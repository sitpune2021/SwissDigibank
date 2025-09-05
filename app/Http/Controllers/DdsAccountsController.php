<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Branch;
use App\Models\DdsAccount;
use App\Models\Minor;
use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\DdTransaction;
use App\Models\Rdscheme;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;

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
        $savingAccounts = Account::where('account_type', 'saving')->get();
        $members = Member::orderBy('member_info_first_name')->get();

        return view('fd_account.ddsaccounts.create', compact('members', 'branches', 'schemes', 'minors', 'savingAccounts'));
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

        // Call calculateMaturity with logging
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



    // public function show($id)
    // {
    //     Log::info("DdsAccountsController@show called for ID: $id");

    //     $ddaccount = DdsAccount::with(['member', 'branch', 'scheme', 'transactions'])->findOrFail($id);

    //     $installmentAmount = $ddaccount->dd_amount ?? 0;

    //     $totalInstallments = $ddaccount->total_installments
    //         ?? (strtolower($ddaccount->rd_dd_frequency) === 'daily' ? 365 : ($ddaccount->scheme->tenure_of_rd_dd_value ?? 12));

    //     $installmentReceived = $ddaccount->transactions->sum('amount') ?? 0;
    //     $penaltyReceived     = $ddaccount->transactions->sum('penalty_amount') ?? 0;
    //     $interestCredited    = $ddaccount->transactions->sum('interest_amount') ?? 0;
    //     $tdsDeduction        = $ddaccount->tds_deduction ?? 0;

    //     $balanceAvailable = $installmentReceived + $interestCredited + $penaltyReceived - $tdsDeduction;

    //     $shouldHavePaid = 0;
    //     if ($ddaccount->open_date) {
    //         $openDate = Carbon::parse($ddaccount->open_date);
    //         $today = Carbon::today();

    //         switch (strtolower($ddaccount->rd_dd_frequency)) {
    //             case 'daily':
    //                 $shouldHavePaid = $openDate->diffInDays($today);
    //                 break;
    //             case 'monthly':
    //                 $shouldHavePaid = $openDate->diffInMonths($today);
    //                 break;
    //             case 'yearly':
    //                 $shouldHavePaid = $openDate->diffInYears($today);
    //                 break;
    //         }

    //         $shouldHavePaid = min($shouldHavePaid, $totalInstallments);
    //     }

    //     $paid = $ddaccount->transactions->count();
    //     $due = max($shouldHavePaid - $paid, 0);

    //     $overdue = 0;
    //     if (!empty($ddaccount->maturity_date)) {
    //         $maturityDateCheck = Carbon::parse($ddaccount->maturity_date);
    //         if ($today->gt($maturityDateCheck)) {
    //             $overdue = $totalInstallments - $paid;
    //         }
    //     }

    //     $notDue = $totalInstallments - $paid - $due;

    //     $principalDue = max($installmentAmount * $due, 0);

    //     $penaltyDue = ($principalDue > 0 && !empty($ddaccount->scheme->penalty_charges_value))
    //         ? $due * $ddaccount->scheme->penalty_charges_value
    //         : 0;

    //     $totalAmountDue = $principalDue + $penaltyDue;

    //     $closeDate = '';
    //     if ($paid >= $totalInstallments && $ddaccount->open_date) {
    //         $openingDate = Carbon::parse($ddaccount->open_date);
    //         if (strtolower($ddaccount->rd_dd_frequency) === 'daily') {
    //             $closeDate = $openingDate->copy()->addDays($totalInstallments)->format('d-m-Y');
    //         } else {
    //             $closeDate = $openingDate->copy()->addMonths($totalInstallments)->format('d-m-Y');
    //         }
    //     }

    //     $annualInterestRate = $ddaccount->scheme->anuual_interest_rate ?? 0;

    //     $calculation = $this->calculateMaturity(
    //         $installmentAmount,
    //         $totalInstallments,
    //         strtolower($ddaccount->rd_dd_frequency),
    //         $annualInterestRate,
    //         $ddaccount->scheme->maturity_bonus_percent ?? 0,
    //         0,
    //         $ddaccount->open_date
    //     );

    //     $maturityAmount = $calculation['maturity'];
    //     $maturityBonus  = $calculation['bonus'];
    //     $maturityDate   = $calculation['maturity_date'];

    //     $specialAccount = $ddaccount->account_type === 'special';
    //     return view('fd_account.ddsaccounts.show', [
    //         'ddaccount'             => $ddaccount,
    //         'branches'              => Branch::all(),
    //         'members'               => Member::all(),
    //         'schemes'               => Rdscheme::all(),
    //         'installmentAmount'     => $installmentAmount,
    //         'installmentReceived'   => $installmentReceived,
    //         'penaltyReceived'       => $penaltyReceived,
    //         'interestCredited'      => $interestCredited,
    //         'tdsDeduction'          => $tdsDeduction,
    //         'balanceAvailable'      => $balanceAvailable,
    //         'principalDue'          => $principalDue,
    //         'penaltyDue'            => $penaltyDue,
    //         'totalAmountDue'        => $totalAmountDue,
    //         'closeDate'             => $closeDate,
    //         'maturityAmount'        => $maturityAmount,
    //         'maturityBonus'         => $maturityBonus,
    //         'maturityDate'          => $maturityDate,
    //         'annualInterestRate'    => $annualInterestRate,
    //         'paid_installments'     => $paid,
    //         'due_installments'      => $due,
    //         'overdue_installments'  => $overdue,
    //         'not_due_installments'  => max($notDue, 0),
    //         'specialAccount'        => $specialAccount,
    //     ]);
    // }

    public function store(Request $request)
    {
        Log::info('DdsAccountsController@store called');
        $validated = $request->validate([
            'member_id' => 'required|integer',
            'branch_id' => 'required|integer',
            'scheme_id' => 'required|integer|exists:rdschemes,id',
            'open_date' => 'required|date',
            'amount' => 'required|numeric',
            'nominee' => 'required|in:yes,no',
            'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
            'dd_amount' => 'required|numeric|min:100',
        ]);

        try {
            $scheme = Rdscheme::findOrFail($validated['scheme_id']);

            $depositPerDay = $scheme->min_rd_dd_amount;

            // Tenure days calculate
            if ($scheme->tenure_of_rd_dd_type === 'months') {
                $days = $scheme->tenure_of_rd_dd_value * 30;
            } elseif ($scheme->tenure_of_rd_dd_type === 'years') {
                $days = $scheme->tenure_of_rd_dd_value * 365;
            } else {
                $days = $scheme->tenure_of_rd_dd_value;
            }

            $rate = $scheme->anuual_interest_rate;

            switch ($scheme->rd_dd_frequency) {
                case 'daily':
                    $installments = 365;
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
                $depositPerDay,
                $installments,
                $scheme->rd_dd_frequency,
                $rate,
                $bonusRate,
                $fixedBonus,
                $request->open_date
            );

            $ddsAccount = new DdsAccount();
            $ddsAccount->member_id = $request->member_id;
            $ddsAccount->branch_id = $request->branch_id;
            $ddsAccount->scheme_id = $request->scheme_id;
            $ddsAccount->dd_amount = $request->dd_amount;
            $ddsAccount->open_date = $request->open_date;
            $ddsAccount->nominee = ($request->nominee === 'yes') ? 1 : 0;
            $ddsAccount->account_type = 'single';
            $ddsAccount->tds_deduction = 0;
            $ddsAccount->rd_dd_frequency = $scheme->rd_dd_frequency;
            $ddsAccount->total_installments = $installments;
            $ddsAccount->maturity_amount = $calculation['maturity'];
            $ddsAccount->maturity_date = \Carbon\Carbon::createFromFormat('d-m-Y', $calculation['maturity_date'])->format('Y-m-d');
            $ddsAccount->save();

            $transaction = new DdTransaction();
            $transaction->dds_account_id = $ddsAccount->id;
            $transaction->transaction_date = now()->format('Y-m-d');
            $transaction->amount = $request->amount;
            $transaction->account_id = null;
            $transaction->pay_mode = $request->pay_mode;
            $transaction->save();

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
            }

            return redirect()->route('dds-accounts.index')
                ->with('success', 'DDS Account created successfully!');
        } catch (\Exception $e) {
            Log::error("DDS Store Error: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
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
                'dd_amount'             => 'required|numeric|min:1',
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
        $member = Member::with('branch')->findOrFail($id);

        return response()->json([
            'member_info_first_name' => $member->member_info_first_name,
            'member_info_last_name'  => $member->member_info_last_name,
            'member_address_line_1'  => $member->address->member_address_line_1 ?? '',
            'member_info_mobile_no'  => $member->member_info_mobile_no,
            'branch_id'   => $member->branch_id,
            'branch_name' => $member->branch->branch_name ?? '',
            'open_date'              => now()->format('Y-m-d'),
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

    function calculateMaturity($depositAmount, $installments, $frequency, $annualRate, $bonusRate = 0, $fixedBonus = 0, $startDate = null, $schemeTenureMonths = null)
    {
        $totalDeposit = $depositAmount * $installments;
        $interest = 0;

        switch (strtolower($frequency)) {
            case 'daily':
                $days = $installments;
                $interest = ($depositAmount * $days * ($days + 1) * $annualRate) / (2 * 100 * 365);
                break;
            case 'monthly':
                $months = $installments;
                $interest = ($depositAmount * $months * ($months + 1) * $annualRate) / (2 * 100 * 12);
                break;
            case 'yearly':
                $years = $installments;
                $interest = ($depositAmount * $years * ($years + 1) * $annualRate) / (2 * 100);
                break;
        }

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

            switch (strtolower($frequency)) {
                case 'daily':
                    $date->addDays($installments);
                    break;
                case 'monthly':
                    $date->addMonths($installments);
                    break;
                case 'yearly':
                    $date->addYears($installments);
                    break;
            }

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
            $query->whereBetween('transaction_date', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        }

        if ($request->filled('from_amount') && $request->filled('to_amount')) {
            $query->whereBetween('amount', [
                $request->from_amount,
                $request->to_amount
            ]);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        return view('fd_account.ddsaccounts.transactions', compact('ddsAccount', 'transactions'));
    }

    public function destroyTransaction($id)
    {
        Log::info("DdsAccountsController@destroyTransaction called for Transaction ID: $id");
        $tranx = DdTransaction::findOrFail($id);
        $tranx->delete();

        return back()->with('success', 'Transaction deleted.');
    }

    public function transactionShow($accountId, $transactionId)
    {
        Log::info("DdsAccountsController@transactionShow called for DDS ID: $accountId, Transaction ID: $transactionId");
        $ddsAccount  = DdsAccount::with('member', 'branch', 'scheme')->findOrFail($accountId);
        $transaction = DdTransaction::where('dds_account_id', $accountId)
            ->with('ddsAccount')
            ->findOrFail($transactionId);

        return view('fd_account.ddsaccounts.transaction-show', compact('ddsAccount', 'transaction'));
    }
}
