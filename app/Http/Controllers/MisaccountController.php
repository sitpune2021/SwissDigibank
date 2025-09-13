<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountNominee;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\FDAccount;
use App\Models\FDScheme;
use App\Models\Minor;
use App\Models\Misaccount;
use App\Models\Member;
use App\Models\MisTransaction;
use Exception;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class MisaccountController extends Controller
{
    public function index()
    {
        $misaccounts = MisAccount::orderBy('id','desc')->get();
        return view('fd_mis_account.misaccount.index', compact('misaccounts'));
    }

    public function create(Request $request)
    {

        $members = Member::with(['address', 'branch'])->get();
        $minors = Minor::all();
        $branches = Branch::all();
        $banks = Bank::all();
        $savingAccounts = Account::where('account_type', 'SAVING')->get();
        $schemes = FDScheme::all(); // fetch all FD schemes

        return view('fd_mis_account.misaccount.create', compact('members', 'minors', 'branches', 'banks', 'savingAccounts', 'schemes'));
    }

    public function getByMember($memberId)
    {
        $accounts = Account::where('member_id', $memberId)
            ->where('account_type', 'SAVING') // only saving accounts
            ->get();

        return response()->json($accounts);
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'member_id' => 'required|exists:members,id',
    //             'member_name' => 'nullable|string|max:255',
    //             'member_address' => 'nullable|string|max:500',
    //             'member_mobile' => 'nullable|string|max:15',
    //             'minor_id' => 'nullable|exists:minors,id',
    //             'branch_id' => 'required|exists:branches,id',
    //             'fd_scheme_id' => 'nullable|exists:fd_schemes,id',
    //             'advisor_id' => 'nullable|integer',
    //             'open_date' => 'required|date',
    //             'tenure_year' => 'nullable|integer|min:0',
    //             'tenure_month' => 'nullable|integer|min:0|max:12',
    //             'tenure_day' => 'nullable|integer|min:0|max:31',
    //             'mis_amount' => 'required|numeric|min:0',
    //             'interest_payout_type' => 'required|string|max:100',
    //             'tds_deduction' => 'required|in:yes,no',
    //             'senior_citizen' => 'required|in:yes,no',
    //             'account_type' => 'required|in:single,joint',
    //             'joint_member_id' => 'nullable|exists:members,id',
    //             'nominee' => 'required|in:yes,no',
    //             'final_amount' => 'nullable|integer|min:0',
    //             'transaction_date' => 'required|date',

    //             'amount' => 'required|numeric|min:1',
    //             'pay_mode' => 'required|in:cash,cheque,online,saving',
    //         ]);



    //         if ($request->account_type === 'joint') {
    //             if (!$request->joint_member_id) {
    //                 return back()->withInput()->withErrors(['joint_member_id' => 'Joint member is required for joint accounts.']);
    //             }
    //             $validated['joint_member_id'] = $request->joint_member_id;
    //         } else {
    //             $validated['joint_member_id'] = null;
    //         }

    //         $validated['open_date'] = Carbon::parse($validated['open_date'])->format('Y-m-d');
    //         $validated['transaction_date'] = Carbon::parse($validated['transaction_date'])->format('Y-m-d');
    //         $misaccount = Misaccount::create($validated);

    //         if ($request->nominee === 'yes' && $request->has('nominee_name')) {
    //             $totalNominees = count(array_filter($request->nominee_name));
    //             $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;
    //             foreach ($request->nominee_name as $key => $name) {
    //                 if (!empty($name)) {
    //                     $acc = AccountNominee::create([
    //                         'account_id' => "MIS-" . $misaccount->id,
    //                         'nominee_name' => $name,
    //                         'nominee_relation' => $request->nominee_relation[$key] ?? null,
    //                         'nominee_address' => $request->nominee_address[$key] ?? null,
    //                         'share_percentage' => $share ?? null,
    //                     ]);
    //                     //  dd($acc);

    //                 }
    //             }
    //             Log::info("Nomninees saved", ['count' => $totalNominees]);
    //         }

    //         $chequeDate = $request->cheque_date
    //             ? Carbon::parse($request->cheque_date)->format('Y-m-d')
    //             : null;

    //         $transferDate = $request->transfer_date
    //             ? Carbon::parse($request->transfer_date)->format('Y-m-d')
    //             : null;

    //         $calc = $this->calculateInvestment(
    //             'MIS',
    //             $request->mis_amount,
    //             $request->scheme->interest_rate ?? 8,
    //             ($request->tenure_year * 12) + $request->tenure_month,
    //             $request->date,
    //             $request->payout
    //         );

    //         $summary = $calc->getData(true)['summary']['summary'] ?? [];
    //         $transactionDate = $request->transaction_date
    //             ? Carbon::createFromFormat('D M d Y', $request->transaction_date)->format('Y-m-d')
    //             : null;

    //         MisTransaction::create([
    //             'misaccount_id' => $misaccount->id,
    //             'amount' => $request->amount,
    //             'pay_mode' => $request->pay_mode,
    //             'bank_id' => $request->bank_id ?? null,
    //             'cheque_no' => $request->cheque_no ?? null,
    //             'cheque_date' => $chequeDate,
    //             'transfer_date' => $transferDate,
    //             'utr_no' => $request->utr_no ?? null,
    //             'transfer_mode' => $request->transfer_mode ?? null,
    //             'saving_account_id' => $request->saving_account_id ?? null,

    //             // Store MIS calculated fields
    //             'monthly_interest' => $summary['net_interest'],
    //             'final_amount'          => isset($summary['final_amount'])
    //                 ? (float) str_replace(',', '', $summary['final_amount'])
    //                 : 0,
    //             'maturity_amount' => $summary['maturity_amount'],
    //             'maturity_date'         => Carbon::createFromFormat('d/m/Y', $summary['maturity_date'])->format('Y-m-d'),
    //         ]);


    //         return redirect()
    //             ->route('misaccount.index')
    //             ->with('success', 'MIS Account created successfully.');
    //     } catch (ValidationException $e) {
    //         return redirect()->back()
    //             ->withErrors($e->errors())
    //             ->withInput();
    //     } catch (Exception $e) {
    //         Log::error('MisAccount creation failed: ' . $e->getMessage());
    //         return redirect()->back()
    //             ->with('error', 'Something went wrong while creating MisAccount. Please try again.')
    //             ->withInput();
    //     }
    // }

    public function store(Request $request)
    {
        try {
            Log::info('MIS Account Store Request Received', $request->all());

            // Validate incoming request
            $validated = $request->validate([
                'member_id' => 'required|exists:members,id',
                'member_name' => 'nullable|string|max:255',
                'member_address' => 'nullable|string|max:500',
                'member_mobile' => 'nullable|string|max:15',
                'minor_id' => 'nullable|exists:minors,id',
                'branch_id' => 'required|exists:branches,id',
                'fd_scheme_id' => 'nullable|exists:fd_schemes,id',
                'advisor_id' => 'nullable|integer',
                'open_date' => 'required|date',
                'tenure_year' => 'nullable|integer|min:0',
                'tenure_month' => 'nullable|integer|min:0|max:12',
                'tenure_day' => 'nullable|integer|min:0|max:31',
                'mis_amount' => 'required|numeric|min:0',
                'interest_payout_type' => 'required|string|max:100',
                'tds_deduction' => 'required|in:yes,no',
                'senior_citizen' => 'required|in:yes,no',
                'account_type' => 'required|in:single,joint',
                'joint_member_id' => 'nullable|exists:members,id',
                'nominee' => 'required|in:yes,no',
                'nominee_name' => 'nullable|array',
                'nominee_relation' => 'nullable|array',
                'nominee_address' => 'nullable|array',
                'final_amount' => 'nullable|integer|min:0',
                'transaction_date' => 'required|date',
                'amount' => 'required|numeric|min:1',
                'pay_mode' => 'required|in:cash,cheque,online,saving',
            ]);

            Log::info('MIS Account Validated Data', $validated);

            // Handle joint accounts
            if ($request->account_type === 'joint' && !$request->joint_member_id) {
                return back()->withInput()->withErrors(['joint_member_id' => 'Joint member is required for joint accounts.']);
            }
            $validated['joint_member_id'] = $request->joint_member_id ?? null;

            // Format dates
            $validated['open_date'] = Carbon::parse($validated['open_date'])->format('Y-m-d');
            $validated['transaction_date'] = Carbon::parse($validated['transaction_date'])->format('Y-m-d');

            // --- Calculate MIS investment summary BEFORE inserting ---
            $calc = $this->calculateInvestment(
                'MIS',
                $request->mis_amount,
                $request->scheme->interest_rate ?? 8,
                ($request->tenure_year * 12) + $request->tenure_month,
                $request->date,
                $request->payout
            );

            $summary = $calc->getData(true)['summary']['summary'] ?? [];

            Log::info('MIS Summary Calculated', $summary);

            // Add calculated fields to validated data
            $validated['monthly_interest'] =  isset($summary['net_interest'])
                ? (float) str_replace(',', '', $summary['net_interest'])
                : 0;

            $validated['total_interest'] = isset($summary['interest_earned'])
                ? (float) str_replace(',', '', $summary['interest_earned'])
                : 0;

            $validated['final_amount'] = isset($summary['final_amount'])
                ? (float) str_replace(',', '', $summary['final_amount'])
                : 0;

            $validated['maturity_amount'] = isset($summary['maturity_amount'])
                ? (float) str_replace(',', '', $summary['maturity_amount'])
                : 0;

            $validated['maturity_date'] = isset($summary['maturity_date'])
                ? Carbon::createFromFormat('d/m/Y', $summary['maturity_date'])->format('Y-m-d')
                : null;

            // --- Create MIS account with all fields including calculated ---
            $misaccount = Misaccount::create($validated);
            Log::info('MIS Account Created', $misaccount->toArray());

            // --- Handle nominees ---
            if ($request->nominee === 'yes' && $request->has('nominee_name')) {
                $totalNominees = count(array_filter($request->nominee_name));
                $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (!empty($name)) {
                        AccountNominee::create([
                            'account_id' => "MIS-" . $misaccount->id,
                            'nominee_name' => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address' => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }
                Log::info('Nominees saved', ['count' => $totalNominees]);
            }

            // --- Format cheque & transfer dates ---
            $chequeDate = $request->cheque_date ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null;
            $transferDate = $request->transfer_date ? Carbon::parse($request->transfer_date)->format('Y-m-d') : null;

            // --- Create MIS Transaction ---
            MisTransaction::create([
                'misaccount_id' => $misaccount->id,
                'amount' => $request->amount,
                'pay_mode' => $request->pay_mode,
                'bank_id' => $request->bank_id ?? null,
                'cheque_no' => $request->cheque_no ?? null,
                'cheque_date' => $chequeDate,
                'transfer_date' => $transferDate,
                'utr_no' => $request->utr_no ?? null,
                'transfer_mode' => $request->transfer_mode ?? null,
                'saving_account_id' => $request->saving_account_id ?? null,
            ]);

            Log::info('MIS Transaction Created', ['misaccount_id' => $misaccount->id]);

            return redirect()
                ->route('misaccount.index')
                ->with('success', 'MIS Account created successfully.');
        } catch (ValidationException $e) {
            Log::warning('MIS Account Validation Failed', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            Log::error('MIS Account Store Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while creating MIS Account.')->withInput();
        }
    }


    function calculateInvestment(
        $type = null,
        $principal = null,
        $rate = null,
        $tenureMonths = null,
        $startDate = null,
        $payoutType = null
    ) {
        $results = [];

        $type         = $type ?? 'FD';
        $principal    = (float) ($principal ?? 120000);
        $rate         = (float) ($rate ?? 10);
        $tenureMonths = (int) ($tenureMonths ?? 12);
        $startDate    = $startDate ?? '2025-08-27';
        $payoutType   = strtoupper($payoutType ?? 'CUMULATIVE_HALF_YEARLY');

        $annualRate = $rate / 100;

        $currentDate    = Carbon::parse($startDate)->startOfDay();
        $maturityCarbon = Carbon::parse($startDate)->addMonths($tenureMonths)->startOfDay();

        $maturityDateInternal  = $maturityCarbon->format('Y-m-d');
        $maturityDate          = $maturityCarbon->format('d/m/Y');
        $depositStartInternal  = Carbon::parse($startDate)->startOfDay()->format('Y-m-d');

        $totalInterest = 0;
        $totalTDS      = 0;
        $maturityBonus = 0;

        $isCumulative = str_starts_with($payoutType, 'CUMULATIVE_');

        $cycleMonths = match ($payoutType) {
            'MONTHLY', 'CUMULATIVE_MONTHLY'             => 1,
            'QUARTERLY', 'CUMULATIVE_QUARTERLY'         => 3,
            'HALF_YEARLY', 'CUMULATIVE_HALF_YEARLY'     => 6,
            'YEARLY', 'CUMULATIVE_YEARLY'               => 12,
            default                                     => 1,
        };

        $cycleMonths = (int) $cycleMonths;

        while ($currentDate < $maturityCarbon) {
            $periodStart = $currentDate->copy()->startOfDay();
            $periodEnd   = $currentDate->copy()->addMonths($cycleMonths)->subDay()->startOfDay();

            if ($periodEnd > $maturityCarbon) {
                $periodEnd = $maturityCarbon->copy()->startOfDay();
            }

            // March 31 adjustment
            $marchYear = ($periodStart->month > 3) ? $periodStart->year + 1 : $periodStart->year;
            $marchEnd  = Carbon::createFromDate($marchYear, 3, 31)->startOfDay();

            if ($marchEnd >= $periodStart && $marchEnd <= $periodEnd) {
                [$results, $totalInterest, $principal] = $this->processPeriod(
                    $results,
                    $periodStart,
                    $marchEnd,
                    $principal,
                    $annualRate,
                    $maturityDateInternal,
                    $depositStartInternal,
                    $payoutType,
                    $totalInterest
                );

                $periodStart = $marchEnd->copy()->addDay(1)->startOfDay();

                [$results, $totalInterest, $principal] = $this->processPeriod(
                    $results,
                    $periodStart,
                    $periodEnd,
                    $principal,
                    $annualRate,
                    $maturityDateInternal,
                    $depositStartInternal,
                    $payoutType,
                    $totalInterest
                );
            } else {
                [$results, $totalInterest, $principal] = $this->processPeriod(
                    $results,
                    $periodStart,
                    $periodEnd,
                    $principal,
                    $annualRate,
                    $maturityDateInternal,
                    $depositStartInternal,
                    $payoutType,
                    $totalInterest
                );
            }

            $currentDate = $periodEnd->copy()->addDay(1)->startOfDay();
        }

        // ---- Final Summary ----
        $netInterest = $totalInterest - $totalTDS;
        $maturityAmt = $principal + $maturityBonus + $netInterest;

        $summary['summary'] = [
            'principal'       => number_format($principal, 2),
            'interest_earned' => number_format($totalInterest, 2),
            'tds_deducted'    => number_format($totalTDS, 2),
            'net_interest'    => number_format($netInterest, 2),
            'maturity_bonus'  => number_format($maturityBonus, 2),
            'maturity_amount' => number_format($maturityAmt, 2),
            'maturity_date'   => $maturityDate
        ];

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'details' => $results
        ]);
    }

    function processPeriod(
        $results,
        $periodStart,
        $periodEnd,
        $principal,
        $annualRate,
        $maturityDateInternal,
        $depositStartInternal,
        $payoutType,
        $totalInterest
    ) {
        $daysInYr = $periodStart->isLeapYear() ? 366 : 365;
        $current  = $periodStart->copy();

        $cumulativeTypes = ['CUMULATIVE', 'CUMULATIVE_MONTHLY', 'CUMULATIVE_HALF_YEARLY', 'YEARLY'];

        if (in_array($payoutType, $cumulativeTypes)) {
            while ($current < $periodEnd) {
                // determine next compounding boundary
                $next = match ($payoutType) {
                    'CUMULATIVE_MONTHLY'     => $current->copy()->addMonth(1),
                    'CUMULATIVE_HALF_YEARLY' => $current->copy()->addMonths(6),
                    'YEARLY'                 => $current->copy()->addYear(1),
                    default                  => $periodEnd->copy(),
                };

                if ($next > $periodEnd) $next = $periodEnd->copy();

                $days = (int) $current->diffInDays($next) + 1;

                $interest = ($principal * $annualRate * $days) / $daysInYr;
                $netInt   = round($interest, 2);

                $principal     += $netInt;
                $totalInterest += $netInt;

                $results[] = [
                    'period'           => $current->format('d/m/Y') . ' - ' . $next->format('d/m/Y'),
                    'days'             => $days,
                    'principal'        => round($principal - $netInt, 2),
                    'interest'         => $netInt,
                    'tds'              => 0.0,
                    'net_interest'     => $netInt,
                    'net_interest_due' => $netInt,
                    'principal_eoy'    => ($next->format('d/m') === '31/03') ? round($principal, 2) : '',
                    'due_by'           => $next->copy()->addDay(1)->format('d/m/Y'),
                    'maturity_amount'  => round($principal, 2),
                    'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
                ];

                $current = $next->copy()->addDay(1);
            }
        } else {
            // For payout types (non-cumulative like MIS)
            $next = match ($payoutType) {
                'MONTHLY'    => $periodStart->copy()->addMonth(1),
                'QUARTERLY'  => $periodStart->copy()->addMonths(3),
                'HALF_YEARLY' => $periodStart->copy()->addMonths(6),
                'YEARLY'     => $periodStart->copy()->addYear(1),
                default      => $periodEnd->copy(),
            };

            while ($periodStart < $periodEnd) {
                if ($next > $periodEnd) $next = $periodEnd->copy();

                $days     = (int) $periodStart->diffInDays($next) + 1;
                $interest = ($principal * $annualRate * $days) / $daysInYr;
                $netInt   = round($interest, 2);
                $totalInterest += $netInt;

                $results[] = [
                    'period'           => $periodStart->format('d/m/Y') . ' - ' . $next->format('d/m/Y'),
                    'days'             => $days,
                    'principal'        => $principal, // stays same in MIS
                    'interest'         => $netInt,
                    'tds'              => 0.0,
                    'net_interest'     => $netInt,
                    'net_interest_due' => $netInt,
                    'principal_eoy'    => ($next->format('d/m') === '31/03') ? $principal : '',
                    'due_by'           => $next->copy()->addDay(1)->format('d/m/Y'),
                    'maturity_amount'  => $principal + $totalInterest, // principal + all payouts
                    'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
                ];

                // Move to next payout cycle
                $periodStart = $next->copy()->addDay(1);
                $next = match ($payoutType) {
                    'MONTHLY'    => $periodStart->copy()->addMonth(1),
                    'QUARTERLY'  => $periodStart->copy()->addMonths(3),
                    'HALF_YEARLY' => $periodStart->copy()->addMonths(6),
                    'YEARLY'     => $periodStart->copy()->addYear(1),
                    default      => $periodEnd->copy(),
                };
            }
        }

        return [$results, $totalInterest, $principal];
    }


    public function edit(Misaccount $misaccount)
    {
        $members = Member::with(['address', 'branch'])->get();
        $minors = Minor::all();
        $branches = Branch::all();
        $banks = Bank::all();
        $savingAccounts = Account::where('account_type', 'SAVING')->get();
        $schemes = FdScheme::all();
        $misaccount->load(['transactions', 'nominees']);

        return view('fd_mis_account.misaccount.create', compact('members', 'minors', 'branches', 'banks', 'savingAccounts', 'schemes', 'misaccount'));
    }

    public function update(Request $request, Misaccount $misaccount)
    {
        try {
            Log::info('MIS Update started', [
                'misaccount_id' => $misaccount->id,
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'member_id' => 'required|exists:members,id',
                'branch_id' => 'required|exists:branches,id',
                'fd_scheme_id' => 'nullable|exists:fd_schemes,id',
                'open_date' => 'required|date',
                'tenure_year' => 'nullable|integer|min:0',
                'tenure_month' => 'nullable|integer|min:0|max:12',
                'tenure_day' => 'nullable|integer|min:0|max:31',
                'mis_amount' => 'required|numeric|min:0',
                'interest_payout_type' => 'nullable|string|max:100',
                'tds_deduction' => 'required|in:yes,no',
                'senior_citizen' => 'nullable|in:yes,no',
                'account_type' => 'required|in:single,joint',
                'joint_member_id' => 'nullable|exists:members,id',
                'nominee' => 'required|in:yes,no',
                'final_amount' => 'nullable|integer|min:0',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            $validated['open_date'] = Carbon::parse($validated['open_date'])->format('Y-m-d');

            // ✅ Update MIS account
            $misaccount->update($validated);
            Log::info('MIS Account updated', ['misaccount' => $misaccount->toArray()]);

            $chequeDate = $request->cheque_date
                ? Carbon::parse($request->cheque_date)->format('Y-m-d')
                : null;

            $transferDate = $request->transfer_date
                ? Carbon::parse($request->transfer_date)->format('Y-m-d')
                : null;

            // ✅ Always create new transaction
            $transaction = MisTransaction::create([
                'misaccount_id' => $misaccount->id,
                'amount' => $request->amount,
                'pay_mode' => $request->pay_mode,
                'bank_id' => $request->bank_id ?? null,
                'cheque_no' => $request->cheque_no ?? null,
                'cheque_date' => $chequeDate,
                'transfer_date' => $transferDate,
                'utr_no' => $request->utr_no ?? null,
                'transfer_mode' => $request->transfer_mode ?? null,
                'saving_account_id' => $request->saving_account_id ?? null,
            ]);

            Log::info('New MIS Transaction created', ['transaction' => $transaction->toArray()]);

            return redirect()
                ->route('misaccount.index')
                ->with('success', 'MIS Account updated successfully.');
        } catch (ValidationException $e) {
            Log::warning('Validation failed during MIS update', [
                'errors' => $e->errors()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('MIS Account update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Something went wrong while updating MisAccount. Please try again.')
                ->withInput();
        }
    }


    public function showMemberTransactions($memberId)
    {
        $transactions = MisTransaction::with(['misaccount', 'bank', 'savingAccount'])
            ->whereHas('misaccount', function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            })
            ->get();

        $member = Member::findOrFail($memberId);

        return view('fd_mis_account.misaccount.member-transactions', compact('transactions', 'member'));
    }

    public function show($id)
    {
        $misaccount = MisAccount::with(['member', 'transactions', 'fdScheme'])->findOrFail($id);

        $branches = Branch::all();

        $transactions = MisTransaction::with(['misaccount', 'bank', 'savingAccount'])
            ->whereHas('misaccount', function ($q) use ($misaccount) {
                $q->where('member_id', $misaccount->member_id);
            })
            ->get();

        $savingAccounts = Account::where('member_id', $misaccount->member_id)
            ->where('account_type', 'SAVING')
            ->get();

        return view('fd_mis_account.misaccount.show', compact('misaccount', 'savingAccounts', 'branches'));
    }

    //edit editBranch
    public function updateBranch(Request $request, $misaccountId)
    {
        $misaccount = Misaccount::findOrFail($misaccountId);

        // Validate branch_id
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Update branch
        $misaccount->branch_id = $request->branch_id;
        $misaccount->save();

        return redirect()->back()->with('success', 'Branch updated successfully.');
    }

    public function mispayoutplan()
    {
        $misaccounts = Misaccount::with('fdScheme')->get();

        // Fetch MIS accounts, optionally eager-load related models if needed
        $misaccounts = Misaccount::with(['member', 'fdScheme', 'branch'])->get();

        return view('misaccount.viewbuttons.mispayoutplan.mispayoutplan', compact('misaccounts'));
    }
}
