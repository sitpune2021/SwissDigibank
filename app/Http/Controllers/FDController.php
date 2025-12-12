<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\Branch;
use App\Models\FdAccount;
use App\Models\Bank;
use App\Models\FDScheme;
use App\Models\FdSchemeSlab;
use App\Models\FdTransaction;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Helpers\TransactionHelper;
use App\Models\Minor;
use App\Models\Comments;
use App\Models\Document;
use App\Models\Passbook;
use App\Helpers\AccountsTransactionsHelper;


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
    public function store(Request $request)
    {
        try {
            Log::info('FD Scheme Store initiated.', ['user_id' => auth()->id(), 'request_data' => $request->all()]);

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

            Log::info('FD Scheme validation passed.');

            $validated['effective_date'] = Carbon::parse($request->effective_date)->format('Y-m-d');
            $validated['admin']     = $request->has('admin') ? 1 : 0;
            $validated['associate'] = $request->has('associate') ? 1 : 0;
            $validated['member']    = $request->has('member') ? 1 : 0;

            DB::beginTransaction();

            $scheme = FdScheme::create($validated);
            Log::info('FD Scheme created successfully.', ['scheme_id' => $scheme->id, 'scheme_name' => $scheme->scheme_name]);

            if ($request->has('rows')) {
                foreach ($request->rows as $index => $row) {
                    if (
                        empty($row['day_from']) &&
                        empty($row['day_to']) &&
                        empty($row['interest_rate'])
                    ) {
                        Log::warning("Skipping slab row {$index} due to missing values.", ['row_data' => $row]);
                        continue;
                    }

                    $slab = FdSchemeSlab::create([
                        'fd_scheme_id'    => $scheme->id,
                        'day_from'        => $row['day_from'] ?? 0,
                        'day_to'          => $row['day_to'] ?? 0,
                        'interest_rate'   => $row['interest_rate'] ?? 0,
                        'sr_citizen_rate' => $row['sr_citizen_rate'] ?? 0,
                        'payout_type'     => $row['payout_type'] ?? null,
                    ]);

                    Log::info("FD Scheme Slab created.", [
                        'scheme_id' => $scheme->id,
                        'slab_id'   => $slab->id,
                        'row_data'  => $row
                    ]);
                }
            }

            DB::commit();

            Log::info('FD Scheme Store transaction committed successfully.', [
                'scheme_id' => $scheme->id,
                'created_by' => Auth::id()
            ]);

            return redirect()
                ->route('fd-mis-schemes.index')
                ->with('success', 'FD Scheme created successfully!');
        } catch (ValidationException $e) {
            Log::warning('FD Scheme validation failed.', [
                'errors' => $e->errors(),
                'input'  => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('FD Scheme Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'user_id' => Auth::id()
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

        return view('fd_mis_account.fd-account.index', compact('accounts'));
    }

    public function fd_create()
    {
        $members = Member::all();
        $schemes = FDScheme::all();
        $savings = Account::with('members')->get();
        $banks = Bank::all(); // assuming you have a Bank model

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

        return view('fd_mis_account.fd-account.add_account', compact('members', 'membersData', 'schemes', 'savings', 'banks'));
    }

    public function fd_store(Request $request)
    {
        Log::info('📌 FD/MIS Store Request Initiated', [
            'request_payload' => $request->all()
        ]);

        try {
            // ---------------------------- VALIDATION ----------------------------
            Log::info('🔍 Validating request data...');

            $validated = $request->validate([
                'member_id'       => 'required|exists:members,id',
                'branch_id'       => 'required|integer|exists:branches,id',
                'advisor_staff'   => 'nullable|integer',
                'date'            => 'required|date',
                'tenure_year'     => 'required|integer|min:0',
                'tenure_month'    => 'required|integer|min:0',
                'tenure_day'      => 'required|integer|min:0',
                'fd_amount'       => 'required|numeric|min:1',
                'payout'          => 'nullable|string',
                'tds_deduction'    => 'nullable|string',
                'senior_citizen'  => 'nullable|string',
                'account_type'    => 'required|string',
                'scheme_id'       => 'required|exists:fd_schemes,id',
                'final_amount'    => 'nullable|numeric|min:1',
                'transaction_date' => 'nullable|date',
                'joint_member_id' => 'required_if:account_type,joint|nullable|integer|exists:members,id',

                // Nominees
                'nominees'        => 'nullable|in:yes,no',
                'nominee_name.*'  => 'nullable|string|max:255',
                'nominee_relation.*' => 'nullable|string|max:255',
                'nominee_address.*'  => 'nullable|string|max:500',

                // Payment
                'pay1_amount'     => 'required|numeric|min:1',
                'pay1_mode'       => 'required|string|in:cash,cheque,online,saving',

                // Cheque
                'pay1_bank'       => 'nullable|required_if:pay1_mode,cheque|string|max:255',
                'pay1_cheque_no'  => 'nullable|required_if:pay1_mode,cheque|string|max:255',
                'pay1_cheque_date' => 'nullable|required_if:pay1_mode,cheque|date',

                // Online
                'pay1_transfer_date' => 'nullable|required_if:pay1_mode,online|date',
                'pay1_transfer_utr'  => 'nullable|required_if:pay1_mode,online|string|max:255',
                'transferMode'       => 'nullable|required_if:pay1_mode,online|string|in:imps,vpa,neft,upi',
                // 'transaction_type'    => 'nullable|required_if:pay1_mode,online|in:yes,no',
                // 'transaction_type' => 'nullable|in:credit,debit',
                'transaction_type' => 'nullable|required_if:pay1_mode,online|in:credit,debit',


                'saving_account'     => 'nullable|required_if:pay1_mode,saving|string|max:255',
            ]);

            Log::info('✔ Validation Successful', ['validated_data' => $validated]);

            DB::beginTransaction();
            Log::info('🟡 Database Transaction Started');

            // ---------------------------- CALCULATION ----------------------------
            Log::info('🧮 Calculating FD Maturity...');

            $calc = $this->calculateInvestment(
                'FD',
                $request->fd_amount,
                $request->scheme->interest_rate ?? 8,
                ($request->tenure_year * 12) + $request->tenure_month,
                $request->date,
                $request->payout
            );

            $summary = $calc->getData(true)['summary']['summary'] ?? [];

            // ---------------------------- FD ACCOUNT CREATE ----------------------------
            Log::info('📝 Creating FD Account...');

            $transactionDate = $request->transaction_date
                ? Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d')
                : null;

            $fdAccount = FdAccount::create([
                'member_id'     => $request->member_id,
                'account_no'    => rand(100000, 999999),
                'branch_id'     => $request->branch_id,
                'minor_id'      => $request->minor_id,
                'staff_id'      => $request->advisor_staff,
                'open_date'     => Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
                'tenure_year'   => $request->tenure_year,
                'tenure_month'  => $request->tenure_month,
                'tenure_days'   => $request->tenure_day,
                'fd_amount'     => $request->fd_amount,
                'interest_payout_type'  => $request->payout,
                'tds_deduction' => $request->tds_deduction,
                'senior_citizen' => $request->senior_citizen ?? 0,
                'account_type'  => $request->account_type,
                'payment_mode'  => $request->pay1_mode,
                'scheme_id'     => $request->scheme_id,
                'transaction_date' => $transactionDate,
                'joint_member_id'  => $request->account_type === 'joint' ? $request->joint_member_id : null,

                'amount'     => isset($summary['amount']) ? (float) str_replace(',', '', $summary['amount']) : 0,
                'maturity_amount'  => isset($summary['maturity_amount']) ? (float) str_replace(',', '', $summary['maturity_amount']) : 0,
                'total_interest'   => isset($summary['interest_earned']) ? (float) str_replace(',', '', $summary['interest_earned']) : 0,
                'monthly_interest' => 0,
                'maturity_date'    => isset($summary['maturity_date'])
                    ? Carbon::createFromFormat('d-m-Y', $summary['maturity_date'])->format('Y-m-d')
                    : null,
            ]);

            Log::info('✔ FD Account Created', [
                'fd_account_id' => $fdAccount->id,
                'fd_account_no' => $fdAccount->account_no
            ]);

            $fdAccount->account_no = 'SA' . str_pad($fdAccount->id, 5, '0', STR_PAD_LEFT);
            $fdAccount->fd_no = 'FD' . str_pad($fdAccount->id, 5, '0', STR_PAD_LEFT);
            $fdAccount->save();

            Log::info('🔄 FD Account Number Updated', [
                'final_account_no' => $fdAccount->account_no,
                'final_fd_no'      => $fdAccount->fd_no
            ]);

            // ---------------------------- SMS ----------------------------
            try {
                Log::info('📨 Sending SMS...');

                $fdaccount = FdAccount::with('member')->find($fdAccount->id);
                $mobile = $fdaccount->member->member_info_mobile_no;

                $msg = "Dear Customer, we have received your request for opening Fixed Deposit. Your temp. FD a/c no. is $fdaccount->fd_no. SBC GLOBAL";

                \App\Helpers\SmsHelper::sendSms($mobile, $msg, 1707172234112046638);

                Log::info('✔ SMS Sent Successfully', ['mobile' => $mobile]);
            } catch (\Exception $smsError) {
                Log::error('❌ SMS Sending Failed', ['error' => $smsError->getMessage()]);
            }

            // ---------------------------- NOMINEES ----------------------------
            if ($request->nominees === "yes" && $request->has('nominee_name')) {

                Log::info('👤 Saving Nominees...');

                $totalNominees = count(array_filter($request->nominee_name));
                $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (!empty($name)) {
                        AccountNominee::create([
                            // 'account_id'       => "FD-" . $fdAccount->id,
                            'account_id'       => $fdAccount->id,
                            'nominee_name'     => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address'  => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }

                Log::info('✔ Nominees Saved', ['total_nominees' => $totalNominees]);
            }

            // ---------------------------- TRANSACTION ----------------------------
            Log::info('💰 Creating FD Transaction...');
            // dd($request->transaction_type);
            $fdTransaction = FdTransaction::create([
                'fd_account_id'   => $fdAccount->id,
                'transaction_date' => $request->pay1_transfer_date
                    ? Carbon::createFromFormat('d-m-Y', $request->pay1_transfer_date)->format('Y-m-d')
                    : now(),
                'amount'          => $request->pay1_amount,
                'mode'            => $request->pay1_mode,
                'bank'            => $request->pay1_bank ?? null,
                'cheque_no'       => $request->pay1_cheque_no ?? null,
                'cheque_date'     => $request->pay1_cheque_date ? Carbon::parse($request->pay1_cheque_date) : null,
                'transfer_date'   => $request->pay1_transfer_date ? Carbon::createFromFormat('d-m-Y', $request->pay1_transfer_date) : null,
                'transaction_no'  => $request->pay1_transfer_utr ?? null,
                'transfer_mode'   => $request->transferMode ?? null,
                'transaction_type' => 1,
                'saving_account'  => $request->saving_account ?? null,
            ]);

            Log::info('✔ FD Transaction Saved', [
                'transaction_id' => $fdTransaction->id,
                'amount' => $fdTransaction->amount
            ]);

            DB::commit();
            Log::info('🟢 FD/MIS Successfully Saved & Transaction Committed');

            return redirect()->route('fd-mis-schemes.fd_index')
                ->with('success', 'Please approve status!');
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('❌ FD Store Failed', [
                'error_message' => $ex->getMessage(),
                'line'          => $ex->getLine(),
                'file'          => $ex->getFile(),
            ]);

            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $ex->getMessage());
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
        $maturityDate          = $maturityCarbon->format('d-m-Y');
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

    // public function fd_show(string $id)
    // {
    //     $fdAccount = FdAccount::with(['member.address', 'branch', 'transactions', 'fdscheme.fdslabs', 'savingAccount'])->findOrFail($id);
    //     $documents = Document::where('fd_id', $fdAccount->id)->get();
    //     $passbooks = Passbook::where('account_type', 'MIS Accounts')
    //         ->where('account_no', $fdAccount->id)
    //         ->get();
    //     $fdSlabs = FdSchemeSlab::where('fd_scheme_id', $fdAccount->scheme_id)->get();
    //     $branches = Branch::all();
    //     $calculation = $this->calculateFdMaturity($fdAccount);
    //     $linkedSavingAcc = Account::find($fdAccount->saving_account_id);
    //     $fdBalances = AccountsTransactionsHelper::getFdAccountBalance($fdAccount->id);
    //     $fdBalance  = $fdBalances[$fdAccount->id] ?? 0;
    //     $balances = [];
    //     if ($linkedSavingAcc) {
    //         $bal = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec($linkedSavingAcc->id);
    //         $balances[$linkedSavingAcc->id] = $bal['total_balance'] ?? 0;
    //     }

    //     return view('fd_mis_account.fd-account.view', array_merge(
    //         [
    //             'fdAccount' => $fdAccount,
    //             'fdSlabs'   => $fdSlabs,
    //             'branches'  => $branches,
    //             'link_status' => $fdAccount->link_status,
    //             'linkedSavingAcc' => $linkedSavingAcc,
    //             'balances' => $balances,
    //             'fdBalance' => $fdBalance, // Pass FD balance to Blade

    //             'documents' => $documents,
    //             'passbooks' => $passbooks,
    //         ],
    //         $calculation
    //     ));
    // }

    public function fd_show(string $id)
    {
        $fdAccount = FdAccount::with([
            'member.address',
            'branch',
            'transactions',
            'fdscheme.fdslabs',
            'savingAccount'
        ])->findOrFail($id);

        $documents = Document::where('fd_id', $fdAccount->id)->get();
        $passbooks = Passbook::where('account_type', 'MIS Accounts')
            ->where('account_no', $fdAccount->id)
            ->get();

        $fdSlabs = FdSchemeSlab::where('fd_scheme_id', $fdAccount->scheme_id)->get();
        $branches = Branch::all();
        $calculation = $this->calculateFdMaturity($fdAccount);

        // ✅ Get FD balance in controller
        $fdBalances = AccountsTransactionsHelper::getFdAccountBalance($fdAccount->id);
        $fdBalance  = $fdBalances[$fdAccount->id] ?? 0;

        $linkedSavingAcc = Account::find($fdAccount->saving_account_id);
        $balances = [];
        if ($linkedSavingAcc) {
            $bal = AccountsTransactionsHelper::getAccountBalacec($linkedSavingAcc->id);
            $balances[$linkedSavingAcc->id] = $bal['total_balance'] ?? 0;
        }

        return view('fd_mis_account.fd-account.view', array_merge(
            [
                'fdAccount' => $fdAccount,
                'fdSlabs'   => $fdSlabs,
                'branches'  => $branches,
                'link_status' => $fdAccount->link_status,
                'linkedSavingAcc' => $linkedSavingAcc,
                'balances' => $balances,
                'fdBalance' => $fdBalance, // Pass FD balance to Blade
                'documents' => $documents,
                'passbooks' => $passbooks,
            ],
            $calculation
        ));
    }

    private function calculateFdMaturity($fdAccount)
    {
        $principal = $fdAccount->fd_amount;

        $years  = $fdAccount->tenure_year ?? 0;
        $months = $fdAccount->tenure_month ?? 0;
        $days   = $fdAccount->tenure_days ?? 0;

        $tenureDays = ($years * 365) + ($months * 30) + $days;

        $fdAnnualIntrest = null;

        if ($tenureDays > 0) {
            $slab = FdSchemeSlab::where('fd_scheme_id', $fdAccount->scheme_id)
                ->where('day_from', '<=', $tenureDays)
                ->where('day_to', '>=', $tenureDays)
                ->first();

            if ($slab) {
                if (!empty($fdAccount->senior_citizen) && $fdAccount->senior_citizen == 1) {
                    $fdAnnualIntrest = $slab->sr_citizen_rate;
                } else {
                    $fdAnnualIntrest = $slab->interest_rate;
                }
            }
        }

        $timeInYears = (($years * 360) + ($months * 30) + $days) / 360;

        $totalInterest = ($principal * $fdAnnualIntrest * $timeInYears) / 100;

        $exemption = $fdAccount->senior_citizen ? 50000 : 40000;
        $tds = ($totalInterest > $exemption) ? $totalInterest * 0.10 : 0;

        $bonus = 0;
        if (!is_null($fdAccount->fdscheme->bonus_rate)) {
            $bonusRate = $fdAccount->fdscheme->bonus_rate;
            $bonusType = $fdAccount->fdscheme->bonus_type ?? 'percentage';

            if ($bonusType === 'percentage') {
                $bonus = ($principal * $bonusRate) / 100;
            } elseif ($bonusType === 'fixed') {
                $bonus = $bonusRate;
            }
        }

        $maturityAmount = $principal + $totalInterest + $bonus;
        $netMaturityAmount = $maturityAmount - $tds;

        return [
            'fdAnnualIntrest'   => $fdAnnualIntrest,
            'totalInterest'     => $totalInterest,
            'tds'               => $tds,
            'bonus'             => $bonus,
            'maturityAmount'    => $maturityAmount,
            'netMaturityAmount' => $netMaturityAmount,
        ];
    }
    public function updateBranch(Request $request, $id)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);

        $fdAccount = FdAccount::findOrFail($id);
        $fdAccount->branch_id = $request->branch_id;
        $fdAccount->save();

        return redirect()->back()->with('success', 'Branch updated successfully!');
    }

    public function getBalance($id)
    {

        $account = Account::find($id);

        if ($account) {
            return response()->json(['balance' => $account->balance]);
        } else {
            return response()->json(['balance' => 0]);
        }
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


    public function fdPayout($id)
    {
        $fdAccount = FdAccount::with(['member.address', 'branch', 'fdscheme.fdslabs'])
            ->findOrFail($id);

        $totalDays = ($fdAccount->tenure_year * 365)
            + ($fdAccount->tenure_month * 30)
            + $fdAccount->tenure_days;

        $slab = $fdAccount->fdscheme->fdslabs
            ->where('day_from', '<=', $totalDays)
            ->where('day_to', '>=', $totalDays)
            ->first();

        $principal = $fdAccount->fd_amount;
        $rate      = $slab->interest_rate ?? 0;

        $startDate    = \Carbon\Carbon::parse($fdAccount->open_date);
        $maturityDate = \Carbon\Carbon::parse($fdAccount->maturity_date);

        $transactions = FdTransaction::where('fd_account_id', $id)->get()
            ->keyBy(fn($item) => \Carbon\Carbon::parse($item->due_date)->format('Y-m-d'));

        $payouts = [];
        $period = 1;
        $currentFrom = $startDate->copy();
        $openDay = $startDate->day;

        while ($currentFrom->lt($maturityDate)) {

            // Default: 1 month
            $currentTo = $currentFrom->copy()->addMonth()->subDay();

            // 🔹 Case 1: If period crosses March 31 — stop at 31 Mar
            if (
                ($currentFrom->month == 3 && $currentTo->month == 4) ||
                ($currentTo->month == 3 && $currentTo->day == 31) ||
                ($currentTo->gt(\Carbon\Carbon::create($currentFrom->year, 3, 31)) &&
                    $currentFrom->lte(\Carbon\Carbon::create($currentFrom->year, 3, 31)))
            ) {
                $currentTo = \Carbon\Carbon::create($currentFrom->year, 3, 31);
            }

            // 🔹 Case 2: April short period (01 Apr → openDay - 1)
            elseif ($currentFrom->month == 4 && $currentFrom->day == 1) {
                $endDay = $openDay - 1;
                $currentTo = \Carbon\Carbon::create($currentFrom->year, 4, $endDay);
            }

            // Do not exceed maturity date
            if ($currentTo->gt($maturityDate)) {
                $currentTo = $maturityDate->copy();
            }

            $days = $currentFrom->diffInDays($currentTo) + 1;

            // 💰 Interest calculation
            $interest = round(($principal * $rate * $days) / (365 * 100), 2);
            $tds = 0;
            $net = $interest - $tds;

            // 📅 Due date (next day unless maturity)
            $dueDate = $currentTo->copy()->addDay();
            if ($currentTo->eq($maturityDate)) {
                $dueDate = $currentTo->copy();
            }

            $transaction = $transactions->get($dueDate->format('Y-m-d'));

            // 🧾 Special case: if period ends on 31 March → blank due date + blank net interest on due date
            if ($currentTo->month == 3 && $currentTo->day == 31) {
                $dueDateDisplay = '';
                $netInterestOnDueDate = '';
            } else {
                $dueDateDisplay = $dueDate->format('Y-m-d');
                $netInterestOnDueDate = number_format($net, 2);
            }

            // 🧾 Prepare data for view
            $payouts[] = [
                'period'                => $period,
                'from'                  => $currentFrom->format('d M y'),
                'to'                    => $currentTo->format('d M y'),
                'days'                  => $days,
                'principal'             => number_format($principal, 2),
                'interest'              => number_format($interest, 2),
                'tds'                   => number_format($tds, 2),
                'net_interest'          => number_format($net, 2),
                'net_interest_due_date' => $netInterestOnDueDate,
                'closing_balance'       => number_format($principal + $net, 2),
                'due_date'              => $dueDateDisplay,
                'status'                => $transaction->status ?? 'No',
                'processed'             => $transaction->processed ?? 0,
            ];

            // Update principal for next period
            $principal = round($principal + $net, 2);

            // Move to next period
            $period++;
            $currentFrom = $dueDate->copy();
        }

        return view('fd_mis_account.fd-account.fdpayoutplan', compact('fdAccount', 'payouts'));
    }


    public function processPayout(Request $request)
    {
        $fdAccountId = $request->fd_account_id;
        $dueDate     = $request->due_date;

        $existing = FdTransaction::where('fd_account_id', $fdAccountId)
            ->where('due_date', $dueDate)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Already processed for this due date',
                'processed_label' => 'Yes',
                'state' => 'Paid'
            ]);
        }

        $payoutData = [
            'fd_account_id'   => $fdAccountId,
            'transaction_date' => now(),
            'amount'          => $request->interest,
            'interest'        => $request->interest,
            'tds'             => $request->tds,
            'net_interest'    => $request->net_interest,
            'due_date'        => $dueDate,
            'status'          => 'Yes',
            'processed'       => 1,
        ];
        $transaction = FdTransaction::create($payoutData);

        return response()->json([
            'success' => true,
            'processed_label' => 'Yes',
            'state' => 'Paid',
            'processed' => $transaction->processed
        ]);
    }

    // Change Account Info
    public function changeAccountInfo($id)
    {
        $fdAccountDetail = FdAccount::with('member.kyc', 'fdscheme', 'minor')->findOrFail($id);

        $selectedMember = Member::find($fdAccountDetail->member_id);

        $schemes = FdScheme::all();

        // Fetch minors of this member
        $minors = Minor::where('member_id', $fdAccountDetail->member_id)->get();

        $otherMembers = Member::where('id', '!=', $fdAccountDetail->member_id)->get();

        $members = collect([$selectedMember])->merge($otherMembers);

        return view('fd_mis_account.fd-account.fdchangeaccinfo', compact('fdAccountDetail', 'members', 'schemes', 'minors'));
    }
    public function updateAccountInfo(Request $request, $id)
    {
        Log::info("FD ID Received: $id");
        Log::info("Request Data: ", $request->all());

        try {
            // Validation
            Log::info("Validating request data...");
            $request->validate([
                'scheme_id'        => 'required|exists:fd_schemes,id',
                'member_id'        => 'required|exists:members,id',
                'account_type'     => 'required|in:single,joint',
                'joint_member_id'  => 'nullable|exists:members,id',
                'minor_id'         => 'nullable|exists:minors,id',
                'open_date'        => 'required|date_format:d-m-Y',
            ]);
            Log::info("Validation Success.");

            // Fetch account
            $fd = FdAccount::findOrFail($id);
            Log::info("Current FD Details Before Update: ", $fd->toArray());

            // Convert open date
            $openDate = Carbon::createFromFormat('d-m-Y', $request->open_date)
                ->format('Y-m-d');

            // Store old values for comparison
            $oldData = $fd->getOriginal();

            // Update Values
            $fd->scheme_id        = $request->scheme_id;
            $fd->member_id        = $request->member_id;
            $fd->account_type     = $request->account_type;
            $fd->joint_member_id  = $request->account_type == 'joint' ? $request->joint_member_id : null;
            $fd->minor_id         = $request->minor_id;
            $fd->open_date        = $openDate;

            $fd->save();

            // Log updated values
            Log::info("FD Details After Update: ", $fd->toArray());

            // Compare and log what exactly changed
            $changes = [];
            foreach ($fd->getChanges() as $field => $newValue) {
                $oldValue = $oldData[$field] ?? null;
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }

            Log::info("Fields Updated: ", $changes);


            return redirect()
                ->route('fd-mis-schemes.fd_show', $fd->id)
                ->with('success', 'Account info updated successfully');
        } catch (\Exception $e) {

            Log::error("===== UPDATE FD ACCOUNT INFO FAILED =====");
            Log::error("Error Message: " . $e->getMessage());
            Log::error("Error Trace: " . $e->getTraceAsString());

            return back()->with('error', 'Something went wrong while updating FD account info.');
        }
    }

    public function addNominee($id)
    {
        return view('fd_mis_account.fd-account.fd-accountnominee');
    }

    // public function viewTransactions(Request $request, $id)
    // {
    //     Log::info("DdsAccountsController@transactions called for DDS ID: $id");

    //     $fdAccount = FdAccount::with('member', 'branch', 'fdscheme')->findOrFail($id);

    //     $query = FdTransaction::where('fd_account_id', $id);

    //     if ($request->filled('tranx_id')) {
    //         $query->where('id', $request->tranx_id);
    //     }

    //     if ($request->filled('remarks')) {
    //         $query->where('remarks', 'like', '%' . $request->remarks . '%');
    //     }

    //     if ($request->filled('from_date') && $request->filled('to_date')) {
    //         $fromDate = Carbon::parse($request->from_date)->startOfDay();
    //         $toDate = Carbon::parse($request->to_date)->endOfDay();
    //         $query->whereBetween('transaction_date', [$fromDate, $toDate]);
    //     }

    //     if ($request->filled('from_amount') && $request->filled('to_amount')) {
    //         $query->whereBetween('balance_available', [$request->from_amount, $request->to_amount]);
    //     }

    //     $transactions = $query
    //         ->orderBy('transaction_date', 'asc')
    //         ->orderBy('id', 'asc')
    //         ->get();

    //     $transactions = TransactionHelper::calculateRunningBalance($transactions);

    //     $transactions = $transactions->sortByDesc('transaction_date')->sortByDesc('id')->values();

    //     return view('fd_mis_account.fd-account.viewTransactions', compact('fdAccount', 'transactions'));
    // }
   public function viewTransactions(Request $request, $id)
{
    $fdAccount = FdAccount::with('member', 'branch', 'fdscheme')->findOrFail($id);

    $transactions = FdTransaction::where('fd_account_id', $id)
        ->orderBy('transaction_date', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    $cumulativeBalance = $fdAccount->status == 1 ? $fdAccount->fd_amount : 0; // Start with FD principal if approved

    foreach ($transactions as $tran) {
        if ($tran->status === 'approved') {
            // Add/Subtract only approved transactions
            if ($tran->transaction_type == 1) { // Credit
                $cumulativeBalance += $tran->amount;
            } elseif ($tran->transaction_type == 0) { // Debit
                $cumulativeBalance -= $tran->amount;
            }
            $tran->balance = $cumulativeBalance;
        } else {
            // Pending transactions → just show their own amount
            $tran->balance = $tran->amount;
        }
    }

    // Show latest transactions first
    $transactions = $transactions->sortByDesc('transaction_date')
        ->sortByDesc('id')
        ->values();

    return view('fd_mis_account.fd-account.viewTransactions', compact('fdAccount', 'transactions'));
}

    public function transactionsDetails($accountId, $transactionId)
    {
        Log::info("DdsAccountsController@transactionShow called for DDS ID: $accountId, Transaction ID: $transactionId");

        $fdAccount = FdAccount::with(['member', 'branch', 'fdscheme'])
            ->findOrFail($accountId);
        $transaction = $fdAccount->transactions()
            ->with('fdAccount.branch')
            ->findOrFail($transactionId);

        return view('fd_mis_account.fd-account.transaction-details', compact('fdAccount', 'transaction', 'fdBalance'));
    }
    public function destroyTransaction($ddsAccountId, $tranxId)
    {
        Log::info("Deleting Transaction ID: $tranxId for DDS Account: $ddsAccountId");

        $tranx = FdTransaction::findOrFail($tranxId);
        $tranx->delete();

        return back()->with('success', 'Transaction deleted.');
    }
    public function printReceipt($id, $transactionId)
    {
        $transaction = FdAccount::with(['member', 'transactions' => function ($query) use ($transactionId) {
            $query->where('id', $transactionId);
        }])->find($id);

        if (!$transaction || $transaction->transactions->isEmpty()) {
            abort(404, "Transaction not found");
        }
        $printedOn = now()->format('d-m-Y H:i');
        $printedBy = optional(Auth::user())->name ?? 'System';

        return view('fd_mis_account.fd-account.transactionPrintReceipt', compact('transaction', 'printedOn', 'printedBy'));
    }
    public function createLinkSavingAcc($id)
    {
        $fdAccount = fdAccount::with('member', 'branch', 'transactions', 'fdscheme')
            ->findOrFail($id);

        $savingAccounts = Account::where('member_id', $fdAccount->member_id)
            ->where('account_type', 'Saving')
            ->where('account_status', 1)
            ->get();

        $balances = [];
        foreach ($savingAccounts as $acc) {
            $bal = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec($acc->id);

            $balances[$acc->id] = $bal['total_balance'] ?? 0;
        }

        return view('fd_mis_account.fd-account.link-account', compact('fdAccount', 'savingAccounts', 'balances'));
    }

    public function storeLinkSavingAcc(Request $request, $id)
    {
        $request->validate([
            'saving_account_id' => 'nullable|exists:accounts,id',
        ]);

        $fdAccount = FdAccount::findOrFail($id);
        $savingAccId = $request->saving_account_id;

        $linkStatus = $savingAccId ? 1 : 0;

        $savingAcc = $savingAccId ? Account::find($savingAccId) : null;
        $savingAccNo = $savingAcc->account_no ?? 'N/A';

        // -----------------------------
        // Prepare log message
        // -----------------------------
        if ($linkStatus == 1) {
            $logMessage = "✔ Linked Saving A/c ({$savingAccNo}) to FD Account ID {$fdAccount->id} on " . now()->format('d-m-Y H:i:s');
        } else {
            $logMessage = "✘ Unlinked Saving A/c from FD Account ID {$fdAccount->id} on " . now()->format('d-m-Y H:i:s');
        }

        // -----------------------------
        // Append log to remarks column
        // -----------------------------
        $existingLog = trim($fdAccount->remarks ?? '');
        $newLog = $existingLog
            ? $existingLog . "\n" . $logMessage
            : $logMessage;

        $fdAccount->update([
            'saving_account_id' => $savingAccId,
            'link_status'       => $linkStatus,
            'remarks'           => $newLog,
        ]);

        // -----------------------------
        // Log to laravel.log
        // -----------------------------
        Log::info($logMessage, [
            'fd_account_id' => $fdAccount->id,
            'saving_account_id' => $savingAccId,
            'link_status' => $linkStatus,
        ]);

        // -----------------------------
        // FD transaction entry
        // -----------------------------
        FdTransaction::create([
            'fd_account_id'     => $fdAccount->id,
            'branch_id'         => $fdAccount->branch_id,
            'saving_account_id' => $savingAccId,
            'pay_mode'          => 'saving',
            'transaction_date'  => now(),
            'balance_available' => 0,
            'amount'            => 0,
        ]);

        $message = $linkStatus
            ? "Saving Account No {$savingAccNo} has been successfully linked to FD Account."
            : "Saving Account has been successfully unlinked from FD Account.";

        return redirect()
            ->route('fd-mis-schemes.fd_show', $id)
            ->with('success', $message);
    }


    public function confirmUnlink($id)
    {
        $fdAccount = FdAccount::with(['member', 'branch', 'fdscheme', 'transactions'])->findOrFail($id);

        $linkedSavingAcc = Account::find($fdAccount->saving_account_id);
        $availableBalance = optional($linkedSavingAcc)->balance ?? 0;

        return view('fd_mis_account.fd-account.unlink_confirm', compact('fdAccount', 'linkedSavingAcc', 'availableBalance'));
    }


    public function uploadDocuments($id)
    {
        $fdAccount = FdAccount::with('member')->findOrFail($id);
        return view('fd_mis_account.fd-account.upload_documents', compact('fdAccount'));
    }

    public function storeDocuments(Request $request, $id)
    {
        $fdAccount = FdAccount::findOrFail($id);

        // Validate fields properly
        $request->validate([
            'document_type.*' => 'required|string',
            'file_path.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Loop through uploaded documents
        foreach ($request->document_type as $index => $docType) {

            $file = $request->file('file_path')[$index] ?? null;

            if ($file) {
                $destinationPath = public_path('assets/documents');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move($destinationPath, $fileName);

                $path = 'assets/documents/' . $fileName;
                Document::create([
                    'fd_id' => $fdAccount->id,
                    'document_type' => $docType,
                    'file_path' => $path,
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('fd-mis-schemes.fd_show', $id)
            ->with('success', 'Documents uploaded successfully.');
    }


    public function addComment($id)
    {
        $fdAccount = FdAccount::with('comments')->findOrFail($id);
        return view('fd_mis_account.fd-account.add-comment', compact('fdAccount'));
    }

    public function storeComment(Request $request, $id)
    {

        $request->validate([
            'comment'       => 'required|string',
        ]);

        Comments::create([
            'fd_account_id' => $id,
            'commented_by'  => auth::id(),
            'date'          => now()->toDateString(),
            'comment'       => $request->comment,
        ]);

        return redirect()->route('fd-mis-schemes.fd_show', $id)
            ->with('success', 'Comment added successfully!');
    }

    public static function getAccountBalance($fdaccountids)
    {
        if (!is_array($fdaccountids)) {
            $fdaccountids = [$fdaccountids];
        }

        $balances = [];

        // Get all FD accounts
        $fdAccounts = FdAccount::whereIn('id', $fdaccountids)->get();

        // Get all approved transactions for these accounts
        $transactions = FdTransaction::whereIn('fd_account_id', $fdaccountids)
            ->where('status', 'approved')
            ->get()
            ->groupBy('fd_account_id');

        foreach ($fdAccounts as $fdAccount) {
            // Start with principal if FD is approved
            $balance = 0;
            if ($fdAccount->status == 1) { // 1 = Approved
                $balance = $fdAccount->fd_amount;
            }

            // Add credits and subtract debits
            if (isset($transactions[$fdAccount->id])) {
                $group = $transactions[$fdAccount->id];
                $credit = $group->where('transaction_type', 1)->sum('amount');
                $debit  = $group->where('transaction_type', 0)->sum('amount');

                $balance += ($credit - $debit);
            }

            $balances[$fdAccount->id] = $balance;
        }

        return $balances;
    }

    public function creditDebitInterest($id)
    {
        $fdAccount = FdAccount::with('transactions')->findOrFail($id);

        $transaction = $fdAccount->transactions()
            ->where('status', 'approved')
            ->latest('id')
            ->first();
        $balances   = self::getAccountBalance($id);

        $balance    = $balances[$id] ?? 0;

        return view('fd_mis_account.fd-account.interest-tds.credit_debit_interest', compact('fdAccount', 'balance', 'transaction'));
    }

    public function storeCreditDebitInterestAndTDS(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:credit,debit',
            'amount'           => 'required|numeric|min:0.01',
            'remarks'          => 'nullable|string|max:255',
        ]);

        $fdAccount = FdAccount::findOrFail($id);

        // Prepare transaction entry
        $transaction                   = new FdTransaction();
        $transaction->fd_account_id    = $fdAccount->id;
        $transaction->transaction_date = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
        $transaction->paid_on          = now();
        $transaction->transaction_type = $request->transaction_type === 'credit' ? 1 : 0;
        $transaction->amount           = $request->amount;
        $transaction->status   =  "approved";
        // $transaction->mode         = "System";
        // $transaction->created_by       = Auth::id() ?? null;
        $transaction->save();
        $fdAccount->remarks = $request->remarks ?? null;
        $fdAccount->save();
        Log::info('Credit/Debit Interest Transaction Recorded', [
            'fd_account_id'   => $fdAccount->id,
            'account_no'       => $fdAccount->account_no ?? null,
            'transaction_id'   => $transaction->id,
            'transaction_date' => $transaction->transaction_date,
            'transaction_type' => $transaction->transaction_type,
            'amount'           => $transaction->amount,
            'remarks'          => $transaction->remarks,
            'user_id'          => Auth::id(),
            'user_name'        => Auth::user()->name ?? 'System',
            'timestamp'        => now()->toDateTimeString(),
        ]);
        return redirect()
            ->route('fd-accounts.transactions.details', [$fdAccount->id, $transaction->id])
            ->with('success', 'Interest ' . ucfirst($request->transaction_type) . ' recorded successfully.');

        // return redirect()
        //     ->route('fd-mis-schemes.fd_show', $transaction->id)
        //     ->with('success', 'Interest ' . ucfirst($request->transaction_type) . ' recorded successfully.');
    }

    public function deductReverseTds($id)
    {
        $fdAccount = FdAccount::findOrFail($id);
        $balances   = self::getAccountBalance($id);
        $balance    = $balances[$id] ?? 0;

        return view('fd_mis_account.fd-account.interest-tds.deduct_reverse_tds', compact('fdAccount', 'balance'));
    }
}
