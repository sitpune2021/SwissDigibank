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
use App\Models\LoanCreditScore;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoldLoanController extends Controller
{

    public function index()
    {
        // saare gold loan schemes fetch karenge
        $schemes = GoldLoanScheme::all();
        return view("gold-loan.schemes.index", compact('schemes'));
    }


    public function create()
    {
        return view("gold-loan.schemes.create");
    }

    public function store(Request $request)
    {

        try {
            // validation
            $validated = $request->validate([
                'scheme_name' => 'required|string|max:255',
                'scheme_code' => 'required|string|max:50|unique:gold_loan_schemes,scheme_code',
                'min_loan_amount' => 'required|numeric',
                'max_loan_amount' => 'required|numeric',
                'tenure' => 'required|integer',
                'annual_interest_rate' => 'required|numeric',
            ]);


            // Add is_active = 0
            $data = array_merge($validated, ['is_active' => 0]);

            // Save data
            $scheme = GoldLoanScheme::create($data);
            // Log success
            Log::info('Gold Loan Scheme created successfully', [
                'scheme_id' => $scheme->id,
                'scheme_code' => $scheme->scheme_code
            ]);

            return redirect()->route('gold-loan.schemes.index')
                ->with('success', 'Scheme created successfully!');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error creating Gold Loan Scheme: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e
            ]);

            return back()->withErrors(['error' => 'An error occurred while creating the scheme. Please try again.']);
        }
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
        return view("gold-loan.calculator.index");
    }
    public function calculation()
    {
        return view("gold-loan.calculator.calculation");
    }

    // GoldLoanController.php
    public function appindex()
    {
        // सभी loan applications fetch करें
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

            // ✅ Save Ornaments (Dynamic Rows)
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

        // Dropdown data अगर चाहिए तो यहाँ से pass करो
        $members = Member::all();
        $schemes = GoldLoanScheme::all();
        $branch = Branch::all();
        $scheme = GoldLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view('gold-loan.applications.create', compact('application', 'members', 'schemes', 'branch', 'scheme', 'banks'));
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

        $application = LoanApplication::findOrFail($id);
        $application->update($request->all());

        return redirect()
            ->route('gold-loan.applications.view', $application->id)
            ->with('success', 'Application updated successfully');
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
