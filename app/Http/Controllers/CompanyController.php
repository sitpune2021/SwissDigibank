<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyCertificate;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();
            $company = Company::with(['State', 'incorporationState', ])->where('user_id',  $userId)
                ->first();
            $dynamicOptions = [
                'state' => State::pluck('name', 'id')
            ];
            $show = true;
            $route = '';
            return view('company.company-profile.profile', compact('company', 'dynamicOptions', 'show', 'route'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function edit($id)
    {
        try {
            $company = Company::findOrFail($id);
            $dynamicOptions = [
                'state' => State::pluck('name', 'id')
            ];
            $show = false;
            $route = route('company.update', $id);
            $method = 'PUT';
            return view('company.company-profile.profile', compact('company', 'dynamicOptions', 'show', 'route', 'method'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
           $request->validate([
                // COMPANY
                'company_website' => 'nullable|string|url|max:255',
                'company_name' => 'required|string|max:255',
                'short_name' => 'required|string|max:255',
                'about_company' => 'nullable|string',
                'company_category' => 'nullable|string|max:255',
                'company_class' => 'nullable|string|max:255',

                // REGISTERED OFFICE
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'pincode' => 'required|digits:6',
                'country' => 'required|string|max:255',
                'mobile_no' => 'required|digits:10',
                'landline_no' => 'nullable|digits_between:6,15',
                'contact_email' => 'nullable|email|max:255',

                // LEGAL INFO
                'cin_no' => 'nullable|regex:/^[LU]{1}[0-9]{5}[A-Z]{2}[0-9]{4}[A-Z]{3}[0-9]{6}$/',
                'cin_certificate_path' => 'nullable|file|max:2048',

                'pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'pan_certificate_path' => 'nullable|file|max:2048',

                'tan_no' => 'nullable|regex:/^[A-Z]{4}[0-9]{5}[A-Z]{1}$/',
                'tan_certificate_path' => 'nullable|file|max:2048',

                'gst_no' => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/',
                'gst_certificate_path' => 'nullable|file|max:2048',

                'iso_certification' => 'nullable|string|max:255',
                'iso_certificate_path' => 'nullable|file|max:2048',

                'bis_certification' => 'nullable|string|max:255',
                'bis_certificate_path' => 'nullable|file|max:2048',

                'pf_number' => 'nullable|string|max:50',
                'pf_certificate_path' => 'nullable|file|max:2048',

                'esic_number' => 'nullable|string|max:50',
                'esic_certificate_path' => 'nullable|file|max:2048',

                'incorporation_date' => 'nullable|date',
                'incorporation_state' => 'nullable|string|max:255',
                'incorporation_country' => 'nullable|string|max:255',

                'authorized_capital' => 'nullable|numeric|min:0',
                'paid_up_capital' => 'nullable|numeric|min:0',
            ]);

            $company = Company::findOrFail($id);
            $company->update($request->all());
            $certificate = $company->certificate ?? new CompanyCertificate(['company_id' => $company->id]);
            $fileFields = [
                'cin_certificate_path',
                'pan_certificate_path',
                'tan_certificate_path',
                'gst_certificate_path',
                'iso_certificate_path',
                'bis_certificate_path',
                'pf_certificate_path',
                'esic_certificate_path',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store('certificates', 'public');
                    $certificate->$field = $path;
                }
            }

            $certificate->save();
            return redirect()->route('company.index')->with('success', 'Company profile updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
}
