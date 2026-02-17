<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MortgageLoanApplication;
use App\Models\MortgageLoanDisbursement;
use App\Models\Bank;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;


class MortgageDisbursementController extends Controller
{

    public function index()
    {
        $disbursements = MortgageLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            // ->whereNotIn('id', $disbursedIds)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('mortgage.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = DB::table('mortgage_loan_applications')->where('id', $id)->first();

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        DB::table('mortgage_loan_applications')
            ->where('id', $id)
            ->update(['status' => 3]);

        // Debug check
        $updated = DB::table('mortgage_loan_applications')->where('id', $id)->first();

        if ($updated->status == 3) {
            return redirect()->back()->with('success', ' Loan cancelled successfully!');
        } else {
            return redirect()->back()->with('error', ' Loan status not updated.');
        }
    }

    public function store(Request $request)
    {
        try {

            Log::info('===== Mortgage Loan Disbursement Store START =====', [
                'user_id' => auth()->id(),
                'input'   => $request->all(),
            ]);

            $request->validate([
                'loan_application_id' => 'required|exists:mortgage_loan_applications,id',
                'disbursal_date'       => 'required|date_format:d-m-Y',
                'emi_date'             => 'required|date_format:d-m-Y',
                'loan_amount'          => 'required|numeric|min:1',
                'final_amount'         => 'required|numeric|min:1',
            ]);

            $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
            $emiDate       = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

            DB::beginTransaction();
            Log::info('Transaction Started');

            /*
        =========================
        MAIN DISBURSEMENT INSERT
        =========================
        */

            $disbursement = MortgageLoanDisbursement::create([

                'loan_application_id' => $request->loan_application_id,
                'disbursal_date'      => $disbursalDate,
                'emi_date'            => $emiDate,
                'loan_amount'         => $request->loan_amount,

                'processing_fee'       => $request->processing_fee ?? 0,
                'gst_percent'          => $request->gst_percent ?? 0,
                'sgst'                 => $request->sgst ?? 0,
                'cgst'                 => $request->cgst ?? 0,
                'igst'                 => $request->igst ?? 0,
                'processing_fee_total' => $request->processing_fee_total ?? 0,
                'stamp_duty_fee'       => $request->stamp_duty_fee ?? 0,
                'insurance_fee'        => $request->insurance_fee ?? 0,
                'advance_interest'     => $request->advance_interest ?? 0,
                'final_amount'         => $request->final_amount,

                /*
            =========================
            DISBURSE MODE 1
            =========================
            */

                'disburse_mode1' => $request->D_mode_1 ?? 0,
                'payment_mode1'  => $request->payment_mode,
                'bank_id1'       => $request->bank_id,
                'cheque_no1'     => $request->cheque_no,
                'cheque_date1'   => $request->cheque_date
                    ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d')
                    : null,
                'transfer_date1' => $request->transfer_date
                    ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d')
                    : null,
                'utr_no1'        => $request->utr_no,
                'transfer_mode1' => $request->transfer_mode,
                'saving_acc1'    => $request->saving,

                /*
            =========================
            DISBURSE MODE 2
            =========================
            */

                'disburse_mode2' => $request->D_mode_2 ?? 0,
                'payment_mode2'  => $request->payment_mode2,
                'bank_id2'       => $request->bank_id2,
                'cheque_no2'     => $request->cheque_no2,
                'cheque_date2'   => $request->cheque_date2
                    ? Carbon::createFromFormat('d-m-Y', $request->cheque_date2)->format('Y-m-d')
                    : null,
                'transfer_date2' => $request->transfer_date2
                    ? Carbon::createFromFormat('d-m-Y', $request->transfer_date2)->format('Y-m-d')
                    : null,
                'utr_no2'        => $request->utr_no2,
                'transfer_mode2' => $request->transfer_mode2,
                'saving_acc2'    => $request->saving2,
            ]);

            Log::info('Disbursement Inserted', [
                'disbursement_id' => $disbursement->id
            ]);

            /*
        =========================
        UPDATE APPLICATION STATUS
        =========================
        */

            DB::table('mortgage_loan_applications')
                ->where('id', $request->loan_application_id)
                ->update(['status' => 2]);

            Log::info('Application Status Updated');

            /*
        =========================
        COMMON FEE INSERT FUNCTION
        =========================
        */

            $insertFee = function ($feeType, $prefix) use ($request, $disbursement) {

                $paymentMode = $request->{$prefix . '_payment_mode'};

                if (!$paymentMode) {
                    Log::info("No {$feeType} mode selected");
                    return;
                }

                DB::table('mortgage_loan_disbursement_fee_modes')->insert([

                    'morg_disbursement_id' => $disbursement->id,
                    'fee_type'             => $feeType,
                    'payment_mode'         => $paymentMode,

                    'bank_id' => $paymentMode == 'cheque'
                        ? $request->{$prefix . '_bank_id'} : null,

                    'cheque_no' => $paymentMode == 'cheque'
                        ? $request->{$prefix . '_cheque_no'} : null,

                    'cheque_date' => $paymentMode == 'cheque'
                        && $request->{$prefix . '_cheque_date'}
                        ? Carbon::createFromFormat(
                            'd-m-Y',
                            $request->{$prefix . '_cheque_date'}
                        )->format('Y-m-d')
                        : null,

                    'transfer_date' => $paymentMode == 'online'
                        && $request->{$prefix . '_transfer_date'}
                        ? Carbon::createFromFormat(
                            'd-m-Y',
                            $request->{$prefix . '_transfer_date'}
                        )->format('Y-m-d')
                        : null,

                    'utr_no' => $paymentMode == 'online'
                        ? $request->{$prefix . '_utr_no'} : null,

                    'transfer_mode' => $paymentMode == 'online'
                        ? $request->{$prefix . '_transfer_mode'} : null,

                    'credited_account' => $paymentMode == 'online'
                        ? ($request->{$prefix . '_credited_account'} == 'yes' ? 1 : 0)
                        : null,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info("{$feeType} Inserted Successfully");
            };

            /*
        =========================
        INSERT ALL FEES
        =========================
        */

            $insertFee('stamp_duty', 'stamp');
            $insertFee('issuer_fee', 'insurance');
            $insertFee('processing_fee', 'processing');

            DB::commit();
            Log::info('Transaction Committed Successfully');

            return redirect()
                ->route('mortgage.account.index')
                ->with('success', 'Loan Disbursement Created Successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Mortgage Loan Disbursement FAILED', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'input'   => $request->all(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving.');
        }
    }

    public function show($id)
    {
        // Load loan + scheme + member + branch
        $disbursement = MortgageLoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
        $banks = Bank::pluck('name', 'id');
        $savingAccounts = Account::where('account_type', 'SAVING')->pluck('account_no');

        // Base scheme values
        $scheme = optional($disbursement->scheme);
        $processingFee = $scheme->processing_fee ?? 0;
        $stampDutyFee = $scheme->stamp_duty_charge ?? 0;
        $insuranceFee = $scheme->insurance_fee ?? 0;

        // Common GST percent
        $gstPercent = 18;

        // ===== Processing Fee Logic =====
        $processingGst = ($processingFee * $gstPercent) / 100;
        $processingTotal = $processingFee + $processingGst;

        // ===== Stamp Duty Logic =====
        $stampGst = ($stampDutyFee * $gstPercent) / 100;
        $stampTotal = $stampDutyFee + $stampGst;

        // ===== Insurance Fee Logic =====
        $insuranceGst = ($insuranceFee * $gstPercent) / 100;
        $insuranceTotal = $insuranceFee + $insuranceGst;

        // ===== SGST / CGST / IGST fix 0 =====
        $sgst = 0;
        $cgst = 0;
        $igst = 0;

        // ===== Interest calculation =====
        $maxLoanAmount = $scheme->max_loan_amount ?? 0;
        $annualInterestRate = $scheme->annual_interest_rate ?? 0;
        $advanceInterest = ($maxLoanAmount * $annualInterestRate) / 100;

        // ===== Total deductions =====
        //$totalDeductions = $processingTotal + $stampTotal + $insuranceTotal + $advanceInterest;
        if ($scheme->gold_loan_setting === 'flat_advanced_interest') {
            $totalDeductions = $processingTotal + $stampTotal + $insuranceTotal + $advanceInterest;
        } else {
            $totalDeductions = $processingTotal + $stampTotal + $insuranceTotal;
        }

        // ===== Final amount to disburse =====
        $loanAmount = $disbursement->approved_loan_amount ?? 0;
        //$finalAmountToDisburse = $loanAmount - $totalDeductions;
        if ($scheme->gold_loan_setting === 'flat_advanced_interest') {
            $finalAmountToDisburse = $loanAmount - $totalDeductions;
        } else {
            $finalAmountToDisburse = $loanAmount - ($processingTotal + $stampTotal + $insuranceTotal);
        }
        if ($finalAmountToDisburse < 0) $finalAmountToDisburse = 0; // safety

        // Approved Loan Amount
        $approvedLoan = (float) ($disbursement->approved_loan_amount ?? 0);

        // Annual interest rate
        $annualRate = (float) ($scheme->annual_interest_rate ?? 0);

        // Tenure months (default 12)
        $tenureMonths = (int) ($disbursement->tenure_months ?? 12);

        // Monthly Rate
        $monthlyRate = $annualRate / 12 / 100;

        // EMI Calculation (reducing)
        if ($monthlyRate > 0) {
            $emi = round(
                ($approvedLoan * $monthlyRate * pow(1 + $monthlyRate, $tenureMonths)) /
                    (pow(1 + $monthlyRate, $tenureMonths) - 1),
                2
            );
        } else {
            $emi = round($approvedLoan / $tenureMonths, 2);
        }

        // Total interest
        $totalInterest = round(($emi * $tenureMonths) - $approvedLoan, 2);

        // Total Recover Amount
        $totalRecover = round($approvedLoan + $totalInterest, 2);

        $isAdvanceInterest = ($scheme->gold_loan_setting === 'flat_advanced_interest');

        return view(
            "mortgage.disbursements.disburse-loan",
            compact(
                'disbursement',
                'banks',
                'processingFee',
                'processingGst',
                'processingTotal',
                'stampDutyFee',
                'stampGst',
                'stampTotal',
                'insuranceFee',
                'insuranceGst',
                'insuranceTotal',
                'gstPercent',
                'sgst',
                'cgst',
                'igst',
                'maxLoanAmount',
                'annualInterestRate',
                'advanceInterest',
                'finalAmountToDisburse',
                'loanAmount',
                'totalDeductions',
                'totalInterest',
                'totalRecover',
                'emi',
                'isAdvanceInterest',
                'savingAccounts'

            )
        );
    }
    
}
