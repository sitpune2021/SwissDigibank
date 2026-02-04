<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\GoldLoanDisbursement;
use Carbon\Carbon;

class GoldLoanPrintDocument extends Controller
{

    public function loanAgreementView(LoanApplication $loan)
    {
        $member = $loan->member;

        /* ---------------- EMI BASIC INPUTS ---------------- */
        $loanAmount = $loan->loan_amount;              // 200000
        $annualRate = optional($loan->scheme)->interest_rate ?? 12; // %
        $tenureMonths = $loan->tenure_value;              // 60
        $emiDate = \Carbon\Carbon::parse($loan->application_date)->addMonth();

        $monthlyRate = $annualRate / 12 / 100;

        // EMI Formula
        $emi = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths))
            / (pow(1 + $monthlyRate, $tenureMonths) - 1);

        $emi = round($emi, 2);

        /* ---------------- EMI SCHEDULE ---------------- */
        $balance = $loanAmount;
        $emiSchedule = [];

        for ($i = 1; $i <= $tenureMonths; $i++) {

            $interest = round($balance * $monthlyRate, 2);
            $principal = round($emi - $interest, 2);
            $balance = round($balance - $principal, 2);

            $emiSchedule[] = [
                'emi_no' => $i,
                'emi_date' => $emiDate->format('d-M-y'),
                'principal' => number_format($principal, 2),
                'interest' => number_format($interest, 2),
                'charges' => number_format(0, 2),
                'emi_amount' => number_format($emi, 2),
                'balance' => number_format(max($balance, 0), 2),
            ];

            $emiDate->addMonth();
        }

        $scheme = $loan->scheme;

        $processingFee = $scheme->processing_fee ?? 0;
        $stampDutyFee = $scheme->stamp_duty_charge ?? 0;
        $insuranceFee = $scheme->insurance_fee ?? 0;
        $interestRate = $scheme->annual_interest_rate ?? $annualRate;

        $sms_charge = $scheme->sms_charge ?? 0;
        $fuel_charge = $scheme->fuel_charge ?? 0;
        $stationary_charge = $scheme->stationary_charge ?? 0;
        $maintenance_charge = $scheme->maintenance_charge ?? 0;
        $collection = $scheme->collection ?? 0;

        $disbursement = $loan->disbursement;

        $processingFeeTotal = $disbursement->processing_fee_total ?? 0;
        $stampDutyTotal = $disbursement->stamp_duty_total ?? 0;
        $insuranceTotal = $disbursement->insurance_total ?? 0;
        $finalDisburseAmount = $disbursement->final_amount_to_disburse ?? 0;

        $ornaments = $loan->ornaments;


        /* ---------------- AGREEMENT DATA ---------------- */
        $schedule_one = [
            'member_id' => $loan->member_id,
            'loan_no' => $loan->id,
            'loan_acc_no' => 'GL' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
            'loan_application_no' => 'GLA' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
            'aggre_date' => optional($loan->application_date)->format('d-m-Y'),
            'loan_amt' => number_format($loanAmount, 2),
            'Annualized_ro_int' => $annualRate,
            'tenure' => $tenureMonths,
            'emi_amount' => number_format($emi, 2),
            'loan_agree_no' => '',
            'business_nature' => '',
            'loan_purpose' => $loan->purpose_of_loan,
            'emi_freq' => ucfirst($loan->emi_collection),

            // FEES FROM SCHEME
            'processing_fee' => number_format($processingFee, 2),
            'stamp_duty_fee' => number_format($stampDutyFee, 2),
            'insurance_fee' => number_format($insuranceFee, 2),
            'interest_rate' => $interestRate . '%',
            'sms_charge' => number_format($sms_charge, 2),
            'fuel_charge' => number_format($fuel_charge, 2),
            'stationary_charge' => number_format($stationary_charge, 2),
            'maintenance_charge' => number_format($maintenance_charge, 2),
            'collection' => number_format($collection, 2),

            // DISBURSEMENT TOTALS
            'processing_fee_total' => number_format($processingFeeTotal, 2),
            'stamp_duty_total' => number_format($stampDutyTotal, 2),
            'insurance_total' => number_format($insuranceTotal, 2),
            'final_disburse_amount' => number_format($finalDisburseAmount, 2),


            'name_borrower' => trim(
                ($member->member_info_title ?? '') . ' ' .
                ($member->member_info_first_name ?? '') . ' ' .
                ($member->member_info_last_name ?? '')
            ),
            'mob_borrower' => $member->member_info_mobile_no ?? '',
            'adr_borrower' => $member->member_info_address ?? '',
            'adr_lender' => optional($loan->bank)->bank_name,
        ];

        return view(
            'gold-loan.gold-loan-pdf.loan-agreement-view',
            compact('schedule_one', 'emiSchedule', 'ornaments')
        );
    }
    public function loanAgreement(LoanApplication $loan)
    {
        $member = $loan->member;

        /* ---------------- EMI BASIC INPUTS ---------------- */
        $loanAmount = $loan->loan_amount;              // 200000
        $annualRate = optional($loan->scheme)->interest_rate ?? 12; // %
        $tenureMonths = $loan->tenure_value;              // 60
        $emiDate = \Carbon\Carbon::parse($loan->application_date)->addMonth();

        $monthlyRate = $annualRate / 12 / 100;

        // EMI Formula
        $emi = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths))
            / (pow(1 + $monthlyRate, $tenureMonths) - 1);

        $emi = round($emi, 2);

        /* ---------------- EMI SCHEDULE ---------------- */
        $balance = $loanAmount;
        $emiSchedule = [];

        for ($i = 1; $i <= $tenureMonths; $i++) {

            $interest = round($balance * $monthlyRate, 2);
            $principal = round($emi - $interest, 2);
            $balance = round($balance - $principal, 2);

            $emiSchedule[] = [
                'emi_no' => $i,
                'emi_date' => $emiDate->format('d-M-y'),
                'principal' => number_format($principal, 2),
                'interest' => number_format($interest, 2),
                'charges' => number_format(0, 2),
                'emi_amount' => number_format($emi, 2),
                'balance' => number_format(max($balance, 0), 2),
            ];

            $emiDate->addMonth();
        }

        $scheme = $loan->scheme;

        $processingFee = $scheme->processing_fee ?? 0;
        $stampDutyFee = $scheme->stamp_duty_charge ?? 0;
        $insuranceFee = $scheme->insurance_fee ?? 0;
        $interestRate = $scheme->annual_interest_rate ?? $annualRate;

        $sms_charge = $scheme->sms_charge ?? 0;
        $fuel_charge = $scheme->fuel_charge ?? 0;
        $stationary_charge = $scheme->stationary_charge ?? 0;
        $maintenance_charge = $scheme->maintenance_charge ?? 0;
        $collection = $scheme->collection ?? 0;

        $disbursement = $loan->disbursement;

        $processingFeeTotal = $disbursement->processing_fee_total ?? 0;
        $stampDutyTotal = $disbursement->stamp_duty_total ?? 0;
        $insuranceTotal = $disbursement->insurance_total ?? 0;
        $finalDisburseAmount = $disbursement->final_amount_to_disburse ?? 0;

        $ornaments = $loan->ornaments;


        /* ---------------- AGREEMENT DATA ---------------- */
        $schedule_one = [
            'member_id' => $loan->member_id,
            'loan_acc_no' => 'GL' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
            'loan_application_no' => 'GLA' . str_pad($loan->id, 5, '0', STR_PAD_LEFT),
            'aggre_date' => optional($loan->application_date)->format('d-m-Y'),
            'loan_amt' => number_format($loanAmount, 2),
            'Annualized_ro_int' => $annualRate,
            'tenure' => $tenureMonths,
            'emi_amount' => number_format($emi, 2),
            'loan_agree_no' => '',
            'business_nature' => '',
            'loan_purpose' => $loan->purpose_of_loan,
            'emi_freq' => ucfirst($loan->emi_collection),

            // FEES FROM SCHEME
            'processing_fee' => number_format($processingFee, 2),
            'stamp_duty_fee' => number_format($stampDutyFee, 2),
            'insurance_fee' => number_format($insuranceFee, 2),
            'interest_rate' => $interestRate . '%',
            'sms_charge' => number_format($sms_charge, 2),
            'fuel_charge' => number_format($fuel_charge, 2),
            'stationary_charge' => number_format($stationary_charge, 2),
            'maintenance_charge' => number_format($maintenance_charge, 2),
            'collection' => number_format($collection, 2),

            // DISBURSEMENT TOTALS
            'processing_fee_total' => number_format($processingFeeTotal, 2),
            'stamp_duty_total' => number_format($stampDutyTotal, 2),
            'insurance_total' => number_format($insuranceTotal, 2),
            'final_disburse_amount' => number_format($finalDisburseAmount, 2),


            'name_borrower' => trim(
                ($member->member_info_title ?? '') . ' ' .
                ($member->member_info_first_name ?? '') . ' ' .
                ($member->member_info_last_name ?? '')
            ),
            'mob_borrower' => $member->member_info_mobile_no ?? '',
            'adr_borrower' => $member->member_info_address ?? '',
            'adr_lender' => optional($loan->bank)->bank_name,
        ];

        $pdf = Pdf::loadView(
            'gold-loan.gold-loan-pdf.loan-agreement',
            compact('schedule_one', 'emiSchedule', 'ornaments')
        )->setPaper('A4');

        return $pdf->download('Loan_Agreement_' . $loan->id . '.pdf');
    }
    public function disburse_letter_view(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme']); // eager load member

        $data = [
            'printed_on' => now()->format('d-m-Y'),
            'date' => now()->format('d-m-Y'),

            // MEMBER INFO (dynamic)
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'member_id' => $loan->member->member_no ?? '',
            'member_address' => $loan->member->address ?? '',
            'member_mobile' => $loan->member->mobile ?? '',
            'member_state' => $loan->member->state ?? '',
            // KEEP OTHER VALUES STATIC FOR NOW
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'loan_no' => $loan->id,
            'loan_amount' => $loan->approved_loan_amount ?? 0,
            'bank_details' => '',
            'processing_charges' => 0,
            'stamp_duty' => $loan->scheme->stamp_duty_charge ?? 0,
            'insurance_fee' => $loan->scheme->insurance_fee ?? 0,
            'final_amount' => $loan->approved_loan_amount ?? 0,
        ];
        return view('gold-loan.gold-loan-pdf.disburse-letter-view', $data);
    }

    public function disburse_letter(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme']); // eager load member

        $data = [
            'printed_on' => now()->format('d-m-Y'),
            'date' => now()->format('d-m-Y'),

            // MEMBER INFO (dynamic)
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'member_id' => $loan->member->member_no ?? '',
            'member_address' => $loan->member->address ?? '',
            'member_mobile' => $loan->member->mobile ?? '',
            'member_state' => $loan->member->state ?? '',
            // KEEP OTHER VALUES STATIC FOR NOW
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'loan_no' => $loan->id,
            'loan_amount' => $loan->approved_loan_amount ?? 0,
            'bank_details' => '',
            'processing_charges' => 0,
            'stamp_duty' => $loan->scheme->stamp_duty_charge ?? 0,
            'insurance_fee' => $loan->scheme->insurance_fee ?? 0,
            'final_amount' => $loan->approved_loan_amount ?? 0,
        ];
        $pdf = Pdf::loadView('gold-loan.gold-loan-pdf.disburse-letter', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Gold_Loan_Disbursement_Letter.pdf');
    }


    public function letter_udertaking_gold_view(LoanApplication $loan)
    {
        $loanAmount = $loan->approved_loan_amount ?? 0;

        $data = [
            'printed_on' => date('d-m-Y'),
            'date' => date('d-m-Y'),
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'loan_no' => $loan->id,
            'loan_amount' => $loanAmount,
            'loan_amount_words' => $this->amountInWords($loanAmount),
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'processing_charges' => 0,
            'stamp_duty' => $loan->scheme->stamp_duty_charge ?? 0,
            'insurance_fee' => $loan->scheme->insurance_fee ?? 0,
            'final_amount' => 200000,
            'installments' => 4449.00,
            'state' => ''

        ];

        return view('gold-loan.gold-loan-pdf.letter-udertaking-gold-view', $data);
    }
    public function letter_udertaking_gold(LoanApplication $loan)
    {
        $loanAmount = $loan->approved_loan_amount ?? 0;

        $data = [
            'printed_on' => date('d-m-Y'),
            'date' => date('d-m-Y'),
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'loan_no' => $loan->id,
            'loan_amount' => $loanAmount,
            'loan_amount_words' => $this->amountInWords($loanAmount),
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'processing_charges' => 0,
            'stamp_duty' => $loan->scheme->stamp_duty_charge ?? 0,
            'insurance_fee' => $loan->scheme->insurance_fee ?? 0,
            'final_amount' => 200000,
            'installments' => 4449.00,
            'state' => ''

        ];

        $pdf = Pdf::loadView('gold-loan.gold-loan-pdf.letter-udertaking-gold', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('letter_udertaking_gold.pdf');
    }



    /* ---------------- NUMBER TO WORDS ---------------- */

    private function amountInWords($amount)
    {
        $amount = number_format($amount, 2, '.', '');
        [$rupees, $paise] = explode('.', $amount);

        return ucfirst($this->convertNumberIndian($rupees)) . ' '
            . ($paise > 0 ? ' and ' . $this->convertNumberIndian($paise) . ' ' : '')
            . ' only';
    }

    private function convertNumberIndian($num)
    {
        $ones = [
            '',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
            'eleven',
            'twelve',
            'thirteen',
            'fourteen',
            'fifteen',
            'sixteen',
            'seventeen',
            'eighteen',
            'nineteen'
        ];

        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        if ($num == 0)
            return 'zero';

        $num = str_pad($num, 9, '0', STR_PAD_LEFT);

        $crore = substr($num, 0, 2);
        $lakh = substr($num, 2, 2);
        $thousand = substr($num, 4, 2);
        $hundred = substr($num, 6, 1);
        $rest = substr($num, 7, 2);

        $str = '';

        if ($crore > 0)
            $str .= $this->twoDigit($crore, $ones, $tens) . ' crore ';
        if ($lakh > 0)
            $str .= $this->twoDigit($lakh, $ones, $tens) . ' lakh ';
        if ($thousand > 0)
            $str .= $this->twoDigit($thousand, $ones, $tens) . ' thousand ';
        if ($hundred > 0)
            $str .= $ones[$hundred] . ' hundred ';
        if ($rest > 0)
            $str .= $this->twoDigit($rest, $ones, $tens);

        return trim($str);
    }

    private function twoDigit($num, $ones, $tens)
    {
        $num = (int) $num; // 🔥 critical fix

        if ($num < 20) {
            return $ones[$num] ?? '';
        }

        return ($tens[(int) floor($num / 10)] ?? '') .
            ($num % 10 ? ' ' . ($ones[$num % 10] ?? '') : '');
    }

    public function payout_chart_gold_appli_view(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;
        $disbursement = $loan->disbursement;
         $statusText = match ($loan->status) {
            0 => 'DRAFT',
            1 => 'APPROVED',
            2 => 'DISBURSED',
            3 => 'CANCELLED',
        };
        $data = [
            'printed_on' => date('d-m-Y'),
            'disburse_date' => $statusText,
            'loan_no' => $loan->id,
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'loan_amount' => $loan?->approved_loan_amount,
            'interest_type' => $scheme->gold_loan_setting,
            'processing_fee' => '(static)',
            'tenure' => $loan?->tenure_value . ' ' . $loan?->tenure_type,
            'stamp_duty_fee' => $scheme->stamp_duty_charge,
            'interest_rate' => $scheme->annual_interest_rate,
            'insurance_charge' => $scheme->insurance_fee,
            'emi_count' => '(static)',
            'emi_payout' => $loan->emi_collection,
            'loan_in_ratio' => '(static)',
            'apr_rate' => '(static)'

        ];

        $payoutCharts = [
            'emi_date' => '12-12-2025(static)',
            'emi_principle' => '2,449.00(static)',
            'emi_interest' => '2,000.00(static)',
            'per_emi_charges' => '0.00(static)',
            'emi_amount' => '4,449.00(static)',
            'balance_principle' => '197,551.00(static)',
            'total_emi_principle' => '200,000.00(static)',
            'total_emi_interest' => '66,940.00(static)',
            'total_per_emi_charges' => '0.00(static)',
            'total_emi_amount' => '266,940.00(static)',

        ];


        return view('gold-loan.gold-loan-pdf.gold-appli-payout-chart-view', $data, $payoutCharts);
    }
    public function payout_chart_gold_appli(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;
        $disbursement = $loan->disbursement;
         $statusText = match ($loan->status) {
            0 => 'DRAFT',
            1 => 'APPROVED',
            2 => 'DISBURSED',
            3 => 'CANCELLED',
        };
        $data = [
            'printed_on' => date('d-m-Y'),
            'disburse_date' => $statusText,
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'loan_amount' => $loan?->approved_loan_amount,
            'interest_type' => $scheme->gold_loan_setting,
            'processing_fee' => '(static)',
            'tenure' => $loan?->tenure_value . ' ' . $loan?->tenure_type,
            'stamp_duty_fee' => $scheme->stamp_duty_charge,
            'interest_rate' => $scheme->annual_interest_rate,
            'insurance_charge' => $scheme->insurance_fee,
            'emi_count' => '(static)',
            'emi_payout' => $loan->emi_collection,
            'loan_in_ratio' => '(static)',
            'apr_rate' => '(static)'

        ];

        $payoutCharts = [
            'emi_date' => '12-12-2025(static)',
            'emi_principle' => '2,449.00(static)',
            'emi_interest' => '2,000.00(static)',
            'per_emi_charges' => '0.00(static)',
            'emi_amount' => '4,449.00(static)',
            'balance_principle' => '197,551.00(static)',
            'total_emi_principle' => '200,000.00(static)',
            'total_emi_interest' => '66,940.00(static)',
            'total_per_emi_charges' => '0.00(static)',
            'total_emi_amount' => '266,940.00(static)',

        ];

        $pdf = Pdf::loadView('gold-loan.gold-loan-pdf.gold-appli-payout-chart', $data, $payoutCharts)
            ->setPaper('A4', 'portrait');

        return $pdf->download('payout_chart_gold_loan_application.pdf');
    }




    public function promisary_note_view(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;
        $disbursement = $loan->disbursement;
        $loanAmount = $loan->approved_loan_amount ?? 0;
        $data = [
            'loan_no' => $loan->id,
            'name' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'date' => date('d-m-Y'),
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'amount' => '(static)',
            'amount_words' => '(static)',
            'interest_rate' => $scheme->annual_interest_rate,
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'processing_charges' => 100,
            'stamp_duty' => 100,
            'insurance_fee' => 100,
            'final_amount' => 200000,
            'installments' => 4449.00,
            'state' => 'Maharashtra'

        ];



        return view('gold-loan.gold-loan-pdf.gold-appli-promisary-note-view', $data);
    }
    public function promisary_note(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;
        $disbursement = $loan->disbursement;
        $loanAmount = $loan->approved_loan_amount ?? 0;
        $data = [
            'name' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'date' => date('d-m-Y'),
            'bank_name' => '',
            'bank_adr_branch' => '',
            'bank_adr' => '',
            'amount' => '(static)',
            'amount_words' => '(static)',
            'interest_rate' => $scheme->annual_interest_rate,
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'processing_charges' => 100,
            'stamp_duty' => 100,
            'insurance_fee' => 100,
            'final_amount' => 200000,
            'installments' => 4449.00,
            'state' => 'Maharashtra'

        ];

        $pdf = Pdf::loadView('gold-loan.gold-loan-pdf.gold-appli-promisary-note', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('promissory-note.pdf');
    }

     public function sanction_letter_view(LoanApplication $loan)
    {
        $loan->load(relations: ['member', 'scheme', 'disbursement', 'branch', 'ornaments']);

        $statusText = match ($loan->status) {
            0 => 'DRAFT',
            1 => 'APPROVED',
            2 => 'DISBURSED',
            3 => 'CANCELLED',
        };
        $scheme = $loan->scheme;

        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'branch' => $loan->branch->branch_name ?? '',
            'member_name' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'member_no' => str_pad($loan->member_id, 6, '0', STR_PAD_LEFT),
            'father_husband' => '',
            'contact_no' => $loan->member->member_info_mobile_no,
            'address' => '',
            'application_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),
            'application_date' => $loan->application_date
                ? Carbon::parse($loan->application_date)->format('d-m-Y')
                : '',
            'application_status' => $statusText,
             'loan_id'=>$loan->id,
            'loan_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),
            'nature_of_loan' => 'Gold Loan',
            'loan_scheme' => $scheme->scheme_name,
            'loan_amount' => $loan?->approved_loan_amount,
            'tenure_of_loan' => $loan?->tenure_value . ' ' . $loan?->tenure_type,
            'interest_type' => $scheme->gold_loan_setting,
            'annual_interset_rate' => $scheme->annual_interest_rate,
            'emi_payout' => $loan->emi_collection,
            'emi_amt' => '',
            'no_of_emis' => '',
            'credit_grace_period' => $loan->credit_period,
            'processing_fee' => '(static)',
            'stamp_duty' => $scheme->stamp_duty_charge,
            'insurance_fee' => $scheme->insurance_fee,
            'emi_amount' => '4,449.00',

            // Security Deposits
           'ornaments' => $loan->ornaments,
            // 'sec_name' => 'Coin',
            // 'qty' => '5',
            // 'val_gm' => '4,000.00',
            // 'gross_weight_gm' => '50.0',
            // 'net_weight_gm' => '50.0',
            // 'tunch' => '100.0',
            // 'fine_weight_gm' => '50',
            // 'total_val' => '2000000',
            // 'image' => '',
            // 'status' => 'Mortgage'
        ];

      
        return view('gold-loan.gold-loan-pdf.gold-appli-sanction-letter-view', $data) ;
    }
    public function sanction_letter(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement', 'branch', 'ornaments']);

        $statusText = match ($loan->status) {
            0 => 'DRAFT',
            1 => 'APPROVED',
            2 => 'DISBURSED',
            3 => 'CANCELLED',
        };
        $scheme = $loan->scheme;

        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'branch' => $loan->branch->branch_name ?? '',
            'member_name' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'member_no' => str_pad($loan->member_id, 6, '0', STR_PAD_LEFT),
            'father_husband' => '',
            'contact_no' => $loan->member->member_info_mobile_no,
            'address' => '',
            'application_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),
            'application_date' => $loan->application_date
                ? Carbon::parse($loan->application_date)->format('d-m-Y')
                : '',
            'application_status' => $statusText,
             'loan_id'=>$loan->id,
            'loan_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),
            'nature_of_loan' => 'Gold Loan',
            'loan_scheme' => $scheme->scheme_name,
            'loan_amount' => $loan?->approved_loan_amount,
            'tenure_of_loan' => $loan?->tenure_value . ' ' . $loan?->tenure_type,
            'interest_type' => $scheme->gold_loan_setting,
            'annual_interset_rate' => $scheme->annual_interest_rate,
            'emi_payout' => $loan->emi_collection,
            'emi_amt' => '',
            'no_of_emis' => '',
            'credit_grace_period' => $loan->credit_period,
            'processing_fee' => '(static)',
            'stamp_duty' => $scheme->stamp_duty_charge,
            'insurance_fee' => $scheme->insurance_fee,
            'emi_amount' => '4,449.00',

            // Security Deposits
           'ornaments' => $loan->ornaments,
            // 'sec_name' => 'Coin',
            // 'qty' => '5',
            // 'val_gm' => '4,000.00',
            // 'gross_weight_gm' => '50.0',
            // 'net_weight_gm' => '50.0',
            // 'tunch' => '100.0',
            // 'fine_weight_gm' => '50',
            // 'total_val' => '2000000',
            // 'image' => '',
            // 'status' => 'Mortgage'
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.gold-appli-sanction-letter', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
        // OR download
        // return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
    }

}
