<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CutReportController extends Controller
{

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
    public function fdIndex()
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
    public function rdIndex()
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


    public function misIndex()
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

    public function savingIndex()
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
    public function ddIndex()
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
