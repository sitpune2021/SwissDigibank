<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalLoanApplication;
use App\Models\PersonalDisburment;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class PersonalDisbursementController extends Controller
{


    public function index()
    {   
        $disbursements = PersonalLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            // ->whereNotIn('id', $disbursedIds)
            ->get();

        Log::info('Loan Query Result', [
            'count' => $disbursements->count(),
            'ids' => $disbursements->pluck('id')
        ]);

        return view('personal.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = PersonalLoanApplication::find($id);

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
            Log::info('--- personal Loan Disbursement Store Started ---', [
                'user_id' => Auth::id(),
                'input'   => $request->all(),
            ]);

            // Validate input
            $validated = $request->validate([
                'loan_application_id' => 'required|exists:personal_loan_applications,id',
                'disbursal_date' => 'required|date_format:d-m-Y',
                'loan_amount' => 'required|numeric|min:1',
                'final_amount' => 'required|numeric|min:1',
            ]);

            DB::beginTransaction();

            // Convert date format
            $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
            $emiDate = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

            // Create disbursement
            $disbursement = PersonalDisburment::create([
                'loan_application_id' => $request->loan_application_id,
                'disbursal_date' => $disbursalDate,
                'emi_date' => $emiDate,
                'loan_amount' => $request->loan_amount,
                'processing_fee' => $request->processing_fee,
                'gst_percent' => $request->gst_percent,
                'sgst' => $request->sgst,
                'cgst' => $request->cgst,
                'igst' => $request->igst,
                'processing_fee_total' => $request->processing_fee_total,
                'stamp_duty_fee'      => $request->stamp_duty_fee ?? 0,
                'insurance_fee'       => $request->insurance_fee ?? 0,
                'advance_interest'    => $request->advance_interest ?? 0,
                'final_amount'        => $request->final_amount ?? 0,
                
                'disburse_mode1' => $request->D_mode_1,
                'payment_mode1' => $request->payment_mode,
                'bank_id1' => $request->bank_id,
                'cheque_no1' => $request->cheque_no,
                'cheque_date1' => $request->cheque_date,
                'transfer_date1' => $request->transfer_date,
                'utr_no1' => $request->utr_no,
                'transfer_mode1' => $request->transfer_mode,
                'saving_acc1' => $request->saving,

                'disburse_mode2' => $request->D_mode_2,
                'payment_mode2' => $request->payment_mode2,
                'bank_id2' => $request->bank_id2,
                'cheque_no2' => $request->cheque_no2,
                'cheque_date2' => $request->cheque_date2,
                'transfer_date2' => $request->transfer_date2,
                'utr_no2' => $request->utr_no2,
                'transfer_mode2' => $request->transfer_mode2,
                'saving_acc2' => $request->saving2,
                'status' => 1,
            ]);


            // Update loan application status → 2
            DB::table('personal_loan_applications')
                ->where('id', $request->loan_application_id)
                ->update(['status' => 2]);

            DB::commit();

            Log::info('personal Loan Disbursement Created Successfully', [
                'disbursement_id' => $disbursement->id,
            ]);

            return redirect()
                ->route('personal.disbursements.index')
                ->with('success', 'Loan Disbursement Created Successfully!');
        }

        catch (Exception $e) {
            DB::rollBack();
            Log::error('personal Loan Disbursement Store Error', [
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
        $disbursement = PersonalLoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
        $banks = Bank::pluck('name', 'id');

        $processingFee = optional($disbursement->scheme)->processing_fee ?? 0;
        $gstPercent = 18;
        $gstAmount = ($processingFee * $gstPercent) / 100;

        $sgst = 0;
        $cgst = 0;
        $igst = 0;

        $total = $processingFee + $gstAmount;

        $loanAmount = $disbursement->loan_amount ?? 0;

        // Final Amount
        $finalAmount = $loanAmount - $total;

        return view(
            "personal.disbursements.disburse-loan",
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
                'finalAmount'
            )
        );
    }


}
