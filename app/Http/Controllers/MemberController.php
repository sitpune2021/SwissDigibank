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
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;


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
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    public function create()
    {
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id'),
                'branch' => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id')
            ];
            $sections = config('member_form');
            $member = null;
            $route = route('member.store');
            $method = 'POST';
            return view('members.member.create', compact('sections', 'member', 'route', 'method', 'dynamicOptions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                // Membership Type
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
                'member_info_dob'        => 'required|date|before_or_equal:today',
                'member_info_qualification' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_occupation' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_monthly_income' => 'nullable|numeric',
                'member_info_old_member_no' => 'nullable|string',
                'member_info_father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_spouse_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_spouse_dob' => 'nullable|date|before_or_equal:today',
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
                'member_address_pincode' => 'required|numeric',
                'member_address_country' => 'required|string',
                'member_address_address' => 'nullable|string',

                // Permanent Address
                'member_perm_address_city' => 'nullable|string',
                'member_perm_address_state' => 'nullable|string',
                'member_perm_address_pincode' => 'nullable|numeric',

                // GPS Location
                'member_gps_location_latitude' => 'nullable|string',
                'member_gps_location_longitude' => 'nullable|numeric',

                // KYC Info
                'member_kyc_aadhaar_no' => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                'member_kyc_voter_id_no' => 'nullable|string',
                'member_kyc_pan_no' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
                'member_kyc_ration_card_no' => 'nullable|string',
                'member_kyc_meter_no' => 'nullable|string',
                'member_kyc_ci_no' => 'nullable|string',
                'member_kyc_ci_relation' => 'nullable|string',
                'member_kyc_dl_no' => 'nullable|string',
                'member_kyc_passport_no' => 'nullable|string',

                // Nominee Info
                'nominee_name' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'nominee_relation' => 'nullable|string',
                'nominee_mobile_no' => 'nullable|string',
                'nominee_gender' => 'nullable|in:Male,Female,Other',
                'nominee_dob' => 'nullable|date|before_or_equal:today',
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
                'charges_remarks' => 'nullable|string',
                'charges_pay_mode' => 'required|in:cash,online,cheque',
            ]);

            $request->merge([
                'general_enrollment_date' => $request->general_enrollment_date ? Carbon::parse($request->general_enrollment_date)->format('D M d Y') : null,
                'member_info_dob' => $request->member_info_dob ? Carbon::parse($request->member_info_dob)->format('D M d Y') : null,
                'member_info_spouse_dob' => $request->member_info_spouse_dob ? Carbon::parse($request->member_info_spouse_dob)->format('D M d Y') : null,
                'nominee_dob' => $request->nominee_dob ? Carbon::parse($request->nominee_dob)->format('D M d Y') : null,
                'charges_transaction_date' => $request->charges_transaction_date ? Carbon::parse($request->charges_transaction_date)->format('D M d Y') : null,
            ]);

            $memberData = $request->only((new Member)->getFillable());
            $addressData = $request->only((new Address)->getFillable());
            $kycData = $request->only((new KycAndNominee)->getFillable());

            $member = Member::create($memberData);
            $member->address()->create(array_merge($addressData, ['member_id' => $member->id]));
            $member->kyc()->create(array_merge($kycData, ['member_id' => $member->id]));
            return redirect()->route('member.index')->with('success', 'Member created successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
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
            $sections = config('member_form');
            $show = true;
            $button = true;
            $method = 'PUT';
            $minor = true;
            session(['member_id' => $id]);
            session(['type' => "member"]);

            return view('members.member.show ', compact('sections', 'member', 'show', 'dynamicOptions', 'button', 'minor', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    public function documentShow(string $id)
    {
        try {
            $route = route('member.documentupdate', $id);
            $method = 'POST';
            $documents = KycDocument::where('member_id', $id)->get()->keyBy('document_category');
            // dd($documents);
            return view('members.member.kycDocumentAdd', compact('route', 'method', 'id', 'documents'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
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

            return redirect()->route('member.index')->with('success', 'Member updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
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
            $member = array_merge(
                $memberModel->toArray(),
                $memberModel->address?->toArray() ?? [],
                $memberModel->kyc?->toArray() ?? []
            );

            $sections = config('member_form');
            $route = route('member.update', $id);
            session(['member_id' => $id]);
            $minor = true;
            return view('members.member.create', compact('sections', 'member', 'route', 'method', 'dynamicOptions', 'minor'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                // (Same validation rules as in store)
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
                'member_info_dob' => 'required|date|before_or_equal:today',
                'member_info_qualification' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_occupation' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_monthly_income' => 'nullable|numeric',
                'member_info_old_member_no' => 'nullable|string',
                'member_info_father_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_spouse_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_spouse_dob' => 'nullable|date|before_or_equal:today',
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
                'member_address_country' => 'required|string',
                'member_address_address' => 'nullable|string',

                // Permanent Address
                'member_perm_address_city' => 'nullable|string',
                'member_perm_address_state' => 'nullable|string',
                'member_perm_address_pincode' => 'nullable|numeric',

                // GPS Location
                'member_gps_location_latitude' => 'nullable|string',
                'member_gps_location_longitude' => 'nullable|numeric',

                // KYC Info
                'member_kyc_aadhaar_no' => 'required|string',
                'member_kyc_voter_id_no' => 'nullable|string',
                'member_kyc_pan_no' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
                'member_kyc_ration_card_no' => 'nullable|string',
                'member_kyc_meter_no' => 'nullable|string',
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
                'nominee_dob' => 'nullable|date|before_or_equal:today',
                'nominee_aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
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
                'charges_remarks' => 'nullable|string',
                'charges_pay_mode' => 'nullable|in:cash,online,cheque',
            ]);

            $request->merge([
                'general_enrollment_date' => $request->general_enrollment_date ? Carbon::parse($request->general_enrollment_date)->format('D M d Y') : null,
                'member_info_dob' => $request->member_info_dob ? Carbon::parse($request->member_info_dob)->format('D M d Y') : null,
                'member_info_spouse_dob' => $request->member_info_spouse_dob ? Carbon::parse($request->member_info_spouse_dob)->format('D M d Y') : null,
                'nominee_dob' => $request->nominee_dob ? Carbon::parse($request->nominee_dob)->format('D M d Y') : null,
                'charges_transaction_date' => $request->charges_transaction_date ? Carbon::parse($request->charges_transaction_date)->format('D M d Y') : null,
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
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    public function destroy(string $id)
    {
        //
    }


    public function createMinor(Request $request)
    {
        try {
            $memberId = $request->input('member_id'); // e.g. 4
            $type = $request->input('type'); // e.g. 'promoter' or 'member'

            $parentMember = Member::findOrFail($memberId);

            // Check type validity
            if ($type !== 'promoter') {
                return redirect()->back()->with('error', 'Minor can only be added under a promoter.');
            }

            return view('members.minor.create', compact('parentMember'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
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
        } catch (\Throwable $e) {
            abort(500);
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
        } catch (\Throwable $e) {
            abort(500);
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
        } catch (\Throwable $e) {
            abort(500);
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
        } catch (\Throwable $e) {
            abort(500);
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
        } catch (\Throwable $e) {
            abort(500);
        }
    }


    public function getMembers()
    {
        try {
            $members = Member::select('id', 'member_info_first_name')->get();
            return response()->json($members);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
        }
    }
}
