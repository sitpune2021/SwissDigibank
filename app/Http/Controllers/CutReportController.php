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
//use App\Models\Shareholding;
use App\Models\Shareholding;
use App\Models\Promotor;
use App\Models\Scheme;
use App\Models\ShareTransfer;
use Illuminate\Support\Facades\Response;
use Mpdf\Mpdf;

use Barryvdh\DomPDF\Facade\Pdf;

class CutReportController extends Controller
{

    // Promoters/Members Cut Reports start here
    public function promoterMemberIndex()
    {
        $members = Member::with(['promotor', 'branch'])->orderBy('id', 'desc')->paginate(10);
    
        return view('cut-reports.report.promoter-member', compact('members'));
    }

    public function promoterMemberSearchBox(Request $request)
    {
        $query = Member::with(['promotor', 'branch']);

        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->member_no) {
            $query->where('member_no', 'LIKE', '%' . $request->member_no . '%');
        }

        if ($request->first_name) {
            $query->where('member_info_first_name', 'LIKE', '%' . $request->first_name . '%');
        }

        if ($request->last_name) {
            $query->where('member_info_last_name', 'LIKE', '%' . $request->last_name . '%');
        }

        if ($request->account_no) {
            $query->where('account_no', 'LIKE', '%' . $request->account_no . '%');
        }

        if ($request->mobile_no) {
            $query->where('member_info_mobile', 'LIKE', '%' . $request->mobile_no . '%');
        }

        $members = $query->orderBy('id', 'desc')->paginate(10);
        $branches = Branch::all();

        return view('cut-reports.report.promoter-member', compact('members', 'branches'));
    }

    public function downloadPromoterMemberCsv()
    {
        $members = Member::with(['promotor', 'branch'])->orderBy('id', 'desc')->get();

        $filename = 'promoter_members_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Member No', 'Member Name', 'Branch', 'KYC Status', 'Enrollment Date', 'Status'];

        $callback = function () use ($members, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($members as $member) {
                fputcsv($file, [
                    $member->member_no ?? '',
                    ($member->member_info_first_name ?? '') . ' ' . ($member->member_info_last_name ?? ''),
                    $member->branch->branch_name ?? 'N/A',
                    strtoupper($member->status) ?? 'N/A',
                    $member->general_enrollment_date ? date('d-m-Y', strtotime($member->general_enrollment_date)) : 'N/A',
                    $member->is_active ? 'Active' : 'Inactive',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Promoters/Members Cut Reports start here

    // shareHoldingIndex Cut Reports start here
    public function shareHoldingIndex()
    {
        $promoters = Promotor::with('latestShare')->orderBy('id', 'desc')->paginate(10);
        return view('cut-reports.report.share-holding', compact('promoters'));
    }

    public function shareAllotmentSearchBox(Request $request)
    {

        $from = $request->from_date;
        $to   = $request->to_date;

        // Base query
        $promoters = Promotor::with(['latestShare'])
            ->when($from && $to, function ($query) use ($from, $to) {

                // Convert DD/MM/YYYY → YYYY-MM-DD
                $fromDate = \Carbon\Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
                $toDate   = \Carbon\Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');

                $query->whereHas('latestShare', function ($q) use ($fromDate, $toDate) {
                    $q->whereBetween('allotment_date', [$fromDate, $toDate]);
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('cut-reports.report.share-holding', compact('promoters'));
    }

    public function downloadPromoterCSV(Request $request)
    {

        $records = Promotor::with('latestShare')->get();

        $filename = 'promoter_holdings_report_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $columns = [
            'MEMBER',
            'SHARE RANGE',
            'TOTAL SHARES',
            'NOMINAL VAL.',
            'TOTAL SHARE VAL.',
            'ALLOTMENT DATE',
            'TRANSFER DATE',
        ];

        $callback = function () use ($records, $columns) {
            $file = fopen('php://output', 'w');

            // Add heading row
            fputcsv($file, $columns);

            foreach ($records as $promoter) {

                $share = $promoter->latestShare;

                fputcsv($file, [
                    // MEMBER NAME
                    strtoupper($promoter->first_name . ' ' . $promoter->last_name),

                    // SHARE RANGE
                    ($share->first_share ?? '') . ' - ' . ($share->share_no ?? ''),

                    // TOTAL SHARES
                    $share->total_share_held ?? '',

                    // NOMINAL VAL
                    $share->nominal_value ?? '',

                    // TOTAL SHARE VAL
                    $share->total_share_value ?? '',

                    // ALLOTMENT DATE → d-m-Y
                    $share && $share->allotment_date
                        ? date('d-m-Y', strtotime($share->allotment_date))
                        : '',

                    // TRANSFER DATE (transaction_date) → d-m-Y
                    $share && $share->transaction_date
                        ? date('d-m-Y', strtotime($share->transaction_date))
                        : '',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    // shareHoldingIndex Cut Reports start here

    // shareHoldingIndex Cut Reports start here
    public function shareTransferHistoryIndex()
    {
        $shareTransfers = ShareTransfer::with(['promotor', 'members'])->paginate(10);
        return view('cut-reports.report.share-transfer-history', compact('shareTransfers'));
    }
    
    public function downloadShareTransferHistoryCsv()
    {
        $shareTransfers = ShareTransfer::with(['promotor', 'members'])->get();

        $filename = "share-transfer-history.csv";

        $columns = [
            'Business Type',
            'Transferor',
            'Transferee',
            'Share Range',
            'Nominal Value',
            'No. of Shares',
            'Date of Transfer',
            'New Share'
        ];

        $callback = function () use ($shareTransfers, $columns) {
            $file = fopen('php://output', 'w');

            // Write headers
            fputcsv($file, $columns);

            foreach ($shareTransfers as $s) {
                fputcsv($file, [
                    $s->business_type ?? '',
                    optional($s->members)->member_info_first_name . ' ' . optional($s->members)->member_info_last_name,
                    optional($s->promotor)->first_name . ' ' . optional($s->promotor)->last_name,
                    "'" . ($s->from_share_no ?? '') . " - " . ($s->to_share_no ?? ''),
                    $s->face_value ?? '',
                    $s->total_consideration ?? '',
                    $s->date_of_transfer ?? '',
                    $s->certificate_number ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }

    public function shareTransferHistorySearchBox(Request $request)
    {
        // VALIDATION
        $request->validate([
            'from_date' => 'required|date_format:d-m-Y',
            'to_date' => 'required|date_format:d-m-Y',
        ]);

        $from = $request->from_date;
        $to   = $request->to_date;
        // CONVERT FROM dd-mm-yyyy TO yyyy-mm-dd
        $fromDate = \Carbon\Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $toDate   = \Carbon\Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');

        // FETCH DATA
        $shareTransfers = ShareTransfer::with(['members', 'promotor'])
            ->whereDate('transfer_date', '>=', $fromDate)
            ->whereDate('transfer_date', '<=', $toDate)
            ->orderBy('transfer_date', 'DESC')
            ->get();

        return view('cut-reports.report.share-transfer-history', compact('shareTransfers'));
    }

     private function getMarathiMpdf()
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $fontData['marathi'] = [
            'R' => 'TiroDevanagariMarathi-Regular.ttf',
            'B' => 'TiroDevanagariMarathi-Italic.ttf',
        ];

        return new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
            'fontdata' => $fontData,
            'default_font' => 'marathi',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
    }


    // shareHoldingIndex Cut Reports start here

    // Saving Account Cut Reports start here

    public function savingacc_index()
    {
        $account = Account::with(['members', 'branch'])->orderBy('id', 'desc')->paginate(10);

        return view('cut-reports.report.saving-account', compact('account'));
    }

    public function savingIndex()
    {
        $associates = Account::select(
            'accounts.id',
            'accounts.account_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-saving', $data)->render();
        // $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        // $mpdf = new \Mpdf\Mpdf([
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
        //     'fontdata' => $fontData + [
        //         'mukta' => [
        //             'R' => 'TiroDevanagariMarathi-Regular.ttf',
        //             'B' => 'Mukta-Bold.ttf',
        //         ]
        //     ],
        //     'default_font' => 'mukta',
        // ]);

        // $mpdf->SetAutoPageBreak(true, 10);
        // $mpdf->WriteHTML($html);

        $mpdf = $this->getMarathiMpdf();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('cut-report-saving.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }

    public function printSaving()
    {
        
        $associates = Account::select(
            'accounts.id',
            'accounts.account_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-saving', $data)->render();
        $mpdf = $this->getMarathiMpdf();
        $mpdf->SetJS('this.print();'); // auto open print dialog
        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output('saving-report.pdf', 'I')
        )->header('Content-Type', 'application/pdf');
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
        $account = FdAccount::with(['member', 'branch', 'fdscheme.fdslabs'])->orderBy('id', 'desc')->paginate(10);
        return view('cut-reports.report.fd-account', compact('account'));
    }

    public function FDIndex()
    {
        $associates = FdAccount::select(
            'fd_accounts.id',
            'fd_accounts.fd_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-fd', $data)->render();
        // $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        // $mpdf = new \Mpdf\Mpdf([
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
        //     'fontdata' => $fontData + [
        //         'mukta' => [
        //             'R' => 'TiroDevanagariMarathi-Regular.ttf',
        //             'B' => 'Mukta-Bold.ttf',
        //         ]
        //     ],
        //     'default_font' => 'mukta',
        // ]);

        // $mpdf->SetAutoPageBreak(true, 10);
        // $mpdf->WriteHTML($html);
        $mpdf = $this->getMarathiMpdf();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('cut-report-fd_account.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }

     public function printFd()
    {
        
        $associates = FdAccount::select(
            'fd_accounts.id',
            'fd_accounts.fd_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-fd', $data)->render();
      
        $mpdf = $this->getMarathiMpdf();
        $mpdf->SetJS('this.print();'); // auto open print dialog
        $mpdf->WriteHTML($html);

       
        return response($mpdf->Output('cut-report-fd_account.pdf', 'I'))
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
        $account = Misaccount::with(['member', 'branch', 'fdScheme.fdslabs'])->orderBy('id', 'desc')->paginate(10);
        return view('cut-reports.report.mis-account', compact('account'));
    }

    public function misIndex()
    {
        $associates = Misaccount::select(
            'misaccounts.id',
            'misaccounts.mis_account_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-mis', $data)->render();
        // $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        // $mpdf = new \Mpdf\Mpdf([
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
        //     'fontdata' => $fontData + [
        //         'mukta' => [
        //             'R' => 'TiroDevanagariMarathi-Regular.ttf',
        //             'B' => 'Mukta-Bold.ttf',
        //         ]
        //     ],
        //     'default_font' => 'mukta',
        // ]);

        // $mpdf->SetAutoPageBreak(true, 10);
        // $mpdf->WriteHTML($html);

        $mpdf = $this->getMarathiMpdf();
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('cut-report-mis_account.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }



     public function printMis()
    {
       
        $associates = Misaccount::select(
            'misaccounts.id',
            'misaccounts.mis_account_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-mis', $data)->render();
    
        $mpdf = $this->getMarathiMpdf();
        $mpdf->SetJS('this.print();'); // auto open print dialog
        $mpdf->WriteHTML($html);

       
        return response($mpdf->Output('cut-report-fd_account.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

    public function downloadMisCsv()
    {
        $accounts = Misaccount::with(['member', 'branch', 'fdscheme'])
            ->orderBy('id', 'desc')
            ->get();

        $filename = "mis_accounts_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename"
        ];

        return response()->stream(function () use ($accounts) {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM (Fixes Marathi/Hindi text in Excel)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV HEADERS
            fputcsv($file, [
                'MIS NO',
                'MEMBER NAME',
                'BRANCH',
                'SCHEME',
                'INTEREST PAYOUT',
                'PRINCIPAL AMOUNT',
                'OPEN DATE',
                'MATURITY DATE',
                'STATUS'
            ]);

            // ROWS
            foreach ($accounts as $row) {

                $memberName = trim(($row->member->member_info_first_name ?? '') . ' ' . ($row->member->member_info_last_name ?? ''));

                $scheme = trim(($row->fdscheme->scheme_name ?? '') . ' ' . ($row->fdscheme->scheme_code ?? ''));

                fputcsv($file, [
                    $row->mis_account_no ?? '',
                    $memberName,
                    $row->branch->branch_name ?? '',
                    $scheme,
                    $row->interest_payout_type ?? '',
                    $row->mis_amount ?? '',
                    $row->open_date
                        ? '="' . date('d-m-Y', strtotime($row->open_date)) . '"'
                        : '',
                    $row->maturity_date
                        ? '="' . date('d-m-Y', strtotime($row->maturity_date)) . '"'
                        : '',
                    ucfirst($row->final_status ?? '')
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    // MIS Account Cut Reports End here


    // DD Account Cut Reports Start here
    public function ddaccount_index()
    {
        $account = DdsAccount::with(['member', 'branch', 'scheme'])->orderBy('id', 'desc')->paginate(10);
        return view('cut-reports.report.dd-accounts', compact('account'));
    }

    public function ddIndex()
    {
        $associates = DdsAccount::with(['member', 'branch', 'scheme'])
            ->get()
            ->map(function ($item, $key) {
                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                return [
                    'sr_no' => $key + 1,
                    'dd_account_no' => $item->dd_no,
                    'name' => $item->member->member_info_first_name ?? '',
                    'last_name' => $item->member->member_info_last_name ?? '',
                    'branch_name' => $item->branch->branch_name ?? '',
                    'scheme_name' => $item->scheme->scheme_name ?? '',
                    'scheme_code' => $item->scheme->scheme_code ?? '',
                    'dd_amount' => $item->dd_amount ?? 0,
                    'amount' => is_array($balance) && isset($balance['total_balance'])
                        ? (float) $balance['total_balance']
                        : 0,
                    'open_date' => $item->open_date ? \Carbon\Carbon::parse($item->open_date)->format('d-m-Y') : '',
                    'maturity_date' => $item->maturity_date ? \Carbon\Carbon::parse($item->maturity_date)->format('d-m-Y') : '',
                    'rr_dd_frequency' => $item->scheme->rr_dd_frequency ?? '',
                    'final_status' => $item->final_status ?? '',
                ];
            });

        $totalAmount = $associates->sum('amount');

        $data = [
            'company' => ['name' => Company::first()->company_name ?? 'SBC GLOBAL'],
            'associates' => $associates,
            'totalAmount' => $totalAmount,
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-dd', $data)->render();

        // $mpdf = new \Mpdf\Mpdf([
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [storage_path('fonts')]),
        //     'fontdata' => (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'] + [
        //         'mukta' => [
        //             'R' => 'TiroDevanagariMarathi-Regular.ttf',
        //             'B' => 'Mukta-Bold.ttf',
        //         ]
        //     ],
        //     'default_font' => 'mukta',
        // ]);

        // $mpdf->SetAutoPageBreak(true, 10);
        // $mpdf->WriteHTML($html);

        $mpdf = $this->getMarathiMpdf();
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('cut-report-dd_account.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }

    
     public function printDD()
    {
       
        
        $associates = DdsAccount::with(['member', 'branch', 'scheme'])
            ->get()
            ->map(function ($item, $key) {
                $balance = AccountsTransactionsHelper::getAccountBalacec($item->id);

                return [
                    'sr_no' => $key + 1,
                    'dd_account_no' => $item->dd_no,
                    'name' => $item->member->member_info_first_name ?? '',
                    'last_name' => $item->member->member_info_last_name ?? '',
                    'branch_name' => $item->branch->branch_name ?? '',
                    'scheme_name' => $item->scheme->scheme_name ?? '',
                    'scheme_code' => $item->scheme->scheme_code ?? '',
                    'dd_amount' => $item->dd_amount ?? 0,
                    'amount' => is_array($balance) && isset($balance['total_balance'])
                        ? (float) $balance['total_balance']
                        : 0,
                    'open_date' => $item->open_date ? \Carbon\Carbon::parse($item->open_date)->format('d-m-Y') : '',
                    'maturity_date' => $item->maturity_date ? \Carbon\Carbon::parse($item->maturity_date)->format('d-m-Y') : '',
                    'rr_dd_frequency' => $item->scheme->rr_dd_frequency ?? '',
                    'final_status' => $item->final_status ?? '',
                ];
            });

        $totalAmount = $associates->sum('amount');

        $data = [
            'company' => ['name' => Company::first()->company_name ?? 'SBC GLOBAL'],
            'associates' => $associates,
            'totalAmount' => $totalAmount,
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-dd', $data)->render();

        $mpdf = $this->getMarathiMpdf();
        $mpdf->SetJS('this.print();'); // auto open print dialog
        $mpdf->WriteHTML($html);

       return response($mpdf->Output('cut-report-dd_account.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

    public function ddAccountCsv()
    {
        $accounts = DdsAccount::with(['member', 'branch', 'scheme'])
            ->orderBy('id', 'desc')
            ->get();

        $filename = "dd_accounts_report_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            "DD NO",
            "MEMBER",
            "BRANCH",
            "ASSOCIATE",
            "COLLECTOR",
            "SCHEME",
            "AMOUNT",
            "OPEN DATE",
            "MATURITY DATE",
            "FREQUENCY",
            "STATUS"
        ];

        $callback = function () use ($accounts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($accounts as $row) {
                fputcsv($file, [
                    $row->dd_account_no,
                    $row->member->member_info_first_name . ' ' . $row->member->member_info_last_name,
                    $row->branch->branch_name ?? '',
                    '', // associate
                    '', // collector
                    ($row->scheme->scheme_name ?? '') . ' ' . ($row->scheme->scheme_code ?? ''),
                    $row->dd_amount,
                    $row->open_date
                        ? "=\"" . \Carbon\Carbon::parse($row->open_date)->format('d-m-Y') . "\""
                        : '',

                    $row->maturity_date
                        ? "=\"" . \Carbon\Carbon::parse($row->maturity_date)->format('d-m-Y') . "\""
                        : '',
                    $row->scheme->rr_dd_frequency ?? '',
                    $row->final_status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // DD Account Cut Reports End here


    // RD Account Cut Reports Start here

    public function rd_account_index()
    {
        $account = RdAccount::with(['member', 'branch', 'scheme'])->orderBy('id', 'desc')->paginate(10);
        return view('cut-reports.report.rd-account', compact('account'));
    }
    //  Download Pdf
    public function rdIndex()
    {
        $associates = RdAccount::select(
            'rd_accounts.id',
            'rd_accounts.rd_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
            'members.member_info_title as title',
        )
            ->leftJoin('members', 'members.id', '=', 'rd_accounts.member_id')
            ->get();

        $associates = collect($associates)->map(function ($item, $key) {
            $item->sr_no = $key + 1;
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-rd', $data)->render();
        // $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        // $mpdf = new \Mpdf\Mpdf([
        //     'format' => 'A4',
        //     'margin_left' => 10,
        //     'margin_right' => 10,
        //     'margin_top' => 10,
        //     'margin_bottom' => 10,
        //     'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
        //     'fontdata' => $fontData + [
        //         'mukta' => [
        //             'R' => 'TiroDevanagariMarathi-Regular.ttf',
        //             'B' => 'Mukta-Bold.ttf',
        //         ]
        //     ],
        //     'default_font' => 'mukta',
        // ]);

        // $mpdf->SetAutoPageBreak(true, 10);
        // $mpdf->WriteHTML($html);

        $mpdf = $this->getMarathiMpdf();
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('cut-report-rd_account.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }

      public function printRD()
    {
       
        
        $associates = RdAccount::select(
            'rd_accounts.id',
            'rd_accounts.rd_no',
            'members.member_info_first_name as name',
            'members.member_info_last_name as last_name',
            'members.member_info_title as title',
        )
            ->leftJoin('members', 'members.id', '=', 'rd_accounts.member_id')
            ->get();

        $associates = collect($associates)->map(function ($item, $key) {
            $item->sr_no = $key + 1;
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
            'photoPath' => public_path('assets/images/SBC_Logo_gpg.jpg'),
        ];

        $html = view('cut-reports.pdf.cut-report-rd', $data)->render();

        $mpdf = $this->getMarathiMpdf();
        $mpdf->SetJS('this.print();'); // auto open print dialog
        $mpdf->WriteHTML($html);

       return response($mpdf->Output('cut-report-rd_account.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

    // Download CSV
    public function rdAccountCsv()
    {
        $accounts = RdAccount::with(['member', 'branch', 'scheme'])
            ->orderBy('id', 'desc')
            ->get(); // export ALL records

        $filename = "rd_accounts_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            "RD NO.",
            "MEMBER",
            "ASSOCIATE",
            "COLLECTOR",
            "MOBILE NO",
            "BRANCH",
            "SCHEME",
            "AMOUNT",
            "OPEN DATE",
            "MATURITY DATE",
            "FREQUENCY",
            "STATUS",
        ];

        $callback = function () use ($accounts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($accounts as $row) {
                fputcsv($file, [
                    $row->rd_no ?? '',
                    ($row->member->member_info_first_name ?? '') . ' ' . ($row->member->member_info_last_name ?? ''),
                    '', // associate
                    '', // collector
                    $row->member->member_info_mobile_no ?? '',
                    $row->branch->branch_name ?? '',
                    ($row->scheme->scheme_name ?? '') . ' ' . ($row->scheme->scheme_code ?? ''),
                    $row->rd_amount ?? '',

                    // Prevent Excel auto-formatting
                    $row->open_date
                        ? "=\"" . \Carbon\Carbon::parse($row->open_date)->format('d-m-Y') . "\""
                        : '',

                    $row->maturity_date
                        ? "=\"" . \Carbon\Carbon::parse($row->maturity_date)->format('d-m-Y') . "\""
                        : '',

                    $row->scheme->rr_dd_frequency ?? '',
                    $row->final_status ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
        foreach ($goldLoan as $loan) {

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
        foreach ($goldLoan as $loan) {

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
        foreach ($goldLoan as $loan) {

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
        foreach ($goldLoan as $loan) {

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
        foreach ($goldLoan as $loan) {

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
        foreach ($goldLoan as $loan) {

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
        foreach ($goldLoan as $loan) {

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

        return view('cut-reports.report.loan_report.vehicle-loan', compact('goldLoan', 'branches'));
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
        foreach ($goldLoan as $loan) {

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


    public function printMembers()
{
      $members = Member::with([
        'branch',
        'kyc'
    ])->get();

    $pdf = Pdf::loadView(
        'cut-reports.pdf.promoter-member-cut-report',
        compact('members')
    )->setPaper('A4','portrait');

    $pdf->getDomPDF()->getCanvas()->get_cpdf()->addJavascript("print(true);");

    return $pdf->stream('all-members.pdf');
}
}
