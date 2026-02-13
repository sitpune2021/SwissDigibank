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
use Illuminate\Validation\Rule;
use App\Models\Account;
use App\Models\Member;
use Illuminate\Support\Facades\Log;

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

            $promotors = $query->orderBy('created_at', 'desc')->paginate(25);

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
                'members' => Member::all()->pluck('full_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),

                'religions' => Religion::pluck('name', 'id'),
            ];
            $maritalStatuses = MaritalStatus::pluck('id', 'status'); // ['Married' => 2]
            $route = route('promotor.store');
            $method = 'POST';
            $promoter = null;

            $membersData = Member::select(
                'id',
                'member_info_title',
                'member_info_gender',
                'member_info_first_name',
                'member_info_middle_name',
                'member_info_last_name',
                'member_info_dob',
                'member_info_occupation',
                'member_info_father_name',
                'member_info_mother_name',
                'member_info_spouse_name',
                'member_info_mobile_no',
                'member_info_email',
                'member_info_marital_status',
                'member_info_religion'
            )->get()->keyBy('id');

            return view('company.promoters.add-promoter', compact('route', 'dynamicOptions', 'method', 'promoter', 'membersData', 'maritalStatuses'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'enrollment_date' => 'required|date|before_or_equal:today',
                 'member_id' => 'required|exists:members,id',
                'title' => 'required|string|max:10',
                'gender' => 'required|string|in:Male,Female,Other',
                'first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'last_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'branch_id' => 'required|exists:branches,id',
               
                'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'occupation' => 'nullable|string|max:255',
                'father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'marital_statuses_id' => 'nullable|exists:marital_statuses,id',
                'religions_id' => 'nullable|exists:religions,id',
                'husband_wife_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'email' => 'required|email|unique:promotors,email',
                'mobile' => 'required|digits:10|unique:promotors,mobile',
                'sms' => 'boolean',

                'aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/|unique:promotor_k_y_c_s,aadhaar_no',
                'voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/|unique:promotor_k_y_c_s,voter_id_no',
                'pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/|unique:promotor_k_y_c_s,pan_no',
                'ration_card_no' => 'nullable|string|max:20|unique:promotor_k_y_c_s,ration_card_no',
                'meter_no' => 'nullable|string|max:20|unique:promotor_k_y_c_s,meter_no',
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
                    'enrollment_date' => $validated['enrollment_date'],
                    'member_id' => $validated['member_id'], // ✅ ADD THIS
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
                // this condition is commented  now beacuse  kyc field want null (requirement) 
                // if (
                //     !empty($validated['aadhaar_no']) ||
                //     !empty($validated['voter_id_no']) ||
                //     !empty($validated['pan_no']) ||
                //     !empty($validated['ration_card_no']) ||
                //     !empty($validated['meter_no']) ||
                //     !empty($validated['ci_no']) ||
                //     !empty($validated['ci_relation']) ||
                //     !empty($validated['dl_no'])
                // ) {   }  

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
            $decryptedId = base64_decode($id);

            if (!$decryptedId || !is_numeric($decryptedId)) {
                abort(404, 'Invalid promoter ID.');
            }

            $promoter = Promotor::with('minor', 'members', 'accounts', 'branch', 'nominees')->findOrFail($decryptedId);
            $documents = KycDocument::where('promoter_id', $decryptedId)->get()->keyBy('document_category');
            $totalShares = $promoter->shareholdings->sum('total_share_held');

            $dynamicOptions = [
                'branches' => Branch::pluck('branch_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),
                'religions' => Religion::pluck('name', 'id'),
                // 'account'=>Account::pluck('account_type','id')
            ];

            $route = "";
            $method = "";
            $show = true;

            return view('company.promoters.show', compact('promoter', 'documents', 'dynamicOptions', 'route', 'show', 'method', 'totalShares'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function edit($id)
    {
        try {
            $decryptedId = base64_decode($id);
            // $promoter = Promotor::with('minor')->findOrFail($decryptedId);
            $promoter = Promotor::with(['minor', 'nominees', 'kyc'])->findOrFail($decryptedId);

            $route = route('promotor.update', $promoter->id);
            $dynamicOptions = [
                'branches' => Branch::pluck('branch_name', 'id'),
                'marital_statuses' => MaritalStatus::pluck('status', 'id'),
                'religions' => Religion::pluck('name', 'id'),
                'members' => Member::all()->pluck('full_name', 'id'),
            ];

              // 🔥 THIS IS WHAT YOU MISSED
        $membersData = Member::select(
                'id',
                'member_info_first_name',
                'member_info_middle_name',
                'member_info_last_name',
                'member_info_occupation',
                'member_info_father_name',
                'member_info_mother_name',
                'member_info_spouse_name',
                'member_info_mobile_no',
                'member_info_email',
                'member_info_dob',
                'member_info_marital_status',
                'member_info_religion',
                'member_info_title',
                'member_info_gender'
            )
            ->get()
            ->keyBy('id');
            $method = 'PUT';
            return view('company.promoters.add-promoter', compact('promoter', 'dynamicOptions', 'route', 'method','membersData'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $promotor = Promotor::findOrFail($id);
            $validated = $request->validate([
                'enrollment_date' => 'required|date|before_or_equal:today',
                'member_id' => 'required|exists:members,id',
                'title' => 'required|string|max:10',
                'gender' => 'required|string|in:Male,Female,Other',
                'first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'last_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'branch_id' => 'required|exists:branches,id',
                'date_of_birth' => 'required|before:today',
                'occupation' => 'nullable|string|max:255',
                'father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'marital_statuses_id' => 'nullable|exists:marital_statuses,id',
                'religions_id' => 'nullable|exists:religions,id',
                'husband_wife_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'email' => "required|email|unique:promotors,email,{$id}",
                'mobile' => "required|digits:10|unique:promotors,mobile,{$id}",
                'sms' => 'boolean',

                // KYC fields
                // 'aadhaar_no' => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                // 'voter_id_no' => 'nullable|regex:/^[A-Z]{3}[0-9]{7}$/',
                // 'pan_no' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                // 'ration_card_no' => 'nullable|string|max:20',
                // 'meter_no' => 'nullable|string|max:20',
                'aadhaar_no' => [
                    'nullable',
                    'digits:12',
                    'regex:/^[2-9]{1}[0-9]{11}$/',
                    Rule::unique('promotor_k_y_c_s', 'aadhaar_no')->ignore(optional($promotor->kyc)->id),
                ],
                'voter_id_no' => [
                    'nullable',
                    'regex:/^[A-Z]{3}[0-9]{7}$/',
                    Rule::unique('promotor_k_y_c_s', 'voter_id_no')->ignore(optional($promotor->kyc)->id),
                ],
                'pan_no' => [
                    'nullable',
                    'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                    Rule::unique('promotor_k_y_c_s', 'pan_no')->ignore(optional($promotor->kyc)->id),
                ],
                'ration_card_no' => [
                    'nullable',
                    'string',
                    'max:20',
                    Rule::unique('promotor_k_y_c_s', 'ration_card_no')->ignore(optional($promotor->kyc)->id),
                ],
                'meter_no' => [
                    'nullable',
                    'string',
                    'max:20',
                    Rule::unique('promotor_k_y_c_s', 'meter_no')->ignore(optional($promotor->kyc)->id),
                ],
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

                // Update promotor
                $promotor->update([
                    'enrollment_date' => $validated['enrollment_date'],
                     'member_id' => $validated['member_id'], 
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

    public function documentUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'documents' => 'nullable|array',
                'documents.*.file' => 'nullable|file',
                'documents.*.category' => 'nullable|string',
                'documents.*.type' => 'nullable|string',
            ]);

            if ($request->has('documents')) {
                foreach ($request->documents as $doc) {
                    if (isset($doc['file']) && $doc['file'] instanceof UploadedFile) {

                        $path = $doc['file']->store('documents', 'public');

                        KycDocument::updateOrCreate(
                            [
                                'promoter_id' => $id, // 👈 store promoter_id
                                'document_category' => $doc['category'],
                            ],
                            [
                                'document_type' => $doc['type'] ?? null,
                                'file_path' => $path,
                                'type' => 'promoter', // optional
                            ]
                        );
                    }
                }
            }

            return redirect()->route('promotor.index')
                ->with('success', 'Documents updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function addressedit($id)
    {
        try {
            $decryptedId = base64_decode($id);
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


    public function editNominee($id)
    {
        if (str_starts_with($id, 'new-')) {
            // New nominee mode
            $promoterId = str_replace('new-', '', $id);
            $promoter = Promotor::findOrFail($promoterId);

            return view('company.promoters.add-nominee', [
                'nominee' => null,
                'promoter' => $promoter,
                'isUpdate' => false
            ]);
        }

        $nominee = PromotorNomine::findOrFail($id);
        $promoter = $nominee->promotor;
        $promoter = $nominee->promotor;

        return view('company.promoters.add-nominee', [
            'nominee' => $nominee,
            'promoter' => $promoter,
            'isUpdate' => true
        ]);
    }

    public function updateNominee(Request $request, $id)
    {
        Log::info("Nominee update request received", [
            'nominee_id' => $id,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'nominee' => 'required|in:yes,no',
            'nominees' => 'required_if:nominee,yes|array',
            'nominees.*.relation' => 'required|string|max:50',
            'nominees.*.name' => 'required|string|max:100',
            'nominees.*.address' => 'required|string|max:255',
            'nominees.*.share_holding' => 'required|numeric|min:0|max:100',
        ]);

        $nominee = PromotorNomine::findOrFail($id);
        $promotor = $nominee->promotor;

        if (!$promotor) {
            Log::warning("Promoter not found for nominee ID: {$id}");
            return back()->with('error', 'Promoter not found for this nominee.');
        }

        // If user selected NO nominee
        if ($request->nominee === 'no') {

            Log::info("Deleting all nominees for promoter", [
                'promoter_id' => $promotor->id,
            ]);

            $promotor->nominees()->delete();

            return back()->with('success', 'Nominee removed.');
        }

        // Incoming nominee array
        $incomingNominees = $request->nominees ?? [];
        $incomingIds = collect($incomingNominees)->pluck('id')->filter()->toArray();

        Log::info("Incoming nominee IDs for update", [
            'promoter_id' => $promotor->id,
            'incoming_ids' => $incomingIds
        ]);

        // Delete removed nominees
        $deleted = $promotor->nominees()
            ->whereNotIn('id', $incomingIds)
            ->delete();

        Log::info("Deleted nominees count", [
            'count' => $deleted
        ]);

        // Update or create nominees
        foreach ($incomingNominees as $nomineeData) {

            Log::info("Processing nominee entry", $nomineeData);

            $data = [
                'relation' => $nomineeData['relation'],
                'name' => $nomineeData['name'],
                'address' => $nomineeData['address'],
                'share_holding' => $nomineeData['share_holding'] ?? 0,
            ];

            if (!empty($nomineeData['id'])) {
                Log::info("Updating nominee", [
                    'nominee_id' => $nomineeData['id'],
                    'data' => $data
                ]);

                $promotor->nominees()
                    ->where('id', $nomineeData['id'])
                    ->update($data);
            } else {
                Log::info("Creating new nominee", [
                    'data' => $data
                ]);

                $promotor->nominees()->create($data);
            }
        }

        Log::info("Nominee updated successfully", [
            'promoter_id' => $promotor->id
        ]);

        return redirect()
            ->route('promotor.show', base64_encode($promotor->id))
            ->with('success', 'Nominee updated successfully.');
    }
    public function viewTransactions($id)
    {
        $promotor = Promotor::findOrFail($id);
        return view('company.promoters.view-transactions', compact('id'));
    }



    //need to complete it when roles and permissions done full kyc status updation
//     public function updateStatus(Request $request, $id)
// {
    
//     //need to complete it when roles and permissions done full kyc status updation
//     $request->validate([
//         'kyc_status' => 'required|in:pending,in_progress,completed,rejected',
//     ]);

//     $kyc = PromotorKyc::firstOrCreate(
//         ['promotor_id' => $id],
//         ['kyc_status' => 'pending']
//     );

//     $oldStatus = $kyc->kyc_status;
//     $newStatus = $request->kyc_status;

//     Log::info('KYC status update requested', [
//         'kyc_id' => $kyc->id,
//         'promoter_id' => $id,
//         'old_status' => $oldStatus,
//         'new_status' => $newStatus,
//         'updated_by' => auth()->id(),
//     ]);

//     $kyc->update([
//         'kyc_status' => $newStatus
//     ]);

//     Log::notice('KYC status updated successfully', [
//         'kyc_id' => $kyc->id,
//         'final_status' => $newStatus,
//         'updated_by' => auth()->id(),
//     ]);

//     return back()->with('success', 'KYC status updated successfully.');
// }
  

}
