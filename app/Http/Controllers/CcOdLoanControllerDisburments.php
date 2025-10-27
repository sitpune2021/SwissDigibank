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
        // $disbursedIds = BusinessLoanDisbursment::pluck('loan_application_id');

        $disbursements = CcOdLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            // ->whereNotIn('id', $disbursedIds)
            ->get();

        Log::info('Loan Query Result', [
            'count' => $disbursements->count(),
            'ids' => $disbursements->pluck('id')
        ]);

        return view('cc_od.disbursements.index', compact('disbursements'));
    }


    public function cancelLoan($id)
    {
        $loan = CcOdLoanApplication::find($id);

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
            $disbursalDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');

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
                ->route('cc_od.disbursements.index')
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
        $disbursement = CcOdLoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
        $banks = Bank::pluck('name', 'id');

        $processingFee = optional($disbursement->scheme)->processing_fee ?? 0;
        $gstPercent = 18;
        $gstAmount = ($processingFee * $gstPercent) / 100;

        // sgst, cgst, igst ko fix 0
        $sgst = 0;
        $cgst = 0;
        $igst = 0;

        $total = $processingFee + $gstAmount;

        // Interest calculation from scheme
        $maxLoanAmount = optional($disbursement->scheme)->max_loan_amount ?? 0;
        $annualInterestRate = optional($disbursement->scheme)->annual_interest_rate ?? 0;

        // Example: Advance Interest = (maxLoanAmount * annualInterestRate / 100)
        $advanceInterest = ($maxLoanAmount * $annualInterestRate) / 100;

        return view(
            "cc_od.disbursements.disburse-loan",
            compact(
                'disbursement',
                'banks',
                'processingFee',
                'gstPercent',
                'gstAmount',
                'sgst',
                'cgst',
                'igst',
                'total',
                'maxLoanAmount',
                'annualInterestRate',
                'advanceInterest'
            )
        );
    }


}
