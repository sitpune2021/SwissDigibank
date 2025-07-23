<?php

namespace App\Http\Controllers;

use App\Models\SchemeCharges;
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
        $route = route('scheme.store');
        $method = 'POST';
        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'scheme_name'   => 'required|string|max:255',
            'scheme_code'   => 'required|alpha_num|max:100|unique:tbl_schemes,scheme_code',
            'min_opening_balance'   => 'required|numeric|min:0',
            'min_monthly_avg_balance' => 'required|numeric|min:0',
            'annual_interest_rate' => 'required|numeric|min:0|max:8',
            'sr_citizen_add_on_interest_rate'       => 'required|numeric|min:0|max:5|decimal:2',
            'interest_payout'      => 'required|string|max:50',
            'lock_in_amount'    => 'required|numeric|min:0',
            'min_monthly_avg_balance_charge'    => 'required|numeric|min:0',
            'service_charge_frequency'      => 'nullable',
            'service_charges' => 'nullable',
            'sms_charge_frequency' => 'nullable',
            'sms_charges' => 'nullable',
            'free_ifsc_collection_per_month' => 'nullable',
            'free_transfers_per_month' => 'nullable',
            'single_transaction_limit' => 'nullable',
            'daily_max_limit' => 'nullable',
            'weekly_max_limit' => 'nullable',
            'monthly_max_limit' => 'nullable',
            'app_type' => 'required|array',
            'app_type.*' => 'in:Admin,Associate,Member',
            'scheme_active' => 'required|in:Yes,No',
            'limit' => 'nullable|numeric|min:0',
            'imps_charge' => 'nullable|numeric|min:0',
            'neft_charge' => 'nullable|numeric|min:0',
            'upi_charge' => 'nullable|numeric|min:0',
        ]);


        $scheme = new Schemes();
        $scheme->scheme_name = $validated['scheme_name'];
        $scheme->scheme_code = $validated['scheme_code'];
        $scheme->min_opening_balance = $validated['min_opening_balance'];
        $scheme->min_monthly_avg_balance = $validated['min_monthly_avg_balance'];
        $scheme->annual_int_rate = $validated['annual_interest_rate'];
        $scheme->sr_citizen_add_on_int_rate = $validated['sr_citizen_add_on_interest_rate'];
        $scheme->interest_pay_cycle = $validated['interest_payout'];
        $scheme->lock_in_amount = $validated['lock_in_amount'];
        $scheme->min_monthly_avg_bal_charge = $validated['min_monthly_avg_balance_charge'];
        $scheme->service_charge_freq = $validated['service_charge_frequency'] ?? null;
        $scheme->service_charges = $validated['service_charges'] ?? null;
        $scheme->sms_charge_freq = $validated['sms_charge_frequency'] ?? null;
        $scheme->sms_charges = $validated['sms_charges'] ?? null;
        $scheme->free_ifsc_collect_per_month = $validated['free_ifsc_collection_per_month'] ?? null;
        $scheme->free_imps_neft_transactions = $validated['free_transfers_per_month'] ?? null;
        $scheme->single_transaction_limit = $validated['single_transaction_limit'] ?? null;
        $scheme->imps_neft_daily_limit = $validated['daily_max_limit'] ?? null;
        $scheme->imps_neft_weekly_limit = $validated['weekly_max_limit'] ?? null;
        $scheme->imps_neft_monthly_limit = $validated['monthly_max_limit'] ?? null;
        $scheme->app_type = json_encode($validated['app_type']);
        $scheme->active = $request->active === 'Yes' ? 1 : 0;
        $scheme->save();

        $charges = [];

        foreach ($request->all() as $key => $value) {
            if (preg_match('/^(imps|neft|upi)_charges_(\d+)$/i', $key, $matches) && $value !== null) {
                $mode = strtolower($matches[1]);  
                $limit = $matches[2];             

                if (!isset($charges[$limit])) {
                    $charges[$limit] = [
                        'scheme_id'   => $scheme->id,
                        'limit'       => $limit,
                        'imps_charge' => null,
                        'neft_charge' => null,
                        'upi_charge'  => null,
                    ];
                }

                $charges[$limit]["{$mode}_charge"] = $value;
            }
        }

        foreach ($charges as $chargeData) {
            SchemeCharges::create($chargeData);
        }

        return redirect()->route('scheme.index')
            ->with('success', 'Schemes created successfully.');
    }


    public function show(string $id)
    {
        $sections = config('schemes_form');
        $show = true;
        $method = 'GET';
        $schemes = Schemes::findOrFail($id);
        return view('schemes.add-edit', compact('sections', 'schemes', 'show', 'method'));
    }


    public function edit(string $id)
    {
        $sections = config('schemes_form');
        $schemes = Schemes::findOrFail($id);
        $route = route('scheme.update', $id);
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
        return redirect()->route('scheme.index')
            ->with('success', 'Schemes created successfully.');
    }

    public function destroy(string $id) 
    {
        
    }
}
