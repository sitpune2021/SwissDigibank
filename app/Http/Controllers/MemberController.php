<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Address;
use App\Models\KycAndNominee;
use App\Models\State;
use App\Models\Branch;
use App\Models\Religion;

class MemberController extends Controller
{
    
    public function index()
    {
        $members = Member::latest()->get(); 
         session()->forget('member_id');
        return view('members.member.index', compact('members'));

    }

    
    public function create()
    {
        $dynamicOptions = [
            'states' =>State::pluck('name', 'id'),
            'branch' => Branch::pluck('branch_name', 'id'),
            'religion' => Religion::pluck('name', 'id')
        ];
        $sections = config('member_form');
        $member = null;
        $route = route('member.store');
        $method = 'POST';
        return view('members.member.create', compact('sections', 'member', 'route', 'method', 'dynamicOptions'));

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
            'general_enrollment_date' => 'nullable',

            // Member Info
            'member_info_title' => 'required|in:md,mr,ms,mrs',
            'member_info_gender' => 'required|in:male,female,other',
            'member_info_first_name' => 'required|string',
            'member_info_middle_name' => 'nullable|string',
            'member_info_last_name' => 'required|string',
            'member_info_dob' => 'required',
            'member_info_qualification' => 'nullable|string',
            'member_info_occupation' => 'nullable|string',
            'member_info_monthly_income' => 'nullable|numeric',
            'member_info_old_member_no' => 'nullable|string',
            'member_info_father_name' => 'nullable|string',
            'member_info_mother_name' => 'nullable|string',
            'member_info_spouse_name' => 'nullable|string',
            'member_info_spouse_dob' => 'nullable',
            'member_info_mobile_no' => 'required|string',
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
            'member_kyc_aadhaar_no' => 'required|string',
            'member_kyc_voter_id_no' => 'nullable|string',
            'member_kyc_pan_no' => 'nullable|string',
            'member_kyc_ration_card_no' => 'nullable|string',
            'member_kyc_meter_no' => 'nullable|string',
            'member_kyc_ci_no' => 'nullable|string',
            'member_kyc_ci_relation' => 'nullable|string',
            'member_kyc_dl_no' => 'nullable|string',
            'member_kyc_passport_no' => 'nullable|string',

            // KYC Documents
            'member_kyc_photo' => 'nullable|file|image',
            'member_kyc_signature' => 'nullable|file|image',
            'member_kyc_id_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'member_kyc_id_proof_back' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'member_kyc_address_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'member_kyc_address_proof_back' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
            'member_kyc_pan_number' => 'nullable|file|mimes:jpeg,png,jpg,pdf',

            // Nominee Info
            'nominee_name' => 'nullable|string',
            'nominee_relation' => 'nullable|string',
            'nominee_mobile_no' => 'nullable|string',
            'nominee_gender' => 'nullable|in:Male,Female,Other',
            'nominee_dob' => 'nullable',
            'nominee_aadhaar_no' => 'nullable|string',
            'nominee_voter_id_no' => 'nullable|string',
            'nominee_pan_no' => 'nullable|string',
            'nominee_ration_card_no' => 'nullable|string',
            'nominee_address' => 'nullable|string',

            // Extra Settings
            'extra_sms' => 'nullable|boolean',

            // Membership Charges
            'charges_transaction_date' => 'required',
            'charges_membership_fee' => 'nullable|numeric',
            'charges_net_fee' => 'required|numeric',
            'charges_remarks' => 'nullable|string',
            'charges_pay_mode' => 'required|in:cash,online,cheque',
        ]);

        $memberData = $request->only((new Member)->getFillable());
        $addressData = $request->only((new Address)->getFillable());
        $kycData = $request->only((new KycAndNominee)->getFillable());


        if ($request->filled('general_enrollment_date')) {
            $kycData['general_enrollment_date'] = date('Y-m-d', strtotime($request->input('general_enrollment_date')));
        }

        if ($request->filled('member_info_dob')) {
            $kycData['member_info_dob'] = date('Y-m-d', strtotime($request->input('member_info_dob')));
        }

        if ($request->filled('member_info_spouse_dob')) {
            $kycData['member_info_spouse_dob'] = date('Y-m-d', strtotime($request->input('member_info_spouse_dob')));
        }

        if ($request->filled('nominee_dob')) {
            $kycData['nominee_dob'] = date('Y-m-d', strtotime($request->input('nominee_dob')));
        }

        if ($request->filled('charges_transaction_date')) {
            $kycData['charges_transaction_date'] = date('Y-m-d', strtotime($request->input('charges_transaction_date')));
        }


        $member = Member::create($memberData);
        $member->address()->create(array_merge($addressData, ['member_id' => $member->id]));
        $member->kyc()->create(array_merge($kycData, ['member_id' => $member->id]));
        return redirect()->route('member.index')->with('success', 'Member created successfully.');
    }

    
    public function show(string $id)
    {
        $dynamicOptions = [
            'states' =>State::pluck('name', 'id'),
            'branch' => Branch::pluck('branch_name', 'id'),
            'religion' => Religion::pluck('name', 'id')
        ];
        $member = Member::with('address', 'kyc')->findOrFail($id);
        // $member = array_merge(
        //     $memberModel->toArray(),
        //     $memberModel->address?->toArray() ?? [],
        //     $memberModel->kyc?->toArray() ?? []
        // );

        $sections = config('member_form');
        $show = true;
        $button=true;
        $method='PUT';
        $minor = true;
        session(['member_id' => $id]);
        return view('members.member.show ', compact('sections', 'member', 'show', 'dynamicOptions','button', 'minor','method'));
    }

    
 public function edit(string $id)
    {
        $dynamicOptions = [
            'states' =>State::pluck('name', 'id'),
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
        $route = route('member.update', $id) ;
        session(['member_id' => $id]);
        $minor = true;
        return view('members.member.create', compact('sections', 'member', 'route', 'method', 'dynamicOptions', 'minor'));
    }
 

   
    public function update(Request $request, string $id)
{
    $request->validate([
        // (Same validation rules as in store)
        'membership_type' => 'required|in:nominal,regular',
        'general_advisor_staff' => 'nullable|string',
        'general_group' => 'nullable|in:group1,group2',
        'general_branch' => 'required|string',
        'general_enrollment_date' => 'nullable',
        'member_info_title' => 'required|in:md,mr,ms,mrs',
        'member_info_gender' => 'required|in:male,female,other',
        'member_info_first_name' => 'required|string',
        'member_info_middle_name' => 'nullable|string',
        'member_info_last_name' => 'required|string',
        'member_info_dob' => 'required',
        'member_info_qualification' => 'nullable|string',
        'member_info_occupation' => 'nullable|string',
        'member_info_monthly_income' => 'nullable|numeric',
        'member_info_old_member_no' => 'nullable|string',
        'member_info_father_name' => 'nullable|string',
        'member_info_mother_name' => 'nullable|string',
        'member_info_spouse_name' => 'nullable|string',
        'member_info_spouse_dob' => 'nullable',
        'member_info_mobile_no' => 'required|string',
        'member_info_collection_time' => 'nullable|string',
        'member_info_marital_status' => 'nullable|in:single,married,divorced,widowed,separated',
        'member_info_religion' => 'nullable|string',
        'member_info_email' => 'nullable|email',
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
        'member_kyc_aadhaar_no' => 'required|string',
        'member_kyc_voter_id_no' => 'nullable|string',
        'member_kyc_pan_no' => 'required|string',
        'member_kyc_ration_card_no' => 'nullable|string',
        'member_kyc_meter_no' => 'nullable|string',
        'member_kyc_ci_no' => 'nullable|string',
        'member_kyc_ci_relation' => 'nullable|string',
        'member_kyc_dl_no' => 'nullable|string',
        'member_kyc_passport_no' => 'nullable|string',
        'member_kyc_photo' => 'nullable|file|image',
        'member_kyc_signature' => 'nullable|file|image',
        'member_kyc_id_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'member_kyc_id_proof_back' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'member_kyc_address_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'member_kyc_address_proof_back' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'member_kyc_pan_number' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        'nominee_name' => 'nullable|string',
        'nominee_relation' => 'nullable|string',
        'nominee_mobile_no' => 'nullable|string',
        'nominee_gender' => 'nullable|in:Male,Female,Other',
        'nominee_dob' => 'nullable',
        'nominee_aadhaar_no' => 'nullable|string',
        'nominee_voter_id_no' => 'nullable|string',
        'nominee_pan_no' => 'nullable|string',
        'nominee_ration_card_no' => 'nullable|string',
        'nominee_address' => 'nullable|string',
        'extra_sms' => 'nullable|boolean',
        'charges_transaction_date' => 'required',
        'charges_membership_fee' => 'nullable|numeric',
        'charges_net_fee' => 'required|numeric',
        'charges_remarks' => 'nullable|string',
        'charges_pay_mode' => 'nullable|in:cash,online,cheque',
    ]);

    $member = Member::findOrFail($id);
    $memberData = $request->only((new Member)->getFillable());
    $addressData = $request->only((new Address)->getFillable());
    $kycData = $request->only((new KycAndNominee)->getFillable());

    if ($request->filled('general_enrollment_date')) {
        $kycData['general_enrollment_date'] = date('Y-m-d', strtotime($request->input('general_enrollment_date')));
    }
    if ($request->filled('member_info_dob')) {
        $kycData['member_info_dob'] = date('Y-m-d', strtotime($request->input('member_info_dob')));
    }
    if ($request->filled('member_info_spouse_dob')) {
        $kycData['member_info_spouse_dob'] = date('Y-m-d', strtotime($request->input('member_info_spouse_dob')));
    }
    if ($request->filled('nominee_dob')) {
        $kycData['nominee_dob'] = date('Y-m-d', strtotime($request->input('nominee_dob')));
    }
    if ($request->filled('charges_transaction_date')) {
        $kycData['charges_transaction_date'] = date('Y-m-d', strtotime($request->input('charges_transaction_date')));
    }

    $member->update($memberData);
    $member->address()->update($addressData);
    $member->kyc()->update($kycData);

    return redirect()->route('member.index')->with('success', 'Member updated successfully.');
}

    public function destroy(string $id)
    {
        //
    }
}
