<?php

namespace App\Http\Controllers;

use App\Models\BusinessLoanApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessLoanPrintDocumentController extends Controller
{
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

    public function payout_chart_business_appli_view(BusinessLoanApplication $loan)
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
        $payoutSchedule = [];

        $totalCharges = 0;

        $chargeRate = $scheme->charge_percent ?? 0;   // your DB column
        $chargeType = $scheme->charge_per_emi ?? 0;   // 0 = ON PRINCIPAL, 1 = ON EMI

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

            $totalPrincipal += $principal;

            $charge = 0;

            if ($chargeRate > 0) {

                if ($chargeType == 0) {
                    // ON PRINCIPAL
                    $charge = round($balance * ($chargeRate / 100), 2);
                } else {
                    // ON EMI
                    $charge = round(($principal + $interest) * ($chargeRate / 100), 2);
                }
            }

            $totalCharges += $charge;

            $payoutSchedule[] = [
                'emi_no' => $i,
                'emi_date' => $emiDateCursor->format('d-M-y'),
                'emi_principle' => number_format($principal, 2),
                'emi_interest' => number_format($interest, 2),
                'per_emi_charges' => number_format($charge, 2),
                'emi_amount' => number_format($principal + $interest + $charge, 2),
                'balance_principle' => number_format(max($balance, 0), 2),
            ];

            /* ----- DATE INCREMENT ----- */
            match ($emiCollection) {
                'daily'      => $emiDateCursor->addDay(),
                'weekly'     => $emiDateCursor->addWeek(),
                'bi_weekly'  => $emiDateCursor->addWeeks(2),
                '4_weekly'   => $emiDateCursor->addWeeks(4),
                'monthly'    => $emiDateCursor->addMonth(),
                'quarterly'  => $emiDateCursor->addMonths(3),
                'half_yearly' => $emiDateCursor->addMonths(6),
                'yearly'     => $emiDateCursor->addYear(),
                default      => $emiDateCursor->addMonth(),
            };
        }
        $charge = 0;

        if ($chargeRate > 0) {

            if ($chargeType == 0) {
                // ON PRINCIPAL
                $charge = round($balance * ($chargeRate / 100), 2);
            } else {
                // ON EMI
                $charge = round(($principal + $interest) * ($chargeRate / 100), 2);
            }
        }

        $totalCharges += $charge;

        return view(
            'bussiness.business-loan-pdf.business-payout-chart-view',
            [
                ...$data,
                'loan_no' => $loan->id,
                'payoutSchedule'   => $payoutSchedule,
                'total_emi_principle' => number_format($principal, 2),
                'total_emi_interest' => number_format($interest, 2),
                'total_per_emi_charges' => number_format($charge, 2),
                'total_emi_amount' => number_format($principal + $interest + $charge, 2),
            ]
        );
    }

    public function payout_chart_business_appli(BusinessLoanApplication $loan)
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
        $payoutSchedule = [];

        $totalCharges = 0;

        $chargeRate = $scheme->charge_percent ?? 0;   // your DB column
        $chargeType = $scheme->charge_per_emi ?? 0;   // 0 = ON PRINCIPAL, 1 = ON EMI

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

            $totalPrincipal += $principal;

            $charge = 0;

            if ($chargeRate > 0) {

                if ($chargeType == 0) {
                    // ON PRINCIPAL
                    $charge = round($balance * ($chargeRate / 100), 2);
                } else {
                    // ON EMI
                    $charge = round(($principal + $interest) * ($chargeRate / 100), 2);
                }
            }

            $totalCharges += $charge;

            $payoutSchedule[] = [
                'emi_no' => $i,
                'emi_date' => $emiDateCursor->format('d-M-y'),
                'emi_principle' => number_format($principal, 2),
                'emi_interest' => number_format($interest, 2),
                'per_emi_charges' => number_format($charge, 2),
                'emi_amount' => number_format($principal + $interest + $charge, 2),
                'balance_principle' => number_format(max($balance, 0), 2),
            ];

            /* ----- DATE INCREMENT ----- */
            match ($emiCollection) {
                'daily'      => $emiDateCursor->addDay(),
                'weekly'     => $emiDateCursor->addWeek(),
                'bi_weekly'  => $emiDateCursor->addWeeks(2),
                '4_weekly'   => $emiDateCursor->addWeeks(4),
                'monthly'    => $emiDateCursor->addMonth(),
                'quarterly'  => $emiDateCursor->addMonths(3),
                'half_yearly' => $emiDateCursor->addMonths(6),
                'yearly'     => $emiDateCursor->addYear(),
                default      => $emiDateCursor->addMonth(),
            };
        }
        $charge = 0;

        if ($chargeRate > 0) {

            if ($chargeType == 0) {
                // ON PRINCIPAL
                $charge = round($balance * ($chargeRate / 100), 2);
            } else {
                // ON EMI
                $charge = round(($principal + $interest) * ($chargeRate / 100), 2);
            }
        }

        $totalCharges += $charge;


        $pdf = Pdf::loadView(
            'bussiness.bussiness-loan-pdf.bussiness-payout-chart',
            [
                ...$data,
                'loan_no' => $loan->id,
                'payoutSchedule'   => $payoutSchedule,
                'total_emi_principle' => number_format($principal, 2),
                'total_emi_interest' => number_format($interest, 2),
                'total_per_emi_charges' => number_format($charge, 2),
                'total_emi_amount' => number_format($principal + $interest + $charge, 2),
            ]
        )->setPaper('A4', 'portrait');

        return $pdf->download('payout_chart_loan_application.pdf');
    }
}
