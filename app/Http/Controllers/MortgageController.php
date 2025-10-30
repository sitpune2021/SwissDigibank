<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\MortgageScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\MortgageLoanApplication;
use App\Models\MortgageProperty;
use App\Models\Calculator;
use App\Models\MortgageCreditScore;
use Carbon\Carbon;
use App\Exports\LinePropertExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class MortgageController extends Controller
{
    
    public function index()
    {       
        //$schemes = MortgageScheme::all();
        // paginate(10) => 10 records per page
        $schemes = MortgageScheme::orderBy('id', 'desc')->paginate(10);
        return view("mortgage.schemes.index", compact('schemes'));
    } 
  
    public function create()
    {
        return view("mortgage.schemes.create");
    }

    public function store(Request $request)
    {
        Log::info('Mortgage Scheme Store Started', [
            'input' => $request->all(),
            'user_id' => auth()->id(),
        ]);

        // Step 1: Validation (add new fields)
        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:50|unique:mortgage_schemes,scheme_code',
            'max_loan_limit' => 'required|numeric|min:1',
            'max_loan_amount' => 'required|numeric|min:1|max:200000',
            'annual_interest_rate' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',

            // optional numeric fields (these will be saved if present)
            'overdue_interest_rate' => 'nullable|numeric',
            'penalty_charge' => 'nullable|numeric',
            'processing_fee' => 'nullable|numeric',
            'stamp_duty_charge' => 'nullable|numeric',
            'insurance_fee' => 'nullable|numeric',
            'fore_closer_charge' => 'nullable|numeric',
            'credit_period' => 'nullable|integer',
            'gold_loan_setting' => 'nullable|string',
            'sms_charge' => 'nullable|integer',
            'fuel_charge' => 'nullable|integer',
            'stationary_charge' => 'nullable|integer',
            'maintenance_charge' => 'nullable|integer',
            'collection' => 'nullable|integer',
        ], [
            'scheme_name.required' => 'Please enter scheme name.',
            'scheme_code.required' => 'Scheme code is required.',
            'max_loan_limit.required' => 'Max loan limit is required.',
            'tenure.required' => 'Tenure type is required.',
            'annual_interest_rate.required' => 'Annual interest rate is required.',
            'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
        ]);

        try {
            DB::beginTransaction();

            // Create record directly with validated fields
            $scheme = MortgageScheme::create($validated);

            DB::commit();

            Log::info('Mortgage Scheme Created Successfully', [
                'scheme_id' => $scheme->id,
            ]);

            return redirect()
                ->route('mortgage.schemes.index')
                ->with('success', 'Scheme created successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error While Storing Mortgage Scheme', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = MortgageScheme::findOrFail($id);
        return view('mortgage.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = MortgageScheme::findOrFail($id);
        return view('mortgage.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = MortgageScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('mortgage.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = MortgageScheme::findOrFail($id);
        return view("mortgage.schemes.view", compact('scheme'));
    }


//////////////////////////////////////////////////////////////////////////////////////


    public function calculator()
    {
        $scheme = MortgageScheme::all();
        return view("mortgage.calculator.index", compact('scheme'));
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
           // $interestType = 'flat';
           $interestType = $request->interest_type ?? 'flat_emi';

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

            $scheme = MortgageScheme::findOrFail($request->scheme_id);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            $payout = $request->payout;
            //$interestType = 'flat';
            //$interestType = strtolower($scheme->gold_loan_setting) === 'no_emi' ? 'no_emi' : 'flat';
            $setting = strtolower($scheme->gold_loan_setting);

            switch ($setting) {
                case 'flat_advanced_interest':
                    $interestType = 'Flat Advanced Interest';
                    break;
                case 'flat_advance_interest':
                    $interestType = 'Flat Advance Interest';
                    break;
                case 'flat_interest':
                    $interestType = 'Flat Interest';
                    break;
                case 'reducing_balance':
                    $interestType = 'Reducing Balance';
                    break;
                case 'no_emi':
                    $interestType = 'No EMI';
                    break;
                default:
                    $interestType = ucfirst($setting); // fallback
            }

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
        //$schedule = [];
        // Interest Calculation According to Selected Type
        if (strtolower($interestType) === 'reducing_emi') {
            $monthlyRate = ($annualRate / 100) / 12;
            $emi = round(($loan * $monthlyRate * pow(1 + $monthlyRate, $installments)) / (pow(1 + $monthlyRate, $installments) - 1), 2);
        } else {
            // FLAT EMI (Default)
            $emi = round(($loan + $totalInterest) / $installments, 2);
        }

        $outstanding = $loan;
        $startDate = now();

        for ($i = 1; $i <= $installments; $i++) 
        {

            $emiDate = $startDate->copy()->addMonths($monthsPerInstallment * $i);
            $dueDate = $emiDate->copy()->addDays(10);

            if ($interestType === 'No EMI') {
                // No EMI Logic
                if ($i == $installments) {
                    $principal = round($loan, 2);
                } else {
                    $principal = 0;
                }

                $interest = null;
                $charges = null;
                $emiTotal = null;
                $balance = null;

            } else {
                // Normal EMI Logic
                if ($i == $installments) {
                    $principal = round($outstanding, 2);
                } else {
                    $principal = round($loan / $installments, 2);
                }

                $interest = round($totalInterest / $installments, 2);
                $charges = 0;
                $emiTotal = round($principal + $interest, 2);

                $outstanding -= $principal;
                $balance = max(round($outstanding, 2), 0);
            }

            $schedule[] = [
                'no' => $i,
                'emi_date' => $emiDate->format('d/m/Y'),
                'due_date' => $dueDate->format('d/m/Y'),
                'principal' => $principal,
                'interest' => $interest,
                'charges' => $charges,
                'emi' => $emiTotal,
                'balance' => $balance,
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


////////////////////////////////////////////////////////////////////////////////////////


    public function appindex()
    {
        //  loan applications fetch 
        $applications = MortgageLoanApplication::with(['creditScores'])->latest()->get();

        return view("mortgage.applications.index", compact('applications'));
    }


    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no','general_branch')->get();
        $branch = Branch::all();
        $scheme = MortgageScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("mortgage.applications.create", compact('members','branch','scheme','banks'));
    }
   

    public function storeLoanApplication(Request $request)
    {
        Log::info('--- Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        try {
            // Step 1: Convert application_date (DD-MM-YYYY → YYYY-MM-DD)
            if ($request->filled('application_date')) {
                try {
                    $formattedDate = Carbon::createFromFormat('d-m-Y', $request->application_date)->format('Y-m-d');
                    $request->merge(['application_date' => $formattedDate]);
                    Log::info('Converted application_date', ['formatted' => $formattedDate]);
                } catch (Exception $e) {
                    Log::warning('Invalid application_date format', ['value' => $request->application_date]);
                }
            }

            // Step 2: Map total_security_amount → security_amount
            if ($request->filled('total_security_amount')) {
                $request->merge(['security_amount' => $request->total_security_amount]);
                Log::info('Mapped total_security_amount → security_amount', [
                    'security_amount' => $request->total_security_amount,
                ]);
            }

            // Step 3: Validation
            $validated = $request->validate([
                'application_date' => 'required|date',
                'member_id' => 'required|exists:members,id',
                'branch_id' => 'required|exists:branches,id',
                'scheme_id' => 'required|exists:mortgage_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'security_amount' => 'required|numeric|min:1',
                'purpose_of_loan' => 'required|string|max:255',
                'tenure_type' => 'required|string',
                'tenure_value' => 'required|numeric|min:1',
                'emi_collection' => 'required|string',
                'credit_period' => 'required|numeric|min:1',
                'insurance_amount' => 'required|numeric|min:1',
                'net_loan_amount' => 'required|numeric|min:1',
            ]);

            Log::info('Validation Passed');

            // Step 4: Create main loan application
            $loanApplication = MortgageLoanApplication::create([
                'application_date' => $request->application_date,
                'member_id' => $request->member_id,
                'branch_id' => $request->branch_id,
                'scheme_id' => $request->scheme_id,
                'co_applicant_1_id' => $request->co_applicant_1_id,
                'co_applicant_2_id' => $request->co_applicant_2_id,
                'guarantor_1_id' => $request->guarantor_1_id,
                'guarantor_2_id' => $request->guarantor_2_id,
                'guarantor_3_id' => $request->guarantor_3_id,
                'guarantor_4_id' => $request->guarantor_4_id,
                'tenure_type' => $request->tenure_type,
                'tenure_value' => $request->tenure_value,
                'emi_collection' => $request->emi_collection,
                'credit_period' => $request->credit_period,
                'loan_amount' => $request->loan_amount,
                'insurance_amount' => $request->insurance_amount,
                'net_loan_amount' => $request->net_loan_amount,
                'purpose_of_loan' => $request->purpose_of_loan,
                'security_amount' => $request->security_amount,
                'securety_type' => $request->securety_type ?? 'Property',
                'max_loan_amount' => $request->max_loan_amount,
                'max_loan_limit' => $request->max_loan_limit,
                'maximum_approvable_amount' => $request->maximum_approvable_amount,
                'approved_loan_amount' => $request->approved_loan_amount,
                'created_by' => Auth::id(),
            ]);

            Log::info('Loan Application Inserted Successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // Step 5: Insert multiple CIBIL records
            if ($request->has('cibil_type') && is_array($request->cibil_type)) {
                foreach ($request->cibil_type as $index => $type) {
                    if (empty($type)) continue;

                    try {
                        $reportDate = null;
                        if (!empty($request->report_date[$index])) {
                            $reportDate = Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d');
                        }

                        $filePath = null;
                        if ($request->hasFile("report_file.$index")) {
                            $filePath = $request->file("report_file.$index")
                                ->store('uploads/cibil_reports', 'public');
                        }

                        MortgageCreditScore::create([
                            'loan_application_id' => $loanApplication->id,
                            'cibil_type' => $type,
                            'cibil_score' => $request->cibil_score[$index] ?? null,
                            'report_date' => $reportDate,
                            'report_file_path' => $filePath,
                        ]);

                        Log::info('CIBIL Record Inserted', [
                            'type' => $type,
                            'score' => $request->cibil_score[$index] ?? null,
                        ]);
                    } catch (Exception $e) {
                        Log::warning('Failed to insert CIBIL record', [
                            'index' => $index,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }

            // Step 6: Insert property details
        
            if ($request->has('properties') && is_array($request->properties)) {
                foreach ($request->properties as $i => $prop) {
                    if (empty($prop['property_type'])) continue;

                        try {
                        MortgageProperty::create([
                        'loan_application_id' => $loanApplication->id,
                        'property_type' => $prop['property_type'] ?? null,
                        'doc_number' => $prop['doc_number'] ?? null,
                        'registrar_name' => $prop['registrar_name'] ?? null,
                        'owner_name' => $prop['owner_name'] ?? null,
                        'parent_name' => $prop['parent_name'] ?? null,
                        'plot_no' => $prop['plot_no'] ?? null,
                        'tehsil' => $prop['tehsil'] ?? null,
                        'district' => $prop['district'] ?? null,
                        'area_sqft' => $prop['area'] ?? null,
                        'expected_value' => $prop['property_value'] ?? null,
                        'registered' => $prop['registered'] ?? 'no',
                        // Boundaries as per Sale Deed
                        'boundary_sale_east' => $prop['boundary_sale_east'] ?? null,
                        'boundary_sale_west' => $prop['boundary_sale_west'] ?? null,
                        'boundary_sale_north' => $prop['boundary_sale_north'] ?? null,
                        'boundary_sale_south' => $prop['boundary_sale_south'] ?? null,
                        // Boundaries as per Technical
                        'boundary_tech_east' => $prop['boundary_tech_east'] ?? null,
                        'boundary_tech_west' => $prop['boundary_tech_west'] ?? null,
                        'boundary_tech_north' => $prop['boundary_tech_north'] ?? null,
                        'boundary_tech_south' => $prop['boundary_tech_south'] ?? null,
                    ]);


                            Log::info('Property Record Inserted', [
                                'property_type' => $prop['property_type'],
                                'expected_value' => $prop['property_value'] ?? null,
                            ]);
                        } catch (Exception $e) {
                            Log::warning('Failed to insert one property record', [
                                'index' => $i,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                } else {
                    Log::info('No property details found in request');
                }


            // Step 7: Final success response
            Log::info('All Data Saved Successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            return redirect()->route('mortgage.applications.index')
                ->with('success', 'Loan, Credit Score & Property details saved successfully.');

        } catch (Exception $e) {
            Log::error('Error while storing Loan Application', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while saving the loan application.');
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
        $application = MortgageLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme'   // <-- add scheme here
        ])->findOrFail($id);

        return view("mortgage.applications.view", compact('application'));
    }

    public function appedit($id)
    {
        $application = MortgageLoanApplication::with(['member', 'scheme', 'creditScores', 'properties'])->findOrFail($id);

        $members = Member::all();
        $schemes = MortgageScheme::all();
        $scheme  = MortgageScheme::all();
        $branch  = Branch::all();
        $banks   = Bank::pluck('name', 'id');

        return view('mortgage.applications.create', compact('application', 'members', 'schemes', 'branch', 'scheme', 'banks'));
    }


    public function appupdate(Request $request, $id)
    {
        $request->validate([
            'application_date' => 'required|date',
            'member_id'        => 'required|exists:members,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric',
        ]);

        $application = MortgageLoanApplication::findOrFail($id);
        //$application->update($request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']));
        // Convert date format before update
        $data = $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']);

        // Convert application_date from d-m-Y → Y-m-d
        if (!empty($data['application_date'])) {
            $data['application_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $data['application_date'])->format('Y-m-d');
        }

        // Convert cheque_date if it exists and not already in Y-m-d
        if (!empty($data['cheque_date']) && strpos($data['cheque_date'], '-') === 2) {
            $data['cheque_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $data['cheque_date'])->format('Y-m-d');
        }

        // Convert transfer_date if exists
        if (!empty($data['transfer_date']) && strpos($data['transfer_date'], '-') === 2) {
            $data['transfer_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $data['transfer_date'])->format('Y-m-d');
        }

        // Now safely update
        $application->update($data);

        // Delete old CIBIL reports (if editing)
        $application->creditScores()->delete();

        // Insert new/updated CIBIL rows
        if ($request->has('cibil_type')) {
            foreach ($request->cibil_type as $index => $type) {
                $filePath = null;
                if ($request->hasFile("report_file.$index")) {
                    $filePath = $request->file("report_file.$index")->store('cibil_reports', 'public');
                }

                $application->creditScores()->create([
                    'cibil_type' => $type,
                    'cibil_score' => $request->cibil_score[$index],
                    'report_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d'),
                    'report_file_path' => $filePath,
                ]);
            }
        }

        // Delete old property details
    $application->properties()->delete();

    // Insert updated property details
    if ($request->has('properties')) {
        foreach ($request->properties as $prop) {
            $application->properties()->create($prop);
        }
    }


        return redirect()
            ->route('mortgage.applications.view', $application->id)
            ->with('success', 'Application updated successfully');
    }


     public function showEmiChart(){
        // $banks = Bank::all(); // or your logic here
        return view("mortgage.applications.view-buttons.show-emi-chart");
    }
     public function showdisbursesetting(){
        
        return view("mortgage.applications.view-buttons.disburse-setting");
    }

     public function col_process_fee(){
        
        return view("mortgage.applications.view-buttons.col_process_fee");
    }
    public function upload_documents(){
        
        return view("mortgage.applications.upload_documents");
    }
     public function upload_cibil_score(){
        
        return view("mortgage.applications.upload-cibil-score");
    }


    public function linepropertyindex()
    {
        // loan applications fetch excluding status 1 and 2
        $applications = MortgageLoanApplication::with(['creditScores', 'branch', 'member'])
            ->whereNotIn('status', [4])
            ->latest()
            ->get(['id', 'status']);

        return view("mortgage.lineproperty.index", compact('applications'));
    }

    
    public function exportXls()
    {
        return Excel::download(new LinePropertExport, 'lineproperty.xlsx');
    }
    


    
}
