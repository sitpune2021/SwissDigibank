<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
        $loan->load([
            'member',
            'scheme',
            'branch',
            'disbursement',
        ]);

        $disb = $loan->disbursement; // shorthand

        $bank = Company::first();

        // Build full bank address
        $bankAddress = collect([
            $bank->address_line1 ?? '',
            $bank->address_line2 ?? '',
            $bank->city ?? '',
            optional($bank->state)->name ?? '',
            $bank->pincode ?? '',
            $bank->country ?? '',
        ])->filter()->implode(', ');

        $data = [
            'printed_on' => now()->format('d-m-Y'),
            'date'       => optional($disb->disbursal_date)->format('d-m-Y'),
            'account_holder' =>
            trim(
                ($loan->member->member_info_title ?? '') . '. ' .
                    ($loan->member->member_info_first_name ?? '') . ' ' .
                    ($loan->member->member_info_last_name ?? '')
            ),

            'member_id'      => $loan->member->member_no ?? '',
            'member_address' => $loan->member->address ?? '',
            'member_mobile'  => $loan->member->mobile ?? '',
            'member_state'   => $loan->member->state ?? '',

            'bank_name'       => $bank->company_name ?? '',
            'bank_adr_branch' => $loan->branch->branch_name ?? '',
            'bank_adr'        => $bankAddress,

            'loan_no'     => $loan->id,
            'loan_amount' => $disb->loan_amount ?? 0,

            'processing_charges' => $disb->processing_fee_total ?? 0,
            'stamp_duty'         => $disb->stamp_duty_total ?? 0,
            'insurance_fee'      => $disb->insurance_total ?? 0,
            'advance_interest'   => $disb->advance_interest ?? 0,

            'final_amount' => $disb->final_amount_to_disburse ?? 0,
        ];

        return view('gold-loan.gold-loan-pdf.disburse-letter-view', $data);
    }
    public function disburse_letter(LoanApplication $loan)
    {
        $loan->load([
            'member',
            'scheme',
            'branch',
            'disbursement',
        ]);

        $disb = $loan->disbursement; // shorthand

        $bank = Company::first();

        // Build full bank address
        $bankAddress = collect([
            $bank->address_line1 ?? '',
            $bank->address_line2 ?? '',
            $bank->city ?? '',
            optional($bank->state)->name ?? '',
            $bank->pincode ?? '',
            $bank->country ?? '',
        ])->filter()->implode(', ');

        $data = [
            'printed_on' => now()->format('d-m-Y'),
            'date'       => optional($disb->disbursal_date)->format('d-m-Y'),
            'account_holder' =>
            trim(
                ($loan->member->member_info_title ?? '') . '. ' .
                    ($loan->member->member_info_first_name ?? '') . ' ' .
                    ($loan->member->member_info_last_name ?? '')
            ),

            'member_id'      => $loan->member->member_no ?? '',
            'member_address' => $loan->member->address ?? '',
            'member_mobile'  => $loan->member->mobile ?? '',
            'member_state'   => $loan->member->state ?? '',

            'bank_name'       => $bank->company_name ?? '',
            'bank_adr_branch' => $loan->branch->branch_name ?? '',
            'bank_adr'        => $bankAddress,

            'loan_no'     => $loan->id,
            'loan_amount' => $disb->loan_amount ?? 0,

            'processing_charges' => $disb->processing_fee_total ?? 0,
            'stamp_duty'         => $disb->stamp_duty_total ?? 0,
            'insurance_fee'      => $disb->insurance_total ?? 0,
            'advance_interest'   => $disb->advance_interest ?? 0,

            'final_amount' => $disb->final_amount_to_disburse ?? 0,
        ];

        $pdf = Pdf::loadView('gold-loan.gold-loan-pdf.disburse-letter', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Gold_Loan_Disbursement_Letter.pdf');
    }
    public function letter_udertaking_gold_view(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'branch']);
        $loanAmount = $loan->approved_loan_amount ?? 0;
        $bank = Company::first();
        // Build full bank address
        $bankAddress = collect([
            $bank->address_line1 ?? '',
            $bank->address_line2 ?? '',
            $bank->city ?? '',
            optional($bank->state)->name ?? '', // if state is FK
            $bank->pincode ?? '',
            $bank->country ?? '',
        ])->filter()->implode(', ');

        $data = [
            'printed_on' => date('d-m-Y'),
            'date' => date('d-m-Y'),
            'bank_name' => $bank->company_name ?? '',
            'bank_adr_branch' => $loan->branch->branch_name ?? '',
            'bank_adr' => $bankAddress,
            'loan_no' => $loan->id,
            'loan_amount' => $loanAmount,
            'loan_amount_words' => $this->amountInWords($loanAmount),
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'bank_details' => '',
            'processing_charges' => 0,
            'stamp_duty' => $loan->scheme->stamp_duty_charge ?? 0,
            'insurance_fee' => $loan->scheme->insurance_fee ?? 0,
            'final_amount' => 'static',
            'installments' => 'static',
            'state' => ''

        ];

        return view('gold-loan.gold-loan-pdf.letter-udertaking-gold-view', $data);
    }
    public function letter_udertaking_gold(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'branch']);
        $loanAmount = $loan->approved_loan_amount ?? 0;
        $bank = Company::first();
        // Build full bank address
        $bankAddress = collect([
            $bank->address_line1 ?? '',
            $bank->address_line2 ?? '',
            $bank->city ?? '',
            optional($bank->state)->name ?? '', // if state is FK
            $bank->pincode ?? '',
            $bank->country ?? '',
        ])->filter()->implode(', ');

        $data = [
            'printed_on' => date('d-m-Y'),
            'date' => date('d-m-Y'),
            'bank_name' => $bank->company_name ?? '',
            'bank_adr_branch' => $loan->branch->branch_name ?? '',
            'bank_adr' => $bankAddress,
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

        /* ---------------- BASIC INPUTS ---------------- */
        $loanAmount   = $loan->approved_loan_amount ?? $loan->loan_amount;
        $annualRate   = $scheme->annual_interest_rate ?? 12;
        $interestType = $scheme->gold_loan_setting;

        $tenureValue = (int) $loan->tenure_value;
        $tenureType  = strtoupper($loan->tenure_type);
        $emiCollection = strtolower($loan->emi_collection);

        /* ---------------- TIME IN YEARS ---------------- */
        $timeInYears = match ($tenureType) {
            'WEEKS'  => $tenureValue / 52,
            'DAYS'   => $tenureValue / 365,
            'MONTHS' => $tenureValue / 12,
            default  => $tenureValue / 12,
        };

        /* ---------------- EMI COUNT BASED ON COLLECTION ---------------- */
        $emiCount = match ($emiCollection) {
            'daily'      => $tenureType === 'DAYS'   ? $tenureValue : ceil($tenureValue * 30),
            'weekly'     => $tenureType === 'WEEKS'  ? $tenureValue : ceil($tenureValue * 4),
            'bi_weekly'  => ceil(($tenureType === 'WEEKS' ? $tenureValue : $tenureValue * 4) / 2),
            '4_weekly'   => ceil(($tenureType === 'WEEKS' ? $tenureValue : $tenureValue * 4) / 4),
            'monthly'    => $tenureType === 'MONTHS' ? $tenureValue : ceil($tenureValue / 4),
            'quarterly'  => ceil($tenureValue / 3),
            'half_yearly' => ceil($tenureValue / 6),
            'yearly'     => ceil($tenureValue / 12),
            default      => $tenureValue,
        };

        /* ---------------- PAYOUT SUMMARY DATA ---------------- */
        $data = [
            'printed_on' => now()->format('d-m-Y'),
            'disburse_date' => optional($loan->disbursement?->disbursal_date)
                ? \Carbon\Carbon::parse($loan->disbursement->disbursal_date)->format('d-m-Y')
                : '',
            'loan_no' => $loan->id,

            'loan_amount' => number_format($loanAmount, 2),
            'interest_type' => $interestType,
            'processing_fee' => number_format($loan->processing_fee_total ?? 0, 2),
            'tenure' => $loan->tenure_value . ' ' . $loan->tenure_type,
            'stamp_duty_fee' => number_format($scheme->stamp_duty_charge ?? 0, 2),
            'interest_rate' => $annualRate,
            'insurance_charge' => number_format($scheme->insurance_fee ?? 0, 2),
            'emi_count' => $emiCount,
            'emi_payout' => ucfirst($loan->emi_collection),
            'loan_in_ratio' => $loan->loan_in_ratio ?? '',
            'apr_rate' => $annualRate . '%',
        ];

        /* ---------------- FLAT INTEREST CALCULATION (CORRECT) ---------------- */
        $totalInterest = 0;
        $emi = 0;

        if ($interestType === 'flat_emi' || $interestType === 'flat_advanced_interest') {

            $totalInterest = round($loanAmount * ($annualRate / 100) * $timeInYears, 2);

            $emi = round(
                ($interestType === 'flat_emi'
                    ? ($loanAmount + $totalInterest)
                    : $loanAmount
                ) / $emiCount,
                2
            );
        }

        /* ---------------- REDUCING EMI ---------------- */
        if ($interestType === 'reducing_emi') {

            if ($tenureType !== 'MONTHS') {
                throw new \Exception('Reducing EMI allowed only for MONTHS tenure');
            }

            $monthlyRate = $annualRate / 12 / 100;

            $emi = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureValue))
                / (pow(1 + $monthlyRate, $tenureValue) - 1);

            $emi = round($emi, 2);
        }

        /* ---------------- EMI DATE START ---------------- */
        $emiDateCursor = match ($tenureType) {
            'MONTHS' => Carbon::parse($loan->application_date)->addMonth(),
            'WEEKS'  => Carbon::parse($loan->application_date)->addWeek(),
            'DAYS'   => Carbon::parse($loan->application_date)->addDay(),
        };

        /* ---------------- SCHEDULE ---------------- */
        $balance = $loanAmount;
        $totalPrincipal = 0;
        $totalInterest  = 0;
        $totalCharges   = 0;
        $payoutSchedule = [];

        /* ----- Fixed Charges Per EMI ----- */
        $smsCharge         = $scheme->sms_charge ?? 0;
        $fuelCharge        = $scheme->fuel_charge ?? 0;
        $stationaryCharge  = $scheme->stationary_charge ?? 0;
        $maintenanceCharge = $scheme->maintenance_charge ?? 0;
        $collectionCharge  = $scheme->collection ?? 0;

        $fixedChargePerEmi =
            $smsCharge +
            $fuelCharge +
            $stationaryCharge +
            $maintenanceCharge +
            $collectionCharge;

        for ($i = 1; $i <= $emiCount; $i++) {

            if ($interestType === 'reducing_emi') {

                $interest = round($balance * ($annualRate / 12 / 100), 2);
                $principal = round($emi - $interest, 2);
            } elseif ($interestType === 'flat_emi') {

                $principal = round($loanAmount / $emiCount, 2);
                $interest  = round($totalInterest / $emiCount, 2);
            } elseif ($interestType === 'flat_advanced_interest') {

                $principal = round($loanAmount / $emiCount, 2);
                $interest  = 0;
            } elseif ($interestType === 'no_emi') {

                $interest = round($loanAmount * ($annualRate / 100) * $timeInYears / $emiCount, 2);
                $principal = 0;
            }

            if ($i === $emiCount) {
                $principal = $balance;
            }

            $balance = round($balance - $principal, 2);

            $charge = $fixedChargePerEmi;

            $totalPrincipal += $principal;
            $totalInterest  += $interest;
            $totalCharges   += $charge;

            $payoutSchedule[] = [
                'emi_no' => $i,
                'emi_date' => $emiDateCursor->format('d-M-y'),
                'emi_principle' => number_format($principal, 2),
                'emi_interest' => number_format($interest, 2),
                'per_emi_charges' => number_format($charge, 2),
                'emi_amount' => number_format($principal + $interest + $charge, 2),
                'balance_principle' => number_format(max($balance, 0), 2),
            ];

            /* ----- Date Increment ----- */
            match ($emiCollection) {
                'daily'       => $emiDateCursor->addDay(),
                'weekly'      => $emiDateCursor->addWeek(),
                'bi_weekly'   => $emiDateCursor->addWeeks(2),
                '4_weekly'    => $emiDateCursor->addWeeks(4),
                'monthly'     => $emiDateCursor->addMonth(),
                'quarterly'   => $emiDateCursor->addMonths(3),
                'half_yearly' => $emiDateCursor->addMonths(6),
                'yearly'      => $emiDateCursor->addYear(),
                default       => $emiDateCursor->addMonth(),
            };
        }

        return view(
            'gold-loan.gold-loan-pdf.gold-appli-payout-chart-view',
            [
                ...$data,
                'loan_no' => $loan->id,
                'payoutSchedule'   => $payoutSchedule,
                'total_emi_principle' => number_format($totalPrincipal, 2),
                'total_emi_interest'  => number_format($totalInterest, 2),
                'total_per_emi_charges' => number_format($totalCharges, 2),
                'total_emi_amount' => number_format($totalPrincipal + $totalInterest + $totalCharges, 2),
            ]
        );
    }

    public function payout_chart_gold_appli(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;

        /* ---------------- BASIC INPUTS ---------------- */
        $loanAmount   = $loan->approved_loan_amount ?? $loan->loan_amount;
        $annualRate   = $scheme->annual_interest_rate ?? 12;
        $interestType = $scheme->gold_loan_setting;

        $tenureValue = (int) $loan->tenure_value;
        $tenureType  = strtoupper($loan->tenure_type);
        $emiCollection = strtolower($loan->emi_collection);

        /* ---------------- TIME IN YEARS ---------------- */
        $timeInYears = match ($tenureType) {
            'WEEKS'  => $tenureValue / 52,
            'DAYS'   => $tenureValue / 365,
            'MONTHS' => $tenureValue / 12,
            default  => $tenureValue / 12,
        };

        /* ---------------- EMI COUNT BASED ON COLLECTION ---------------- */
        $emiCount = match ($emiCollection) {
            'daily'      => $tenureType === 'DAYS'   ? $tenureValue : ceil($tenureValue * 30),
            'weekly'     => $tenureType === 'WEEKS'  ? $tenureValue : ceil($tenureValue * 4),
            'bi_weekly'  => ceil(($tenureType === 'WEEKS' ? $tenureValue : $tenureValue * 4) / 2),
            '4_weekly'   => ceil(($tenureType === 'WEEKS' ? $tenureValue : $tenureValue * 4) / 4),
            'monthly'    => $tenureType === 'MONTHS' ? $tenureValue : ceil($tenureValue / 4),
            'quarterly'  => ceil($tenureValue / 3),
            'half_yearly' => ceil($tenureValue / 6),
            'yearly'     => ceil($tenureValue / 12),
            default      => $tenureValue,
        };

        /* ---------------- PAYOUT SUMMARY DATA ---------------- */
        $data = [
            'printed_on' => now()->format('d-m-Y'),
            'disburse_date' => optional($loan->disbursement?->disbursal_date)
                ? \Carbon\Carbon::parse($loan->disbursement->disbursal_date)->format('d-m-Y')
                : '',
            'loan_no' => $loan->id,

            'loan_amount' => number_format($loanAmount, 2),
            'interest_type' => $interestType,
            'processing_fee' => number_format($loan->processing_fee_total ?? 0, 2),
            'tenure' => $loan->tenure_value . ' ' . $loan->tenure_type,
            'stamp_duty_fee' => number_format($scheme->stamp_duty_charge ?? 0, 2),
            'interest_rate' => $annualRate,
            'insurance_charge' => number_format($scheme->insurance_fee ?? 0, 2),
            'emi_count' => $emiCount,
            'emi_payout' => ucfirst($loan->emi_collection),
            'loan_in_ratio' => $loan->loan_in_ratio ?? '',
            'apr_rate' => $annualRate . '%',
        ];

        /* ---------------- FLAT INTEREST CALCULATION (CORRECT) ---------------- */
        $totalInterest = 0;
        $emi = 0;

        if ($interestType === 'flat_emi' || $interestType === 'flat_advanced_interest') {

            $totalInterest = round($loanAmount * ($annualRate / 100) * $timeInYears, 2);

            $emi = round(
                ($interestType === 'flat_emi'
                    ? ($loanAmount + $totalInterest)
                    : $loanAmount
                ) / $emiCount,
                2
            );
        }

        /* ---------------- REDUCING EMI ---------------- */
        if ($interestType === 'reducing_emi') {

            if ($tenureType !== 'MONTHS') {
                throw new \Exception('Reducing EMI allowed only for MONTHS tenure');
            }

            $monthlyRate = $annualRate / 12 / 100;

            $emi = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureValue))
                / (pow(1 + $monthlyRate, $tenureValue) - 1);

            $emi = round($emi, 2);
        }

        /* ---------------- EMI DATE START ---------------- */
        $emiDateCursor = match ($tenureType) {
            'MONTHS' => Carbon::parse($loan->application_date)->addMonth(),
            'WEEKS'  => Carbon::parse($loan->application_date)->addWeek(),
            'DAYS'   => Carbon::parse($loan->application_date)->addDay(),
        };

        /* ---------------- SCHEDULE ---------------- */
        $balance = $loanAmount;
        $totalPrincipal = 0;
        $totalInterest  = 0;
        $totalCharges   = 0;
        $payoutSchedule = [];

        /* ----- Fixed Charges Per EMI ----- */
        $smsCharge         = $scheme->sms_charge ?? 0;
        $fuelCharge        = $scheme->fuel_charge ?? 0;
        $stationaryCharge  = $scheme->stationary_charge ?? 0;
        $maintenanceCharge = $scheme->maintenance_charge ?? 0;
        $collectionCharge  = $scheme->collection ?? 0;

        $fixedChargePerEmi =
            $smsCharge +
            $fuelCharge +
            $stationaryCharge +
            $maintenanceCharge +
            $collectionCharge;

        for ($i = 1; $i <= $emiCount; $i++) {

            if ($interestType === 'reducing_emi') {

                $interest = round($balance * ($annualRate / 12 / 100), 2);
                $principal = round($emi - $interest, 2);
            } elseif ($interestType === 'flat_emi') {

                $principal = round($loanAmount / $emiCount, 2);
                $interest  = round($totalInterest / $emiCount, 2);
            } elseif ($interestType === 'flat_advanced_interest') {

                $principal = round($loanAmount / $emiCount, 2);
                $interest  = 0;
            } elseif ($interestType === 'no_emi') {

                $interest = round($loanAmount * ($annualRate / 100) * $timeInYears / $emiCount, 2);
                $principal = 0;
            }

            if ($i === $emiCount) {
                $principal = $balance;
            }

            $balance = round($balance - $principal, 2);

            $charge = $fixedChargePerEmi;

            $totalPrincipal += $principal;
            $totalInterest  += $interest;
            $totalCharges   += $charge;

            $payoutSchedule[] = [
                'emi_no' => $i,
                'emi_date' => $emiDateCursor->format('d-M-y'),
                'emi_principle' => number_format($principal, 2),
                'emi_interest' => number_format($interest, 2),
                'per_emi_charges' => number_format($charge, 2),
                'emi_amount' => number_format($principal + $interest + $charge, 2),
                'balance_principle' => number_format(max($balance, 0), 2),
            ];

            /* ----- Date Increment ----- */
            match ($emiCollection) {
                'daily'       => $emiDateCursor->addDay(),
                'weekly'      => $emiDateCursor->addWeek(),
                'bi_weekly'   => $emiDateCursor->addWeeks(2),
                '4_weekly'    => $emiDateCursor->addWeeks(4),
                'monthly'     => $emiDateCursor->addMonth(),
                'quarterly'   => $emiDateCursor->addMonths(3),
                'half_yearly' => $emiDateCursor->addMonths(6),
                'yearly'      => $emiDateCursor->addYear(),
                default       => $emiDateCursor->addMonth(),
            };
        }
        $pdf = Pdf::loadView(
            'gold-loan.gold-loan-pdf.gold-appli-payout-chart',
            [
                ...$data,
                'loan_no' => $loan->id,
                'payoutSchedule'   => $payoutSchedule,
                'total_emi_principle' => number_format($totalPrincipal, 2),
                'total_emi_interest'  => number_format($totalInterest, 2),
                'total_per_emi_charges' => number_format($totalCharges, 2),
                'total_emi_amount' => number_format($totalPrincipal + $totalInterest + $totalCharges, 2),
            ]
        )->setPaper('A4', 'portrait');

        return $pdf->download('payout_chart_gold_loan_application.pdf');
    }
    public function promisary_note_view(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;

        $bank = Company::first();
        // Build full bank address
        $bankAddress = collect([
            $bank->address_line1 ?? '',
            $bank->address_line2 ?? '',
            $bank->city ?? '',
            optional($bank->state)->name ?? '',
            $bank->pincode ?? '',
            $bank->country ?? '',
        ])->filter()->implode(', ');

        $loanAmount = $loan->approved_loan_amount ?? 0;
        $data = [
            'loan_no' => $loan->id,
            'name' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'date' => date('d-m-Y'),
            'bank_name'       => $bank->company_name ?? '',
            'bank_adr_branch' => $loan->branch->branch_name ?? '',
            'bank_adr'        => $bankAddress,
            'amount' => number_format($loanAmount, 2),
            'amount_words' => $this->amountInWords($loanAmount),
            'interest_rate' => $scheme->annual_interest_rate,
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'state' => 'Maharashtra',
        ];



        return view('gold-loan.gold-loan-pdf.gold-appli-promisary-note-view', $data);
    }
    public function promisary_note(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement']);
        $scheme = $loan->scheme;

        $bank = Company::first();
        // Build full bank address
        $bankAddress = collect([
            $bank->address_line1 ?? '',
            $bank->address_line2 ?? '',
            $bank->city ?? '',
            optional($bank->state)->name ?? '',
            $bank->pincode ?? '',
            $bank->country ?? '',
        ])->filter()->implode(', ');

        $loanAmount = $loan->approved_loan_amount ?? 0;
        $data = [
            'loan_no' => $loan->id,
            'name' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'date' => date('d-m-Y'),
            'bank_name'       => $bank->company_name ?? '',
            'bank_adr_branch' => $loan->branch->branch_name ?? '',
            'bank_adr'        => $bankAddress,
            'amount' => number_format($loanAmount, 2),
            'amount_words' => $this->amountInWords($loanAmount),
            'interest_rate' => $scheme->annual_interest_rate,
            'account_holder' => $loan->member->member_info_title . '.' . $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name ?? '',
            'state' => 'Maharashtra',
        ];


        $pdf = Pdf::loadView('gold-loan.gold-loan-pdf.gold-appli-promisary-note', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('promissory-note.pdf');
    }

    public function sanction_letter_view(LoanApplication $loan)
    {
        $loan->load(['member', 'scheme', 'disbursement', 'branch', 'ornaments']);

        $statusText = match ($loan->status) {
            0 => 'DRAFT',
            1 => 'APPROVED',
            2 => 'DISBURSED',
            3 => 'CANCELLED',
            default => 'UNKNOWN',
        };

        $scheme = $loan->scheme;

        /* ---------------- BASIC INPUTS ---------------- */
        $loanAmount   = $loan->approved_loan_amount ?? $loan->loan_amount;
        $annualRate   = $scheme->annual_interest_rate ?? 12;
        $interestType = $scheme->gold_loan_setting;

        $tenureValue = (int) $loan->tenure_value;
        $tenureType  = strtoupper($loan->tenure_type);

        /* ---------------- TENURE CONVERSION ---------------- */
        $tenureMonths = match ($tenureType) {
            'MONTHS' => $tenureValue,
            'WEEKS'  => round($tenureValue / 4, 2),
            'DAYS'   => round($tenureValue / 30, 2),
            default  => $tenureValue,
        };

        $emiCount = $tenureValue;

        $monthlyRate = $annualRate / 12 / 100;

        /* ---------------- DEFAULT VALUES ---------------- */
        $emiAmount = 0;

        /* ---------------- EMI / PAYOUT LOGIC ---------------- */
        switch ($interestType) {

            /* ========= REDUCING EMI (MONTHLY ONLY) ========= */
            case 'reducing_emi':

                if ($tenureType !== 'MONTHS') {
                    throw new \Exception('Reducing EMI allowed only for MONTHS tenure');
                }

                $emiAmount = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths))
                    / (pow(1 + $monthlyRate, $tenureMonths) - 1);

                $emiAmount = round($emiAmount, 2);
                break;

            /* ========= FLAT EMI ========= */
            case 'flat_emi':

                $totalInterest = $loanAmount * ($annualRate / 100) * ($tenureMonths / 12);
                $emiAmount = round(($loanAmount + $totalInterest) / $tenureMonths, 2);
                break;

            /* ========= FLAT ADVANCED INTEREST ========= */
            case 'flat_advanced_interest':

                // EMI is principal-only
                $emiAmount = round($loanAmount / $tenureMonths, 2);
                break;

            /* ========= NO EMI ========= */
            case 'no_emi':

                // Interest-only collection
                $emiAmount = match ($tenureType) {
                    'MONTHS' => round($loanAmount * ($annualRate / 100) / 12, 2),
                    'WEEKS'  => round($loanAmount * ($annualRate / 100) / 52, 2),
                    'DAYS'   => round($loanAmount * ($annualRate / 100) / 365, 2),
                };
                break;
        }

        /* ---------------- SANCTION LETTER DATA ---------------- */
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'branch' => $loan->branch->branch_name ?? '',

            'member_name' => ($loan->member->member_info_title ?? '') . '. ' .
                ($loan->member->member_info_first_name ?? '') . ' ' .
                ($loan->member->member_info_last_name ?? ''),

            'bank_details' => '',
            'member_no' => str_pad($loan->member_id, 6, '0', STR_PAD_LEFT),
            'father_husband' => '',
            'contact_no' => $loan->member->member_info_mobile_no ?? '',
            'address' => '',

            'application_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),
            'application_date' => $loan->application_date
                ? Carbon::parse($loan->application_date)->format('d-m-Y')
                : '',

            'application_status' => $statusText,
            'loan_id' => $loan->id,
            'loan_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),

            'nature_of_loan' => 'Gold Loan',
            'loan_scheme' => $scheme->scheme_name ?? '',
            'loan_amount' => number_format($loanAmount, 2),

            'tenure_of_loan' => $loan->tenure_value . ' ' . $loan->tenure_type,
            'interest_type' => $interestType,
            'annual_interset_rate' => $annualRate,

            'emi_payout' => ucfirst($loan->emi_collection),
            'emi_amt' => number_format($emiAmount, 2),
            'no_of_emis' => $emiCount,

            'credit_grace_period' => $loan->credit_period,
            'processing_fee' => number_format($scheme->processing_fee ?? 0, 2),
            'stamp_duty' => number_format($scheme->stamp_duty_charge ?? 0, 2),
            'insurance_fee' => number_format($scheme->insurance_fee ?? 0, 2),

            // Security
            'ornaments' => $loan->ornaments,
        ];

        return view('gold-loan.gold-loan-pdf.gold-appli-sanction-letter-view', $data);
    }
    public function sanction_letter(LoanApplication $loan)
    {

        $loan->load(['member', 'scheme', 'disbursement', 'branch', 'ornaments']);

        $statusText = match ($loan->status) {
            0 => 'DRAFT',
            1 => 'APPROVED',
            2 => 'DISBURSED',
            3 => 'CANCELLED',
            default => 'UNKNOWN',
        };

        $scheme = $loan->scheme;

        /* ---------------- BASIC INPUTS ---------------- */
        $loanAmount   = $loan->approved_loan_amount ?? $loan->loan_amount;
        $annualRate   = $scheme->annual_interest_rate ?? 12;
        $interestType = $scheme->gold_loan_setting;

        $tenureValue = (int) $loan->tenure_value;
        $tenureType  = strtoupper($loan->tenure_type);

        /* ---------------- TENURE CONVERSION ---------------- */
        $tenureMonths = match ($tenureType) {
            'MONTHS' => $tenureValue,
            'WEEKS'  => round($tenureValue / 4, 2),
            'DAYS'   => round($tenureValue / 30, 2),
            default  => $tenureValue,
        };

        $emiCount = $tenureValue;

        $monthlyRate = $annualRate / 12 / 100;

        /* ---------------- DEFAULT VALUES ---------------- */
        $emiAmount = 0;

        /* ---------------- EMI / PAYOUT LOGIC ---------------- */
        switch ($interestType) {

            /* ========= REDUCING EMI (MONTHLY ONLY) ========= */
            case 'reducing_emi':

                if ($tenureType !== 'MONTHS') {
                    throw new \Exception('Reducing EMI allowed only for MONTHS tenure');
                }

                $emiAmount = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths))
                    / (pow(1 + $monthlyRate, $tenureMonths) - 1);

                $emiAmount = round($emiAmount, 2);
                break;

            /* ========= FLAT EMI ========= */
            case 'flat_emi':

                $totalInterest = $loanAmount * ($annualRate / 100) * ($tenureMonths / 12);
                $emiAmount = round(($loanAmount + $totalInterest) / $tenureMonths, 2);
                break;

            /* ========= FLAT ADVANCED INTEREST ========= */
            case 'flat_advanced_interest':

                // EMI is principal-only
                $emiAmount = round($loanAmount / $tenureMonths, 2);
                break;

            /* ========= NO EMI ========= */
            case 'no_emi':

                // Interest-only collection
                $emiAmount = match ($tenureType) {
                    'MONTHS' => round($loanAmount * ($annualRate / 100) / 12, 2),
                    'WEEKS'  => round($loanAmount * ($annualRate / 100) / 52, 2),
                    'DAYS'   => round($loanAmount * ($annualRate / 100) / 365, 2),
                };
                break;
        }

        /* ---------------- SANCTION LETTER DATA ---------------- */
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'branch' => $loan->branch->branch_name ?? '',

            'member_name' => ($loan->member->member_info_title ?? '') . '. ' .
                ($loan->member->member_info_first_name ?? '') . ' ' .
                ($loan->member->member_info_last_name ?? ''),

            'bank_details' => '',
            'member_no' => str_pad($loan->member_id, 6, '0', STR_PAD_LEFT),
            'father_husband' => '',
            'contact_no' => $loan->member->member_info_mobile_no ?? '',
            'address' => '',

            'application_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),
            'application_date' => $loan->application_date
                ? Carbon::parse($loan->application_date)->format('d-m-Y')
                : '',

            'application_status' => $statusText,
            'loan_id' => $loan->id,
            'loan_no' => str_pad($loan->id, 10, '0', STR_PAD_LEFT),

            'nature_of_loan' => 'Gold Loan',
            'loan_scheme' => $scheme->scheme_name ?? '',
            'loan_amount' => number_format($loanAmount, 2),

            'tenure_of_loan' => $loan->tenure_value . ' ' . $loan->tenure_type,
            'interest_type' => $interestType,
            'annual_interset_rate' => $annualRate,

            'emi_payout' => ucfirst($loan->emi_collection),
            'emi_amt' => number_format($emiAmount, 2),
            'no_of_emis' => $emiCount,

            'credit_grace_period' => $loan->credit_period,
            'processing_fee' => number_format($scheme->processing_fee ?? 0, 2),
            'stamp_duty' => number_format($scheme->stamp_duty_charge ?? 0, 2),
            'insurance_fee' => number_format($scheme->insurance_fee ?? 0, 2),

            // Security
            'ornaments' => $loan->ornaments,
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.gold-appli-sanction-letter', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
        // OR download
        // return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
    }

     public function application_letter_view(LoanApplication $loan)
    {

         $loan->load(['member', 'scheme', 'disbursement', 'branch', 'ornaments']);
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
           
        ];


        return view('gold-loan.gold-loan-pdf.gold-loan-application-view', $data);
        
    }
     public function application_letter(LoanApplication $loan)
    {

        
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
           
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.gold-loan-application', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Gold_Loan_application_Letter.pdf');
        // OR download
        // return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
    }
    public function print_application_letter(LoanApplication $loan)
{

        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
           
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.gold-loan-application', $data)
            ->setPaper('A4', 'portrait');


    // trigger print dialog automatically
    $pdf->getDomPDF()->getCanvas()->get_cpdf()->addJavascript("print(true);");

    return $pdf->stream('gold-loan-application');
}

 public function letterOf_evidencing_view(LoanApplication $loan)
    {
 $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
        ];

        
        return view('gold-loan.gold-loan-pdf.letter-of-evidencing-view', $data);
        
    }
 public function letterOf_evidencing(LoanApplication $loan)
    {

        
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.letter-of-evidencing', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Gold_Loan_letter-of-evidencing.pdf');
        // OR download
        // return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
    }
 public function print_letterOf_evidencing(LoanApplication $loan)
{

         
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.letter-of-evidencing', $data)
            ->setPaper('A4', 'portrait');


    // trigger print dialog automatically
    $pdf->getDomPDF()->getCanvas()->get_cpdf()->addJavascript("print(true);");

    return $pdf->stream('letter-of-evidencing');
}


 public function jurisdiction_ack_letter_view(LoanApplication $loan)
    {

        
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
        ];

      

        return view('gold-loan.gold-loan-pdf.letter-of-jurisdiction-view',$data);
      
    }

 public function jurisdiction_ack_letter(LoanApplication $loan)
    {

        
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.letter-of-jurisdiction', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('jurisdiction_ack_letter.pdf');
        // OR download
        // return $pdf->download('Gold_Loan_Sanction_Letter.pdf');
    }
     public function print_jurisdiction_ack_letter(LoanApplication $loan)
{

        
        $data = [
            'bank_name' => '',
            'printed_on' => date('d-m-Y'),
            'loan_id' => $loan->id,
        ];

        $pdf = PDF::loadView('gold-loan.gold-loan-pdf.letter-of-jurisdiction', $data)
            ->setPaper('A4', 'portrait');


    // trigger print dialog automatically
    $pdf->getDomPDF()->getCanvas()->get_cpdf()->addJavascript("print(true);");

    return $pdf->stream('letter-of-jurisdiction');
}
}
