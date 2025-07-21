<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Promotor;
use Illuminate\Http\Request;
use App\Models\MaritalStatus;
use App\Models\Religion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class PromotorController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotor::query();
        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('member_no', 'like', "%$search%")
                    ->orWhere('first_name', 'like', "%$search%")
                    ->orWhere('gender', 'like', "%$search%")
                    ->orWhere('enrollment_date', 'like', "%$search%");
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
        return view('promoters.manage-promotors', compact('promotors'));
    }
    public function create()
    {
        $dynamicOptions = [
            'branches' => Branch::pluck('branch_name', 'id'),
            'marital_statuses' => MaritalStatus::pluck('status', 'id'),
            'religions' => Religion::pluck('name', 'id'),
            // 'religions'
        ];
        $route = route('promotor.store');
        $method = 'POST';
        return view('promoters.add-promoter', compact('route','dynamicOptions', 'method'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required|integer',
            'enrollment_date' => 'required|date',
            'title' => 'required|string',
            'gender' => 'required|string',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dob' => 'required|date',
            'occupation' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'mariatal_status' => 'nullable|string',
            'member_religion' => 'nullable|string',
            'spouse' => 'nullable|string|max:255',
          //  'landline_no' => 'nullable|digits_between:6,10',
            'email' => 'nullable|email|max:255',
            'mobile_no' => 'required|digits:10',

            'aadhaar_no' => 'nullable|digits:12',
            'voter_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|alpha_num|size:10',
            'ration_no' => 'nullable|string|max:20',
            'meter_no' => 'nullable|string|max:20',
            'ci_no' => 'nullable|string|max:20',
            'ci_relation' => 'nullable|string|max:255',
            'dl_no' => 'nullable|string|max:20',

            'nomine_name' => 'nullable|string|max:255',
            'nomine_relation' => 'nullable|string|max:255',
            'nomine_mobile' => 'nullable|string|max:20',
            'nomine_aadhar' => 'nullable|string|max:20',
            'nomine_voter' => 'nullable|string|max:20',
            'nomine_pan' => 'nullable|string|max:20',
            'nomine_address' => 'nullable|string|max:255',

            'sms' => 'nullable|boolean',
        ]);

        $promoter = new Promotor();
        $promoter->branch = $request->branch;
        $promoter->enrollment_date = date('Y-m-d', strtotime($request->enrollment_date));
        $promoter->title = $request->title;
        $promoter->gender = $request->gender;
        $promoter->first_name = $request->first_name;
        $promoter->middle_name = $request->middle_name;
        $promoter->last_name = $request->lastname;
        $promoter->date_of_birth = date('Y-m-d', strtotime($request->dob));
        $promoter->occupation = $request->occupation;
        $promoter->father_name = $request->father_name;
        $promoter->mother_name = $request->mother_name;
        $promoter->marital_status = $request->mariatal_status;
        $promoter->member_religion = $request->member_religion;
        $promoter->husband_wife_name = $request->spouse;
        $promoter->email = $request->email;
        $promoter->mobile = $request->mobile_no;

        // KYC
        $promoter->aadhaar_no = $request->aadhaar_no;
        $promoter->voter_id_no = $request->voter_no;
        $promoter->pan_no = $request->pan_no;
        $promoter->ration_card_no = $request->ration_no;
        $promoter->meter_no = $request->meter_no;
        $promoter->ci_no = $request->ci_no;
        $promoter->ci_relation = $request->ci_relation;
        $promoter->dl_no = $request->dl_no;

        // Nominee
        $promoter->nominee_name = $request->nomine_name;
        $promoter->nominee_relation = $request->nomine_relation;
        $promoter->nominee_mobile_no = $request->nomine_mobile;
        $promoter->nominee_aadhaar_no = $request->nomine_aadhar;
        $promoter->nominee_voter_id_no = $request->nomine_voter;
        $promoter->nominee_pan_no = $request->nomine_pan;
        $promoter->nominee_address = $request->nomine_address;
        $promoter->sms = $request->sms ?? 0;
        $promoter->save();

        $prefix = 'DEMO-';
        $code = $prefix . str_pad($promoter->id, 2, '0', STR_PAD_LEFT); // DEMO01, DEMO02...

        // Step 3: Save it again
        $promoter->member_no = $code;
        $promoter->save();

        return redirect()->route('promotor.index')->with('success', 'Promoter added successfully!');
    }
    public function show($id)
    {
        $decryptedId =  base64_decode($id);
        $promoter = Promotor::with(['MaritalStatus', 'Religion', 'Branches'])
            ->findOrFail($decryptedId);

        if ($promoter && $promoter->date_of_birth) {
            $dob = Carbon::parse($promoter->date_of_birth);
            $age = $dob->age;
            if ($age >= 60) {
                $isSeniorCitizen = 'Yes';
            } else {
                $isSeniorCitizen = 'No';
            }
        } else {
            $age = null;
        }
        return view('promoters.view-promoter', compact('promoter', 'age', 'isSeniorCitizen'));
    }
    public function edit($id)
    {
        $decryptedId = base64_decode($id);
        $promoter = Promotor::with(['MaritalStatus', 'Religion'])
            ->find($decryptedId);
        $route = route('promotor.update', $decryptedId);
        $method = 'PUT';
        $dynamicOptions = [
            'branches' => Branch::pluck('branch_name', 'id'),
            'marital_statuses' => MaritalStatus::pluck('status', 'id'),
            'religions' => Religion::pluck('name', 'id'),
            // 'religions'
        ];
        return view('promoters.add-promoter', compact('route', 'promoter', 'dynamicOptions'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'branch' => 'required|exists:branches,id',
            'enrollment_date' => 'required|date',
            'title' => 'required',
            'gender' => 'required',
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'dob' => 'required|date',
            'occupation' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'mobile_no' => 'required|digits:10',
        ], [
            'branch.required' => 'Please select a branch.',
            'branch.exists' => 'The selected branch does not exist.',
            'enrollment_date.required' => 'Please select the enrollment date.',
            'enrollment_date.date' => 'The enrollment date must be a valid date.',
            'title.required' => 'Please select a title.',
            'gender.required' => 'Please select gender.',
            'first_name.required' => 'Please enter the first name.',
            'first_name.string' => 'First name must be a valid string.',
            'middle_name.required' => 'Please enter the middle name.',
            'middle_name.string' => 'Middle name must be a valid string.',
            'dob.required' => 'Please select the date of birth.',
            'dob.date' => 'Date of birth must be a valid date.',
            'occupation.required' => 'Please enter occupation.',
            'occupation.string' => 'Occupation must be a valid string.',
            'father_name.required' => 'Please enter father\'s name.',
            'father_name.string' => 'Father name must be a valid string.',
            'mother_name.required' => 'Please enter mother\'s name.',
            'mother_name.string' => 'Mother name must be a valid string.',
            'mobile_no.required' => 'Please enter mobile number.',
            'mobile_no.digits' => 'Mobile number must be exactly 10 digits.',
        ]);

        $promotor = Promotor::findOrFail($id);

        $promotor->branch = $request->branch;
        $promotor->enrollment_date = date('Y-m-d', strtotime($request->enrollment_date));
        $promotor->title = $request->title;
        $promotor->gender = $request->gender;
        $promotor->first_name = $request->first_name;
        $promotor->middle_name = $request->middle_name;
        $promotor->last_name = $request->lastname;
        $promotor->date_of_birth = date('Y-m-d', strtotime($request->dob));
        $promotor->occupation = $request->occupation;
        $promotor->father_name = $request->father_name;
        $promotor->mother_name = $request->mother_name;
        $promotor->marital_status = $request->mariatal_status;
        $promotor->member_religion = $request->member_religion;
        $promotor->husband_wife_name = $request->spouse;
        $promotor->email = $request->email;
        $promotor->mobile = $request->mobile_no;

        $promotor->aadhaar_no = $request->aadhaar_no;
        $promotor->voter_id_no = $request->voter_no;
        $promotor->pan_no = $request->pan_no;
        $promotor->ration_card_no = $request->ration_no;
        $promotor->meter_no = $request->meter_no;
        $promotor->ci_no = $request->ci_no;
        $promotor->ci_relation = $request->ci_relation;
        $promotor->dl_no = $request->dl_no;

        $promotor->nominee_name = $request->nomine_name;
        $promotor->nominee_relation = $request->nomine_relation;
        $promotor->nominee_mobile_no = $request->nomine_mobile;
        $promotor->nominee_aadhaar_no = $request->nomine_aadhar;
        $promotor->nominee_voter_id_no = $request->nomine_voter;
        $promotor->nominee_pan_no = $request->nomine_pan;
        $promotor->nominee_address = $request->nomine_address;

        $promotor->sms = $request->sms ?? 0;

        $promotor->save();

        return redirect()->route('promotor.index')->with('success', 'Promotor updated successfully!');
    }

    public function destroy($id)
    {
        $branch = Promotor::findOrFail($id);
        $branch->delete();

        return redirect()->route('promotor.index')->with('success', 'Branch deleted successfully.');
    }
    public function getMariatalStatuses()
    {
        $statuses = MaritalStatus::all();
        return response()->json($statuses);
    }

    public function getReligion()
    {
        $religions = Religion::all();
        return response()->json($religions);
    }

    public function getPromoters()
    {
        $promoters = Promotor::all();
        return response()->json($promoters);
    }
}
