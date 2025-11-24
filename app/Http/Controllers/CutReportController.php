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
use Illuminate\Http\Request;

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
    // public function fdIndex()
    // {
    //     // Data for the PDF
    //     $data = [
    //         'company' => [
    //             'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED'
    //         ],
    //         'associates' => [
    //             [
    //                 'sr_no' => 1,
    //                 'account_no' => 'FD00013',
    //                 'name' => 'Mrs. NISHA SWAPNIL THAKARE',
    //                 'amount' => '100082.19',
    //                 'shillak' => 'िशल्लक'
    //             ]
    //         ],
    //         'totals' => [
    //             'amount' => '122222.00',
    //         ],
    //         'photoPath' => public_path('assets/images/sbc-image.jpg')
    //     ];

    //     // Render Blade HTML
    //     $html = view('associates-advisor.pdf.cut-report-fd', $data)->render();
    //     $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    //     $fontDirs = $defaultConfig['fontDir'];

    //     $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    //     $fontData = $defaultFontConfig['fontdata'];

    //     $mpdf = new \Mpdf\Mpdf([
    //         'format' => 'A4',
    //         'margin_left' => 10,
    //         'margin_right' => 10,
    //         'margin_top' => 10,
    //         'margin_bottom' => 10,
    //         'fontDir' => array_merge($fontDirs, [storage_path('fonts')]),
    //         'fontdata' => $fontData + [
    //             'mukta' => [
    //                 'R' => 'TiroDevanagariMarathi-Regular.ttf',
    //                 'B' => 'Mukta-Bold.ttf',
    //                 // include other weights if needed
    //             ]
    //         ],
    //         'default_font' => 'mukta',
    //     ]);

    //     $mpdf->SetAutoPageBreak(true, 10);
    //     $mpdf->WriteHTML($html);

    //     // Stream PDF to browser
    //     return response($mpdf->Output('cut-report-fd.pdf', 'D'))
    //         ->header('Content-Type', 'application/pdf');
    // }


}
