<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\GoldLoanDisbursement;
use App\Models\Bank;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class DisbursementController extends Controller
{
    
    public function index()
    {
        $disbursements = LoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            ->paginate(20);

        return view('gold-loan.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = LoanApplication::find($id);

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        // Update status to 0 (cancelled )
        $loan->status = 3;
        $loan->save();

        return redirect()->back()->with('success', 'Loan has been cancelled successfully.');

    }

    public function store(Request $request)
    {
        try {
            // Start log
            Log::info('--- Loan Disbursement Store Started ---', [
                'user_id' => Auth::id(),
                'input' => $request->all(),
            ]);

            // Validate input
            $validated = $request->validate([
                'loan_application_id' => 'required|exists:loan_applications,id',
                'disbursal_date' => 'required|date_format:d-m-Y',
                'emi_date' => 'required|date_format:d-m-Y',
                'loan_amount' => 'required|numeric|min:1',
                'final_amount' => 'required|numeric|min:1',
            ]);

            // Check if this loan application already has a disbursement
            $existing = GoldLoanDisbursement::where('loan_application_id', $request->loan_application_id)->first();

            if ($existing) {
                return back()
                    ->withInput()
                    ->withErrors(['loan_application_id' => 'This loan application is already disbursed.']);
            }

            // Date conversion
            $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
            $emiDate = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

            DB::beginTransaction();

            // Insert into disbursements
            $disbursement = GoldLoanDisbursement::create([
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
            DB::table('loan_applications')
                ->where('id', $request->loan_application_id)
                ->update(['status' => 2]);

            DB::commit();

            Log::info('Loan Disbursement Created Successfully', [
                'disbursement_id' => $disbursement->id,
            ]);

            return redirect()
                ->route('gold-loan.disbursements.index')
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
        $disbursement = LoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
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
        $totalDeductions = $processingTotal + $stampTotal + $insuranceTotal + $advanceInterest;

        // ===== Final amount to disburse =====
        $loanAmount = $disbursement->approved_loan_amount ?? 0;
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
            "gold-loan.disbursements.disburse-loan",
            compact(
                'disbursement',
                'banks',
                'processingFee', 'processingGst', 'processingTotal',
                'stampDutyFee', 'stampGst', 'stampTotal',
                'insuranceFee', 'insuranceGst', 'insuranceTotal',
                'gstPercent',
                'sgst', 'cgst', 'igst',
                'maxLoanAmount', 'annualInterestRate', 'advanceInterest',
                'finalAmountToDisburse',
                'loanAmount',
                'totalDeductions',
                'totalInterest',      
                'totalRecover',       
                'emi',
                'savingAccounts'                 
            )
        );
    }



   
}
