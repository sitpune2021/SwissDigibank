<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\GoldLoanScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\LoanApplication;
use App\Models\LoanOrnament;
use App\Models\Calculator;
use App\Models\LoanCreditScore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class GoldLoanController extends Controller
{
    
    public function index()
    {       
        //$schemes = GoldLoanScheme::all();
        // paginate(10) => 10 records per page
        $schemes = GoldLoanScheme::orderBy('id', 'desc')->paginate(10);
        return view("gold-loan.schemes.index", compact('schemes'));
    }


    public function create()
    {
        return view("gold-loan.schemes.create");
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:50|unique:gold_loan_schemes,scheme_code',
            'min_loan_amount' => 'required|numeric|min:1',
            'max_loan_amount' => 'required|numeric|min:1|max:200000',
            'tenure' => 'required|integer|min:1',
            'annual_interest_rate' => 'required|numeric|min:0',

            // new optional fields
            'processing_fee' => 'nullable|numeric|min:0',
            'stamp_duty_charge' => 'nullable|numeric|min:0',
            'insurance_fee' => 'nullable|numeric|min:0',
            'gold_loan_setting' => 'nullable|string',
            'max_loan_limit' => 'nullable|numeric|min:0',
            'overdue_interest_rate' => 'nullable|numeric|min:0',
            'penalty_charge' => 'nullable|numeric|min:0',
            'fore_closer_charge' => 'nullable|numeric|min:0',
            'credit_period' => 'nullable|numeric|min:0',
            'sms_charge' => 'nullable|numeric|min:0',
            'fuel_charge' => 'nullable|numeric|min:0',
            'stationary_charge' => 'nullable|numeric|min:0',
            'maintenance_charge' => 'nullable|numeric|min:0',
            'collection' => 'nullable|numeric|min:0',
            'is_active' => 'required|in:0,1',
        ], [
            'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
        ]);

        GoldLoanScheme::create($validated);

        return redirect()
            ->route('gold-loan.schemes.index')
            ->with('success', 'Scheme created successfully!');
    }

    public function show($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view('gold-loan.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view('gold-loan.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('gold-loan.schemes.index')
            ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view("gold-loan.schemes.view", compact('scheme'));
    }

    public function calculator()
    {
        $scheme = GoldLoanScheme::all();
        return view("gold-loan.calculator.index", compact('scheme'));
    }


    public function calculateResult(Request $request)
    {
        $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';

        if ($isManual) {
            //  Manual Entry Mode
            $request->validate([
                'loan_amount' => 'required|numeric|min:1',
                'max_tenure' => 'required|integer|min:1',
                'manual_interest_rate' => 'required|numeric|min:0',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly',
            ]);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->max_tenure;
            $payout = $request->payout;
            $interestType = 'flat';
            $annualRate = (float) $request->manual_interest_rate;

            $processingFee = (float) ($request->manual_processing_fee ?? 0);
            $stampAmount = round($loan * ((float) ($request->manual_stamp ?? 0)) / 100, 2);
            $insuranceAmount = round($loan * ((float) ($request->manual_insurance ?? 0)) / 100, 2);
            $scheme = null;
        } else {
            //  Scheme Mode
            $request->validate([
                'scheme_id' => 'required|exists:gold_loan_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|integer|min:1',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly',
            ]);

            $scheme = GoldLoanScheme::findOrFail($request->scheme_id);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            $payout = $request->payout;
            $interestType = 'flat';
            $annualRate = (float) ($request->annual_interest_rate ?? $scheme->annual_interest_rate ?? 0);

            $processingFee = (float) ($scheme->processing_fee ?? 0);
            $stampAmount = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
        }

        //  Determine months per EMI payout
        switch ($payout) {
            case 'monthly':
                $monthsPerInstallment = 1;
                break;
            case 'quarterly':
                $monthsPerInstallment = 3;
                break;
            case 'half-yearly':
                $monthsPerInstallment = 6;
                break;
            case 'yearly':
                $monthsPerInstallment = 12;
                break;
            default:
                $monthsPerInstallment = 1;
        }

        //  Total Installments & Interest
        $installments = (int) ceil($tenureMonths / $monthsPerInstallment);
        $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
        $emi = round(($loan + $totalInterest) / $installments, 2);

        // EMI Schedule Generation
        $schedule = [];
        $outstanding = $loan;
        $startDate = now();

        for ($i = 1; $i <= $installments; $i++) {
            $principal = round($loan / $installments, 2);
            $interest = round($totalInterest / $installments, 2);
            $emiTotal = round($principal + $interest, 2);
            $outstanding -= $principal;

            $emiDate = $startDate->copy()->addMonths($monthsPerInstallment * $i);
            $dueDate = $emiDate->copy()->addDays(10); // optional grace period

            $schedule[] = [
                'no' => $i,
                'emi_date' => $emiDate->format('d/m/Y'),
                'due_date' => $dueDate->format('d/m/Y'),
                'principal' => $principal,
                'interest' => $interest,
                'charges' => 0,
                'emi' => $emiTotal,
                'balance' => max($outstanding, 0),
            ];
        }

        //  Grand Total (Loan + Interest + Charges)
        $grandTotalPayable = round($loan + $totalInterest + $processingFee + $stampAmount + $insuranceAmount, 2);

        //  Return to view
        return view('gold-loan.calculator.result', [
            'scheme' => $scheme,
            'is_manual' => $isManual,
            'loan' => $loan,
            'tenure_months' => $tenureMonths,
            'payout' => $payout,
            'installments' => $installments,
            'interest_type' => ucfirst($interestType),
            'annual_rate' => $annualRate,
            'disburse_date' => now(),
            'processing_fee' => $processingFee,
            'processing_incl_gst' => $processingFee,
            'stamp_amount' => $stampAmount,
            'stamp_incl_gst' => $stampAmount,
            'insurance_amount' => $insuranceAmount,
            'schedule' => $schedule,
            'total_interest' => $totalInterest,
            'total_principal' => $loan,
            'total_emi_paid' => $loan + $totalInterest,
            'grand_total_payable' => $grandTotalPayable,
        ]);
    }


     // GoldLoanController.php
    public function appindex()
    {
        //  loan applications fetch 
        $applications = LoanApplication::with(['creditScores'])->latest()->get();

        return view("gold-loan.applications.index", compact('applications'));
    }


    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name', 'member_info_mobile_no')->get();
        $branch = Branch::all();
        $scheme = GoldLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("gold-loan.applications.create", compact('members', 'branch', 'scheme', 'banks'));
    }
   

    public function storeLoanApplication(Request $request)
    {
        // dd($request->all());
        Log::info('--- Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        try {
            // Loan Application Save
            $loanApplication = LoanApplication::create($request->only([
                'application_date',
                'member_id',
                'co_applicant_1_id',
                'co_applicant_2_id',
                'branch_id',
                'advisor_id',
                'guarantor_1_id',
                'guarantor_2_id',
                'guarantor_3_id',
                'guarantor_4_id',
                'scheme_id',
                'tenure_type',
                'tenure_value',
                'emi_collection',
                'credit_period',
                'loan_amount',
                'insurance_amount',
                'net_loan_amount',
                'purpose_of_loan',
                'processing_fee_value',
                'processing_fee_gst',
                'processing_fee_sgst',
                'processing_fee_cgst',
                'processing_fee_igst',
                'processing_fee_total',
                'fee_mode',
                'bank_id',
                'cheque_no',
                'cheque_date',
                'transfer_date',
                'utr_no',
                'transfer_mode',
                'credited',
                'collect_principal_as_emi',
                'collect_advance_processing_fee',
                'security_value',
                'max_loan_amount',
                'max_loan_limit',
                'maximum_approvable_amount',
                'approved_loan_amount',
            ]));

            Log::info('Loan Application created successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // ==== Credit Score Details Save (Dynamic Rows) ====
            if ($request->has('cibil_type')) {
                foreach ($request->cibil_type as $index => $type) {
                    try {
                        $filePath = null;

                        if ($request->hasFile('report_file') && isset($request->file('report_file')[$index])) {
                            $filePath = $request->file('report_file')[$index]->store('cibil_reports', 'public');
                        }

                        $loanApplication->creditScores()->create([
                            'cibil_type'       => $type,
                            'cibil_score'      => $request->cibil_score[$index] ?? null,
                            'report_date'      => isset($request->report_date[$index])
                                ? Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d')
                                : null,
                            'report_file_path' => $filePath,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error while saving credit score entry', [
                            'index' => $index,
                            'error_message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                    }
                }
            }

            //  Save Ornaments (Dynamic Rows)
            $itemTypes = $request->input('item_type', []);
            $itemNames = $request->input('item_name', []);
            $noOfItems = $request->input('no_of_item', []);
            $valuePerGram = $request->input('value_per_gram', []);
            $grossWeight = $request->input('gross_weight', []);
            $netWeight = $request->input('net_weight', []);
            $tunch = $request->input('tunch', []);
            $fineWeight = $request->input('fine_weight', []);
            $totalValue = $request->input('total_value', []);

            if (!empty($itemTypes)) {
                foreach ($itemTypes as $index => $type) {
                    $loanOrnament = LoanOrnament::create([
                        'application_id'=> $loanApplication->id,
                        'item_type' => $type,
                        'item_name' => $itemNames[$index] ?? null,
                        'no_of_item' => $noOfItems[$index] ?? 0,
                        'value_per_gram' => $valuePerGram[$index] ?? 0,
                        'gross_weight' => $grossWeight[$index] ?? 0,
                        'net_weight' => $netWeight[$index] ?? 0,
                        'tunch' => $tunch[$index] ?? 0,
                        'fine_weight' => $fineWeight[$index] ?? 0,
                        'total_value' => $totalValue[$index] ?? 0,
                        'status'=>1
                    ]);
                }
            }


            Log::info('--- Loan Application Store Completed Successfully ---', [
                'loan_application_id' => $loanApplication->id,
            ]);

            return redirect()->route('gold-loan.applications.index')
                ->with('success', 'Loan Application + Credit Scores + Ornaments saved successfully!');
        } catch (\Exception $e) {
            Log::error('Error while storing Loan Application', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while saving loan application.');
        }
    }

    public function getMemberInfo($id)
    {
        $member = Member::select('id', 'member_info_first_name', 'member_info_mobile_no')
            ->find($id);

        if ($member) {
            return response()->json([
                'status' => true,
                'data' => $member
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Member not found'
            ]);
        }
    }


    public function appview($id)
    {
        $application = LoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme'   // <-- add scheme here
        ])->findOrFail($id);

        return view("gold-loan.applications.view", compact('application'));
    }


    public function appedit($id)
    {
        $application = LoanApplication::with(['member', 'scheme'])->findOrFail($id);

        // ✅ Fetch all related CIBIL records for this loan application
        $creditScores = LoanCreditScore::where('loan_application_id', $id)->get();

        $ornaments = LoanOrnament::where('application_id', $id)->get();

        // Dropdown data
        $members = Member::all();
        $schemes = GoldLoanScheme::all();
        $branch = Branch::all();
        $scheme = GoldLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view('gold-loan.applications.create', compact(
            'application',
            'members',
            'schemes',
            'branch',
            'scheme',
            'banks',
            'creditScores', // ✅ Pass it to view
            'ornaments'
        ));
    }

    public function appupdate(Request $request, $id)
    {
        $request->validate([
            'application_date' => 'required|date',
            'member_id'        => 'required|exists:members,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric',
        ]);

        $application = LoanApplication::findOrFail($id);
        $application->update($request->all());

        /* -----------------------------------------------
        🟡 STEP 1: Purane ornaments delete karo
        ------------------------------------------------*/
        DB::table('loan_ornaments')->where('application_id', $application->id)->delete();

        /* -----------------------------------------------
        🟢 STEP 2: Naye ornaments insert karo
        ------------------------------------------------*/
        if ($request->has('item_type')) {
            foreach ($request->item_type as $index => $type) {
                DB::table('loan_ornaments')->insert([
                    'application_id' => $application->id,
                    'item_type'      => $type ?? null,
                    'item_name'      => $request->item_name[$index] ?? null,
                    'no_of_items'    => $request->no_of_items[$index] ?? null,
                    'value_per_gram' => $request->value_per_gram[$index] ?? null,
                    'gross_weight'   => $request->gross_weight[$index] ?? null,
                    'net_weight'     => $request->net_weight[$index] ?? null,
                    'tunch'          => $request->tunch[$index] ?? null,
                    'fine_weight'    => $request->fine_weight[$index] ?? null,
                    'total_value'    => $request->total_value[$index] ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

            /* -----------------------------------------------
            🟢 STEP 3: Credit Score Details Update karo
            ------------------------------------------------*/
            DB::table('loan_credit_scores')->where('loan_application_id', $application->id)->delete();

            if ($request->has('cibil_type')) {
                foreach ($request->cibil_type as $index => $type) {
            // Convert report_date to proper MySQL format
            $report_date = null;
            if (!empty($request->report_date[$index])) {
                $report_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->report_date[$index])));
            }

            DB::table('loan_credit_scores')->insert([
                'loan_application_id' => $application->id,
                'cibil_type'          => $type ?? null,
                'cibil_score'         => $request->cibil_score[$index] ?? null,
                'report_date'         => $report_date,
                'report_file_path'    => isset($request->report_file[$index])
                                        ? $request->report_file[$index]->store('uploads/cibil_reports', 'public')
                                        : null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        }

        return redirect()
            ->route('gold-loan.applications.view', $application->id)
            ->with('success', 'Application updated successfully with ornaments & credit score');
    }

    public function showEmiChart()
    {
        // $banks = Bank::all(); // or your logic here
        return view("gold-loan.applications.view-buttons.show-emi-chart");
    }
    public function showdisbursesetting()
    {

        return view("gold-loan.applications.view-buttons.disburse-setting");
    }

    public function col_process_fee()
    {

        return view("gold-loan.applications.view-buttons.col_process_fee");
    }
    public function upload_documents()
    {

        return view("gold-loan.applications.upload_documents");
    }
    public function upload_cibil_score()
    {

        return view("gold-loan.applications.upload-cibil-score");
    }
}
