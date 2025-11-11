<?php

namespace App\Http\Controllers;

use App\Helpers\CsvExportHelper;
use App\Models\Bank;
use App\Models\GoldLoanTransaction;
use App\Models\LoanApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoldLoanAccountController extends Controller
{
    public function index(Request $request)
    {
        $goldLoan = LoanApplication::with(['member', 'branch', 'scheme'])->where('status', 1)
            ->orderBy('id', 'desc')->get();
        return view('gold-loan.account.index', compact('goldLoan'));
    }


    public function show(Request $request, $id)
    {
        $goldLoan = LoanApplication::with(['member.branch', 'branch', 'scheme', 'coApplicant1', 'guarantor1', 'goldLoanTransactions'])->find($id);

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

        $monthlyRate = $interestRate / 12 / 100;

        switch ($interestType) {

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

            case 'flat_advanced_interest':
                $totalInterest = $principal * ($interestRate / 100) * ($emiCount / 12);
                $netDisbursed = $principal - $totalInterest;
                $monthlyRate = $interestRate / (12 * 100);
                $firstEmiDate = $applicationDate->copy()->addMonth();
                $lastEmiDate  = $applicationDate->copy()->addMonthsNoOverflow($emiCount);

                $lastCurrentDebt = \App\Models\GoldLoanTransaction::where('loan_id', $goldLoan->id)
                    ->orderByDesc('id')
                    ->value('current_debt');

                $monthlyPrincipal = $principal / $emiCount;
                $lastEmiDate  = $firstEmiDate;

                $totalPayable =
                    $emiSchedule = [];

                $emi = $monthlyPrincipal * $monthlyRate * pow(1 + $monthlyRate, 12) / (pow(1 + $monthlyRate, 12) - 1);

                $emi = round($emi, 2);

                $payableAmount = $monthlyPrincipal + $emi;



                // Row 2: Single EMI (principal only)
                // $emiSchedule[] = [
                //     'emi_no' => 1,
                //     'emi_date' => $firstEmiDate->format('d/m/Y'),
                //     'emi_due_date' => $firstEmiDate->copy()->addDay()->format('d/m/Y'),
                //     'principal' => number_format($principal, 2),
                //     'interest' => '0.00',
                //     'other_charges' => '0.00',
                //     'emi_amount' => number_format($principal, 2),
                //     'balance_principal' => '0.00',
                //     'remaining_amount' => number_format($principal, 2),
                //     'paid_date' => '',
                //     'status' => 'DUE',
                //     'processed' => 'No',
                // ];

                for ($i = 0; $i < $emiCount; $i++) {
                    $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);
                    $balancePrincipal = max($principal - ($monthlyPrincipal * ($i + 1)), 0);

                    $emiSchedule[] = [
                        'emi_no' => $i + 1,
                        'emi_date' => $emiDate->format('d/m/Y'),
                        'emi_due_date' => $emiDate->copy()->addDay()->format('d/m/Y'),
                        'principal' => number_format($monthlyPrincipal, 2),
                        'interest' =>   $emi,
                        'other_charges' => '0.00',
                        'emi_amount' => number_format($payableAmount, 2),
                        'balance_principal' => number_format($balancePrincipal, 2),
                        'remaining_amount' => number_format($payableAmount, 2),
                        'paid_date' => '',
                        'status' => 'UNPAID',
                        'processed' => 'No',
                    ];
                }

                $lastEmiDate = $firstEmiDate;

                $goldLoan->net_disbursed = number_format($netDisbursed, 2);
                break;

            case 'no_emi':
                $interestPerMonth = $principal * ($interestRate / 100) / 12;
                for ($i = 0; $i < $emiCount; $i++) {
                    $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);

                    $emiAmount = $interestPerMonth;
                    $balancePrincipal = max($principal - ($interestPerMonth * ($i + 1)), 0);

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

        return view('gold-loan.account.view', compact(
            'goldLoan',
            'principal',
            'firstEmiDate',
            'emiSchedule',
            'lastCurrentDebt'
        ));
    }


    public function goldLoanTransaction(Request $request, $id)
    {

        return view('gold-loan.account.view-buttons.view-transactions.view_transactions');
    }

    // Gold loan Pay EMI
    public function goldLoanPayEmi($id)
    {
        $goldLoan = LoanApplication::with([
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

        $totalPaid = \App\Models\GoldLoanTransaction::where('loan_id', $goldLoan->id)
            ->sum('amount_collected');

        $remainingAmount = 0;
        $emiAmount = 0;
        $netDisbursed = 0;

        switch ($emiType) {
            case 'flat_advanced_interest':

                $totalInterest = $totalLoan * ($interestRate / 100) * ($emiCount / 12);
                $netDisbursed = $totalLoan - $totalInterest;

                $emiAmount =  round($totalLoan / $emiCount, 2);

                $remainingAmount = ($totalLoan) - $totalPaid;

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

        return view('gold-loan.account.view-buttons.pay-emi.pay_emi', compact(
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
            'netAmount',
            'lastCurrentDebt'
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

        $loan = LoanApplication::with('scheme')->findOrFail($id);

        $totalPaid = GoldLoanTransaction::where('loan_id', $loan->id)
            ->sum('amount_collected');

        $remainingDue = max($loan->loan_amount - $totalPaid, 0);

        $amountCollected = $request->amount_collected;
        $newRemainingDue = max($remainingDue - $amountCollected, 0);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('goldloan_receipts', 'public');
        }

        $transaction = new GoldLoanTransaction();
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

        if ($receiptPath) {
            $transaction->receipt = $receiptPath;
        }

        $transaction->save();

        if ($newRemainingDue <= 0) {
            $loan->status = 'closed';
            $loan->save();
        }

        return redirect()->route('gold-loan.account.show', $loan->id)
            ->with('success', 'EMI Payment recorded successfully!');
    }

    // Gold loan pay button
    public function goldLoanPay($id)
    {
        $goldLoan = LoanApplication::with(['member.branch', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])->find($id);

        $banks = Bank::all();

        $P = (float)$goldLoan->loan_amount;
        $annualRate = (float)$goldLoan->interest_rate;
        $N = (int)$goldLoan->tenure_value;
        $R = $annualRate / 12 / 100;

        $paidCount = LoanApplication::where('status', 'PAID')->count();

        if ($paidCount == 0) {
            $currentDebt = $P;
        } else {
            $currentDebt = $P * ((pow(1 + $R, $N) - pow(1 + $R, $paidCount)) / (pow(1 + $R, $N) - 1));
        }

        $currentDebt = round($currentDebt, 2);

        $nextDue = $goldLoan->emiPayments()
            ->where('status', 'pending')
            ->orderBy('emi_no', 'asc')
            ->first();

        if (!$nextDue) {
            return view('gold-loan.account.view-buttons.pay.pay', [
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

        return view('gold-loan.account.view-buttons.pay.pay', compact(
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

        $loan = LoanApplication::find($request->loan_id);

        $lastEmiNo = GoldLoanTransaction::where('loan_id', $loan->id)->max('emi_no');
        $nextEmiNo = $lastEmiNo ? $lastEmiNo + 1 : 1;

        $transaction = GoldLoanTransaction::create([
            'loan_id' => $loan->id,
            'emi_no' => $nextEmiNo,
            'transaction_date' => $request->transaction_date,
            'current_debt' => $request->current_debt,
            'other_charges' => $request->other_charges ?? 0,
            'total_payable' => $request->total_payable,
            'amount_collected' => $request->amount_collected,
            'remarks' => $request->remarks ?? null,
            'created_by' => Auth::id(),
        ]);

        $loan->balance_amount = $loan->balance_amount - $request->amount_collected;
        if ($loan->balance_amount < 0) $loan->balance_amount = 0;
        
        $loan->save();

        return redirect()->back()->with('success', 'EMI Payment Recorded Successfully.');
    }

    // Process button functionality
    public function updateEmiStatus(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|integer',
            'emi_no' => 'required|integer',
            'status' => 'required|string',
        ]);
dd($request->all());
        $emi = GoldLoanTransaction::where('loan_id', $request->loan_id)
            ->where('emi_no', $request->emi_no)
            ->first();
dd( $emi );
        if (!$emi) {
            return response()->json(['success' => false, 'message' => 'EMI record not found'], 404);
        }

        $emi->status = $request->status;
        $emi->paid_date = now();
        $emi->save();

        return response()->json([
            'success' => true,
            'message' => 'EMI status updated successfully',
            'emi' => $emi
        ]);
    }
}
