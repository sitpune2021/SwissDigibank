<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use Barryvdh\DomPDF\Facade\Pdf;

class GoldLoanPrintDocument extends Controller
{
   
   

    // public function loanAgreement(LoanApplication $loan)
    // {
    //     $member = $loan->member;

    //     $schedule_one = [
    //         'member_id'            => $loan->member_id,
    //         'loan_acc_no'          => 'GL' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
    //         'loan_application_no'  => 'GLA' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
    //         'aggre_date'           => optional($loan->application_date)->format('d-m-Y'),
    //         'loan_agree_no'        => '',
    //         'business_nature'      => '',
    //         'loan_purpose'         => $loan->purpose_of_loan,
    //         'loan_amt'             => number_format($loan->loan_amount, 2),
    //         'Annualized_ro_int'    => optional($loan->scheme)->interest_rate ?? '',
    //         'tenure'               => $loan->tenure_value,
    //         'emi_freq'             => ucfirst($loan->emi_collection),
    //         'adr_lender'           => optional($loan->bank)->bank_name,
    //          // ✅ Borrower info (members table se)
    //     'name_borrower' => trim(
    //         ($member->member_info_title ?? '') . ' ' .
    //         ($member->member_info_first_name ?? '') . ' ' .
    //         ($member->member_info_last_name ?? '')
    //     ),

    //     'mob_borrower'  => $member->member_info_mobile_no ?? '',
    //     'adr_borrower'  => $member->member_info_address ?? '',
    //     ];

    //     $pdf = Pdf::loadView(
    //         'gold-loan.gold-loan-pdf.loan-agreement',
    //         compact('schedule_one')
    //     )->setPaper('A4');

    //     return $pdf->download('Loan_Agreement_'.$loan->id.'.pdf');
    // }

       
    public function loanAgreement(LoanApplication $loan)
    {
        $member = $loan->member;

        /* ---------------- EMI BASIC INPUTS ---------------- */
        $loanAmount   = $loan->loan_amount;              // 200000
        $annualRate   = optional($loan->scheme)->interest_rate ?? 12; // %
        $tenureMonths = $loan->tenure_value;              // 60
        $emiDate      = \Carbon\Carbon::parse($loan->application_date)->addMonth();

        $monthlyRate = $annualRate / 12 / 100;

        // EMI Formula
        $emi = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths))
            / (pow(1 + $monthlyRate, $tenureMonths) - 1);

        $emi = round($emi, 2);

        /* ---------------- EMI SCHEDULE ---------------- */
        $balance = $loanAmount;
        $emiSchedule = [];

        for ($i = 1; $i <= $tenureMonths; $i++) {

            $interest  = round($balance * $monthlyRate, 2);
            $principal = round($emi - $interest, 2);
            $balance   = round($balance - $principal, 2);

            $emiSchedule[] = [
                'emi_no'        => $i,
                'emi_date'      => $emiDate->format('d-M-y'),
                'principal'     => number_format($principal, 2),
                'interest'      => number_format($interest, 2),
                'charges'       => number_format(0, 2),
                'emi_amount'    => number_format($emi, 2),
                'balance'       => number_format(max($balance, 0), 2),
            ];

            $emiDate->addMonth();
        }

        $scheme = $loan->scheme;

        $processingFee   = $scheme->processing_fee ?? 0;
        $stampDutyFee    = $scheme->stamp_duty_charge ?? 0;
        $insuranceFee    = $scheme->insurance_fee ?? 0;
        $interestRate    = $scheme->annual_interest_rate ?? $annualRate;

        $sms_charge    = $scheme->sms_charge ?? 0;
        $fuel_charge    = $scheme->fuel_charge ?? 0;
        $stationary_charge    = $scheme->stationary_charge ?? 0;
        $maintenance_charge    = $scheme->maintenance_charge ?? 0;
        $collection    = $scheme->collection ?? 0;

        $disbursement = $loan->disbursement;

        $processingFeeTotal   = $disbursement->processing_fee_total ?? 0;
        $stampDutyTotal       = $disbursement->stamp_duty_total ?? 0;
        $insuranceTotal       = $disbursement->insurance_total ?? 0;
        $finalDisburseAmount  = $disbursement->final_amount_to_disburse ?? 0;

        $ornaments = $loan->ornaments;


        /* ---------------- AGREEMENT DATA ---------------- */
        $schedule_one = [
            'member_id'           => $loan->member_id,
            'loan_acc_no'         => 'GL' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
            'loan_application_no' => 'GLA' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
            'aggre_date'          => optional($loan->application_date)->format('d-m-Y'),
            'loan_amt'            => number_format($loanAmount, 2),
            'Annualized_ro_int'   => $annualRate,
            'tenure'              => $tenureMonths,
            'emi_amount'          => number_format($emi, 2),
            'loan_agree_no'       => '',
            'business_nature'       => '',
            'loan_purpose'       => $loan->purpose_of_loan,
            'emi_freq'             => ucfirst($loan->emi_collection),

            // FEES FROM SCHEME
            'processing_fee'      => number_format($processingFee, 2),
            'stamp_duty_fee'      => number_format($stampDutyFee, 2),
            'insurance_fee'       => number_format($insuranceFee, 2),
            'interest_rate'       => $interestRate . '%',
            'sms_charge'       => number_format($sms_charge, 2),
            'fuel_charge'       => number_format($fuel_charge, 2),
            'stationary_charge'       => number_format($stationary_charge, 2),
            'maintenance_charge'       => number_format($maintenance_charge, 2),
            'collection'       => number_format($collection, 2),

            // DISBURSEMENT TOTALS
            'processing_fee_total'  => number_format($processingFeeTotal, 2),
            'stamp_duty_total'      => number_format($stampDutyTotal, 2),
            'insurance_total'       => number_format($insuranceTotal, 2),
            'final_disburse_amount' => number_format($finalDisburseAmount, 2),


            'name_borrower' => trim(
                ($member->member_info_title ?? '') . ' ' .
                ($member->member_info_first_name ?? '') . ' ' .
                ($member->member_info_last_name ?? '')
            ),
            'mob_borrower' => $member->member_info_mobile_no ?? '',
            'adr_borrower' => $member->member_info_address ?? '',
            'adr_lender'   => optional($loan->bank)->bank_name,
        ];

        $pdf = Pdf::loadView(
            'gold-loan.gold-loan-pdf.loan-agreement',
            compact('schedule_one', 'emiSchedule','ornaments')
        )->setPaper('A4');

        return $pdf->download('Loan_Agreement_'.$loan->id.'.pdf');
    }

     
 
}
