<?php

namespace App\Http\Controllers;

use App\Models\DdsAccount;
use App\Models\FdAccount;
use App\Models\Member;
use App\Models\Misaccount;
use App\Models\Passbook;
use App\Models\RdAccount;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
class PrintDocumentsController extends Controller
{
    public function fd_mis_bond()
    {
        return view('print-documents.fd-mis-bond.index');
    }

    public function searchBond(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account_type' => 'required|in:FD,MIS',
            'account_no' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('print-documents.fd-mis-bond.index')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->account_type === 'FD') {
            $account = FdAccount::where('account_no', $request->account_no)->first();
        } else {
            $account = Misaccount::where('mis_account_no', $request->account_no)->first();
        }

        return view('print-documents.fd-mis-bond.index', [
            'account' => $account,
            'type' => $request->account_type
        ]);
    }


    public function getAccountNumbers($type)
    {
        if ($type === 'FD') {
            return FdAccount::select('id', 'account_no')->get();
        }

        if ($type === 'MIS') {
            return Misaccount::select('id', 'mis_account_no')->get();
        }



        return response()->json([]);
    }

    // rd-dd
    public function rdDdBond()
    {
        return view('print-documents.rd-dd-bond.index', [
            'type' => null,
            'account' => null,
            'accounts' => collect(), // IMPORTANT
        ]);
        // return view('print-documents.rd-dd-bond.index');
    }

    public function getRdDdAccountNumbers($type)
    {
        if ($type === 'RD') {
            return RdAccount::select('id', 'rd_no')->get();
        }

        if ($type === 'DD') {
            return DdsAccount::select('id', 'dd_no')->get();
        }

        return response()->json([]);
    }


    public function searchRdDdBond(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'account_type' => 'required|in:RD,DD',
            'account_no' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('print.rd-dd-bond.index')
                ->withErrors($validator)
                ->withInput();
        }


        if ($request->account_type === 'RD') {
        $accounts = RdAccount::select('id', 'rd_no')->get();
        $account  = RdAccount::findOrFail($request->account_no);
    } else {
        $accounts = DdsAccount::select('id', 'dd_no')->get();
        $account  = DdsAccount::findOrFail($request->account_no);
    }

        // if ($request->account_type === 'RD') {
        //     $account = RdAccount::find($request->account_no);
        // } else {
        //     $account = DdsAccount::find($request->account_no);
        // }
           return view('print-documents.rd-dd-bond.index', [
        'type'     => $request->account_type,
        'account'  => $account,
        'accounts' => $accounts, // THIS FIXES IT
    ]);

        // return view('print-documents.rd-dd-bond.index', [
        //     'account' => $account,
        //     'type' => $request->account_type
        // ]);
    }

    public function letter_head()
    {
        return view('print-documents.letter-head.index');
    }
    public function print_letter_head()
    {
        $data = [
            'bank_name' => 'SBC Global',
            'address' => 'SBC GLOBAL TOWAR ,  SHEGAON Maharashtra - 444001  ',
        ];

        $pdf = Pdf::loadView(
            'print-documents.letter-head.letter-head', // blade file path
            $data
        )->setPaper('A4', 'portrait');

        return $pdf->download('letter-head.pdf');
    }
    // public function fd_mis_passbook()
    // {
    //     return view('print-documents.fd-mis-passbook.index');
    // }

    // /**
    //  * Handle search and show download button
    //  */
    // public function searchPassbook(Request $request)
    // {
    //     $request->validate([
    //         'account_type' => 'required|in:FD,MIS',
    //         'account_no' => 'required'
    //     ]);

    //     $accountType = $request->account_type === 'FD'
    //         ? 'FD Accounts'
    //         : 'MIS Accounts';

    //     $passbook = Passbook::where('account_type', $accountType)
    //         ->where('account_no', $request->account_no)
    //         ->firstOrFail();

    //     return view('print-documents.fd-mis-passbook.index', [
    //         'passbook' => $passbook
    //     ]);
    // }

    // public function printpassbook($id)
    // {

    //     $pdf = PDF::loadView( 'print-documents.fd-mis-passbook.fd-passbook' )->setPaper('A4', 'portrait');

    //     return $pdf->download('passbook.pdf');
    // }


    // public function getAccountsByType($type)
    // {
    //     $accountType = $type === 'FD'
    //         ? 'FD Accounts'
    //         : 'MIS Accounts';

    //     return Passbook::where('account_type', $accountType)
    //         ->select('account_no')
    //         ->distinct()
    //         ->orderBy('account_no')
    //         ->get();
    // }


  public function index_formi(){
    // $members = Member::orderBy('id', 'asc')->get();
    $members = Member::with([
            'address.state'
        ])
        ->orderBy('id', 'asc')
        ->get();
    return view('print-documents.form-i-and-j.index-from-i',compact('members')) ;

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
public function generateFormJ()
{
    // $members = Member::orderBy('id', 'asc')->get();
//   $members = Member::with('address')
//         ->orderBy('id', 'asc')
//         ->get();
$members = Member::with([
            'address.state'
        ])
        ->orderBy('id', 'asc')
        ->get();

    $html = view(
        'print-documents.form-i-and-j.form-j',
        compact('members')
    )->render();

    $mpdf = $this->getMarathiMpdf();
    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('form-j-all-members.pdf', 'D')
    )->header('Content-Type', 'application/pdf');
}
public function generateFormI()
{
    $members = Member::with('address.state')
        ->orderBy('id', 'asc')
        ->get();

    $html = view(
        'print-documents.form-i-and-j.form-i',
        compact('members')
    )->render();

    $mpdf = $this->getMarathiMpdf();
    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('form-i.pdf', 'D')
    )->header('Content-Type', 'application/pdf');
}
public function procedingBook()
{
    // $members = Member::orderBy('id', 'asc')->get();
//   $members = Member::with('address')
//         ->orderBy('id', 'asc')
//         ->get();
$members = Member::with([
            'address.state'
        ])
        ->orderBy('id', 'asc')
        ->get();

    $html = view(
        'print-documents.form-i-and-j.proceding-book',
        compact('members')
    )->render();

    $mpdf = $this->getMarathiMpdf();
    $mpdf->WriteHTML($html);

    return response(
        $mpdf->Output('Proceeding Book.pdf', 'D')
    )->header('Content-Type', 'application/pdf');
}


   
}
