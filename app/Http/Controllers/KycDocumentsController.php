<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\KycAndNominee;
use App\Models\Address;
use App\Models\State;
use App\Models\Branch;
use App\Models\Religion;
use Carbon\Carbon;
use App\Models\KycDocument;



class KycDocumentsController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id'),
                'branch' => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id')
            ];
            $sections = config('kyc_document_form');
            $member = null;
            $route = route('member.store');
            $method = 'POST';
            return view('members.member.kycDocumentAdd', compact('sections', 'member', 'route', 'method', 'dynamicOptions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'documents' => 'nullable|array',
                'documents.*.file' => 'nullable|file|max:2048',
                'documents.*.category' => 'nullable|string',
                'documents.*.type' => 'nullable|string',
                'member_id' => 'nullable|exists:members,id',
                'promoter_id' => 'nullable|exists:promoters,id',
            ]);

            // Ensure only one of member_id or promoter_id is present
            if (!$request->member_id && !$request->promoter_id) {
                return response()->json(['error' => 'Either member_id or promoter_id must be provided.'], 422);
            }

            if ($request->member_id && $request->promoter_id) {
                return response()->json(['error' => 'Only one of member_id or promoter_id should be provided.'], 422);
            }

            foreach ($request->documents as $doc) {
                $path = $doc['file']->store('documents', 'public');

                KycDocument::create([
                    'member_id' => $request->member_id,
                    'promoter_id' => $request->promoter_id,
                    'document_category' => $doc['category'],
                    'document_type' => $doc['type'] ?? null,
                    'file_path' => $path,
                    'type' => $request->member_id ? 'member' : 'promoter',
                ]);
            }

            return response()->json(['message' => 'Documents uploaded successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }


    public function show(string $id) {}

    public function edit(string $id)
    {
        try {
            $method = 'PUT';
            $memberModel = Member::with('address', 'kyc')->findOrFail($id);
            $member = array_merge(
                $memberModel->toArray(),
                $memberModel->address?->toArray() ?? [],
                $memberModel->kyc?->toArray() ?? []
            );

            $sections = config('kyc_document_form');
            $route = route('member.update', $id);
            session(['member_id' => $id]);
            // dd($sections);
            return view('members.member.kycDocumentAdd', compact('sections', 'member', 'route', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
