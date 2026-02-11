<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedLoanApplication;
use App\Models\FixeLoanDisburments;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class FixedLoanDisburments extends Controller
{

    public function index()
    {
        // $disbursedIds = BusinessLoanDisbursment::pluck('loan_application_id');

        $disbursements = FixedLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('fixed_loan.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = FixedLoanApplication::find($id);

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        // Update status to 0 (cancelled )
        $loan->status = 3;
        $loan->save();

        return redirect()->back()->with('success', 'Loan has been cancelled successfully.');
    }

    public function show($id)
    {
        $disbursement = FixedLoanApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
        $banks = Bank::pluck('name', 'id');

        $processingFee = optional($disbursement->scheme)->processing_fee ?? 0;
        $gstPercent = 18;
        $gstAmount = ($processingFee * $gstPercent) / 100;

        $sgst = 0;
        $cgst = 0;
        $igst = 0;

        $totalProcessingFee = $processingFee + $gstAmount;

        $loanAmount = $disbursement->loan_amount ?? 0;

        // Final Amount
        $finalAmount = $loanAmount - $totalProcessingFee;

        return view(
            "fixed_loan.disbursements.disburse-loan",
            compact(
                'disbursement',
                'banks',
                'processingFee',
                'gstPercent',
                'gstAmount',
                'sgst',
                'cgst',
                'igst',
                'totalProcessingFee',
                'finalAmount'
            )
        );
    }



  

public function store(Request $request)
{
    Log::info('--- Fixed Loan Disbursement Store Started ---', [
        'user_id' => auth()->id(),
        'input'   => $request->all(),
    ]);

    

    // ===============================
    // Validation (ESSENTIAL ONLY)
    // ===============================
    $request->validate([
        'loan_application_id' => 'required|exists:fixed_loan_applications,id',
        'disbursal_date'      => 'required|date_format:d-m-Y',
        'emi_date'            => 'nullable|date_format:d-m-Y',
        'loan_amount'         => 'required|numeric|min:1',
        'final_amount'        => 'required|numeric|min:1',
    ]);

    DB::beginTransaction();

    try {

        // ===============================
        // Date Conversion
        // ===============================
        $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
        $emiDate       = $request->emi_date
            ? Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d')
            : null;

        // ===============================
        // Data Mapping
        // ===============================
        $data = [
            /* Core Loan Info */
            'loan_application_id' => $request->loan_application_id,
            'disbursal_date'      => $disbursalDate,
            'emi_date'            => $emiDate,
            'loan_amount'         => $request->loan_amount,

            /* Processing Fee */
            'processing_fee'                    => $request->processing_fee ?? 0,
            'processing_fee_gst_percent'         => $request->processing_fee_gst_percent,
            'processing_fee_sgst'                => $request->processing_fee_sgst,
            'processing_fee_cgst'                => $request->processing_fee_cgst,
            'processing_fee_igst'                => $request->processing_fee_igst,
            'processing_fee_total'               => $request->processing_fee_total ,
            'processingfee_payment_mode'         => $request->processingfee_payment_mode,
            'processing_fee_bank_id'             => $request->processing_fee_bank_id,
            'processing_fee_cheque_no'           => $request->processing_fee_cheque_no,
            'processing_fee_cheque_date'         => $request->processing_fee_cheque_date,
            'processing_fee_transfer_date'       => $request->processing_fee_transfer_date,
            'processing_fee_utr_no'              => $request->processing_fee_utr_no,
            'processing_fee_transfer_mode'       => $request->processing_fee_transfer_mode,

            /* Stamp Duty */
            'stamp_duty_fee'                     => $request->stamp_duty_fee,
            'stamp_gst_percent'                  => $request->stamp_gst_percent,
            'stamp_duty_fee_sgst'                => $request->stamp_duty_fee_sgst,
            'stamp_duty_fee_cgst'                => $request->stamp_duty_fee_cgst,
            'stamp_duty_fee_igst'                => $request->stamp_duty_fee_igst,
            'stamp_duty_total'                   => $request->stamp_duty_total,
            'stamp_duty_fee_payment_mode'        => $request->stamp_duty_fee_payment_mode,
            'stamp_duty_fee_bank_id'             => $request->stamp_duty_fee_bank_id,
            'stamp_duty_fee_cheque_no'           => $request->stamp_duty_fee_cheque_no,
            'stamp_duty_fee_cheque_date'         => $request->stamp_duty_fee_cheque_date,
            'stamp_duty_fee_transfer_date'       => $request->stamp_duty_fee_transfer_date,
            'stamp_duty_fee_utr_no'              => $request->stamp_duty_fee_utr_no,
            'stamp_duty_fee_transfer_mode'       => $request->stamp_duty_fee_transfer_mode,

            /* Insurance */
            'insurance_fee'                      => $request->insurance_fee,
            'insurance_gst_percent'              => $request->insurance_gst_percent,
            'insurance_fee_sgst'                 => $request->insurance_fee_sgst,
            'insurance_fee_cgst'                 => $request->insurance_fee_cgst,
            'insurance_fee_igst'                 => $request->insurance_fee_igst,
            'insurance_total'                    => $request->insurance_total,
            'insurance_fee_payment_mode'         => $request->insurance_fee_payment_mode,
            'insurance_fee_bank_id'             => $request->insurance_fee_bank_id,
            'insurance_fee_cheque_no'           => $request->insurance_fee_cheque_no,
            'insurance_fee_cheque_date'         => $request->insurance_fee_cheque_date,
            'insurance_fee_transfer_date'       => $request->insurance_fee_transfer_date,
            'insurance_fee_utr_no'              => $request->insurance_fee_utr_no,
            'insurance_fee_transfer_mode'       => $request->insurance_fee_transfer_mode,


            /* Fitness */
            'fitness_fee'                        => $request->fitness_fee,
            'fitness_fee_gst_percent'            => $request->fitness_fee_gst_percent,
            'fitness_fee_sgst'                   => $request->fitness_fee_sgst,
            'fitness_fee_cgst'                   => $request->fitness_fee_cgst,
            'fitness_fee_igst'                   => $request->fitness_fee_igst,
            'fitness_fee_total'                  => $request->fitness_fee_total,
            'fitness_fee_payment_mode'           => $request->fitness_fee_payment_mode,
            'fitness_fee_bank_id'             => $request->fitness_fee_bank_id,
            'fitness_fee_cheque_no'           => $request->fitness_fee_cheque_no,
            'fitness_fee_cheque_date'         => $request->fitness_fee_cheque_date,
            'fitness_fee_transfer_date'       => $request->fitness_fee_transfer_date,
            'fitness_fee_utr_no'              => $request->fitness_fee_utr_no,
            'fitness_fee_transfer_mode'       => $request->fitness_fee_transfer_mode,


            /* Final Amount */
            'final_amount'                       => $request->final_amount,

            /* Disbursement Mode 1 */
            'D_mode_1'       => $request->D_mode_1,
            'payment_mode'  => $request->payment_mode,
            'bank_id'       => $request->bank_id,
            'cheque_no'     => $request->cheque_no,
            'cheque_date'   => $request->cheque_date,
            'transfer_date' => $request->transfer_date,
            'utr_no'        => $request->utr_no,
            'transfer_mode' => $request->transfer_mode,
            'saving'        => $request->saving,

            /* Disbursement Mode 2 */
            'D_mode_2'       => $request->D_mode_2,
            'payment_mode2' => $request->payment_mode2,
            'bank_id2'      => $request->bank_id2,
            'cheque_no2'    => $request->cheque_no2,
            'cheque_date2'  => $request->cheque_date2,
            'transfer_date2'=> $request->transfer_date2,
            'utr_no2'       => $request->utr_no2,
            'transfer_mode2'=> $request->transfer_mode2,
            'saving2'       => $request->saving2,
        ];

        $disbursement = FixeLoanDisburments::create($data);

        // ===============================
        // Update Loan Application Status
        // ===============================
        DB::table('fixed_loan_applications')
            ->where('id', $request->loan_application_id)
            ->update(['status' => 2]);

        DB::commit();

        Log::info('Fixed Loan Disbursement Created', [
            'disbursement_id' => $disbursement->id,
        ]);

         return redirect()
                ->route('fixed_loan.account.index')
                ->with('success', 'Loan Disbursement Created Successfully!');
        
        // return back()->with('success', 'Fixed Loan Disbursement saved successfully');

    } catch (\Throwable $e) {

        DB::rollBack();

        Log::error('FixeLoanDisburments Store Error', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ]);

        return back()
            ->withInput()
            ->with('error', 'Something went wrong while saving the disbursement');
    }
}

    // public function store(Request $request)
    // {
    //     try {
    //         Log::info('--- Fixed Loan Disbursement Store Started ---', [
    //             'user_id' => Auth::id(),
    //             'input'   => $request->all(),
    //         ]);

    //         // Validate input
    //         $validated = $request->validate([
    //             'loan_application_id' => 'required|exists:fixed_loan_applications,id',
    //             'disbursal_date' => 'required|date_format:d-m-Y',
    //             'loan_amount' => 'required|numeric|min:1',
    //             'final_amount' => 'required|numeric|min:1',
    //         ]);

    //         DB::beginTransaction();

    //         // Convert date format
    //         $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
    //         $emiDate = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

    //         // Create disbursement
    //         $disbursement = FixeLoanDisburments::create([
    //             'loan_application_id' => $request->loan_application_id,
    //             'disbursal_date' => $disbursalDate,
    //             'emi_date' => $emiDate,
    //             'loan_amount' => $request->loan_amount,
    //             'processing_fee' => $request->processing_fee,
    //             'gst_percent' => $request->gst_percent,
    //             'sgst' => $request->sgst,
    //             'cgst' => $request->cgst,
    //             'igst' => $request->igst,
    //             'processing_fee_total' => $request->processing_fee_total,
    //             'stamp_duty_fee' => $request->stamp_duty_fee,
    //             'insurance_fee' => $request->insurance_fee,
    //             'advance_interest' => $request->advance_interest,
    //             'final_amount' => $request->final_amount,
                
    //             'disburse_mode1' => $request->D_mode_1,
    //             'payment_mode1' => $request->payment_mode,
    //             'bank_id1' => $request->bank_id,
    //             'cheque_no1' => $request->cheque_no,
    //             'cheque_date1' => $request->cheque_date,
    //             'transfer_date1' => $request->transfer_date,
    //             'utr_no1' => $request->utr_no,
    //             'transfer_mode1' => $request->transfer_mode,
    //             'saving_acc1' => $request->saving,

    //             'disburse_mode2' => $request->D_mode_2,
    //             'payment_mode2' => $request->payment_mode2,
    //             'bank_id2' => $request->bank_id2,
    //             'cheque_no2' => $request->cheque_no2,
    //             'cheque_date2' => $request->cheque_date2,
    //             'transfer_date2' => $request->transfer_date2,
    //             'utr_no2' => $request->utr_no2,
    //             'transfer_mode2' => $request->transfer_mode2,
    //             'saving_acc2' => $request->saving2,
    //             'status' => 1,
    //         ]);


    //         // Update loan application status → 2
    //         DB::table('fixed_loan_applications')
    //             ->where('id', $request->loan_application_id)
    //             ->update(['status' => 2]);

    //         DB::commit();

    //         Log::info('Fixed Loan Disbursement Created Successfully', [
    //             'disbursement_id' => $disbursement->id,
    //         ]);

    //         return redirect()
    //             ->route('fixed_loan.account.index')
    //             ->with('success', 'Loan Disbursement Created Successfully!');
    //     }

    //     catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('Fixed Loan Disbursement Store Error', [
    //             'message' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //         ]);

    //         return back()
    //             ->withInput()
    //             ->with('error', 'Something went wrong while saving the disbursement.');
    //     }
    // }



//     public function store(Request $request)
// {
//     try {
//         Log::info('--- Fixed Loan Disbursement Store Started ---', [
//             'user_id' => Auth::id(),
//             'input'   => $request->all(),
//         ]);

//         // =========================
//         // Validation
//         // =========================
//         $validated = $request->validate([
//             'loan_application_id' => 'required|exists:fixed_loan_applications,id',
//             'disbursal_date'      => 'required|date_format:d-m-Y',
//             'emi_date'            => 'required|date_format:d-m-Y',
//             'loan_amount'         => 'required|numeric|min:1',
//             // 'final_amount'        => 'required|numeric|min:1',
//         ]);

//         DB::beginTransaction();

//         // =========================
//         // Date conversion
//         // =========================
//         $disbursalDate = Carbon::createFromFormat('d-m-Y', $request->disbursal_date)->format('Y-m-d');
//         $emiDate       = Carbon::createFromFormat('d-m-Y', $request->emi_date)->format('Y-m-d');

//         // =========================
//         // Amount defaults
//         // =========================
//         $processingFee   = (float) ($request->processing_fee ?? 0);
//         $gstPercent      = (float) ($request->gst_percent ?? 0);
//         $stampDutyFee    = (float) ($request->stamp_duty_fee ?? 0);
//         $insuranceFee    = (float) ($request->insurance_fee ?? 0);
//         $advanceInterest = (float) ($request->advance_interest ?? 0);

//         // =========================
//         // GST calculation
//         // =========================
//         $gstAmount = ($processingFee * $gstPercent) / 100;

//         $cgst = 0;
//         $sgst = 0;
//         $igst = 0;

//         /**
//          * If IGST is applicable → full GST in IGST
//          * Else → split equally between CGST & SGST
//          */
//         if ($request->igst_applicable == 1) {
//             $igst = $gstAmount;
//         } else {
//             $cgst = $gstAmount / 2;
//             $sgst = $gstAmount / 2;
//         }

//         $processingFeeTotal = $processingFee + $gstAmount;

//         // =========================
//         // Create Disbursement
//         // =========================
//         $disbursement = FixeLoanDisburments::create([

//             // Loan details
//             'loan_application_id' => $request->loan_application_id,
//             'disbursal_date'      => $disbursalDate,
//             'emi_date'            => $emiDate,
//             'loan_amount'         => $request->loan_amount,

//             // Charges
//             'processing_fee'       => $processingFee,
//             'processing_fee_gst_percent'          => $gstPercent,
//             'processing_fee_sgst'                 => $sgst,
//             'processing_fee_cgst'                 => $cgst,
//             'processing_fee_igst'                 => $igst,
//             'processing_fee_total' => $processingFeeTotal,
//             'stamp_duty_fee'       => $stampDutyFee,
//             'insurance_fee'        => $insuranceFee,
//             'advance_interest'     => $advanceInterest,

//             'final_amount' => $request->final_amount,

//             // =========================
//             // Disbursement – Mode 1
//             // =========================
//             'disburse_mode1'  => $request->D_mode_1,
//             'payment_mode'  => $request->payment_mode,
//             'bank_id'       => $request->bank_id,
//             'cheque_no'     => $request->cheque_no,
//             'cheque_date'   => $request->cheque_date,
//             'transfer_date' => $request->transfer_date,
//             'utr_no'        => $request->utr_no,
//             'transfer_mode' => $request->transfer_mode,
//             'saving_acc'    => $request->saving,

//             // =========================
//             // Disbursement – Mode 2
//             // =========================
//             'disburse_mode2'  => $request->D_mode_2,
//             'payment_mode2'  => $request->payment_mode2,
//             'bank_id2'       => $request->bank_id2,
//             'cheque_no2'     => $request->cheque_no2,
//             'cheque_date2'   => $request->cheque_date2,
//             'transfer_date2' => $request->transfer_date2,
//             'utr_no2'        => $request->utr_no2,
//             'transfer_mode2' => $request->transfer_mode2,
//             'saving_acc2'    => $request->saving2,

//             'status' => 1,
//         ]);

//         // =========================
//         // Update loan application status
//         // =========================
//         DB::table('fixed_loan_applications')
//             ->where('id', $request->loan_application_id)
//             ->update(['status' => 2]);

//         DB::commit();

//         Log::info('Fixed Loan Disbursement Created Successfully', [
//             'disbursement_id' => $disbursement->id,
//         ]);

//         return redirect()
//             ->route('fixed_loan.account.index')
//             ->with('success', 'Loan Disbursement Created Successfully!');
//     }
//     catch (\Exception $e) {

//         DB::rollBack();

//         Log::error('Fixed Loan Disbursement Store Error', [
//             'message' => $e->getMessage(),
//             'file'    => $e->getFile(),
//             'line'    => $e->getLine(),
//         ]);

//         return back()
//             ->withInput()
//             ->with('error', 'Something went wrong while saving the disbursement.');
//     }
// }



}
