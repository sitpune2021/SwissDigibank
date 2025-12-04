<?php

namespace App\Http\Controllers;

use App\Helpers\CsvExportHelper;
use App\Models\Bank;
use App\Models\DailyWeeklyLoanTransaction;
use App\Models\DailyWeeklyApplication;
use App\Models\DailyWeeklyLoanForeClosure;
use App\Models\DailyWeeklyLoanOtherCharge;
use App\Models\DailyWeeklyLoanExtension;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyWeeklyAccount extends Controller
{

    // index page
    public function index(Request $request)
    {
        $goldLoan = DailyWeeklyApplication::with(['member', 'branch', 'scheme', 'DailyWeeklyLoanTransaction'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->paginate(10);

        foreach ($goldLoan as $loan) 
        {

            // Loan total amount
            $loanAmount = $loan->loan_amount;

            // Sum of collected EMI from daily_weekly_loan_transactions table
            $collectedAmount = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges from daily_weekly_loan_other_charges table
            $otherCharges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            // Attach dynamic values for UI
            $loan->current_debt = $currentDebt;

            $loan->close_date = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('created_at');

            // Status update
            $loan->foreclosure_status = $remainingAmount > 0 || $currentDebt == 0 ? 'Fore Close' : 'Active';
        }

        return view('daily_weekly.account.index', compact('goldLoan'));
    }

    // view page
    public function show(Request $request, $id)
    {

        $savedStatuses = DB::table('daily_weekly_loan_emi_status')
        ->where('loan_id', $id)
        ->pluck('status', 'emi_no')
        ->toArray();

        $savedPaidDates = DB::table('daily_weekly_loan_emi_status')
        ->where('loan_id', $id)
        ->pluck('paid_date', 'emi_no')
        ->toArray();

        // Total Deposit
        $totalDeposit = DB::table('daily_weekly_loan_transactions')
            ->where('loan_id', $id)
            ->sum('amount_collected');
            
            // NEW: Total Foreclosure Amount
            $foreclosureDeposit = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $id)
                ->sum('net_amount_k');

            // Update Total Deposit (Already Transactions + Other Charges calculated)
            $totalDeposit = $totalDeposit + $foreclosureDeposit;


        // Total from Other Charges (only paid)
        $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
            ->where('loan_id', $id)
            ->where('status', 'paid')
            ->sum('amount');

        // FINAL DEPOSIT = Transactions + Other Charges
        $totalDeposit = $totalDeposit + $otherChargesDeposit;

        // Latest total_payable (from last transaction)
        $totalPayable = DB::table('daily_weekly_loan_transactions')
            ->where('loan_id', $id)
            ->orderByDesc('id')
            ->value('total_payable') ?? 0;

        
        $goldLoan = DailyWeeklyApplication::with(['member.branch', 'branch', 'scheme', 'coApplicant1', 'guarantor1', 'DailyWeeklyLoanTransaction'])->find($id);

        
        if (!$goldLoan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        $applicationDate = Carbon::parse($goldLoan->application_date);
        $firstEmiDate = $applicationDate->copy()->addMonthNoOverflow();

        $emiCount = $goldLoan->tenure_value;
        $principal = $goldLoan->loan_amount;
        $interestRate = $goldLoan->scheme->annual_interest_rate ?? 0;

        //$interestType = strtolower($goldLoan->scheme->gold_loan_setting ?? 'flat_emi'); // default
        $interestType = 'reducing_emi';
        $emiSchedule = [];
        $balance = $principal;

        $monthlyRate = $interestRate / 12 / 100;

        switch ($interestType) 
        {

            case 'reducing_emi':

                $emi = $principal * ($monthlyRate * pow(1 + $monthlyRate, $emiCount)) / (pow(1 + $monthlyRate, $emiCount) - 1);
                for ($i = 0; $i < $emiCount; $i++) {
                    $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);
                    $interest = $balance * $monthlyRate;
                    $principalComponent = $emi - $interest;
                    $balance -= $principalComponent;

                    $emiSchedule[] = [
                        'emi_no' => $i + 1,
                        'emi_date' => $emiDate->format('d-m-Y'),
                        'emi_due_date' => $emiDate->copy()->addDay()->format('d-m-Y'),
                        'principal' => number_format($principalComponent, 2),
                        'interest' => number_format($interest, 2),
                        'other_charges' => '0.00',
                        'emi_amount' => number_format($emi, 2),
                        'balance_principal' => number_format(max($balance, 0), 2),
                        'remaining_amount' => '0.00',
                        'paid_date' => '',
                        'status' => 'PENDING',
                        'processed' => 'No',
                    ];
                }
                break;

            }

       
        // Apply payments & auto status logic
        // ⭐ Apply payments on EMI schedule (front-end calculation only)
        $totalPaid = DailyWeeklyLoanTransaction::where('loan_id', $id)->sum('amount_collected');

        foreach ($emiSchedule as &$emi) 
        {

            $emiAmount = floatval(str_replace(',', '', $emi['emi_amount']));

            // Already paid nothing?
            if ($totalPaid <= 0) 
            {
                $emi['remaining_amount'] = number_format($emiAmount, 2);

                // ⭐ ALWAYS load saved statuses from DB
                if (isset($savedStatuses[$emi['emi_no']])) {
                    $emi['status'] = $savedStatuses[$emi['emi_no']];
                    $emi['paid_date'] = $savedPaidDates[$emi['emi_no']] ?? '';
                } else {
                    // Default if no data saved
                    $emi['status'] = "UNPAID";
                }

                continue;
            }

            // Full payment
            if ($totalPaid >= $emiAmount) {
                $emi['remaining_amount'] = "0.00";
                $emi['status'] = "PAID";
                $totalPaid -= $emiAmount;
            }
            // Partial payment
            else {
                $emi['remaining_amount'] = number_format($emiAmount - $totalPaid, 2);
                $emi['status'] = "PARTIAL";
                $totalPaid = 0;
            }

        }

        $eirSchedule = [];

        // EIR should run for both flat_emi AND reducing_emi
        if (in_array($interestType, ['flat_emi', 'reducing_emi'])) {

            $monthlyRate = $interestRate / 12 / 100;
            $balanceEIR = $principal;

            // effective EMI formula
            $eirEmi = $principal * ($monthlyRate * pow(1 + $monthlyRate, $emiCount)) /
                    (pow(1 + $monthlyRate, $emiCount) - 1);

            for ($i = 0; $i < $emiCount; $i++) {

                $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);

                $interestEIR = $balanceEIR * $monthlyRate;
                $principalEIR = $eirEmi - $interestEIR;
                $balanceEIR -= $principalEIR;

                $eirSchedule[] = [
                    'emi_no' => $i + 1,
                    'emi_date' => $emiDate->format('d-m-Y'),
                    'emi_due_date' => $emiDate->copy()->addDay()->format('d-m-Y'),
                    'principal' => number_format($principalEIR, 2),
                    'interest' => number_format($interestEIR, 2),
                    'other_charges' => '0.00',
                    'emi_amount' => number_format($eirEmi, 2),
                    'balance_principal' => number_format(max($balanceEIR, 0), 2),
                    'remaining_amount' => '0.00',
                ];
            }
        }

        // Close date code
            // Fetch Principal Loan Amount
            $loanAmount = $principal;

            // Step 1: Collect all deposits with their date
            $depositTimeline = [];

            // EMI Transactions
            $transactions = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->select('amount_collected as amount', 'created_at')
                ->get();

            // Other Charges (Only Paid)
            $otherCharges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->select('amount', 'created_at')
                ->get();

            // Foreclosure Deposit
            $foreclosurePayments = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $id)
                ->select('net_amount_k as amount', 'created_at')
                ->get();

            // Merge All
            foreach ($transactions as $t) {
                $depositTimeline[] = ['amount' => $t->amount, 'date' => $t->created_at];
            }
            foreach ($otherCharges as $oc) {
                $depositTimeline[] = ['amount' => $oc->amount, 'date' => $oc->created_at];
            }
            foreach ($foreclosurePayments as $f) {
                $depositTimeline[] = ['amount' => $f->amount, 'date' => $f->created_at];
            }

            // Sort by Date
            usort($depositTimeline, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));


            // STEP 2: Find close date (when cumulative >= loan amount)
            $cumulative = 0;
            $closeDate = null;

            foreach ($depositTimeline as $entry) {
                $cumulative += $entry['amount'];

                if ($cumulative >= $loanAmount) {
                    $closeDate = Carbon::parse($entry['date'])->format('d-m-Y');
                    break;
                }
            }
        // end close date code

        // current statment chart code

            // ⭐ CURRENT STATEMENT TABLE DATA ⭐
            $currentStatement = collect([]);

            // 1️⃣ Transactions (EMI)
            $transactions = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->select(
                    'created_at as date',
                    DB::raw("'EMI Payment' as type"),
                    DB::raw("'' AS payment_mode"),              // ← no payment_mode column — return empty
                    'amount_collected as amount',
                    DB::raw("'PAID' as status")
                )
                ->get();

            // 2️⃣ Other Charges
            $otherCharges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->select(
                    'created_at as date',
                    DB::raw("'Other Charge' as type"),
                    DB::raw("'' AS payment_mode"),              // ← empty
                    'amount',
                    'status'
                )
                ->get();

            // 3️⃣ Foreclosure Payments
            $closures = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $id)
                ->select(
                    'created_at as date',
                    DB::raw("'Foreclosure Payment' as type"),
                    DB::raw("'' AS payment_mode"),              // ← empty
                    'net_amount_k as amount',
                    DB::raw("'PAID' as status")
                )
                ->get();

            $currentStatement = $currentStatement
                ->merge($transactions)
                ->merge($otherCharges)
                ->merge($closures);

            // Sort latest first
            $currentStatement = $currentStatement->sortByDesc('date')->values();

        // end current statement code

        // ornaments show on chart

            // ⭐ Fetch Ornaments Based on Loan ID
            $ornaments = DB::table('mortgage_properties')
                ->where('loan_application_id', $id)
                ->select(
                    'property_type',
                    'expected_value',
                    'registered'   
                )
                ->get();

        // end ornaments show on chart

        // DYNAMIC SUMMARY CHART VALUES 

            // PAID = Total deposit from calculation above
            $paidNetPrincipal = min($totalDeposit, $principal); 

            // SINCE interest_paid column exists nahi hai → default zero rakho
            $paidInterest = 0;

            // PRINCIPAL DUE
            $emiPrincipalDue = max($principal - $paidNetPrincipal, 0);

            // TOTAL INTEREST PLANNED (from schedule)
            $totalInterestPlanned = array_sum(array_map(fn($emi) => floatval(str_replace(',', '', $emi['interest'])), $emiSchedule));

            // INTEREST DUE = full interest (because no interest deposited yet)
            $interestDue = $totalInterestPlanned;

            // OTHER CHARGES PAID
            $otherChargesPaid = $otherChargesDeposit;

            // OTHER CHARGES DUE
            $otherChargesTotal = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->sum('amount');
            $otherChargesDue = max($otherChargesTotal - $otherChargesPaid, 0);


            // BUILD DATA FOR TABLE (PAID ROW)
            $paidSummary = [
                'net_p' => number_format($paidNetPrincipal, 2),
                'emi_p' => number_format($paidNetPrincipal, 2),
                'emi_int' => "0.00", // because interest_paid not stored yet
                'emi_charges' => "0.00",
                'overdue_int' => "0.00",
                'other_charges' => number_format($otherChargesPaid, 2),
                'advance' => "0.00",
                'discount' => "0.00",
            ];

            // BUILD DATA FOR TABLE (DUE ROW)
            $dueSummary = [
                'net_p' => number_format($emiPrincipalDue, 2),
                'emi_p' => number_format($emiPrincipalDue, 2),
                'emi_int' => number_format($interestDue, 2),
                'emi_charges' => "0.00",
                'overdue_int' => "0.00",
                'other_charges' => number_format($otherChargesDue, 2),
                'advance' => "-",
                'discount' => "-",
            ];
        
        // end DYNAMIC SUMMARY CHART VALUES 

        $currentDebt = max($goldLoan->loan_amount - $totalDeposit, 0);


        return view('daily_weekly.account.view', compact(
            'goldLoan',
            'principal',
            'firstEmiDate',
            'emiSchedule',
            'eirSchedule',
            'closeDate',
            'currentStatement',
            'ornaments',
            'paidSummary', 'dueSummary',
            'totalDeposit',   
            'currentDebt'     
        ));
        
    }

    // process button status store
    public function saveEmiStatus(Request $request)
    {
        $request->validate([
            'loan_id'          => 'required|integer',
            'emi_no'           => 'required|integer',
            'status'           => 'required|string',
            'remaining_amount' => 'required|numeric'
        ]);

        DB::table('gold_loan_emi_status')->updateOrInsert(
            [
                'loan_id' => $request->loan_id,
                'emi_no'  => $request->emi_no
            ],
            [
                'status'           => $request->status,
                'remaining_amount' => $request->remaining_amount,
                'paid_date'        => now()->format('d-m-Y')
            ]
        );

        return response()->json(['success' => true]);
    }

    // pay emi tab page
    public function mortgagePayEmi($id)
    {
        $goldLoan = DailyWeeklyApplication::with([
            'member.branch',
            'branch',
            'scheme',
            'coApplicant1',
            'guarantor1'
        ])->findOrFail($id);

        $emiType = $goldLoan->scheme->gold_loan_setting;
        $totalLoan = $goldLoan->loan_amount;
        $interestRate = $goldLoan->scheme->interest_rate ?? 0;
        $emiCount = $goldLoan->scheme->emi_count ?? 12;

        $totalPaid = DailyWeeklyLoanTransaction::where('loan_id', $goldLoan->id)
            ->sum('amount_collected');

        $remainingAmount = 0;
        $emiAmount = 0;
        $netDisbursed = 0;

        switch ($emiType) {
            case 'flat_advanced_interest':
                $totalInterest = $totalLoan * ($interestRate / 100) * ($emiCount / 12);
                $netDisbursed = $totalLoan - $totalInterest;
                $emiAmount = round($totalLoan / $emiCount, 2);
                $remainingAmount = $totalLoan - $totalPaid;
                break;

            case 'flat_interest':
                $totalInterest = $totalLoan * ($interestRate / 100) * ($emiCount / 12);
                $totalPayable = $totalLoan + $totalInterest;
                $emiAmount = $totalPayable / $emiCount;
                $remainingAmount = $totalPayable - $totalPaid;
                break;

            case 'reducing_interest':
                $monthlyRate = $interestRate / (12 * 100);
                $emiAmount = $totalLoan * ($monthlyRate * pow(1 + $monthlyRate, $emiCount)) / (pow(1 + $monthlyRate, $emiCount) - 1);
                $totalPayable = $emiAmount * $emiCount;
                $remainingAmount = $totalPayable - $totalPaid;
                break;

            default:
                $emiAmount = $totalLoan / $emiCount;
                $remainingAmount = $totalLoan - $totalPaid;
                break;
        }

        $overdueInterest = 0;
        $otherCharges = 0;
        $gstRate = 18;
        $gstAmount = ($overdueInterest * $gstRate) / 100;
        $totalOverdueWithGst = $overdueInterest + $gstAmount;
        $totalAmount = $remainingAmount + $overdueInterest + $otherCharges;

        $rounding = round($totalAmount) - $totalAmount;
        $netAmount = $totalAmount + $rounding;

        $goldLoan->current_debt = $remainingAmount;

        $firstPendingEmi = DailyWeeklyLoanTransaction::where('loan_id', $goldLoan->id)
            ->where('status', '!=', 'PAID')
            ->orderBy('emi_no', 'asc')
            ->first();

        if ($firstPendingEmi) {
            $firstPendingEmi->status = 'PROCESSING';
            $firstPendingEmi->paid_date = now();
            $firstPendingEmi->save();

            Log::info('First EMI updated successfully', [
                'loan_id' => $goldLoan->id,
                'emi_no' => $firstPendingEmi->emi_no,
                'status' => $firstPendingEmi->status,
            ]);
        }

        return view('daily_weekly.account.view-buttons.pay-emi.pay_emi', compact(
            'goldLoan',
            'emiAmount',
            'remainingAmount',
            'netDisbursed',
            'overdueInterest',
            'otherCharges',
            'gstRate',
            'totalOverdueWithGst',
            'totalAmount',
            'rounding',
            'netAmount'
        ));
    }

    // pay emi tab data store in mortage loan transiction table
    public function mortgagepayEmiLoan(Request $request, $id)
    {
        Log::info("🟩 EMI Payment Request Received", [
            'loan_id' => $id,
            'payload' => $request->all()
        ]);

        try {

            // 🔥 REMOVE COMMA FROM AMOUNT BEFORE VALIDATION
            $cleanAmount = str_replace(',', '', $request->amount_collected);
            $request->merge(['amount_collected' => $cleanAmount]);


            $request->validate([
                'transaction_date' => 'required|date',
                'amount_collected' => 'required|numeric|min:1',
                'remarks' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            Log::info("🟦 Validation Passed for Loan ID: $id");

            $loan = DailyWeeklyApplication::with('scheme')->findOrFail($id);

            $totalPaid = DailyWeeklyLoanTransaction::where('loan_id', $loan->id)
                ->sum('amount_collected');

            $remainingDue = max($loan->loan_amount - $totalPaid, 0);

            $amountCollected = (float) $cleanAmount;
            $newRemainingDue = max($remainingDue - $amountCollected, 0);


            Log::info("🔍 Calculation", [
                'remaining_due' => $remainingDue,
                'amount_collected' => $amountCollected,
                'new_remaining_due' => $newRemainingDue
            ]);


            // Upload File
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('goldloan_receipts', 'public');
                Log::info("🟨 Receipt uploaded: " . $receiptPath);
            }

            // 🔥 GET NEXT EMI NUMBER (COUNT + 1)
            $nextEmiNo = DailyWeeklyLoanTransaction::where('loan_id', $loan->id)->count() + 1;

            Log::info("➡️ Next EMI No Calculated", [
                'loan_id' => $loan->id,
                'next_emi_no' => $nextEmiNo
            ]);

            // Store Transaction
            $transaction = new DailyWeeklyLoanTransaction();
            $transaction->loan_id = $loan->id;
            $transaction->transaction_date = date('Y-m-d', strtotime($request->transaction_date));
            $transaction->amount_collected = $amountCollected;
            $transaction->current_debt = $newRemainingDue;
            $transaction->other_charges = 0;
            $transaction->total_payable = $remainingDue;
            $transaction->status = 'paid';
            $transaction->remarks = $request->remarks ?? null;
            $transaction->flag = 'emi_payment';
            $transaction->created_by = Auth::id() ?? null;

            // 🟩 NEW LINE — SAVE EMI NO
            $transaction->emi_no = $nextEmiNo;

            if ($receiptPath) {
                $transaction->receipt = $receiptPath;
            }

            Log::info("📝 Transaction Before Save", $transaction->toArray());

            $transaction->save();

            Log::info("🟩 Transaction saved successfully!", [
                'transaction_id' => $transaction->id
            ]);

            if ($newRemainingDue <= 0) {
                $loan->status = 'closed';
                $loan->save();

                Log::info("🟢 Loan Closed Automatically", [
                    'loan_id' => $loan->id
                ]);
            }

            return redirect()->route('daily_weekly.account.show', $loan->id)
                ->with('success', 'EMI Payment recorded successfully!');

        } catch (\Exception $e) {

            Log::error("❌ EMI PAYMENT ERROR", [
                'loan_id' => $id,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return back()->with('error', "Something went wrong: " . $e->getMessage());
        }
    }

    // Transiction tab 
    public function mortgageTransaction(Request $request, $id)
    {
        $account = DailyWeeklyApplication::findOrFail($id);

        // 1. TRANSACTIONS
        $transactions = DailyWeeklyLoanTransaction::where('loan_id', $id)
            ->get()
            ->map(function ($t) {
                return (object)[
                    'date' => $t->transaction_date,
                    'fee_mode' => $t->fee_mode,
                    'remarks' => $t->remarks,
                    'status' => $t->status,
                    'type' => 'transaction',
                    'amount' => 0,
                    'amount_collected' => $t->amount_collected,
                    'total_payable' => $t->total_payable,
                ];
            });

        // 2. OTHER CHARGES (PAID ONLY)
        $otherCharges = DailyWeeklyLoanOtherCharge::where('loan_id', $id)
            ->where('status', 'paid')
            ->get()
            ->map(function ($o) {
                return (object)[
                    'date' => $o->charge_date,
                    'fee_mode' => 'system',
                    'remarks' => $o->remarks,
                    'status' => $o->status,
                    'type' => 'other_charge',
                    'amount' => $o->amount,
                    'amount_collected' => 0,
                    'total_payable' => 0,
                ];
            });

        // 3. FORECLOSURE ENTRIES
        $foreclosure = DailyWeeklyLoanForeClosure::where('loan_id', $id)
            ->get()
            ->map(function ($f) {
                return (object)[
                    'date' => $f->transaction_date,
                    'fee_mode' => $f->payment_mode ?? 'closure',
                    'remarks' => $f->remarks ?? 'Loan Foreclosed',
                    'status' => $f->status == 1 ? 'closed' : 'pending',
                    'type' => 'foreclosure',
                    'amount' => $f->remaining_amount, // debit column value
                    'amount_collected' => 0,
                    'total_payable' => 0,
                ];
            });


        // 4. MERGE + SORT ASC (balance calculation ke liye)
        $merged = $transactions
            ->merge($otherCharges)
            ->merge($foreclosure)
            ->sortBy('date')
            ->values();

        // 4. RUNNING BALANCE
        $runningBalance = 0;
        $started = false;

        $processed = $merged->map(function ($row) use (&$runningBalance, &$started) {

            if (!$started && $row->type === 'transaction') {
                // first transaction row initializes balance
                $runningBalance = $row->total_payable - $row->amount_collected;
                $started = true;
            } else {
                if ($row->type === 'transaction') {
                    $runningBalance -= $row->amount_collected;
                }
               if ($row->type === 'other_charge' || $row->type === 'foreclosure') {
                    $runningBalance -= $row->amount;
                }

            }

            $row->balance = $runningBalance;
            return $row;
        });

        // 5. LAST STEP → Latest first
        $mergedData = $processed->sortByDesc('date')->values();

        return view(
            'daily_weekly.account.view-buttons.view-transactions.view_transactions',
            compact('account', 'mergedData')
        );
    }

    // Loan extenstion tab page
    public function loanextension($id)
    {
        $goldLoan = DailyWeeklyApplication::with(['member', 'branch', 'scheme', 'DailyWeeklyLoanTransaction'])
            ->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        // Total Deposit
            $totalDeposit = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->sum('amount_collected');
            
            // // Total from Other Charges (only paid)
            $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->sum('amount');

            // // FINAL DEPOSIT = Transactions + Other Charges
            $totalDeposit = $totalDeposit + $otherChargesDeposit;

            // Latest total_payable (from last transaction)
            $totalPayable = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->orderByDesc('id')
                ->value('total_payable') ?? $goldLoan->loan_amount;

            // 1. Total Transaction Deposit
            $transactionDeposit = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->sum('amount_collected');

            // 2. Total Paid Other Charges
            $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->sum('amount');

            // 3. FINAL Total Deposit
            $totalDeposit = $transactionDeposit + $otherChargesDeposit;

            // 4. FINAL Correct Current Debt
            $currentDebt = max($totalPayable - $totalDeposit, 0);

        return view('daily_weekly.account.loan-extension', compact('goldLoan','currentDebt','banks'));

    }

    // Loan extenstion tab page data store
    public function storeLoanExtension(Request $request, $id)
    {
        Log::info('--- Loan Extension Request Received ---', [
            'loan_id' => $id,
            'input' => $request->all()
        ]);

        try 
        {

            $validated = $request->validate([
                'remaining_amount' => 'required|numeric',
                'interest_accrued' => 'nullable|numeric',
                'total_amount_h' => 'required|numeric',
                'rounding_off_i' => 'nullable|numeric',
                'net_amount_k' => 'required|numeric',
                'transaction_date' => 'required',
                'reschedule_date' => 'required',
                'first_emi_date' => 'required',
                'interest_rate' => 'required|numeric',
                'tenure' => 'required|numeric',
                'reason' => 'required|string',
            ]);

            // Convert Dates AFTER validation
            $validated['transaction_date'] = Carbon::parse($validated['transaction_date'])->format('Y-m-d');
            $validated['reschedule_date'] = Carbon::parse($validated['reschedule_date'])->format('Y-m-d');
            $validated['first_emi_date'] = Carbon::parse($validated['first_emi_date'])->format('Y-m-d');

            $validated['loan_id'] = $id;

            $extension = DailyWeeklyLoanExtension::create($validated);

            Log::info('✔ Loan Extension Saved Successfully!', [
                'extension_id' => $extension->id,
            ]);

            return redirect()->route('daily_weekly.account.show')->with('success', 'Loan Extension Successfully Added!');

        } 
        catch (\Throwable $e) 
        {

            Log::error('Loan Extension Save Failed', [
                'loan_id' => $id,
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return back()->with('error', 'Something went wrong while saving!');
        }
    }

    // only pay tab page
    public function mortgagePay($id)
    {
        $goldLoan = DailyWeeklyApplication::with([
            'member.branch',
            'DailyWeeklyLoanTransaction',
            'branch',
            'scheme',
            'coApplicant1',
            'guarantor1'
        ])->findOrFail($id);

        $banks = Bank::all();

        $lastTransaction = $goldLoan->DailyWeeklyLoanTransaction->last();
        $payableAmount = $lastTransaction->total_payable ?? 0;

        if ($lastTransaction) {
            $currentDebt = (float) $lastTransaction->current_debt;
        } else {
            $currentDebt = (float) $goldLoan->loan_amount;
        }

        $currentDebt = round($currentDebt, 2);

        $nextDue = $goldLoan->emiPayments()
            ->where('status', 'pending')
            ->first();

        if (!$nextDue) {
            return view('daily_weekly.account.view-buttons.pay.pay', [
                'goldLoan' => $goldLoan,
                'banks' => $banks,
                'currentDebt' => 0,
                'payableAmount' => 0,
                'message' => 'All EMIs are fully paid.'
            ]);
        }

        $annualRate = (float) $goldLoan->interest_rate;

        $today = Carbon::today();
        $dueDate = Carbon::parse($nextDue->emi_date);

        $daysLate = $dueDate->diffInDays($today, false);
        $daysLate = $daysLate > 0 ? $daysLate : 0;

        $interestTillToday = round(($currentDebt * $annualRate * $daysLate) / 36500, 2);

        $lateFee = $daysLate * 10;

        $emiAmount = (float) $nextDue->emi_amount;

        // $payableAmount = round($emiAmount + $interestTillToday + $lateFee, 2);

        return view('daily_weekly.account.view-buttons.pay.pay', compact(
            'goldLoan',
            'banks',
            'currentDebt',
            'payableAmount',
            'interestTillToday',
            'lateFee',
            'daysLate',
            'nextDue'
        ));
    }

    // update emi status on pay tab
    public function updateEmiStatus(Request $request)
    {
        Log::info('🟢 updateEmiStatus() called', $request->all());

        $request->validate([
            'loan_id' => 'required|integer',
            'status'  => 'required|string',
        ]);

        $emi = DailyWeeklyLoanTransaction::where('loan_id', $request->loan_id)
            ->where('status', 'UNPAID')
            ->orderBy('id', 'asc')
            ->first();

        if (!$emi) {
            Log::warning("⚠️ No unpaid EMI found for loan_id={$request->loan_id}");
            return response()->json(['success' => false, 'message' => 'No unpaid EMI found'], 404);
        }

        Log::info("📝 Before update:", $emi->toArray());

        $emi->status = $request->status; // e.g. 'PAID' or 'DUE'
        $emi->paid_date = now();
        $emi->save();

        Log::info("✅ After update:", $emi->fresh()->toArray());

        return response()->json([
            'success' => true,
            'message' => 'First unpaid EMI status updated successfully',
            'emi' => $emi
        ]);
    }

    // store pay tab data in table
    public function payEmi(Request $request)
    {
        Log::info('payEmi() called', ['request_data' => $request->all()]);

        try {

            Log::info('payEmi(): Starting validation');

            $rules = [
                'loan_id'           => 'required|exists:loan_against_applications,id',
                'transaction_date'  => 'required|date',
                'current_debt'      => 'required|numeric',
                'total_payable'     => 'required|numeric',
                'amount_collected'  => 'required|numeric|min:1',
                'fee_mode'          => 'required|in:cash,cheque,online',
            ];

            if ($request->fee_mode === 'cheque') {

                $rules['bank_id']     = 'required';
                $rules['cheque_no']   = 'required';
                $rules['cheque_date'] = 'required|date';
            }

            if ($request->fee_mode === 'online') {
                $rules['transfer_date'] = 'required|date';
                $rules['utr_no']        = 'required';
                $rules['transfer_mode'] = 'required|in:imps,vpa,neft_rtgs';
                $rules['credited']      = 'required|in:yes,no';
            }

            $request->validate($rules);

            Log::info('payEmi(): Validation passed');

            $loan = DailyWeeklyApplication::find($request->loan_id);

            if (!$loan) {
                Log::error('payEmi(): Loan not found', ['loan_id' => $request->loan_id]);
                return back()->withErrors(['loan_id' => 'Loan not found.']);
            }

            $lastEmiNo = DailyWeeklyLoanTransaction::where('loan_id', $loan->id)->max('emi_no');
            $nextEmiNo = $lastEmiNo ? $lastEmiNo + 1 : 1;

            Log::info('payEmi(): Next EMI Number', [
                'emi_no' => $nextEmiNo,
            ]);

            $paymentDetails = ['mode' => $request->fee_mode];

            if ($request->fee_mode === 'cash') {
                $paymentDetails['fee_mode']  = $request->fee_mode;
                $paymentDetails['description'] = 'Cash payment received';
            }

            if ($request->fee_mode === 'cheque') {
                $paymentDetails['fee_mode']  = $request->fee_mode;
                $paymentDetails['bank_id']     = $request->bank_id;
                $paymentDetails['cheque_no']   = $request->cheque_no;
                $paymentDetails['cheque_date'] = $request->cheque_date;
            }

            if ($request->fee_mode === 'online') {
                $paymentDetails['fee_mode']  = $request->fee_mode;
                $paymentDetails['transfer_date'] = $request->transfer_date;
                $paymentDetails['utr_no']        = $request->utr_no;
                $paymentDetails['transfer_mode'] = $request->transfer_mode;
                $paymentDetails['credited']      = $request->credited;
            }


            $transaction = DailyWeeklyLoanTransaction::create([
                'loan_id'          => $loan->id,
                'emi_no'           => $nextEmiNo,
                'transaction_date' => Carbon::parse($request->transaction_date)->format('Y-m-d'),

                'current_debt'     => $request->current_debt,
                'other_charges'    => $request->other_charges ?? 0,
                'total_payable'    => $request->total_payable,
                'amount_collected' => $request->amount_collected,

                'remarks'          => $request->remarks ?? null,
                'payment_mode'     => $request->fee_mode,
                'payment_details'  => json_encode($paymentDetails),

                'bank_id'          => $request->bank_id ?? null,
                'cheque_no'        => $request->cheque_no ?? null,
                'cheque_date'      => $request->cheque_date ?? null,

                'transfer_date'    => $request->transfer_date ?? null,
                'utr_no'           => $request->utr_no ?? null,
                'transfer_mode'    => $request->transfer_mode ?? null,
                'credited'         => $request->credited ?? null,

                'created_by'       => Auth::id(),
            ]);

            Log::info('payEmi(): Transaction Created', [
                'transaction_id' => $transaction->id,
                'data' => $transaction->toArray()
            ]);

            return redirect()->route('daily_weekly.account.show', $loan->id)->with('success', 'EMI Payment Recorded Successfully.');
        } catch (\Exception $e) {

            Log::error('payEmi(): Exception Occurred', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    // foure closer tab
    public function fourcloser($id)
    {
        $goldLoan = DailyWeeklyApplication::with(['member', 'branch', 'scheme', 'DailyWeeklyLoanTransaction'])
            ->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        // Total Deposit
            $totalDeposit = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->sum('amount_collected');
            
            // // Total from Other Charges (only paid)
            $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->sum('amount');

            // // FINAL DEPOSIT = Transactions + Other Charges
            $totalDeposit = $totalDeposit + $otherChargesDeposit;

            // Latest total_payable (from last transaction)
            $totalPayable = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->orderByDesc('id')
                ->value('total_payable') ?? $goldLoan->loan_amount;

            // 1. Total Transaction Deposit
            $transactionDeposit = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->sum('amount_collected');

            // 2. Total Paid Other Charges
            $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->sum('amount');

            // 3. FINAL Total Deposit
            $totalDeposit = $transactionDeposit + $otherChargesDeposit;

            // 4. FINAL Correct Current Debt
            $currentDebt = max($totalPayable - $totalDeposit, 0);

        return view('daily_weekly.account.view-buttons.fore-close.fore-close', compact('goldLoan','currentDebt','banks'));
    }

    // foure closer store tab
    public function storeForeCloser(Request $request, $loanId)
    {
        Log::info('---- ForeClosure Store Request START ----', [
            'loan_id' => $loanId,
            'request_data' => $request->all()
        ]);

        try {

            // VALIDATION
            $request->validate([
                'remaining_amount'   => 'required|numeric',
                'interest_accrued'   => 'required|numeric',
                'overdue_interest'   => 'required|numeric',
                'notice_charges'     => 'required|numeric',
                'service_charges'    => 'required|numeric',
                'other_charges'      => 'required|numeric',
                'foreclosure_charges'=> 'required|numeric',
                'total_amount_h'     => 'required|numeric',
                'rounding_off_i'     => 'required|numeric',
                'closure_discount_j' => 'required|numeric',
                'net_amount_k'       => 'required|numeric',
                'transaction_date'   => 'required',
                 // optional payment fields validation:
                'payment_mode'           => 'nullable|in:cash,cheque,online',
                'bank_id'            => 'nullable|exists:banks,id',
                'cheque_no'          => 'nullable|string|max:100',
                'cheque_date'        => 'nullable|date',
                'transfer_date'      => 'nullable|date',
                'utr_no'             => 'nullable|string|max:150',
                'transfer_mode'      => 'nullable|in:imps,vpa,neft_rtgs',
                'credited'           => 'nullable|in:0,1',
            ]);

            // STORE DATA
            $save = DailyWeeklyLoanForeClosure::create([
                'loan_id'               => $loanId,

                'remaining_amount'      => $request->remaining_amount,
                'interest_accrued'      => $request->interest_accrued,
                'overdue_interest'      => $request->overdue_interest,

                'notice_charges'        => $request->notice_charges,
                'service_charges'       => $request->service_charges,
                'other_charges'         => $request->other_charges,
                'foreclosure_charges'   => $request->foreclosure_charges,

                'total_amount_h'        => $request->total_amount_h,
                'rounding_off_i'        => $request->rounding_off_i,
                'closure_discount_j'    => $request->closure_discount_j,
                'net_amount_k'          => $request->net_amount_k,

                'transaction_date'      => Carbon::createFromFormat('d-m-Y', $request->transaction_date),
                'remarks'               => $request->remarks,

                 // NEW payment fields mapping from your form names
                'payment_mode'          => $request->input('payment_mode') ?? null,   // cash/cheque/online
                'bank_id'               => $request->input('bank_id') ?? null,
                'cheque_no'             => $request->input('cheque_no') ?? null,
                'cheque_date'           => $request->filled('cheque_date') ? Carbon::parse($request->input('cheque_date')) : null,
                'transfer_date'         => $request->filled('transfer_date') ? Carbon::parse($request->input('transfer_date')) : null,
                'utr_no'                => $request->input('utr_no') ?? null,
                'transfer_mode'         => $request->input('transfer_mode') ?? null,
                'credited'              => is_null($request->input('credited')) ? null : (int)$request->input('credited'),

                'status'                => 0
            ]);

            Log::info('---- ForeClosure Stored Successfully ----', [
                'saved_record' => $save
            ]);

            // UPDATE LOAN STATUS (Active → Inactive)
            DailyWeeklyApplication::where('id', $loanId)->update(['status' => 4]);

            return redirect()
                ->route('daily_weekly.account.show', $loanId)
                ->with('success', 'Fore Closure Stored Successfully!');

        } catch (\Exception $e) {

            Log::error('ForeClosure Store Error', [
                'loan_id' => $loanId,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // link saving account tab
    public function linksaving($id)
    {
        $goldLoan = DailyWeeklyApplication::with(['member', 'branch', 'scheme', 'DailyWeeklyLoanTransaction'])
            ->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        // Fetch all saving accounts for the same member
        $savingAccounts = DB::table('accounts')
            ->where('member_id', $goldLoan->member_id)
            ->where('account_type', 'SAVING')
            ->pluck('account_no', 'id'); // ['id' => 'account_no']


        // Total Deposit
            $totalDeposit = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->sum('amount_collected');
            
            // // Total from Other Charges (only paid)
            $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->sum('amount');

            // // FINAL DEPOSIT = Transactions + Other Charges
            $totalDeposit = $totalDeposit + $otherChargesDeposit;

            // Latest total_payable (from last transaction)
            $totalPayable = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->orderByDesc('id')
                ->value('total_payable') ?? $goldLoan->loan_amount;

            // 1. Total Transaction Deposit
            $transactionDeposit = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $id)
                ->sum('amount_collected');

            // 2. Total Paid Other Charges
            $otherChargesDeposit = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $id)
                ->where('status', 'paid')
                ->sum('amount');

            // 3. FINAL Total Deposit
            $totalDeposit = $transactionDeposit + $otherChargesDeposit;

            // 4. FINAL Correct Current Debt
            $currentDebt = max($totalPayable - $totalDeposit, 0);

        return view('daily_weekly.account.view-buttons.link-saving-acc.link-saving-acc', compact('goldLoan','currentDebt', 'banks', 'savingAccounts'));
    }

    // update and store link saving account in account table and aplication table
    public function storeSavingAccount(Request $request, $loanId)
    {
        $request->validate([
            'saving_account_id' => 'required|exists:accounts,id',
        ]);

        $loan = DailyWeeklyApplication::findOrFail($loanId);

        // Update selected saving account
        DB::table('accounts')
            ->where('id', $request->saving_account_id)
            ->update([
                'loan_type'   => 'daily weekly', // this page का loan category
                'loan_number' => $loan->id, // loan_applications का id
            ]);

        return redirect()->route('daily_weekly.account.show', $loanId)
        ->with('success', 'Saving Account Linked Successfully!');
    }

    // remove account tab
    public function removeAccount(Request $request, $id)
    {
        
        // Basic validation: confirm flag (optional)
        if (!$request->filled('confirm') || $request->input('confirm') != 1) {
            return redirect()->back()->with('error', 'Confirmation missing.');
        }

        DB::beginTransaction();

        try {
            // 1) find loan
            $loan = DailyWeeklyApplication::findOrFail($id);

            // 2) update loan status to 0
            $loan->status = 0;        // or the exact column name you use
            $loan->save();

            // 3) delete related rows from gold_loan_transactions
            DailyWeeklyLoanTransaction::where('loan_id', $loan->id)->delete();

            // 4) delete related rows from gold_loan_other_charges
            DailyWeeklyLoanOtherCharge::where('loan_id', $loan->id)->delete();

            // 5) commit
            DB::commit();

            // optional logging
            Log::info('daily_weekly loan removed', [
                'loan_id' => $loan->id,
                'user_id' => $request->user()->id ?? null,
            ]);

            return redirect()->back()->with('success', 'Account removed, related transactions & charges deleted and status set to 0.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error removing gold loan account', [
                'loan_id' => $id,
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()
            ->route('daily_weekly.account.index')
            ->with('error', 'Something went wrong while removing the account: '.$e->getMessage());
        }
    }

    // audit tab
    public function audit(Request $request)
    { 
        return view('daily_weekly.account.view-buttons.audit-trail.audit-trail');
    }

    // Gold loan debit other charges list page functionality
    public function showDebitChargesList($id)
    {
        $goldLoan = DailyWeeklyApplication::with(['member'])->findOrFail($id);
        return view('daily_weekly.account.view-buttons.debit-other-charges.other-charges-list', compact('goldLoan'));
    }

    public function DebitOtherCharges($id)
    {
        $goldLoan = DailyWeeklyApplication::with(['member', 'scheme', 'DailyWeeklyLoanTransaction'])->findOrFail($id);
        return view('daily_weekly.account.view-buttons.debit-other-charges.debit-other-charges', compact('goldLoan'));
    }

    // store data other debit charge
    public function storeDebitOtherCharges(Request $request, $id)
    {
        try {
            $request->validate([
                'charge_type'  => 'required',
                'amount'       => 'required|numeric|min:0',
                'gst_rate'     => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'charge_date'  => 'required|date',
            ]);

            $formattedDate = Carbon::parse($request->charge_date)->format('Y-m-d');

            $charge = DailyWeeklyLoanOtherCharge::create([
                'loan_id'   => $id,
                'charge_type'  => $request->charge_type,
                'amount'       => $request->amount,
                'gst_rate'     => $request->gst_rate,
                'total_amount' => $request->total_amount,
                'charge_date'  => $formattedDate,
                'remarks'      => $request->remarks,
                'created_by'   => Auth::id(),
            ]);

            DB::beginTransaction();

            $loan = DailyWeeklyApplication::with('DailyWeeklyLoanTransaction')->findOrFail($id);
            $transaction = $loan->DailyWeeklyLoanTransaction()->first();

            if ($transaction) {
                $oldDebt = $transaction->current_debt ?? 0;
                $transaction->current_debt = $oldDebt + $request->total_amount;
                $transaction->save();
            } else {
                Log::warning('⚠️ No related gold loan transaction found for loan', [
                    'loan_id' => $id,
                    'user_id' => Auth::id(),
                ]);
            }

            DB::commit();

            Log::info('Other charge debited successfully', [
                'user_id'     => Auth::id(),
                'account_id'  => $request->loan_id,
                'charge_id'   => $charge->id ?? null,
                'data'        => $request->all(),
            ]);

            return redirect()->route('daily_weekly.debitChargesList.form', $id)->with('success', 'Other charge debited successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed while debiting other charge', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error occurred while storing other charge', [
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
                'user_id'    => Auth::id(),
                'input_data' => $request->all(),
            ]);

            return back()->with('error', 'Something went wrong while saving the other charge. Please try again.');
        }
    }

    // Clear Due
    public function mortgageLoanClearDues($id)
    {
        $goldLoan = DailyWeeklyApplication::with(['member', 'scheme', 'DailyWeeklyLoanTransaction'])->findOrFail($id);
        $totalDue = DailyWeeklyLoanOtherCharge::where('loan_id', $id)
            ->where('status', 'unpaid')
            ->sum('amount');
        $banks = Bank::all();
        return view('daily_weekly.account.view-buttons.debit-other-charges.clear-dues', compact('goldLoan', 'totalDue', 'banks'));
    }

    // update / store clear due tab
    public function clearDue(Request $request, $id)
    {
        $request->validate([
            'waived_amount' => 'required|numeric|min:0.01',
            'remarks'       => 'nullable|string|max:255',
            'payment_mode'          => 'required|in:cash,online,cheque',
        ]);

        Log::info('🟢 Starting daily_weekly due clearance process', [
            'loan_id'       => $id,
            'waived_amount' => $request->waived_amount,
            'user_id'       => Auth::id(),
            'timestamp'     => now()->toDateTimeString(),
        ]);

        if ($request->payment_mode === 'online') {
            $rules['pay1_transfer_utr'] = 'required|string|max:50';
            $rules['transfer_mode'] = 'nullable|string|max:50';
            $rules['credited'] = 'nullable|numeric|max:100';
        }

        if ($request->payment_mode === 'cheque') {
            $rules['pay1_bank'] = 'required|string|max:50';
            $rules['pay1_cheque_no'] = 'required|numeric';
            $rules['pay1_cheque_date'] = 'nullable|date';
        }

        DB::beginTransaction();

        try {
            $loan = DailyWeeklyApplication::with('DailyWeeklyLoanTransaction')->findOrFail($id);

            $goldTxn = $loan->goldLoanTransactions;

            if (!$goldTxn) {
                Log::warning('⚠️ daily_weekly transaction record missing', [
                    'loan_id' => $id,
                    'user_id' => Auth::id(),
                ]);
                return back()->with('error', 'Gold Loan transaction not found.');
            }

            // Step 1: Create a record in daily_weekly_loan_other_charges
            $clearDue = DailyWeeklyLoanOtherCharge::create([
                'loan_id'          => $id,
                'transaction_type' => 'credit',
                'charge_type'      => 'Clear Due',
                'amount'           => $request->waived_amount,
                'charge_date'      => now(),
                'remarks'          => $request->remarks,
                'status'           => 'paid',
                'created_by'       => Auth::id(),
            ]);

            Log::info('🧾 daily_weekly Clear Due entry created successfully', [
                'loan_id'        => $id,
                'charge_id'      => $clearDue->id,
                'charge_type'    => 'Clear Due',
                'amount'         => $request->waived_amount,
                'created_by'     => Auth::id(),
            ]);

            // Step 2: Update the current_debt
            $oldDebt = $goldTxn->current_debt ?? 0;
            $goldTxn->current_debt = max(0, $oldDebt - $request->waived_amount);
            $goldTxn->save();

            Log::info('💰 daily_weekly current debt updated', [
                'loan_id'        => $id,
                'previous_debt'  => $oldDebt,
                'cleared_amount' => $request->waived_amount,
                'remaining_debt' => $goldTxn->current_debt,
                'updated_by'     => Auth::id(),
            ]);

            DB::commit();

            Log::info('✅ daily_weekly due cleared successfully', [
                'loan_id'         => $id,
                'transaction_id'  => $clearDue->id,
                'cleared_amount'  => $request->waived_amount,
                'remaining_debt'  => $goldTxn->current_debt,
                'user_id'         => Auth::id(),
                'timestamp'       => now()->toDateTimeString(),
            ]);

            return redirect()->route('daily_weekly.debitChargesList.form', $id)->with('success', 'Due cleared successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Error while clearing gold loan due', [
                'loan_id' => $id,
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return back()->with('error', 'Something went wrong while clearing the due.');
        }
    }



}

