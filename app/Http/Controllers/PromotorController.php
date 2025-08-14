<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Promotor;
use App\Models\PromotorKYC;
use App\Models\PromotorNomine;
use Illuminate\Http\Request;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\KycDocument;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PromotorController extends Controller
{
    public function index(Request $request)
    {
        try {
            // return abort(404);
            $query = Promotor::query();
            if ($request->has('search')) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->Where('first_name', 'like', "%$search%")
                        ->orWhere('gender', 'like', "%$search%");
                    // ->orWhere('enrollment_date', 'like', "%$search%");
                    try {
                        $date = Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                        $q->orWhereDate('enrollment_date', $date);
                    } catch (\Exception $e) {
                        // Do nothing if not a valid date
                    }
                });
            }

            $promotors = $query->orderBy('created_at', 'desc')->paginate(10);

            foreach ($promotors as $promotor) {
                if ($promotor->date_of_birth) {
                    $age = Carbon::parse($promotor->date_of_birth)->age;
                    $promotor->is_senior = $age >= 60 ? 'Yes' : 'No';
                } else {
                    $promotor->is_senior = 'No';
                }
            }
            return view('company.promoters.manage-promotors', compact('promotors'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function create()
    {
        try {
            $dynamicOptions = [
                'branches' => Branch::pluck('branch_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),
                'religions' => Religion::pluck('name', 'id'),
            ];
            $route = route('promotor.store');
            $method = 'POST';
            $promoter = null;
            return view('company.promoters.add-promoter', compact('route', 'dynamicOptions', 'method', 'promoter'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'enrollment_date' => 'required|date|before_or_equal:today',
                'title' => 'required|string|max:10',
                'gender' => 'required|string|in:Male,Female,Other',
                'first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'last_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'branch_id' => 'required|exists:branches,id',
                'date_of_birth' => 'required|before:today',
                'occupation' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'marital_statuses_id' => 'nullable|exists:marital_statuses,id',
                'religions_id' => 'nullable|exists:religions,id',
                'husband_wife_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'email' => 'nullable|email|unique:promotors,email',
                'mobile' => 'required|digits:10|unique:promotors,mobile',
                'sms' => 'boolean',

                'aadhaar_no' => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',
                'pan_no' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'ration_card_no' => 'nullable|string|max:20',
                'meter_no' => 'nullable|string|max:20',
                'ci_no' => 'nullable|string|max:20',
                'ci_relation' => 'nullable|string|max:50',
                'dl_no' => 'nullable|string|max:20',

                'nominee_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'nominee_relation' => 'nullable|string|max:100|regex:/^[A-Za-z]+$/',
                'nominee_mobile_no' => 'nullable|digits:10',
                'nominee_aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'nominee_voter_id_no' => 'nullable||regex:/^[A-Z]{3}[0-9]{7}$/',
                'nominee_pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'nominee_address' => 'nullable|string|max:500',
            ]);
            try {
                DB::beginTransaction();

                // Store promotor
                $promotor = Promotor::create([
                    'enrollment_date' =>  $validated['enrollment_date'],
                    'title' => $validated['title'],
                    'gender' => $validated['gender'],
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'branch_id' => $validated['branch_id'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'occupation' => $validated['occupation'],
                    'father_name' => $validated['father_name'],
                    'mother_name' => $validated['mother_name'],
                    'marital_statuses_id' => $validated['marital_statuses_id'] ?? null,
                    'religions_id' => $validated['religions_id'] ?? null,
                    'husband_wife_name' => $validated['husband_wife_name'] ?? null,
                    'email' => $validated['email'],
                    'mobile' => $validated['mobile'],
                    'sms' => $validated['sms'] ?? 0,
                    'active' => $validated['active'] ?? 'No',
                    'form15g' => $validated['form15g'] ?? 'No',
                    'folio_no' => 34,
                ]);

                $promotor->update([
                    'folio_no' => str_pad($promotor->id, 4, '0', STR_PAD_LEFT),
                ]);


                // Store KYC
                // Create PromotorKYC only if at least one field is present
                if (
                    !empty($validated['aadhaar_no']) ||
                    !empty($validated['voter_id_no']) ||
                    !empty($validated['pan_no']) ||
                    !empty($validated['ration_card_no']) ||
                    !empty($validated['meter_no']) ||
                    !empty($validated['ci_no']) ||
                    !empty($validated['ci_relation']) ||
                    !empty($validated['dl_no'])
                ) {

                    PromotorKYC::create([
                        'promotor_id' => $promotor->id,
                        'aadhaar_no' => $validated['aadhaar_no'],
                        'voter_id_no' => $validated['voter_id_no'] ?? null,
                        'pan_no' => $validated['pan_no'] ?? null,
                        'ration_card_no' => $validated['ration_card_no'] ?? null,
                        'meter_no' => $validated['meter_no'] ?? null,
                        'ci_no' => $validated['ci_no'] ?? null,
                        'ci_relation' => $validated['ci_relation'] ?? null,
                        'dl_no' => $validated['dl_no'] ?? null,
                        'kyc_status' => $validated['kyc_status'] ?? 'pending',
                    ]);
                }

                // Create PromotorNomine only if at least one field is present
                if (
                    !empty($validated['nominee_name']) ||
                    !empty($validated['nominee_relation']) ||
                    !empty($validated['nominee_mobile_no']) ||
                    !empty($validated['nominee_aadhaar_no']) ||
                    !empty($validated['nominee_voter_id_no']) ||
                    !empty($validated['nominee_pan_no']) ||
                    !empty($validated['nominee_address'])
                ) {

                    PromotorNomine::create([
                        'promotor_id' => $promotor->id,
                        'name' => $validated['nominee_name'],
                        'relation' => $validated['nominee_relation'] ?? null,
                        'mobile_no' => $validated['nominee_mobile_no'],
                        'aadhaar_no' => $validated['nominee_aadhaar_no'] ?? null,
                        'voter_id_no' => $validated['nominee_voter_id_no'] ?? null,
                        'pan_no' => $validated['nominee_pan_no'] ?? null,
                        'address' => $validated['nominee_address'] ?? null,
                    ]);
                }

                DB::commit();
                return redirect()->route('promotor.index')->with('success', 'Promotor created successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'An error occurred while creating the promotor. Please try again.']);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function show($id)
    {
        try {
            $decryptedId =  base64_decode($id);
            // $promoter = Promotor::findOrFail($decryptedId);

            $promoter = Promotor::with('minor')->findOrFail($decryptedId);

            $route = "";
            $dynamicOptions = [
                'branches' => Branch::pluck('branch_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),
                'religions' => Religion::pluck('name', 'id'),
            ];
            $show = true;
            $method = "";

            return view('company.promoters.show', compact('promoter', 'dynamicOptions', 'route', 'show', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function edit($id)
    {
        try {
            $decryptedId =  base64_decode($id);
            $promoter = Promotor::with('minor')->findOrFail($decryptedId);
            $route = route('promotor.update', $promoter->id);
            $dynamicOptions = [
                'branches' => Branch::pluck('branch_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),
                'religions' => Religion::pluck('name', 'id'),
            ];
            $method = 'PUT';
            return view('company.promoters.add-promoter', compact('promoter', 'dynamicOptions', 'route', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                // Promotor fields (same validation as store)
                'enrollment_date' => 'required|date|before_or_equal:today',
                'title' => 'required|string|max:10',
                'gender' => 'required|string|in:Male,Female,Other',
                'first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'last_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'branch_id' => 'required|exists:branches,id',
                'date_of_birth' => 'required',
                'occupation' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'marital_statuses_id' => 'nullable|exists:marital_statuses,id',
                'religions_id' => 'nullable|exists:religions,id',
                'husband_wife_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'email' => "nullable|email|unique:promotors,email,{$id}",
                'mobile' => "required|digits:10|unique:promotors,mobile,{$id}",
                'sms' => 'boolean',

                // KYC fields
                'aadhaar_no' => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',
                'pan_no' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'ration_card_no' => 'nullable|string|max:20',
                'meter_no' => 'nullable|string|max:20',
                'ci_no' => 'nullable|string|max:20',
                'ci_relation' => 'nullable|string|max:50',
                'dl_no' => 'nullable|string|max:20',

                // Nominee fields
                'nominee_name' => 'nullable|string|max:255',
                'nominee_relation' => 'nullable|string|max:100|regex:/^[A-Za-z]+$/',
                'nominee_mobile_no' => 'nullable|digits:10',
                'nominee_aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'nominee_voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',
                'nominee_pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'nominee_address' => 'nullable|string|max:500',
            ]);

            try {
                DB::beginTransaction();


                $promotor = Promotor::findOrFail($id);

                // Update promotor
                $promotor->update([
                    'enrollment_date' => $validated['enrollment_date'],
                    'title' => $validated['title'],
                    'gender' => $validated['gender'],
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'branch_id' => $validated['branch_id'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'occupation' => $validated['occupation'],
                    'father_name' => $validated['father_name'],
                    'mother_name' => $validated['mother_name'],
                    'marital_statuses_id' => $validated['marital_statuses_id'] ?? null,
                    'religions_id' => $validated['religions_id'] ?? null,
                    'husband_wife_name' => $validated['husband_wife_name'] ?? null,
                    'email' => $validated['email'],
                    'mobile' => $validated['mobile'],
                    'sms' => $validated['sms'] ?? 0,
                    'active' => $validated['active'] ?? $promotor->active,
                    'form15g' => $validated['form15g'] ?? $promotor->form15g,
                ]);

                // Update or create KYC
                $kycData = [
                    'aadhaar_no' => $validated['aadhaar_no'],
                    'voter_id_no' => $validated['voter_id_no'] ?? null,
                    'pan_no' => $validated['pan_no'] ?? null,
                    'ration_card_no' => $validated['ration_card_no'] ?? null,
                    'meter_no' => $validated['meter_no'] ?? null,
                    'ci_no' => $validated['ci_no'] ?? null,
                    'ci_relation' => $validated['ci_relation'] ?? null,
                    'dl_no' => $validated['dl_no'] ?? null,
                    'kyc_status' => $validated['kyc_status'] ?? 'pending',
                ];

                if ($promotor->kyc) {
                    $promotor->kyc->update($kycData);
                } else {
                    $promotor->kyc()->create($kycData);
                }

                // Update or create nominee (assuming only one nominee)
                $nomineeData = [
                    'name' => $validated['nominee_name'],
                    'relation' => $validated['nominee_relation'] ?? null,
                    'mobile_no' => $validated['nominee_mobile_no'],
                    'aadhaar_no' => $validated['nominee_aadhaar_no'] ?? null,
                    'voter_id_no' => $validated['nominee_voter_id_no'] ?? null,
                    'pan_no' => $validated['nominee_pan_no'] ?? null,
                    'address' => $validated['nominee_address'] ?? null,
                ];

                if ($promotor->nominees()->exists()) {
                    // Update first nominee
                    $promotor->nominees()->first()->update($nomineeData);
                } else {
                    // Create nominee
                    $promotor->nominees()->create($nomineeData);
                }

                DB::commit();

                return redirect()->route('promotor.index')->with('success', 'Promotor updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'An error occurred while updating the promotor. Please try again.']);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function destroy($id)
    {
        try {
            $branch = Promotor::findOrFail($id);
            $branch->delete();

            return redirect()->route('promotor.index')->with('success', 'Branch deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }
    public function getMariatalStatuses()
    {
        try {
            $statuses = MaritalStatus::all();
            return response()->json($statuses);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function getReligion()
    {
        try {
            $religions = Religion::all();
            return response()->json($religions);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function getPromoters()
    {
        try {
            $promoters = Promotor::all();
            return response()->json($promoters);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function documentShow(string $id)
    {
        try {
            $route = route('promoter.documentupdate', $id);
            $method = 'POST';
            $documents = KycDocument::where('promoter_id', $id)->get()->keyBy('document_category');
            return view('company.promoters.kycDocumentAdd', compact('route', 'method', 'id', 'documents'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function documentUpdate(Request $request)
    {
        try {
            $request->validate([
                'documents' => 'required|array',
                'documents.*.file' => 'required',
                'documents.*.category' => 'required|string',
                'documents.*.type' => 'nullable|string',
                'member_id' => 'nullable'
            ]);

            foreach ($request->documents as $doc) {
                if (isset($doc['file']) && $doc['file'] instanceof UploadedFile) {
                    $path = $doc['file']->storeAs('documents', 'public');
                    KycDocument::updateOrCreate(
                        [
                            'member_id' => $request->member_id,
                            'document_category' => $doc['category'],
                            'document_type' => $doc['type'] ?? null,
                        ],
                        [
                            'file_path' => $path,
                            'type' => 'member',
                        ]
                    );
                }
            }
            return redirect()->route('promotor.index')->with('success', 'Documents updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }
    public function addressedit($id)
    {
        try {
            $decryptedId =  base64_decode($id);
            $promoter = Promotor::findOrFail($decryptedId);
            $route = route('promotor.update', $promoter->id);
            $dynamicOptions = [
                'branches' => Branch::pluck('branch_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),
                'religions' => Religion::pluck('name', 'id'),
            ];
            $method = 'PUT';
            return view('company.promoters.add-promoter', compact('promoter', 'dynamicOptions', 'route', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function addressupdate(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                // Promotor fields (same validation as store)
                'enrollment_date' => 'required',
                'title' => 'required|string|max:10',
                'gender' => 'required|string|in:Male,Female,Other',
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'branch_id' => 'required|exists:branches,id',
                'date_of_birth' => 'required',
                'occupation' => 'nullable|string|max:255',
                'father_name' => 'nullable|string|max:255',
                'mother_name' => 'nullable|string|max:255',
                'marital_statuses_id' => 'nullable|exists:marital_statuses,id',
                'religions_id' => 'nullable|exists:religions,id',
                'husband_wife_name' => 'nullable|string|max:255',
                'email' => "nullable|email|unique:promotors,email,{$id}",
                'mobile' => "required|digits:10|unique:promotors,mobile,{$id}",
                'sms' => 'boolean',

                // KYC fields
                'aadhaar_no' => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',
                'pan_no' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'ration_card_no' => 'nullable|string|max:20',
                'meter_no' => 'nullable|string|max:20',
                'ci_no' => 'nullable|string|max:20',
                'ci_relation' => 'nullable|string|max:50',
                'dl_no' => 'nullable|string|max:20',

                // Nominee fields
                'nominee_name' => 'nullable|string|max:255',
                'nominee_relation' => 'nullable|string|max:100',
                'nominee_mobile_no' => 'nullable|digits:10',
                'nominee_aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'nominee_voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',
                'nominee_pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'nominee_address' => 'nullable|string|max:500',
            ]);

            try {
                DB::beginTransaction();


                $promotor = Promotor::findOrFail($id);

                // Update promotor
                $promotor->update([
                    'enrollment_date' => $validated['enrollment_date'],
                    'title' => $validated['title'],
                    'gender' => $validated['gender'],
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name' => $validated['last_name'],
                    'branch_id' => $validated['branch_id'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'occupation' => $validated['occupation'],
                    'father_name' => $validated['father_name'],
                    'mother_name' => $validated['mother_name'],
                    'marital_statuses_id' => $validated['marital_statuses_id'] ?? null,
                    'religions_id' => $validated['religions_id'] ?? null,
                    'husband_wife_name' => $validated['husband_wife_name'] ?? null,
                    'email' => $validated['email'],
                    'mobile' => $validated['mobile'],
                    'sms' => $validated['sms'] ?? 0,
                    'active' => $validated['active'] ?? $promotor->active,
                    'form15g' => $validated['form15g'] ?? $promotor->form15g,
                ]);

                // Update or create KYC
                $kycData = [
                    'aadhaar_no' => $validated['aadhaar_no'],
                    'voter_id_no' => $validated['voter_id_no'] ?? null,
                    'pan_no' => $validated['pan_no'] ?? null,
                    'ration_card_no' => $validated['ration_card_no'] ?? null,
                    'meter_no' => $validated['meter_no'] ?? null,
                    'ci_no' => $validated['ci_no'] ?? null,
                    'ci_relation' => $validated['ci_relation'] ?? null,
                    'dl_no' => $validated['dl_no'] ?? null,
                    'kyc_status' => $validated['kyc_status'] ?? 'pending',
                ];

                if ($promotor->kyc) {
                    $promotor->kyc->update($kycData);
                } else {
                    $promotor->kyc()->create($kycData);
                }

                // Update or create nominee (assuming only one nominee)
                $nomineeData = [
                    'name' => $validated['nominee_name'],
                    'relation' => $validated['nominee_relation'] ?? null,
                    'mobile_no' => $validated['nominee_mobile_no'],
                    'aadhaar_no' => $validated['nominee_aadhaar_no'] ?? null,
                    'voter_id_no' => $validated['nominee_voter_id_no'] ?? null,
                    'pan_no' => $validated['nominee_pan_no'] ?? null,
                    'address' => $validated['nominee_address'] ?? null,
                ];

                if ($promotor->nominees()->exists()) {
                    // Update first nominee
                    $promotor->nominees()->first()->update($nomineeData);
                } else {
                    // Create nominee
                    $promotor->nominees()->create($nomineeData);
                }

                DB::commit();

                return redirect()->route('promotor.index')->with('success', 'Promotor updated successfully');
            } catch (\Exception $e) {

                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'An error occurred while updating the promotor. Please try again.']);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }
}
