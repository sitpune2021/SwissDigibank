<?php

namespace App\Http\Controllers;

use App\Helpers\CsvExportHelper;
use App\Models\Bank;
use App\Models\GoldLoanTransaction;
use App\Models\MortgageLoanApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MortgageAccountController extends Controller
{
    public function index(Request $request)
    {
        $goldLoan = MortgageLoanApplication::with(['member', 'branch', 'scheme'])->where('status', 1)
            ->orderBy('id', 'desc')->get();
        // dd( $goldLoan);
        return view('mortgage.account.index', compact('goldLoan'));
    }

    public function show(Request $request, $id)
    {
        $goldLoan = MortgageLoanApplication::with(['member.branch', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])->find($id);

        if (!$goldLoan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        $applicationDate = Carbon::parse($goldLoan->application_date);
        $firstEmiDate = $applicationDate->copy()->addMonthNoOverflow();

        $emiCount = $goldLoan->tenure_value;
        $principal = $goldLoan->loan_amount;
        $interestRate = $goldLoan->scheme->annual_interest_rate ?? 0;
        $interestType = strtolower($goldLoan->scheme->gold_loan_setting ?? 'flat_emi'); // default
        $emiSchedule = [];
        $balance = $principal;

        // Monthly interest rate
        $monthlyRate = $interestRate / 12 / 100;

        // ==========================
        // INTEREST TYPE CONDITIONS
        // ==========================

        switch ($interestType) {

            // ---------------------------------
            // 1️⃣ REDUCING EMI
            // ---------------------------------
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
                //    dd($emiSchedule);
                break;

            // ---------------------------------
            // 2️⃣ FLAT EMI
            // ---------------------------------
            case 'flat_emi':
                $totalInterest = $principal * ($interestRate / 100) * ($emiCount / 12);
                $emi = ($principal + $totalInterest) / $emiCount;
                $emiPrincipal = $principal / $emiCount;

                for ($i = 0; $i < $emiCount; $i++) {
                    $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);
                    $interest = $totalInterest / $emiCount;
                    $balance -= $emiPrincipal;

                    $emiSchedule[] = [
                        'emi_no' => $i + 1,
                        'emi_date' => $emiDate->format('d-m-Y'),
                        'emi_due_date' => $emiDate->copy()->addDay()->format('d-m-Y'),
                        'principal' => number_format($emiPrincipal, 2),
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

            // ---------------------------------
            // 3️⃣ FLAT ADVANCED INTEREST DEDUCTION
            // ---------------------------------
            case 'flat_advanced_interest':
                $totalInterest = $principal * ($interestRate / 100) * ($emiCount / 12);
                $netDisbursed = $principal - $totalInterest;

                $firstEmiDate = $applicationDate->copy()->addMonthsNoOverflow($emiCount);
                $lastEmiDate  = $firstEmiDate;

                $emiSchedule = [];

                // Row 2: Single EMI (principal only)
                $emiSchedule[] = [
                    'emi_no' => 1,
                    'emi_date' => $firstEmiDate->format('d/m/Y'),
                    'emi_due_date' => $firstEmiDate->copy()->addDay()->format('d/m/Y'),
                    'principal' => number_format($principal, 2),
                    'interest' => '0.00',
                    'other_charges' => '0.00',
                    'emi_amount' => number_format($principal, 2),
                    'balance_principal' => '0.00',
                    'remaining_amount' => number_format($principal, 2),
                    'paid_date' => '',
                    'status' => 'DUE',
                    'processed' => 'No',
                ];

                $lastEmiDate = $firstEmiDate;

                $goldLoan->net_disbursed = number_format($netDisbursed, 2);
                break;
            // ---------------------------------
            // 4️⃣ NO EMI (BULLET PAYMENT)
            // ---------------------------------
            case 'no_emi':
                $interestPerMonth = $principal * ($interestRate / 100) / 12;
                for ($i = 0; $i < $emiCount; $i++) {
                    $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);

                    $emiSchedule[] = [
                        'emi_no' => $i + 1,
                        'emi_date' => $emiDate->format('d-m-Y'),
                        'emi_due_date' => $emiDate->copy()->addDay()->format('d-m-Y'),
                        'principal' => '0.00',
                        'interest' => number_format($interestPerMonth, 2),
                        'other_charges' => '0.00',
                        'emi_amount' => number_format($interestPerMonth, 2),
                        'balance_principal' => number_format($balance, 2),
                        'remaining_amount' => '0.00',
                        'paid_date' => '',
                        'status' => 'PENDING',
                        'processed' => 'No',
                    ];
                }

                // Add one final bullet payment (principal)
                $finalDate = $firstEmiDate->copy()->addMonthsNoOverflow($emiCount);
                $emiSchedule[] = [
                    'emi_no' => $emiCount + 1,
                    'emi_date' => $finalDate->format('d-m-Y'),
                    'emi_due_date' => $finalDate->copy()->addDay()->format('d-m-Y'),
                    'principal' => number_format($principal, 2),
                    'interest' => '0.00',
                    'other_charges' => '0.00',
                    'emi_amount' => number_format($principal, 2),
                    'balance_principal' => '0.00',
                    'remaining_amount' => '0.00',
                    'paid_date' => '',
                    'status' => 'PENDING',
                    'processed' => 'No',
                ];
                break;
        }

        return view('mortgage.account.view', compact(
            'goldLoan',
            'principal',
            'firstEmiDate',
            'emiSchedule'
        ));
    }

    public function mortgageTransaction(Request $request, $id)
    {

        return view('mortgage.account.view-buttons.view-transactions.view_transactions');
    }

    public function mortgagePayEmi($id)
    {
        $goldLoan = MortgageLoanApplication::with(['member.branch', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])
            ->whereHas('scheme', function ($query) {
                $query->where('gold_loan_setting', 'flat_advanced_interest');
            })
            ->find($id);

        $totalLoan = $goldLoan->loan_amount;

        $totalPaid = \App\Models\GoldLoanTransaction::where('loan_id', $goldLoan->id)
            ->sum('amount_collected');

        $currentDebt = $totalLoan - $totalPaid;

        $goldLoan->current_debt = $currentDebt;


        $overdueInterest = 0;
        $otherCharges = 0;
        $gstRate = 18; // Example

        $gstAmount = ($overdueInterest * $gstRate) / 100;

        $totalOverdueWithGst = $overdueInterest + $gstAmount;

        $totalAmount = $currentDebt + $overdueInterest + $otherCharges;

        $rounding = round($totalAmount) - $totalAmount;
        $netAmount = $totalAmount + $rounding;

        return view('mortgage.account.view-buttons.pay-emi.pay_emi', compact(
            'goldLoan',
            'currentDebt',
            'overdueInterest',
            'otherCharges',
            'gstRate',
            'totalOverdueWithGst',
            'totalAmount',
            'rounding',
            'netAmount'
        ));
    }

    public function payEmiLoan(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount_collected' => 'required|numeric|min:1',
            'remarks' => 'nullable|string|max:255',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Fetch the loan with its scheme to check gold_loan_setting type
        $loan = MortgageLoanApplication::with('scheme')->findOrFail($id);

        // Calculate total paid till date
        $totalPaid = GoldLoanTransaction::where('loan_id', $loan->id)
            ->sum('amount_collected');

        // Current remaining debt before new payment
        $remainingDue = max($loan->loan_amount - $totalPaid, 0);

        $amountCollected = $request->amount_collected;
        $newRemainingDue = max($remainingDue - $amountCollected, 0);

        // Handle receipt upload (optional)
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('goldloan_receipts', 'public');
        }

        // Create new EMI transaction entry
        $transaction = new GoldLoanTransaction();
        $transaction->loan_id = $loan->id;
        $transaction->transaction_date = date('Y-m-d', strtotime($request->transaction_date));
        $transaction->amount_collected = $amountCollected;
        $transaction->current_debt = $newRemainingDue;
        $transaction->other_charges = 0;
        $transaction->total_payable = $remainingDue; // before paying this EMI
        $transaction->status = 'paid';
        $transaction->remarks = $request->remarks ?? null;
        $transaction->flag = 'emi_payment';
        $transaction->created_by = Auth::id() ?? null;

        if ($receiptPath) {
            $transaction->receipt = $receiptPath;
        }

        $transaction->save();

        // If fully paid, mark loan as closed
        if ($newRemainingDue <= 0) {
            $loan->status = 'closed';
            $loan->save();
        }

        return redirect()->route('mortgage.account.show', $loan->id)
            ->with('success', 'EMI Payment recorded successfully!');
    }

    public function mortgagePay($id)
    {
        $goldLoan = MortgageLoanApplication::with(['member.branch', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])->find($id);

        // dd($goldLoan);
        $banks = Bank::all();

        $P = (float)$goldLoan->loan_amount;
        $annualRate = (float)$goldLoan->interest_rate;
        $N = (int)$goldLoan->tenure_value;
        $R = $annualRate / 12 / 100;

        $paidCount = MortgageLoanApplication::where('status', 'PAID')->count();

        if ($paidCount == 0) {
            $currentDebt = $P;
        } else {
            $currentDebt = $P * ((pow(1 + $R, $N) - pow(1 + $R, $paidCount)) / (pow(1 + $R, $N) - 1));
        }

        $currentDebt = round($currentDebt, 2);
        // dd($currentDebt);
        // --- Find next due EMI ---
        $nextDue = $goldLoan->emiPayments()
            ->where('status', 'pending')
            ->orderBy('emi_no', 'asc')
            ->first();

        // If no pending EMI, loan is fully paid
        if (!$nextDue) {
            return view('mortgage.account.view-buttons.pay.pay', [
                'goldLoan' => $goldLoan,
                'banks' => $banks,
                'currentDebt' => 0,
                'payableAmount' => 0,
                'message' => 'All EMIs are paid.'
            ]);
        }

        $today = \Carbon\Carbon::today();
        $dueDate = \Carbon\Carbon::parse($nextDue->emi_date);
        $daysLate = $dueDate->diffInDays($today, false);
        $daysLate = $daysLate > 0 ? $daysLate : 0;

        $interestTillToday = round(($currentDebt * $annualRate * $daysLate) / 36500, 2);

        $lateFee = $daysLate * 10;

        $emiAmount = (float) $nextDue->emi_amount;
        $payableAmount = round($emiAmount + $interestTillToday + $lateFee, 2);
        dd($payableAmount);

        return view('mortgage.account.view-buttons.pay.pay', compact(
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

    public function payEmi(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loan_applications,id',
            'transaction_date' => 'required|date',
            'current_debt' => 'required|numeric',
            'total_payable' => 'required|numeric',
            'amount_collected' => 'required|numeric|min:1',
        ]);

        $loan = MortgageLoanApplication::find($request->loan_id);

        // Store transaction
        $transaction = GoldLoanTransaction::create([
            'loan_id' => $loan->id,
            'transaction_date' => $request->transaction_date,
            'current_debt' => $request->current_debt,
            'other_charges' => $request->other_charges ?? 0,
            'total_payable' => $request->total_payable,
            'amount_collected' => $request->amount_collected,
            'remarks' => $request->remarks ?? null,
            'created_by' => Auth::id(),
        ]);

        // Update remaining balance in loan table
        $loan->balance_amount = $loan->balance_amount - $request->amount_collected;
        if ($loan->balance_amount < 0) $loan->balance_amount = 0;


        dd($loan);
        $loan->save();

        return redirect()->back()->with('success', 'EMI Payment Recorded Successfully.');
    }


}

