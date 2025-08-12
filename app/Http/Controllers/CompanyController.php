<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {
       $userId = Auth::id();
        $company = Company::with(['State', 'incorporationState'])->where('user_id',  $userId)
            ->first();
         $dynamicOptions = [
            'state' =>State::pluck('name', 'id')
        ]; 
        $show = true;
        $route = '';
        return view('company.company-profile.profile', compact('company', 'dynamicOptions', 'show', 'route'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $dynamicOptions = [
            'state' => State::pluck('name', 'id')
        ];
        $show = false;
        $route = route('company.update', $id);
        $method = 'PUT';
        return view('company.company-profile.profile', compact('company', 'dynamicOptions', 'show', 'route', 'method'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
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
            'mobile_no' => 'required|digits:10',
            'landline_no' => 'required|digits_between:6,15',
            'contact_email' => 'required|email',
            'cin_no' => 'required|regex:/^[LU]{1}[0-9]{5}[A-Z]{2}[0-9]{4}[A-Z]{3}[0-9]{6}$/',
            'pan_no' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'tan_no' => 'required|regex:/^[A-Z]{4}[0-9]{5}[A-Z]{1}$/',
            'gst_no' => 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/',
            'company_category' => 'required|string',
            'company_class' => 'required|string',
            'incorporation_date' => 'required',
            'incorporation_state' => 'required|string',
            'incorporation_country' => 'required|string',
            'authorized_capital' => 'required|numeric',
            'paid_up_capital' => 'required|numeric',
        ]);

        $company = Company::findOrFail($id);
        $company->update($request->all());
        return redirect()->route('company.index')->with('success', 'Company profile updated successfully.');
    }
}
