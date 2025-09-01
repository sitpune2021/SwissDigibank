<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\FdAccount;
use App\Models\FDScheme;
use App\Models\FdSchemeSlab;
use App\Models\FdTransaction;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FDController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');

        $fdSchemes = FDScheme::with('fdslabs')
            ->when($search, function ($query, $search) {
                $query->where('scheme_name', 'like', "%{$search}%")
                    ->orWhere('scheme_code', 'like', "%{$search}%")
                    ->orWhere('min_amount', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('fd_mis_account.fd_scheme.index', compact('fdSchemes', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fd_mis_account.fd_scheme.add-scheme');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'scheme_name'          => 'required|string|max:255',
                'scheme_code'          => 'required|string|max:255',
                'min_amount'           => 'required|numeric|min:0',
                'lock_in_period'       => 'required|integer|min:0',
                'interest_lock_in'     => 'required|integer|min:0',
                'bonus_rate'           => 'nullable|numeric|min:0',
                'bonus_type'           => 'nullable|in:percentage,fixed',
                'cancellation_charge'  => 'nullable|numeric|min:0',
                'cancellation_type'    => 'nullable|in:percent,fixed',
                'penal_charge'         => 'nullable|numeric|min:0',
                'effective_date'       => 'required|date',
                'stationary_fee'       => 'nullable|numeric|min:0',
                'is_active'            => 'nullable|integer|in:0,1',

                'rows.*.day_from'        => 'nullable|integer|min:0',
                'rows.*.day_to'          => 'nullable|integer|min:0',
                'rows.*.interest_rate'   => 'nullable|numeric|min:0',
                'rows.*.sr_citizen_rate' => 'nullable|numeric|min:0',
                'rows.*.payout_type'     => 'nullable|string',
            ]);

            $validated['effective_date'] = \Carbon\Carbon::parse($request->effective_date)->format('Y-m-d');
            $validated['admin']     = $request->has('admin') ? 1 : 0;
            $validated['associate'] = $request->has('associate') ? 1 : 0;
            $validated['member']    = $request->has('member') ? 1 : 0;

            DB::beginTransaction();

            $scheme = FdScheme::create($validated);

            if ($request->has('rows')) {
                foreach ($request->rows as $row) {
                    if (
                        empty($row['day_from']) &&
                        empty($row['day_to']) &&
                        empty($row['interest_rate'])
                    ) {
                        continue;
                    }

                    FdSchemeSlab::create([
                        'fd_scheme_id'    => $scheme->id,
                        'day_from'        => $row['day_from'] ?? 0,
                        'day_to'          => $row['day_to'] ?? 0,
                        'interest_rate'   => $row['interest_rate'] ?? 0,
                        'sr_citizen_rate' => $row['sr_citizen_rate'] ?? 0,
                        'payout_type'     => $row['payout_type'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('fd-mis-schemes.index')
                ->with('success', 'FD Scheme created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log for debugging
            Log::error('FD Scheme Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong while creating FD Scheme. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fdScheme = FDScheme::with('fdslabs')->findOrFail($id);
        foreach ($fdScheme->fdslabs as $slab) {
            if (!empty($slab->day_from) && !empty($slab->day_to)) {
                $from = Carbon::now()->addDays($slab->day_from);
                $to   = Carbon::now()->addDays($slab->day_to);
                $slab->months = $from->diffInMonths($to);
            } else {
                $slab->months = null;
            }
        }
        return view('fd_mis_account.fd_scheme.view-scheme', compact('fdScheme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fdScheme = FDScheme::with('fdslabs')->findOrFail($id);
        return view('fd_mis_account.fd_scheme.add-scheme', compact('fdScheme'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'scheme_name'      => 'required|string|max:255',
            'scheme_code'      => 'required|string|max:50',
            'min_amount'       => 'required|numeric',
            'lock_in_period'   => 'required|integer',
            'interest_lock_in' => 'required|integer',
            'bonus_rate'       => 'nullable|numeric',
            'effective_date'   => 'required|date',
            'active'           => 'required|boolean',
        ]);

        $fdScheme = FDScheme::findOrFail($id);

        $data = $request->all();
        $data['admin']     = $request->has('admin') ? 1 : 0;
        $data['associate'] = $request->has('associate') ? 1 : 0;

        $fdScheme->update($data);

        if ($request->has('rows')) {
            $fdScheme->fdslabs()->delete();
            foreach ($request->rows as $row) {
                if (!empty($row['day_from']) && !empty($row['day_to'])) {
                    $fdScheme->fdslabs()->create($row);
                }
            }
        }

        return redirect()->route('fd-mis-schemes.index')
            ->with('success', 'FD Scheme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function fd_index()
    {
        $accounts = FdAccount::with('member', 'branch') // eager load relations if needed
            ->orderBy('id', 'desc')
             ->paginate(10);

        // dd( $accounts);
        return view('fd_mis_account.fd-account.index', compact('accounts'));
    }

    public function fd_create()
    {
        $members = Member::all();
        $schemes = FDScheme::all();
        $savings = Account::with('members')->get();

        $membersData = Member::with('address', 'minors', 'branch')->get()
            ->mapWithKeys(function ($m) {
                return [
                    $m->id => [
                        'first_name' => $m->member_info_first_name,
                        'last_name'  => $m->member_info_last_name ?? '',
                        'mobile'     => $m->member_info_mobile_no,
                        'address'    => $m->address->member_address_line_1 ?? '',
                        'branch_id'  => $m->branch ?? [],
                        'minors'     => $m->minors ?? [],
                    ]
                ];
            });
        // dd($membersData);
        return view('fd_mis_account.fd-account.add_account', compact('members', 'membersData', 'schemes', 'savings'));
    }

    public function fd_store(Request $request)
    {
        try {
            Log::info('FD/MIS Store request started', ['data' => $request->all()]);

            $validated = $request->validate([
                'member_id'       => 'required|exists:members,id',
                'branch_id'       => 'required|integer|exists:branches,id',
                'advisor_staff'   => 'nullable|integer',
                'date'            => 'required|date',
                // 'tenure_year'     => 'required|integer|min:0',
                // 'tenure_month'    => 'required|integer|min:0',
                // 'tenure_day'      => 'required|integer|min:0',
                'fd_amount'       => 'required|numeric|min:1',
                'payout'          => 'nullable|string',
                'tds_decution'    => 'nullable|string',
                'senior_citizen'  => 'nullable|string',
                'account_type'    => 'required|string',
                'scheme_id'       => 'required|exists:fd_schemes,id',

                'final_amount'    => 'nullable|numeric|min:1',
                'transaction_date' => 'nullable|date',

                // ✅ Nominees
                'nominees'        => 'nullable|in:yes,no',
                'nominee_name'    => 'array',
                'nominee_name.*'  => 'nullable|string|max:255',
                'nominee_relation.*' => 'nullable|string|max:255',
                'nominee_address.*'  => 'nullable|string|max:500',

                // ✅ Payment (single)
                'pay1_amount'     => 'required|numeric|min:1',
                'pay1_mode'       => 'required|string|in:cash,cheque,online,saving',

                // If cheque
                'pay1_bank'       => 'nullable|required_if:pay1_mode,cheque|string|max:255',
                'pay1_cheque_no'  => 'nullable|required_if:pay1_mode,cheque|string|max:255',
                'pay1_cheque_date' => 'nullable|required_if:pay1_mode,cheque|date',

                // If online transfer
                'pay1_transfer_date' => 'nullable|required_if:pay1_mode,online|date',
                'pay1_transfer_utr'  => 'nullable|required_if:pay1_mode,online|string|max:255',
                'transferMode'       => 'nullable|required_if:pay1_mode,online|string|in:imps,vpa,neft,upi',
                'credited'           => 'nullable|required_if:pay1_mode,online|in:yes,no',

                'saving_account'     => 'nullable|required_if:pay1_mode,saving|string|max:255',
            ]);
            Log::info('Validation passed', ['validated' => $validated]);

            DB::beginTransaction();

            Log::info('Transaction started');

            $calc = $this->calculateInvestment(
                'FD',
                $request->fd_amount,
                $request->scheme->interest_rate ?? 8,  // you can also fetch from fd_schemes table
                ($request->tenure_year * 12) + $request->tenure_month,
                $request->date,
                $request->payout
            );

            $summary = $calc->getData(true)['summary']['summary'] ?? [];
            // dd($summary);
            $transactionDate = $request->transaction_date
                ? Carbon::createFromFormat('D M d Y', $request->transaction_date)->format('Y-m-d')
                : null;

            $fdAccount = FdAccount::create([
                'member_id'             => $request->member_id,
                'branch_id'             => $request->branch_id,
                'minor_id'              => $request->minor_id,
                'staff_id'              => $request->advisor_staff,
                'open_date'             => $request->date ? Carbon::parse($request->date)->format('Y-m-d') : null,
                'tenure_year'           => $request->tenure_year,
                'tenure_month'          => $request->tenure_month,
                'tenure_days'           => $request->tenure_day,
                'fd_amount'             => $request->fd_amount,
                'interest_payout_type'  => $request->payout,
                'tds_deduction'         => $request->tds_deduction,
                'senior_citizen'        => $request->senior_citizen,
                'account_type'          => $request->account_type,
                // 'final_amount'          => $request->final_amount,
                'scheme_id'          => $request->scheme_id,
                'transaction_date'      => $transactionDate,
                'joint_member_id'       => $request->account_type === 'joint' ? $request->joint_member_id : null,

                'final_amount'          => isset($summary['final_amount'])
                    ? (float) str_replace(',', '', $summary['final_amount'])
                    : 0,
                'maturity_date'         => Carbon::createFromFormat('d/m/Y', $summary['maturity_date'])->format('Y-m-d'),
            ]);
            Log::info('FD Account created', ['fd_account_id' => $fdAccount->id]);

            if ($request->nominees === "yes" && $request->has('nominee_name')) {
                $totalNominees = count(array_filter($request->nominee_name));
                $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (!empty($name)) {
                        AccountNominee::create([
                            'account_id'       => "FD-" . $fdAccount->id,
                            'nominee_name'     => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address'  => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }
                Log::info('Nominees saved', ['count' => $totalNominees]);
            }

            $fdTransaction = FdTransaction::create([
                'fd_account_id'   => $fdAccount->id,
                'transaction_date' => $request->pay1_transfer_date
                    ? Carbon::parse($request->pay1_transfer_date)->format('Y-m-d')
                    : now(),
                'amount'          => $request->pay1_amount,
                'mode'            => $request->pay1_mode,
                'bank'            => $request->pay1_bank ?? null,
                'cheque_no'       => $request->pay1_cheque_no ?? null,
                'cheque_date'     => $request->pay1_cheque_date ? Carbon::parse($request->pay1_cheque_date) : null,
                'transfer_date'   => $request->pay1_transfer_date ? Carbon::parse($request->pay1_transfer_date) : null,
                'transaction_no'  => $request->pay1_transfer_utr ?? null,
                'transfer_mode'   => $request->transferMode ?? null,
                'credited'        => $request->credited === "yes" ? true : false,
                'saving_account'  => $request->saving_account ?? null,
            ]);
            Log::info('FD Transaction saved', ['transaction_id' => $fdTransaction->id]);

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('fd-mis-schemes.fd_index')
                ->with('success', 'FD/MIS account opened successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {

            Log::error('FD Store validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('FD Store failed', ['error' => $ex->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong: ' . $ex->getMessage());
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
            $days     = (int) $periodStart->diffInDays($periodEnd) + 1;
            $interest = ($principal * $annualRate * $days) / $daysInYr;
            $netInt   = round($interest, 2);
            $totalInterest += $netInt;

            $results[] = [
                'period'           => $periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'),
                'days'             => $days,
                'principal'        => round($principal, 0),
                'interest'         => $netInt,
                'tds'              => 0.0,
                'net_interest'     => $netInt,
                'net_interest_due' => $netInt,
                'principal_eoy'    => ($periodEnd->format('d/m') === '31/03') ? $principal : '',
                'due_by'           => $periodEnd->copy()->addDay(1)->format('d/m/Y'),
                'maturity_amount'  => $principal + $totalInterest,
                'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
            ];
        }

        return [$results, $totalInterest, $principal];
    }
    // AccountController.php
    public function getBalance($id)
    {

        $account = Account::find($id);

        if ($account) {
            return response()->json(['balance' => $account->balance]);
        } else {
            return response()->json(['balance' => 0]);
        }
    }

    public function fd_show(string $id)
    {
        $fdAccount = FdAccount::with(['member.address', 'branch','fdscheme.fdslabs'])->findOrFail($id);

        return view('fd_mis_account.fd-account.view', compact('fdAccount'));
    }

    public function getMemberSavings($member_id)
    {
        try {
            $savings = Account::where('member_id', $member_id)->get();

            return response()->json([
                'status' => 'success',
                'data' => $savings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
