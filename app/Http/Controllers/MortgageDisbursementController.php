<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MortgageLoanApplication;
use App\Models\MortgageLoanDisbursement;
use App\Models\Bank;
use Carbon\Carbon;

class MortgageDisbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
   
    public function index()
    {
        // Pehle se disbursed ho chuke applications ke IDs nikalo
        $disbursedIds = MortgageLoanDisbursement::pluck('loan_application_id');

        // Sirf approved (status = 1) aur abhi tak disbursed na hue applications fetch karo
        $disbursements = MortgageLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 1) //  Only approved
            ->whereNotIn('id', $disbursedIds)
            ->get();

        return view('mortgage.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = MortgageLoanApplication::find($id);

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        // Update status to 0 (cancelled / draft)
        $loan->status = 0;
        $loan->save();

        return redirect()->back()->with('success', 'Loan has been cancelled successfully.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  

    public function store(Request $request)
    {
        //dd($request->all());

        // Validate incoming request
        $request->validate([
            'loan_application_id' => 'required|exists:loan_applications,id',
            'disbursal_date' => 'required',
            'emi_date' => 'required',
            'loan_amount' => 'required|numeric',
            'final_amount' => 'required|numeric',
        ]);


        // Convert d-m-Y to Y-m-d before insert
        $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
        $emiDate = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

        // Insert data into DB
        $disbursement = MortgageLoanDisbursement::create([
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

            // 'cheque_date1' => $request->cheque_date ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d') : null,
            // 'transfer_date1' => $request->transfer_date ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d') : null,
            'utr_no1' => $request->utr_no,
            'transfer_mode1' => $request->transfer_mode,
            'saving_acc1' => $request->saving,

            // Disburse mode 2
            'disburse_mode2' => $request->D_mode_2,
            'payment_mode2' => $request->payment_mode2,
            'bank_id2' => $request->bank_id2,
            'cheque_no2' => $request->cheque_no2,
            'cheque_date2' => $request->cheque_date2 ? Carbon::createFromFormat('d-m-Y', $request->cheque_date2)->format('Y-m-d') : null,
            'transfer_date2' => $request->transfer_date2 ? Carbon::createFromFormat('d-m-Y', $request->transfer_date2)->format('Y-m-d') : null,
            'utr_no2' => $request->utr_no2,
            'transfer_mode2' => $request->transfer_mode2,
            'saving_acc2' => $request->saving2,
        ]);

        // Redirect to index page
        return redirect()
            ->route('mortgage.disbursements.index')
            ->with('success', 'Loan Disbursement Created Successfully!');
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
