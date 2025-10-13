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
use App\Models\LoanCreditScore;
use Carbon\Carbon;
use App\Exports\LinePropertExport;
use Maatwebsite\Excel\Facades\Excel;

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
            'maintenace_charge' => 'nullable|numeric|min:0',
            'collcetion' => 'nullable|numeric|min:0',
            'is_active' => 'required|in:0,1',
        ], [
            'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
        ]);

        MortgageScheme::create($validated);

        return redirect()
            ->route('mortgage.schemes.index')
            ->with('success', 'Scheme created successfully!');
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

            $scheme = MortgageScheme::findOrFail($request->scheme_id);

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
        $applications = MortgageLoanApplication::with(['creditScores'])->latest()->get();

        return view("mortgage.applications.index", compact('applications'));
    }


    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no')->get();
        $branch = Branch::all();
        $scheme = MortgageScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("mortgage.applications.create", compact('members','branch','scheme','banks'));
    }
   

public function storeLoanApplication(Request $request)
{
    // Step 1: Save Loan Application
    $application = MortgageLoanApplication::create([
        'application_date' => $request->application_date,
        'member_id' => $request->member_id,
        'scheme_id' => $request->scheme_id,
        'loan_amount' => $request->loan_amount,
        'branch_id' => $request->branch_id,
        'tenure_value' => $request->tenure_value,
        'net_loan_amount' => $request->net_loan_amount,
        'purpose_of_loan' => $request->purpose_of_loan,
    ]);

    // Step 2: Save Multiple Property Details
    if ($request->filled('property_type')) {
        foreach ($request->property_type as $index => $type) {
            MortgageProperty::create([
                'loan_application_id' => $application->id,
                'property_type' => $type,
                'ownership_type' => $request->ownership_type[$index] ?? null,
                'property_address' => $request->property_address[$index] ?? null,
                'city' => $request->city[$index] ?? null,
                'state' => $request->state[$index] ?? null,
                'area' => $request->area[$index] ?? null,
                'property_value' => $request->property_value[$index] ?? 0,
            ]);
        }
    }

    return redirect()->route('mortgage.applications.index')
        ->with('success', 'Loan Application and Property saved successfully!');
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
        $application = MortgageLoanApplication::with(['member', 'scheme'])->findOrFail($id);

        // Dropdown data अगर चाहिए तो यहाँ से pass करो
        $members = Member::all();
        $schemes = MortgageScheme::all();
        $branch = Branch::all();
        $scheme = MortgageScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view('mortgage.applications.create', compact('application', 'members', 'schemes','branch', 'scheme','banks'));
    }

    public function appupdate(Request $request, $id)
    {
        $request->validate([
            'application_date' => 'required|date',
            'member_id'        => 'required|exists:members,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric',
            // बाकी fields का validation
        ]);

        $application = MortgageLoanApplication::findOrFail($id);
        $application->update($request->all());

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
