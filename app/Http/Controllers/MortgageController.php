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
use App\Models\MortgageProcessingFee;
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
        Log::info('personal Scheme Store Started', [
            'input' => $request->all(),
            'user_id' => Auth::id(), 
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
                'scheme_id' => 'required|exists:mortgage_schemes,id',
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
        $lowerType = strtolower($interestType);

        if (in_array($lowerType, ['reducing_emi', 'reducing balance', 'reducing_balance'])) {
            // Reducing Balance EMI (Declining interest each month)
            $monthlyRate = ($annualRate / 100) / 12;
            $emi = round(($loan * $monthlyRate * pow(1 + $monthlyRate, $installments)) / (pow(1 + $monthlyRate, $installments) - 1), 2);

            // recompute total interest dynamically
            $balance = $loan;
            $totalInterest = 0;
            for ($i = 1; $i <= $installments; $i++) {
                $interestForMonth = $balance * $monthlyRate;
                $principalPaid = $emi - $interestForMonth;
                $balance -= $principalPaid;
                $totalInterest += $interestForMonth;
            }
            $totalInterest = round($totalInterest, 2);
        }
        // elseif (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) {
        //     // Flat Advanced Interest: interest deducted upfront, not added to EMIs
        //     $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
        //     $emi = round($loan / $installments, 2); // Only principal EMIs
        // }
        elseif (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) 
        {
            // Flat Advanced Interest Logic
            //$totalInterest = 0;      // ✅ Interest upfront deduct hoga, EMI me interest zero
            // Flat Advanced Interest Logic
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);  // ✅ Correct total interest


            $installments = 1;       // ✅ EMI = only 1
            $emi = $loan;            // ✅ EMI = full principal (single shot)
        }
        else {
            // Flat EMI
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
            $emi = round(($loan + $totalInterest) / $installments, 2);
        }


        $outstanding = $loan;
        $startDate = now();

        for ($i = 1; $i <= $installments; $i++) 
        {

            $emiDate = $startDate->copy()->addMonths($monthsPerInstallment * $i);
            //$dueDate = $emiDate->copy()->addDays(10);
            $dueDate = $emiDate->copy()->addDay();

            if ($interestType === 'No EMI') 
            {
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

            } 
            else 
            {
                // Normal EMI Logic
                // if ($i == $installments) {
                //     $principal = round($outstanding, 2);
                // } else {
                //     $principal = round($loan / $installments, 2);
                // }

                // $interest = round($totalInterest / $installments, 2);
                // $charges = 0;
                // $emiTotal = round($principal + $interest, 2);

                // $outstanding -= $principal;
                // $balance = max(round($outstanding, 2), 0);
                if (in_array($lowerType, ['reducing_emi', 'reducing balance', 'reducing_balance'])) 
                {
                    // ✅ Reducing EMI Logic
                    $interest = round($outstanding * $monthlyRate, 2);
                    $principal = round($emi - $interest, 2);
                    $charges = 0;
                    $emiTotal = round($principal + $interest, 2);

                    $outstanding -= $principal;
                    $balance = max(round($outstanding, 2), 0);
                } 
                // else 
                // {
                //     // ✅ Flat EMI Logic (same as before)
                //     if ($i == $installments) {
                //         $principal = round($outstanding, 2);
                //     } else {
                //         $principal = round($loan / $installments, 2);
                //     }

                //     $interest = round($totalInterest / $installments, 2);
                //     $charges = 0;
                //     $emiTotal = round($principal + $interest, 2);

                //     $outstanding -= $principal;
                //     $balance = max(round($outstanding, 2), 0);
                // }
                else 
                {
                    if (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) 
                    {
                        // ✅ Flat Advanced Single EMI
                        $principal = round($loan, 2);
                        $interest = 0;
                        $charges = 0;
                        $emiTotal = round($loan, 2);
                        $balance = 0;
                    } 
                    else 
                    {
                        // ✅ Normal Flat EMI logic
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
                }


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
        //  Grand Total (Loan + Interest + Charges)
        if (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) 
        {
            // Interest deducted upfront, EMIs = only principal, total payable = loan amount
            //$totalInterest = 0;
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);

            $totalEmiPaid = $loan;
            $grandTotalPayable = round($loan + $processingFee + $stampAmount + $insuranceAmount, 2);
        } else {
            // Flat / Reducing EMI = normal interest added
            $totalEmiPaid = $loan + $totalInterest;
            $grandTotalPayable = round($loan + $totalInterest + $processingFee + $stampAmount + $insuranceAmount, 2);
        }


        $disbursedAmount = $loan;
        if (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) {
            $disbursedAmount = $loan - $totalInterest;
        }


        //  Return to view
        return view('mortgage.calculator.result', [
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
            //'total_interest' => $totalInterest,
            'total_principal' => $loan,
            //'total_emi_paid' => $loan + $totalInterest,
            'total_emi_paid' => $totalEmiPaid,
            'total_interest' => $totalInterest,
            'grand_total_payable' => $grandTotalPayable,
            'disbursed_amount' => $disbursedAmount,
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
        Log::info('--- Mortgage Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        // Validate before try
        $validated = $request->validate([
            'application_date' => 'required|date_format:d-m-Y',
            'member_id'        => 'required|exists:members,id',
            'branch_id'        => 'required|exists:branches,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric|min:1',
            'tenure_type'      => 'required',
            'tenure_value'      => 'required',
            'emi_collection'      => 'required',
            'credit_period'      => 'required',
            'insurance_amount'      => 'required',
            'net_loan_amount'      => 'required',
            'purpose_of_loan'      => 'required',
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
                'insurance_amount' => 'required|numeric|min:0',
                'net_loan_amount' => 'required|numeric|min:1',
            ]);

             // Validate CIBIL scores (each must be 3 digits between 300–900)
            if ($request->has('cibil_score')) {
                foreach ($request->cibil_score as $index => $score) {
                    if (!empty($score)) {
                        if (!preg_match('/^\d{3}$/', $score) || $score < 300 || $score > 900) {
                            return back()
                                ->withInput()
                                ->with('error', "CIBIL Score at row " . ($index + 1) . " must be a 3-digit number between 300 and 900.");
                        }
                    }
                }
            }

            Log::info('Validation Passed');

            // Step 3.5: Check if any property already exists before creating loan
            if ($request->has('properties') && is_array($request->properties)) {
                foreach ($request->properties as $i => $prop) {
                    if (empty($prop['property_type'])) continue;

                    $docNumber = trim($prop['doc_number'] ?? '');
                    $ownerName = trim($prop['owner_name'] ?? '');
                    $plotNo = trim($prop['plot_no'] ?? '');
                    $tehsil = trim($prop['tehsil'] ?? '');
                    $district = trim($prop['district'] ?? '');
                    $areaSqft = trim($prop['area_sqft'] ?? '');

                    $alreadyExists = MortgageProperty::where(function ($q) use (
                        $docNumber,
                        $ownerName,
                        $plotNo,
                        $tehsil,
                        $district,
                        $areaSqft
                    ) {
                        if ($docNumber) $q->where('doc_number', $docNumber);
                        if ($ownerName) $q->where('owner_name', $ownerName);
                        if ($plotNo) $q->where('plot_no', $plotNo);
                        if ($tehsil) $q->where('tehsil', $tehsil);
                        if ($district) $q->where('district', $district);
                        if ($areaSqft) $q->where('area_sqft', $areaSqft);
                    })->exists();

                    if ($alreadyExists) {
                        Log::warning("Duplicate property found, stopping process", [
                            'row' => $i + 1,
                            'doc_number' => $docNumber,
                            'owner_name' => $ownerName,
                        ]);

                        return back()
                            ->withInput()
                            ->with('error', 'Property details already exist! Please check and try again.');
                    }
                }
            }

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

            Log::info('Mortgage Loan Application Inserted Successfully', [
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

                    // Clean all fields
                    $docNumber = trim($prop['doc_number'] ?? '');
                    $ownerName = trim($prop['owner_name'] ?? '');
                    $plotNo = trim($prop['plot_no'] ?? '');
                    $tehsil = trim($prop['tehsil'] ?? '');
                    $district = trim($prop['district'] ?? '');
                    $areaSqft = trim($prop['area_sqft'] ?? '');

                    // --- 🔍 Check if this property already exists globally ---
                    $alreadyExists = MortgageProperty::where(function ($q) use (
                        $docNumber,
                        $ownerName,
                        $plotNo,
                        $tehsil,
                        $district,
                        $areaSqft
                    ) {
                        if ($docNumber) $q->where('doc_number', $docNumber);
                        if ($ownerName) $q->where('owner_name', $ownerName);
                        if ($plotNo) $q->where('plot_no', $plotNo);
                        if ($tehsil) $q->where('tehsil', $tehsil);
                        if ($district) $q->where('district', $district);
                        if ($areaSqft) $q->where('area_sqft', $areaSqft);
                    })->exists();

                    if ($alreadyExists) {
                        Log::warning("Skipping duplicate property (already exists)", [
                            'row' => $i + 1,
                            'doc_number' => $docNumber,
                            'owner_name' => $ownerName,
                        ]);
                        continue; // ✅ Skip insert
                    }

                    // --- ✅ Insert New Property ---
                    try {
                        MortgageProperty::create([
                            'loan_application_id' => $loanApplication->id,
                            'property_type' => $prop['property_type'] ?? null,
                            'doc_number' => $docNumber ?: null,
                            'registrar_name' => $prop['registrar_name'] ?? null,
                            'owner_name' => $ownerName ?: null,
                            'parent_name' => $prop['parent_name'] ?? null,
                            'plot_no' => $plotNo ?: null,
                            'tehsil' => $tehsil ?: null,
                            'district' => $district ?: null,
                            'area_sqft' => $areaSqft ?: null,
                            'expected_value' => $prop['expected_value'] ?? null,
                            'total_security_amount' => $request->total_security_amount ?? null,
                            'registered' => $prop['registered'] ?? 'no',
                            'boundary_sale_east' => $prop['boundary_sale_east'] ?? null,
                            'boundary_sale_west' => $prop['boundary_sale_west'] ?? null,
                            'boundary_sale_north' => $prop['boundary_sale_north'] ?? null,
                            'boundary_sale_south' => $prop['boundary_sale_south'] ?? null,
                            'boundary_tech_east' => $prop['boundary_tech_east'] ?? null,
                            'boundary_tech_west' => $prop['boundary_tech_west'] ?? null,
                            'boundary_tech_north' => $prop['boundary_tech_north'] ?? null,
                            'boundary_tech_south' => $prop['boundary_tech_south'] ?? null,
                        ]);

                        Log::info('Property Record Inserted', [
                            'property_type' => $prop['property_type'],
                            'doc_number' => $docNumber,
                        ]);
                    } catch (Exception $e) {
                        Log::warning('Failed to insert property record', [
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
                ->with('success', 'Mortgage Loan, Credit Score details saved successfully.');

        } 
        catch (Exception $e) {
            Log::error('Error while storing Loan Application', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // For development: show exact error in browser
            if (app()->environment('local')) {
                return back()
                    ->withInput()
                    ->with('error', 'Error: ' . $e->getMessage());
            }

            // For production: keep generic but log detailed
            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the loan application.');
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
            'scheme',  // <-- add scheme here
            'creditScores'
        ])->findOrFail($id);

        return view("mortgage.applications.view", compact('application'));
    }

    public function appedit($id)
    {
        $application = MortgageLoanApplication::with(['member', 'scheme', 'creditScores', 'properties'])
            ->findOrFail($id);

        $members = Member::all();
        $schemes = MortgageScheme::all();
        $scheme  = MortgageScheme::all();
        $branch  = Branch::all();
        $banks   = Bank::pluck('name', 'id');

        // Total Security Amount calculate (sum of all property expected_value)
        $totalSecurityAmount = $application->properties->sum('expected_value');

        return view('mortgage.applications.create', compact(
            'application',
            'members',
            'schemes',
            'branch',
            'scheme',
            'banks',
            'totalSecurityAmount' 
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

        $application = MortgageLoanApplication::findOrFail($id);
        //$application->update($request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']));
        // Convert date format before update
        $data = $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']);

        // Convert application_date from d-m-Y → Y-m-d
        if (!empty($data['application_date'])) {
            $data['application_date'] = Carbon::createFromFormat('d-m-Y', $data['application_date'])->format('Y-m-d');
        }

        // Convert cheque_date if it exists and not already in Y-m-d
        if (!empty($data['cheque_date']) && strpos($data['cheque_date'], '-') === 2) {
            $data['cheque_date'] = Carbon::createFromFormat('d-m-Y', $data['cheque_date'])->format('Y-m-d');
        }

        // Convert transfer_date if exists
        if (!empty($data['transfer_date']) && strpos($data['transfer_date'], '-') === 2) {
            $data['transfer_date'] = Carbon::createFromFormat('d-m-Y', $data['transfer_date'])->format('Y-m-d');
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
                    'report_date' => Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d'),
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


//////////////////////////////////////////////////////////////////////////////////////


    public function emiChart($id)
    {
        $application = MortgageLoanApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);

        /* Detect Interest Type */
        $interestTypeRaw = strtolower(trim($application->scheme->gold_loan_setting ?? ''));

        if (str_contains($interestTypeRaw, 'no')) {
            $interestType = 'no_emi';
        } elseif (str_contains($interestTypeRaw, 'advanced')) {
            $interestType = 'flat_advanced';
        } elseif (
            str_contains($interestTypeRaw, 'reducing') ||
            str_contains($interestTypeRaw, 'reduce') ||
            str_contains($interestTypeRaw, 'balance') ||
            str_contains($interestTypeRaw, 'rb')
        ) {
            $interestType = 'reducing';
        } else {
            $interestType = 'flat_emi';
        }

        /* Basic Inputs */
        $disburseDate = $application->disbursal_date
            ? Carbon::parse($application->disbursal_date)
            : Carbon::now();

        $loanAmount = floatval($application->approved_loan_amount ?? $application->loan_amount ?? 0);
        $tenure = intval($application->tenure_value ?? ($application->scheme->no_of_emi ?? 1));
        if ($tenure <= 0) $tenure = 1;

        /* Charges */
        $processingFeeInc = floatval($application->processing_fee ?? 0);
        $stampDutyInc     = floatval($application->stamp_duty ?? 0);
        $insuranceInc     = floatval($application->insurance_fee ?? 0);
        $fitnessInc       = floatval($application->fitness_fee ?? 0);

        $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;
        $chargesPerEmi = $tenure ? round($totalChargesInc / $tenure, 2) : 0;

        /* Interest Rate */
        $annualRate = floatval($application->scheme->annual_interest_rate ?? 0);

        /* Collection Frequency */
        $collection = strtolower($application->emi_collection ?? 'monthly');
        switch ($collection) {
            case 'daily':    $periodIncrement = 'addDay';  $periodName = 'DAILY';   $periodsPerYear = 365; break;
            case 'weekly':   $periodIncrement = 'addWeek'; $periodName = 'WEEKLY';  $periodsPerYear = 52; break;
            default:         $periodIncrement = 'addMonth';$periodName = 'MONTHLY'; $periodsPerYear = 12;
        }

        $periodicRate = ($annualRate / 100) / $periodsPerYear;
        $principalPerEmi = round($loanAmount / $tenure, 2);

        /* FLAT EMI fixed interest */
        if ($interestType === 'flat_emi') {
            $totalFlatInterest = ($loanAmount * ($annualRate / 100) * ($tenure / 12));
            $fixedInterest = round($totalFlatInterest / $tenure, 2);

            $roundingDiff = round($totalFlatInterest - ($fixedInterest * $tenure), 2);
        }

        $schedule = [];
        $remainingPrincipal = $loanAmount;
        $emiDate = $disburseDate->copy();

        /*  SPECIAL CASE — **ONLY 1 ROW** (Flat Advanced) */
        if ($interestType == 'flat_advanced') {

        $emiDate = $emiDate->copy()->{$periodIncrement}(1);
        $formattedEmiDate = $emiDate->format('d-m-Y');
        $dueDate = $emiDate->copy()->addDay()->format('d-m-Y');

            $schedule[] = [
                'no' => 1,
                'emi_date' => $formattedEmiDate,
                'due_date' => $dueDate,
                'principal' => number_format($loanAmount, 2),
                'interest' => "0.00",
                'charges_per_emi' => "0.00",
                'emi' => number_format($loanAmount, 2),
                'bal_principal' => "0.00",
            ];

            //  ADD THESE TOTALS
            $totalPrincipal = $loanAmount;
            $totalInterest = 0;
            $totalCharges = 0;
            $totalEmi = $loanAmount;

            return view('mortgage.applications.view-buttons.show-emi-chart', compact(
                'application','loanAmount','disburseDate',
                'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
                'tenure','chargesPerEmi','schedule',
                'totalPrincipal','totalInterest','totalCharges','totalEmi',
                'annualRate','interestType','periodName'
            ));
        }


        /*  Generate EMI Rows */
        for ($i = 1; $i <= $tenure; $i++) {

            $emiDate = $emiDate->copy()->{$periodIncrement}(1);
            $formattedEmiDate = $emiDate->format('d-m-Y');
            $dueDate = $emiDate->copy()->addDay()->format('d-m-Y');

            /*  NO-EMI CASE — every row principal = loanAmount */
            if ($interestType == 'no_emi') {
                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $formattedEmiDate,
                    'due_date' => $dueDate,
                    'principal' => number_format($loanAmount, 2),
                    'interest' => "",
                    'charges_per_emi' => "",
                    'emi' => "",
                    'bal_principal' => "",
                ];
                continue;
            }

            /*  Flat EMI */
            if ($interestType == 'flat_emi') {
                $interestForPeriod = ($i == $tenure) ? $fixedInterest + $roundingDiff : $fixedInterest;
            } else {
                /*  Reducing */
                $interestForPeriod = round($remainingPrincipal * $periodicRate, 2);
            }

            if ($i == $tenure) {
                $principalThis = round($remainingPrincipal, 2);
            } else {
                $principalThis = $principalPerEmi;
            }

            $emiTotal = round($principalThis + $interestForPeriod + $chargesPerEmi, 2);
            $remainingPrincipal = round($remainingPrincipal - $principalThis, 2);

            // $schedule[] = [
            //     'no' => $i,
            //     'emi_date' => $formattedEmiDate,
            //     'due_date' => $dueDate,
            //     'principal' => number_format($principalThis, 2),
            //     'interest' => number_format($interestForPeriod, 2),
            //     'charges_per_emi' => number_format($chargesPerEmi, 2),
            //     'emi' => number_format($emiTotal, 2),
            //     'bal_principal' => number_format($remainingPrincipal, 2),
            // ];
            $schedule[] = [
                'no' => $i,
                'emi_date' => $formattedEmiDate,
                'due_date' => $dueDate,
                'principal' => $principalThis,         
                'interest' => $interestForPeriod,      
                'charges_per_emi' => $chargesPerEmi,   
                'emi' => $emiTotal,                    
                'bal_principal' => $remainingPrincipal 
            ];

        }

        /* Totals */
        $totalPrincipal = array_sum(array_map(fn($r)=>floatval($r['principal']), $schedule));
        $totalInterest  = array_sum(array_map(fn($r)=>floatval($r['interest']), $schedule));
        $totalCharges   = array_sum(array_map(fn($r)=>floatval($r['charges_per_emi']), $schedule));
        $totalEmi       = array_sum(array_map(fn($r)=>floatval($r['emi']), $schedule));
        if ($interestType === 'no_emi') {
            $totalPrincipal = 0;
            $totalInterest  = 0;
            $totalCharges   = 0;
            $totalEmi       = 0;
        }
        return view('mortgage.applications.view-buttons.show-emi-chart', compact(
            'application','loanAmount','disburseDate',
            'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
            'tenure','chargesPerEmi','schedule',
            'totalPrincipal','totalInterest','totalCharges','totalEmi',
            'annualRate','interestType','periodName'
        ));
    }

    public function mortgagecol_process_fee($id)
    {
        $application = MortgageLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("mortgage.applications.view-buttons.col_process_fee", compact('application','banks'));
    }

    public function mortgagestoreProcessFee(Request $request, $id)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'fee_mode' => 'required|in:cash,cheque,online'
        ]);

        $data = $request->all();
        $data['application_id'] = $id;

        if ($request->fee_mode == 'cheque') {
            $request->validate([
                'bank_id' => 'required',
                'cheque_no' => 'required',
                'cheque_date' => 'required|date',
            ]);
        }

        if ($request->fee_mode == 'online') {
            $request->validate([
                'transfer_date' => 'required|date',
                'utr_no' => 'required',
                'transfer_mode' => 'required|in:imps,vpa,neft_rtgs',
                'credited' => 'required|in:yes,no',
            ]);
        }

        MortgageProcessingFee::create($data);

        return redirect()->route('mortgage.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }
    
   public function linepropertyindex()
    {
        $applications = MortgageLoanApplication::with(['creditScores', 'branch', 'member', 'properties'])
            ->whereNotIn('status', [4])
            ->latest()
            ->get(['id', 'status']);

        return view("mortgage.lineproperty.index", compact('applications'));
    }
    
    public function exportLineProperty()
    {
        $fileName = "line_property_export.xls";

        // Fetch data with LEFT JOIN to mortgage_properties
        $data = DB::table('mortgage_loan_applications as mla')
            ->leftJoin('mortgage_properties as mp', 'mp.loan_application_id', '=', 'mla.id')
            ->select(
                'mla.id',
                'mla.status',
                DB::raw('NULL as loan_account_no'),
                DB::raw('NULL as loan_account_status'),
                'mp.property_type',
                'mp.expected_value',
                DB::raw('NULL as registered')
            )
            ->get();

        // Define headers for columns
        $headers = [
            'LOAN APPLICATION NO',
            'LOAN APPLICATION STATUS',
            'LOAN ACCOUNT NO',
            'LOAN ACCOUNT STATUS',
            'PROPERTY TYPE',
            'EXPECTED VALUE',
            'REGISTERED',
        ];

        // Create output buffer
        $output = fopen('php://temp', 'w');

        // Write headings
        fputcsv($output, $headers, "\t");

        // Write rows
        foreach ($data as $row) {
            $statusText = match ((int) $row->status) {
                0 => 'Draft',
                1 => 'Approved',
                2 => 'Disbursed',
                3 => 'Cancelled',
                default => 'Unknown',
            };

            fputcsv($output, [
                $row->id ?? '',
                $statusText,
                '-', // loan_account_no
                '-', // loan_account_status
                $row->property_type ?? '-',
                $row->expected_value ? '₹ ' . number_format($row->expected_value, 2) : '-',
                $row->registered ? 'Yes' : 'No',
            ], "\t");
        }

        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        // Return proper Laravel response
        return response($content)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename={$fileName}")
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


}
