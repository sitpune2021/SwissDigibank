<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rdscheme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class RdschemesController extends Controller
{
  public function create()
  {
    return view("rdschemes.create");
  }


  public function store(Request $request)
  {

    try {

      $request->validate([
        'scheme_name' => 'required|string|max:255',
        'scheme_code' => 'required|string|max:50|unique:rdschemes,scheme_code',
        'min_rd_dd_amount' => 'required|integer|min:1',
        'rd_dd_frequency' => 'required|string|in:daily,weekly,bi_weekly,monthly,quarterly,half-yearly,yearly',
        'anuual_interest_rate' => 'required|numeric|min:0|max:100',
        'sr_citizen_add_on_interest_rate' => 'nullable|numeric|min:0|max:100',
        'bonus_rate_type' => 'required|string|in:fixed,percentage',
        'bonus_rate_value' => 'required|numeric|min:0',
        'interest_compounding_interval' => 'required|string|in:monthly,quarterly,half_yearly,yearly',
        'rd_dd_lock_in_period' => 'required|string|max:60',
        'interest_lock_in_period' => 'required|string|max:60',
        'tenure_of_rd_dd_type' => 'required|string|in:days,months,weeks',
        'tenure_of_rd_dd_value' => 'required|integer|min:1',
        'cancellation_charges_type' => 'required|string|in:fixed,percentage',
        'cancellation_charges_value' => 'required|numeric|min:0',
        'stationary_charges' => 'required|numeric|min:0',
        'penalty_charges_type' => 'required|string|in:fixed,percentage',
        'penalty_charges_value' => 'required|numeric|min:0',
        'penal_charges' => 'required|string|max:255|in:0.0,0.5,1.0,1.5,2.0,3.0,4.0,5.0',
        'app_type_admin' => 'nullable|string|in:1',
        'app_type_associate' => 'nullable|string|in:1',
        'app_type_member' => 'nullable|string|in:1',
        'active' => 'required|string|in:yes,no',
      ]);
      // dd("hii");

      // Insert record
      Rdscheme::create($request->all());

     return redirect()->route('rdschemes.index')
                 ->with('success', 'RD Scheme created successfully!');

    } catch (ValidationException $e) {
      return redirect()->back()
        ->withErrors($e->errors())
        ->withInput();
    } catch (Exception $e) {
      Log::error('Rdscheme creation failed: ' . $e->getMessage());
      return redirect()->back()
        ->with('error', 'Something went wrong while saving scheme. Please try again.')
        ->withInput();
    }
    // If validation passes, save data
    // Rdscheme::create($request->all());
  }
public function index()
{
    // Fetch all records from DB
    $schemes = Rdscheme::all();

    // Pass data to Blade view
    return view('rdschemes.index', compact('schemes'));
}

public function show($id)
{
    // fetch scheme by id
    $scheme = Rdscheme::findOrFail($id);

    // return view and pass scheme data
    return view('rdschemes.show', compact('scheme'));
}



public function edit($id)
{
    $scheme = Rdscheme::findOrFail($id);
    return view('rdschemes.edit', compact('scheme'));
}

public function update(Request $request, $id)
{
    $request->validate([
  
       
        'min_rd_dd_amount' => 'required|integer|min:1',
        'rd_dd_frequency' => 'required|string|in:daily,weekly,bi_weekly,monthly,quarterly,half-yearly,yearly',
        'anuual_interest_rate' => 'required|numeric|min:0|max:100',
        'sr_citizen_add_on_interest_rate' => 'nullable|numeric|min:0|max:100',
        'bonus_rate_type' => 'required|string|in:fixed,percentage',
        'bonus_rate_value' => 'required|numeric|min:0',
        'interest_compounding_interval' => 'required|string|in:monthly,quarterly,half_yearly,yearly',
        'rd_dd_lock_in_period' => 'required|string|max:60',
        'interest_lock_in_period' => 'required|string|max:60',
        'tenure_of_rd_dd_type' => 'required|string|in:days,months,weeks',
        'tenure_of_rd_dd_value' => 'required|integer|min:1',
        'cancellation_charges_type' => 'required|string|in:fixed,percentage',
        'cancellation_charges_value' => 'required|numeric|min:0',
        'stationary_charges' => 'required|numeric|min:0',
        'penalty_charges_type' => 'required|string|in:fixed,percentage',
        'penalty_charges_value' => 'required|numeric|min:0',
        'penal_charges' => 'required|string|max:255|in:0.0,0.5,1.0,1.5,2.0,3.0,4.0,5.0',
        'app_type_admin' => 'nullable|string|in:1',
        'app_type_associate' => 'nullable|string|in:1',
        'app_type_member' => 'nullable|string|in:1',
        'active' => 'required|string|in:yes,no',
    ]);

    $scheme = Rdscheme::findOrFail($id);
    $scheme->update($request->all());

    return redirect()->route('rdschemes.index')
        ->with('success', 'RD Scheme updated successfully!');
}

public function updateCommission(Request $request, $id)
{
    $scheme = Rdscheme::findOrFail($id);

    $request->validate([
        'commission_chart' => 'nullable|string|max:255',
    ]);

    $scheme->update([
        'commission_chart' => $request->commission_chart
    ]);

    return redirect()->back()->with('success', 'Commission Chart updated successfully!');
}


}
