<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Branch;
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
            $paid = $account->transactions->count();
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
            'remarks'    => 'nullable|string',
        ]);
        switch ($request->pay_mode) {
            case 'onlineTr':
                $rules['transfer_date'] = 'required|date_format:d-m-Y';
                $rules['utr_no'] = 'required|string|max:255';
                $rules['transfer_mode'] = 'required|in:IMPS,VPA,NEFT/RTGS';
                $rules['credited_in_company'] = 'required|in:1,0'; // 1=Yes, 0=No
                break;

            case 'cheque':
                $rules['bank_name'] = 'required|string|max:255';
                $rules['cheque_no'] = 'required|string|max:255';
                $rules['cheque_date'] = 'required|date_format:d-m-Y';
                break;

            case 'saving':
                $rules['saving_account_id'] = 'required|exists:saving_accounts,id';
                break;
        }
        try {
            Log::info('✅ Validation successful', $validated);

            $scheme = Rdscheme::findOrFail($validated['scheme_id']);
            Log::info('✅ Scheme fetched', ['scheme_id' => $scheme->id, 'scheme_name' => $scheme->name ?? 'N/A']);

            $depositPerDay = $scheme->min_rd_dd_amount;

            if ($scheme->tenure_of_rd_dd_type === 'months') {
                $days = $scheme->tenure_of_rd_dd_value * 30;
            } elseif ($scheme->tenure_of_rd_dd_type === 'years') {
                $days = $scheme->tenure_of_rd_dd_value * 365;
            } else {
                $days = $scheme->tenure_of_rd_dd_value;
            }
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

            if ($scheme->bonus_rate_type === 'percentage') {
                $bonusRate = $scheme->bonus_rate_value;
                $fixedBonus = 0;
            } elseif ($scheme->bonus_rate_type === 'fixed') {
                $bonusRate = 0;
                $fixedBonus = $scheme->bonus_rate_value;
            } else {
                $bonusRate = 0;
                $fixedBonus = 0;
            }

            $calculation = $this->calculateMaturity(
                $request->dd_amount,
                $installments,
                'daily',
                $rate,
                $bonusRate,
                $fixedBonus,
                $request->open_date
            );

            sleep(5);
            $total_deposit          = $calculation['total_deposit'];
            $interest_earned        = $calculation['interest_earned'];
            $bonus                  = $calculation['bonus'];
            $maturity               = $calculation['maturity'];
            $maturity_date          = $calculation['maturity_date'];

            Log::info('📈 Maturity calculated', $calculation);

            $ddsAccount = new DdsAccount();
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
            $ddsAccount->paid_installments     = 1;
            $ddsAccount->due_installments      = 0;
            $ddsAccount->overdue_installments  = 0;
            $ddsAccount->canceled_installments = 0;
            $ddsAccount->not_due_installments  = $ddsAccount->total_installments - 1;
            $ddsAccount->maturity_date = \Carbon\Carbon::createFromFormat('d-m-Y', $calculation['maturity_date'])->format('Y-m-d');
            $ddsAccount->save();

            Log::info('✅ DDS Account created', ['dds_account_id' => $ddsAccount->id]);

            $transaction = new DdTransaction();
            $transaction->dds_account_id = $ddsAccount->id;
            $transaction->transaction_date = now()->format('Y-m-d');
            $transaction->balance_available = $request->amount;
            $transaction->account_id = null;
            $transaction->pay_mode = $request->pay_mode;

            switch ($request->pay_mode) {
                case 'onlineTr':
                    $transaction->transfer_date = Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d');
                    $transaction->utr_no = $request->utr_no;
                    $transaction->transfer_mode = $request->transfer_mode;
                    $transaction->credited_in_company = $request->credited_in_company;
                    break;

                case 'cheque':
                    $transaction->bank_name = $request->bank_name;
                    $transaction->cheque_no = $request->cheque_no;
                    $transaction->cheque_date = Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d');
                    break;

                case 'saving':
                    $transaction->saving_account_id = $request->saving_account_id;
                    break;

                    // No additional fields needed for 'cash'
            }

            $transaction->save();

            Log::info('✅ Transaction saved', ['transaction_id' => $transaction->id, 'pay_mode' => $transaction->pay_mode]);

            Log::debug('📦 Full transaction request payload', $request->all());

            if ($request->nominee === "yes" && $request->has('nominee_name')) {
                $totalNominees = count(array_filter($request->nominee_name));
                $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (!empty($name)) {
                        AccountNominee::create([
                            'account_id'       => $ddsAccount->id,
                            'nominee_name'     => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address'  => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }

                Log::info('👥 Nominees added', ['total_nominees' => $totalNominees]);
            }

            return redirect()->route('dds-accounts.index')
                ->with('success', 'DDS Account created successfully!');
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

        $ddaccount = DdsAccount::with(['member', 'branch', 'scheme'])->findOrFail($id);

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

        $principalDue = max($installmentAmount * $due, 0);
        $penaltyDue   = ($principalDue > 0 && !empty($ddaccount->scheme->penalty_charges_value))
            ? $due * $ddaccount->scheme->penalty_charges_value
            : 0;

        $totalAmountDue = $principalDue + $penaltyDue;

        $closeDate = '';
        if ($paid >= $totalInstallments && $ddaccount->open_date) {
            $openingDate = Carbon::parse($ddaccount->open_date);
            $closeDate = match (strtolower($ddaccount->rd_dd_frequency)) {
                'daily' => $openingDate->copy()->addDays($totalInstallments)->format('d-m-Y'),
                'monthly' => $openingDate->copy()->addMonths($totalInstallments)->format('d-m-Y'),
                'yearly' => $openingDate->copy()->addYears($totalInstallments)->format('d-m-Y'),
                default => $openingDate->copy()->addDays($totalInstallments)->format('d-m-Y'),
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

        Log::info('DDS Maturity Calculation', [
            'dds_account_id'         => $ddaccount->id,
            'installment_amount'     => $installmentAmount,
            'total_installments'     => $totalInstallments,
            'frequency'              => $ddaccount->rd_dd_frequency,
            'annual_interest_rate'   => $annualInterestRate,
            'maturity_bonus_percent' => $ddaccount->scheme->maturity_bonus_percent ?? 0,
            'open_date'              => $ddaccount->open_date,
            'scheme_tenure_value'    => $ddaccount->scheme->tenure_of_rd_dd_value,
            'calculation'            => $calculation
        ]);

        $maturityAmount = $calculation['maturity'];
        $maturityBonus  = $calculation['bonus'];
        $maturityDate   = $calculation['maturity_date'];

        $specialAccount = $ddaccount->account_type === 'special';

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

        $installmentAmount = $ddaccount->dd_amount;
        $openDate = Carbon::parse($ddaccount->open_date);
        $totalInstallments = $ddaccount->total_installments;
        $frequency = strtolower($ddaccount->rd_dd_frequency);

        $installments = [];

        for ($i = 0; $i < $totalInstallments; $i++) {
            $dueDate = match ($frequency) {
                'daily' => $openDate->copy()->addDays($i),
                'monthly' => $openDate->copy()->addMonths($i),
                'yearly' => $openDate->copy()->addYears($i),
                default => $openDate->copy()->addDays($i),
            };

            $transaction = $ddaccount->transactions->firstWhere(function ($tranx) use ($dueDate) {
                return Carbon::parse($tranx->transaction_date)->isSameDay($dueDate);
            });

            $installments[] = [
                'number'   => $i + 1,
                'amount'   => number_format($installmentAmount, 2),
                'due_date' => $dueDate->format('d/m/Y'),
                'state'    => $transaction ? 'PAID' : '',
                'paid_on'  => $transaction ? Carbon::parse($transaction->transaction_date)->format('d/m/Y') : '',
            ];
        }

        return view('fd_account.ddsaccounts.installments', [
            'ddaccount' => $ddaccount,
            'installments' => $installments,
        ]);
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

        // Get transactions
        $transactions = $query
            ->orderBy('transaction_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Calculate running balance
        $transactions = TransactionHelper::calculateRunningBalance($transactions);

        // Sort transactions (most recent first)
        $transactions = $transactions->sortByDesc('transaction_date')->sortByDesc('id')->values();

        return view('fd_account.ddsaccounts.transactions', compact('ddsAccount', 'transactions'));
    }
    public function destroyTransaction($id)
    {
        dd($id);
        Log::info("DdsAccountsController@destroyTransaction called for Transaction ID: $id");
        $tranx = DdTransaction::findOrFail($id);
        $tranx->delete();

        return back()->with('success', 'Transaction deleted.');
    }

    public function transactionShow($accountId, $transactionId)
    {
        Log::info("DdsAccountsController@transactionShow called for DDS ID: $accountId, Transaction ID: $transactionId");

        // Fetch DDS Account with relations
        $ddsAccount = DdsAccount::with(['member', 'branch', 'scheme'])
            ->findOrFail($accountId);

        // Fetch Transaction with all related data including branch
        $transaction = DdTransaction::where('dds_account_id', $accountId)
            ->with(['ddsAccount', 'branch'])
            ->findOrFail($transactionId);
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


    // public function deposit(Request $request, $id)
    // {
    //     Log::info('Deposit function called', ['account_id' => $id, 'request_data' => $request->all()]);

    //     // Step 1: Validate the request
    //     try {
    //         $request->validate([
    //             'amount' => 'required|numeric|min:1',
    //             'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
    //             'transaction_date' => 'required|date_format:d-m-Y',
    //             'saving_account_id' => 'required_if:pay_mode,saving|exists:accounts,id',
    //         ]);
    //         Log::info('Validation passed');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         Log::warning('Validation failed', ['errors' => $e->errors()]);
    //         return redirect()->back()->withErrors($e->errors());
    //     }

    //     $amount = $request->amount;

    //     // Step 2: Find DDS account
    //     $account = DdsAccount::find($id);
    //     if (!$account) {
    //         Log::error('DDS Account not found', ['account_id' => $id]);
    //         return redirect()->back()->with('error', 'Account not found!');
    //     }
    //     Log::info('DDS Account found', ['account_id' => $id, 'balance' => $account->balance]);

    //     // Step 3: Convert dates (transaction date, transfer date, cheque date)
    //     try {
    //         $transactionDate = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
    //         $transferDate = $request->transfer_date ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d') : null;
    //         $chequeDate = $request->cheque_date ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d') : null;
    //     } catch (\Exception $e) {
    //         Log::error('Date conversion failed', ['error' => $e->getMessage()]);
    //         return redirect()->back()->with('error', 'Invalid date format');
    //     }

    //     // Step 4: Deduct from saving account if pay_mode is saving
    //     $savingAccountId = null;
    //     if ($request->pay_mode === 'saving') {
    //         $savingAccount = Account::find($request->saving_account_id);
    //         if (!$savingAccount) {
    //             Log::error('Saving account not found', ['saving_account_id' => $request->saving_account_id]);
    //             return redirect()->back()->with('error', 'Saving account not found!');
    //         }

    //         if ($savingAccount->amount_deposit < $amount) {
    //             Log::warning('Insufficient balance in saving account', ['saving_account_id' => $savingAccount->id]);
    //             return redirect()->back()->with('error', 'Insufficient balance in saving account!');
    //         }

    //         // Deduct amount from saving account
    //         $savingAccount->amount_deposit -= $amount;
    //         $savingAccount->save();
    //         $savingAccountId = $savingAccount->id;

    //         Log::info('Amount deducted from saving account', ['saving_account_id' => $savingAccount->id, 'new_balance' => $savingAccount->amount_deposit]);
    //     }

    //     // Step 5: Set remarks and status
    //     $remarks = $request->remarks;
    //     if ($request->pay_mode === 'saving' && isset($savingAccount)) {
    //         $remarks = $remarks ?: 'Credit from Saving a/c - ' . $savingAccount->account_no;
    //     }
    //     if (!$remarks) $remarks = 'Deposit via ' . ucfirst($request->pay_mode);
    //     $status = ($request->pay_mode === 'saving') ? 'Approved' : 'Pending';

    //     // Log the transaction status
    //     Log::info('Transaction status determined', [
    //         'status' => $status,
    //         'pay_mode' => $request->pay_mode,
    //         'remarks' => $remarks
    //     ]);

    //     // Step 6: Create the transaction
    //     try {
    //         $transaction = DdTransaction::create([
    //             'type' => 'credit',
    //             'dds_account_id' => $id,
    //             'pay_mode' => $request->pay_mode,
    //             'remarks' => $remarks,
    //             'transaction_date' => $transactionDate,
    //             'amount' => $amount,
    //             'balance_available' => $account->balance + $amount, // Calculate the new balance
    //             'collected_by' => $request->collected_by ?? null,
    //             't_receipt' => $request->t_receipt ?? null,
    //             'transfer_date' => $transferDate,
    //             'transfer_mode' => $request->transfer_mode ?? null,
    //             'utr_no' => $request->utr_no ?? null,
    //             'bank_name' => $request->bank_name ?? null,
    //             'cheque_no' => $request->cheque_no ?? null,
    //             'cheque_date' => $chequeDate,
    //             'saving_account_id' => $savingAccountId,
    //         ]);
    //         Log::info('Transaction created', ['transaction_id' => $transaction->id, 'status' => $status]);
    //     } catch (\Exception $e) {
    //         Log::error('Failed to create transaction', ['error' => $e->getMessage()]);
    //         return redirect()->back()->with('error', 'Failed to create transaction');
    //     }

    //     // Step 7: Recalculate the running balance for all transactions
    //     try {
    //         $runningBalance = 0;
    //         $transactions = DdTransaction::where('dds_account_id', $id)
    //             ->orderBy('transaction_date')
    //             ->orderBy('id')
    //             ->get();

    //         foreach ($transactions as $txn) {
    //             $runningBalance += ($txn->type === 'credit') ? $txn->amount : -$txn->amount;
    //             $txn->balance_available = $runningBalance;
    //             $txn->save();
    //         }

    //         // Update the account balance
    //         $account->balance = $runningBalance;
    //         $account->save();
    //     } catch (\Exception $e) {
    //         Log::error('Error updating balances', ['error' => $e->getMessage()]);
    //         return redirect()->back()->with('error', 'Error updating balance');
    //     }

    //     Log::info('Deposit completed successfully', ['account_id' => $id, 'running_balance' => $runningBalance]);

    //     // Return to the transactions page with a success message
    //     return redirect()->route('dds-accounts.transactions', $id)
    //         ->with('success', 'Deposit successful!')
    //         ->with('transactions', $transactions);  // Pass transactions to the view
    // }
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

    // public function withdraw(Request $request, $id)
    // {
    //     Log::info('Withdrawal function called', ['account_id' => $id, 'request_data' => $request->all()]);

    //     try {
    //         $request->validate([
    //             'amount' => 'required|numeric|min:1',
    //             'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
    //             'transaction_date' => 'required|date_format:d-m-Y',
    //             'saving_account_id' => 'required_if:pay_mode,saving|exists:accounts,id',
    //         ]);
    //         Log::info('Validation passed for withdrawal');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         Log::warning('Validation failed', ['errors' => $e->errors()]);
    //         return redirect()->back()->withErrors($e->errors());
    //     }

    //     $amount = $request->amount;

    //     $account = DdsAccount::find($id);
    //     if (!$account) {
    //         Log::error('DDS Account not found', ['account_id' => $id]);
    //         return redirect()->back()->with('error', 'Account not found!');
    //     }

    //     if ($account->balance < $amount) {
    //         return redirect()->back()->with('error', 'Insufficient balance!');
    //     }

    //     try {
    //         $transactionDate = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Invalid date format');
    //     }

    //     DB::beginTransaction();

    //     try {
    //         $savingAccount = null;
    //         if ($request->pay_mode === 'saving') {
    //             $savingAccount = Account::find($request->saving_account_id);
    //             if (!$savingAccount) throw new \Exception('Saving account not found!');
    //             $savingAccount->amount_deposit += $amount;
    //             $savingAccount->save();
    //         }

    //         // Prepare remarks
    //         if ($request->pay_mode === 'saving' && $savingAccount) {
    //             $remarks = 'Debit to Saving a/c - ' . $savingAccount->account_no . '.';
    //         } else {
    //             $remarks = $request->remarks ?? 'Withdrawal via ' . ucfirst($request->pay_mode);
    //         }
    //         $status = ($request->pay_mode === 'saving') ? 'Approved' : 'Pending';

    //         $transaction = DdTransaction::create([
    //             'type' => 'debit',
    //             'dds_account_id' => $id,
    //             'pay_mode' => $request->pay_mode,
    //             'remarks' => $remarks,
    //             'transaction_date' => $transactionDate,
    //             'amount' => $amount,
    //             'balance_available' => 0, // will update below
    //             'collected_by' => $request->collected_by ?? null,
    //             't_receipt' => $request->t_receipt ?? null,
    //             'saving_account_id' => $savingAccount->id ?? null,
    //             'status' => $status,
    //         ]);

    //         // Recalculate running balance
    //         $transactions = DdTransaction::where('dds_account_id', $id)
    //             ->orderBy('transaction_date')
    //             ->orderBy('id')
    //             ->get();

    //         $runningBalance = 0;
    //         foreach ($transactions as $txn) {
    //             $runningBalance += ($txn->type === 'credit') ? $txn->amount : -$txn->amount;
    //             $txn->balance_available = $runningBalance;
    //             $txn->save();
    //         }

    //         $account->balance = $runningBalance;
    //         $account->save();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }

    //     return redirect()->route('dds-accounts.transactions', $id)->with('success', 'Withdrawal successful!');
    // }
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
            $remarks= null ;
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


}
