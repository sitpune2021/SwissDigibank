<?php

namespace App\Http\Controllers;

use App\Helpers\CsvExportHelper;
use App\Models\LoanApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GoldLoanAccountController extends Controller
{
    public function index(Request $request)
    {
        $goldLoan = LoanApplication::with(['member', 'branch', 'scheme'])->where('status', 1)
            ->orderBy('id', 'desc')->get();
        // dd( $goldLoan);
        return view('gold-loan.account.index', compact('goldLoan'));
    }
    // public function show(Request $request, $id)
    // {
    //     $goldLoan = LoanApplication::with(['member', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])->find($id);

    //     $applicationDate = Carbon::parse($goldLoan->application_date);
    //     $firstEmiDate = $applicationDate->copy()->addMonthNoOverflow();

    //     $emiCount = $goldLoan->tenure_value;
    //     $emiDates = [];
    //     $emiSchedule = [];

    //     $principal = $goldLoan->loan_amount;
    //     $emiPrincipal = $principal / $emiCount; // equal principal
    //     $interestRate = $goldLoan->interest_rate ?? 0; // in % per month
    //     $balance = $principal;

    //     for ($i = 0; $i < $emiCount; $i++) {
    //         switch (strtolower($goldLoan->tenure_type)) {
    //             case 'days':
    //                 $emiDate = $firstEmiDate->copy()->addDays($i);
    //                 break;
    //             case 'weeks':
    //                 $emiDate = $firstEmiDate->copy()->addWeeks($i);
    //                 break;
    //             case 'months':
    //             default:
    //                 $emiDate = $firstEmiDate->copy()->addMonthsNoOverflow($i);
    //                 break;
    //         }

    //         $interest = ($balance * $interestRate) / 100; // simple interest calculation
    //         $emiAmount = $emiPrincipal + $interest;
    //         $balance -= $emiPrincipal;

    //         $emiSchedule[] = [
    //             'emi_no' => $i + 1,
    //             'emi_date' => $emiDate->format('d-m-Y'),
    //             'emi_due_date' => $emiDate->copy()->addDay()->format('d-m-Y'),
    //             'principal' => number_format($emiPrincipal, 2),
    //             'interest' => number_format($interest, 2),
    //             'other_charges' => '0.00',
    //             'emi_amount' => number_format($emiAmount, 2),
    //             'balance_principal' => number_format(max($balance, 0), 2),
    //             'remaining_amount' => '0.00',
    //             'paid_date' => '',
    //             'status' => 'PENDING',
    //             'processed' => 'No',
    //         ];
    //     }
    //     // dd($emiSchedule);
    //     $lastEmiDate = end($emiDates);
    //     return view('gold-loan.account.view', compact('goldLoan','principal','firstEmiDate', 'lastEmiDate', 'emiSchedule'));
    // }

    public function show(Request $request, $id)
    {
        $goldLoan = LoanApplication::with(['member', 'branch', 'scheme', 'coApplicant1', 'guarantor1'])->find($id);

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

        return view('gold-loan.account.view', compact(
            'goldLoan',
            'principal',
            'firstEmiDate',
            'emiSchedule'
        ));
    }


    public function goldLoanTransaction(Request $request, $id)
    {

        return view('gold-loan.account.view-buttons.view-transactions.view_transactions');
    }
    // public function downloadCsvExample($id)
    // {
    //     $headers = [
    //         'DATE',
    //     'PAY MODE',
    //     'REMARKS',
    //     'STATUS',
    //     'DEBIT',
    //     'CREDIT',
    //     'BALANCE',
    //     'ACCOUNTED',
    //     ];

    //     $transactions = Transaction::with('accounts.scheme')
    //         ->where('account_id', $id)
    //         ->select('*')
    //         ->selectRaw("
    //     CASE WHEN transaction_type = 'credit' THEN amount ELSE 0 END as credited_amount,
    //     CASE WHEN transaction_type = 'debit' THEN amount ELSE 0 END as debited_amount
    // ")
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $data = $transactions->map(function ($txn) {
    //         return [
    //             $txn->accounts->branches->branch_name ?? '',
    //             $txn->agent->name ?? '',
    //             $txn->agent->code ?? '',
    //             $txn->supervisor->name ?? '',
    //             $txn->supervisor->code ?? '',
    //             $txn->group->name ?? '',
    //             $txn->collectionCenter->name ?? '',
    //             $txn->accounts->members->member_info_first_name ?? '',
    //             $txn->accounts->members->id ?? '',
    //             $txn->accounts->account_no  ?? '',
    //             $txn->accounts->scheme->scheme_name ?? '',
    //             $txn->accounts->payment_mode ?? '',
    //             $txn->accounts->transaction_date,
    //             $txn->transaction_type,
    //             $txn->accounts->opening_balance,
    //             $txn->credited_amount,
    //             $txn->debited_amount,
    //             $txn->closing_balance,
    //             $txn->approve_status,
    //             $txn->approvedBy->name ?? 'System',
    //             $txn->is_accounted ? 'Yes' : 'No',
    //             $txn->message,
    //             $txn->tranx,
    //             $txn->reference_type,
    //             $txn->collected_by_name,
    //             $txn->createdBy->name ?? '',
    //             $txn->cheque_number,
    //             $txn->cheque_date,
    //             $txn->bank_name,
    //             $txn->transfer_date,
    //             $txn->transfer_mode,
    //             $txn->transaction_number,
    //             $txn->bank_account,
    //             $txn->cheque_clearing_date,
    //             $txn->gst_rate,
    //             $txn->customer_gst_no
    //         ];
    //     })->toArray();

    //     return CsvExportHelper::downloadCsv($headers, $data, 'transactions.csv');
    // }

    public function goldLoanPayEmi()
    {
        return view('gold-loan.account.view-buttons.pay-emi.pay_emi');
    }
}
