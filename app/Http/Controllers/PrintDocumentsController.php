<?php

namespace App\Http\Controllers;

use App\Models\DdsAccount;
use App\Models\FdAccount;
use App\Models\Misaccount;
use App\Models\RdAccount;
use Illuminate\Http\Request;

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
        'account_no'   => 'required',
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
        'type'    => $request->account_type
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
 public function rdDdBond(){
     return view('print-documents.rd-dd-bond.index');
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
        'account_no'   => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->route('print.rd-dd-bond.index')
            ->withErrors($validator)
            ->withInput();
    }
    

    if ($request->account_type === 'RD') {
        $account = RdAccount::find($request->account_no);
    } else {
        $account = DdsAccount::find($request->account_no);
    }

    return view('print-documents.rd-dd-bond.index', [
        'account' => $account,
        'type'    => $request->account_type
    ]);
}

}
