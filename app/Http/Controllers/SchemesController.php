<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schemes;

class SchemesController extends Controller
{
   public function index(Request $request)
    {
        $schemes = Schemes::all();
        return view('schemes.index', compact('schemes'));
    }

  public function create()
    {
       
        $sections = config('schemes_form');
        $schemes = null;
        $route = route('schemes.store');
        $method = 'POST';
        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
    'scheme_name' => 'required|string|max:255',
    'scheme_code' => 'required|string|max:100',
    'min_opening_balance' => 'required|numeric|min:0',
    'min_monthly_avg_balance' => 'required|numeric|min:0',
    'annual_interest_rate' => 'required|numeric|min:0|max:100',
    'sr_citizen_add_on_interest_rate' => 'required|numeric|min:0|max:100',
    'interest_payout' => 'required|string|in:monthly,quarterly,annually',
    'lock_in_amount' => 'required|numeric|min:0',
    'min_monthly_avg_balance_charge' => 'required|numeric|min:0',
    'charge_frequency' => 'nullable|string|in:monthly,quarterly,annually',
    'service_charges' => 'nullable|numeric|min:0',
    'sms_charges' => 'nullable|numeric|min:0',
    'free_ifsc_collection_per_month' => 'nullable|integer|min:0',
    'free_imps_neft_transactions' => 'nullable|integer|min:0',
    'free_transfers_per_month' => 'nullable|integer|min:0',
    'single_transaction_limit' => 'nullable|numeric|min:0',
    'daily_max_limit' => 'nullable|numeric|min:0',
    'weekly_max_limit' => 'nullable|numeric|min:0',
    'monthly_max_limit' => 'nullable|numeric|min:0',
]);

         Schemes::create($data);
  return redirect()->route('schemes.index') 
                     ->with('success', 'Schemes created successfully.');
    }

    
   public function show(string $id)
    {
        $sections = config('schemes_form');
        $show = true;
         $method = 'GET';
        $schemes = Schemes::findOrFail($id);
        return view('schemes.add-edit', compact('sections', 'schemes', 'show','method'));
    }

  
    public function edit(string $id)
    {
        $sections = config('schemes_form');
        $schemes = Schemes::findOrFail($id);
        $route = route('schemes.update',$id);
        $method = 'PUT';
        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method'));
    }

   
    public function update(Request $request, string $id)
    {
         $data = $request->validate([
    'scheme_name' => 'required|string|max:255',
    'scheme_code' => 'required|string|max:100',
    'min_opening_balance' => 'required|numeric|min:0',
    'min_monthly_avg_balance' => 'required|numeric|min:0',
    'annual_interest_rate' => 'required|numeric|min:0|max:100',
    'sr_citizen_add_on_interest_rate' => 'required|numeric|min:0|max:100',
    'interest_payout' => 'required|string|in:monthly,quarterly,annually',
    'lock_in_amount' => 'required|numeric|min:0',
    'min_monthly_avg_balance_charge' => 'required|numeric|min:0',
    'charge_frequency' => 'nullable|string|in:monthly,quarterly,annually',
    'service_charges' => 'nullable|numeric|min:0',
    'sms_charges' => 'nullable|numeric|min:0',
    'free_ifsc_collection_per_month' => 'nullable|integer|min:0',
    'free_imps_neft_transactions' => 'nullable|integer|min:0',
    'free_transfers_per_month' => 'nullable|integer|min:0',
    'single_transaction_limit' => 'nullable|numeric|min:0',
    'daily_max_limit' => 'nullable|numeric|min:0',
    'weekly_max_limit' => 'nullable|numeric|min:0',
    'monthly_max_limit' => 'nullable|numeric|min:0',
]);

// Handle range-based validation (for IMPS, NEFT, UPI)
$transactionMethods = ['imps', 'neft', 'upi'];
$limits = [1000, 2500, 5000, 7500, 10000, 17500, 25000, 37500, 50000, 75000, 100000, 150000, 200000, 300000, 400000, 500000, 1000000];

foreach ($transactionMethods as $method) {
    foreach ($limits as $limit) {
        $field = "{$method}_upto_{$limit}";
        $data[$field] = $request->validate([
            $field => 'nullable|numeric|min:0'
        ])[$field] ?? null;
    }
}

         Schemes::update($data);
  return redirect()->route('schemes.index') 
                     ->with('success', 'Schemes created successfully.');
    }

    public function destroy(string $id)
    {
        
    }
}
