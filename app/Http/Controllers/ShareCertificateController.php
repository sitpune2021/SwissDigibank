<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class ShareCertificateController extends Controller
{
    public function index()
    {
    
    //    $certificate = Member::with('member')->get();

        return view('members.share-certificates.index');
    }
 
    public function create()
    {
       return view('members.share-certificates.create');

    }

    public function store(Request $request)
    {
        
    }
    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
