<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {

        $companies = Company::with('stateData')->orderBy('created_at', 'desc')->paginate(10);
        return view('company-profile.manage-profile', compact('companies'));
    }

    public function create()
    {
        return view('company-profile.create-profile');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company_website' => 'nullable|url',
                'company_name' => 'required|string|max:255',
                'short_name' => 'required|string|max:255',
                'about_company' => 'required|string',
                'user_id' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',

                'address_line1' => 'required|string',
                'address_line2' => 'nullable|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'pincode' => 'required|numeric',
                'country' => 'required|string',

                'mobile_no' => 'required|string',
                'landline_no' => 'nullable|string',
                'contact_email' => 'required|email',

                'cin_no' => 'required|string',
                'pan_no' => 'nullable|string',
                'tan_no' => 'nullable|string',
                'gst_no' => 'nullable|string',

                'company_category' => 'required|string',
                'company_class' => 'required|string',
                'incorporation_date' => 'required|date',
                'incorporation_state' => 'required|string',
                'incorporation_country' => 'required|string',

                'authorized_capital' => 'required|numeric',
                'paid_up_capital' => 'required|numeric',
            ], [
                'company_name.required' => 'Company name is required.',
                'short_name.required' => 'Short name is required.',
                'about_company.required' => 'Please provide details about the company.',
                'address_line1.required' => 'Address Line 1 is required.',
                'city.required' => 'City is required.',
                'state.required' => 'State is required.',
                'pincode.required' => 'Pincode is required.',
                'pincode.numeric' => 'Pincode must be a number.',
                'country.required' => 'Country is required.',
                'mobile_no.required' => 'Mobile number is required.',
                'contact_email.required' => 'Contact email is required.',
                'contact_email.email' => 'Please enter a valid email address.',
                'cin_no.required' => 'CIN number is required.',
                'company_category.required' => 'Company category is required.',
                'company_class.required' => 'Company class is required.',
                'incorporation_date.required' => 'Incorporation date is required.',
                'incorporation_state.required' => 'Incorporation state is required.',
                'incorporation_country.required' => 'Incorporation country is required.',
                'authorized_capital.required' => 'Authorized capital is required.',
                'paid_up_capital.required' => 'Paid up capital is required.',
                'authorized_capital.numeric' => 'Authorized capital must be a number.',
                'paid_up_capital.numeric' => 'Paid up capital must be a number.',
            ]);


            $user = new User();
            $user->name = $request->company_name;
            $user->fname = $request->company_name;
            $user->email = $request->user_id;
            $user->password = Hash::make($request->password);
            $user->role_id = 2;
            $user->mobile = $request->mobile_no;
            $user->save();

            $company = new Company();
            $company->company_website = $request->company_website;
            $company->company_name = $request->company_name;
            $company->short_name = $request->short_name;
            $company->about_company = $request->about_company;
            $company->user_id = $user->id;

            $company->address_line1 = $request->address_line1;
            $company->address_line2 = $request->address_line2;
            $company->city = $request->city;
            $company->state = $request->state;
            $company->pincode = $request->pincode;
            $company->country = $request->country;

            $company->mobile_no = $request->mobile_no;
            $company->landline_no = $request->landline_no;
            $company->contact_email = $request->contact_email;

            $company->cin_no = $request->cin_no;
            $company->pan_no = $request->pan_no;
            $company->tan_no = $request->tan_no;
            $company->gst_no = $request->gst_no;

            $company->company_category = $request->company_category;
            $company->company_class = $request->company_class;
            $company->incorporation_date =  Carbon::parse($request->incorporation_date)->format('Y-m-d');
            $company->incorporation_state = $request->incorporation_state;
            $company->incorporation_country = $request->incorporation_country;

            $company->authorized_capital = $request->authorized_capital;
            $company->paid_up_capital = $request->paid_up_capital;

            $company->save();


            return redirect()->back()->with('success', 'Company details saved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! Please try again. Error: ' . $e->getMessage());
        }
    }


    public function show()
    {
        $company = Company::with(['stateData', 'incorporationState'])->where('user_id', 2)
        ->first();
        return view('company-profile.view-profile', compact('company'));
    }

    public function edit()
    {
        $company = Company::with(['stateData', 'incorporationState'])
        ->where('user_id', 2)->first();
        $states = State::all();
        return view('company-profile.edit-profile', compact('company', 'states'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_website' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'about_company' => 'required|string',

            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|numeric',
            'country' => 'required|string',

            'mobile_no' => 'required|string',
            'landline_no' => 'nullable|string',
            'contact_email' => 'required|email',

            'cin_no' => 'required|string',
            'pan_no' => 'nullable|string',
            'tan_no' => 'nullable|string',
            'gst_no' => 'nullable|string',

            'company_category' => 'required|string',
            'company_class' => 'required|string',
            'incorporation_date' => 'required|date',
            'incorporation_state' => 'required|string',
            'incorporation_country' => 'required|string',

            'authorized_capital' => 'required|numeric',
            'paid_up_capital' => 'required|numeric',
        ], [
            'company_name.required' => 'Company name is required.',
            'short_name.required' => 'Short name is required.',
            'about_company.required' => 'Please provide details about the company.',
            'address_line1.required' => 'Address Line 1 is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'pincode.required' => 'Pincode is required.',
            'pincode.numeric' => 'Pincode must be a number.',
            'country.required' => 'Country is required.',
            'mobile_no.required' => 'Mobile number is required.',
            'contact_email.required' => 'Contact email is required.',
            'contact_email.email' => 'Please enter a valid email address.',
            'cin_no.required' => 'CIN number is required.',
            'company_category.required' => 'Company category is required.',
            'company_class.required' => 'Company class is required.',
            'incorporation_date.required' => 'Incorporation date is required.',
            'incorporation_state.required' => 'Incorporation state is required.',
            'incorporation_country.required' => 'Incorporation country is required.',
            'authorized_capital.required' => 'Authorized capital is required.',
            'paid_up_capital.required' => 'Paid up capital is required.',
            'authorized_capital.numeric' => 'Authorized capital must be a number.',
            'paid_up_capital.numeric' => 'Paid up capital must be a number.',
        ]);

        $company = Company::where('user_id', 2)->first();

        $company->company_website = $request->company_website;
        $company->company_name = $request->company_name;
        $company->short_name = $request->short_name;
        $company->about_company = $request->about_company;

        $company->address_line1 = $request->address_line1;
        $company->address_line2 = $request->address_line2;
        $company->city = $request->city;
        $company->state = $request->state;
        $company->pincode = $request->pincode;
        $company->country = $request->country;

        $company->mobile_no = $request->mobile_no;
        $company->landline_no = $request->landline_no;
        $company->contact_email = $request->contact_email;

        $company->cin_no = $request->cin_no;
        $company->pan_no = $request->pan_no;
        $company->tan_no = $request->tan_no;
        $company->gst_no = $request->gst_no;

        $company->company_category = $request->company_category;
        $company->company_class = $request->company_class;
        $company->incorporation_date =  Carbon::parse($request->incorporation_date)->format('Y-m-d');
        $company->incorporation_state = $request->incorporation_state;
        $company->incorporation_country = $request->incorporation_country;

        $company->authorized_capital = $request->authorized_capital;
        $company->paid_up_capital = $request->paid_up_capital;

        $company->save();
        Log::info("data=" . $company);
        return redirect()->route('company.view')->with('success', 'Company profile updated successfully.');
    }

    // public function destroy($id)
    // {
    //     $company = Company::findOrFail($id);
    //     $company->delete();

    //     return redirect()->route('manage.profile')->with('success', 'Company deleted successfully.');
    // }
}
