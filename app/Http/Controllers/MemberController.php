<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Address;
use App\Models\KycAndNominee;
use App\Models\State;
use App\Models\Branch;
use App\Models\Religion;
use App\Models\Bank;
use App\Models\KycDocument;
use App\Models\MemberOtherCharge;
use App\Models\ShareTransfer;
use App\Models\Shareholding;
use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MembershipChargeTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use App\Models\Transaction;
use App\Models\Group;
use Illuminate\Support\Facades\Http;
use App\Helpers\MufinHelper;

class MemberController extends Controller
{


    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // If the logged-in user is a Member, redirect to their own profile
            if ($user && optional($user->role)->name === 'Member') {
                $member = Member::where('member_info_email', $user->email)
                    ->orWhere('member_info_mobile_no', $user->mobile)
                    ->first();

                if ($member) {
                    return redirect()->route('member.show', $member->id);
                } else {
                    abort(403, 'Member record not found for this user.');
                }
            }
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

            $members = $query->latest()->paginate(30);

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
                'groups'   => Group::where('is_active', 1)->pluck('group_name', 'id'),
            ];

            // $banks = Bank::all();
            $banks = Bank::pluck('name', 'id');
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
                compact('sections', 'member', 'route', 'method', 'dynamicOptions', 'documents', 'advisors', 'banks')
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
            'member_info_first_name'  => 'required|string|max:255|regex:/^[A-Za-z]+$/',
            'member_info_middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
            'member_info_last_name'   => 'required|string|max:255|regex:/^[A-Za-z]+$/',
            'member_info_dob' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'member_info_qualification' => 'nullable|string',
            'member_info_occupation' => 'nullable|string',
            'member_info_monthly_income' => 'nullable|numeric',
            'member_info_old_member_no' => 'nullable|string',
            'member_info_father_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'member_info_mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'member_info_spouse_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',

            'member_info_spouse_dob' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'member_info_email' => 'required|unique:members,member_info_email|unique:users,email',
            'member_info_mobile_no' => 'required|digits:10|unique:members,member_info_mobile_no|unique:users,mobile',

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
            'member_kyc_aadhaar_no'     => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/|unique:kyc_and_nominees,member_kyc_aadhaar_no',
            // 'member_kyc_aadhaar_no'     => 'required|digits:12|regex:/^[2-9]{1}[0-9]{11}$/|unique:kyc_and_nominees,member_kyc_aadhaar_no',
            'member_kyc_voter_id_no' => 'nullable|string|regex:/^[A-Za-z0-9]+$/|unique:kyc_and_nominees,member_kyc_voter_id_no',
            'member_kyc_pan_no'         => 'nullable|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|unique:kyc_and_nominees,member_kyc_pan_no',
            // 'member_kyc_pan_no'         => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/|unique:kyc_and_nominees,member_kyc_pan_no',
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
            'nominee_voter_id_no'    => 'nullable|string|regex:/^[A-Za-z0-9]+$/',
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
            // Format date fields into Y-m-d
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


            // Generate padded member_no
            $nextId = (Member::max('id') ?? 0) + 1;
            $memberNo = str_pad($nextId, 6, '0', STR_PAD_LEFT);

            // Create Member (only once ✅)
            $memberData = $request->only((new Member)->getFillable());
            $memberData['member_no'] = $memberNo;
            $member = Member::create($memberData);

            Log::info('Member created successfully', ['member_id' => $member->id, 'member_no' => $member->member_no]);

            // Create Address
            $addressData = $request->only((new Address)->getFillable());
            $member->address()->create(array_merge($addressData, ['member_id' => $member->id]));

            // Create KYC & Nominee
            $kycData = $request->only((new KycAndNominee)->getFillable());
            $member->kyc()->create(array_merge($kycData, ['member_id' => $member->id]));

            // Store KYC documents
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

            // Store Membership Charge Transaction
            $transaction = MembershipChargeTransaction::create([
                'member_id' => $member->id,
                'transaction_date' => Carbon::parse($request->charges_transaction_date)->format('Y-m-d'),
                'membership_fee' => $request->charges_membership_fee ?? 0,
                'net_fee_to_collect' => $request->charges_net_fee,
                'remarks' => $request->charges_remarks ?? null,
                'charges_pay_mode' => $request->charges_pay_mode,
                'online_utr_no' => $request->charges_pay_mode === 'online' ? $request->online_utr_no : null,
                'online_transfer_mode' => $request->charges_pay_mode === 'online' ? $request->online_transfer_mode : null,
                'bank_id' => in_array($request->charges_pay_mode, ['cheque', 'online']) ? $request->bank_id : null,
                'cheque_no' => $request->charges_pay_mode === 'cheque' ? $request->cheque_no : null,
                'cheque_date' => $request->charges_pay_mode === 'cheque' ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null,
                'type' => "Membership Charges" ?? null,
            ]);

            // ✅ Log the transaction data
            Log::info('MembershipChargeTransaction stored', [
                'transaction_id' => $transaction->id,
                'member_id' => $transaction->member_id,
                'pay_mode' => $transaction->charges_pay_mode,
                'bank_id' => $transaction->bank_id,
                'cheque_no' => $transaction->cheque_no,
                'cheque_date' => $transaction->cheque_date,
                'online_utr_no' => $transaction->online_utr_no,
                'online_transfer_mode' => $transaction->online_transfer_mode,
            ]);

            $managerRole = Role::where('name', 'Member')->first();

            if ($managerRole) {
                $user = User::create([
                    'name'       => $managerRole->name ?? 'Member',
                    'fname'      => $request->member_info_first_name ?? 'Member',
                    'lname'      => $request->member_info_last_name ?? 'Member',
                    'email'      => $request->member_info_email ?? 'member' . $member->id . '@gmail.com',
                    'mobile'     => $request->member_info_mobile_no ?? null,
                    'username'   => 'Member' . $member->id,
                    'password'   => Hash::make('member123'),
                    'role_id'    => $managerRole->id,
                    'branch_id'  => $member->general_branch ?? null,
                    'user_active' => true,
                ]);
                $member->user_id = $user->id;
                $member->save();
            }

            $apiKey = env('MUFFINPAY_API_KEY');
            $saltKey = env('MUFFINPAY_SALT_KEY');

            $payload = [
                "firstName" => $member->member_info_first_name,
                "lastName" => $member->member_info_last_name,
                "email" => $member->member_info_email,
                "mobileNumber" => $member->member_info_mobile_no,
                "userType" => "ROLE_INDIVIDUAL_MERCHANT_USER",
                "userCatg" => "INDIVIDUAL"
            ];

            $xverify = MufinHelper::generateXVerify($payload, $saltKey);
            // $body = json_encode($payload);

            // $hash = hash('sha256', $apiKey . $body . $saltKey);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'apiKey' => $apiKey,
                'xverifyv2' => $xverify
            ])->post(env('MUFFINPAY_URL') . '/user/create', $payload);

            $data = $response->json();

            Log::info('MuffinPay Create User', $data);

            if ($response->successful()) {

                $data = $response->json();

                Log::info('MufinPay API Response', $data);

                $mufUserId = $data['data']['userId'] ?? null;

                if ($mufUserId && isset($user)) {

                    $user->muf_user_id = $mufUserId;
                    $user->save();

                    Log::info('MufinPay User ID Stored', [
                        'user_id' => $user->id,
                        'muf_user_id' => $mufUserId
                    ]);
                }
            } else {

                Log::error('MuffinPay API Failed', [
                    'response' => $response->body()
                ]);
            }

            $kyc = KycAndNominee::where('member_id', $member->id)->first();

            if ($kyc && !empty($request->member_kyc_pan_no) && !empty($user->muf_user_id)) {

                $kyc->member_kyc_pan_no = $request->member_kyc_pan_no;
                $kyc->save();

                $panPayload = [
                    "idType" => "PAN_CARD",
                    "userId" => $user->muf_user_id,
                    "pan" => [
                        "number" => $kyc->member_kyc_pan_no,
                        "dob" => Carbon::parse($member->member_info_dob)->format('d/m/Y'),
                        "name" => trim(
                            $member->member_info_first_name . ' ' .
                                $member->member_info_middle_name . ' ' .
                                $member->member_info_last_name
                        )
                    ]
                ];

                $xverifyPan = MufinHelper::generateXVerify($panPayload, env('MUFFINPAY_SALT_KEY'));

                $panResponse = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'apiKey' => env('MUFFINPAY_API_KEY'),
                    'xverifyv2' => $xverifyPan
                ])->post(env('MUFFINPAY_URL') . '/kyc/submit', $panPayload);

                $panData = $panResponse->json();

                Log::info('PAN Payload', $panPayload);
                Log::info('PAN Response', $panData);
            }
            $kyc = KycAndNominee::where('member_id', $member->id)->first();

            if ($kyc && !empty($kyc->member_kyc_aadhaar_no) && !empty($user->muf_user_id)) {

                $aadhaarPayload = [

                    "idType" => "AADHAAR_CARD",

                    "userId" => $user->muf_user_id,

                    "aadhaar" => [
                        "number" => $kyc->member_kyc_aadhaar_no
                    ]

                ];

                $xverifyAadhaar = MufinHelper::generateXVerify($aadhaarPayload, env('MUFFINPAY_SALT_KEY'));

                $aadhaarResponse = Http::withHeaders([

                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'apiKey' => env('MUFFINPAY_API_KEY'),
                    'xverifyv2' => $xverifyAadhaar

                ])->post(env('MUFFINPAY_URL') . '/kyc/submit', $aadhaarPayload);

                $aadhaarData = $aadhaarResponse->json();

                Log::info('MufinPay Aadhaar KYC Payload', $aadhaarPayload);
                Log::info('MufinPay Aadhaar KYC Response', $aadhaarData);
            }
            try {
                $member = \App\Models\Member::find($member->id);
                $mobile = $member->member_info_mobile_no;
                // if ($member && !empty($member->member_info_mobile_no)) {
                $dlttemplateid = 1707173529330693298;
                $password = "member123";

                $message = "Dear Customer, Thanks for becoming member of $mobile. Your login USERNAME - $mobile, PASSWORD -  $password. Note - Don't disclose USERNAME/PASSWORD to anyone. SBC GLOBAL
                ";
                \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            } catch (\Exception $e) {
                Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
            }

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
        // $member = Member::findOrFail($id);
        // $loggedInEmail  = Auth::user()->email;
        // $loggedInMobile = Auth::user()->mobile;

        // $loggedInMember = Member::where('member_info_email', $loggedInEmail)
        //     ->orWhere('member_info_mobile_no', $loggedInMobile)
        //     ->first();

        // if ($loggedInMember && $loggedInMember->id != $id) {
        //     abort(403, 'Unauthorized access');
        // }
        try {
            $dynamicOptions = [
                'states' => State::pluck('name', 'id'),
                'branch' => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id'),
            ];
            $member = Member::with('address', 'kyc', 'minors', 'religion', 'accounts.bank', 'memberOtherCharges')->findOrFail($id);

            $comments = MembershipChargeTransaction::where('member_id', $id)
                ->where('status', 'comment')
                ->orderBy('transaction_date', 'desc')
                ->paginate(5);
            $charge = MemberOtherCharge::where('status', 'DUE')
                ->first();

            $chargeId = $charge ? $charge->id : null;

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
                'shareholdings',
                'chargeId',
                'charge',
                'id',
                'comments'
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
                'states'   => State::pluck('name', 'id'),
                'branch'   => Branch::pluck('branch_name', 'id'),
                'religion' => Religion::pluck('name', 'id'),
                'groups'   => Group::where('is_active', 1)->pluck('group_name', 'id')
            ];

            $method = 'PUT';
            // $banks = Bank::all();
            $banks = Bank::pluck('name', 'id');

            $memberModel = Member::with('address', 'kyc')->findOrFail($id);

            $member = array_merge(
                $memberModel->toArray(),
                $memberModel->address?->toArray() ?? [],
                $memberModel->kyc?->toArray() ?? []
            );

            $dateFields = [
                'general_enrollment_date',
                'member_info_dob',
                'member_info_spouse_dob',
                'nominee_dob',
                'charges_transaction_date',
            ];

            foreach ($dateFields as $field) {
                if (!empty($member[$field])) {
                    try {
                        $member[$field] = \Carbon\Carbon::parse($member[$field])->format('d-m-Y');
                    } catch (\Exception $e) {
                        // keep original if parsing fails
                    }
                }
            }

            $sections = config('member_form');
            $route = route('member.update', $id);
            session(['member_id' => $id]);
            $minor = true;

            $empty = fn($category) => (object)[
                'file'          => null,
                'category'      => $category,
                'file_path'     => null,
                'document_type' => null,
            ];

            $existingDocs = KycDocument::where('member_id', $id)
                ->get()
                ->keyBy('document_category');

            $documents = [
                'photo'              => $existingDocs['photo'] ?? $empty('photo'),
                'signature'          => $existingDocs['signature'] ?? $empty('signature'),
                'id_proof'           => $existingDocs['id_proof'] ?? $empty('id_proof'),
                'id_proof_back'      => $existingDocs['id_proof_back'] ?? $empty('id_proof_back'),
                'address_proof'      => $existingDocs['address_proof'] ?? $empty('address_proof'),
                'address_proof_back' => $existingDocs['address_proof_back'] ?? $empty('address_proof_back'),
                'pan_number'         => $existingDocs['pan_number'] ?? $empty('pan_number'),
            ];

            return view('members.member.create', compact(
                'sections',
                'member',
                'route',
                'method',
                'dynamicOptions',
                'minor',
                'documents',
                'banks'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $kycId = optional(KycAndNominee::where('member_id', $id)->first())->id;
            // Validation Rules
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
                'member_info_first_name'  => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_last_name'   => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                'member_info_dob' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'member_info_qualification' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_occupation' => 'nullable|string|regex:/^[A-Za-z]+$/',
                'member_info_monthly_income' => 'nullable|numeric',
                'member_info_old_member_no' => 'nullable|string',
                'member_info_father_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
                'member_info_mother_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
                'member_info_spouse_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',

                'member_info_spouse_dob' => 'nullable|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'member_info_mobile_no' => 'required|string|max:10',
                'member_info_collection_time' => 'nullable|string',
                'member_info_marital_status' => 'nullable|in:single,married,divorced,widowed,separated',
                'member_info_religion' => 'nullable|string',
                'member_info_email' => 'nullable|email:rfc,dns|max:255',

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
                    'nullable',
                    'digits:12',
                    'regex:/^[2-9]{1}[0-9]{11}$/',
                    Rule::unique('kyc_and_nominees', 'member_kyc_aadhaar_no')->ignore($kycId),
                ],
                // 'member_kyc_aadhaar_no' => [
                //     'required',
                //     'digits:12',
                //     'regex:/^[2-9]{1}[0-9]{11}$/',
                //     Rule::unique('kyc_and_nominees', 'member_kyc_aadhaar_no')->ignore($kycId),
                // ],
                'member_kyc_voter_id_no' => 'nullable|string|regex:/^[A-Za-z0-9]+$/|unique:kyc_and_nominees,member_kyc_voter_id_no',

                'member_kyc_pan_no' => [
                    'nullable',
                    'string',
                    'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
                    Rule::unique('kyc_and_nominees', 'member_kyc_pan_no')->ignore($kycId),
                ],
                // 'member_kyc_pan_no' => [
                //     'required',
                //     'string',
                //     'regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
                //     Rule::unique('kyc_and_nominees', 'member_kyc_pan_no')->ignore($kycId),
                // ],
                'member_kyc_ration_card_no' => [
                    'nullable',
                    'string',
                    Rule::unique('kyc_and_nominees', 'member_kyc_ration_card_no')->ignore($kycId),
                ],
                'member_kyc_meter_no' => [
                    'nullable',
                    'string',
                    Rule::unique('kyc_and_nominees', 'member_kyc_meter_no')->ignore($kycId),
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
                'nominee_voter_id_no'    => 'nullable|string|regex:/^[A-Za-z0-9]+$/',
                'nominee_pan_no' => 'nullable|string',
                'nominee_ration_card_no' => 'nullable|string',
                'nominee_address' => 'nullable|string',

                // Extra Settings
                'extra_sms' => 'nullable|boolean',

                // Membership Charges
                'charges_transaction_date' => 'required|date|before_or_equal:today',
                'membership_fee' => 'nullable|numeric',
                'charges_net_fee' => 'required|numeric',
                'remarks' => 'nullable|string',
                'charges_pay_mode' => 'required|in:cash,online,cheque',
            ]);

            // Date Format Standardization
            $request->merge([
                'general_enrollment_date' => $request->general_enrollment_date ? Carbon::parse($request->general_enrollment_date)->format('Y-m-d') : null,
                'member_info_dob' => $request->member_info_dob ? Carbon::parse($request->member_info_dob)->format('Y-m-d') : null,
                'member_info_spouse_dob' => $request->member_info_spouse_dob ? Carbon::parse($request->member_info_spouse_dob)->format('Y-m-d') : null,
                'nominee_dob' => $request->nominee_dob ? Carbon::parse($request->nominee_dob)->format('Y-m-d') : null,
                'charges_transaction_date' => $request->charges_transaction_date ? Carbon::parse($request->charges_transaction_date)->format('Y-m-d') : null,
            ]);

            $member = Member::findOrFail($id);
            $memberData = $request->only((new Member)->getFillable());
            $addressData = $request->only((new Address)->getFillable());
            $kycData = $request->only((new KycAndNominee)->getFillable());

            $member->update($memberData);
            $member->address()->update($addressData);
            $member->kyc()->update($kycData);

            return redirect()->route('member.index')->with('success', 'Member updated successfully.');
        } catch (ValidationException $e) {
            // ✅ Log validation errors clearly
            Log::error('Member update validation failed', [
                'member_id' => $id,
                'errors' => $e->errors(),
                'input' => $request->only([
                    'member_kyc_aadhaar_no',
                    'member_kyc_pan_no',
                    'member_kyc_voter_id_no',
                    'member_info_first_name',
                    'member_info_last_name',
                    'member_info_dob'
                ])
            ]);

            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Member not found during update', ['member_id' => $id]);
            abort(404, 'Member not found');
        } catch (\Exception $e) {
            Log::error('Unexpected error in member update', [
                'message' => $e->getMessage(),
                'member_id' => $id,
            ]);
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
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
            $members = Member::select('id', 'member_info_first_name', 'member_info_last_name')->get();
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
    //Transaction index page 
    public function showTransactions($memberId)
    {

        $transactions = DB::select("
        SELECT * FROM (
            -- Membership Charges
            SELECT 
                id,
                member_id,
                transaction_date,
                net_fee_to_collect AS amount,
                charges_pay_mode AS pay_mode,
                type,
                    CASE 
                        WHEN type = 'Membership Charges' THEN 'Member Registration'
                        ELSE remarks
                    END AS remarks,
                    CASE WHEN approve_status = 1 THEN 'Approved' ELSE 'Pending' END AS status,
                is_accounted,
                'Membership Charge' AS transaction_source
            FROM membership_charges_transaction
            WHERE member_id = ? AND (deleted_at IS NULL OR deleted_at = 0)

            UNION ALL

            -- Grouped dues with same clearance_id
            SELECT
                MIN(id) AS id,
                member_id,
                transaction_date,
                SUM(charges) AS amount,
                pay_mode,
                'Normal' AS type,
                CONCAT('| consolidated transaction :: ', GROUP_CONCAT(clear_due_remarks ORDER BY id SEPARATOR ', ')) AS remarks,
                CASE 
                    WHEN SUM(CASE WHEN status = 'CLEARED' THEN 1 ELSE 0 END) = COUNT(*) THEN 'Approved'
                    ELSE 'Pending'
                END AS status,
                NULL AS is_accounted,
                'Other Charge' AS transaction_source
            FROM member_other_charges
            WHERE member_id = ?
              AND clearance_id IS NOT NULL
              AND (deleted_at IS NULL OR deleted_at = 0)
            GROUP BY clearance_id, member_id, transaction_date, pay_mode

            UNION ALL

            -- Single dues (not grouped)
            SELECT
                id,
                member_id,
                transaction_date,
                charges AS amount,
                pay_mode,
                'Normal' AS type,
                CONCAT('| consolidated transaction :: ', clear_due_remarks) AS remarks,
                CASE 
                    WHEN status = 'CLEARED' THEN 'Approved'
                    ELSE 'Pending'
                END AS status,
                NULL AS is_accounted,
                'Other Charge' AS transaction_source
            FROM member_other_charges
            WHERE member_id = ?
              AND clearance_id IS NULL
              AND (deleted_at IS NULL OR deleted_at = 0)
        ) AS combined_transactions
        ORDER BY transaction_date DESC, id DESC
    ", [$memberId, $memberId, $memberId]);

        return view('members.member.transactions', [
            'memberId' => $memberId,
            'transactions' => $transactions,
        ]);
    }

    //this is for transaction details view page
    public function showTransactionDetails($id)
    {
        // Detect which table actually contains this transaction ID
        $isMemberOtherCharge = DB::table('member_other_charges')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->exists();

        if ($isMemberOtherCharge) {
            // Fetch from member_other_charges table
            $query = "
            SELECT
                id,
                member_id,
                transaction_date,
                charges AS amount,
                pay_mode,
                type,
                CONCAT('| consolidated transaction ::', IFNULL(clear_due_remarks, '')) AS remarks,
                CASE WHEN status = 'PAID' THEN 'Approved' ELSE 'Pending' END AS status,
                NULL AS is_accounted,
                'Other Charge' AS transaction_source,
                created_at,
                updated_at,
                charge_type,
                clearance_id,
                charges_due,
                waived_amount,
                gst_rate,
                total_amount,
                rounding_off,
                net_amount,
                clear_due_remarks,
                transfer_date,
                utr_no,
                transfer_mode,
                credited_in_account,
                bank_id,
                cheque_no,
                cheque_date
            FROM
                member_other_charges
            WHERE
                id = ? AND deleted_at IS NULL
                AND type = 'Normal'
            LIMIT 1
        ";

            $transaction = DB::selectOne($query, [$id]);
        } else {
            // Otherwise fetch from membership_charges_transaction table
            $query = "
            SELECT
                id,
                member_id,
                transaction_date,
                net_fee_to_collect AS amount,
                charges_pay_mode AS pay_mode,
                 type,
                 CASE 
                    WHEN type = 'Membership Charges' THEN 'Member Registration'
                    ELSE remarks
                END AS remarks,
                CASE WHEN approve_status = 1 THEN 'Approved' ELSE 'Pending' END AS status,
                is_accounted,
                'Membership Charge' AS transaction_source,
                created_at,
                updated_at,
                NULL AS charge_type,
                NULL AS clearance_id,
                NULL AS charges_due,
                NULL AS waived_amount,
                NULL AS gst_rate,
                NULL AS total_amount,
                NULL AS rounding_off,
                NULL AS net_amount,
                NULL AS clear_due_remarks,
                NULL AS transfer_date,
                NULL AS utr_no,
                NULL AS transfer_mode,
                NULL AS credited_in_account,
                NULL AS bank_id,
                NULL AS cheque_no,
                NULL AS cheque_date
            FROM
                membership_charges_transaction
            WHERE
                id = ?
            AND type IN ('Share amount', 'Membership Charges')
            LIMIT 1
        ";

            $transaction = DB::selectOne($query, [$id]);
        }
        if (!$transaction) {
            abort(404, 'Transaction not found.');
        }

        // Fetch related data
        $member = Member::find($transaction->member_id);
        $branch = Branch::latest()->first();
        $Accounts = Account::latest()->first();

        $amountFormatted = '₹ ' . number_format($transaction->amount, 2);
        if (!empty($transaction->gst_rate)) {
            $amountFormatted .= ' (Incl. ' . number_format($transaction->gst_rate, 1) . ' % GST)';
        }

        return view('members.member.transactionshow', compact('member', 'transaction', 'branch', 'Accounts', 'amountFormatted'));
    }

    public function softDeleteTransaction($transactionId)
    {
        $transaction = MembershipChargeTransaction::findOrFail($transactionId);
        $memberId = $transaction->member_id;
        $transaction->delete();
        return redirect()->route('members.transactions', $memberId);
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
        $members = Member::findOrFail($id);
        $banks = Bank::all();
        $selectedBankId = 'bank_name';
        $savingAccounts = Account::where('member_id', $id)->get();

        return view('members.member.shareAmount', compact('members', 'banks', 'selectedBankId', 'savingAccounts'));
    }

    public function storeShareAmount(Request $request, $id)
    {
        try {
            Log::info('--- storeShareAmount called ---', [
                'member_id' => $id,
                'input_data' => $request->all(),
            ]);

            $member = Member::findOrFail($id);

            $validated = $request->validate([
                'transaction_date'     => 'required|date',
                'membership_fee'       => 'required|numeric|min:0',
                'remarks'              => 'nullable|string|max:1000',
                'charges_pay_mode'     => 'required|in:cash,online,cheque,saving',
                'approve_status'       => 'nullable|boolean',
                'is_accounted'         => 'nullable|boolean',
                'online_utr_no'        => 'nullable',
                'transfer_date'        => 'nullable|date',
                'transfer_mode'        => 'nullable|in:IMPS,VPA,NEFT/RTGS',
                'bank_id'              => 'nullable|integer|exists:banks,id',
                'cheque_no'            => 'nullable',
                'cheque_date'          => 'nullable|date',
                'saving_account_id'    => 'nullable|integer',
            ]);

            Log::info('Validated data:', $validated);

            $paymentMode = $validated['charges_pay_mode'];
            $type = 'Share amount';
            $remarks = $validated['remarks'] ?? '';

            $account = null;

            // Saving account validation
            if ($paymentMode === 'saving' && !empty($validated['saving_account_id'])) {
                $account = Account::find($validated['saving_account_id']);

                if (!$account) {
                    Log::warning('Invalid saving account', ['saving_account_id' => $validated['saving_account_id']]);
                    return back()->withErrors(['saving_account_id' => 'Selected saving account does not exist.']);
                }

                if ($account->member_id !== $member->id) {
                    Log::warning('Saving account mismatch', ['member_id' => $member->id, 'account_member_id' => $account->member_id]);
                    return back()->withErrors(['saving_account_id' => 'Selected saving account does not belong to the member.']);
                }

                if ($account->amount_deposit < $validated['membership_fee']) {
                    Log::warning('Insufficient balance in saving account', ['balance' => $account->amount_deposit]);
                    return back()->withErrors(['saving_account_id' => 'Insufficient balance in the selected saving account.']);
                }

                // Deduct balance
                $account->amount_deposit -= $validated['membership_fee'];
                $account->save();

                $type = 'Saving to Share Amount';
                $remarks = 'Credited from Saving A/c - ' . $account->account_no;
            }

            // Prepare data for insert
            $data = [
                'transaction_date'     => \Carbon\Carbon::parse($validated['transaction_date'])->format('Y-m-d'),
                'membership_fee'       => $validated['membership_fee'],
                'net_fee_to_collect'   => $validated['membership_fee'],
                'remarks'              => $remarks,
                'charges_pay_mode'     => $paymentMode,
                'type'                 => $type,
                'approve_status'       => $validated['approve_status'] ?? 0,
                'is_accounted'         => $validated['is_accounted'] ?? 0,
                'member_id'            => $member->id,
            ];

            if ($paymentMode === 'online') {
                $data['online_utr_no'] = $validated['online_utr_no'] ?? null;
                $data['transfer_mode'] = $validated['transfer_mode'] ?? null;
            }

            if ($paymentMode === 'cheque') {
                $data['cheque_no'] = $validated['cheque_no'] ?? null;
                $data['cheque_date'] = $validated['cheque_date']
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $validated['cheque_date'])->format('Y-m-d')
                    : null;
                $data['bank_id'] = $validated['bank_id'] ?? null;
            }

            if ($paymentMode === 'System' && $account) {
                $data['saving_account_id'] = $account->id;
            }

            Log::info('Prepared data for DB insert:', $data);

            // Try to insert transaction
            $transaction = MembershipChargeTransaction::create($data);

            if (!$transaction) {
                Log::error('DB insert failed', ['data' => $data]);
            } else {
                Log::info('Transaction successfully created', [
                    'transaction_id' => $transaction->id,
                    'member_id' => $member->id,
                ]);
            }

            return redirect()->route('members.transactions', $id);
        } catch (\Exception $e) {
            Log::error('Error in storeShareAmount', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return back()->with('error', 'Something went wrong. Please check logs.');
        }
    }
    public function otherChargesList($id)
    {
        try {
            $member = Member::findOrFail($id);

            // Get the first 'DUE' charge, ordered by latest created first
            $charge = MemberOtherCharge::where('status', 'DUE')
                ->where('member_id', $id)
                ->orderBy('created_at', 'desc')
                ->first();

            $chargeId = $charge ? $charge->id : null;

            // Get all charges for the member ordered by latest created first
            $otherCharge = MemberOtherCharge::where('member_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('members.member.otherChargesList', compact('member', 'otherCharge', 'charge', 'chargeId'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Member not found with ID: ' . $id, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            abort(404);
        } catch (\Exception $e) {
            Log::error('Error while fetching other charges for member ID: ' . $id, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function otherCharges($id)
    {
        $member = Member::findOrFail($id);
        $method = 'PUT';

        return view('members.member.otherCharges', compact('member', 'method'));
    }
    public function storeOtherCharges(Request $request, $id)
    {
        Log::info('storeOtherCharges called for member_id: ' . $id);

        $validated = $request->validate([
            'charge_type' => 'required|string|max:255',
            'transaction_date' => 'required|date_format:d-m-Y',
            'charges' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);
        $transactionDate = Carbon::createFromFormat('d-m-Y', $validated['transaction_date'])->format('Y-m-d');
        Log::info('Validation passed', $validated);

        $charge = MemberOtherCharge::create([
            'member_id' => $id,
            'charge_type' => $validated['charge_type'],
            'transaction_date' => $transactionDate,
            'charges' => $validated['charges'],
            'remarks' => $validated['remarks'] ?? null,
            'status'             => 'DUE',
        ]);
        Log::info('Charge saved successfully', ['id' => $charge->id]);

        return redirect()->route('members.other-charges.list', ['id' => $id]);
    }
    public function softDeleteothercharges($id)
    {
        $charge = MemberOtherCharge::findOrFail($id);

        if ($charge->status !== 'DUE') {
            return redirect()->back()->with('error', 'Only DUE charges can be deleted.');
        }

        $charge->delete();

        return redirect()->back();
    }

    public function showClearDueForm($id, $chargeId)
    {
        $member = Member::findOrFail($id);
        $banks = Bank::all();
        $charge = MemberOtherCharge::findOrFail($chargeId);
        $dueCharges = MemberOtherCharge::where('member_id', $id)
            ->where('status', 'DUE')
            ->get();

        foreach ($dueCharges as $charge) {
            $charge->total_amount = $charge->charges * (1 + $charge->gst_rate / 100);
        }
        $gstRate = 18.0;

        $totalChargesDue = $dueCharges->sum('charges');

        $totalAmount = $dueCharges->sum(function ($charge) {
            return $charge->charges * (1 + $charge->gst_rate / 100);
        });

        $roundingOff = (float) request('rounding_off', 0);
        $waivedAmount = (float) request('waived_amount', 0);

        $netAmount = $totalAmount + $roundingOff - $waivedAmount;

        return view('members.member.clearDue', [
            'memberId' => $member->id,
            'member' => $member,
            'charge' => $charge,
            'chargeId' => $charge->id,
            'dueCharges' => $dueCharges,
            'totalChargesDue' => $totalChargesDue,
            'totalAmount' => $totalAmount,
            'netAmount' => $netAmount,
            'banks' => $banks,
            'gstRate' => $gstRate,

        ]);
    }

    public function storeChargesDue(Request $request, $id)
    {

        try {
            $validated = $request->validate([
                'transaction_date' => 'required|date_format:d-m-Y',
                'transfer_date' => 'required|date_format:d-m-Y',
                'pay_mode' => 'required|in:Cash,Online,Cheque',
                'rounding_off' => 'nullable|numeric',
                'waived_amount' => 'required|numeric|min:0',
                'net_amount' => 'required|numeric|min:0',
                'clear_due_remarks' => 'nullable|string|max:255',
                'cheque_no' => 'nullable|required_if:pay_mode,Cheque|max:50',
                'cheque_date' => 'nullable|required_if:pay_mode,Cheque|date_format:d-m-Y',
                'bank_id' => 'nullable|required_if:pay_mode,Cheque|exists:banks,id',

            ]);

            // Log the validated data for debugging purposes
            Log::info('Validated data:', $validated);

            $transactionDate = Carbon::createFromFormat('d-m-Y', $validated['transaction_date'])->format('Y-m-d');
            $transferDate = Carbon::createFromFormat('d-m-Y', $validated['transfer_date'])->format('Y-m-d');

            // Log the formatted dates
            Log::info('Transaction Date: ' . $transactionDate . ' | Transfer Date: ' . $transferDate);

            $dueCharges = MemberOtherCharge::where('member_id', $id)
                ->where('status', 'DUE')
                ->orderBy('transaction_date')
                ->get();

            // If no due charges are found, log and return error
            if ($dueCharges->isEmpty()) {
                Log::warning('No due charges found for member_id: ' . $id);
                return redirect()->back()->with('error', 'No due charges found to clear.');
            }

            $totalChargesDue = $dueCharges->sum('charges');
            $waivedAmount = $validated['waived_amount'];

            if ($waivedAmount >= $totalChargesDue) {
                Log::warning('Waived amount is greater than or equal to charges due for member_id: ' . $id);
                return redirect()->back()
                    ->withErrors(['waived_amount' => "Waived amount can't be greater than or equal to Charges Due."])
                    ->withInput();
            }

            $gstRate = 18.0;
            $amountAfterWaive = $totalChargesDue - $waivedAmount;
            $gstAmount = $amountAfterWaive * ($gstRate / 100);
            $totalAmount = $amountAfterWaive + $gstAmount;

            // Round total amount and log the calculation
            $totalAmountRounded = ceil($totalAmount);
            Log::info('Total amount before rounding: ' . $totalAmount . ' | After rounding: ' . $totalAmountRounded);

            $roundingOff = isset($validated['rounding_off']) ? (int)$validated['rounding_off'] : 0;
            $netAmountRaw = $totalAmountRounded + $roundingOff;
            $netAmountRounded = ceil($netAmountRaw);

            // Log net amount calculation
            Log::info('Net amount before rounding off: ' . $netAmountRaw . ' | After rounding off: ' . $netAmountRounded);

            // Update charges status
            foreach ($dueCharges as $dueCharge) {
                try {
                    $dueCharge->update([
                        'charges_due' => $totalChargesDue,
                        'waived_amount' => $waivedAmount,
                        'total_amount' => $totalAmountRounded,
                        'rounding_off' => $roundingOff,
                        'net_amount' => $netAmountRounded,
                        'clear_due_remarks' => $validated['clear_due_remarks'] ?? 'Locker Charges',
                        'transaction_date' => $transactionDate,
                        'pay_mode' => $validated['pay_mode'],
                        'utr_no' => $validated['utr_no'] ?? null, // Store UTR No if available
                        'transfer_mode' => $validated['transfer_mode'] ?? null, // Store transfer mode if available
                        'credited_in_account' => $validated['credited_in_account'] ?? null,
                        'cheque_no' => $validated['cheque_no'] ?? null,
                        'cheque_date' => $chequeDate ?? null,
                        'bank_id' => $validated['bank_id'] ?? null, // Store credited in account if available
                        'status' => 'PAID',
                    ]);
                    Log::info('Due charge updated for member_id: ' . $id . ' | Charge ID: ' . $dueCharge->id);
                } catch (\Exception $e) {
                    // Log the error for each update failure
                    Log::error('Error updating charge for member_id: ' . $id . ' | Charge ID: ' . $dueCharge->id . ' | Error: ' . $e->getMessage());
                }
            }

            return redirect()->route('members.transactions', ['id' => $id]);
        } catch (\Exception $e) {
            // Log the general exception
            Log::error('Error in storeChargesDue method for member_id: ' . $id . ' | Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while clearing dues.');
        }
    }

    public function applicationForm($id)
    {
        $member = Member::with('address', 'kyc', 'minors', 'kycDocuments')->findOrFail($id);
        $transaction = MembershipChargeTransaction::findOrFail($id);

        return view('members.member.application-form', compact('member', 'transaction'));
    }

    public function printReceipt($id)
    {

        // Detect which table has this transaction ID
        $isMemberOtherCharge = DB::table('member_other_charges')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->exists();

        if ($isMemberOtherCharge) {
            // Build query only for member_other_charges
            $query = "
            SELECT
                id,
                member_id,
                transaction_date,
                charges AS amount,
                pay_mode,
                type,
                CONCAT('| consolidated transaction ::', IFNULL(clear_due_remarks, '')) AS remarks,
                CASE WHEN status = 'PAID' THEN 'Approved' ELSE 'Pending' END AS status,
                NULL AS is_accounted,
                'Other Charge' AS transaction_source,
                created_at,
                updated_at,
                charge_type,
                clearance_id,
                charges_due,
                waived_amount,
                gst_rate,
                total_amount,
                rounding_off,
                net_amount,
                clear_due_remarks,
                transfer_date,
                utr_no,
                transfer_mode,
                credited_in_account,
                bank_id,
                cheque_no,
                cheque_date
            FROM
                member_other_charges
            WHERE
                id = ? AND deleted_at IS NULL AND type = 'Normal'
            LIMIT 1
        ";
            $transaction = DB::selectOne($query, [$id]);
        } else {

            $query = "
        SELECT
            id,
            member_id,
            transaction_date,
            net_fee_to_collect AS amount,
            charges_pay_mode AS pay_mode,
            type,
            CASE 
                WHEN type = 'Membership Charges' THEN 'Member Registration'
                ELSE remarks
            END AS remarks,
            CASE WHEN approve_status = 1 THEN 'Approved' ELSE 'Pending' END AS status,
            is_accounted,
            'Membership Charge' AS transaction_source,
            created_at,
            updated_at,
            NULL AS charge_type,
            NULL AS clearance_id,
            NULL AS charges_due,
            NULL AS waived_amount,
            NULL AS gst_rate,
            NULL AS total_amount,
            NULL AS rounding_off,
            NULL AS net_amount,
            NULL AS clear_due_remarks,
            NULL AS transfer_date,
            NULL AS utr_no,
            NULL AS transfer_mode,
            NULL AS credited_in_account,
            NULL AS bank_id,
            NULL AS cheque_no,
            NULL AS cheque_date
        FROM membership_charges_transaction
        WHERE id = ?
          AND deleted_at IS NULL
          AND type IN ('Share amount', 'Membership Charges')
        LIMIT 1
    ";

            $transaction = DB::selectOne($query, [$id]);
        }


        if (!$transaction) {
            abort(404, 'Transaction not found.');
        }
        // changes done B
        $memberId = $transaction->member_id;

        $member = DB::table('members')->where('id', $memberId)->first();

        if (!$member) {
            Log::warning("Member not found for transaction_id: $id | member_id: $memberId");
            abort(404, 'Member not found for this transaction.');
        }

        // ✅ Prepare data for PDF
        $data = [
            'reg_no'                  => $member->reg_no ?? 'N/A',
            'member_info_first_name'  => $member->member_info_first_name ?? 'N/A',
            'member_info_middle_name' => $member->member_info_middle_name ?? '',
            'member_info_last_name'   => $member->member_info_last_name ?? 'N/A',
            'phone'                   => $member->phone ?? 'N/A',
            'transaction_date'        => Carbon::parse($transaction->transaction_date)->format('d-m-Y'),
            'ref_id'                  => $transaction->id,
            'amount'                  => number_format($transaction->amount, 2),
            'amount_suffix'           => 'CR',
            'member_info_mobile_no'   => $member->member_info_mobile_no ?? '',
            'mode'                    => $transaction->pay_mode ?? 'N/A',
            'status'                  => $transaction->status ?? 'Pending',
            'type'                    => $transaction->type ?? 'Membership Fee',
            'remarks'                 => $transaction->remarks ?? '',
            'printed_on'              => now()->format('d-m-Y H:i'),
            'printed_by'              => optional(Auth::user())->name ?? 'System',

            // Extra fields
            'charge_type'             => $transaction->charge_type,
            'clearance_id'            => $transaction->clearance_id,
            'charges_due'             => $transaction->charges_due,
            'waived_amount'           => $transaction->waived_amount,
            'gst_rate'                => $transaction->gst_rate,
            'total_amount'            => $transaction->total_amount,
            'rounding_off'            => $transaction->rounding_off,
            'net_amount'              => $transaction->net_amount,
            'clear_due_remarks'       => $transaction->clear_due_remarks,
            'transfer_date'           => $transaction->transfer_date,
            'utr_no'                  => $transaction->utr_no,
            'transfer_mode'           => $transaction->transfer_mode,
            'credited_in_account'     => $transaction->credited_in_account,
            'bank_id'                 => $transaction->bank_id,
            'cheque_no'               => $transaction->cheque_no,
            'cheque_date'             => $transaction->cheque_date,
            'member_no' => $member->member_no, // 👈 add this line

        ];

        // ✅ Generate and stream PDF
        $pdf = Pdf::loadView('members.member.receipt', $data)
            ->setPaper([0, 0, 238.346, 1000], 'portrait');

        return $pdf->stream('receipt.pdf');
    }

    public function addComment($member_id)
    {
        $comments = MembershipChargeTransaction::where('member_id', $member_id)
            ->where('status', 'comment')
            ->orderBy('transaction_date', 'desc')
            ->paginate(5);
        return view('members.member.addComments', compact('comments', 'member_id'));
    }

    public function storeComment(Request $request)
    {
        Log::debug('Store Comment Request Data: ', $request->all());

        // Validate the incoming request
        $validated = $request->validate([
            'comment' => 'required|string',
            'member_id' => 'required|exists:members,id',  // Ensure member exists
        ]);

        try {
            // Store the comment with member_id, current date as transaction_date, and 'comment' status
            MembershipChargeTransaction::create([
                'member_id' => $validated['member_id'],
                'status' => 'comment',  // Set status as 'comment'
                'transaction_date' => now(),  // Store the current date and time
                'comment' => $validated['comment'],
            ]);

            // Log the successful store operation
            Log::info('Comment stored successfully', [
                'member_id' => $validated['member_id'],
                'comment' => $validated['comment'],
                'transaction_date' => now(),
            ]);

            // Redirect with success message
            return redirect()->route('member.addComment', ['member_id' => $validated['member_id']])
                ->with('success', 'Comment added successfully!');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error storing comment', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            // Handle error
            return back()->withErrors('There was an error storing your comment.');
        }
    }
}
