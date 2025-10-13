<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MortgageLoanApplication;
use App\Models\MortgageLoanDisbursement;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MortgageDisbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
   
    public function index()
    {
        // Pehle se disbursed ho chuke applications ke IDs nikalo
        $disbursedIds = MortgageLoanDisbursement::pluck('loan_application_id');

        //  approved (status = 1) applications fetch 
        $disbursements = MortgageLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 1) //  Only approved
            ->whereNotIn('id', $disbursedIds)
            ->get();

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
        //  Step 1: Validation
        $validated = $request->validate([
            'loan_application_id' => 'required|integer',
            'disbursal_date' => 'required',
            'emi_date' => 'required',
            'final_amount' => 'required|numeric',
            'processing_fee' => 'nullable|numeric',
            'gst_percent' => 'nullable|numeric',
        ]);

        //  Step 2: Date format convert (d-m-Y → Y-m-d)
        $disbursalDate = date('Y-m-d', strtotime($request->disbursal_date));
        $emiDate = date('Y-m-d', strtotime($request->emi_date));

        //  Step 3: Create record
        $disbursement = new MortgageLoanDisbursement([
            'loan_application_id' => $request->loan_application_id,
            'disbursal_date'      => $disbursalDate,
            'emi_date'            => $emiDate,
            'loan_amount'         => $request->loan_amount ?? 0,
            'processing_fee'      => $request->processing_fee ?? 0,
            'gst_percent'         => $request->gst_percent ?? 0,
            'sgst'                => $request->sgst ?? 0,
            'cgst'                => $request->cgst ?? 0,
            'igst'                => $request->igst ?? 0,
            'processing_fee_total'=> $request->processing_fee_total ?? 0,
            'stamp_duty_fee'      => $request->stamp_duty_fee ?? 0,
            'insurance_fee'       => $request->insurance_fee ?? 0,
            'advance_interest'    => $request->advance_interest ?? 0,
            'final_amount'        => $request->final_amount ?? 0,

            // First disbursement mode
            'disburse_mode1'      => $request->D_mode_1 ?? 0,
            'payment_mode1'       => $request->payment_mode ?? null,
            'bank_id1'            => $request->bank_id ?? null,
            'cheque_no1'          => $request->cheque_no ?? null,
            'cheque_date1'        => $request->cheque_date ? date('Y-m-d', strtotime($request->cheque_date)) : null,
            'transfer_date1'      => $request->transfer_date ? date('Y-m-d', strtotime($request->transfer_date)) : null,
            'utr_no1'             => $request->utr_no ?? null,
            'transfer_mode1'      => $request->transfer_mode1 ?? null,
            'saving_acc1'         => $request->saving ?? null,

            // Second disbursement mode
            'disburse_mode2'      => $request->D_mode_2 ?? 0,
            'payment_mode2'       => $request->payment_mode2 ?? null,
            'bank_id2'            => $request->bank_id2 ?? null,
            'cheque_no2'          => $request->cheque_no2 ?? null,
            'cheque_date2'        => $request->cheque_date2 ? date('Y-m-d', strtotime($request->cheque_date2)) : null,
            'transfer_date2'      => $request->transfer_date2 ? date('Y-m-d', strtotime($request->transfer_date2)) : null,
            'utr_no2'             => $request->utr_no2 ?? null,
            'transfer_mode2'      => $request->transfer_mode2 ?? null,
            'saving_acc2'         => $request->saving2 ?? null,
        ]);

        $disbursement->save();

        // Step 4: Update mortgage_loan_applications status = 2
        MortgageLoanApplication::where('id', $request->loan_application_id)
            ->update(['status' => 2]);

        // Step 4: Redirect with success
        return redirect()
            ->route('mortgage.disbursements.index')
            ->with('success', 'Loan disbursement successfully saved!');
    }


    public function show($id)
    {
        $disbursement = MortgageLoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
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
            "mortgage.disbursements.disburse-loan",
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
