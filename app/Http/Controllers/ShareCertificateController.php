<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareCertificateController extends Controller
{
    public function index()
    {
    
       $sharecertificates = Shareholders::with('sharecertificate')->get();

        return view('share-certificates.index', compact('sharecertificates'));
    }
 
    public function create()
    {
       return view('share-certificates.create');

    }

    public function store(Request $request)
    {
        
    }

    
    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        //
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
