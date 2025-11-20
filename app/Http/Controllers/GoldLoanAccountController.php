<?php

namespace App\Http\Controllers;

use App\Helpers\CsvExportHelper;
use App\Models\Bank;
use App\Models\GoldLoanOtherCharge;
use App\Models\GoldLoanTransaction;
use App\Models\LoanApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoldLoanAccountController extends Controller
{
    public function index(Request $request)
    {
        $goldLoan = LoanApplication::with(['member', 'branch', 'scheme', 'goldLoanTransactions'])->where('status', 1)
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

        ));
    }


    public function goldLoanTransaction(Request $request, $id)
    {

        return view('gold-loan.account.view-buttons.view-transactions.view_transactions');
    }

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

        $firstPendingEmi = \App\Models\GoldLoanTransaction::where('loan_id', $goldLoan->id)
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

    public function updateEmiStatus(Request $request)
    {
        Log::info('🟢 updateEmiStatus() called', $request->all());

        $request->validate([
            'loan_id' => 'required|integer',
            'status'  => 'required|string',
        ]);

        $emi = GoldLoanTransaction::where('loan_id', $request->loan_id)
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

    // Gold loan pay button
    // public function goldLoanPay($id)
    // {
    //     $goldLoan = LoanApplication::with(['member.branch', 'goldLoanTransactions', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])->find($id);

    //     $banks = Bank::all();

    //     $P = (float)$goldLoan->loan_amount;
    //     $annualRate = (float)$goldLoan->interest_rate;
    //     $N = (int)$goldLoan->tenure_value;
    //     $R = $annualRate / 12 / 100;

    //     $paidCount = LoanApplication::where('status', 'PAID')->count();

    //     if ($paidCount == 0) {
    //         $currentDebt = $P;
    //     } else {
    //         $denominator = pow(1 + $R, $N) - 1;

    //         if ($denominator != 0) {
    //             $currentDebt = $P * ((pow(1 + $R, $N) - pow(1 + $R, $paidCount)) / $denominator);
    //         } else {
    //             // Prevent divide by zero — fall back to simple remaining principal
    //             $currentDebt = $P;
    //         }
    //     }

    //     $currentDebt = round($currentDebt, 2);

    //     $nextDue = $goldLoan->emiPayments()
    //         ->where('status', 'pending')
    //         ->orderBy('emi_no', 'asc')
    //         ->first();

    //     // dd(  $nextDue);

    //     if (!$nextDue) {
    //         return view('gold-loan.account.view-buttons.pay.pay', [
    //             'goldLoan' => $goldLoan,
    //             'banks' => $banks,
    //             'currentDebt' => 0,
    //             'payableAmount' => 0,
    //             'message' => 'All EMIs are paid.'
    //         ]);
    //     }

    //     $today = \Carbon\Carbon::today();
    //     $dueDate = \Carbon\Carbon::parse($nextDue->emi_date);
    //     $daysLate = $dueDate->diffInDays($today, false);
    //     $daysLate = $daysLate > 0 ? $daysLate : 0;

    //     $interestTillToday = round(($currentDebt * $annualRate * $daysLate) / 36500, 2);

    //     $lateFee = $daysLate * 10;

    //     $emiAmount = (float) $nextDue->emi_amount;
    //     $payableAmount = round($emiAmount + $interestTillToday + $lateFee, 2);

    //     return view('gold-loan.account.view-buttons.pay.pay', compact(
    //         'goldLoan',
    //         'banks',
    //         'currentDebt',
    //         'payableAmount',
    //         'interestTillToday',
    //         'lateFee',
    //         'daysLate',
    //         'nextDue'
    //     ));
    // }

    public function goldLoanPay($id)
    {
        $goldLoan = LoanApplication::with([
            'member.branch',
            'goldLoanTransactions',
            'branch',
            'scheme',
            'coApplicant1',
            'guarantor1'
        ])->findOrFail($id);

        $banks = Bank::all();

        $lastTransaction = $goldLoan->goldLoanTransactions->last();
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
            return view('gold-loan.account.view-buttons.pay.pay', [
                'goldLoan' => $goldLoan,
                'banks' => $banks,
                'currentDebt' => 0,
                'payableAmount' => 0,
                'message' => 'All EMIs are fully paid.'
            ]);
        }

        $annualRate = (float) $goldLoan->interest_rate;

        $today = \Carbon\Carbon::today();
        $dueDate = \Carbon\Carbon::parse($nextDue->emi_date);

        $daysLate = $dueDate->diffInDays($today, false);
        $daysLate = $daysLate > 0 ? $daysLate : 0;

        $interestTillToday = round(($currentDebt * $annualRate * $daysLate) / 36500, 2);

        $lateFee = $daysLate * 10;

        $emiAmount = (float) $nextDue->emi_amount;

        // $payableAmount = round($emiAmount + $interestTillToday + $lateFee, 2);

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

    // public function payEmi(Request $request)
    // {
    //     Log::info('payEmi() called', [
    //         'request_data' => $request->all()
    //     ]);

    //     try {

    //         // Validation Log
    //         Log::info('payEmi(): Starting validation');

    //         $request->validate([
    //             'loan_id'           => 'required|exists:loan_applications,id',
    //             'transaction_date'  => 'required|date',
    //             'current_debt'      => 'required|numeric',
    //             'total_payable'     => 'required|numeric',
    //             'amount_collected'  => 'required|numeric|min:1',
    //             'fee_mode'         => 'required|in:cash,cheque,online',
    //         ]);

    //         Log::info('payEmi(): Validation passed');

    //         // Loan Fetch
    //         Log::info('payEmi(): Fetching loan', ['loan_id' => $request->loan_id]);

    //         $loan = LoanApplication::find($request->loan_id);

    //         if (!$loan) {
    //             Log::error('payEmi(): Loan not found', ['loan_id' => $request->loan_id]);
    //             return back()->withErrors(['loan_id' => 'Loan not found.']);
    //         }

    //         // Last EMI No
    //         $lastEmiNo = GoldLoanTransaction::where('loan_id', $loan->id)->max('emi_no');

    //         Log::info('payEmi(): Last EMI No fetched', [
    //             'loan_id' => $loan->id,
    //             'last_emi_no' => $lastEmiNo
    //         ]);

    //         $nextEmiNo = $lastEmiNo ? $lastEmiNo + 1 : 1;

    //         Log::info('payEmi(): Next EMI No calculated', [
    //             'next_emi_no' => $nextEmiNo
    //         ]);

    //         // Creating EMI Transaction
    //         $transaction = GoldLoanTransaction::create([
    //             'loan_id'          => $loan->id,
    //             'emi_no'           => $nextEmiNo,
    //             'transaction_date' => \Carbon\Carbon::parse($request->transaction_date)->format('Y-m-d'),
    //             'current_debt'     => $request->current_debt,
    //             'other_charges'    => $request->other_charges ?? 0,
    //             'total_payable'    => $request->total_payable,
    //             'amount_collected' => $request->amount_collected,
    //             'remarks'          => $request->remarks ?? null,
    //             'created_by'       => Auth::id(),
    //         ]);

    //         Log::info('payEmi(): EMI Transaction Created Successfully', [
    //             'transaction_id' => $transaction->id,
    //             'data' => $transaction->toArray()
    //         ]);

    //         return redirect()->back()->with('success', 'EMI Payment Recorded Successfully.');
    //     } catch (\Exception $e) {

    //         Log::error('payEmi(): Exception Occurred', [
    //             'message' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //         ]);

    //         return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
    //     }
    // }

    public function payEmi(Request $request)
    {
        Log::info('payEmi() called', ['request_data' => $request->all()]);

        try {

            Log::info('payEmi(): Starting validation');

            $rules = [
                'loan_id'           => 'required|exists:loan_applications,id',
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

            $loan = LoanApplication::find($request->loan_id);

            if (!$loan) {
                Log::error('payEmi(): Loan not found', ['loan_id' => $request->loan_id]);
                return back()->withErrors(['loan_id' => 'Loan not found.']);
            }

            $lastEmiNo = GoldLoanTransaction::where('loan_id', $loan->id)->max('emi_no');
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


            $transaction = GoldLoanTransaction::create([
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

            return redirect()->route('gold-loan.account.show', $loan->id)->with('success', 'EMI Payment Recorded Successfully.');
        } catch (\Exception $e) {

            Log::error('payEmi(): Exception Occurred', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    // Gold loan debit other charges functionality
    public function showDebitChargesList($id)
    {
        $goldLoan = LoanApplication::with(['member'])->findOrFail($id);
        return view('gold-loan.account.view-buttons.debit-other-charges.other-charges-list', compact('goldLoan'));
    }

    public function DebitOtherCharges($id)
    {
        $goldLoan = LoanApplication::with(['member', 'scheme', 'goldLoanTransactions'])->findOrFail($id);
        return view('gold-loan.account.view-buttons.debit-other-charges.debit-other-charges', compact('goldLoan'));
    }

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

            $formattedDate = \Carbon\Carbon::parse($request->charge_date)->format('Y-m-d');

            $charge = GoldLoanOtherCharge::create([
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

            $loan = LoanApplication::with('goldLoanTransactions')->findOrFail($id);
            $transaction = $loan->goldLoanTransactions()->first();

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

            return redirect()->route('gold-loan.debitChargesList.form', $id)->with('success', 'Other charge debited successfully.');
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
    public function goldLoanClearDues($id)
    {
        $goldLoan = LoanApplication::with(['member', 'scheme', 'goldLoanTransactions'])->findOrFail($id);
        $totalDue = GoldLoanOtherCharge::where('loan_id', $id)
            ->where('status', 'unpaid')
            ->sum('amount');
        $banks = Bank::all();
        return view('gold-loan.account.view-buttons.debit-other-charges.clear-dues', compact('goldLoan', 'totalDue', 'banks'));
    }

    public function clearDue(Request $request, $id)
    {
        $request->validate([
            'waived_amount' => 'required|numeric|min:0.01',
            'remarks'       => 'nullable|string|max:255',
            'payment_mode'          => 'required|in:cash,online,cheque',
        ]);

        Log::info('🟢 Starting gold loan due clearance process', [
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
            $loan = LoanApplication::with('goldLoanTransactions')->findOrFail($id);

            $goldTxn = $loan->goldLoanTransactions;

            if (!$goldTxn) {
                Log::warning('⚠️ Gold Loan transaction record missing', [
                    'loan_id' => $id,
                    'user_id' => Auth::id(),
                ]);
                return back()->with('error', 'Gold Loan transaction not found.');
            }

            // Step 1: Create a record in gold_loan_other_charges
            $clearDue = GoldLoanOtherCharge::create([
                'loan_id'          => $id,
                'transaction_type' => 'credit',
                'charge_type'      => 'Clear Due',
                'amount'           => $request->waived_amount,
                'charge_date'      => now(),
                'remarks'          => $request->remarks,
                'status'           => 'paid',
                'created_by'       => Auth::id(),
            ]);

            Log::info('🧾 Gold Loan Clear Due entry created successfully', [
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

            Log::info('💰 Gold Loan current debt updated', [
                'loan_id'        => $id,
                'previous_debt'  => $oldDebt,
                'cleared_amount' => $request->waived_amount,
                'remaining_debt' => $goldTxn->current_debt,
                'updated_by'     => Auth::id(),
            ]);

            DB::commit();

            Log::info('✅ Gold Loan due cleared successfully', [
                'loan_id'         => $id,
                'transaction_id'  => $clearDue->id,
                'cleared_amount'  => $request->waived_amount,
                'remaining_debt'  => $goldTxn->current_debt,
                'user_id'         => Auth::id(),
                'timestamp'       => now()->toDateTimeString(),
            ]);

            return redirect()->route('gold-loan.debitChargesList.form', $id)->with('success', 'Due cleared successfully.');
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

    // Fore close functionality
    public function foreclose(Request $request, $loan_id)
    {
        try {
            // Validate input
            $request->validate([
                'foreclosure_date' => 'required|date',
                'penalty_amount'   => 'nullable|numeric|min:0',
                'discount'         => 'nullable|numeric|min:0',
                'closing_remarks'  => 'nullable|string|max:255',
            ]);

            $loan = LoanApplication::find($loan_id);

            if (!$loan) {
                return back()->withErrors(['loan' => 'Loan not found']);
            }

            // Check if already foreclosed
            if ($loan->status == 'closed') {
                return back()->withErrors(['loan' => 'Loan already foreclosed']);
            }

            // Latest outstanding
            $lastTransaction = GoldLoanTransaction::where('loan_id', $loan_id)
                ->orderBy('id', 'DESC')
                ->first();

            if (!$lastTransaction) {
                return back()->withErrors(['loan' => 'No transaction found']);
            }

            $currentDebt  = $lastTransaction->current_debt ?? 0;
            $penalty      = $request->penalty_amount ?? 0;
            $discount     = $request->discount ?? 0;

            // Foreclosure calculation
            $foreclosureAmount = ($currentDebt + $penalty) - $discount;

            // Foreclosure Entry
            $transaction = GoldLoanTransaction::create([
                'loan_id'             => $loan_id,
                'emi_no'              => null,
                'transaction_date'    => now()->format('Y-m-d'),
                'foreclosure_amount'  => $foreclosureAmount,
                'foreclosure_date'    => $request->foreclosure_date,
                'penalty_amount'      => $penalty,
                'discount'            => $discount,
                'remarks'             => $request->closing_remarks,
                'status'              => 'foreclosed',
                'created_by'          => Auth::id(),
            ]);

            // Update Loan Table Status
            $loan->update([
                'status'         => 'closed',
                'closing_date'   => $request->foreclosure_date,
                'closing_amount' => $foreclosureAmount,
            ]);

            return redirect()->back()->with('success', 'Loan foreclosed successfully.');
        } catch (\Exception $ex) {

            Log::error('Foreclosure Error', [
                'message' => $ex->getMessage(),
                'line'    => $ex->getLine(),
            ]);

            return back()->withErrors(['error' => 'Something went wrong.']);
        }
    }
}
