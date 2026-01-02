<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\DailyWeeklyScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\DailyWeeklyApplication;
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


class DailyWeeklyController extends Controller
{

    public function index()
    {
        $schemes = DailyWeeklyScheme::orderBy('id', 'desc')->paginate(10);
        return view("daily_weekly.schemes.index", compact('schemes'));
    }

    public function create()
    {
        return view("daily_weekly.schemes.create");
    }

    public function store(Request $request)
    {
        Log::info('--- daily_weekly Loan Scheme Store Started ---', [
            'user_id' => auth()->id(),
            'input' => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            try {
                // Basic validation
                $validated = $request->validate([
                    'scheme_name' => 'required|string|max:255',
                    'scheme_code' => 'required|string|max:50|unique:daily_weekly_schemes,scheme_code',
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
                Log::warning('Validation Failed in DailyWeeklyScheme', [
                    'errors' => $e->errors(),
                    'input' => $request->all(),
                ]);

                return back()->withErrors($e->errors())->withInput();
            }

            // Store data in DB
            $scheme = DailyWeeklyScheme::create($data);

            DB::commit();

            Log::info('daily_weekly Loan Scheme Created Successfully', [
                'scheme_id' => $scheme->id,
            ]);

            return redirect()
                ->route('daily_weekly.schemes.index')
                ->with('success', 'Scheme created successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error while storing daily_weekly Loan Scheme', [
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = DailyWeeklyScheme::findOrFail($id);
        return view('daily_weekly.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = DailyWeeklyScheme::findOrFail($id);
        return view('daily_weekly.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = DailyWeeklyScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('daily_weekly.schemes.index')
            ->with('success', 'Scheme updated successfully!');
    }

    public function view($id)
    {
        $scheme = DailyWeeklyScheme::findOrFail($id);
        return view("daily_weekly.schemes.view", compact('scheme'));
    }

    public function appindex()
    {
        // loan applications fetch with pagination
        $applications = DailyWeeklyApplication::with(['creditScores'])
            ->latest()
            ->paginate(10); // 10 records

        return view("daily_weekly.applications.index", compact('applications'));
    }

    public function appcreate()
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name', 'member_info_mobile_no', 'general_branch')->get();
        $branch = Branch::all();
        $scheme = DailyWeeklyScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("daily_weekly.applications.create", compact('members', 'branch', 'scheme', 'banks'));
    }

    public function storeLoanApplication(Request $request)
    {
        Log::info('--- daily_weekly Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        // Validation (Security fields removed)
        try {
            $validated = $request->validate([
                'application_date' => 'required|date',
                'member_id' => 'required|exists:members,id',
                'branch_id' => 'required|exists:branches,id',
                'scheme_id' => 'required|exists:loan_against_schemes,id',
                'purpose_of_loan' => 'required|string|max:255',
                'credit_period' => 'required|numeric|min:1',
                'tenure_value' => 'required|numeric|min:1',
                'loan_amount' => 'required|numeric|min:1',
                'emi_collection' => 'required|string',
                'emi_amount' => 'required|numeric|min:1',
                'processing_fee' => 'required|numeric|min:0',
                'stamp_duty' => 'required|numeric|min:0',
                'fitness_fee' => 'required|numeric|min:0',
                'insurance_fee' => 'required|numeric|min:0',
                'charges_per_emi' => 'required|numeric|min:0',
                'net_emi_with_charges' => 'required|numeric|min:0',
                'total_recovered_amount' => 'required|numeric|min:0',
            ], [
                'application_date.required' => 'Please select the application date.',
                'member_id.required' => 'Please select a member.',
                'branch_id.required' => 'Please select a branch.',
                'scheme_id.required' => 'Please select a loan scheme.',
                'purpose_of_loan.required' => 'Please enter the purpose of the loan.',
                'credit_period.required' => 'Please enter Credit Period.',
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

            Log::info('Validation passed successfully.');
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);

            return back()->withErrors($e->errors())->withInput();
        }

        $applicationDate = Carbon::createFromFormat(
            'd-m-Y',
            $request->application_date
        )->format('Y-m-d');

        $chequeDate = $request->cheque_date
            ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d')
            : null;

        $transferDate = $request->transfer_date
            ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d')
            : null;
        try {
            // Create record (Security fields removed, null sent instead)
            $loanApplication = DailyWeeklyApplication::create([
                'application_date' => $applicationDate,
                'member_id' => $request->member_id,
                'co_applicant_1_id' => $request->co_applicant_1_id,
                'co_applicant_2_id' => $request->co_applicant_2_id,
                'branch_id' => $request->branch_id,
                'advisor_id' => $request->advisor_id,
                'guarantor_1_id' => $request->guarantor_1_id,
                'guarantor_2_id' => $request->guarantor_2_id,
                'guarantor_3_id' => $request->guarantor_3_id,
                'guarantor_4_id' => $request->guarantor_4_id,
                'scheme_id' => $request->scheme_id,
                'purpose_of_loan' => $request->purpose_of_loan,
                'credit_period' => $request->credit_period,
                'processing_fee_gst' => $request->processing_fee_gst,
                'processing_fee_sgst' => $request->processing_fee_sgst,
                'processing_fee_cgst' => $request->processing_fee_cgst,
                'processing_fee_igst' => $request->processing_fee_igst,
                'processing_fee_total' => $request->processing_fee_total,
                'fee_mode' => $request->fee_mode,
                'bank_id' => $request->bank_id,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => $chequeDate,
                'transfer_date' => $transferDate,
                'utr_no' => $request->utr_no,
                'transfer_mode' => $request->transfer_mode,
                'credited' => ($request->credited === 'yes' || $request->credited == 1) ? 1 : 0,
                'collect_principal_as_emi' => $request->collect_principal_as_emi ?? 0,
                'collect_advance_processing_fee' => $request->collect_advance_processing_fee ?? 0,
                'max_loan_amount' => $request->max_loan_amount ?? 0,
                'maximum_approvable_amount' => $request->maximum_approvable_amount ?? 0,
                'approved_loan_amount' => $request->approved_loan_amount ?? 0,
                'security_type' => null,
                'security_amount' => null,
                'tenure_value' => $request->tenure_value,
                'loan_amount' => $request->loan_amount,
                'emi_collection' => $request->emi_collection,
                'emi_amount' => $request->emi_amount,
                'processing_fee' => $request->processing_fee,
                'stamp_duty' => $request->stamp_duty,
                'fitness_fee' => $request->fitness_fee,
                'insurance_fee' => $request->insurance_fee,
                'charges_per_emi' => $request->charges_per_emi,
                'net_emi_with_charges' => $request->net_emi_with_charges,
                'total_recovered_amount' => $request->total_recovered_amount,

            ]);


            Log::info('daily_weekly Loan Application created successfully', [
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
                            'cibil_type' => $type,
                            'cibil_score' => $request->cibil_score[$index] ?? null,
                            // 'report_date'      => isset($request->report_date[$index])
                            //     ? Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d')
                            //     : null,
                            'report_date' => isset($request->report_date[$index])
                                ? Carbon::createFromFormat('d-m-Y', $request->report_date[$index])->format('Y-m-d') // ✅ Correct format
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

            return redirect()->route('daily_weekly.applications.index')
                ->with('success', 'daily_weekly Loan Application + Credit Scores saved successfully!');
        } catch (Exception $e) {
            Log::error('Error while storing Business Loan Application', [
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
        $application = DailyWeeklyApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        $processingFee = DailyWeeklyProcessingFee::where('application_id', $id)
            ->latest()
            ->first();

        return view("daily_weekly.applications.view", compact('application', 'processingFee'));
    }

    public function appedit($id)
    {
        $application = DailyWeeklyApplication::with([
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
        $scheme = DailyWeeklyScheme::all();
        $branch = Branch::all();
        $banks = Bank::pluck('name', 'id');

        return view('daily_weekly.applications.create', compact(
            'application',
            'members',
            'scheme',
            'branch',
            'banks'
        ));
    }

    public function appupdate(Request $request, $id)
    {
        Log::info('--- daily_weekly Loan Application Update Started ---', [
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
                'scheme_id' => 'required|exists:gold_loan_schemes,id',
            ]);

            // Step 2: Fetch record
            $application = DailyWeeklyApplication::find($id);
            if (!$application) {
                Log::warning('daily_weekly Loan Application not found', ['application_id' => $id]);
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
             if (!empty($inputData['application_date'])) {
            $inputData['application_date'] = Carbon::createFromFormat(
                'd-m-Y',
                $inputData['application_date']
            )->format('Y-m-d');
        }


            if (isset($inputData['credited'])) {
                $inputData['credited'] = ($inputData['credited'] === 'yes' || $inputData['credited'] === '1') ? 1 : 0;
            }

            $updated = $application->update($inputData);


            if (!$updated) {
                Log::error('daily_weekly Loan Application update failed', [
                    'application_id' => $id,
                ]);
                throw new Exception('daily_weekly Loan application update failed.');
            }

            // Step 5: Delete old CIBIL scores
            Log::info('Deleting old CIBIL entries...', [
                'application_id' => $id,
            ]);
            $application->creditScores()->delete();

            // Step 6: Insert new CIBIL scores
            $cibilTypes = $request->input('cibil_type', []);
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
                        $dateObj = \DateTime::createFromFormat('d-m-Y', $rawDate);
                        if ($dateObj) {
                            $formattedDate = $dateObj->format('Y-m-d');
                        }
                    }

                    $application->creditScores()->create([
                        'cibil_type' => $type,
                        'cibil_score' => $cibilScores[$index] ?? null,
                        'report_date' => $formattedDate,
                        'report_file' => $filePath,
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

            Log::info('daily_weekly Loan Application Updated Successfully', [
                'application_id' => $application->id,
            ]);

            return redirect()
                ->route('daily_weekly.applications.view', $application->id)
                ->with('success', 'Application and credit scores updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('daily_weekly Loan Application Update Failed', [
                'application_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while updating the application.');
        }
    }

    public function col_process_fee($id)
    {
        $application = DailyWeeklyApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("daily_weekly.applications.view-buttons.col_process_fee", compact('application', 'banks'));
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

        return redirect()->route('daily_weekly.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }

    public function emiChart($id)
    {
        $application = DailyWeeklyApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);

        // Basic inputs
        $disburseDate = $application->disbursal_date
            ? Carbon::parse($application->disbursal_date)
            : Carbon::now(); // fallback

        $loanAmount = floatval($application->loan_amount ?? 0);
        $tenure = intval($application->tenure_value ?? ($application->scheme->no_of_emi ?? 1));
        if ($tenure <= 0)
            $tenure = 1;

        // Charges (inclusive amounts if stored that way). We will treat these as inclusive already.
        $processingFeeInc = floatval($application->processing_fee ?? 0);
        $stampDutyInc = floatval($application->stamp_duty ?? 0);
        $insuranceInc = floatval($application->insurance_fee ?? 0);
        $fitnessInc = floatval($application->fitness_fee ?? 0);

        $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;

        // Charges per EMI
        $chargesPerEmi = $tenure ? round($totalChargesInc / $tenure, 2) : 0;

        // Interest rate (annual) & periodic rate
        $annualRate = floatval($application->scheme->annual_interest_rate ?? 0); // e.g. 8
        // Decide period multiplier from emi_collection
        $collection = strtolower($application->emi_collection ?? 'monthly');

        // Map to Carbon increments and period factor
        switch ($collection) {
            case 'daily':
                $periodIncrement = 'addDay';
                $periodCount = 30; // treat month as 30 days for display; amortization uses daily? keep simple: monthly logic would be default
                $periodsPerYear = 365;
                $periodName = 'Daily';
                $periodUnit = 'day';
                break;
            case 'weekly':
            case 'bi_weekly':
            case '4_weekly':
                $periodIncrement = 'addWeek';
                $periodsPerYear = 52;
                $periodName = 'Weekly';
                $periodUnit = 'week';
                break;
            default:
                // monthly
                $periodIncrement = 'addMonth';
                $periodsPerYear = 12;
                $periodName = 'Monthly';
                $periodUnit = 'month';
        }

        // periodic interest rate
        $periodicRate = ($annualRate / 100) / $periodsPerYear; // e.g. monthly => /12

        // We'll use equal principal approach:
        $principalPerEmi = round($loanAmount / $tenure, 2);

        $schedule = [];
        $remainingPrincipal = $loanAmount;
        $emiDate = $disburseDate->copy();

        for ($i = 1; $i <= $tenure; $i++) {
            // Next EMI date: for equal principal we typically start next period; advance once
            $emiDate = $emiDate->copy()->{$periodIncrement}(1);

            // Interest on remaining principal for the period
            $interestForPeriod = round($remainingPrincipal * $periodicRate, 2);

            // For last installment, adjust principal to consume rounding residuals
            if ($i == $tenure) {
                $principalThis = round($remainingPrincipal, 2);
            } else {
                $principalThis = $principalPerEmi;
            }

            $emiTotal = round($principalThis + $interestForPeriod + $chargesPerEmi, 2);
            $remainingPrincipal = round($remainingPrincipal - $principalThis, 2);
            if ($remainingPrincipal < 0)
                $remainingPrincipal = 0.00;
            // EMI Date format change
            $formattedEmiDate = $emiDate->format('d-m-Y');

            // Due date = EMI date + 1 day
            $dueDate = $emiDate->copy()->addDay()->format('d-m-Y');

            $schedule[] = [
                'no' => $i,
                'emi_date' => $formattedEmiDate,
                'due_date' => $dueDate,
                'principal' => number_format($principalThis, 2, '.', ''),
                'interest' => number_format($interestForPeriod, 2, '.', ''),
                'charges_per_emi' => number_format($chargesPerEmi, 2, '.', ''),
                'emi' => number_format($emiTotal, 2, '.', ''),
                'bal_principal' => number_format($remainingPrincipal, 2, '.', ''),
            ];
        }

        // Totals for footer
        $totalPrincipal = array_sum(array_map(fn($r) => floatval($r['principal']), $schedule));
        $totalInterest = array_sum(array_map(fn($r) => floatval($r['interest']), $schedule));
        $totalCharges = array_sum(array_map(fn($r) => floatval($r['charges_per_emi']), $schedule));
        $totalEmi = array_sum(array_map(fn($r) => floatval($r['emi']), $schedule));

        return view('daily_weekly.applications.view-buttons.show-emi-chart', compact(
            'application',
            'loanAmount',
            'disburseDate',
            'processingFeeInc',
            'stampDutyInc',
            'insuranceInc',
            'fitnessInc',
            'tenure',
            'periodName',
            'periodUnit',
            'chargesPerEmi',
            'schedule',
            'totalPrincipal',
            'totalInterest',
            'totalCharges',
            'totalEmi'
        ));
    }

    public function disbursment($id)
    {
        $application = DailyWeeklyApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        return view("daily_weekly.applications.view-buttons.disburse-setting", compact('application'));
    }

    public function submitForApproval($id)
    {
        // Fetch the relevant model — change LoanApplication to appropriate model if many models share same button.
        $application = DailyWeeklyApplication::findOrFail($id);

        // Do NOT change status. Only update updated_at to current time so it becomes "latest"
        // Option A: touch() updates updated_at automatically
        $application->touch();

        return redirect()->route('loans')
            ->with('success', 'Submitted for approval!');

    }


}
