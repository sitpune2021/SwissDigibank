<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsTransactionsHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Company;
use App\Models\DdsAccount;
use App\Models\FdAccount;
use App\Models\Misaccount;
use App\Models\RdAccount;
use App\Models\LoanApplication;
use App\Models\MortgageLoanApplication;
use App\Models\LoanAgainstApplication;
use App\Models\BusinessLoanApplication;
use App\Models\PersonalLoanApplication;
use App\Models\DailyWeeklyApplication;
use App\Models\VehicalApplication;
use App\Models\CcOdLoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;

class CutReportController extends Controller
{

    // Saving Account Cut Reports start here

        public function savingacc_index()
        {
            $account = Account::with(['members', 'branch'])->orderBy('id', 'desc')->get();

            return view('cut-reports.report.saving-account', compact('account'));
        }

        public function savingIndex()
        {
            $associates = Account::select(
                'accounts.id',
                'accounts.account_no',
                'members.member_info_first_name as name',
                'members.member_info_first_name as last_name',
                'members.member_info_title as title'
            )
                ->leftJoin('members', 'members.id', '=', 'accounts.member_id')
                ->get();

            $associates = collect($associates)->map(function ($item) {

                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                // If helper returns array
                if (is_array($balance) && isset($balance['total_balance'])) {
                    $item->amount = (float) $balance['total_balance'];
                } else {
                    $item->amount = 0; // fallback
                }

                return $item;
            });

            $totalAmount = $associates->sum('amount');
            $data = [
                'company' => [
                    'name' => Company::first()->company_name ?? 'SBC GLOBAL'
                ],
                'associates' => $associates,
                'totalAmount' =>  $totalAmount,
                'photoPath' => public_path('assets/images/sbc-image.jpg'),
            ];

            $html = view('cut-reports.pdf.cut-report-saving', $data)->render();
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
                'fontdata' => $fontData + [
                    'mukta' => [
                        'R' => 'TiroDevanagariMarathi-Regular.ttf',
                        'B' => 'Mukta-Bold.ttf',
                    ]
                ],
                'default_font' => 'mukta',
            ]);

            $mpdf->SetAutoPageBreak(true, 10);
            $mpdf->WriteHTML($html);

            return response($mpdf->Output('cut-report-saving.pdf', 'D'))
                ->header('Content-Type', 'application/pdf');
        }

        public function exportCsv()
        {
            $accounts = Account::with(['members', 'branch'])->get();

            $filename = "accounts_" . date('Ymd_His') . ".csv";

            $columns = [
                "Account No",
                "Member Name",
                "Branch",
                "Enrollment Date",
                "Status"
            ];

            $callback = function () use ($accounts, $columns) {

                $file = fopen('php://output', 'w');

                fputcsv($file, $columns);

                foreach ($accounts as $row) {
                    fputcsv($file, [
                        $row->account_no,
                        $row->members->full_name ?? '',
                        $row->branch->branch_name ?? '',
                        optional($row->members)->general_enrollment_date
                            ? \Carbon\Carbon::parse($row->members->general_enrollment_date)->format('d-m-Y')
                            : '',
                        $row->final_status ?? '',
                    ]);
                }

                fclose($file);
            };

            return response()->streamDownload($callback, $filename, [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename={$filename}",
            ]);
        }

    // Saving Account Cut Reports end here


    // FD Account Cut Reports Start here

        public function fdaccount_index()
        {
            $account = FdAccount::with(['member', 'branch', 'fdscheme.fdslabs'])->orderBy('id', 'desc')->get();
            return view('cut-reports.report.fd-account', compact('account'));
        }
        
        public function FDIndex()
        {
            $associates = FdAccount::select(
                'fd_accounts.id',
                'fd_accounts.fd_no',
                'members.member_info_first_name as name',
                'members.member_info_first_name as last_name',
                'members.member_info_title as title',
            )
                ->leftJoin('members', 'members.id', '=', 'fd_accounts.member_id')
                ->get();

            $associates = collect($associates)->map(function ($item) {

                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                // If helper returns array
                if (is_array($balance) && isset($balance['total_balance'])) {
                    $item->amount = (float) $balance['total_balance'];
                } else {
                    $item->amount = 0; // fallback
                }

                return $item;
            });

            $totalAmount = $associates->sum('amount');
            $data = [
                'company' => [
                    'name' => Company::first()->company_name ?? 'SBC GLOBAL'
                ],
                'associates' => $associates,
                'totalAmount' =>  $totalAmount,
                'photoPath' => public_path('assets/images/sbc-image.jpg'),
            ];

            $html = view('cut-reports.pdf.cut-report-fd', $data)->render();
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
                'fontdata' => $fontData + [
                    'mukta' => [
                        'R' => 'TiroDevanagariMarathi-Regular.ttf',
                        'B' => 'Mukta-Bold.ttf',
                    ]
                ],
                'default_font' => 'mukta',
            ]);

            $mpdf->SetAutoPageBreak(true, 10);
            $mpdf->WriteHTML($html);

            return response($mpdf->Output('cut-report-fd_account.pdf', 'D'))
                ->header('Content-Type', 'application/pdf');
        }

        public function fdExportCsv()
        {
            $accounts = FdAccount::with(['member', 'branch', 'fdscheme.fdslabs'])->get();

            $filename = "fd_accounts_" . date('Ymd_His') . ".csv";

            $columns = [
                "Account No",
                "Member Name",
                "Branch",
                "Scheme",
                "Interest Payout",
                "Principal Amt",
                "Open Date",
                "Maturity Date",
                "Status"
            ];

            $callback = function () use ($accounts, $columns) {

                $file = fopen('php://output', 'w');

                fputcsv($file, $columns);

                foreach ($accounts as $row) {
                    fputcsv($file, [
                        $row->fd_no,
                        $row->member->full_name ?? '',
                        $row->branch->branch_name ?? '',
                        $row->fdscheme->scheme_name ?? '',
                        $row->interest_payout_type ?? '',
                        $row->fd_amount ?? '',
                        optional($row->maturity_date)
                            ? \Carbon\Carbon::parse($row->maturity_date)->format('d-m-Y')
                            : '',
                        optional($row->open_date)
                            ? \Carbon\Carbon::parse($row->open_date)->format('d-m-Y')
                            : '',
                        $row->final_status ?? '',
                    ]);
                }

                fclose($file);
            };

            return response()->streamDownload($callback, $filename, [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename={$filename}",
            ]);
        }

    // FD Account Cut Reports End here


    // MIS Account Cut Reports Start here

        public function misaccount_index()
        {
            $account = Misaccount::with(['member', 'branch', 'fdScheme.fdslabs'])->orderBy('id', 'desc')->get();
            return view('cut-reports.report.mis-account', compact('account'));
        }

        public function misIndex()
        {
            $associates = Misaccount::select(
                'misaccounts.id',
                'misaccounts.mis_account_no',
                'members.member_info_first_name as name',
                'members.member_info_first_name as last_name',
                'members.member_info_title as title',
            )
                ->leftJoin('members', 'members.id', '=', 'misaccounts.member_id')
                ->get();

            $associates = collect($associates)->map(function ($item) {

                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                // If helper returns array
                if (is_array($balance) && isset($balance['total_balance'])) {
                    $item->amount = (float) $balance['total_balance'];
                } else {
                    $item->amount = 0; // fallback
                }

                return $item;
            });

            $totalAmount = $associates->sum('amount');
            $data = [
                'company' => [
                    'name' => Company::first()->company_name ?? 'SBC GLOBAL'
                ],
                'associates' => $associates,
                'totalAmount' =>  $totalAmount,
                'photoPath' => public_path('assets/images/sbc-image.jpg'),
            ];

            $html = view('cut-reports.pdf.cut-report-mis', $data)->render();
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
                'fontdata' => $fontData + [
                    'mukta' => [
                        'R' => 'TiroDevanagariMarathi-Regular.ttf',
                        'B' => 'Mukta-Bold.ttf',
                    ]
                ],
                'default_font' => 'mukta',
            ]);

            $mpdf->SetAutoPageBreak(true, 10);
            $mpdf->WriteHTML($html);

            return response($mpdf->Output('cut-report-mis_account.pdf', 'D'))
                ->header('Content-Type', 'application/pdf');
        }

    // MIS Account Cut Reports End here


    // DD Account Cut Reports Start here

        public function ddaccount_index()
        {
            $account = DdsAccount::with(['member', 'branch', 'scheme'])->orderBy('id', 'desc')->get();
            return view('cut-reports.report.dd-accounts', compact('account'));
        }

        public function ddIndex()
        {
            $associates = DdsAccount::select(
                'dds_accounts.id',
                'dds_accounts.dd_no',
                'members.member_info_first_name as name',
                'members.member_info_first_name as last_name',
                'members.member_info_title as title',
            )
                ->leftJoin('members', 'members.id', '=', 'dds_accounts.member_id')
                ->get();

            $associates = collect($associates)->map(function ($item) {

                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                // If helper returns array
                if (is_array($balance) && isset($balance['total_balance'])) {
                    $item->amount = (float) $balance['total_balance'];
                } else {
                    $item->amount = 0; // fallback
                }

                return $item;
            });

            $totalAmount = $associates->sum('amount');
            $data = [
                'company' => [
                    'name' => Company::first()->company_name ?? 'SBC GLOBAL'
                ],
                'associates' => $associates,
                'totalAmount' =>  $totalAmount,
                'photoPath' => public_path('assets/images/sbc-image.jpg'),
            ];

            $html = view('cut-reports.pdf.cut-report-dd', $data)->render();
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
                'fontdata' => $fontData + [
                    'mukta' => [
                        'R' => 'TiroDevanagariMarathi-Regular.ttf',
                        'B' => 'Mukta-Bold.ttf',
                    ]
                ],
                'default_font' => 'mukta',
            ]);

            $mpdf->SetAutoPageBreak(true, 10);
            $mpdf->WriteHTML($html);

            return response($mpdf->Output('cut-report-dd_account.pdf', 'D'))
                ->header('Content-Type', 'application/pdf');
        }

    // DD Account Cut Reports End here


    // RD Account Cut Reports Start here

        public function rd_account_index()
        {
            $account = RdAccount::with(['member', 'branch', 'scheme'])->orderBy('id', 'desc')->get();
            return view('cut-reports.report.rd-account', compact('account'));
        }
        
        public function rdIndex()
        {
            $associates = RdAccount::select(
                'rd_accounts.id',
                'rd_accounts.rd_no',
                'members.member_info_first_name as name',
                'members.member_info_first_name as last_name',
                'members.member_info_title as title',
            )
                ->leftJoin('members', 'members.id', '=', 'rd_accounts.member_id')
                ->get();

            $associates = collect($associates)->map(function ($item) {

                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                // If helper returns array
                if (is_array($balance) && isset($balance['total_balance'])) {
                    $item->amount = (float) $balance['total_balance'];
                } else {
                    $item->amount = 0; // fallback
                }

                return $item;
            });

            $totalAmount = $associates->sum('amount');
            $data = [
                'company' => [
                    'name' => Company::first()->company_name ?? 'SBC GLOBAL'
                ],
                'associates' => $associates,
                'totalAmount' =>  $totalAmount,
                'photoPath' => public_path('assets/images/sbc-image.jpg'),
            ];

            $html = view('cut-reports.pdf.cut-report-rd', $data)->render();
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
                'fontdata' => $fontData + [
                    'mukta' => [
                        'R' => 'TiroDevanagariMarathi-Regular.ttf',
                        'B' => 'Mukta-Bold.ttf',
                    ]
                ],
                'default_font' => 'mukta',
            ]);

            $mpdf->SetAutoPageBreak(true, 10);
            $mpdf->WriteHTML($html);

            return response($mpdf->Output('cut-report-rd_account.pdf', 'D'))
                ->header('Content-Type', 'application/pdf');
        }

    // RD Account Cut Reports End here


    public function generateIdCardPdf()
    {
        $data = [
            'name' => 'NITIN ILLARKAR',
            'code' => 'AGT00016',
            'designation' => 'SALES EXECUTIVE OFFICE/BUSSINESS PARTNER',
            'mobile' => '9011446171',
            'blood' => 'O+',
            'branch' => 'SHEGAON',
            'address' => 'SHEGAON Maharashtra - 110012',
            'photoPath' => 'assets/images/photo.jpg',
        ];

        $pdf = PDF::loadView('associates-advisor.pdf.id-card', $data)
            ->setPaper([0, 0, 242.6, 153.0], 'landscape');
        // CR80 size (85.6mm × 53.98mm)

        return $pdf->stream('id-card.pdf');
    }

    public function downloadIdCardPdf()
    {
        $data = [
            'name' => 'NITIN ILLARKAR',
            'code' => 'AGT00016',
            'designation' => 'SALES EXECUTIVE OFFICE/BUSSINESS PARTNER',
            'mobile' => '9011446171',
            'blood' => 'O+',
            'branch' => 'SHEGAON',
            'address' => 'SHEGAON Maharashtra - 110012',
            'photoPath' => 'assets/images/photo.jpg',
        ];

        $pdf = PDF::loadView('associates-advisor.pdf.id-card', $data)
            ->setPaper([0, 0, 242.6, 153.0], 'landscape');

        // Forces download
        return $pdf->download('id-card.pdf');
    }


//////////////////////////////////////////////////////////////////////////////////////////

    // Index Page Gold Loan

    public function gold_loan_index(Request $request)
    {
        $query = LoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('gold_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('gold_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('gold_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.gold-loan-report', compact('goldLoan', 'branches'));
    }

    // CSV Downloan Gold Loan Function

    public function gold_loan_exportCsv()
    {
        $loans = LoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('gold_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('gold_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('gold_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "gold_loans_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page Mortgage Loan

    public function mortgage_index(Request $request)
    {
        $query = MortgageLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('mortgage_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('mortgage_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('mortgage_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.property-loan', compact('goldLoan', 'branches'));
    }

    // CSV Downloan Mortgage Loan
    
    public function mortgage_exportCsv()
    {
        $loans = MortgageLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('mortgage_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('mortgage_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('mortgage_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "mortgage_loans_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page Loanagainst Loan

    public function loanagainst_index(Request $request)
    {
        $query = LoanAgainstApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('loan_against_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('loan_against_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('loan_against_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.deposit-loan', compact('goldLoan', 'branches'));
    }

    // CSV Downloan Loanagainst
    
    public function loanagainst_exportCsv()
    {
        $loans = LoanAgainstApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('loan_against_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('loan_against_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('loan_against_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "loanagainst_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page Business Loan

    public function business_index(Request $request)
    {
        $query = BusinessLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('business_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('business_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('business_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.business-loan', compact('goldLoan', 'branches'));
    }

    // CSV Downloan Business
    
    public function business_exportCsv()
    {
        $loans = BusinessLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('business_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('business_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('business_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "business_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page Personal Loan

    public function personal_index(Request $request)
    {
        $query = PersonalLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('personal_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('personal_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('personal_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.personal-loan', compact('goldLoan', 'branches'));
    }

    // CSV Downloan Personal
    
    public function personal_exportCsv()
    {
        $loans = PersonalLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('personal_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('personal_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('personal_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "personal_loan_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page daily_weekly Loan

    public function daily_weekly_index(Request $request)
    {
        $query = DailyWeeklyApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.daily-weekly-loan', compact('goldLoan', 'branches'));
    }

    // CSV Downloan daily_weekly
    
    public function dailyweekly_exportCsv()
    {
        $loans = DailyWeeklyApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "dailyweekly_loan_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page vehical Loan

    public function vehical_index(Request $request)
    {
        $query = VehicalApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('vehical_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('vehical_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('vehical_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.vehical-loan', compact('goldLoan', 'branches'));
    }

    // CSV Downloan vehical
    
    public function vehical_exportCsv()
    {
        $loans = VehicalApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('vehical_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('vehical_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('vehical_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "vehical_loan_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


    // Index Page CC OD Loan

    public function cc_od_index(Request $request)
    {
        $query = CcOdLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', 2);

        // Branch Filter
        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Customer No Filter
        if ($request->customer_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('member_no', 'LIKE', "%{$request->customer_no}%");
            });
        }

        // Customer First Name Filter
        if ($request->first_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->first_name}%");
            });
        }

        // Customer Last Name Filter
        if ($request->last_name) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('last_name', 'LIKE', "%{$request->last_name}%");
            });
        }

        // Account No Filter
        if ($request->account_no) {
            $query->where('id', $request->account_no);
        }

        // Mobile No Filter
        if ($request->mobile_no) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('mobile', 'LIKE', "%{$request->mobile_no}%");
            });
        }

        // Fetch result
        $goldLoan = $query->orderBy('id', 'desc')->paginate(10);

        // --- Current Debt Calculation ---
        foreach ($goldLoan as $loan) 
        {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table('cc_od_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table('cc_od_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table('cc_od_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        // Branch List for dropdown
        $branches = Branch::orderBy('branch_name')->get();

        return view('cut-reports.report.loan_report.cc-od-limit', compact('goldLoan', 'branches'));
    }

    // CSV Downloan CC OD
    
    public function cc_od_exportCsv()
    {
        $loans = CcOdLoanApplication::with(['member', 'branch', 'scheme'])
            ->where('status', [2])
            ->orderBy('id', 'desc')
            ->get();

        // Calculate current debt for each loan (same as index function)
        foreach ($loans as $loan) {

            // Loan Amount
            $loanAmount = $loan->loan_amount;

            // Sum of EMI collected
            $collectedAmount = DB::table('cc_od_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            // Sum of other charges
            $otherCharges = DB::table('cc_od_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            // Foreclosure remaining amount
            $remainingAmount = DB::table('cc_od_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            // Final CURRENT DEBT Calculation
            $currentDebt = $loanAmount - $collectedAmount - $otherCharges - $remainingAmount;
            if ($currentDebt < 0) $currentDebt = 0;

            $loan->current_debt = $currentDebt;
        }

        $filename = "ccod_loan_" . date('Ymd_His') . ".csv";

        $columns = [
            "Branch",
            "Customer (Name - Member No)",
            "Account No",
            "Application No",
            "Scheme",
            "Open Date",
            "Status",
            "Loan Amount",
            "Current Debt"
        ];

        $callback = function () use ($loans, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->branch->branch_name ?? 'N/A',
                    ($loan->member->full_name ?? 'N/A') . ' - ' . ($loan->member->member_no ?? '---'),
                    $loan->id ?? 'N/A',
                    $loan->id ?? 'N/A',
                    $loan->scheme->scheme_name ?? 'N/A',

                    $loan->application_date
                        ? \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y')
                        : '-',

                    $loan->status == 2 ? 'Active' : 'Closed',

                    number_format($loan->loan_amount ?? 0, 2),

                    number_format($loan->current_debt ?? 0, 2),
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }


}
