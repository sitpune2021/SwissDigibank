<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShareCertificate;

class ShareCertificateController extends Controller
{
    public function index()
    {
      $certificates = ShareCertificate::with(['member', 'branch'])->get();
        return view('members.share-certificates.index',compact('certificates'));
    }

    public function create()
    {
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
    }

    public function destroy(string $id)
    {
    }
}
