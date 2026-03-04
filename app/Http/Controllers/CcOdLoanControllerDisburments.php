<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CcOdLoanApplication;
use App\Models\CcOdLoanDisbursment;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class CcOdLoanControllerDisburments extends Controller
{
    
    public function index()
    {       
        $disbursements = CcOdLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('cc_od.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = CcOdLoanApplication::find($id);

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        $loan->status = 3;
        $loan->save();

        return redirect()->back()->with('success', 'Loan has been cancelled successfully.');
    }

    public function store(Request $request)
    {
        try {
            Log::info('--- CC OD Loan Disbursement Store Started ---', [
                'user_id' => Auth::id(),
                'input'   => $request->all(),
            ]);

            // Validate input
            $validated = $request->validate([
                'loan_application_id' => 'required|exists:cc_od_loan_applications,id',
                'disbursal_date' => 'required|date_format:d-m-Y',
                'loan_amount' => 'required|numeric|min:1',
                'final_amount' => 'required|numeric|min:1',
            ]);

            DB::beginTransaction();

            // Convert date format
            $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');

            // Create disbursement
            $disbursement = CcOdLoanDisbursment::create([
                'loan_application_id' => $request->loan_application_id,
                'disbursal_date' => $disbursalDate,
                'loan_amount' => $request->loan_amount,
                'final_amount' => $request->final_amount,
            ]);

            // Update loan application status → 2
            DB::table('cc_od_loan_applications')
                ->where('id', $request->loan_application_id)
                ->update(['status' => 2]);

            DB::commit();

            Log::info('Loan Disbursement Created Successfully', [
                'disbursement_id' => $disbursement->id,
            ]);

            return redirect()
                ->route('cc_od.account.index')
                ->with('success', 'Loan Disbursement Created Successfully!');
        }

        catch (Exception $e) {
            DB::rollBack();
            Log::error('Loan Disbursement Store Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the disbursement.');
        }
    }

    public function show($id)
    {
        // Load loan + scheme + member + branch
        $disbursement = CcOdLoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
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
            "cc_od.disbursements.disburse-loan",
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
                'emi'
               
            )
        );
    }


}
