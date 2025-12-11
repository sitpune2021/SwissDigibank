<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Comments;
use App\Models\FDScheme;
use App\Models\Member;
use App\Models\Minor;
use App\Models\Misaccount;
use App\Models\MisTransaction;
use App\Models\Document;
use App\Models\Passbook;
use Barryvdh\DomPDF\PDF;
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

            $formattedMisNo = 'MIS' . str_pad($misaccount->id, 9, '0', STR_PAD_LEFT);

            // Update record
            $misaccount->update([
                'mis_account_no' => $formattedMisNo
            ]);

            Log::info('MIS Account No Generated', ['mis_no' => $formattedMisNo]);

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
        $forDisplay = false,
        $misAccount = null
    ) {


        // normalize inputs
        $periodStart = $periodStart instanceof Carbon ? $periodStart->copy()->startOfDay() : Carbon::parse($periodStart)->startOfDay();
        $periodEnd   = $periodEnd instanceof Carbon ? $periodEnd->copy()->startOfDay() : Carbon::parse($periodEnd)->startOfDay();

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

            if ($proposedEnd->lessThan($periodStart)) break;

            // ----- Interest calculation -----
            $daysInYr = $periodStart->isLeapYear() ? 366 : 365;
            $days = (int) $periodStart->diffInDays($proposedEnd) + 1;
            // compute raw interest then normalize/round to avoid binary-float artifacts
            $interest = ($principal * $annualRate * $days) / $daysInYr;
            $interest = (float) $interest;

            // keep accumulated total with higher precision, then round on return/display
            $totalInterest = round($totalInterest + $interest, 12);

            // -------------------- TDS LOGIC (APPLIES TO ALL ROWS) --------------------
            $tdsEnabled = $misAccount && $misAccount->tds_deduction === 'yes';

            $tds = 0;
            if ($tdsEnabled) {
                $tdsThreshold = 40000;
                $projectedTotal = $totalInterest + $interest;

                // If total FY interest exceeds threshold → deduct 10%
                if ($projectedTotal > $tdsThreshold) {
                    $tds = round($interest * 0.10, 2);
                }
            }
            // Net interest is ALWAYS interest - tds (even if tds = 0)
            $netInterest = round($interest - $tds, 2);

            // ✅ BROKEN MONTH LOGIC FOR 31 MARCH
            $isMarchBroken = (
                $proposedEnd->format('m') == "03" &&
                $proposedEnd->format('d') == "31" &&
                $days < 30
            );

            $displayInterest = $interest;
            $displayNetInterest = $netInterest;

            $carryFromPrev = $carryForward ?? 0;

            if ($isMarchBroken) {

                $dueDateDb = null;
                $dueDateDisplay = null;

                $rowStatus = "pending";

                // Carry-forward interest to next period
                $carryForward = $netInterest;

                // Net interest on due date is blank
                $netInterestDueDate = null;
            } else {
                // Normal due date
                $dueDateDb = $proposedEnd->copy()->addDay()->format('Y-m-d');
                $dueDateDisplay = $proposedEnd->copy()->addDay()->format('d-m-Y');

                $rowStatus = "Pending";
                // ✅ NET INTEREST on DUE DATE must include carryForward
                $netInterestDueDate = $netInterest + $carryFromPrev;
                $carryForward = 0;
            }

            $fyLabel = $periodStart->month > 3
                ? "{$periodStart->year}-" . ($periodStart->year + 1)
                : ($periodStart->year - 1) . "-{$periodStart->year}";

            //  Only assign due date if NOT LAND
            if (!$isMarchBroken) {
                $dueDateDb = $proposedEnd->copy()->addDay()->format('Y-m-d');
                $dueDateDisplay = $proposedEnd->copy()->addDay()->format('d-m-Y');
            }

            $data = [
                'period'           => $periodStart->format('d M y') . ' - ' . $proposedEnd->format('d M y'),
                'days'             => (int) $days,
                'principal'        => round($principal, 2),
                'interest'         => $displayInterest,
                'tds'              => $tds,
                'net_interest'     => $displayNetInterest,
                'net_interest_due_date'     => $netInterestDueDate,
                'maturity_partial' => round($principal + $totalInterest, 2),
                'payout_type'      => $payoutType,
            ];



            if ($forDisplay) {
                $data['from'] = $periodStart->format('d M y');
                $data['to'] = $proposedEnd->format('d M y');
                $data['fy_label'] = 'FY ' . ($fyLabel);
                $data['due_date'] = $dueDateDisplay;
                $data['due_date_db'] = $dueDateDb;
                $data['interest'] = $interest;
                $data['tds'] = $tds;
                $data['net_interest'] = $netInterest;
                $data['net_interest_due_date'] = $netInterestDueDate;
                $data['status'] = $rowStatus;
                $data['processed'] = 0;



                if (!$isMarchBroken && $transactions && isset($transactions[$dueDateDb])) {
                    $tx = $transactions[$dueDateDb];
                    $data['status'] = $tx['status'] ?? 'Paid';
                    $data['processed'] = isset($tx['processed']) && $tx['processed'] ? 1 : 0;
                }

                if ($isMarchBroken) {
                    // LAND row but NOT processed yet
                    $data['status'] = "LAND";
                    $data['processed'] = 0;

                    // If a LAND transaction exists in DB:
                    if ($transactions) {
                        foreach ($transactions as $tx) {
                            if ($tx['status'] === "LAND") {
                                $data['processed'] = 2;
                            }
                        }
                    }
                }
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
            true,
            $misAccount
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
            'due_date'      => 'nullable|date',
            'period_from'   => 'required|string',
            'period_to'     => 'required|string',
        ]);

        try {
            $response = DB::transaction(function () use ($validated) {

                $dueDate = isset($validated['due_date'])
                    ? Carbon::parse($validated['due_date'])->format('Y-m-d')
                    : null;

                $periodTo = Carbon::parse($validated['period_to']);
                $isLand = $periodTo->format('d-m') === '31-03';

                $status = $isLand ? 'LAND' : 'Paid';
                $processed = $isLand ? 2 : 1;

                $transaction = MisTransaction::create([
                    'misaccount_id'    => $validated['misaccount_id'],
                    'transaction_date' => now(),
                    'transaction_type' => 'credit',
                    'approve_status'   => 'approved',
                    'amount'           => $validated['net_interest'],
                    'interest'         => $validated['interest'],
                    'tds'              => $validated['tds'],
                    'net_interest'     => $validated['net_interest'],
                    'due_date'         => $dueDate,
                    'status'           => $status,
                    'remark'           => 'MIS Interest Payout from '
                        . $validated['period_from']
                        . ' to '
                        . $validated['period_to'],
                    'period_from'      => $validated['period_from'],
                    'period_to'        => $validated['period_to'],
                    'processed'        => $processed,
                ]);

                Log::info("MIS payout processed", [
                    'misaccount_id'  => $validated['misaccount_id'],
                    'transaction_id' => $transaction->id,
                    'due_date'       => $dueDate,
                    'net_interest'   => $validated['net_interest'],
                ]);

                return [
                    'success'         => true,
                    'processed_label' => 'Yes',
                    'state'           => $status,
                    'processed'       => $processed,
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

        return view('fd_mis_account.misaccount.view-transaction.viewtransaction', compact('misaccount', 'transactions', 'balance'));
    }

    public function transaction($id)
    {
        $transaction = MisTransaction::with(['misaccount.member', 'misaccount.branch'])
            ->findOrFail($id);

        $misaccount = $transaction->misaccount;


        return view('fd_mis_account.misaccount.view-transaction.transaction', compact('misaccount', 'transaction'));
    }

    public function printReceipt($id)
    {

        $transaction = MisTransaction::with([
            'misaccount.member'
        ])->findOrFail($id);

        $accountId = $transaction->misaccount_id;

        $balances = self::getAccountBalance($accountId);
        $balance  = $balances[$accountId] ?? 0;



        $printedOn = now()->format('d-m-Y h:i A');
        $printedBy = Auth::user()->name ?? 'System';

        $data = [
            'transaction' => $transaction,
            'balance'     => $balance,
            'printedOn'   => $printedOn,
            'printedBy'   => $printedBy,
        ];

        // Load PDF
        $pdf = app('dompdf.wrapper')
            ->loadView('fd_mis_account.misaccount.view-transaction.printtransaction', $data)
            ->setPaper([0, 0, 226.77, 800], 'portrait');
        /**
         * 80mm thermal width = 226.77 points
         * height flexible (800 points)
         */

        return $pdf->stream('payment-receipt-' . $id . '.pdf');
    }


    public function show($id)
    {
        $misaccount = MisAccount::with(['member', 'transactions', 'fdScheme.fdslabs'])->where('id', $id)->first();

        $branches = Branch::all();
        $documents = Document::where('mis_id', $misaccount->id)->get();
        $passbooks = Passbook::where('account_type', 'MIS Accounts')
            ->where('account_no', $misaccount->id)
            ->get();
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

        return view('fd_mis_account.misaccount.show', compact('misaccount', 'passbooks', 'savingAccounts', 'branches', 'balance', 'documents', 'transactions'));
    }

    // edit editBranch
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

    public function changeAccountInfo($id)
    {
        $account = Misaccount::with('member.kyc')->findOrFail($id);

        // Members list fetch -> ['id' => 'member_name']
        $members = Member::select('id', 'member_info_first_name', 'member_info_middle_name', 'member_info_last_name')
            ->get()
            ->mapWithKeys(function ($m) {
                return [
                    $m->id => trim($m->member_info_first_name . ' ' . ($m->member_info_middle_name ?? '') . ' ' . $m->member_info_last_name)
                ];
            });

        $schemes = FdScheme::pluck('scheme_name', 'id');

        $balances = self::getAccountBalance($id);
        $balance  = $balances[$id] ?? 0;

        // Joint members ke dropdown me se selected member_id hata do
        $jointMembers = $members->except($account->member_id);

        return view('fd_mis_account.misaccount.account-details.change_account_info', compact('account', 'members', 'jointMembers', 'schemes', 'balance'));
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
        $account = Misaccount::with('member', 'nominees')->findOrFail($id);
        $member = $account->member;
        return view('fd_mis_account.misaccount.account-details.add_nominee', compact('account', 'member'));
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
    public function linkSavingsAccount($id)
    {
        $misaccount = MisAccount::with('member.accounts')->findOrFail($id);

        return view('fd_mis_account.misaccount.linksavingaccount', compact('misaccount'));
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

    public function misBondForm($id)
    {
        $misaccount = Misaccount::with(['member', 'fdScheme.fdslabs'])->findOrFail($id);
        // Calculate amount in words
        $amountWords = $this->numToWords((int) round($misaccount->maturity_amount)) . ' Only';

        $data = [
            'misaccount' => $misaccount,
            'amount_words' => $amountWords,
            'company_address' => 'HEAD OFFICE',
            'date' => now()->format('d-m-Y'),
            'company_reg_no' => 'Reg. No. 969/03-04',
        ];

        $pdf = app('dompdf.wrapper')->loadView('fd_mis_account.misaccount.print-documents.misbond', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('mis-bond-' . $misaccount->id . '.pdf');

        // $pdf = PDF::loadView('misaccount.print-documents.misbond', $data)
        //           ->setPaper('a4', 'portrait');

        // return $pdf->stream('mis-bond-' . $deposit->id . '.pdf');
    }

    protected function numToWords($number)
    {
        $words = [
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];

        if ($number == 0) return 'Zero';

        $crores = floor($number / 10000000);
        $number -= $crores * 10000000;
        $lakhs = floor($number / 100000);
        $number -= $lakhs * 100000;
        $thousands = floor($number / 1000);
        $number -= $thousands * 1000;
        $hundreds = floor($number / 100);
        $number -= $hundreds * 100;
        $tens = floor($number / 10) * 10;
        $units = $number % 10;

        $result = '';

        if ($crores) $result .= $this->numToWords($crores) . ' Crore ';
        if ($lakhs) $result .= $this->numToWords($lakhs) . ' Lakh ';
        if ($thousands) $result .= $this->numToWords($thousands) . ' Thousand ';
        if ($hundreds) $result .= $this->numToWords($hundreds) . ' Hundred ';

        if ($tens || $units) {
            if ($result != '') $result .= 'and ';
            if ($tens < 20) {
                $result .= $words[$tens + $units];
            } else {
                $result .= $words[$tens];
                if ($units) $result .= '-' . $words[$units];
            }
        }

        return trim($result);
    }

    public function misOpeningForm($id)
    {

        // Load MIS account with all required relations
        $account = Misaccount::with([
            'member.kyc',
            'member.address.state',
            'member.branch',
            'fdScheme.fdslabs'
        ])->findOrFail($id);

        $slab = $account->fdscheme->fdslabs
            ->where('from_month', '<=', $account->tenure)
            ->where('to_month', '>=', $account->tenure)
            ->first();

        $interestRate = $slab->interest_rate ?? $account->rate_of_interest;


        $member = $account->member;


        return view('fd_mis_account.misaccount.print-documents.accountopeningform', compact('account', 'member', 'interestRate'));
    }


    public function misClosingForm($id)
    {
        $misaccount = Misaccount::with(['member.branch'])->findOrFail($id);

        $data = [
            'name'            => $misaccount->member->member_info_first_name . ' ' . $misaccount->member->member_info_last_name,
            'date'            => now()->format('d-m-Y'),
            'agreement_no'    => $mis->mis_no ?? 'MIS' . str_pad($misaccount->id, 5, '0', STR_PAD_LEFT),
            'holder_name'     => strtoupper($misaccount->member->member_info_first_name . ' ' . $misaccount->member->member_info_last_name),
            'expiry_date'     => \Carbon\Carbon::parse($misaccount->maturity_date)->format('d-m-Y'),
            'branch_name'     => $misaccount->member->branch->branch_name ?? ' ',
            'branch_address'  => $misaccount->member->branch->branch_address ?? ' ',
        ];

        $pdf = app('dompdf.wrapper')->loadView('fd_mis_account.misaccount.print-documents.closingform', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('mis-closing-form-' . $misaccount->id . '.pdf');
    }


    public function uploadDocuments($id)
    {
        $misaccount = Misaccount::with('member')->findOrFail($id);
        return view('fd_mis_account.misaccount.upload_documents', compact('misaccount'));
    }

    public function storeDocuments(Request $request, $id)
    {
        $misaccount = Misaccount::findOrFail($id);

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
                    'mis_id' => $misaccount->id,
                    'document_type' => $docType,
                    'file_path' => $path,
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('misaccount.show', $id)
            ->with('success', 'Documents uploaded successfully.');
    }


    public function addComment($id)
    {
        $misaccount = Misaccount::with('comments')->findOrFail($id);
        return view('fd_mis_account.misaccount.add-comment', compact('misaccount'));
    }

    public function storeComment(Request $request, $id)
    {

        $request->validate([
            'comment'       => 'required|string',
        ]);

        Comments::create([
            'misaccount_id' => $id,
            'commented_by'  => auth::id(),
            'date'          => now()->toDateString(),
            'comment'       => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function updateSetting(Request $request, $id)
    {
        $mis = Misaccount::findOrFail($id);

        $field = $request->field;
        $value = $request->value;

        if (!in_array($field, ['sms', 'tds', 'hold'])) {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        $mis->$field = $value;
        if ($field === 'tds') {
            $mis->tds_deduction = $value ? 'yes' : 'no';
        }
        $mis->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Delete file from storage
        if (file_exists(storage_path('app/public/' . $document->file_path))) {
            unlink(storage_path('app/public/' . $document->file_path));
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
