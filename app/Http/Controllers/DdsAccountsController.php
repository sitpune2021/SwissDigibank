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
        $ddaccounts = DdsAccount::with(['member', 'branch', 'scheme', 'transactions'])
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($ddaccounts as $account) {
            $installments = $account->total_installments ?? 0;
            $openDate     = $account->open_date ? Carbon::parse($account->open_date) : null;
            $today        = Carbon::today();

            // Frequency gap
            $diff = 0;
            if ($openDate) {
                $frequency = $account->rd_dd_frequency; // daily/monthly/yearly
                if ($frequency === 'daily') {
                    $diff = $openDate->diffInDays($today);
                } elseif ($frequency === 'monthly') {
                    $diff = $openDate->diffInMonths($today);
                } elseif ($frequency === 'yearly') {
                    $diff = $openDate->diffInYears($today);
                }
            }

            // Till today, how many installments should be paid
            $shouldHavePaid = min($diff, $installments);

            // Paid installments = count of transactions
            $paid = $account->transactions->count();

            // Due installments = should have paid - paid
            $due = max($shouldHavePaid - $paid, 0);

            // Overdue installments = only if maturity_date exists and already passed
            $overdue = 0;
            if (!empty($account->maturity_date)) {
                $maturityDate = Carbon::parse($account->maturity_date);
                if ($today->gt($maturityDate)) {
                    $overdue = $installments - $paid;
                }
            }

            // Not due installments = total - should have paid
            $notDue = max($installments - $shouldHavePaid, 0);

            // Assign for blade
            $account->paid_installments     = $paid;
            $account->due_installments      = $due;
            $account->overdue_installments  = $overdue;
            $account->canceled_installments = 0; // unless you implement cancellation
            $account->not_due_installments = (int) $notDue;
        }

        return view('fd_account.ddsaccounts.index', compact('ddaccounts'));
    }


    public function create()
    {
        $members  = Member::all();
        $branches = Branch::all();
        $schemes = RdScheme::all();
        $minors   = Minor::all();
        $savingAccounts = Account::where('account_type', 'saving')->get();
        $members = Member::orderBy('member_info_first_name')->get();

        return view('fd_account.ddsaccounts.create', compact('members', 'branches', 'schemes', 'minors', 'savingAccounts'));
    }
    public function show($id)
    {
        $ddaccount = DdsAccount::with(['member', 'branch', 'scheme', 'transactions'])->findOrFail($id);
        $branches = Branch::select('id', 'branch_name')->orderBy('branch_name')->get();
        $branches = Branch::all(); // or whatever query you need
        $members  = Member::all();
        $schemes  = Rdscheme::all();


        return view('fd_account.ddsaccounts.show', compact('ddaccount', 'branches', 'members', 'schemes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'member_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'scheme_id'  => 'required|integer|exists:rdschemes,id',
                'open_date' => 'required|date',
                'amount' => 'required|numeric',
                'nominee' => 'required|in:yes,no',
                'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
                'dd_amount' => 'required|numeric|min:100',
            ]);
            $scheme = Rdscheme::findOrFail($validated['scheme_id']);

            $depositPerDay = $scheme->min_rd_dd_amount;

            if ($scheme->tenure_of_rd_dd_type === 'months') {
                $days = $scheme->tenure_of_rd_dd_value * 30;
            } elseif ($scheme->tenure_of_rd_dd_type === 'years') {
                $days = $scheme->tenure_of_rd_dd_value * 365;
            } else {
                $days = $scheme->tenure_of_rd_dd_value;
            }

            $rate = $scheme->anuual_interest_rate;

            // installments calculate
            if ($scheme->rd_dd_frequency === 'daily') {
                $installments = $days;
            } elseif ($scheme->rd_dd_frequency === 'monthly') {
                $installments = $scheme->tenure_of_rd_dd_value;
            } elseif ($scheme->rd_dd_frequency === 'yearly') {
                $installments = $scheme->tenure_of_rd_dd_value;
            } else {
                $installments = $days;
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
            // Calculate daily deposit
            $calculation = $this->calculateMaturity(
                $depositPerDay,
                $installments,
                $scheme->rd_dd_frequency,
                $rate,
                $bonusRate,
                $fixedBonus,
                $request->open_date
            );
            // // --- debug output ---
            // echo "<pre>";
            // print_r($calculation);
            // exit;

            // Save DDS Account with calculated values
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

            // Save first transaction
            $transaction = new DdTransaction();
            $transaction->dds_account_id = $ddsAccount->id;
            $transaction->transaction_date = now()->format('Y-m-d');
            $transaction->amount = $request->amount;
            $transaction->account_id = null;
            $transaction->pay_mode = $request->pay_mode;
            $transaction->save();

            // Save nominees if any
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
                Log::info('Nominees saved', ['count' => $totalNominees]);
            }

            Log::info("DdTransaction saved successfully", ['id' => $transaction->id]);

            return redirect()->route('dds-accounts.index')
                ->with('success', 'DDS Account created successfully!');
        } catch (\Exception $e) {
            Log::error("Store error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            dd("Error => " . $e->getMessage());
        }
    }

    public function edit(DdsAccount $ddaccount)
    {
        $members = Member::select('id', 'member_info_first_name', 'member_info_last_name', 'mobile_no')
            ->orderBy('member_info_first_name')
            ->get();
        $branches = Branch::all(); // or whatever query you need
        $members  = Member::all();


        return view('dds-accounts.edit', compact('ddaccount', 'members', 'branches'));
    }

    // public function edit($id)
    // {
    //     $ddaccount = DdsAccount::findOrFail($id);
    //     $members = Member::all();
    //     $branches = Branch::all();
    //     $schemes = Scheme::all();
    //     $minors = Minor::all();
    //     $savingAccounts = Account::where('account_type', 'saving')->get();

    //     return view('fd_account.ddsaccounts.create', compact(
    //         'ddaccount',
    //         'members',
    //         'branches',
    //         'schemes',
    //         'minors',
    //         'savingAccounts'
    //     ));
    // }
    public function update(Request $request, string $id)
    {
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
        $member = Member::with('branch')->findOrFail($id);

        return response()->json([
            'member_info_first_name' => $member->member_info_first_name,
            'member_info_last_name'  => $member->member_info_last_name,
            'member_address_line_1'  => $member->address->member_address_line_1 ?? '',
            'member_info_mobile_no'  => $member->member_info_mobile_no,
            'branch_id'   => $member->branch_id, // <-- हे पाठव
            'branch_name' => $member->branch->branch_name ?? '',
            'open_date'              => now()->format('Y-m-d'),
        ]);
    }

    public function updateMember(Request $request, DdsAccount $ddaccount)
    {
        $request->validate(['member_id' => 'required|exists:members,id']);
        $ddaccount->member_id = $request->member_id;
        $ddaccount->save();

        return back()->with('success', 'Member updated successfully');
    }

    public function updateBranch(Request $request, DdsAccount $ddaccount)
    {
        $request->validate(['branch_id' => 'required|exists:branches,id']);
        $ddaccount->branch_id = $request->branch_id;
        $ddaccount->save();

        return back()->with('success', 'Branch updated successfully');
    }

    function calculateMaturity($depositAmount, $installments, $frequency, $rate, $bonusRate = 0, $fixedBonus = 0, $startDate = null)
    {
        $totalDeposit = $depositAmount * $installments;
        $interest = 0;

        if ($frequency === 'daily') {
            $days = $installments;
            $interest = ($depositAmount * $days * ($days + 1) * $rate) / (2 * 100 * 365);
        } elseif ($frequency === 'monthly') {
            $months = $installments;
            $interest = ($depositAmount * $months * ($months + 1) * $rate) / (2 * 100 * 12);
        } elseif ($frequency === 'yearly') {
            $years = $installments;
            $interest = ($depositAmount * $years * ($years + 1) * $rate) / (2 * 100);
        }

        $interest = round($interest, 2);

        // bonus
        $bonus = 0;
        if ($bonusRate > 0) {
            $bonus = ($totalDeposit * $bonusRate) / 100;
        } elseif ($fixedBonus > 0) {
            $bonus = $fixedBonus;
        }

        $bonus = round($bonus, 2);

        $maturity = $totalDeposit + $interest + $bonus;

        // maturity date
        $maturityDate = null;
        if ($startDate) {
            $date = Carbon::parse($startDate);
            if ($frequency === 'daily') {
                $date->addDays($installments);
            } elseif ($frequency === 'monthly') {
                $date->addMonths($installments);
            } elseif ($frequency === 'yearly') {
                $date->addYears($installments);
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
        $ddsAccount = DdsAccount::with('member', 'branch', 'scheme')->findOrFail($id);

        // Apply filters
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
        $tranx = DdTransaction::findOrFail($id);
        $tranx->delete();

        return back()->with('success', 'Transaction deleted.');
    }
    public function transactionShow($accountId, $transactionId)
    {
        $ddsAccount  = DdsAccount::with('member', 'branch', 'scheme')->findOrFail($accountId);
        $transaction = DdTransaction::where('dds_account_id', $accountId)
            ->with('ddsAccount')
            ->findOrFail($transactionId);

        return view('fd_account.ddsaccounts.transaction-show', compact('ddsAccount', 'transaction'));
    }
}
