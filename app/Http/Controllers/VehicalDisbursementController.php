<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicalApplication;
use App\Models\VehicalDisbursement;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;


class VehicalDisbursementController extends Controller
{

    public function index()
    {
        $disbursements = VehicalApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('vehical.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = DB::table('vehical_applications')->where('id', $id)->first();

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        DB::table('vehical_applications')
            ->where('id', $id)
            ->update(['status' => 3]);

        // Debug check
        $updated = DB::table('vehical_applications')->where('id', $id)->first();

        if ($updated->status == 3) {
            return redirect()->back()->with('success', ' Loan cancelled successfully!');
        } else {
            return redirect()->back()->with('error', ' Loan status not updated.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Start log
            Log::info('--- Loan Disbursement Store Started ---', [
                'user_id' => auth()->id(),
                'input' => $request->all(),
            ]);

            // Validate input
            $validated = $request->validate([
                'loan_application_id' => 'required|exists:vehical_applications,id',
                'disbursal_date' => 'required|date_format:d-m-Y',
                'emi_date' => 'required|date_format:d-m-Y',
                'loan_amount' => 'required|numeric|min:1',
                'final_amount' => 'required|numeric|min:1',
            ]);

            // Date conversion
            $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
            $emiDate = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

            DB::beginTransaction();

            // Insert into disbursements
            $disbursement = VehicalDisbursement::create([
                'loan_application_id' => $request->loan_application_id,
                'disbursal_date' => $disbursalDate,
                'emi_date' => $emiDate,
                'loan_amount' => $request->loan_amount,
                'processing_fee' => $request->processing_fee ?? 0,
                'gst_percent' => $request->gst_percent ?? 0,
                'sgst' => $request->sgst ?? 0,
                'cgst' => $request->cgst ?? 0,
                'igst' => $request->igst ?? 0,
                'processing_fee_total' => $request->processing_fee_total ?? 0,
                'stamp_duty_fee' => $request->stamp_duty_fee ?? 0,
                'insurance_fee' => $request->insurance_fee ?? 0,
                'advance_interest' => $request->advance_interest ?? 0,
                'final_amount' => $request->final_amount,

                // Disburse mode 1
                'disburse_mode1' => $request->D_mode_1,
                'payment_mode1' => $request->payment_mode,
                'bank_id1' => $request->bank_id,
                'cheque_no1' => $request->cheque_no,
                'cheque_date1' => $request->cheque_date ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null,
                'transfer_date1' => $request->transfer_date ? Carbon::parse($request->transfer_date)->format('Y-m-d') : null,
                'utr_no1' => $request->utr_no,
                'transfer_mode1' => $request->transfer_mode,
                'saving_acc1' => $request->saving,

                // Disburse mode 2
                'disburse_mode2' => $request->D_mode_2,
                'payment_mode2' => $request->payment_mode2,
                'bank_id2' => $request->bank_id2,
                'cheque_no2' => $request->cheque_no2,
                'cheque_date2' => $request->cheque_date2 ? Carbon::parse($request->cheque_date2)->format('Y-m-d') : null,
                'transfer_date2' => $request->transfer_date2 ? Carbon::parse($request->transfer_date2)->format('Y-m-d') : null,
                'utr_no2' => $request->utr_no2,
                'transfer_mode2' => $request->transfer_mode2,
                'saving_acc2' => $request->saving2,
            ]);

            // Update application status
            DB::table('vehical_applications')
                ->where('id', $request->loan_application_id)
                ->update(['status' => 2]);
            // 🔵 PROCESSING FEE
            if ($request->collect_fee) {

                Log::info('Processing Fee Selected');

                DB::table('vehical_disbursements_fees')->insert([
                    'loan_id'        => $disbursement->id,
                    'fee_type'       => 'processing_fee',
                    'payment_mode'   => $request->processing_fee_mode,
                    'bank_id'        => $request->p_bank_id ?? null,
                    'cheque_no'      => $request->p_cheque_no ?? null,
                    'cheque_date'    => $request->p_cheque_date
                        ? Carbon::createFromFormat('d-m-Y', $request->p_cheque_date)->format('Y-m-d') : null,
                    'transfer_date'  => $request->p_transfer_date
                        ? Carbon::createFromFormat('d-m-Y', $request->p_transfer_date)->format('Y-m-d') : null,
                    'utr_no'         => $request->p_utr_no ?? null,
                    'transfer_mode'  => $request->p_transfer_mode ?? null,
                    'credited_account' => $request->processing_credited_account ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                Log::info('Processing Fee Saved');
            }

            // 🟡 STAMP DUTY
            if ($request->collect_stamp_duty) {

                Log::info('Stamp Duty Selected');

                DB::table('vehical_disbursements_fees')->insert([
                    'loan_id'        => $disbursement->id,
                    'fee_type'       => 'stamp_duty',
                    'payment_mode'   => $request->stamp_payment_mode,
                    'bank_id'        => $request->stamp_bank_id ?? null,
                    'cheque_no'      => $request->stamp_cheque_no ?? null,
                    'cheque_date'    => $request->stamp_cheque_date
                        ? Carbon::createFromFormat('d-m-Y', $request->stamp_cheque_date)->format('Y-m-d') : null,
                    'transfer_date'  => $request->stamp_transfer_date
                        ? Carbon::createFromFormat('d-m-Y', $request->stamp_transfer_date)->format('Y-m-d') : null,
                    'utr_no'         => $request->stamp_utr_no ?? null,
                    'transfer_mode'  => $request->stamp_transfer_mode ?? null,
                    'credited_account' => $request->stamp_credited_account ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                Log::info('Stamp Duty Saved');
            }

            // 🟢 INSURANCE FEE
            if ($request->collect_insurance_fee) {

                Log::info('Insurance Fee Selected');

                DB::table('vehical_disbursements_fees')->insert([
                    'loan_id'        => $disbursement->id,
                    'fee_type'       => 'issuer_fee',
                    'payment_mode'   => $request->insurance_payment_mode,
                    'bank_id'        => $request->insurance_bank_id ?? null,
                    'cheque_no'      => $request->insurance_cheque_no ?? null,
                    'cheque_date'    => $request->insurance_cheque_date
                        ? Carbon::createFromFormat('d-m-Y', $request->insurance_cheque_date)->format('Y-m-d') : null,
                    'transfer_date'  => $request->insurance_transfer_date
                        ? Carbon::createFromFormat('d-m-Y', $request->insurance_transfer_date)->format('Y-m-d') : null,
                    'utr_no'         => $request->insurance_utr_no ?? null,
                    'transfer_mode'  => $request->insurance_transfer_mode ?? null,
                    'credited_account' => $request->insurance_credited_account ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                Log::info('Insurance Fee Saved');
            }
            DB::commit();

            Log::info('Loan Disbursement Created Successfully', [
                'disbursement_id' => $disbursement->id,
            ]);

            return redirect()
                ->route('vehical.account.index')
                ->with('success', 'Loan Disbursement Created Successfully!');
        }

        // Validation error → show on form
        catch (ValidationException $e) {
            Log::warning('Validation Failed During Loan Disbursement', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);
            throw $e;
        }

        // Any other system/DB error
        catch (Exception $e) {
            DB::rollBack();

            Log::error('Loan Disbursement Store Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input' => $request->all(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the disbursement. Please try again.');
        }
    }

    public function show($id)
    {
        // Load loan + scheme + member + branch
        $disbursement = VehicalApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
        $banks = Bank::pluck('name', 'id');

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
        $totalDeductions = $processingTotal + $stampTotal + $insuranceTotal + $advanceInterest;

        // ===== Final amount to disburse =====
        $loanAmount = $disbursement->net_loan_amount ?? 0;
        $finalAmountToDisburse = $loanAmount - $totalDeductions;
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

        return view(
            "vehical.disbursements.disburse-loan",
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
                'emi'
            )
        );
    }
}
