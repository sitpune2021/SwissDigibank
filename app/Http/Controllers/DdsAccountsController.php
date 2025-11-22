<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Branch;
use App\Helpers\SmsHelper;
use App\Models\DdsAccount;
use App\Models\Minor;
use App\Models\Bank;
use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\DdTransaction;
use App\Models\Rdscheme;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use App\Helpers\TransactionHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Helpers\AccountsTransactionsHelper;

class DdsAccountsController extends Controller
{

    public function index()
    {
        Log::info('DdsAccountsController@index called');

        $ddaccounts = DdsAccount::with(['member', 'branch', 'scheme', 'transactions'])
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($ddaccounts as $account) {

            $installments = $account->total_installments ?? 0;
            $openDate     = $account->open_date ? Carbon::parse($account->open_date) : null;
            $today        = Carbon::today();

            $diff = 0;
            if ($openDate) {
                $frequency = strtolower($account->rd_dd_frequency);

                switch ($frequency) {
                    case 'daily':
                        $diff = $openDate->diffInDays($today);
                        break;
                    case 'monthly':
                        $diff = $openDate->diffInMonths($today);
                        break;
                    case 'yearly':
                        $diff = $openDate->diffInYears($today);
                        break;
                }
            }

            $shouldHavePaid = min($diff, $installments);

            $totalPrincipalPaid   = $account->transactions->sum('amount');
            $installmentCleared   = floor($totalPrincipalPaid / $account->dd_amount);

            $paid = $installmentCleared;

            $due = max($shouldHavePaid - $paid, 0);

            $overdue = 0;
            if (!empty($account->maturity_date)) {
                $maturityDate = Carbon::parse($account->maturity_date);
                if ($today->gt($maturityDate)) {
                    $overdue = $installments - $paid;
                }
            }

            $notDue = $installments - $paid - $due;

            $account->paid_installments     = $paid;
            $account->due_installments      = $due;
            $account->overdue_installments  = $overdue;
            $account->canceled_installments = 0;
            $account->not_due_installments  = max($notDue, 0);
        }

        return view('fd_account.ddsaccounts.index', compact('ddaccounts'));
    }


    public function create()
    {
        Log::info('DdsAccountsController@create called');
        $members  = Member::all();
        $branches = Branch::all();
        $schemes = Rdscheme::all();
        $minors   = Minor::all();
        $banks = Bank::all();
        Log::info('All Schemes:', $schemes->pluck('rd_dd_frequency', 'scheme_name')->toArray());

        $savingAccounts = Account::where('account_type', 'saving')->get();
        $members = Member::orderBy('member_info_first_name')->get();
        $membersData = $members->keyBy('id');

        return view('fd_account.ddsaccounts.create', compact('members', 'branches', 'schemes', 'minors', 'savingAccounts', 'membersData', 'banks'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Log::info('🔹 DdsAccountsController@store called');
        Log::info('Request data:', $request->all());
        if ($request->branch_id === 'null' || $request->branch_id === '') {
            $request->merge(['branch_id' => null]);
        }

        $validated = $request->validate([
            'member_id' => 'required|integer',
            'branch_id' => 'nullable|integer',
            'scheme_id' => 'required|integer|exists:rdschemes,id',
            'open_date' => 'required|date',
            'amount' => 'required|numeric',
            'nominee' => 'required|in:yes,no',
            'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
            'dd_amount' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        try {
            Log::info('✅ Validation successful', $validated);

            $scheme = Rdscheme::findOrFail($validated['scheme_id']);
            Log::info('✅ Scheme fetched', ['scheme_id' => $scheme->id, 'scheme_name' => $scheme->name ?? 'N/A']);

            $depositPerDay = $scheme->min_rd_dd_amount;
            $days = $scheme->tenure_of_rd_dd_type === 'months' ? $scheme->tenure_of_rd_dd_value * 30 : $scheme->tenure_of_rd_dd_value * 365;
            Log::info('📅 Tenure calculated', ['days' => $days]);

            $rate = $scheme->anuual_interest_rate;

            switch ($scheme->rd_dd_frequency) {
                case 'daily':
                    $installments = 365;
                    break;
                case 'weekly':
                    $installments = floor(365 / 7);
                    break;
                case 'bi-weekly':
                    $installments = floor(365 / 14);
                    break;
                case 'monthly':
                    $installments = $scheme->tenure_of_rd_dd_value;
                    break;
                case 'yearly':
                    $installments = $scheme->tenure_of_rd_dd_value;
                    break;
                default:
                    $installments = 365;
            }

            $bonusRate = $scheme->bonus_rate_type === 'percentage' ? $scheme->bonus_rate_value : 0;
            $fixedBonus = $scheme->bonus_rate_type === 'fixed' ? $scheme->bonus_rate_value : 0;

            $calculation = $this->calculateMaturity(
                $request->dd_amount,
                $installments,
                'daily',
                $rate,
                $bonusRate,
                $fixedBonus,
                $request->open_date
            );

            $total_deposit = $calculation['total_deposit'];
            $interest_earned = $calculation['interest_earned'];
            $bonus = $calculation['bonus'];
            $maturity = $calculation['maturity'];
            $maturity_date = $calculation['maturity_date'];

            Log::info('📈 Maturity calculated', $calculation);

            // Generate dd_no based on the last inserted value
            $lastAccount = DdsAccount::orderBy('id', 'desc')->first();
            $lastDdNo = $lastAccount ? (int) substr($lastAccount->dd_no, 2) : 0;
            $newDdNo = 'DD' . str_pad($lastDdNo + 1, 3, '0', STR_PAD_LEFT);

            $ddsAccount = new DdsAccount();
            $ddsAccount->dd_no = $newDdNo;  // Store the generated dd_no
            $ddsAccount->member_id = $request->member_id;
            $ddsAccount->branch_id = $request->branch_id;
            $ddsAccount->scheme_id = $request->scheme_id;
            $ddsAccount->dd_amount = $request->dd_amount;
            $ddsAccount->open_date = $request->open_date;
            $ddsAccount->nominee = ($request->nominee === 'yes') ? 1 : 0;
            $ddsAccount->account_type = 'single';
            $ddsAccount->remarks = $request->remarks;
            $ddsAccount->tds_deduction = 0;
            $ddsAccount->rd_dd_frequency = $scheme->rd_dd_frequency;
            $ddsAccount->total_installments = $installments;
            $ddsAccount->maturity_amount = $calculation['maturity'];
            $ddsAccount->member_name = $request->member_name;
            $ddsAccount->member_mobile = $request->member_mobile;
            $ddsAccount->member_address = $request->member_address;
            $ddsAccount->total_deposit = $calculation['total_deposit'];
            $ddsAccount->interest_earned = $calculation['interest_earned'];
            $ddsAccount->bonus = $calculation['bonus'];
            $ddsAccount->maturity = $calculation['maturity'];
            $ddsAccount->paid_installments = 1;
            $ddsAccount->due_installments = 0;
            $ddsAccount->overdue_installments = 0;
            $ddsAccount->canceled_installments = 0;
            $ddsAccount->not_due_installments = $ddsAccount->total_installments - 1;
            $ddsAccount->maturity_date = \Carbon\Carbon::createFromFormat('d-m-Y', $calculation['maturity_date'])->format('Y-m-d');
            $ddsAccount->save();

            Log::info('✅ DDS Account created', ['dds_account_id' => $ddsAccount->id]);

            try {
                $ddsaccount = DdsAccount::with('member')->find($ddsAccount->id);
                $mobile = $ddsaccount->member->member_info_mobile_no;
                if (!empty($mobile)) {
                    $dlttemplateid = 1707172234295563351;  // Replace with actual template ID
                    $message = "Dear Customer, we have received your request for opening DD. Your temp. DD no. is $ddsAccount->dd_no. SBC GLOBAL
    ";
                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                    Log::info('✅ SMS sent', ['mobile' => $mobile, 'message' => $message]);
                }
            } catch (\Exception $e) {
                Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
            }
            $transaction = new DdTransaction();
            $transaction->dds_account_id = $ddsAccount->id;
            $transaction->transaction_date = now()->format('Y-m-d');
            $transaction->balance_available = $request->amount;
            $transaction->account_id = null;
            $transaction->pay_mode = $request->pay_mode;
            $transaction->save();

            Log::info('✅ Transaction saved', ['transaction_id' => $transaction->id]);

            Log::debug('📦 Full transaction request payload', $request->all());

            if ($request->nominee === "yes" && $request->has('nominee_name')) {
                $totalNominees = count(array_filter($request->nominee_name));
                $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (!empty($name)) {
                        AccountNominee::create([
                            'account_id' => $ddsAccount->id,
                            'nominee_name' => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address' => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }

                Log::info('👥 Nominees added', ['total_nominees' => $totalNominees]);
            }

            return redirect()->route('dds-accounts.index')
                ->with('success', 'Please approve status!.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('❌ DDS Store Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors([
                'error' => 'Something went wrong. Please try again.',
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        Log::info("DdsAccountsController@show called for ID: $id");

        $ddaccount = DdsAccount::with(['member', 'branch', 'scheme', 'transactions', 'account'])->findOrFail($id);

        // -----------------------------
        // GET ALL SAVING ACCOUNTS OF MEMBER
        // -----------------------------
        $savingAccounts = Account::where('member_id', $ddaccount->member_id)
            ->where('account_type', 'Saving')
            ->where('account_status', 1)
            ->get();

        // -----------------------------
        // GET LATEST TRANSACTION FOR LINK STATUS
        // -----------------------------
        $latestTransaction = DdTransaction::where('dds_account_id', $id)
            ->latest('id')
            ->first();

        $isLinked = $latestTransaction ? $latestTransaction->is_linked : 0;
        $linkedSavingAcc = $latestTransaction && $latestTransaction->saving_account_id
            ? Account::find($latestTransaction->saving_account_id)
            : null;

        // -----------------------------
        // FETCH ALL DD TRANSACTIONS
        // -----------------------------
        $transactions = DdTransaction::where('dds_account_id', $id)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $installmentAmount = $ddaccount->dd_amount ?? 0;

        $totalInstallments = $ddaccount->total_installments
            ?? (strtolower($ddaccount->rd_dd_frequency) === 'daily' ? 365 : ($ddaccount->scheme->tenure_of_rd_dd_value ?? 12));

        $installmentReceived = $transactions->sum('amount') ?? 0;
        $penaltyReceived     = $transactions->sum('penalty_amount') ?? 0;
        $interestCredited    = $transactions->sum('interest_amount') ?? 0;
        $tdsDeduction        = $ddaccount->tds_deduction ?? 0;

        $balanceAvailable = $installmentReceived + $interestCredited + $penaltyReceived - $tdsDeduction;

        // -----------------------------
        // EXISTING CALCULATIONS (NO CHANGE)
        // -----------------------------
        $shouldHavePaid = 0;
        if ($ddaccount->open_date) {
            $openDate = Carbon::parse($ddaccount->open_date);
            $today = Carbon::today();

            switch (strtolower($ddaccount->rd_dd_frequency)) {
                case 'daily':
                    $shouldHavePaid = $openDate->diffInDays($today);
                    break;
                case 'weekly':
                    $shouldHavePaid = floor($openDate->diffInDays($today) / 7);
                    break;
                case 'bi-weekly':
                    $shouldHavePaid = floor($openDate->diffInDays($today) / 14);
                    break;
                case 'monthly':
                    $shouldHavePaid = $openDate->diffInMonths($today);
                    break;
                case 'yearly':
                    $shouldHavePaid = $openDate->diffInYears($today);
                    break;
            }

            $shouldHavePaid = min($shouldHavePaid, $totalInstallments);
        }

        $paid = $transactions->count();
        $due  = max($shouldHavePaid - $paid, 0);

        $overdue = 0;
        if (!empty($ddaccount->maturity_date)) {
            $maturityDateCheck = Carbon::parse($ddaccount->maturity_date);
            if ($today->gt($maturityDateCheck)) {
                $overdue = $totalInstallments - $paid;
            }
        }

        $notDue = $totalInstallments - $paid - $due;
        $expectedPrincipal = $installmentAmount * $shouldHavePaid;

        $principalDue = max($expectedPrincipal - $installmentReceived, 0);

        $penaltyDue = ($principalDue > 0 && !empty($ddaccount->scheme->penalty_charges_value))
            ? $due * $ddaccount->scheme->penalty_charges_value
            : 0;

        $totalAmountDue = $principalDue + $penaltyDue;

        $closeDate = '';
        if ($paid >= $totalInstallments && $ddaccount->open_date) {
            $openingDate = Carbon::parse($ddaccount->open_date);
            $closeDate = match (strtolower($ddaccount->rd_dd_frequency)) {
                'daily'   => $openingDate->copy()->addDays($totalInstallments)->format('d-m-Y'),
                'monthly' => $openingDate->copy()->addMonths($totalInstallments)->format('d-m-Y'),
                'yearly'  => $openingDate->copy()->addYears($totalInstallments)->format('d-m-Y'),
                default   => $openingDate->copy()->addDays($totalInstallments)->format('d-m-Y'),
            };
        }

        $annualInterestRate = $ddaccount->scheme->anuual_interest_rate ?? 0;

        $calculation = $this->calculateMaturity(
            $installmentAmount,
            $totalInstallments,
            strtolower($ddaccount->rd_dd_frequency),
            $annualInterestRate,
            $ddaccount->scheme->maturity_bonus_percent ?? 0,
            0,
            $ddaccount->open_date,
            $ddaccount->scheme->tenure_of_rd_dd_value
        );

        $maturityAmount = $calculation['maturity'];
        $maturityBonus  = $calculation['bonus'];
        $maturityDate   = $calculation['maturity_date'];

        $specialAccount = $ddaccount->account_type === 'special';
        $balances = AccountsTransactionsHelper::getAccountBalacec($ddaccount->account_id);
        $availableBalance = $balances['total_balance'] ?? 0;

        // -----------------------------
        // RETURN VIEW WITH isLinked & linkedSavingAcc
        // -----------------------------
        return view('fd_account.ddsaccounts.show', [
            'ddaccount'            => $ddaccount,
            'branches'             => Branch::all(),
            'members'              => Member::all(),
            'schemes'              => Rdscheme::all(),
            'installmentAmount'    => $installmentAmount,
            'installmentReceived'  => $installmentReceived,
            'penaltyReceived'      => $penaltyReceived,
            'interestCredited'     => $interestCredited,
            'tdsDeduction'         => $tdsDeduction,
            'availableBalance'     => $availableBalance,
            'balanceAvailable'     => $balanceAvailable,
            'principalDue'         => $principalDue,
            'penaltyDue'           => $penaltyDue,
            'totalAmountDue'       => $totalAmountDue,
            'closeDate'            => $closeDate,
            'maturityAmount'       => $maturityAmount,
            'maturityBonus'        => $maturityBonus,
            'maturityDate'         => $maturityDate,
            'annualInterestRate'   => $annualInterestRate,
            'paid_installments'    => $paid,
            'due_installments'     => $due,
            'overdue_installments' => $overdue,
            'not_due_installments' => max($notDue, 0),
            'specialAccount'       => $specialAccount,
            'savingAccounts'       => $savingAccounts,
            'linkedSavingAcc'      => $linkedSavingAcc,
            'isLinked'             => $isLinked, // NEW
        ]);
    }


    public function edit(DdsAccount $ddaccount)
    {
        Log::info("DdsAccountsController@edit called for ID: {$ddaccount->id}");
        $members = Member::select('id', 'member_info_first_name', 'member_info_last_name', 'mobile_no')
            ->orderBy('member_info_first_name')
            ->get();
        $branches = Branch::all();
        $members  = Member::all();

        return view('dds-accounts.edit', compact('ddaccount', 'members', 'branches'));
    }

    public function update(Request $request, string $id)
    {
        Log::info("DdsAccountsController@update called for ID: $id");
        try {
            $account = DdsAccount::findOrFail($id);
            $validated = $request->validate([
                'member_id'             => 'required|exists:members,id',
                'member_name'           => 'required|string|max:255',
                'member_address'        => 'nullable|string|max:500',
                'member_mobile'         => 'nullable|string|max:15',
                'minor_id'              => 'nullable|exists:minors,id',
                'branch_id'             => 'required|exists:branches,id',
                'advisor_id'            => 'nullable|exists:staff,id',
                'collection_advisor_id' => 'nullable|exists:staff,id',
                'scheme_id'             => 'required|exists:schemes,id',
                'dd_amount'             => 'required|numeric',
                'open_date'             => 'required|date|before_or_equal:today',
                'tds_deduction'         => 'nullable|boolean',
                'account_type'          => ['required', Rule::in(['single', 'joint'])],
                'nominee'               => 'nullable|boolean',
                'pay_mode'              => 'required|string|in:cash,onlineTr,cheque,saving',
                'transaction_date'      => 'required|date',
                'amount'                => 'required|numeric|min:1',
                'transfer_date'         => 'nullable|date',
                'transfer_mode'         => 'nullable|string|max:50',
                'utr_no'                => 'nullable|string|max:100',
                'credited_in_company'   => 'nullable|boolean',
                'bank_id'               => 'nullable|exists:banks,id',
                'cheque_no'             => 'nullable|string|max:50',
                'cheque_date'           => 'nullable|date',
                'saving_account_id'     => [
                    'nullable',
                    Rule::requiredIf($request->pay_mode === 'saving'),
                    'exists:accounts,id'
                ],
            ]);

            $validated['tds_deduction']       = $request->has('tds_deduction');
            $validated['nominee']             = $request->has('nominee');
            $validated['credited_in_company'] = $request->has('credited_in_company');

            $account->update($validated);

            $transaction = $account->transactions()->first();
            if ($transaction) {
                $transaction->update([
                    'transaction_date' => $request->transaction_date,
                    'amount'           => $request->amount,
                    'pay_mode'         => $request->pay_mode,
                ]);
            }

            return redirect()->route('ddsaccounts.index')
                ->with('success', 'DDS Account updated successfully.');
        } catch (\Exception $e) {
            Log::error('DDS Account update failed: ' . $e->getMessage());
            return back()->withErrors('Something went wrong while updating the DDS account.')
                ->withInput();
        }
    }

    public function getMemberDetails($id)
    {
        Log::info("DdsAccountsController@getMemberDetails called for member ID: $id");
        $member = Member::with('branch', 'minors', 'address')->findOrFail($id);

        return response()->json([
            'member_info_first_name' => $member->member_info_first_name,
            'member_info_last_name'  => $member->member_info_last_name,
            'member_address_line_1'  => $member->address->member_address_line_1 ?? '',
            'member_info_mobile_no'  => $member->member_info_mobile_no,
            'branch_id'   => $member->branch_id,
            'branch_name' => $member->branch->branch_name ?? '',
            'open_date'              => now()->format('Y-m-d'),
            'minors' => $member->minors->map(function ($minor) {
                return [
                    'id' => $minor->id,
                    'first_name' => $minor->first_name,
                    'last_name' => $minor->last_name,
                ];
            }),
        ]);
    }

    public function updateMember(Request $request, DdsAccount $ddaccount)
    {
        Log::info("DdsAccountsController@updateMember called for DDS ID: {$ddaccount->id}");
        $request->validate(['member_id' => 'required|exists:members,id']);
        $ddaccount->member_id = $request->member_id;
        $ddaccount->save();

        return back()->with('success', 'Member updated successfully');
    }

    public function updateBranch(Request $request, DdsAccount $ddaccount)
    {
        Log::info("DdsAccountsController@updateBranch called for DDS ID: {$ddaccount->id}");
        $request->validate(['branch_id' => 'required|exists:branches,id']);
        $ddaccount->branch_id = $request->branch_id;
        $ddaccount->save();

        return back()->with('success', 'Branch updated successfully');
    }
    function calculateMaturity(
        $depositAmount,
        $installments,
        $frequency,
        $annualRate,
        $bonusRate = 0,
        $fixedBonus = 0,
        $startDate = null,
        $schemeTenureMonths = null
    ) {
        $frequency = str_replace('_', '-', strtolower($frequency)); // normalize

        if (!in_array($frequency, ['daily', 'weekly', 'bi-weekly'])) {
            throw new InvalidArgumentException("Only 'daily', 'weekly', and 'bi-weekly' frequencies are supported.");
        }

        $daysPerInstallment = match ($frequency) {
            'daily' => 1,
            'weekly' => 7,
            'bi-weekly' => 14,
        };

        $totalDeposit = $depositAmount * $installments;

        $days = $installments;
        $interest = ($depositAmount * $days * ($days + 1) * $annualRate) / (2 * 100 * 365);
        $interest = round($interest, 2);

        $bonus = 0;
        if ($bonusRate > 0) {
            $bonus = ($totalDeposit * $bonusRate) / 100;
        } elseif ($fixedBonus > 0) {
            $bonus = $fixedBonus;
        }
        $bonus = round($bonus, 2);

        $maturity = $totalDeposit + $interest + $bonus;

        $maturityDate = null;
        if ($startDate) {
            $date = Carbon::parse($startDate);
            $date->addDays($installments * $daysPerInstallment);
            $maturityDate = $date->format('d-m-Y');
        }

        return [
            'total_deposit'   => round($totalDeposit, 2),
            'interest_earned' => $interest,
            'bonus'           => $bonus,
            'maturity'        => round($maturity, 2),
            'maturity_date'   => $maturityDate,
        ];
    }

    public function installments($id)
    {
        $ddaccount = DdsAccount::with('transactions')->findOrFail($id);

        $emiAmount = $ddaccount->dd_amount;
        $openDate = Carbon::parse($ddaccount->open_date);
        $totalInstallments = $ddaccount->total_installments;
        $frequency = strtolower($ddaccount->rd_dd_frequency);

        // TOTAL AMOUNT PAID
        $totalPaid = $ddaccount->transactions->sum('amount');

        // FULL INSTALLMENTS PAID
        $fullyPaidCount = floor($totalPaid / $emiAmount);

        // Remaining balance (not used for any installment)
        $remaining = $totalPaid - ($fullyPaidCount * $emiAmount);

        $installments = [];

        for ($i = 0; $i < $totalInstallments; $i++) {

            // Calculate installment due date
            $dueDate = match ($frequency) {
                'daily'   => $openDate->copy()->addDays($i),
                'monthly' => $openDate->copy()->addMonths($i),
                'yearly'  => $openDate->copy()->addYears($i),
                default   => $openDate->copy()->addDays($i),
            };

            // Status Logic
            if ($i < $fullyPaidCount) {
                $state = 'PAID';
                $paidOn = $ddaccount->transactions->last()->transaction_date;
            } elseif ($i == $fullyPaidCount && $remaining > 0) {
                $state = 'PARTIAL';  // Optional display
                $paidOn = '';
            } else {
                $state = 'PENDING';
                $paidOn = '';
            }

            $installments[] = [
                'number'     => $i + 1,
                'amount'     => number_format($emiAmount, 2),
                'due_date'   => $dueDate->format('d-m-Y'),
                'state'      => $state,
                'paid_on'    => $paidOn ? Carbon::parse($paidOn)->format('d-m-Y') : '',
                'created_at' => $ddaccount->created_at->format('d-m-Y h:i A'),
                'updated_at' => $ddaccount->updated_at->format('d-m-Y h:i A'),
            ];
        }

        $collection = collect($installments);
        $perPage = 50;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedInstallments = new LengthAwarePaginator(
            $pagedItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('fd_account.ddsaccounts.installments', [
            'ddaccount' => $ddaccount,
            'installments' => $paginatedInstallments,
        ]);
    }

    public function installmentReceipt($id)
    {
        $ddaccount = DdsAccount::with('member', 'branch', 'transactions')->findOrFail($id);

        function numberToWords($number)
        {
            $hyphen      = '-';
            $dictionary  = [
                0 => 'zero',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 => 'nineteen',
                20 => 'twenty',
                30 => 'thirty',
                40 => 'forty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety',
                100 => 'hundred',
                1000 => 'thousand'
            ];

            if ($number < 21) return $dictionary[$number];
            elseif ($number < 100) {
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                return $dictionary[$tens] . ($units ? $hyphen . $dictionary[$units] : '');
            } elseif ($number < 1000) {
                $hundreds = (int)($number / 100);
                $remainder = $number % 100;
                return $dictionary[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
            }
            return $number;
        }

        $wordAmt = ucfirst(numberToWords((int)$ddaccount->dd_amount)) . ' Only';

        $txn = $ddaccount->transactions->sortByDesc('id')->first();
        $pay_mode = $txn->pay_mode ?? 'Cash';

        $dueDate = Carbon::parse($ddaccount->open_date)->format('d-m-Y');

        if ($txn) {
            $nextinsdue = Carbon::parse($txn->transaction_date)->addDay()->format('d-m-Y');
        } else {
            $nextinsdue = Carbon::parse($ddaccount->open_date)->addDay()->format('d-m-Y');
        }

        $depositAmountPerModeValue = $txn->amount
            ?? $txn->deposit_amount
            ?? $txn->installment_amount
            ?? $ddaccount->dd_amount
            ?? 0;

        $DepositAmountperMode = number_format($depositAmountPerModeValue, 2);

        $installmentNo = $ddaccount->transactions->count() + 1;
        $otherCharges = 0;
        $previousBalance = $txn->balance_available
            ?? $ddaccount->balance
            ?? 0;

        $previousBalanceFormatted = number_format($previousBalance, 2);
        $previousBalance = $txn->balance_available ?? $ddaccount->balance ?? 0;

        $currentInstallment = $depositAmountPerModeValue;

        $total = $previousBalance + $currentInstallment;

        $totalFormatted = number_format($total, 2);
        $data = [
            'name'               => trim(
                ($ddaccount->member->member_info_title ?? '') . ' ' .
                    ($ddaccount->member->member_info_first_name ?? '') . ' ' .
                    ($ddaccount->member->member_info_middle_name ?? '') . ' ' .
                    ($ddaccount->member->member_info_last_name ?? '')
            ),
            'state'              => $ddaccount->member->member_address_state ?? '',
            'branch'             => $ddaccount->branch->name ?? 'Main Branch',
            'receipt_no'         => 'DDS' . str_pad($ddaccount->id, 6, '0', STR_PAD_LEFT),
            'receiptno'          => 'DDS' . str_pad($ddaccount->id, 6, '0', STR_PAD_LEFT),
            'dated'              => Carbon::now()->format('d-m-Y'),
            'member_no'          => $ddaccount->member_id,
            'dd_no'              => $ddaccount->dd_no,
            'installment_amount' => number_format($ddaccount->dd_amount, 2),
            'total_installments' => $ddaccount->total_installments,
            'installmentNo'      => $installmentNo,      // 👈 ADDED HERE
            'open_date'          => Carbon::parse($ddaccount->open_date)->format('d-m-Y'),
            'maturity_date'      => Carbon::parse($ddaccount->maturity_date)->format('d-m-Y'),
            'maturity_amount'    => number_format($ddaccount->maturity_amount, 2),
            'status'             => $ddaccount->status ? 'Active' : 'Pending',
            'wordAmt'            => $wordAmt,
            'pay_mode'           => $pay_mode,
            'DepositAmountperMode' => $DepositAmountperMode,
            'dueDate'            => $dueDate,
            'depositAmount'         => $DepositAmountperMode,   // ✅ final variable for BOTH tables
            'otherCharges'          => $otherCharges,   // ✅ added
            'previousBalance' => $previousBalanceFormatted,
            'total' => $totalFormatted,
            'nextinsdue'         => $nextinsdue,
        ];

        $pdf = Pdf::loadView('fd_account.ddsaccounts.installmentReceipt', $data);
        return $pdf->stream('installment-receipt.pdf');
    }
    public function transactions(Request $request, $id)
    {
        Log::info("DdsAccountsController@transactions called for DDS ID: $id");

        $ddsAccount = DdsAccount::with('member', 'branch', 'scheme')->findOrFail($id);

        $query = DdTransaction::where('dds_account_id', $id);

        if ($request->filled('tranx_id')) {
            $query->where('id', $request->tranx_id);
        }

        if ($request->filled('remarks')) {
            $query->where('remarks', 'like', '%' . $request->remarks . '%');
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $query->whereBetween('transaction_date', [$fromDate, $toDate]);
        }

        if ($request->filled('from_amount') && $request->filled('to_amount')) {
            $query->whereBetween('balance_available', [$request->from_amount, $request->to_amount]);
        }

        $transactions = $query
            ->orderBy('transaction_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $transactions = TransactionHelper::calculateRunningBalance($transactions);

        $transactions = $transactions->sortByDesc('transaction_date')->sortByDesc('id')->values();

        return view('fd_account.ddsaccounts.transactions', compact('ddsAccount', 'transactions'));
    }

    public function destroyTransaction($ddsAccountId, $tranxId)
    {
        Log::info("Deleting Transaction ID: $tranxId for DDS Account: $ddsAccountId");

        $tranx = DdTransaction::findOrFail($tranxId);
        $tranx->delete();

        return back()->with('success', 'Transaction deleted.');
    }

    public function transactionShow($accountId, $transactionId)
    {
        Log::info("DdsAccountsController@transactionShow called for DDS ID: $accountId, Transaction ID: $transactionId");

        $ddsAccount = DdsAccount::with(['member', 'branch', 'scheme'])
            ->findOrFail($accountId);
        // dd($ddsAccount);
        $transaction = $ddsAccount->transactions()
            ->with('ddsAccount.branch')
            ->findOrFail($transactionId);

        // Debug
        // dd($transaction);

        return view('fd_account.ddsaccounts.transaction-show', compact('ddsAccount', 'transaction'));
    }

    private function uploadFile(Request $request, string $field, string $folder): ?string
    {
        return $request->hasFile($field)
            ? $request->file($field)->store($folder, 'public')
            : null;
    }

    public function createDeposit($id)
    {
        $ddAccount = DdsAccount::findOrFail($id);
        $banks = Bank::all();
        $members  = Member::all();

        $savingAccounts = Account::with('members')
            ->where('member_id', $ddAccount->member_id)
            ->where('account_type', 'saving')
            ->get();

        // Get all transactions for this DD account
        $transactions = DdTransaction::where('dds_account_id', $id)->get();

        // Calculate totals
        $totalDeposited = $transactions->where('type', 'credit')->sum('amount');
        $totalWithdrawn = $transactions->where('type', 'debit')->sum('amount');
        $balanceAvailable = $totalDeposited - $totalWithdrawn;

        // Pass to view
        return view('fd_account.ddsaccounts.createDeposit', compact(
            'ddAccount',
            'banks',
            'savingAccounts',
            'members',
            'totalDeposited',
            'totalWithdrawn',
            'balanceAvailable'
        ));
    }

    public function deposit(Request $request, $id)
    {
        Log::info('Deposit function called', ['account_id' => $id, 'request_data' => $request->all()]);

        // Step 1: Validate the request
        try {
            // Default validation rules
            $rules = [
                'amount' => 'required|numeric|min:1',
                'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
                'transaction_date' => 'required|date_format:d-m-Y',
            ];

            // Modify validation rules based on pay_mode
            switch ($request->pay_mode) {
                case 'onlineTr':
                    $rules['transfer_date'] = 'required|date_format:d-m-Y';
                    $rules['utr_no'] = 'required|string|max:255';
                    $rules['transfer_mode'] = 'required|in:IMPS,VPA,NEFT/RTGS';
                    break;

                case 'cheque':
                    $rules['bank_name'] = 'required|string|max:255';
                    $rules['cheque_no'] = 'required|string|max:255';
                    $rules['cheque_date'] = 'required|date_format:d-m-Y';
                    break;

                case 'saving':
                    $rules['saving_account_id'] = 'required|exists:accounts,id';
                    break;

                    // No extra validation for 'cash', since it's simple
            }

            // Validate the request data with dynamically adjusted rules
            $request->validate($rules);

            Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors());
        }

        $amount = $request->amount;

        // Step 2: Find DDS account
        $account = DdsAccount::find($id);
        if (!$account) {
            Log::error('DDS Account not found', ['account_id' => $id]);
            return redirect()->back()->with('error', 'Account not found!');
        }
        Log::info('DDS Account found', ['account_id' => $id, 'balance' => $account->balance]);

        // Step 3: Convert dates (transaction date, transfer date, cheque date)
        try {
            $transactionDate = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
            $transferDate = $request->transfer_date ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d') : null;
            $chequeDate = $request->cheque_date ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d') : null;
        } catch (\Exception $e) {
            Log::error('Date conversion failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Invalid date format');
        }

        // Step 4: Deduct from saving account if pay_mode is saving
        $savingAccountId = null;
        if ($request->pay_mode === 'saving') {
            $savingAccount = Account::find($request->saving_account_id);
            if (!$savingAccount) {
                Log::error('Saving account not found', ['saving_account_id' => $request->saving_account_id]);
                return redirect()->back()->with('error', 'Saving account not found!');
            }

            if ($savingAccount->amount_deposit < $amount) {
                Log::warning('Insufficient balance in saving account', ['saving_account_id' => $savingAccount->id]);
                return redirect()->back()->with('error', 'Insufficient balance in saving account!');
            }

            // Deduct amount from saving account
            $savingAccount->amount_deposit -= $amount;
            $savingAccount->save();
            $savingAccountId = $savingAccount->id;

            Log::info('Amount deducted from saving account', ['saving_account_id' => $savingAccount->id, 'new_balance' => $savingAccount->amount_deposit]);
        }

        // Step 5: Set remarks and status
        $remarks = $request->remarks;
        if ($request->pay_mode === 'saving' && isset($savingAccount)) {
            $remarks = $remarks ?: 'Credit from Saving a/c - ' . $savingAccount->account_no;
        }
        if ($request->pay_mode === 'cash') {
            $remarks = null;
        }
        $status = ($request->pay_mode === 'saving') ? 'Approved' : 'Pending';

        // Log the transaction status
        Log::info('Transaction status determined', [
            'status' => $status,
            'pay_mode' => $request->pay_mode,
            'remarks' => $remarks
        ]);

        // Step 6: Create the transaction
        try {
            $transaction = DdTransaction::create([
                'type' => 'credit',
                'dds_account_id' => $id,
                'pay_mode' => $request->pay_mode,
                'remarks' => $remarks,
                'transaction_date' => $transactionDate,
                'amount' => $amount,
                'balance_available' => $account->balance + $amount, // Calculate the new balance
                'collected_by' => $request->collected_by ?? null,
                't_receipt' => $request->t_receipt ?? null,
                'transfer_date' => $transferDate,
                'transfer_mode' => $request->transfer_mode ?? null,
                'utr_no' => $request->utr_no ?? null,
                'bank_name' => $request->bank_name ?? null,
                'cheque_no' => $request->cheque_no ?? null,
                'cheque_date' => $chequeDate,
                'saving_account_id' => $savingAccountId,
            ]);
            Log::info('Transaction created', ['transaction_id' => $transaction->id, 'status' => $status]);
        } catch (\Exception $e) {
            Log::error('Failed to create transaction', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create transaction');
        }

        // Step 7: Recalculate the running balance for all transactions
        try {
            $runningBalance = 0;
            $transactions = DdTransaction::where('dds_account_id', $id)
                ->orderBy('transaction_date')
                ->orderBy('id')
                ->get();

            foreach ($transactions as $txn) {
                $runningBalance += ($txn->type === 'credit') ? $txn->amount : -$txn->amount;
                $txn->balance_available = $runningBalance;
                $txn->save();
            }

            // Update the account balance
            $account->balance = $runningBalance;
            $account->save();
        } catch (\Exception $e) {
            Log::error('Error updating balances', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error updating balance');
        }

        Log::info('Deposit completed successfully', ['account_id' => $id, 'running_balance' => $runningBalance]);

        // Return to the transactions page with a success message
        return redirect()->route('dds-accounts.transactions', $id)
            ->with('success', 'Deposit successful!')
            ->with('transactions', $transactions);  // Pass transactions to the view
    }

    public function createWithdraw($id)
    {
        // Find the account by its ID
        $withraw = DdsAccount::findOrFail($id);
        $banks = Bank::all();
        $members  = Member::all();
        $savingAccounts = Account::with('members')
            ->where('member_id', $withraw->member_id)
            ->where('account_type', 'saving')
            ->get();
        if (!$withraw) {
            return redirect()->back()->with('error', 'Account not found!');
        }
        $balanceAvailable = $withraw->balance ?? 0;
        // Return the withdrawal creation view
        return view('fd_account.ddsaccounts.createwithdraw', compact('withraw', 'banks', 'members', 'savingAccounts', 'balanceAvailable'));
    }

    public function withdraw(Request $request, $id)
    {
        Log::info('Withdrawal function called', ['account_id' => $id, 'request_data' => $request->all()]);

        // Initial validation rules
        $rules = [
            'amount' => 'required|numeric|min:1',
            'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
            'transaction_date' => 'required|date_format:d-m-Y',
        ];

        // Add additional rules based on the payment mode
        switch ($request->pay_mode) {
            case 'onlineTr':
                $rules['transfer_date'] = 'required|date_format:d-m-Y';
                $rules['utr_no'] = 'required|string|max:255';
                $rules['transfer_mode'] = 'required|in:IMPS,VPA,NEFT/RTGS';
                break;

            case 'cheque':
                $rules['bank_name'] = 'required|string|max:255';
                $rules['cheque_no'] = 'required|string|max:255';
                $rules['cheque_date'] = 'required|date_format:d-m-Y';
                break;

            case 'saving':
                $rules['saving_account_id'] = 'required|exists:accounts,id';
                break;

                // No extra validation for 'cash', since it's simple
        }

        // Perform validation
        try {
            $request->validate($rules);
            Log::info('Validation passed for withdrawal');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors());
        }

        $amount = $request->amount;

        // Find the DDS account
        $account = DdsAccount::find($id);
        if (!$account) {
            Log::error('DDS Account not found', ['account_id' => $id]);
            return redirect()->back()->with('error', 'Account not found!');
        }

        // Check if sufficient balance is available
        if ($account->balance < $amount) {
            return redirect()->back()->with('error', 'Insufficient balance!');
        }

        // Convert transaction date
        try {
            $transactionDate = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date format');
        }

        DB::beginTransaction();

        try {
            $savingAccount = null;
            // Only fetch saving account if the payment mode is saving
            if ($request->pay_mode === 'saving') {
                $savingAccount = Account::find($request->saving_account_id);
                if (!$savingAccount) throw new \Exception('Saving account not found!');
                $savingAccount->amount_deposit += $amount;
                $savingAccount->save();
            }

            // Prepare remarks for the transaction
            if ($request->pay_mode === 'saving' && $savingAccount) {
                // Set the remark if the pay_mode is 'saving'
                $remarks = 'Debit to Saving a/c - ' . $savingAccount->account_no . '.';
            } elseif ($request->pay_mode !== 'cash') {
                // For any other mode except 'cash', create a general remark
                $remarks = null;
            } else {
                // If pay_mode is 'cash', don't set any remarks (set it to null)
                $remarks = null;
            }

            $status = ($request->pay_mode === 'saving') ? 'Approved' : 'Pending';

            // Log the remarks before creating the transaction
            Log::info('Creating withdrawal transaction', [
                'remarks' => $remarks,
                'pay_mode' => $request->pay_mode,
                'transaction_date' => $transactionDate
            ]);

            // Create the transaction
            $transaction = DdTransaction::create([
                'type' => 'debit',
                'dds_account_id' => $id,
                'pay_mode' => $request->pay_mode,
                'remarks' => $remarks,
                'transaction_date' => $transactionDate,
                'amount' => $amount,
                'balance_available' => 0, // will update below
                'collected_by' => $request->collected_by ?? null,
                't_receipt' => $request->t_receipt ?? null,
                'saving_account_id' => $savingAccount->id ?? null,
                'status' => $status,
            ]);

            Log::info('Transaction created', ['transaction_id' => $transaction->id]);

            // Recalculate running balance
            $transactions = DdTransaction::where('dds_account_id', $id)
                ->orderBy('transaction_date')
                ->orderBy('id')
                ->get();

            $runningBalance = 0;
            foreach ($transactions as $txn) {
                $runningBalance += ($txn->type === 'credit') ? $txn->amount : -$txn->amount;
                $txn->balance_available = $runningBalance;
                $txn->save();
            }

            $account->balance = $runningBalance;
            $account->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during withdrawal process', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', $e->getMessage());
        }

        Log::info('Withdrawal completed successfully', ['account_id' => $id, 'new_balance' => $account->balance]);

        return redirect()->route('dds-accounts.transactions', $id)->with('success', 'Withdrawal successful!');
    }
    public function printReceipt($id, $transactionId)
    {
        $transaction = DdsAccount::with(['member', 'transactions' => function ($query) use ($transactionId) {
            $query->where('id', $transactionId);
        }])->find($id);

        if (!$transaction || $transaction->transactions->isEmpty()) {
            abort(404, "Transaction not found");
        }
        $printedOn = now()->format('d-m-Y H:i');
        $printedBy = optional(Auth::user())->name ?? 'System';

        return view('fd_account.ddsaccounts.transactionPrintReceipt', compact('transaction', 'printedOn', 'printedBy'));
    }

    public function printReceipt1($id, $transactionId)
    {
        $transaction = DdsAccount::with(['member', 'transactions' => function ($query) use ($transactionId) {
            $query->where('id', $transactionId);
        }])->find($id);

        if (!$transaction || $transaction->transactions->isEmpty()) {
            abort(404, "Transaction not found");
        }

        $printedOn = now()->format('d-m-Y H:i');
        $printedBy = optional(Auth::user())->name ?? 'System';

        return view('fd_account.ddsaccounts.transactionPrintReceipt2', compact('transaction', 'printedOn', 'printedBy'));
    }
    public function createLinkSavingAcc($id)
    {
        $ddaccount = DdsAccount::with('member', 'branch', 'transactions', 'scheme', 'account')
            ->findOrFail($id);

        $savingAccounts = Account::where('member_id', $ddaccount->member_id)
            ->where('account_type', 'Saving')
            ->where('account_status', 1)
            ->get();

        $balances = [];
        foreach ($savingAccounts as $acc) {
            $bal = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec($acc->id);

            $balances[$acc->id] = $bal['total_balance'] ?? 0;
        }

        return view('fd_account.ddsaccounts.link-account', compact('ddaccount', 'savingAccounts', 'balances'));
    }

    public function storeLinkSavingAcc(Request $request, $id)
    {
        $request->validate([
            'saving_account_id' => 'nullable|exists:accounts,id',
        ]);

        $ddaccount = DdsAccount::findOrFail($id);
        $savingAccId = $request->saving_account_id;

        $isLinked = $savingAccId ? 1 : 0;
        $savingAcc = $savingAccId ? Account::find($savingAccId) : null;
        $savingAccNo = $savingAcc->account_no ?? 'N/A';

        // Update DD account
        $ddaccount->update([
            'saving_account_id' => $savingAccId ?? null,
            'is_linked'         => $isLinked,
        ]);

        // Log the action
        if ($isLinked) {
            Log::info("Saving Account No {$savingAccNo} has been linked to DD Account {$ddaccount->id}.");
        } else {
            Log::info("Saving Account has been unlinked from DD Account {$ddaccount->id}.");
        }

        \App\Models\DdTransaction::create([
            'dds_account_id'     => $ddaccount->id,
            'branch_id'          => $ddaccount->branch_id,
            'saving_account_id'  => $savingAccId ?? null,
            'pay_mode'           => 'saving',
            'transaction_date'   => now(),
            'balance_available'  => $ddaccount->balance ?? 0,
            'amount'             => 0,
            'is_linked'          => $isLinked,
            'remarks'            => $isLinked
                ? "Saving Account Linked for Auto Debit"
                : "Saving Account Unlinked (Auto Debit Disabled)",
        ]);

        $message = $isLinked
            ? "Saving Account No {$savingAccNo} has been successfully linked to DD Account."
            : "Saving Account has been successfully unlinked from DD Account.";

        return redirect()->route('ddsaccounts.show', $id)->with('success', $message);
    }

    public function confirmUnlink($id)
    {
        $ddaccount = DdsAccount::with(['member', 'branch', 'scheme', 'transactions', 'account'])->findOrFail($id);

        $linkedSavingAcc = Account::find($ddaccount->saving_account_id);
        $availableBalance = optional($linkedSavingAcc)->balance ?? 0;

        return view('fd_account.ddsaccounts.unlink_confirm', compact('ddaccount', 'linkedSavingAcc', 'availableBalance'));
    }
    public function createCreditInterest($id)
    {
        $ddaccount = DdsAccount::with('member', 'branch', 'transactions', 'scheme', 'account')->findOrFail($id);
        $savingAccounts = Account::where('member_id', $ddaccount->member_id)
            ->where('account_type', 'Saving')
            ->where('account_status', 1)
            ->get();

        return view('fd_account.ddsaccounts.creditReverse', compact('ddaccount', 'savingAccounts'));
    }
    // public function storeCreditInterest(Request $request, $id)
    // {
    //     Log::info("DDS Interest Transaction Validation Started", [
    //         'dds_account_id' => $id,
    //         'request_data' => $request->all(),
    //     ]);

    //     $request->validate([
    //         'transaction_date' => 'required|date',
    //         'transaction_type' => 'required|in:credit,reverse',
    //         'interest_amount'  => 'required|numeric|min:1',
    //         'remarks'          => 'nullable|string|max:255',
    //     ]);

    //     $ddaccount = DdsAccount::findOrFail($id);

    //     DB::beginTransaction();

    //     try {
    //         // Current balance
    //         $oldBalance = $ddaccount->balance ?? 0;

    //         // Determine addition or subtraction
    //         $interestAmount = $request->transaction_type === 'credit'
    //             ? $request->interest_amount
    //             : -$request->interest_amount;

    //         // New balance
    //         $newBalance = $oldBalance + $interestAmount;

    //         Log::info("DDS Interest Calculation", [
    //             'dds_account_id' => $ddaccount->id,
    //             'transaction_type' => $request->transaction_type,
    //             'old_balance' => $oldBalance,
    //             'interest_amount' => $interestAmount,
    //             'new_balance' => $newBalance,
    //         ]);
    //         $transactionDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');

    //         // Save transaction
    //         $transaction = DdTransaction::create([
    //             'dds_account_id'     => $ddaccount->id, // <-- correct column name
    //             'transaction_date'  => $transactionDate,
    //             'transaction_type'  => $request->transaction_type,
    //             'interest_amount'   => $interestAmount,
    //             'balance_available' => $newBalance,
    //             'remarks'           => $request->remarks,
    //             'amount'             => $request->interest_amount, // <-- Add this

    //         ]);

    //         Log::info("DDS Interest Transaction Saved", [
    //             'dds_account_id' => $ddaccount->id,
    //             'transaction_id' => $transaction->id,
    //             'transaction_data' => $transaction->toArray(),
    //         ]);

    //         // Update account balance
    //         $ddaccount->update(['balance' => $newBalance]);

    //         Log::info("DDS Account Balance Updated", [
    //             'dds_account_id' => $ddaccount->id,
    //             'old_balance' => $oldBalance,
    //             'new_balance' => $newBalance,
    //         ]);

    //         DB::commit();

    //         Log::info("DDS Interest Transaction Completed", [
    //             'dds_account_id' => $ddaccount->id,
    //             'transaction_id' => $transaction->id,
    //         ]);

    //         return redirect()->route('ddsaccounts.show', $ddaccount->id)
    //             ->with('success', 'Interest transaction updated successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::error("DDS Interest Transaction FAILED", [
    //             'dds_account_id' => $id,
    //             'error_message' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //         ]);

    //         return back()->with('error', 'Something went wrong. Try again.');
    //     }
    // }
    // public function storeCreditInterest(Request $request, $id)
    // {
    //     Log::info("DDS Interest Transaction Validation Started", [
    //         'dds_account_id' => $id,
    //         'request_data' => $request->all(),
    //     ]);

    //     $request->validate([
    //         'transaction_date' => 'required|date',
    //         'transaction_type' => 'required|in:credit,reverse',
    //         'interest_amount'  => 'required|numeric|min:1',
    //         'remarks'          => 'nullable|string|max:255',
    //     ]);

    //     $ddaccount = DdsAccount::findOrFail($id);

    //     DB::beginTransaction();

    //     try {
    //         $oldBalance = $ddaccount->balance ?? 0;
    //         $interestAmount = $request->interest_amount;

    //         // Credit or reverse logic
    //         if ($request->transaction_type === 'credit') {
    //             $balanceAvailable = $oldBalance - $interestAmount; // deduct from balance
    //             $amountReceived = $oldBalance + $interestAmount;   // total received
    //             $interestAmountToStore = -$interestAmount;         // store negative
    //         } else { // reverse
    //             $balanceAvailable = $oldBalance + $interestAmount; // add to balance
    //             $amountReceived = $oldBalance + $interestAmount;   // total received
    //             $interestAmountToStore = $interestAmount;          // store positive
    //         }

    //         $transactionDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->transaction_date)
    //             ->format('Y-m-d');

    //         $transaction = DdTransaction::create([
    //             'dds_account_id'     => $ddaccount->id,
    //             'transaction_date'   => $transactionDate,
    //             'transaction_type'   => $request->transaction_type,
    //             'amount'             => $amountReceived,        // Amount Received
    //             'interest_amount'    => $interestAmountToStore, // stored interest
    //             'balance_available'  => $balanceAvailable,     // balance after deduction/add
    //             'remarks'            => $request->remarks,
    //         ]);

    //         // Update account balance
    //         $ddaccount->update(['balance' => $balanceAvailable]);

    //         DB::commit();

    //         return redirect()->route('ddsaccounts.show', $ddaccount->id)
    //             ->with('success', 'Interest transaction updated successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error("DDS Interest Transaction FAILED", [
    //             'dds_account_id' => $id,
    //             'error_message' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //         ]);

    //         return back()->with('error', 'Something went wrong. Try again.');
    //     }
    // }
    public function storeCreditInterest(Request $request, $id)
    {
        Log::info("DDS Interest Transaction Validation Started", [
            'dds_account_id' => $id,
            'request_data' => $request->all(),
        ]);

        $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:credit,reverse',
            'interest_amount'  => 'required|numeric|min:1',
            'remarks'          => 'nullable|string|max:255',
        ]);

        $ddaccount = DdsAccount::findOrFail($id);

        DB::beginTransaction();

        try {
            $oldBalance = $ddaccount->balance ?? 0;
            $interestAmount = $request->interest_amount;

            // Opposite logic
            if ($request->transaction_type === 'credit') {
                $balanceAvailable = $oldBalance + $interestAmount; // add to balance
                $amountReceived = $oldBalance + $interestAmount;   // total received
                $interestAmountToStore = $interestAmount;          // store positive
            } else { // reverse
                $balanceAvailable = $oldBalance - $interestAmount; // deduct from balance
                $amountReceived = $oldBalance + $interestAmount;   // total received
                $interestAmountToStore = -$interestAmount;         // store negative
            }

            $transactionDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->transaction_date)
                ->format('Y-m-d');

            $transaction = DdTransaction::create([
                'dds_account_id'     => $ddaccount->id,
                'transaction_date'   => $transactionDate,
                'transaction_type'   => $request->transaction_type,
                'amount'             => $amountReceived,        // Amount Received
                'interest_amount'    => $interestAmountToStore, // stored interest
                'balance_available'  => $balanceAvailable,     // updated balance
                'remarks'            => $request->remarks,
            ]);

            // Update account balance
            $ddaccount->update(['balance' => $balanceAvailable]);

            DB::commit();

            return redirect()->route('ddsaccounts.show', $ddaccount->id)
                ->with('success', 'Interest transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("DDS Interest Transaction FAILED", [
                'dds_account_id' => $id,
                'error_message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'Something went wrong. Try again.');
        }
    }

    public function createMarkLienAccount($id)
    {
        $ddaccount = DdsAccount::with('member', 'branch', 'transactions', 'scheme', 'account')->findOrFail($id);
        $savingAccounts = Account::where('member_id', $ddaccount->member_id)
            ->where('account_type', 'Saving')
            ->where('account_status', 1)
            ->get();

        return view('fd_account.ddsaccounts.markLienAccount', compact('ddaccount', 'savingAccounts'));
    }
    public function accountNominee(string $id)
    {
        $ddaccount = DdsAccount::with(['member', 'nominee'])
            ->where('id', $id)
            ->firstOrFail();

        $member = $ddaccount->member;

        return view('fd_account.ddsaccounts.account-nominee', compact('ddaccount', 'member'));
    }

    // public function saveNominees(Request $request, $id)
    // {
    //     $account = DdsAccount::findOrFail($id);

    //     DB::beginTransaction();

    //     try {
    //         Log::info('Nominee update process started', [
    //             'account_id'  => $account->id,
    //             'request_data' => $request->all(),
    //         ]);

    //         if ($request->nominee === 'no') {

    //             $deletedCount = $account->nominee()->count();
    //             $account->nominee()->delete();

    //             Log::info('All nominees removed for account', [
    //                 'account_id'   => $account->id,
    //                 'deleted_count' => $deletedCount,
    //             ]);

    //             DB::commit();

    //             return back()->with('success', 'Nominee information removed successfully.');
    //         }

    //         $validated = $request->validate([
    //             'nominees'              => 'required|array|min:1',
    //             'nominees.*.id'         => 'nullable|integer',
    //             'nominees.*.name'       => 'required|string|max:255',
    //             'nominees.*.address'    => 'required|string|max:255',
    //             'nominees.*.relation'   => 'required|string|max:100',
    //             'nominees.*.share'      => 'nullable|numeric|min:1|max:100',
    //         ]);


    //         $submittedNominees = collect($validated['nominees']);
    //         $existingNominees  = $account->nominee()->pluck('id')->toArray();

    //         $updatedNominees = [];
    //         $addedNominees   = [];

    //         // -------------------------------------------------
    //         // Add or Update Nominees
    //         // -------------------------------------------------
    //         foreach ($submittedNominees as $nomineeData) {

    //             $nominee = null;

    //             // 1️⃣ Try update via ID
    //             if (!empty($nomineeData['id'])) {
    //             $nominee = $account->nominee()
    //                 ->where('id', $nomineeData['id'])
    //                 ->first();
    //         }

    //             // 2️⃣ Fallback match: by name + relation
    //             if (!$nominee) {
    //                 $nominee = $account->nominee()
    //                     ->where('nominee_name', $nomineeData['name'])
    //                     ->where('nominee_relation', strtolower($nomineeData['relation']))
    //                     ->first();
    //             }

    //             if ($nominee) {

    //                 // UPDATE
    //                 $nominee->update([
    //                     'nominee_name'      => $nomineeData['name'],
    //                     'nominee_address'   => $nomineeData['address'],
    //                     'nominee_relation'  => strtolower($nomineeData['relation']),
    //                     'share_percentage'  => $nomineeData['share'] ?? 100,
    //                 ]);

    //                 $updatedNominees[] = $nominee->id;

    //                 Log::info('Nominee updated', [
    //                     'account_id' => $account->id,
    //                     'nominee_id' => $nominee->id,
    //                 ]);
    //             } else {

    //                 // CREATE
    //                 $newNominee = $account->nominee()->create([
    //                     'nominee_name'      => $nomineeData['name'],
    //                     'nominee_address'   => $nomineeData['address'],
    //                     'nominee_relation'  => strtolower($nomineeData['relation']),
    //                     'share_percentage'  => $nomineeData['share'] ?? 100,
    //                 ]);

    //                 $addedNominees[] = $newNominee->id;

    //                 Log::info('New nominee added', [
    //                     'account_id' => $account->id,
    //                     'nominee_id' => $newNominee->id,
    //                 ]);
    //             }
    //         }

    //         $nomineesToDelete = array_diff($existingNominees, $updatedNominees);

    //         if (!empty($nomineesToDelete)) {
    //             AccountNominee::whereIn('id', $nomineesToDelete)->delete();

    //             Log::info('Nominees deleted', [
    //                 'dds_account_id'           => $account->id,
    //                 'deleted_nominee_ids'  => $nomineesToDelete,
    //             ]);
    //         }

    //         DB::commit();

    //         try {

    //             $member = Member::find($account->member_id);

    //             $mobile = $member->member_info_mobile_no;
    //             $ddNo = $account->account_no;

    //             if (!empty($addedNominees)) {
    //                 $dlttemplateid = 1707172234309014589;
    //                 $message = "Dear Customer, nominee has been successfully added to your DD no. $ddNo. SBC GLOBAL";
    //                 SmsHelper::sendSms($mobile, $message, $dlttemplateid);
    //             }

    //             // Updated nominees SMS
    //             if (!empty($updatedNominees)) {
    //                 $dlttemplateid = 1707172234307304278;
    //                 $message = "Dear Customer, nominee has been successfully updated in your DD no. $ddNo. SBC GLOBAL";
    //                 $successMessage = "Nominee details added successfully.";
    //                 SmsHelper::sendSms($mobile, $message, $dlttemplateid);
    //             } 

    //             SmsHelper::sendSms($mobile, $message, $dlttemplateid);
    //         } catch (\Exception $e) {
    //             Log::error('Nominee SMS sending failed', ['error' => $e->getMessage()]);
    //         }

    //         return redirect()
    //             ->route('ddsaccounts.show', $account->id)
    //             ->with('success', $successMessage);
    //     } catch (\Throwable $th) {

    //         DB::rollBack();

    //         Log::error('Nominee update failed', [
    //             'account_id' => $account->id,
    //             'error'      => $th->getMessage(),
    //             'trace'      => $th->getTraceAsString(),
    //         ]);

    //         return redirect()
    //             ->route('ddsaccounts.show', $account->id)
    //             ->with('error', 'Something went wrong while updating nominees: ' . $th->getMessage());
    //     }
    // }

    public function saveNominees(Request $request, $id)
    {

        $account = DdsAccount::findOrFail($id);
   
        DB::beginTransaction();

        try {
            Log::info('Nominee update process started', [
                'account_id'  => $account->id,
                'request_data' => $request->all(),
            ]);
 
            if ($request->nominee === 'no') {
 
                $deletedCount = $account->nominee()->count();
                $account->nominee()->delete();

                Log::info('All nominees removed for account', [
                    'account_id'   => $account->id,
                    'deleted_count' => $deletedCount,
                ]);

                DB::commit();

                return back()->with('success', 'Nominee information removed successfully.');
            }

            // -------------------------------------------------
            // Validation
            // -------------------------------------------------
            $validated = $request->validate([
                'nominees'              => 'required|array|min:1',
                'nominees.*.id'         => 'nullable|integer',
                'nominees.*.name'       => 'required|string|max:255',
                'nominees.*.address'    => 'required|string|max:255',
                'nominees.*.relation'   => 'required|string|max:100',
                'nominees.*.share'      => 'nullable|numeric|min:1|max:100',
            ]);

            $submittedNominees = collect($validated['nominees']);
            $existingNominees  = $account->nominee()->pluck('id')->toArray();

            $updatedNominees = [];
            $addedNominees   = [];

            foreach ($submittedNominees as $nomineeData) {

                $nominee = null;
  
                if (!empty($nomineeData['id'])) {
                    $nominee = $account->nominee()
                        ->where('id', $nomineeData['id'])
                        ->first();
                }

                if (!$nominee) {
                    $nominee = $account->nominee()
                        ->where('nominee_name', $nomineeData['name'])
                        ->where('nominee_relation', strtolower($nomineeData['relation']))
                        ->first();
                }

                if ($nominee) {

                    $nominee->update([
                        'nominee_name'      => $nomineeData['name'],
                        'nominee_address'   => $nomineeData['address'],
                        'nominee_relation'  => strtolower($nomineeData['relation']),
                        'share_percentage'  => $nomineeData['share'] ?? 100,
                    ]);

                    $updatedNominees[] = $nominee->id;

                    Log::info('Nominee updated', [
                        'account_id' => $account->id,
                        'nominee_id' => $nominee->id,
                    ]);
                } else {

                    // CREATE
                    $newNominee = $account->nominee()->create([
                        'nominee_name'      => $nomineeData['name'],
                        'nominee_address'   => $nomineeData['address'],
                        'nominee_relation'  => strtolower($nomineeData['relation']),
                        'share_percentage'  => $nomineeData['share'] ?? 100,
                    ]);

                    $addedNominees[] = $newNominee->id;

                    Log::info('New nominee added', [
                        'account_id' => $account->id,
                        'nominee_id' => $newNominee->id,
                    ]);
                }
            }

            // -------------------------------------------------
            // Remove Deleted Nominees
            // -------------------------------------------------
            $nomineesToDelete = array_diff($existingNominees, $updatedNominees);

            if (!empty($nomineesToDelete)) {
                AccountNominee::whereIn('id', $nomineesToDelete)->delete();

                Log::info('Nominees deleted', [
                    'dds_account_id' => $account->id,
                    'deleted_ids'    => $nomineesToDelete,
                ]);
            }

            DB::commit();

            // -------------------------------------------------
            // SEND SMS
            // -------------------------------------------------
            try {
                $member = Member::find($account->member_id);

                if ($member) {
                    $mobile = $member->member_info_mobile_no;
                    $ddNo   = $account->account_no;

                    if (!empty($addedNominees)) {
                        $dlttemplateid = 1707172234309014589;
                        $message = "Dear Customer, nominee has been successfully added to your DD no. $ddNo. SBC GLOBAL";
                        SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                    }

                    if (!empty($updatedNominees)) {
                        $dlttemplateid = 1707172234307304278;
                        $message = "Dear Customer, nominee has been successfully updated in your DD no. $ddNo. SBC GLOBAL";
                        SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                    }
                }
            } catch (\Exception $e) {
                Log::error('SMS sending failed', ['error' => $e->getMessage()]);
            }

            // -------------------------------------------------
            // Success Message Fix (IMPORTANT)
            // -------------------------------------------------
            if (!empty($addedNominees) && empty($updatedNominees)) {
                $successMessage = "Nominee added successfully.";
            } elseif (!empty($updatedNominees) && empty($addedNominees)) {
                $successMessage = "Nominee updated successfully.";
            } else {
                $successMessage = "Nominee details saved successfully.";
            }

            return redirect()
                ->route('ddsaccounts.show', $account->id)
                ->with('success', $successMessage);
        } catch (\Throwable $th) {

            DB::rollBack();

            Log::error('Nominee update failed', [
                'account_id' => $account->id,
                'error'      => $th->getMessage(),
                'trace'      => $th->getTraceAsString(),
            ]);

            return redirect()
                ->route('ddsaccounts.show', $account->id)
                ->with('error', 'Something went wrong while updating nominees: ' . $th->getMessage());
        }
    }

    public function changeAccountInfo($id)
    {
        $ddaccount = DdsAccount::with(
            'member.kyc',
            'branch',
            'transactions',
            'scheme',
            'account'
        )->findOrFail($id);

        $schemes = RdScheme::all();

        $selectedMember = Member::find($ddaccount->member_id);
        $otherMembers = Member::where('id', '!=', $ddaccount->member_id)->get();
        $members = collect([$selectedMember])->merge($otherMembers);

        return view(
            'fd_account.ddsaccounts.changeAccInfo',
            compact('ddaccount', 'members', 'schemes')
        );
    }

    public function updateAccountInfo(Request $request, $id)
    {
        $request->validate([
            'scheme_id' => 'required|exists:rdschemes,id',
            'account_holder_type' => 'required|in:single,joint',
            'dd_amount'  => 'required|numeric|min:1',
            'open_date' => 'required|date',
        ]);

        $ddaccount = DdsAccount::findOrFail($id);

        DB::beginTransaction();

        try {

            Log::info('DDS Account Info Update Started', [
                'dds_account_id' => $ddaccount->id,
                'request_data'   => $request->all(),
                'old_values'     => [
                    'scheme_id' => $ddaccount->scheme_id,
                    'dd_amount' => $ddaccount->dd_amount,
                    'open_date' => $ddaccount->open_date,
                    'account_holder_type' => optional($ddaccount->account)->account_holder_type
                ]
            ]);

            $ddaccount->scheme_id = $request->scheme_id;
            $ddaccount->dd_amount = $request->dd_amount;
            $ddaccount->open_date = $request->open_date;
            $ddaccount->save();

            if ($ddaccount->account) {
                $ddaccount->account->account_holder_type = $request->account_holder_type;
                $ddaccount->account->save();
            }

            DB::commit();

            Log::info('DDS Account Info Updated Successfully', [
                'dds_account_id' => $ddaccount->id,
                'new_values'     => [
                    'scheme_id' => $ddaccount->scheme_id,
                    'dd_amount' => $ddaccount->dd_amount,
                    'open_date' => $ddaccount->open_date,
                    'account_holder_type' => optional($ddaccount->account)->account_holder_type
                ]
            ]);

            return redirect()
                ->route('ddsaccounts.show', $ddaccount->id)
                ->with('success', 'Account Information Updated Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('DDS Account Info Update Failed', [
                'dds_account_id' => $ddaccount->id,
                'error_message'  => $e->getMessage(),
                'line'           => $e->getLine(),
                'file'           => $e->getFile(),
            ]);

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function changeMinorInfo($id)
    {
        $ddaccount = DdsAccount::with('member', 'branch', 'transactions', 'scheme', 'account')
            ->findOrFail($id);

        $minors = Minor::where('member_id', $ddaccount->member_id)
            ->whereNull('deleted_at')
            ->get();

        return view('fd_account.ddsaccounts.addMinorOrUpdate', compact('ddaccount', 'minors'));
    }
    public function updateMinor(Request $request, $id)
    {
        $request->validate([
            'minor_id' => 'nullable|exists:minors,id',
        ]);

        $ddaccount = DdsAccount::findOrFail($id);

        DB::beginTransaction();

        try {

            Log::info('DDS Minor Update Started', [
                'dds_account_id' => $ddaccount->id,
                'request_data'   => $request->all(),
                'old_minor_id'   => $ddaccount->minor_id,
            ]);

            $oldMinor = $ddaccount->minor_id;
            $ddaccount->minor_id = $request->minor_id;
            $ddaccount->save();

            Log::info('DDS Minor Updated Successfully', [
                'dds_account_id' => $ddaccount->id,
                'old_minor_id'   => $oldMinor,
                'new_minor_id'   => $ddaccount->minor_id,
            ]);

            DB::commit();

            return redirect()
                ->route('ddsaccounts.show', $ddaccount->id)
                ->with('success', 'Minor information updated successfully.');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('DDS Minor Update Failed', [
                'dds_account_id' => $ddaccount->id,
                'error'          => $e->getMessage(),
                'request_data'   => $request->all(),
            ]);

            return back()->with('error', 'Something went wrong while updating minor.');
        }
    }
}
