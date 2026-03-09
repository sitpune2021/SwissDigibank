<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\FixedLoanScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\FixedLoanApplication;
use App\Models\Calculator;
use App\Models\DailyWeeklyCreditScore;
use App\Models\DailyWeeklyProcessingFee;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;


class FixedLoanController extends Controller
{

    public function index()
    {
        $schemes = FixedLoanScheme::orderBy('id', 'desc')->paginate(10);
        return view("fixed_loan.schemes.index", compact('schemes'));
    }

    public function create()
    {
        return view("fixed_loan.schemes.create");
    }

    public function store(Request $request)
    {
        Log::info('--- fixed_loan Loan Scheme Store Started ---', [
            'user_id' => auth()->id(),
            'input' => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            try {
                // Basic validation
                $validated = $request->validate([
                    'scheme_name' => 'required|string|max:255',
                    'scheme_code' => 'required|string|max:50|unique:fixed_loan_scheme,scheme_code',
                    'max_loan_amount' => 'required|numeric|min:1|max:200000',
                    'no_of_emi' => 'required|integer|min:1',
                    'emi_amount' => 'required|integer|min:1',
                    'annual_interest_rate' => 'required|numeric|min:0',
                    'is_active' => 'required|in:0,1',
                    'overdue_type' => 'nullable|string|max:50',
                    'overdue_rate' => 'required_if:overdue_type,TYPE_1,TYPE_2|numeric|min:0',

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
                    'overdue_type',
                    'overdue_rate',
                    'fitness_fee',
                    'credit_period',
                ]));

            } catch (ValidationException $e) {
                Log::warning('Validation Failed in fixed_loan Scheme', [
                    'errors' => $e->errors(),
                    'input' => $request->all(),
                ]);

                return back()->withErrors($e->errors())->withInput();
            }

            // Store data in DB
            $scheme = FixedLoanScheme::create($data);

            DB::commit();

            Log::info('fixed Loan Scheme Created Successfully', [
                'scheme_id' => $scheme->id,
            ]);

            $this->saveActivity(
                'fixed Loan Scheme',
                'Create',
                'Created fixed Loan Scheme ID: ' . $scheme->id
            );

            return redirect()
                ->route('fixed_loan.schemes.index')
                ->with('success', 'Scheme created successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error while storing fixed Loan Scheme', [
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = FixedLoanScheme::findOrFail($id);
        return view('fixed_loan.schemes.show', compact('scheme'));
    }

    public function disapprove($id)
    {
        $application = FixedLoanApplication::findOrFail($id);

        // Only allow if currently approved
        if ($application->status == 1) {
            $application->status = 0; // Disapproved / Draft
            $application->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Application marked as Disapproved successfully.');
    }

    public function edit($id)
    {
        $scheme = FixedLoanScheme::findOrFail($id);
        return view('fixed_loan.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = FixedLoanScheme::findOrFail($id);

        $scheme->update($request->all());

        $this->saveActivity(
            'fixed Loan Scheme',
            'Update',
            'Updated fixed Loan Scheme ID: ' . $scheme->id
        );

        return redirect()->route('fixed_loan.schemes.index')
            ->with('success', 'Scheme updated successfully!');
    }

    public function view($id)
    {
        $scheme = FixedLoanScheme::findOrFail($id);
        return view("fixed_loan.schemes.view", compact('scheme'));
    }

    public function appindex()
    {
        // loan applications fetch with pagination
        $applications = FixedLoanApplication::latest()
            ->paginate(10); // 10 records

        return view("fixed_loan.applications.index", compact('applications'));
    }

    public function appcreate()
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name', 'member_info_mobile_no', 'general_branch')->get();
        $branch = Branch::all();
        $scheme = FixedLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("fixed_loan.applications.create", compact('members', 'branch', 'scheme', 'banks'));
    }

    public function storeLoanApplication(Request $request)
    {
        Log::info('--- Fixed Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->except(['_token']),
        ]);

        // =========================
        // 1. VALIDATION
        // =========================
        $validated = $request->validate([
            'application_date'   => 'required|date_format:d-m-Y',
            'member_id'          => 'required|exists:members,id',
            'application_no'     => 'required|string',
            'branch_id'          => 'required|exists:branches,id',

            'purpose_of_loan'    => 'required|string|max:255',
            'credit_period'      => 'required|numeric|min:0',

            'tenure_value'       => 'required|numeric|min:1',
            'loan_amount'        => 'required|numeric|min:1',
            'emi_collection'     => 'required|string',
            'emi_amount'         => 'required|numeric|min:1',

            'processing_fee'     => 'required|numeric|min:0',
            'stamp_duty'         => 'required|numeric|min:0',
            'fitness_fee'        => 'required|numeric|min:0',
            'insurance_fee'      => 'required|numeric|min:0',

            'charge_per_emi'        => 'required|numeric|min:0',
            'net_emi_with_charges'   => 'required|numeric|min:0',
            'total_recovered_amount' => 'required|numeric|min:0',

            // optional IDs
            'co_applicant_1_id'  => 'nullable|exists:members,id',
            'co_applicant_2_id'  => 'nullable|exists:members,id',

            'guarantor_1_id'     => 'nullable|exists:members,id',
            'guarantor_2_id'     => 'nullable|exists:members,id',
            'guarantor_3_id'     => 'nullable|exists:members,id',
            'guarantor_4_id'     => 'nullable|exists:members,id',
        ]);

        // =========================
        // 2. DATE FORMAT CONVERSION
        // =========================
        $applicationDate = Carbon::createFromFormat('d-m-Y', $request->application_date)->format('Y-m-d');

        $chequeDate = $request->cheque_date
            ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d')
            : null;

        $transferDate = $request->transfer_date
            ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d')
            : null;

        // =========================
        // 3. STORE DATA
        // =========================
        try {
            $loanApplication = FixedLoanApplication::create([
                'application_date' => $applicationDate,
                'status'        => 0,
                'member_id'        => $request->member_id,
                'application_no'        => $request->application_no,

                'co_applicant_1_id' => $request->co_applicant_1_id,
                'relation_co_applicant_1' => $request->relation_co_applicant_1,

                'co_applicant_2_id' => $request->co_applicant_2_id,
                'relation_co_applicant_2' => $request->relation_co_applicant_2,

                'branch_id'  => $request->branch_id,
                'advisor_id'=> $request->advisor_id,

                'guarantor_1_id' => $request->guarantor_1_id,
                'relation_guarantor_1' => $request->relation_guarantor_1,

                'guarantor_2_id' => $request->guarantor_2_id,
                'relation_guarantor_2' => $request->relation_guarantor_2,

                'guarantor_3_id' => $request->guarantor_3_id,
                'relation_guarantor_3' => $request->relation_guarantor_3,

                'guarantor_4_id' => $request->guarantor_4_id,
                'relation_guarantor_4' => $request->relation_guarantor_4,

                // scheme optional
                'scheme_id' => $request->scheme_id,

                'purpose_of_loan' => $request->purpose_of_loan,
                'credit_period'   => $request->credit_period,

                'tenure_value'   => $request->tenure_value,
                'loan_amount'    => $request->loan_amount,
                'emi_collection' => $request->emi_collection,
                'emi_amount'     => $request->emi_amount,

                'processing_fee' => $request->processing_fee,
                'stamp_duty'     => $request->stamp_duty,
                'fitness_fee'    => $request->fitness_fee,
                'insurance_fee'  => $request->insurance_fee,

                'charges_per_emi'        => $request->charges_per_emi,
                'net_emi_with_charges'   => $request->net_emi_with_charges,
                'total_recovered_amount' => $request->total_recovered_amount,

                'credited' => $request->credited ? 1 : 0,

                'max_loan_amount'              => $request->max_loan_amount ?? 0,
                'maximum_approvable_amount'    => $request->maximum_approvable_amount ?? 0,
                'approved_loan_amount'          => $request->approved_loan_amount ?? 0,

                'bank_id'       => $request->bank_id,
                'cheque_no'     => $request->cheque_no,
                'cheque_date'   => $chequeDate,
                'transfer_date' => $transferDate,
                'utr_no'        => $request->utr_no,
                'transfer_mode' => $request->transfer_mode,
            ]);

            Log::info('Fixed Loan Application stored successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

             $this->saveActivity(
                'fixed Loan Application',
                'Create',
                'Created fixed Loan Application ID: ' . $loanApplication->id
            );

            return redirect()
                ->route('fixed_loan.applications.index')
                ->with('success', 'Loan Application saved successfully');

        } catch (\Exception $e) {

            Log::error('Error while storing Fixed Loan Application', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving loan application.');
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
        $application = FixedLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
        ])->findOrFail($id);

        $processingFee = DailyWeeklyProcessingFee::where('application_id', $id)
            ->latest()
            ->first();

        return view("fixed_loan.applications.view", compact('application', 'processingFee'));
    }

    public function appedit($id)
    {
        $application = FixedLoanApplication::with([
            'member',
            'branch',
            'guarantor1',
            'guarantor2',
            'guarantor3',
            'guarantor4',
        ])->findOrFail($id);

        // Dropdowns
        $members = Member::all();
        $branch = Branch::all();
        $banks = Bank::pluck('name', 'id');

        return view('fixed_loan.applications.create', compact(
            'application',
            'members',
            'branch',
            'banks'
        ));
    }

    public function appupdate(Request $request, $id)
    {
        Log::info('--- fixed_loan Loan Application Update Started ---', [
            'user_id' => auth()->id(),
            'application_id' => $id,
            'input_data' => $request->all(),
        ]);

        DB::beginTransaction();

        try {
            // Step 1: Validation
            $request->validate([
                'application_date' => 'required|date',
                'member_id' => 'required|exists:members,id',
                // scheme_id removed
            ]);

            // Step 2: Fetch record
            $application = FixedLoanApplication::findOrFail($id);

            // Step 3: Log old data before update
            Log::info('Existing Loan Application Data Before Update', [
                'old_data' => $application->toArray(),
            ]);

            // Step 4: Prepare input
            $inputData = $request->except([
                'cibil_type', 
                'cibil_score', 
                'report_date', 
                'report_file',
                'scheme_id', // ignore scheme_id
            ]);

            if (!empty($inputData['application_date'])) {
                $inputData['application_date'] = Carbon::createFromFormat(
                    'd-m-Y',
                    $inputData['application_date']
                )->format('Y-m-d');
            }

            if (isset($inputData['credited'])) {
                $inputData['credited'] = ($inputData['credited'] === 'yes' || $inputData['credited'] === '1') ? 1 : 0;
            }

            // Step 5: Update
            $application->update($inputData);

            DB::commit();

            Log::info('fixed_loan Loan Application Updated Successfully', [
                'application_id' => $application->id,
            ]);

             $this->saveActivity(
                'fixed Loan Application',
                'Update',
                'Updated fixed Loan Application ID: ' . $application->id
            );

            return redirect()
                ->route('fixed_loan.applications.view', $application->id)
                ->with('success', 'Application updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('fixed_loan Loan Application Update Failed', [
                'application_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while updating the application.');
        }
    }

    public function col_process_fee($id)
    {
        $application = FixedLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("fixed_loan.applications.view-buttons.col_process_fee", compact('application', 'banks'));
    }

    public function storeProcessFee(Request $request, $id)
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

        DailyWeeklyProcessingFee::create($data);

        return redirect()->route('fixed_loan.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }

    public function emiChart($id)
    {
    $application = FixedLoanApplication::findOrFail($id);

    $disburseDate = $application->disbursal_date
        ? Carbon::parse($application->disbursal_date)
        : Carbon::now();

    $loanAmount = floatval($application->loan_amount ?? 0);
    $tenure = intval($application->tenure_value ?? 1);
    if ($tenure <= 0) $tenure = 1;

    // Charges — temporarily zero
    $chargesPerEmi = 0;

    // Fixed EMI from application (if stored)
    $fixedEmiAmount = floatval($application->emi_amount ?? 0);

    // EMI frequency
    $collection = strtolower($application->emi_collection ?? 'monthly');
    switch ($collection) {
        case 'daily':
            $periodName = 'Daily';
            $periodUnit = 'day';
            $periodIncrement = 'addDay';
            break;
        case 'weekly':
            $periodName = 'Weekly';
            $periodUnit = 'week';
            $periodIncrement = 'addWeek';
            break;
        case 'bi_weekly':
            $periodName = 'Bi-Weekly';
            $periodUnit = 'week';
            $periodIncrement = 'addWeeks';
            $periodStep = 2;
            break;
        case '4_weekly':
            $periodName = '4-Weekly';
            $periodUnit = 'week';
            $periodIncrement = 'addWeeks';
            $periodStep = 4;
            break;
        default:
            $periodName = 'Monthly';
            $periodUnit = 'month';
            $periodIncrement = 'addMonth';
            break;
    }

    $schedule = [];
    $remainingPrincipal = $loanAmount;
    $emiDate = $disburseDate->copy();

    for ($i = 1; $i <= $tenure; $i++) {
        if (isset($periodStep)) {
            $emiDate = $emiDate->copy()->{$periodIncrement}($periodStep);
        } else {
            $emiDate = $emiDate->copy()->{$periodIncrement}(1);
        }

        // Principal per EMI = loan / tenure
        $principalPerEmi = round($loanAmount / $tenure, 2);

        // Interest = fixed EMI - principal - charges
        $interestPerEmi = round($fixedEmiAmount - $principalPerEmi - $chargesPerEmi, 2);

        // Last EMI adjustment
        if ($i == $tenure) {
            $principalPerEmi = $remainingPrincipal;
            $interestPerEmi = round($fixedEmiAmount - $principalPerEmi - $chargesPerEmi, 2);
        }

        $emiTotal = round($principalPerEmi + $interestPerEmi + $chargesPerEmi, 2);
        $remainingPrincipal = round($remainingPrincipal - $principalPerEmi, 2);
        if ($remainingPrincipal < 0) $remainingPrincipal = 0.0;

        $schedule[] = [
            'no' => $i,
            'emi_date' => $emiDate->format('d-m-Y'), // dash format
            'due_date' => $emiDate->copy()->addDay()->format('d-m-Y'), // dash format
            'principal' => $principalPerEmi,
            'interest' => $interestPerEmi,
            'charges_per_emi' => $chargesPerEmi, // now zero
            'emi' => $emiTotal,
            'bal_principal' => $remainingPrincipal
        ];
    }

    $totalPrincipal = array_sum(array_column($schedule, 'principal'));
    $totalInterest = array_sum(array_column($schedule, 'interest'));
    $totalCharges = array_sum(array_column($schedule, 'charges_per_emi'));
    $totalEmi = array_sum(array_column($schedule, 'emi'));

    // Charges from application
    $processingFeeInc = floatval($application->processing_fee ?? 0);
    $stampDutyInc = floatval($application->stamp_duty ?? 0);
    $insuranceInc = floatval($application->insurance_fee ?? 0);
    $fitnessInc = floatval($application->fitness_fee ?? 0);


    return view('fixed_loan.applications.view-buttons.show-emi-chart', compact(
        'application',
        'loanAmount',
        'disburseDate',
        'tenure',
        'periodName',
        'periodUnit',
        'chargesPerEmi', // will be zero in chart
        'schedule',
        'totalPrincipal',
        'totalInterest',
        'totalCharges',
        'totalEmi',
            'chargesPerEmi', // EMI chart me zero
    'processingFeeInc', // blade me show karne ke liye
    'stampDutyInc',     // blade me show karne ke liye
    'insuranceInc',     // blade me show karne ke liye
    'fitnessInc',       // agar required
    ));
    }

    public function disbursment($id)
    {
        $application = FixedLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        return view("fixed_loan.applications.view-buttons.disburse-setting", compact('application'));
    }

    public function submitForApproval($id)
    {
        // Fetch the relevant model — change LoanApplication to appropriate model if many models share same button.
        $application = FixedLoanApplication::findOrFail($id);

        // Do NOT change status. Only update updated_at to current time so it becomes "latest"
        // Option A: touch() updates updated_at automatically
        $application->touch();

        return redirect()->route('loans')
            ->with('success', 'Submitted for approval!');

    }


}
