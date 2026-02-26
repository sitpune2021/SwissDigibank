<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanAgainstApplication;
use App\Models\LoanAgainstDisursement;
use App\Models\Bank;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoanAgainstDisbursementController extends Controller
{

    public function index()
    {
        $disbursements = LoanAgainstApplication::with(['member', 'branch', 'scheme'])
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('loanagainst.disbursements.index', compact('disbursements'));
    }

    public function cancelLoan($id)
    {
        $loan = LoanAgainstApplication::find($id);

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
        Log::info('========== LOAN DISBURSEMENT STORE START ==========');

        try {

            /*
        =========================================
        STEP 1 : RAW REQUEST DATA
        =========================================
        */
            Log::info('Incoming Request Data', [
                'user_id' => Auth::id(),
                'payload' => $request->all()
            ]);

            /*
        =========================================
        STEP 2 : VALIDATION
        =========================================
        */
            $validated = $request->validate([
                'loan_application_id' => 'required|exists:loan_against_applications,id',
                'disbursal_date' => 'required|date_format:d-m-Y',
                'emi_date' => 'required|date_format:d-m-Y',
                'loan_amount' => 'required|numeric|min:0.01',
                'final_amount' => 'required|numeric|min:0.01',
            ]);

            Log::info('Validation Passed', $validated);

            /*
        =========================================
        STEP 3 : CHECK DUPLICATE DISBURSEMENT
        =========================================
        */
            $existing = LoanAgainstDisursement::where(
                'loan_application_id',
                $request->loan_application_id
            )->first();

            if ($existing) {

                Log::warning('Disbursement Already Exists', [
                    'loan_application_id' => $request->loan_application_id,
                    'existing_id' => $existing->id
                ]);

                return back()
                    ->withInput()
                    ->withErrors(['loan_application_id' => 'This loan is already disbursed.']);
            }

            /*
        =========================================
        STEP 4 : DATE CONVERSION
        =========================================
        */
            $disbursalDate = Carbon::createFromFormat(
                'd-m-Y',
                $request->disbursal_date
            )->format('Y-m-d');

            $emiDate = Carbon::createFromFormat(
                'd-m-Y',
                $request->emi_date
            )->format('Y-m-d');

            Log::info('Date Converted Successfully', [
                'disbursal_date' => $disbursalDate,
                'emi_date' => $emiDate
            ]);

            DB::beginTransaction();
            Log::info('Database Transaction Started');

            /*
        =========================================
        STEP 5 : CREATE DISBURSEMENT RECORD
        =========================================
        */
            $insertData = [
                'loan_application_id' => $request->loan_application_id,
                'disbursal_date' => $disbursalDate,
                'emi_date' => $emiDate,
                'loan_amount' => $request->loan_amount,
                'final_amount' => $request->final_amount,

                'processing_fee' => $request->processing_fee ?? 0,
                'gst_percent' => $request->gst_percent ?? 0,
                'sgst' => $request->sgst ?? 0,
                'cgst' => $request->cgst ?? 0,
                'igst' => $request->igst ?? 0,
                'processing_fee_total' => $request->processing_fee_total ?? 0,

                'stamp_duty_fee' => $request->stamp_duty_fee ?? 0,
                'stamp_duty_total' => $request->stamp_duty_total ?? 0,

                'insurance_fee' => $request->insurance_fee ?? 0,
                'insurance_total' => $request->insurance_total ?? 0,

                'advance_interest' => $request->advance_interest ?? 0,

                'disburse_mode1' => $request->D_mode_1 ?? 0,
                'payment_mode1'  => $request->payment_mode ?? 'cash',

                'disburse_mode2' => $request->D_mode_2 ?? 0,
                'payment_mode2'  => $request->payment_mode2 ?? 'cash',
            ];

            Log::info('Disbursement Insert Data Prepared', $insertData);

            $disbursement = LoanAgainstDisursement::create($insertData);

            Log::info('Disbursement Created Successfully', [
                'disbursement_id' => $disbursement->id
            ]);

            /*
        =========================================
        STEP 6 : UPDATE LOAN STATUS
        =========================================
        */
            DB::table('loan_against_applications')
                ->where('id', $request->loan_application_id)
                ->update(['status' => 2]);

            Log::info('Loan Application Status Updated', [
                'loan_application_id' => $request->loan_application_id,
                'new_status' => 2
            ]);
            // STEP 6.5 : PROCESSING FEE INSERT
            if ($request->has('collect_fee')) {

                $feeData = [
                    'loanagainsst_disbursement_id' => $disbursement->id,
                    'fee_type' => 'processing_fee',
                    'payment_mode' => $request->processing_fee_mode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // If Cheque
                if ($request->processing_fee_mode === 'cheque') {
                    $feeData['bank_id'] = $request->p_bank_id;
                    $feeData['cheque_no'] = $request->p_cheque_no;
                    $feeData['cheque_date'] = Carbon::createFromFormat(
                        'd-m-Y',
                        $request->p_cheque_date
                    )->format('Y-m-d');
                }

                // If Online
                if ($request->processing_fee_mode === 'online') {
                    $feeData['transfer_date'] = Carbon::createFromFormat(
                        'd-m-Y',
                        $request->p_transfer_date
                    )->format('Y-m-d');
                    $feeData['utr_no'] = $request->p_utr_no;
                    $feeData['transfer_mode'] = $request->p_transfer_mode;
                    $feeData['credited_account'] = $request->processing_credited_account;
                }

                DB::table('loan_againsst_disbursement_fees')->insert($feeData);
            }
            // STEP 7 : STAMP DUTY INSERT

            if ($request->filled('stamp_payment_mode')) {

                DB::table('loan_againsst_disbursement_fees')->insert([
                    'loanagainsst_disbursement_id' => $disbursement->id,
                    'fee_type' => 'stamp_duty',
                    'payment_mode' => $request->stamp_payment_mode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info('Stamp Duty Fee Inserted', [
                    'mode' => $request->stamp_payment_mode
                ]);
            }

            /*
        =========================================
        STEP 8 : INSURANCE INSERT
        =========================================
        */
            if ($request->filled('insurance_payment_mode')) {

                DB::table('loan_againsst_disbursement_fees')->insert([
                    'loanagainsst_disbursement_id' => $disbursement->id,
                    'fee_type' => 'issuer_fee',
                    'payment_mode' => $request->insurance_payment_mode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info('Insurance Fee Inserted', [
                    'mode' => $request->insurance_payment_mode
                ]);
            }

            DB::commit();
            Log::info('Database Transaction Committed Successfully');

            Log::info('========== LOAN DISBURSEMENT SUCCESS ==========');

            return redirect()
                ->route('loanagainst.account.index')
                ->with('success', 'Loan Disbursement Created Successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('!!!!!!!! LOAN DISBURSEMENT FAILED !!!!!!!!', [
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'request_data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving.');
        }
    }

    public function show($id)
    {
        // Load loan + scheme + member + branch
        $disbursement = LoanAgainstApplication::with(['member', 'branch', 'scheme'])->findOrFail($id);
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
        // ===== Total deductions (based on scheme setting) =====
        if ($scheme->gold_loan_setting === 'flat_advanced_interest') {
            $totalDeductions = $processingTotal + $stampTotal + $insuranceTotal + $advanceInterest;
        } else {
            $totalDeductions = $processingTotal + $stampTotal + $insuranceTotal;
        }


        // ===== Final amount to disburse =====
        $loanAmount = $disbursement->approved_loan_amount ?? 0;
        //$finalAmountToDisburse = $loanAmount - $totalDeductions;
        // ===== Final amount calculation =====
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
            "loanagainst.disbursements.disburse-loan",
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
                'savingAccounts',
                'isAdvanceInterest'
            )
        );
    }
}
