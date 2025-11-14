<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\VehicalScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\VehicalApplication;
use App\Models\Calculator;
use App\Models\VehicleDistributor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class VehicalDistributorController extends Controller
{

    public function index()
    {
        $distributors = VehicleDistributor::orderBy('id', 'desc')->paginate(10);

        return view('vehical.distributors.index', compact('distributors'));
    }


    public function create() 
    {
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no','general_branch')->get();
        $branch = Branch::all();
        $scheme = VehicalScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        $distributor = null; // this line for update form
        return view("vehical.distributors.create", compact('members','branch','scheme','banks','distributor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'distributor_name' => 'required|string|max:255',
            'distributor_code' => 'required|string|max:100|unique:vehicle_distributors,distributor_code',
            'distributor_type' => 'required|string|max:100',
            'contact_no' => 'required|digits_between:8,15',
            'email' => 'required|email|unique:vehicle_distributors,email',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|digits_between:4,10',
            'gst_no' => 'nullable|string|max:50',
            'license_no' => 'nullable|string|max:50',
            'active' => 'required|boolean',
        ]);

        VehicleDistributor::create($request->all());

        return redirect()
                    ->route('vehical.distributors.index')
            ->with('success', 'Distributor saved successfully!');
    }

    public function show($id)
    {
        $distributor = VehicleDistributor::findOrFail($id);
        return view('vehical.distributors.view', compact('distributor'));
    }

    public function edit($id)
    {
        $distributor = VehicleDistributor::findOrFail($id);
        return view('vehical.distributors.create', compact('distributor'));
    }

    public function update(Request $request, $id)
    {
        $distributor = VehicleDistributor::findOrFail($id);

        $validated = $request->validate([
            'distributor_name' => 'required',
            'distributor_code' => "required|unique:vehicle_distributors,distributor_code,{$id}",
            'distributor_type' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'gst_no' => 'nullable|string',
            'license_no' => 'nullable|string',
        ]);

        $distributor->update($validated + [
            'active' => $request->active ?? 0,
        ]);

        return redirect()->route('vehical.distributors.index')
            ->with('success', 'Distributor updated successfully!');
    }




}
