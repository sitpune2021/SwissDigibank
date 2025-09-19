<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Address;
use App\Models\KycAndNominee;
use App\Models\State;
use App\Models\Branch;
use App\Models\Religion;
use App\Models\KycDocument;
use App\Models\ShareTransfer;
use App\Models\Shareholding;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\MembershipChargeTransaction;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Member::with(['branch', 'kyc']);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;

                $dateSearch = null;
                try {
                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $search);
                    $dateSearch = $date->format('Y-m-d');
                } catch (\Exception $e) {
                }

                $query->where(function ($q) use ($search, $dateSearch) {
                    $q->where('member_info_old_member_no', 'like', "%{$search}%")
                        ->orWhere('general_group', 'like', "%{$search}%")
                        ->orWhere('member_info_first_name', 'like', "%{$search}%")
                        ->orWhere('member_info_middle_name', 'like', "%{$search}%")
                        ->orWhere('member_info_last_name', 'like', "%{$search}%")
                        ->orWhere('member_info_mobile_no', 'like', "%{$search}%");

                    if ($dateSearch) {
                        $q->orWhereDate('general_enrollment_date', $dateSearch);
                    }

                    $q->orWhereHas('kyc', function ($kq) use ($search) {
                        $kq->where('member_kyc_aadhaar_no', 'like', "%{$search}%")
                            ->orWhere('member_kyc_pan_no', 'like', "%{$search}%");
                    });
                });
            }

            $members = $query->latest()->paginate(10);

            session()->forget('member_id');
            return view('members.member.index', compact('members'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function create()
    {
        try {
            $dynamicOptions = [
                'states'   => State::pluck('name', 'id'),
                'branch'   => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id'),
            ];

            $sections = config('member_form');
            $member   = null;
            $route    = route('member.store');
            $method   = 'POST';

            // default empty document objects so Blade can safely read properties
            $empty = fn($category) => (object)[
                'file'          => null,
                'category'      => $category,
                'file_path'     => null,
                'document_type' => null,
            ];

            $documents = [
                'photo'              => $empty('photo'),
                'signature'          => $empty('signature'),
                'id_proof'           => $empty('id_proof'),
                'id_proof_back'      => $empty('id_proof_back'),
                'address_proof'      => $empty('address_proof'),
                'address_proof_back' => $empty('address_proof_back'),
                'pan_number'         => $empty('pan_number'),
            ];
            $advisors = Member::select('id', 'general_advisor_staff')
                ->whereNotNull('general_advisor_staff')
                ->distinct()
                ->get();

            return view(
                'members.member.create',
                compact('sections', 'member', 'route', 'method', 'dynamicOptions', 'documents', 'advisors')
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            // Membership Type
            'membership_type' => 'required|in:nominal,regular',

            // General Info
            'general_advisor_staff' => 'nullable|string',
            'general_group' => 'nullable|in:group1,group2',
            'general_branch' => 'required|string',
            'general_enrollment_date' => 'nullable|date',

            // Member Info
            'member_info_title' => 'required|in:Md,Mr,Ms,Mrs',
            'member_info_gender' => 'required|in:male,female,other',
            'member_info_first_name' => 'required|string|max:255',
            'member_info_middle_name' => 'nullable|string|max:255',
            'member_info_last_name' => 'required|string|max:255',
            'member_info_dob' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'member_info_qualification' => 'nullable|string',
            'member_info_occupation' => 'nullable|string',
            'member_info_monthly_income' => 'nullable|numeric',
            'member_info_old_member_no' => 'nullable|string',
            'member_info_father_name' => 'nullable|string|max:255',
            'member_info_mother_name' => 'nullable|string|max:255',
            'member_info_spouse_name' => 'nullable|string|max:255',
            'member_info_spouse_dob' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),

            'member_info_mobile_no' => 'required|digits:10',

            // Address Info
            'member_address_line_1' => 'nullable|string',
            'member_address_line_2' => 'nullable|string',
            'member_address_city_district' => 'nullable|string',
            'member_address_state' => 'required|integer',
            'member_address_pincode' => 'required|numeric',
            'member_address_country' => 'required|regex:/^[A-Za-z\s]+$/',
            'member_address_address' => 'nullable|string',

            // Permanent Address
            'member_perm_address_city' => 'nullable|string',
            'member_perm_address_state' => 'nullable|string',
            'member_perm_address_pincode' => 'nullable|numeric',

            // GPS Location
            'member_gps_location_latitude' => 'nullable|string',
            'member_gps_location_longitude' => 'nullable|numeric',

            // KYC Info
            'member_kyc_aadhaar_no'     => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/|unique:kyc_and_nominees,member_kyc_aadhaar_no',
            'member_kyc_voter_id_no'    => 'nullable|string|unique:kyc_and_nominees,member_kyc_voter_id_no',
            'member_kyc_pan_no'         => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|unique:kyc_and_nominees,member_kyc_pan_no',
            'member_kyc_ration_card_no' => 'nullable|string|unique:kyc_and_nominees,member_kyc_ration_card_no',
            'member_kyc_meter_no'       => 'nullable|string|unique:kyc_and_nominees,member_kyc_meter_no',

            'member_kyc_ci_no' => 'nullable|string',
            'member_kyc_ci_relation' => 'nullable|string',
            'member_kyc_dl_no' => 'nullable|string',
            'member_kyc_passport_no' => 'nullable|string',

            // Documents
            'documents' => 'nullable|array',
            'documents.*.file' => 'nullable|file',
            'documents.*.category' => 'nullable|string',
            'documents.*.type' => 'nullable|string',

            // Nominee Info
            'nominee_name' => 'nullable|string',
            'nominee_relation' => 'nullable|string',
            'nominee_mobile_no' => 'nullable|string',
            'nominee_gender' => 'nullable|in:Male,Female,Other',
            'nominee_dob' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),

            'nominee_aadhaar_no' => 'nullable|string',
            'nominee_voter_id_no' => 'nullable|string',
            'nominee_pan_no' => 'nullable|string',
            'nominee_ration_card_no' => 'nullable|string',
            'nominee_address' => 'nullable|string',

            // Extra Settings
            'extra_sms' => 'nullable|boolean',

            // Membership Charges
            'charges_transaction_date' => 'required|date|before_or_equal:today',
            'charges_membership_fee' => 'nullable|numeric',
            'charges_net_fee' => 'required|numeric',
            'charges_pay_mode' => 'required|in:cash,online,cheque',
        ]);

        try {
            // Format date fields into Y-m-d format
            $dates = [
                'general_enrollment_date',
                'member_info_dob',
                'charges_transaction_date',
                'online_transfer_date',
                'cheque_date'
            ];

            foreach ($dates as $dateField) {
                if ($request->filled($dateField)) {
                    $request->merge([$dateField => Carbon::parse($request->$dateField)->format('Y-m-d')]);
                }
            }

            // Create Member
            $memberData = $request->only((new Member)->getFillable());
            $member = Member::create($memberData);
            Log::info('Member created successfully', ['member_id' => $member->id]);

            // Create Address
            $addressData = $request->only((new Address)->getFillable());
            $member->address()->create(array_merge($addressData, ['member_id' => $member->id]));

            // Create KYC & Nominee (if any)
            $kycData = $request->only((new KycAndNominee)->getFillable());
            $member->kyc()->create(array_merge($kycData, ['member_id' => $member->id]));

            // Handle Documents
            if ($request->has('documents')) {
                foreach ($request->documents as $doc) {
                    if (isset($doc['file']) && $doc['file'] instanceof \Illuminate\Http\UploadedFile) {
                        $path = $doc['file']->store('documents', 'public');
                        KycDocument::create([
                            'member_id' => $member->id,
                            'document_category' => $doc['category'],
                            'document_type' => $doc['type'] ?? null,
                            'file_path' => $path,
                        ]);
                    }
                }
            }

            MembershipChargeTransaction::create([
                    'member_id' => $member->id,

                'transaction_date' => Carbon::parse($request->charges_transaction_date)->format('Y-m-d'),
                'membership_fee' => $request->charges_membership_fee ?? 0, // Default to 0 if null
                'net_fee_to_collect' => $request->charges_net_fee,
                'remarks' => $request->charges_remarks ?? null,
                'charges_pay_mode' => $request->charges_pay_mode,
                
                'online_utr_no' => $request->charges_pay_mode === 'online' ? $request->online_utr_no : null,
                'online_transfer_mode' => $request->charges_pay_mode === 'online' ? $request->online_transfer_mode : null,
                'cheque_bank_name' => $request->charges_pay_mode === 'cheque' ? $request->cheque_bank_name : null,
                'cheque_no' => $request->charges_pay_mode === 'cheque' ? $request->cheque_no : null,
                'cheque_date' => $request->charges_pay_mode === 'cheque' ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null,
            ]);

            return redirect()->route('member.index')->with('success', 'Member created successfully.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error during member store: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withErrors(['error' => 'An error occurred while creating the member. Please try again.']);
        }
    }

    public function show(string $id)
    {
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id'),
                'branch' => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id')
            ];

            $member = Member::with('address', 'kyc', 'minors')->findOrFail($id);
            // 👇 Add this line to fetch the shareholdings
            $shareholdings = ShareTransfer::where('member_id', $member->id)
                ->where('status', 'approved')
                ->get();
            $documents = KycDocument::where('member_id', $id)->get();

            $sections = config('member_form');
            $show = true;
            $button = true;
            $method = 'PUT';
            $minor = true;

            session(['member_id' => $id]);
            session(['type' => "member"]);

            return view('members.member.show', compact(
                'sections',
                'member',
                'show',
                'dynamicOptions',
                'button',
                'minor',
                'method',
                'documents',
                'shareholdings' // ✅ send documents also
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function documentShow(string $id)
    {
        try {
            $route = route('member.documentupdate', $id);
            $method = 'POST';
            $documents = KycDocument::where('member_id', $id)->get()->keyBy('document_category');
            return view('members.member.kycDocumentAdd', compact('route', 'method', 'id', 'documents'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function documentUpdate(Request $request)
    {
        try {
            $request->validate([
                'documents' => 'nullable|array',
                'documents.*.file' => 'nullable|file',
                'documents.*.category' => 'nullable|string',
                'documents.*.type' => 'nullable|string',
                'member_id' => 'nullable'
            ]);

            foreach ($request->documents as $doc) {
                if (isset($doc['file']) && $doc['file'] instanceof UploadedFile) {
                    // Generate unique filename
                    $filename = time() . '_' . $doc['file']->getClientOriginalName();

                    // Store in storage/app/public/documents
                    $path = $doc['file']->storeAs('documents', $filename, 'public');

                    // Save or update DB record
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

            return redirect()->route('member.index')->with('success', 'Member updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function edit(string $id)
    {
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id'),
                'branch' => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id')
            ];
            $method = 'PUT';
            $memberModel = Member::with('address', 'kyc')->findOrFail($id);
            $documents = KycDocument::where('member_id', $id)->get();
            $member = array_merge(
                $memberModel->toArray(),
                $memberModel->address?->toArray() ?? [],
                $memberModel->kyc?->toArray() ?? []
            );

            $sections = config('member_form');
            $route = route('member.update', $id);
            session(['member_id' => $id]);
            $minor = true;
            // 🔹 Prepare documents (either existing or empty defaults)
            $empty = fn($category) => (object)[
                'file'          => null,
                'category'      => $category,
                'file_path'     => null,
                'document_type' => null,
            ];

            $existingDocs = KycDocument::where('member_id', $id)->get()->keyBy('document_category');

            $documents = [
                'photo'              => $existingDocs['photo'] ?? $empty('photo'),
                'signature'          => $existingDocs['signature'] ?? $empty('signature'),
                'id_proof'           => $existingDocs['id_proof'] ?? $empty('id_proof'),
                'id_proof_back'      => $existingDocs['id_proof_back'] ?? $empty('id_proof_back'),
                'address_proof'      => $existingDocs['address_proof'] ?? $empty('address_proof'),
                'address_proof_back' => $existingDocs['address_proof_back'] ?? $empty('address_proof_back'),
                'pan_number'         => $existingDocs['pan_number'] ?? $empty('pan_number'),
            ];

            return view('members.member.create', compact('sections', 'member', 'route', 'method', 'dynamicOptions', 'minor', 'documents'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'membership_type' => 'required|in:nominal,regular',

                // General Info
                'general_advisor_staff' => 'nullable|string',
                'general_group' => 'nullable|in:group1,group2',
                'general_branch' => 'required|string',
                'general_enrollment_date' => 'nullable',

                // Member Info
                'member_info_title' => 'required|in:Md,Mr,Ms,Mrs',
                'member_info_gender' => 'required|in:male,female,other',
                'member_info_first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_last_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_dob' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'member_info_qualification' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_occupation' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_monthly_income' => 'nullable|numeric',
                'member_info_old_member_no' => 'nullable|string',
                'member_info_father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_spouse_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_spouse_dob' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'member_info_mobile_no' => 'required|string|max:10',
                'member_info_collection_time' => 'nullable|string',
                'member_info_marital_status' => 'nullable|in:single,married,divorced,widowed,separated',
                'member_info_religion' => 'nullable|string',
                'member_info_email' => 'nullable|email',

                // Member Address
                'member_address_line_1' => 'nullable|string',
                'member_address_line_2' => 'nullable|string',
                'member_address_para' => 'nullable|string',
                'member_address_ward' => 'nullable|string',
                'member_address_panchayat' => 'nullable|string',
                'member_address_area' => 'nullable|string',
                'member_address_landmark' => 'nullable|string',
                'member_address_city_district' => 'nullable|string',
                'member_address_state' => 'required|string',
                'member_address_pincode' => 'nullable|numeric',
                'member_address_country' => 'required|regex:/^[A-Za-z\s]+$/',
                'member_address_address' => 'nullable|string',

                // Permanent Address
                'member_perm_address_city' => 'nullable|string',
                'member_perm_address_state' => 'nullable|string',
                'member_perm_address_pincode' => 'nullable|numeric',

                // GPS Location
                'member_gps_location_latitude' => 'nullable|string',
                'member_gps_location_longitude' => 'nullable|numeric',

                // KYC Info
                'member_kyc_aadhaar_no' => [
                    'required',
                    'digits:12',
                    'regex:/^[2-9]{1}[0-9]{11}$/',
                    Rule::unique('kyc_and_nominees', 'member_kyc_aadhaar_no')->ignore($id),
                ],
                'member_kyc_voter_id_no' => [
                    'nullable',
                    'string',
                    Rule::unique('kyc_and_nominees', 'member_kyc_voter_id_no')->ignore($id),
                ],
                'member_kyc_pan_no' => [
                    'required',
                    'string',
                    'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
                    Rule::unique('kyc_and_nominees', 'member_kyc_pan_no')->ignore($id),
                ],
                'member_kyc_ration_card_no' => [
                    'nullable',
                    'string',
                    Rule::unique('kyc_and_nominees', 'member_kyc_ration_card_no')->ignore($id),
                ],
                'member_kyc_meter_no' => [
                    'nullable',
                    'string',
                    Rule::unique('kyc_and_nominees', 'member_kyc_meter_no')->ignore($id),
                ],

                'member_kyc_ci_no' => 'nullable|string',
                'member_kyc_ci_relation' => 'nullable|string',
                'member_kyc_dl_no' => 'nullable|string',
                'member_kyc_passport_no' => 'nullable|string',
                'member_kyc_pan_number' => 'nullable|file|mimes:jpeg,png,jpg,pdf',

                // Nominee Info
                'nominee_name' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'nominee_relation' => 'nullable|string',
                'nominee_mobile_no' => 'nullable|string',
                'nominee_gender' => 'nullable|in:Male,Female,Other',
                'nominee_dob' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'nominee_aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'nominee_voter_id_no' => 'nullable|string',
                'nominee_pan_no' => 'nullable|string',
                'nominee_ration_card_no' => 'nullable|string',
                'nominee_address' => 'nullable|string',

                // Extra Settings
                'extra_sms' => 'nullable|boolean',
                // Membership Charges
                'transaction_date	' => 'required|date|before_or_equal:today',
                'membership_fee' => 'nullable|numeric',
                'net_fee_to_collect' => 'required|numeric',
                'remarks' => 'nullable|string',
                'charges_pay_mode' => 'required|in:cash,online,cheque',
            ]);

            $request->merge([
                'general_enrollment_date' => $request->general_enrollment_date ? Carbon::parse($request->general_enrollment_date)->format('d-m-Y') : null,
                'member_info_dob' => $request->member_info_dob ? Carbon::parse($request->member_info_dob)->format('d-m-Y') : null,
                'member_info_spouse_dob' => $request->member_info_spouse_dob ? Carbon::parse($request->member_info_spouse_dob)->format('d-m-Y') : null,
                'nominee_dob' => $request->nominee_dob ? Carbon::parse($request->nominee_dob)->format('d-m-Y') : null,
                'charges_transaction_date' => $request->charges_transaction_date ? Carbon::parse($request->charges_transaction_date)->format('d-m-Y') : null,
            ]);

            $member = Member::findOrFail($id);
            $memberData = $request->only((new Member)->getFillable());
            $addressData = $request->only((new Address)->getFillable());
            $kycData = $request->only((new KycAndNominee)->getFillable());

            $member->update($memberData);
            $member->address()->update($addressData);
            $member->kyc()->update($kycData);

            return redirect()->route('member.index')->with('success', 'Member updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function destroy(string $id)
    {
        //
    }


    public function createMinor(Request $request)
    {
        try {
            $memberId = $request->input('member_id');
            $type = $request->input('type');

            $parentMember = Member::findOrFail($memberId);

            if ($type !== 'promoter') {
                return redirect()->back()->with('error', 'Minor can only be added under a promoter.');
            }

            return view('members.minor.create', compact('parentMember'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function storeMinor(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'parent_id' => 'required|exists:members,id',
            ]);

            $parent = Member::findOrFail($validated['parent_id']);

            if ($parent->type !== 'promoter') {
                return redirect()->back()->with('error', 'Minor must be added under a promoter.');
            }

            $minor = new Member();
            $minor->name = $validated['name'];
            $minor->type = 'minor';
            $minor->parent_id = $parent->id;
            $minor->save();

            return redirect()->route('members.index')->with('success', 'Minor member added under promoter.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getShareHoldings($id)
    {
        try {
            Log::info("📥 [getShareHoldings] Requested for Member ID: {$id}");

            $member = Member::findOrFail($id);
            Log::info("✅ Member found: {$member->name} (ID: {$member->id})");

            $query = $member->shareHoldings();


            Log::info("🔍 Executing query: shareHoldings with conditions (transfer_date NOT NULL OR is_surrendered = true)");

            $shareholdings = $query->get();

            Log::info("📊 Found {$shareholdings->count()} matching shareholding records for Member ID: {$id}");

            $formatted = $shareholdings->map(function ($share) {
                return [
                    'share_range' => $share->share_from . ' - ' . $share->share_to,
                    'total_shares' => $share->total_shares,
                    'nominal_value' => number_format($share->share_nominal, 2),
                    'total_value' => number_format($share->total_share_value, 2),
                    'allotment_date' => \Carbon\Carbon::parse($share->allotment_date)->format('d-m-Y'),
                    'transfer_date' => $share->transfer_date ? \Carbon\Carbon::parse($share->transfer_date)->format('d-m-Y') : '-',
                    'is_surrendered' => $share->is_surrendered,
                    'id' => $share->id,
                ];
            });

            Log::info("✅ Successfully formatted shareholdings. Returning JSON response.");

            return response()->json($formatted);
        } catch (\Exception $e) {
            Log::error("❌ Error in getShareHoldings for Member ID {$id}: " . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch shareholding data'], 500);
        }
    }

    public function shareholding($id)
    {
        try {
            Log::info("Fetching shareholding view for member ID: {$id}");

            $member = Member::findOrFail($id);
            Log::info("Found member: {$member->name} (ID: {$member->id})");

            $shareholdings = ShareTransfer::with('members')->where('member_id', $member->id)
                ->where('status', 'approved')->get();
            $finalizedShares = $shareholdings->groupBy('share_range')->toArray();

            if ($shareholdings->isEmpty()) {
                Log::info("No shareholdings found for member ID: {$id}");
            } else {
                Log::info("Successfully fetched shareholdings for member ID: {$id}, Total: " . $shareholdings->count());
            }
            return view('members.member.shareholding', compact('member', 'finalizedShares', 'shareholdings'));
        } catch (\Exception $e) {
            Log::error("Error fetching shareholding for member ID {$id}: " . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching shareholding data.');
        }
    }
    public function viewShareholding($id)
    {
        try {
            $share = ShareTransfer::findOrFail($id);

            return view('members.member.shareholding_view', compact('share'));
        } catch (\Exception $e) {
            Log::error("Error fetching shareholding details for ID {$id}: " . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching shareholding details.');
        }
    }
    public function addressedit(string $id)
    {
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id'),
                'branch' => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id'),
            ];

            $method = 'PUT';
            $memberModel = Member::with('address', 'kyc')->findOrFail($id);

            $member = array_merge(
                $memberModel->toArray(),
                $memberModel->address?->toArray() ?? [],
                $memberModel->kyc?->toArray() ?? []
            );

            $sections = config('address_form');
            $route = route('member.address.update', $id); // Corrected route name
            session(['member_id' => $id]);

            return view('members.member.address', compact('sections', 'member', 'route', 'method', 'dynamicOptions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function addressupdate(Request $request, string $id)
    {
        try {
            $request->validate([
                'member_address_line_1' => 'nullable|string',
                'member_address_line_2' => 'nullable|string',
                'member_address_para' => 'nullable|string',
                'member_address_ward' => 'nullable|string',
                'member_address_panchayat' => 'nullable|string',
                'member_address_area' => 'nullable|string',
                'member_address_landmark' => 'nullable|string',
                'member_address_city_district' => 'nullable|string',
                'member_address_state' => 'required|string',
                'member_address_pincode' => 'nullable|numeric',
                'member_address_country' => 'required|string',
                'member_address_address' => 'nullable|string',
                'member_perm_address_city' => 'nullable|string',
                'member_perm_address_state' => 'nullable|string',
                'member_perm_address_pincode' => 'nullable|numeric',
                'member_gps_location_latitude' => 'nullable|string',
                'member_gps_location_longitude' => 'nullable|numeric',
            ]);

            $member = Member::findOrFail($id);
            $addressData = $request->only((new Address)->getFillable());

            // Ensure the address is correctly created or updated for the specific member
            $member->address()->updateOrCreate(
                ['member_id' => $member->id],  // Where condition
                $addressData                  // Data to update or insert
            );

            return redirect()->route('member.index')->with('success', 'Member address updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function editmobile(string $id)
    {
        try {
            $method = 'PUT';
            $memberModel = Member::with('address', 'kyc')->findOrFail($id);
            $member = array_merge(
                $memberModel->toArray(),
                $memberModel->address?->toArray() ?? [],
                $memberModel->kyc?->toArray() ?? []
            );

            $sections = config('mobile_form');
            $route = route('member.updatemobile', $id);
            session(['member_id' => $id]);
            return view('members.member.mobile', compact('sections', 'member', 'route', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function updatemobile(Request $request, string $id)
    {
        try {
            $request->validate([
                'member_info_mobile_no' => 'required|string|max:10',
                'member_info_email' => 'nullable|email',
            ]);

            $member = Member::findOrFail($id);
            $memberData = $request->only((new Member)->getFillable());

            $member->update($memberData);

            return redirect()->route('member.index')->with('success', 'Member updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function getMembers()
    {
        try {
            $members = Member::select('id', 'member_info_first_name')->get();
            return response()->json($members);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getMemberDetails($id)
    {
        $member = Member::findOrFail($id, ['id', 'member_info_first_name', 'member_info_address', 'member_info_mobile']);

        return response()->json($member);
    }
    public function showTransactions($memberId)
    {
        // $member = Member::findOrFail($memberId);
        $member = Member::latest()->first(); // Based on created_at


        // Fetch transactions in descending order by date
        $transactions = MembershipChargeTransaction::where('member_id', $member->id)
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);


        return view('members.member.transactions', compact('member', 'transactions'));
    }

    public function storeTransaction(Request $request, $memberId)
    {
        $request->validate([
            'transaction_date'     => 'required|date',
            'membership_fee'       => 'required|numeric|min:0',
            'remarks'              => 'nullable|string|max:1000',
            'charges_pay_mode'     => 'required|in:cash,online,cheque,saving',
            'type'                 => 'required|string',
            'approve_status'       => 'nullable|boolean',
            'is_accounted'         => 'nullable|boolean',
        ]);

        MembershipChargeTransaction::create([
            'transaction_date'     => $request->transaction_date,
            'membership_fee'       => $request->membership_fee,
            'net_fee_to_collect'   => $request->membership_fee,
            'remarks'              => $request->remarks,
            'charges_pay_mode'     => $request->charges_pay_mode,
            'member_id'            => $memberId,
        ]);

        return redirect()->route('members.member.transactions', $memberId)
            ->with('success');
    }

    public function createShareAmount($id)
    {
        $member = Member::findOrFail($id);

        return view('members.member.shareAmount', compact('member'));
    }

    public function storeShareAmount(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'transaction_date'     => 'required|date',
            'membership_fee'       => 'required|numeric|min:0',
            'remarks'              => 'nullable|string|max:1000',
            'charges_pay_mode'     => 'required|in:cash,online,cheque,saving',
            'approve_status'       => 'nullable|boolean',
            'is_accounted'         => 'nullable|boolean',

            // Optional fields
            'online_utr_no'        => 'nullable|regex:/^[a-zA-Z0-9\-]+$/',
            'transfer_date'        => 'nullable|date',
            'transfer_mode'        => 'nullable|in:IMPS,VPA,NEFT/RTGS',
            'bank_id'              => 'nullable|integer|exists:banks,id',
            'cheque_no'            => 'nullable|regex:/^\d{6,}$/',
            'cheque_date'          => 'nullable|date',
            'saving_account_id'    => 'nullable|integer|exists:saving_accounts,id',
        ]);

        $data = [
            'transfer_date'     => $validated['transaction_date'],
            'membership_fee'       => $validated['membership_fee'],
            'net_fee_to_collect'   => $validated['membership_fee'],
            'remarks'              => $validated['remarks'] ?? null,
            'charges_pay_mode'     => $validated['charges_pay_mode'],
            'type'                 => 'Share amount', // ✅ Hardcoded
            'approve_status'       => $validated['approve_status'] ?? 0,
            'is_accounted'         => $validated['is_accounted'] ?? 0,
            'member_id'            => $member->id,
        ];
        $transferDate = \Carbon\Carbon::parse($request->transfer_date)->format('Y-m-d');

        // Add optional fields
        if ($validated['charges_pay_mode'] === 'online') {
            $data['transfer_date'] = $validated['transfer_date'] ?? null;
            $data['online_utr_no'] = $validated['online_utr_no'] ?? null;
            $data['transfer_mode'] = $validated['transfer_mode'] ?? null;
        }

        if ($validated['charges_pay_mode'] === 'cheque') {
            $data['cheque_no'] = $validated['cheque_no'] ?? null;
            $data['cheque_date'] = $validated['cheque_date'] ?? null;
            $data['bank_id'] = $validated['bank_id'] ?? null;
        }

        if ($validated['charges_pay_mode'] === 'saving') {
            $data['saving_account_id'] = $validated['saving_account_id'] ?? null;
        }

        $transaction = MembershipChargeTransaction::create($data);

        Log::info('Share Amount Transaction Created', [
            'member_id'        => $member->id,
            'member_name'      => $member->member_info_first_name ?? null,
            'payment_mode'     => $validated['charges_pay_mode'],
            'membership_fee'   => $validated['membership_fee'],
            'transaction_id'   => $transaction->id,
        ]);

        return redirect()
            ->route('members.transactions', $id)
            ->with('success', 'Transaction added successfully!');
    }
}
