<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;

class AdvisorController extends Controller
{
    public function index()
    {
        return view('associates-advisor.rank-structure.index');
    }
    public function add_new_rank()
    {
        return view('associates-advisor.rank-structure.add-new-rank');
    }
    public function view_rank()
    {
        return view('associates-advisor.rank-structure.view');
    }
    public function add_adc_asc()
    {
        return view('associates-advisor.associates-advisors.add');
    }
    public function adv_index()
    {
        return view('associates-advisor.associates-advisors.index');
    }
    public function adv_view()
    {
        return view('associates-advisor.associates-advisors.view');
    }
    public function change_photo()
    {
        return view('associates-advisor.associates-advisors.change-photo');
    }
    public function link_saving_account()
    {
        return view('associates-advisor.associates-advisors.link-saving-account');
    }
    public function reset_password()
    {
        return view('associates-advisor.associates-advisors.reset-password');
    }
    public function commission_index()
    {
        return view('associates-advisor.commission-payout.index');
    }
    public function new_com_pay()
    {
        return view('associates-advisor.commission-payout.new-com-pay');
    }
    public function com_view()
    {
        return view('associates-advisor.commission-payout.view');
    }
    public function multiple_payout()
    {
        return view('associates-advisor.commission-payout.multiple-payout');
    }
    public function regenerate_com()
    {
        return view('associates-advisor.commission-payout.regenerate-com');
    }
    public function remove_payout_com()
    {
        return view('associates-advisor.commission-payout.remove-payout-com');
    }
    public function commission_charts_index()
    {
        return view('associates-advisor.commission-charts.index');
    }
    public function add_chart()
    {
        return view('associates-advisor.commission-charts.add-chart');
    }
    public function comission_view()
    {
        return view('associates-advisor.commission-charts.view');
    }
    public function show()
    {
        // Replace with database call or real data
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED',
                'address' => 'SHEGAON SHEGAON Maharashtra - 110012',
                'cin' => '969/03-04',
                'email' => 'sbcglobalbank@gmail.com',
                'phone' => '9922870805',
            ],
            'associate' => [
                'code' => 'AGT00016',
                'joining_date' => '18-03-2025',
                'rank' => ' SALES EXECUTIVE
 OFFICER/BUSINESS
 PARTNER',
                'supervisor' => '',
                'employee_code' => 'EMP00024',
                'user_id' => 'nitin123',
            ],
            'personal' => [
                'name' => 'NITIN ILLARKAR',
                'father_name' => 'MANIKRAO GANPAT ILLARKAR',
                'dob' => '12-09-1986',
                'reference_by' => '',
            ],
            'kyc' => [
                'address' => 'MATA NAGAR RAMDAS PETH POLICE STATION AKOLA',
                'aadhaar' => '593173951757',
                'pan' => 'AFGPI3017Q',
            ],
            'contact' => [
                'mobile' => '9011446171',
                'email' => '',
            ],
            'nominee' => [
                'name' => 'PRAGATI NITIN ILLARKAR',
                'relation' => 'Spouse',
                'address' => 'MATA NAGAR RAMDDAS PETH POLICE STATION AKOLA',
            ],
            'remarks' => '',
        ];

        return view('associates-advisor.pdf.joining-form', $data);
    }


    public function download()
    {
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED',
                'address' => 'SHEGAON SHEGAON Maharashtra - 110012',
                'cin' => '969/03-04',
                'email' => 'sbcglobalbank@gmail.com',
                'phone' => '9922870805',
            ],
            'associate' => [
                'code' => 'AGT00016',
                'joining_date' => '18-03-2025',
                'rank' => 'SALES EXECUTIVE OFFICER/BUSINESS PARTNER',
                'supervisor' => '',
                'employee_code' => 'EMP00024',
                'user_id' => 'nitin123',
            ],
            'personal' => [
                'name' => 'NITIN ILLARKAR',
                'father_name' => 'MANIKRAO GANPAT ILLARKAR',
                'dob' => '12-09-1986',
                'reference_by' => '',
            ],
            'kyc' => [
                'address' => 'MATA NAGAR RAMDAS PETH POLICE STATION AKOLA',
                'aadhaar' => '593173951757',
                'pan' => 'AFGPI3017Q',
            ],
            'contact' => [
                'mobile' => '9011446171',
                'email' => '',
            ],
            'nominee' => [
                'name' => 'PRAGATI NITIN ILLARKAR',
                'relation' => 'Spouse',
                'address' => 'MATA NAGAR RAMDDAS PETH POLICE STATION AKOLA',
            ],
            'remarks' => '',
        ];

        $pdf = Pdf::loadView('associates-advisor.pdf.joining-form', $data)
            ->setPaper('a4', 'portrait');

        // Download file with custom filename
        $filename = 'joining-form-' . $data['associate']['code'] . '.pdf';

        return $pdf->download($filename);

    }
    // use at top: use PDF; (if using barryvdh/laravel-dompdf)
// composer require barryvdh/laravel-dompdf (if not installed)


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
    public function cut_report_fd()
    {
        // Data for the PDF
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED'
            ],
            'associates' => [
                [
                    'sr_no' => 1,
                    'account_no' => 'FD00013',
                    'name' => 'Mrs. NISHA SWAPNIL THAKARE',
                    'amount' => '100082.19',
                    'shillak' => 'िशल्लक'
                ]
            ],
            'totals' => [
                'amount' => '122222.00',
            ],
            'photoPath' => public_path('assets/images/sbc-image.jpg')
        ];

        // Render Blade HTML
        $html = view('associates-advisor.pdf.cut-report-fd', $data)->render();
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
                    // include other weights if needed
                ]
            ],
            'default_font' => 'mukta',
        ]);

        $mpdf->SetAutoPageBreak(true, 10);
        $mpdf->WriteHTML($html);

        // Stream PDF to browser
        return response($mpdf->Output('cut-report-fd.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }
  public function cut_report_rd()
    {
        // Data for the PDF
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED'
            ],
            'associates' => [
                [
                    'sr_no' => 1,
                    'account_no' => 'RD00013',
                    'name' => 'Mrs. NISHA SWAPNIL THAKARE',
                    'amount' => '100082.19',
                    'shillak' => 'िशल्लक'
                ]
            ],
            'totals' => [
                'amount' => '122222.00',
            ],
            'photoPath' => public_path('assets/images/sbc-image.jpg')
        ];

        // Render Blade HTML
        $html = view('associates-advisor.pdf.cut-report-rd', $data)->render();
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
                    // include other weights if needed
                ]
            ],
            'default_font' => 'mukta',
        ]);

        $mpdf->SetAutoPageBreak(true, 10);
        $mpdf->WriteHTML($html);

        // Stream PDF to browser
        return response($mpdf->Output('cut-report-rd.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }

    
  public function cut_report_mis()
    {
        // Data for the PDF
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED'
            ],
            'associates' => [
                [
                    'sr_no' => 1,
                    'account_no' => 'MIS00013',
                    'name' => 'Mrs. NISHA SWAPNIL THAKARE',
                    'amount' => '100082.19',
                    'shillak' => 'िशल्लक'
                ]
            ],
            'totals' => [
                'amount' => '122222.00',
            ],
            'photoPath' => public_path('assets/images/sbc-image.jpg')
        ];

        // Render Blade HTML
        $html = view('associates-advisor.pdf.cut-report-mis', $data)->render();
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
                    // include other weights if needed
                ]
            ],
            'default_font' => 'mukta',
        ]);

        $mpdf->SetAutoPageBreak(true, 10);
        $mpdf->WriteHTML($html);

        // Stream PDF to browser
        return response($mpdf->Output('cut-report-mis.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

     public function cut_report_saving()
    {
        // Data for the PDF
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED'
            ],
            'associates' => [
                [
                    'sr_no' => 1,
                    'account_no' => 'S00013',
                    'name' => 'Mrs. NISHA SWAPNIL THAKARE',
                    'amount' => '100082.19',
                    'shillak' => 'िशल्लक'
                ]
            ],
            'totals' => [
                'amount' => '122222.00',
            ],
            'photoPath' => public_path('assets/images/sbc-image.jpg')
        ];

        // Render Blade HTML
        $html = view('associates-advisor.pdf.cut-report-saving', $data)->render();
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
                    // include other weights if needed
                ]
            ],
            'default_font' => 'mukta',
        ]);

        $mpdf->SetAutoPageBreak(true, 10);
        $mpdf->WriteHTML($html);

        // Stream PDF to browser
        return response($mpdf->Output('cut-report-saving.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }
    public function cut_report_dd()
    {
        // Data for the PDF
        $data = [
            'company' => [
                'name' => 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED'
            ],
            'associates' => [
                [
                    'sr_no' => 1,
                    'account_no' => 'DD00042',
                    'name' => 'Mrs. NISHA SWAPNIL THAKARE',
                    'amount' => '100082.19',
                    'shillak' => 'िशल्लक'
                ]
            ],
            'totals' => [
                'amount' => '122222.00',
            ],
            'photoPath' => public_path('assets/images/sbc-image.jpg')
        ];

        // Render Blade HTML
        $html = view('associates-advisor.pdf.cut-report-dd', $data)->render();
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
                    // include other weights if needed
                ]
            ],
            'default_font' => 'mukta',
        ]);

        $mpdf->SetAutoPageBreak(true, 10);
        $mpdf->WriteHTML($html);

        // Stream PDF to browser
        return response($mpdf->Output('cut-report-dd.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    } 
}
