<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\CcOdLoanScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\CcOdLoanApplication;
use App\Models\Calculator;
use App\Models\BusinessLoanCredit;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;


class CcOdLoanController extends Controller
{
    
    public function index()
    {       
        $schemes = CcOdLoanScheme::orderBy('id', 'desc')->paginate(10);
        return view("cc_od.schemes.index", compact('schemes'));
    } 
  
    public function create()
    {
        return view("cc_od.schemes.create");
    }

   
    public function store(Request $request)
    {
        Log::info('--- cc_od Loan Scheme Store Started ---', [
            'user_id' => auth()->id(),
            'input'   => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            try {
                // Basic validation
                $validated = $request->validate([
                    'scheme_name' => 'required|string|max:255',
                    'scheme_code' => 'required|string|max:50|unique:cc_od_loan_schemes,scheme_code',
                    'max_loan_amount' => 'required|numeric|min:1|max:200000',
                    'tenure' => 'required|integer|min:1',
                    'annual_interest_rate' => 'required|numeric|min:0',
                    'is_active' => 'required|in:0,1',
                ], [
                    'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
                ]);

            // Merge other optional fields
            $data = array_merge($validated, $request->only([
                'processing_fee',
                'stamp_duty_charge',
                'insurance_fee',
                'gold_loan_setting',
                'penalty_charge',
                'fore_closer_charge',
                'credit_period',
                'sms_charge',
                'fuel_charge',
                'stationary_charge',
                'maintenance_charge',
                'collection',
            ]));

            } catch (ValidationException $e) {
                Log::warning('Validation Failed in CcOdLoanScheme', [
                    'errors' => $e->errors(),
                    'input'  => $request->all(),
                ]);

                return back()->withErrors($e->errors())->withInput();
            }

                // Store data in DB
                $scheme = CcOdLoanScheme::create($data);

                DB::commit();

                Log::info('cc_od Loan Scheme Created Successfully', [
                    'scheme_id' => $scheme->id,
                ]);

                return redirect()
                    ->route('cc_od.schemes.index')
                    ->with('success', 'Scheme created successfully!');

            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error while storing cc_od Loan Scheme', [
                    'message' => $e->getMessage(),
                ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }


    public function show($id)
    {
        $scheme = CcOdLoanScheme::findOrFail($id);
        return view('cc_od.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = CcOdLoanScheme::findOrFail($id);
        return view('cc_od.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = CcOdLoanScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('cc_od.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = CcOdLoanScheme::findOrFail($id);
        return view("cc_od.schemes.view", compact('scheme'));
    }


     
    public function appindex()
    {
        // loan applications fetch with pagination
        $applications = CcOdLoanApplication::with(['creditScores'])
            ->latest()
            ->paginate(10); // 10 records

        return view("cc_od.applications.index", compact('applications'));
    }


    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no')->get();
        $branch = Branch::all();
        $scheme = CcOdLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("cc_od.applications.create", compact('members','branch','scheme','banks'));
    }
   

    public function storeLoanApplication(Request $request)
    {
        Log::info('--- cc od Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        // Validation (Security fields removed)
        try {
            $validated = $request->validate([
                'application_date'   => 'required|date',
                'member_id'          => 'required|exists:members,id',
                'branch_id'          => 'required|exists:branches,id',
                'scheme_id'          => 'required|exists:loan_against_schemes,id',
                'purpose_of_loan'    => 'required|string|max:255',
                'net_loan_amount'    => 'required|numeric|min:1',
                'credit_period'      => 'required|numeric|min:1',
                'charge_per_emi'     => 'required|in:0,1',
            ], [
                'application_date.required' => 'Please select the application date.',
                'member_id.required'        => 'Please select a member.',
                'branch_id.required'        => 'Please select a branch.',
                'scheme_id.required'        => 'Please select a loan scheme.',
                'purpose_of_loan.required'  => 'Please enter the purpose of the loan.',
                'net_loan_amount.required'  => 'Please enter Net Loan Amount.',
                'credit_period.required'    => 'Please enter Credit Period.',
            ]);


            Log::info('Validation passed successfully.');
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);

            return back()->withErrors($e->errors())->withInput();
        }

        try {
            // Create record (Security fields removed, null sent instead)
           $loanApplication = CcOdLoanApplication::create([
            'application_date'              => $request->application_date,
            'member_id'                     => $request->member_id,
            'co_applicant_1_id'             => $request->co_applicant_1_id,
            'co_applicant_2_id'             => $request->co_applicant_2_id,
            'branch_id'                     => $request->branch_id,
            'advisor_id'                    => $request->advisor_id,
            'guarantor_1_id'                => $request->guarantor_1_id,
            'guarantor_2_id'                => $request->guarantor_2_id,
            'guarantor_3_id'                => $request->guarantor_3_id,
            'guarantor_4_id'                => $request->guarantor_4_id,
            'scheme_id'                     => $request->scheme_id,
            'net_loan_amount'               => $request->net_loan_amount,
            'purpose_of_loan'               => $request->purpose_of_loan,
            'credit_period'                 => $request->credit_period,
            'charge_per_emi'                => $request->charge_per_emi,
            'processing_fee_gst'            => $request->processing_fee_gst,
            'processing_fee_sgst'           => $request->processing_fee_sgst,
            'processing_fee_cgst'           => $request->processing_fee_cgst,
            'processing_fee_igst'           => $request->processing_fee_igst,
            'processing_fee_total'          => $request->processing_fee_total,
            'fee_mode'                      => $request->fee_mode,
            'bank_id'                       => $request->bank_id,
            'cheque_no'                     => $request->cheque_no,
            'cheque_date'                   => $request->cheque_date,
            'transfer_date'                 => $request->transfer_date,
            'utr_no'                        => $request->utr_no,
            'transfer_mode'                 => $request->transfer_mode,
            'credited'                      => ($request->credited === 'yes' || $request->credited == 1) ? 1 : 0,
            'collect_principal_as_emi'      => $request->collect_principal_as_emi ?? 0,
            'collect_advance_processing_fee'=> $request->collect_advance_processing_fee ?? 0,
            'max_loan_amount'               => $request->max_loan_amount ?? 0,
            'maximum_approvable_amount'     => $request->maximum_approvable_amount ?? 0,
            'approved_loan_amount'          => $request->approved_loan_amount ?? 0,
            'security_type'                 => null,
            'security_amount'               => null,
        ]);


            Log::info('cc / od Loan Application created successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // ==== Credit Score Details Save (Dynamic Rows) ====
            if ($request->has('cibil_type')) {
                Log::info('CIBIL block triggered', [
                    'cibil_type_count' => count($request->cibil_type),
                ]);

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
                    } catch (Exception $e) {
                        Log::error('Error while saving credit score entry', [
                            'index' => $index,
                            'error_message' => $e->getMessage(),
                        ]);
                    }
                }
            } else {
                Log::warning('CIBIL block skipped — no cibil_type found in request.');
            }

            return redirect()->route('cc_od.applications.index')
                ->with('success', 'cc / od Loan Application + Credit Scores saved successfully!');
        } catch (Exception $e) {
            Log::error('❌ Error while storing Business Loan Application', [
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
        $application = CcOdLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        return view("cc_od.applications.view", compact('application'));
    }


    public function appedit($id)
    {
        $application = CcOdLoanApplication::with([
            'member',
            'scheme',
            'branch',
            'creditScores', // relation
            'guarantor1',
            'guarantor2',
            'guarantor3',
            'guarantor4',
        ])->findOrFail($id);

        // Dropdowns
        $members = Member::all();
        $scheme = CcOdLoanScheme::all();
        $branch = Branch::all();
        $banks = Bank::pluck('name', 'id');

        return view('cc_od.applications.create', compact(
            'application', 'members', 'scheme', 'branch', 'banks'
        ));
    }
   

    public function appupdate(Request $request, $id)
    {
        Log::info('--- Loan Application Update Started ---', [
            'user_id' => auth()->id(),
            'application_id' => $id,
            'input_data' => $request->all(),
        ]);

        DB::beginTransaction();

        try {
            // Step 1: Validation
            $request->validate([
                'application_date' => 'required|date',
                'member_id'        => 'required|exists:members,id',
                'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            ]);

            // Step 2: Fetch record
            $application = CcOdLoanApplication::find($id);
            if (!$application) {
                Log::warning('Loan Application not found', ['application_id' => $id]);
                return back()->with('error', 'Loan application not found!');
            }

            // Step 3: Log old data before update
            Log::info('Existing Loan Application Data Before Update', [
                'old_data' => $application->toArray(),
            ]);

            // Step 4: Update main table
            Log::info('Attempting to update Loan Application...', [
                'update_data' => $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']),
            ]);

            $inputData = $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']);

            if (isset($inputData['credited'])) {
                $inputData['credited'] = ($inputData['credited'] === 'yes' || $inputData['credited'] === '1') ? 1 : 0;
            }

            $updated = $application->update($inputData);


            if (!$updated) {
                Log::error('Loan Application update failed', [
                    'application_id' => $id,
                ]);
                throw new Exception('Loan application update failed.');
            }

            // Step 5: Delete old CIBIL scores
            Log::info('Deleting old CIBIL entries...', [
                'application_id' => $id,
            ]);
            $application->creditScores()->delete();

            // Step 6: Insert new CIBIL scores
            $cibilTypes  = $request->input('cibil_type', []);
            $cibilScores = $request->input('cibil_score', []);
            $reportDates = $request->input('report_date', []);
            $reportFiles = $request->file('report_file', []);

            Log::info('CIBIL Data Received', [
                'count' => count($cibilTypes),
                'cibilTypes' => $cibilTypes,
            ]);

            foreach ($cibilTypes as $index => $type) {
                try {
                    $filePath = null;
                    if (isset($reportFiles[$index])) {
                        $filePath = $reportFiles[$index]->store('uploads/cibil_reports', 'public');
                    }

                    // Convert date DD/MM/YYYY → YYYY-MM-DD
                    $rawDate = $reportDates[$index] ?? null;
                    $formattedDate = null;
                    if (!empty($rawDate)) {
                        $dateObj = \DateTime::createFromFormat('d/m/Y', $rawDate);
                        if ($dateObj) {
                            $formattedDate = $dateObj->format('Y-m-d');
                        }
                    }

                    $application->creditScores()->create([
                        'cibil_type'   => $type,
                        'cibil_score'  => $cibilScores[$index] ?? null,
                        'report_date'  => $formattedDate,
                        'report_file'  => $filePath,
                    ]);

                    Log::info('CIBIL Entry Added', [
                        'application_id' => $id,
                        'index' => $index,
                        'type' => $type,
                    ]);
                } catch (Exception $ex) {
                    Log::error('❌ Error while saving individual CIBIL entry', [
                        'index' => $index,
                        'message' => $ex->getMessage(),
                    ]);
                }
            }

            //  Step 7: Commit transaction
            DB::commit();

            Log::info('Loan Application Updated Successfully', [
                'application_id' => $application->id,
            ]);

            return redirect()
                ->route('cc_od.applications.view', $application->id)
                ->with('success', 'Application and credit scores updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Loan Application Update Failed', [
                'application_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while updating the application.');
        }
    }
    


    
}
