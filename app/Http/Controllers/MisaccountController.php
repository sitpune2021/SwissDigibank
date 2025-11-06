<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\FDScheme;
use App\Models\Member;
use App\Models\Minor;
use App\Models\Misaccount;
use App\Models\MisTransaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MisaccountController extends Controller
{
    public function index()
    {
        $misaccounts = MisAccount::orderBy('id', 'desc')->get();
        $branches    = Branch::all();
        return view('fd_mis_account.misaccount.index', compact('misaccounts', 'branches'));
    }

    public function create(Request $request)
    {
        $members        = Member::with(['address', 'branch'])->get();
        $minors         = Minor::all();
        $branches       = Branch::all();
        $banks          = Bank::all();
        $savingAccounts = Account::where('account_type', 'SAVING')->get();
        $schemes        = FDScheme::all(); // fetch all FD schemes

        return view('fd_mis_account.misaccount.create', compact('members', 'minors', 'branches', 'banks', 'savingAccounts', 'schemes'));
    }

    public function getByMember($memberId)
    {
        $accounts = Account::where('member_id', $memberId)
            ->where('account_type', 'SAVING') // only saving accounts
            ->get();

        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        try {
            Log::info('MIS Account Store Request Received', $request->all());

            // Validate incoming request
            $validated = $request->validate([
                'member_id'            => 'required|exists:members,id',
                'member_name'          => 'nullable|string|max:255',
                'member_address'       => 'nullable|string|max:500',
                'member_mobile'        => 'nullable|string|max:15',
                'minor_id'             => 'nullable|exists:minors,id',
                'branch_id'            => 'required|exists:branches,id',
                'fd_scheme_id'         => 'nullable|exists:fd_schemes,id',
                'advisor_id'           => 'nullable|integer',
                'open_date'            => 'required|date',
                'tenure_year'          => 'nullable|integer|min:0',
                'tenure_month'         => 'nullable|integer|min:0|max:12',
                'tenure_day'           => 'nullable|integer|min:0|max:31',
                'mis_amount'           => 'required|numeric|min:0',
                'interest_payout_type' => 'required|string|max:100',
                'tds_deduction'        => 'required|in:yes,no',
                'senior_citizen'       => 'required|in:yes,no',
                'account_type'         => 'required|in:single,joint',
                'joint_member_id'      => 'nullable|exists:members,id',
                'nominee'              => 'required|in:yes,no',
                'nominee_name'         => 'nullable|array',
                'nominee_relation'     => 'nullable|array',
                'nominee_address'      => 'nullable|array',
                'final_amount'         => 'nullable|integer|min:0',
                'transaction_date'     => 'required|date',
                'amount'               => 'required|numeric|min:1',
                'pay_mode'             => 'required|in:cash,cheque,online,saving',
            ]);

            Log::info('MIS Account Validated Data', $validated);

            // Handle joint accounts
            if ($request->account_type === 'joint' && ! $request->joint_member_id) {
                return back()->withInput()->withErrors(['joint_member_id' => 'Joint member is required for joint accounts.']);
            }
            $validated['joint_member_id'] = $request->joint_member_id ?? null;

            // Format dates
            $validated['open_date']        = Carbon::parse($validated['open_date'])->format('Y-m-d');
            $validated['transaction_date'] = Carbon::parse($validated['transaction_date'])->format('Y-m-d');

            $calc = $this->calculateMISDetails(
                fd_scheme_id: $request->fd_scheme_id,
                principal: $request->mis_amount,
                open_date: $validated['open_date'],
                tenure_year: $request->tenure_year,
                tenure_month: $request->tenure_month,
                senior_citizen: $request->senior_citizen
            );

            $validated['interest_rate']    = $calc['interest_rate'];
            $validated['payout_type']      = $calc['payout_type'];
            $validated['monthly_interest'] = $calc['monthly_interest'];
            $validated['total_interest']   = $calc['total_interest'];
            $validated['final_amount']     = $calc['final_amount'];
            $validated['maturity_amount']  = $calc['maturity_amount'];
            $validated['maturity_date']    = $calc['maturity_date'];

            // --- Create MIS account with all fields including calculated ---
            $misaccount = Misaccount::create($validated);
            Log::info('MIS Account Created', $misaccount->toArray());

            try {
                $member        = Member::find($misaccount->member_id);
                $dlttemplateid = 1707172234271737114;
                $mobile        = $member->member_info_mobile_no;
                $misAccountNo  = $misaccount->mis_account_no;

                $message = "Dear Customer, we have received your request for opening MIS. Your temp. MIS a/c no. is $misAccountNo. SBC GLOBAL";

                \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            } catch (Exception $e) {
                Log::error('Error while sending SMS for RD Account', ['error' => $e->getMessage()]);
            }

            // --- Handle nominees ---
            if ($request->nominee === 'yes' && $request->has('nominee_name')) {
                $totalNominees = count(array_filter($request->nominee_name));
                $share         = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (! empty($name)) {
                        AccountNominee::create([
                            'mis_account_id'   => "MIS-" . $misaccount->id,
                            'nominee_name'     => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address'  => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }
                Log::info('Nominees saved', ['count' => $totalNominees]);
            }

            // --- Format cheque & transfer dates ---
            $chequeDate = $request->cheque_date
                ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d')
                : null;

            $transferDate = $request->transfer_date
                ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d')
                : null;

            $transactionDate = $request->transaction_date
                ? Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d')
                : null;

            // // --- Create MIS Transaction ---
            // MisTransaction::create([
            //     'misaccount_id'     => $misaccount->id,
            //     'amount'            => $request->amount,
            //     'pay_mode'          => $request->pay_mode,
            //     'bank_id'           => $request->bank_id ?? null,
            //     'cheque_no'         => $request->cheque_no ?? null,
            //     'cheque_date'       => $chequeDate,
            //     'transfer_date'     => $transferDate,
            //     'utr_no'            => $request->utr_no ?? null,
            //     'transfer_mode'     => $request->transfer_mode ?? null,
            //     'saving_account_id' => $request->saving_account_id ?? null,
            //     'transaction_type'  => $request->transaction_type ?? 'credit',
            //     'transaction_no'    => $request->transaction_no ?? $request->utr_no ?? null,
            //     'cheque_bank_name'  => $request->cheque_bank_name ?? null,
            //     'approve_status'    => $request->approve_status ?? 'pending',
            //     'amount_received'   => $request->amount_received ?? $request->amount ?? 0,
            //     'remark'            => $request->remark ?? null,
            //     'accounted'         => $request->accounted ?? 0,
            //     'status'            => $request->status ?? 'Pending',
            //     'paid_on'           => $request->paid_on ?? now(),
            //     'print_flag'        => $request->print_flag ?? 0,
            // ]);

            // --- Deposit Initial Transaction ---
            $misaccount_id = $misaccount->id;
            $amount        = $request->amount;

            self::deposit($misaccount_id, $amount, [
                'transaction_date'  => $transactionDate,
                'payment_mode'      => $request->pay_mode,
                'cheque_no'         => $request->cheque_no,
                'cheque_date'       => $chequeDate,
                'bank_id'           => $request->bank_id,
                'utr_no'            => $request->utr_no,
                'transfer_date'     => $transferDate,
                'transfer_mode'     => $request->transfer_mode,
                'saving_account_id' => $request->saving_account_id,
                'remark'            => 'Initial Deposit',
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
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while creating MIS Account.')->withInput();
        }
    }

    public static function getAccountBalance($misaccount_ids)
    {
        if (! is_array($misaccount_ids)) {
            $misaccount_ids = [$misaccount_ids];
        }

        $transactions = MisTransaction::whereIn('misaccount_id', $misaccount_ids)
            ->where('approve_status', 'approved')
            ->get();

        $balances = [];

        foreach ($transactions->groupBy('misaccount_id') as $misaccount_id => $group) {
            $credit                   = $group->where('transaction_type', 'credit')->sum('amount');
            $debit                    = $group->where('transaction_type', 'debit')->sum('amount');
            $balances[$misaccount_id] = $credit - $debit;
        }

        return $balances;
    }

    /**
     * Deposit to MIS Account
     */
    public static function deposit($misaccount_id, $amount, $details = [])
    {

        MisTransaction::create([
            'misaccount_id'     => $misaccount_id,
            'amount'            => $amount,
            'transaction_type'  => 'credit',
            'approve_status'    => 'pending',
            't_date'            => $details['transaction_date'] ?? now(),
            'pay_mode'          => $details['payment_mode'] ?? 'cash',
            'cheque_no'         => $details['cheque_no'] ?? null,
            'cheque_date'       => $details['cheque_date'] ?? null,
            'bank_id'           => $details['bank_id'] ?? null,
            'utr_no'            => $details['utr_no'] ?? null,
            'transfer_mode'     => $details['transfer_mode'] ?? null,
            'transfer_date'     => $details['transfer_date'] ?? null,
            'saving_account_id' => $details['saving_account_id'] ?? null,
            'remark'            => $details['remark'] ?? 'Deposit',
        ]);

        return self::getAccountBalance($misaccount_id);
    }

    /**
     * Withdraw from MIS Account
     */
    public static function withdraw($misaccount_id, $amount, $details = [])
    {
        $balances        = self::getAccountBalance([$misaccount_id]);
        $current_balance = $balances[$misaccount_id] ?? 0;

        if ($current_balance < $amount) {
            throw new \Exception("Insufficient balance. Available: ₹" . number_format($current_balance, 2));
        }

        MisTransaction::create([
            'misaccount_id'     => $misaccount_id,
            'amount'            => $amount,
            'transaction_type'  => 'debit',
            'approve_status'    => 'pending',
            't_date'            => $details['transaction_date'] ?? now(),
            'pay_mode'          => $details['payment_mode'] ?? 'cash',
            'cheque_no'         => $details['cheque_no'] ?? null,
            'cheque_date'       => $details['cheque_date'] ?? null,
            'bank_id'           => $details['bank_id'] ?? null,
            'utr_no'            => $details['utr_no'] ?? null,
            'transfer_mode'     => $details['transfer_mode'] ?? null,
            'transfer_date'     => $details['transfer_date'] ?? null,
            'saving_account_id' => $details['saving_account_id'] ?? null,
            'remark'            => $details['remark'] ?? 'Withdraw',
        ]);

        return self::getAccountBalance($misaccount_id);
    }

    /**
     * Get balance before a specific date
     */
    public static function getBalanceBeforeDate($misaccount_id, $date)
    {
        $credit = MisTransaction::where('misaccount_id', $misaccount_id)
            ->where('transaction_type', 'credit')
            ->where('t_date', '<', $date)
            ->sum('amount');

        $debit = MisTransaction::where('misaccount_id', $misaccount_id)
            ->where('transaction_type', 'debit')
            ->where('t_date', '<', $date)
            ->sum('amount');

        return $credit - $debit;
    }



    public function calculateMISDetails(
        $fd_scheme_id,
        $principal,
        $open_date,
        $tenure_year,
        $tenure_month,
        $senior_citizen = 0
    ) {

        $totalMonths = ($tenure_year * 12) + $tenure_month;
        $totalDays   = $totalMonths * 30 ?: 360;

        $scheme = FdScheme::findOrFail($fd_scheme_id);

        $rateRow = DB::table('fd_schemes as s')
            ->leftJoin('fd_scheme_slabs as fs', function ($join) use ($totalDays) {
                $join->on('fs.fd_scheme_id', '=', 's.id')
                    ->whereRaw('? BETWEEN fs.day_from AND fs.day_to', [$totalDays]);
            })
            ->where('s.id', $scheme->id)
            ->selectRaw('
            CASE WHEN fs.id IS NOT NULL THEN
                CASE WHEN ? = 1 THEN fs.sr_citizen_rate ELSE fs.interest_rate END
            ELSE
                CASE WHEN ? = 1 THEN (s.annual_interest_rate + COALESCE(s.bonus_rate, 0))
                     ELSE s.annual_interest_rate END
            END AS rate,
            fs.payout_type
        ', [$senior_citizen, $senior_citizen])
            ->first();

        $rate = (float) ($rateRow->rate ?? 0);
        $payoutType = strtoupper($rateRow->payout_type ?? 'MONTHLY');
        $annualRate = $rate / 100;

        $monthlyInterest = round(($principal * $rate) / 1200, 2);
        $openCarbon = Carbon::parse($open_date)->startOfDay();
        $maturityCarbon = $openCarbon->copy()->addMonths($totalMonths)->startOfDay();



        $results = [];
        $totalInterest = 0;

        [$results, $totalInterest] = $this->processMISPeriod(
            $results,
            $openCarbon,
            $maturityCarbon,
            $principal,
            $annualRate,
            $totalInterest,
            $payoutType,
            null,
            false
        );

        $maturityAmount = $principal + $totalInterest;

        return [
            'interest_rate'    => $rate,
            'payout_type'      => $payoutType,
            'monthly_interest' => $monthlyInterest,
            'total_interest'   => round($totalInterest, 2),
            'final_amount'     => round($maturityAmount, 2),
            'maturity_amount'  => round($maturityAmount, 2),
            'maturity_date'    => $maturityCarbon->format('Y-m-d'),
            'principal'        => $principal,
            'tenure_months'    => $totalMonths,
            'total_days'       => $totalDays,
        ];
    }
    public function processMISPeriod(
        $results,
        $periodStart,
        $periodEnd,
        $principal,
        $annualRate,
        $totalInterest,
        $payoutType,
        $transactions = null,
        $forDisplay = false
    ) {
       

        // normalize inputs
        $periodStart = $periodStart instanceof Carbon ? $periodStart->copy()->startOfDay() : Carbon::parse($periodStart)->startOfDay();
        $periodEnd   = $periodEnd instanceof Carbon ? $periodEnd->copy()->startOfDay() : Carbon::parse($periodEnd)->startOfDay();
        // dd($periodEnd);
        $anchorDay = (int) $periodStart->day;

        while ($periodStart->lessThanOrEqualTo($periodEnd)) {
            // If the next period would start on or after the maturity date, stop:
            if ($periodStart->greaterThanOrEqualTo($periodEnd)) {
                break;
            }
            // FY end for the year of current start
            $fyEnd = Carbon::create($periodStart->year, 3, 31)->startOfDay();

            // -------- compute proposedEnd correctly for three cases --------
            if ($periodStart->equalTo($fyEnd->copy()->addDay())) {
                // CASE A: BRIDGE starting 1-April — end = (anchorDay - 1) within APRIL
                if ($anchorDay > 1) {
                    $day = min($anchorDay - 1, $periodStart->daysInMonth()); // e.g., 2 for anchor 3
                    $proposedEnd = $periodStart->copy()->setDay($day);
                } else {
                    // anchorDay == 1 -> treat as full-month end (end of April)
                    $proposedEnd = $periodStart->copy()->endOfMonth();
                }
            } else {
                // CASE B: NORMAL monthly period — end normally at (anchorDay - 1) of NEXT month (or nextMonth-1 if anchor=1)
                $nextMonth = $periodStart->copy()->addMonthNoOverflow();
                if ($anchorDay > 1) {
                    $day = min($anchorDay - 1, $nextMonth->daysInMonth());
                    $proposedEnd = $nextMonth->copy()->setDay($day);
                } else {
                    // anchorDay == 1 -> end = nextMonth - 1 day (i.e., end of current month)
                    $proposedEnd = $periodStart->copy()->addMonthNoOverflow()->subDay();
                }
            }

            // CASE C: If a normal proposedEnd would cross FY end (e.g. 03 Mar -> 02 Apr), cap at 31 Mar
            if ($periodStart->lessThanOrEqualTo($fyEnd) && $proposedEnd->greaterThan($fyEnd)) {
                $proposedEnd = $fyEnd->copy();
            }
            // --- Handle final period correctly ---
            if ($proposedEnd->greaterThan($periodEnd)) {
                $maturityMinusOne = $periodEnd->copy()->subDay();
                $naturalEnd = $periodStart->copy()
                    ->addMonthNoOverflow()
                    ->setDay(min($anchorDay - 1, $periodStart->copy()->addMonthNoOverflow()->daysInMonth()));

                // if natural end falls before or exactly on maturityMinusOne, take it
                if ($naturalEnd->lessThanOrEqualTo($maturityMinusOne)) {
                    $proposedEnd = $naturalEnd;
                } else {
                    // otherwise, end exactly a day before maturity
                    $proposedEnd = $maturityMinusOne;
                }
            }


            if ($proposedEnd->lessThanOrEqualTo($periodStart)) {
                $proposedEnd = $periodStart->copy()->addMonthNoOverflow();
                if ($anchorDay > 1) {
                    $proposedEnd->setDay(min($anchorDay - 1, $proposedEnd->daysInMonth()));
                } else {
                    $proposedEnd->subDay();
                }
            }


            // Safety: if invalid range, break
            if ($proposedEnd->lessThan($periodStart)) break;

            // ----- Interest calculation -----
            $daysInYr = $periodStart->isLeapYear() ? 366 : 365;
            $days = (int) $periodStart->diffInDays($proposedEnd) + 1;
            // compute raw interest then normalize/round to avoid binary-float artifacts
            $interest = ($principal * $annualRate * $days) / $daysInYr;
            $interest = (float) $interest;
            $netInterest = round($interest, 2);
            // keep accumulated total with higher precision, then round on return/display
            $totalInterest = round($totalInterest + $netInterest, 12);


            // labels / due date
            $fyLabel = $periodStart->month > 3
                ? "{$periodStart->year}-" . ($periodStart->year + 1)
                : ($periodStart->year - 1) . "-{$periodStart->year}";

            $dueDateDb = $proposedEnd->copy()->addDay()->format('Y-m-d');
            $dueDateDisplay = $proposedEnd->copy()->addDay()->format('d-m-Y');

            $data = [
                'period'           => $periodStart->format('d M y') . ' - ' . $proposedEnd->format('d M y'),
                'days'             => (int) $days,
                'principal'        => round($principal, 2),
                'interest'         => $netInterest,
                'tds'              => 0.00,
                'net_interest'     => $netInterest,
                'maturity_partial' => round($principal + $totalInterest, 2),
                'payout_type'      => $payoutType,
            ];



            if ($forDisplay) {
                $data['from'] = $periodStart->format('d M y');
                $data['to'] = $proposedEnd->format('d M y');
                $data['fy_label'] = 'FY ' . ($fyLabel);
                $data['due_date'] = $dueDateDisplay;
                $data['due_date_db'] = $dueDateDb;
                $data['status'] = 'Pending';
                $data['processed'] = 0;


                if ($transactions && isset($transactions[$dueDateDb])) {
                    $tx = $transactions[$dueDateDb];
                    $data['status'] = $tx['status'] ?? 'Paid';
                    $data['processed'] = isset($tx['processed']) && $tx['processed'] ? 1 : 0;
                }
                // if ($transactions) {
                //     $tx = $transactions[$dueDateDb] ?? null;
                //     if ($tx) {
                //         // transactions from keyBy()->toArray() are arrays, not objects
                //         $data['status'] = $tx['status'] ?? $tx['status'] ?? 'Yes';
                //         $data['processed'] = $tx['processed'] ?? $tx['processed'] ?? 'Yes';
                //     }
                // }
            }


            $results[] = $data;


            // Stop if we've reached overall end
            if ($proposedEnd->greaterThanOrEqualTo($periodEnd)) break;
            // Advance to next start:
            // If we ended at FY end (31 Mar) move to 1 Apr; otherwise day after proposedEnd.
            if ($proposedEnd->equalTo($fyEnd)) {
                $periodStart = $fyEnd->copy()->addDay(); // 1 Apr
            } else {
                $periodStart = $proposedEnd->copy()->addDay();
            }
        }

        // dd($periodEnd);

        return [$results, round($totalInterest, 2)];
    }


    public function misPayout($id)
    {
        $misAccount = Misaccount::with(['member.address', 'branch', 'fdScheme.fdslabs'])
            ->findOrFail($id);
        $principal = (float) $misAccount->mis_amount;
        $totalDays = ($misAccount->tenure_year * 365) + ($misAccount->tenure_month * 30);
        $slab = $misAccount->fdScheme->fdslabs
            ->where('day_from', '<=', $totalDays)
            ->where('day_to', '>=', $totalDays)
            ->first();

        $rate = (float) ($slab->interest_rate ?? 0);
        $annualRate = $rate / 100;
        $openDate = Carbon::parse($misAccount->open_date);
        // $maturityDate = $openDate->copy()->addDays($totalDays);
        $maturityDate = $openDate->copy()
            ->addYears($misAccount->tenure_year)
            ->addMonthsNoOverflow($misAccount->tenure_month);

        // dd($maturityDate);
        $transactions = MisTransaction::where('misaccount_id', $id)
            ->get()
            ->keyBy(fn($t) => Carbon::parse($t->due_date)->format('Y-m-d'))
            ->toArray();

        $payouts = [];
        $totalInterest = 0;
        [$payouts, $totalInterest] = $this->processMISPeriod(
            $payouts,
            $openDate,
            $maturityDate,
            $principal,
            $annualRate,
            $totalInterest,
            'MONTHLY',
            $transactions,
            true
        );

        return view('fd_mis_account.misaccount.mispayout', compact('misAccount', 'payouts'));
    }



    public function processPayout(Request $request)
    {
        $validated = $request->validate([
            'misaccount_id' => 'required|exists:misaccounts,id',
            'interest'      => 'required|numeric|min:0',
            'tds'           => 'required|numeric|min:0',
            'net_interest'  => 'required|numeric|min:0',
            'due_date'      => 'required|date',
        ]);

        try {
            $response = DB::transaction(function () use ($validated) {

                // Check if already processed
                $existing = MisTransaction::where('misaccount_id', $validated['misaccount_id'])
                    ->where('due_date', $validated['due_date'])
                    ->first();

                if ($existing) {
                    return [
                        'success'         => false,
                        'message'         => 'Payout already processed for this due date',
                        'processed_label' => 'Yes',
                        'state'           => 'Paid',
                    ];
                }
                $validated['due_date'] = \Carbon\Carbon::parse($validated['due_date'])->format('Y-m-d');

                // Create the MIS payout transaction
                $transaction = MisTransaction::create([
                    'misaccount_id'    => $validated['misaccount_id'],
                    'transaction_date' => now(),
                    'amount'           => $validated['net_interest'],
                    'interest'         => $validated['interest'],
                    'tds'              => $validated['tds'],
                    'net_interest'     => $validated['net_interest'],
                    'due_date'         => $validated['due_date'],
                    'status'           => 'Paid',
                    'processed'        => 1,
                ]);

                // // Update MIS account (optional)
                $account = Misaccount::find($validated['misaccount_id']);
                // $account->increment('interest_paid', $validated['net_interest']);

                Log::info("MIS payout processed", [
                    'misaccount_id'  => $account->id,
                    'transaction_id' => $transaction->id,
                    'due_date'       => $validated['due_date'],
                    'net_interest'   => $validated['net_interest'],
                ]);

                return [
                    'success'         => true,
                    'processed_label' => 'Yes',
                    'state'           => 'Paid',
                    'processed'       => 1,
                ];
            });

            return response()->json($response);
        } catch (\Throwable $th) {
            Log::error('MIS payout processing failed', ['error' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $th->getMessage(),
            ], 500);
        }
    }

    // public function misPayout($id)
    // {
    //     $misAccount = Misaccount::with(['member.address', 'branch', 'fdScheme.fdslabs'])
    //         ->findOrFail($id);

    //     // Calculate total days based on tenure
    //     $totalDays = ($misAccount->tenure_year * 365)
    //         + ($misAccount->tenure_month * 30)
    //         + $misAccount->tenure_day;

    //     // Get matching slab based on total days
    //     $slab = $misAccount->fdScheme->fdslabs
    //         ->where('day_from', '<=', $totalDays)
    //         ->where('day_to', '>=', $totalDays)
    //         ->first();

    //     $principal    = (float) $misAccount->mis_amount;
    //     $rate         = (float) optional($slab)->interest_rate ?? 0;
    //     $startDate    = $misAccount->open_date instanceof Carbon ? $misAccount->open_date->copy()->startOfDay() : Carbon::parse($misAccount->open_date)->startOfDay();
    //     $maturityDate = $startDate->copy()->addDays($totalDays);
    //     $payoutType   = $misAccount->payout_type;

    //     // Initialize results and totalInterest
    //     $results = [];
    //     $totalInterest = 0;

    //     //  Call your shared logic
    //     [$payouts, $totalInterest] = $this->processMISPeriod(
    //         $results,
    //         $startDate,
    //         $maturityDate,
    //         $principal,
    //         $rate / 100,     // convert % to decimal
    //         $totalInterest,
    //         $payoutType
    //     );

    //     // Fetch processed transactions
    //     $transactions = MisTransaction::where('misaccount_id', $id)
    //         ->get()
    //         ->keyBy(function ($t) {
    //             return Carbon::parse($t->due_date)->format('Y-m-d');
    //         });

    //     // Merge payout info with existing transactions
    //     foreach ($payouts as &$payout) {
    //         $dueDateDb = $payout['due_date_db'] ?? null;
    //         if ($dueDateDb && isset($transactions[$dueDateDb])) {
    //             $transaction = $transactions[$dueDateDb];
    //             $payout['processed'] = $transaction->processed ?? 0;
    //             $payout['status'] = $transaction->status ?? 'Yes';
    //             // if you want to overwrite interest/tds/net_interest from transaction, do that here
    //         }
    //     }
    //     unset($payout);

    //     return view('fd_mis_account.misaccount.mispayout', compact('misAccount', 'payouts'));
    // }


    // public function processPayout(Request $request)
    // {
    //     $misAccountId = $request->misaccount_id;
    //     $dueDate      = $request->due_date;

    //     // Check if already processed
    //     $existing = MisTransaction::where('misaccount_id', $misAccountId)
    //         ->where('due_date', $dueDate)
    //         ->first();

    //     if ($existing) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Payout already processed for this due date',
    //             'processed_label' => 'Yes',
    //             'state' => 'Paid'
    //         ]);
    //     }

    //     $payoutData = [
    //         'misaccount_id'   => $misAccountId,
    //         'transaction_date' => now(),
    //         'amount'           => $request->interest,
    //         'interest'         => $request->interest,
    //         'tds'              => $request->tds,
    //         'net_interest'     => $request->net_interest,
    //         'due_date'         => $dueDate,
    //         'status'           => 'Yes',
    //         'processed'        => 1,
    //     ];

    //     $transaction = MisTransaction::create($payoutData);

    //     return response()->json([
    //         'success' => true,
    //         'processed_label' => 'Yes',
    //         'state' => 'Paid',
    //         'processed' => $transaction->processed
    //     ]);
    // }

    // function calculateInvestment(
    //     $type = null,
    //     $principal = null,
    //     $rate = null,
    //     $tenureMonths = null,
    //     $startDate = null,
    //     $payoutType = null
    // ) {
    //     $results = [];

    //     $type         = $type ?? 'FD';
    //     $principal    = (float) ($principal ?? 120000);
    //     $rate         = (float) ($rate ?? 10);
    //     $tenureMonths = (int) ($tenureMonths ?? 12);
    //     $startDate    = $startDate ?? '2025-08-27';
    //     $payoutType   = strtoupper($payoutType ?? 'CUMULATIVE_HALF_YEARLY');

    //     $annualRate = $rate / 100;

    //     $currentDate    = Carbon::parse($startDate)->startOfDay();
    //     $maturityCarbon = Carbon::parse($startDate)->addMonths($tenureMonths)->startOfDay();

    //     $maturityDateInternal  = $maturityCarbon->format('Y-m-d');
    //     $maturityDate          = $maturityCarbon->format('d/m/Y');
    //     $depositStartInternal  = Carbon::parse($startDate)->startOfDay()->format('Y-m-d');

    //     $totalInterest = 0;
    //     $totalTDS      = 0;
    //     $maturityBonus = 0;

    //     $isCumulative = str_starts_with($payoutType, 'CUMULATIVE_');

    //     $cycleMonths = match ($payoutType) {
    //         'MONTHLY', 'CUMULATIVE_MONTHLY'             => 1,
    //         'QUARTERLY', 'CUMULATIVE_QUARTERLY'         => 3,
    //         'HALF_YEARLY', 'CUMULATIVE_HALF_YEARLY'     => 6,
    //         'YEARLY', 'CUMULATIVE_YEARLY'               => 12,
    //         default                                     => 1,
    //     };

    //     $cycleMonths = (int) $cycleMonths;

    //     while ($currentDate < $maturityCarbon) {
    //         $periodStart = $currentDate->copy()->startOfDay();
    //         $periodEnd   = $currentDate->copy()->addMonths($cycleMonths)->subDay()->startOfDay();

    //         if ($periodEnd > $maturityCarbon) {
    //             $periodEnd = $maturityCarbon->copy()->startOfDay();
    //         }

    //         // March 31 adjustment
    //         $marchYear = ($periodStart->month > 3) ? $periodStart->year + 1 : $periodStart->year;
    //         $marchEnd  = Carbon::createFromDate($marchYear, 3, 31)->startOfDay();

    //         if ($marchEnd >= $periodStart && $marchEnd <= $periodEnd) {
    //             [$results, $totalInterest, $principal] = $this->processPeriod(
    //                 $results,
    //                 $periodStart,
    //                 $marchEnd,
    //                 $principal,
    //                 $annualRate,
    //                 $maturityDateInternal,
    //                 $depositStartInternal,
    //                 $payoutType,
    //                 $totalInterest
    //             );

    //             $periodStart = $marchEnd->copy()->addDay(1)->startOfDay();

    //             [$results, $totalInterest, $principal] = $this->processPeriod(
    //                 $results,
    //                 $periodStart,
    //                 $periodEnd,
    //                 $principal,
    //                 $annualRate,
    //                 $maturityDateInternal,
    //                 $depositStartInternal,
    //                 $payoutType,
    //                 $totalInterest
    //             );
    //         } else {
    //             [$results, $totalInterest, $principal] = $this->processPeriod(
    //                 $results,
    //                 $periodStart,
    //                 $periodEnd,
    //                 $principal,
    //                 $annualRate,
    //                 $maturityDateInternal,
    //                 $depositStartInternal,
    //                 $payoutType,
    //                 $totalInterest
    //             );
    //         }

    //         $currentDate = $periodEnd->copy()->addDay(1)->startOfDay();
    //     }

    //     // ---- Final Summary ----
    //     $netInterest = $totalInterest - $totalTDS;
    //     $maturityAmt = $principal + $maturityBonus + $netInterest;

    //     $summary['summary'] = [
    //         'principal'       => number_format($principal, 2),
    //         'interest_earned' => number_format($totalInterest, 2),
    //         'tds_deducted'    => number_format($totalTDS, 2),
    //         'net_interest'    => number_format($netInterest, 2),
    //         'maturity_bonus'  => number_format($maturityBonus, 2),
    //         'maturity_amount' => number_format($maturityAmt, 2),
    //         'maturity_date'   => $maturityDate
    //     ];

    //     return response()->json([
    //         'success' => true,
    //         'summary' => $summary,
    //         'details' => $results
    //     ]);
    // }

    // function processPeriod(
    //     $results,
    //     $periodStart,
    //     $periodEnd,
    //     $principal,
    //     $annualRate,
    //     $maturityDateInternal,
    //     $depositStartInternal,
    //     $payoutType,
    //     $totalInterest
    // ) {
    //     $daysInYr = $periodStart->isLeapYear() ? 366 : 365;
    //     $current  = $periodStart->copy();

    //     $cumulativeTypes = ['CUMULATIVE', 'CUMULATIVE_MONTHLY', 'CUMULATIVE_HALF_YEARLY', 'YEARLY'];

    //     if (in_array($payoutType, $cumulativeTypes)) {
    //         while ($current < $periodEnd) {
    //             // determine next compounding boundary
    //             $next = match ($payoutType) {
    //                 'CUMULATIVE_MONTHLY'     => $current->copy()->addMonth(1),
    //                 'CUMULATIVE_HALF_YEARLY' => $current->copy()->addMonths(6),
    //                 'YEARLY'                 => $current->copy()->addYear(1),
    //                 default                  => $periodEnd->copy(),
    //             };

    //             if ($next > $periodEnd) $next = $periodEnd->copy();

    //             $days = (int) $current->diffInDays($next) + 1;

    //             $interest = ($principal * $annualRate * $days) / $daysInYr;
    //             $netInt   = round($interest, 2);

    //             $principal     += $netInt;
    //             $totalInterest += $netInt;

    //             $results[] = [
    //                 'period'           => $current->format('d/m/Y') . ' - ' . $next->format('d/m/Y'),
    //                 'days'             => $days,
    //                 'principal'        => round($principal - $netInt, 2),
    //                 'interest'         => $netInt,
    //                 'tds'              => 0.0,
    //                 'net_interest'     => $netInt,
    //                 'net_interest_due' => $netInt,
    //                 'principal_eoy'    => ($next->format('d/m') === '31/03') ? round($principal, 2) : '',
    //                 'due_by'           => $next->copy()->addDay(1)->format('d/m/Y'),
    //                 'maturity_amount'  => round($principal, 2),
    //                 'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
    //             ];

    //             $current = $next->copy()->addDay(1);
    //         }
    //     } else {
    //         // For payout types (non-cumulative like MIS)
    //         $next = match ($payoutType) {
    //             'MONTHLY'    => $periodStart->copy()->addMonth(1),
    //             'QUARTERLY'  => $periodStart->copy()->addMonths(3),
    //             'HALF_YEARLY' => $periodStart->copy()->addMonths(6),
    //             'YEARLY'     => $periodStart->copy()->addYear(1),
    //             default      => $periodEnd->copy(),
    //         };

    //         while ($periodStart < $periodEnd) {
    //             if ($next > $periodEnd) $next = $periodEnd->copy();

    //             $days     = (int) $periodStart->diffInDays($next) + 1;
    //             $interest = ($principal * $annualRate * $days) / $daysInYr;
    //             $netInt   = round($interest, 2);
    //             $totalInterest += $netInt;

    //             $results[] = [
    //                 'period'           => $periodStart->format('d/m/Y') . ' - ' . $next->format('d/m/Y'),
    //                 'days'             => $days,
    //                 'principal'        => $principal, // stays same in MIS
    //                 'interest'         => $netInt,
    //                 'tds'              => 0.0,
    //                 'net_interest'     => $netInt,
    //                 'net_interest_due' => $netInt,
    //                 'principal_eoy'    => ($next->format('d/m') === '31/03') ? $principal : '',
    //                 'due_by'           => $next->copy()->addDay(1)->format('d/m/Y'),
    //                 'maturity_amount'  => $principal + $totalInterest, // principal + all payouts
    //                 'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
    //             ];

    //             // Move to next payout cycle
    //             $periodStart = $next->copy()->addDay(1);
    //             $next = match ($payoutType) {
    //                 'MONTHLY'    => $periodStart->copy()->addMonth(1),
    //                 'QUARTERLY'  => $periodStart->copy()->addMonths(3),
    //                 'HALF_YEARLY' => $periodStart->copy()->addMonths(6),
    //                 'YEARLY'     => $periodStart->copy()->addYear(1),
    //                 default      => $periodEnd->copy(),
    //             };
    //         }
    //     }

    //     return [$results, $totalInterest, $principal];
    // }














    public function edit(Misaccount $misaccount)
    {
        $members        = Member::with(['address', 'branch'])->get();
        $minors         = Minor::all();
        $branches       = Branch::all();
        $banks          = Bank::all();
        $savingAccounts = Account::where('account_type', 'SAVING')->get();
        $schemes        = FdScheme::all();
        $misaccount->load(['transactions', 'nominees']);

        return view('fd_mis_account.misaccount.create', compact('members', 'minors', 'branches', 'banks', 'savingAccounts', 'schemes', 'misaccount'));
    }

    public function update(Request $request, Misaccount $misaccount)
    {
        try {
            Log::info('MIS Update started', [
                'misaccount_id' => $misaccount->id,
                'request_data'  => $request->all(),
            ]);

            $validated = $request->validate([
                'member_id'            => 'required|exists:members,id',
                'branch_id'            => 'required|exists:branches,id',
                'fd_scheme_id'         => 'nullable|exists:fd_schemes,id',
                'open_date'            => 'required|date',
                'tenure_year'          => 'nullable|integer|min:0',
                'tenure_month'         => 'nullable|integer|min:0|max:12',
                'tenure_day'           => 'nullable|integer|min:0|max:31',
                'mis_amount'           => 'required|numeric|min:0',
                'interest_payout_type' => 'nullable|string|max:100',
                'tds_deduction'        => 'required|in:yes,no',
                'senior_citizen'       => 'nullable|in:yes,no',
                'account_type'         => 'required|in:single,joint',
                'joint_member_id'      => 'nullable|exists:members,id',
                'nominee'              => 'required|in:yes,no',
                'final_amount'         => 'nullable|integer|min:0',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            $validated['open_date'] = Carbon::parse($validated['open_date'])->format('Y-m-d');

            //  Update MIS account
            $misaccount->update($validated);
            Log::info('MIS Account updated', ['misaccount' => $misaccount->toArray()]);

            $chequeDate = $request->cheque_date
                ? Carbon::parse($request->cheque_date)->format('Y-m-d')
                : null;

            $transferDate = $request->transfer_date
                ? Carbon::parse($request->transfer_date)->format('Y-m-d')
                : null;

            // Always create new transaction
            $transaction = MisTransaction::create([
                'misaccount_id'     => $misaccount->id,
                'amount'            => $request->amount,
                'pay_mode'          => $request->pay_mode,
                'bank_id'           => $request->bank_id ?? null,
                'cheque_no'         => $request->cheque_no ?? null,
                'cheque_date'       => $chequeDate,
                'transfer_date'     => $transferDate,
                'utr_no'            => $request->utr_no ?? null,
                'transfer_mode'     => $request->transfer_mode ?? null,
                'saving_account_id' => $request->saving_account_id ?? null,
            ]);

            Log::info('New MIS Transaction created', ['transaction' => $transaction->toArray()]);

            return redirect()
                ->route('misaccount.index')
                ->with('success', 'MIS Account updated successfully.');
        } catch (ValidationException $e) {
            Log::warning('Validation failed during MIS update', [
                'errors' => $e->errors(),
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('MIS Account update failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
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

    public function viewTransaction($id)
    {
        $misaccount = Misaccount::with(['transactions' => function ($query) {
            $query->where('approve_status', 'approved');
        }])->findOrFail($id);

        $transactions = $misaccount->transactions;

        $balances = self::getAccountBalance($id);
        $balance  = 0;
        foreach ($transactions as $txn) {
            if ($txn->transaction_type === 'credit') {
                $balance += $txn->amount;
            } elseif ($txn->transaction_type === 'debit') {
                $balance -= $txn->amount;
            }
            $txn->balance = $balance;
        }

        return view('fd_mis_account.misaccount.view-transaction.viewTransaction', compact('misaccount', 'transactions', 'balance'));
    }

    public function transaction($id)
    {
        $transaction = MisTransaction::with(['misaccount.member', 'misaccount.branch'])
            ->findOrFail($id);

        $misaccount = $transaction->misaccount;


        return view('fd_mis_account.misaccount.view-transaction.transaction', compact('misaccount', 'transaction'));
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

        $balances = self::getAccountBalance($id);
        $balance  = $balances[$id] ?? 0;

        $savingAccounts = Account::where('member_id', $misaccount->member_id)
            ->where('account_type', 'SAVING')
            ->get();
        $account = $misaccount;
        return view('fd_mis_account.misaccount.show', compact('misaccount', 'savingAccounts', 'branches', 'balance'));

        //return view('fd_mis_account.misaccount.show', compact('misaccount', 'savingAccounts', 'branches','account'));
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

    // public function mispayoutplan()
    // {
    //     $misaccounts = Misaccount::with('fdScheme')->get();

    //     // Fetch MIS accounts, optionally eager-load related models if needed
    //     $misaccounts = Misaccount::with(['member', 'fdScheme', 'branch'])->get();

    //     return view('misaccount.viewbuttons.mispayoutplan.mispayoutplan', compact('misaccounts'));
    // }

    // public function changeAccountInfo($id)
    // {
    //     // yaha aap db se account fetch kar sakte ho
    //     $account = Misaccount::findOrFail($id);

    //     return view('fd_mis_account.misaccount.change_account_info', compact('account'));
    // }

    // public function changeAccountInfo($id)
    // {
    //     $account = Misaccount::findOrFail($id);   // DB se account fetch
    //     $members = Member::pluck('member_info_first_name', 'id'); // dropdown ke liye

    //     return view('fd_mis_account.misaccount.change_account_info', compact('account', 'members'));
    // }

    //   public function changeAccountInfo($id)
    // {
    //     $account = Misaccount::findOrFail($id);

    //     // Members list fetch -> ['id' => 'member_name']
    //     $members = Member::pluck('member_info_first_name', 'id');

    //     return view('fd_mis_account.misaccount.change_account_info', compact('account', 'members'));
    // }

    public function changeAccountInfo($id)
    {
        $account = Misaccount::findOrFail($id);

        // Members list fetch -> ['id' => 'member_name']
        $members = Member::pluck('member_info_first_name', 'id');

        $schemes = FdScheme::pluck('scheme_name', 'id');

        $balances = self::getAccountBalance($id);
        if (is_array($balances)) {
            $balances = $balances['available_balance'] ?? 0;
        } elseif ($balances instanceof \Illuminate\Support\Collection) {
            $balances = $balances->value('available_balance') ?? 0;
        }
        // Joint members ke dropdown me se selected member_id hata do
        $jointMembers = $members->except($account->member_id);

        return view('fd_mis_account.misaccount.account-details.change_account_info', compact('account', 'members', 'jointMembers', 'schemes', 'balances'));
    }

    public function updateAccountInfo(Request $request, $id)
    {
        $request->validate([
            'member_id'       => 'required|integer',
            'account_type'    => 'required|string',
            'open_date'       => 'required|date_format:d-m-Y',
            'mis_joint_date'  => 'required|date_format:d-m-Y',
            'joint_member_id' => 'nullable|integer',
        ]);

        $account = Misaccount::findOrFail($id);

        $account->member_id       = $request->member_id;
        $account->joint_member_id = $request->joint_member_id; // yaha store hoga dropdown ka id
        $account->account_type    = $request->account_type;
        $account->open_date       = Carbon::createFromFormat('d-m-Y', $request->open_date)->format('Y-m-d');
        $account->mis_joint_date  = Carbon::createFromFormat('d-m-Y', $request->mis_joint_date)->format('Y-m-d');

        $account->save();

        return redirect()->route('misaccount.show', $id)
            ->with('success', 'Account info updated successfully.');
    }

    public function addNominee($id)
    {
        $account = Misaccount::with('nominees')->findOrFail($id);
        return view('fd_mis_account.misaccount.account-details.add_nominee', compact('account'));
    }

    public function updateNominee(Request $request, $id)
    {
        $account = Misaccount::findOrFail($id);

        // Update "nominee" yes/no flag in misaccounts table
        $account->update([
            'nominee' => $request->nominee ?? 'no',
        ]);

        // If "no" is selected → clear all nominee records
        if ($request->nominee === 'no') {
            $account->nominees()->delete();
            return redirect()->route('misaccount.show', $id)
                ->with('success', 'Nominee removed successfully!');
        }

        // If "yes" is selected → handle nominee data
        if ($request->nominee === 'yes' && isset($request->nominees)) {

            foreach ($request->nominees as $index => $nomineeData) {
                // Check if nominee already exists for this account and index
                $existingNominee = $account->nominees()->skip($index)->first();

                if ($existingNominee) {
                    // ✅ Update existing nominee
                    $existingNominee->update([
                        'nominee_name'     => $nomineeData['name'] ?? null,
                        'nominee_relation' => $nomineeData['relation'] ?? null,
                        'nominee_address'  => $nomineeData['address'] ?? null,
                    ]);
                } else {
                    // ✅ Create new nominee entry if not existing
                    $account->nominees()->create([
                        'nominee_name'     => $nomineeData['name'] ?? null,
                        'nominee_relation' => $nomineeData['relation'] ?? null,
                        'nominee_address'  => $nomineeData['address'] ?? null,
                    ]);
                }
            }

            // If fewer nominees submitted than exist in DB → remove extra old ones
            // $totalNew = count($request->nominees);
            // $account->nominees()->skip($totalNew)->delete();
        }

        return redirect()->route('misaccount.show', $id)
            ->with('success', 'Nominee details updated successfully!');
    }

    public function foreClose($id)
    {
        $misaccount = Misaccount::with('member')->findOrFail($id);
        return view('fd_mis_account.misaccount.account-details.foreclose', compact('misaccount'));
    }

    public function removeAccount($id)
    {
        $misaccount = Misaccount::findOrFail($id);
        return view('fd_mis_account.misaccount.account-details.remove-account', compact('misaccount'));
    }

    public function conformRemoveAccount(Request $request, $id)
    {
        $misaccount = Misaccount::findOrFail($id);

        $misaccount->delete();

        return redirect()->route('misaccount.index')
            ->with('Success', 'MIS Account Deleted Successfully');
    }

    public function makeLien($id)
    {
        $misaccount = Misaccount::findOrFail($id);

        return view('fd_mis_account.misaccount.make_lien_against_loan', compact('misaccount'));
    }

    public function creditDebitInterest($id)
    {
        $misaccount = Misaccount::findOrFail($id);
        $balances   = self::getAccountBalance($id);
        $balance    = $balances[$id] ?? 0;

        return view('fd_mis_account.misaccount.interest-tds.credit_debit_interest', compact('misaccount', 'balance'));
    }

    public function storeCreditDebitInterestAndTDS(Request $request, $id)
    {

        $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:credit,debit',
            'amount'           => 'required|numeric|min:0.01',
            'remarks'          => 'nullable|string|max:255',
        ]);

        $misaccount = Misaccount::findOrFail($id);

        // Prepare transaction entry
        $transaction                   = new MisTransaction();
        $transaction->misaccount_id    = $misaccount->id;
        $transaction->transaction_date = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
        $transaction->paid_on          = now();
        $transaction->transaction_type = strtoupper($request->transaction_type); // CREDIT / DEBIT
        $transaction->amount           = $request->amount;
        $transaction->remark           = $request->remarks ?? null;
        $transaction->approve_status   =  "approved";
        // $transaction->pay_mode         = "System";
        // $transaction->created_by       = Auth::id() ?? null;
        $transaction->save();

        Log::info('Credit/Debit Interest Transaction Recorded', [
            'mis_account_id'   => $misaccount->id,
            'account_no'       => $misaccount->account_no ?? null,
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
            ->route('mis.transaction.view', $transaction->id)
            ->with('success', 'Interest ' . ucfirst($request->transaction_type) . ' recorded successfully.');
    }

    public function deductReverseTds($id)
    {
        $misaccount = Misaccount::findOrFail($id);
        $balances   = self::getAccountBalance($id);
        $balance    = $balances[$id] ?? 0;

        return view('fd_mis_account.misaccount.interest-tds.deduct_reverse_tds', compact('misaccount', 'balance'));
    }
}
