<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scheme;
use App\Models\SchemeCharge;


class SchemesController extends Controller
{
   public function index(Request $request)
    {
        $schemes = Scheme::all();
        return view('schemes.index', compact('schemes'));
    }

  public function create()
    {
       
        $sections = config('schemes_form');
        $schemes = null;
        $route = route('schemes.store');
        $method = 'POST';
        $schemeCharges = collect();
        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method', 'schemeCharges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'scheme_name'   => 'required|string|max:255',
            'scheme_code'   => 'required|alpha_num|max:100|unique:schemes,scheme_code',
            'min_opening_balance'   => 'required|numeric|min:0',
            'min_monthly_avg_balance' => 'required|numeric|min:0',
            'annual_int_rate' => 'required|numeric|min:0|max:8',
            'sr_citizen_add_on_int_rate'       => 'required|numeric|min:0|max:5',
            'interest_pay_cycle'      => 'required|string|max:50',
            'lock_in_amount'    => 'required|numeric|min:0',
            'min_monthly_avg_bal_charge'    => 'required|numeric|min:0',
            'service_charge_freq'      => 'nullable',
            'service_charges' => 'nullable',
            'sms_charge_freq' => 'nullable',
            'sms_charges' => 'nullable',
            'free_ifsc_collect_per_month' => 'nullable',
            'free_imps_neft_transactions' => 'nullable',
            'single_transaction_limit' => 'nullable',
            'imps_neft_daily_limit' => 'nullable',
            'imps_neft_weekly_limit' => 'nullable',
            'imps_neft_monthly_limit' => 'nullable',
            'app_type' => 'nullable|in:1,0',
            'app_type_associate' => 'nullable|in:1,0',
            'app_type_member' => 'nullable|in:1,0',
            'active' => 'required|in:1,0',
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
        $scheme->annual_int_rate = $validated['annual_int_rate'];
        $scheme->sr_citizen_add_on_int_rate = $validated['sr_citizen_add_on_int_rate'];
        $scheme->interest_pay_cycle = $validated['interest_pay_cycle'];
        $scheme->lock_in_amount = $validated['lock_in_amount'];
        $scheme->min_monthly_avg_bal_charge = $validated['min_monthly_avg_bal_charge'];
        $scheme->service_charge_freq = $validated['service_charge_freq'] ?? null;
        $scheme->service_charges = $validated['service_charges'] ?? null;
        $scheme->sms_charge_freq = $validated['sms_charge_freq'] ?? null;
        $scheme->sms_charges = $validated['sms_charges'] ?? null;
        $scheme->free_ifsc_collect_per_month = $validated['free_ifsc_collect_per_month'] ?? null;
        $scheme->free_imps_neft_transactions = $validated['free_imps_neft_transactions'] ?? null;
        $scheme->single_transaction_limit = $validated['single_transaction_limit'] ?? null;
        $scheme->imps_neft_daily_limit = $validated['imps_neft_daily_limit'] ?? null;
        $scheme->imps_neft_weekly_limit = $validated['imps_neft_weekly_limit'] ?? null;
        $scheme->imps_neft_monthly_limit = $validated['imps_neft_monthly_limit'] ?? null;
        $scheme->app_type   = $validated['app_type'] ?? 0;
        $scheme->app_type_associate = $validated['app_type_associate'] ?? 0;
        $scheme->app_type_member    = $validated['app_type_member'] ?? 0;

        $scheme->active = $request->active;
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
            SchemeCharge::create($chargeData);
        }

        return redirect()->route('scheme.index')
            ->with('success', 'Schemes created successfully.');
    }

    
   public function show(string $id)
    {
        $sections = config('schemes_form');
        $show = true;
         $method = 'GET';
        $schemes = Scheme::findOrFail($id);
        $route = '';
        $schemeCharges = $schemes->schemeCharges;
        return view('schemes.add-edit', compact('sections', 'schemes', 'show','method', 'schemeCharges'));
    }

  
    public function edit(string $id)
    {
        $sections = config('schemes_form');
        $schemes = Scheme::findOrFail($id);
        $route = route('schemes.update',$id);
        $method = 'PUT';
        $schemeCharges = $schemes->schemeCharges;

        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method', 'schemeCharges'));
    }

   
    public function update(Request $request, string $id)
    {
          $scheme = Schemes::with('schemeCharges')->findOrFail($id);

        $validated = $request->validate([
            'scheme_name'                   => 'required|string|max:255',
            'scheme_code'                   => 'required|alpha_num|max:100',
            'min_opening_balance'          => 'required|numeric|min:0',
            'min_monthly_avg_balance'      => 'required|numeric|min:0',
            'annual_int_rate'              => 'required|numeric|min:0|max:8',
            'sr_citizen_add_on_int_rate'   => 'required|numeric|min:0|max:5|decimal:2',
            'interest_pay_cycle'           => 'required|string|max:50',
            'lock_in_amount'               => 'required|numeric|min:0',
            'min_monthly_avg_bal_charge'   => 'required|numeric|min:0',
            'service_charge_freq'          => 'nullable',
            'service_charges'              => 'nullable|numeric|min:0',
            'sms_charge_freq'              => 'nullable',
            'sms_charges'                  => 'nullable|numeric|min:0',
            'free_ifsc_collect_per_month'  => 'nullable|numeric|min:0',
            'free_imps_neft_transactions'  => 'nullable|numeric|min:0',
            'single_transaction_limit'     => 'nullable|numeric|min:0',
            'imps_neft_daily_limit'        => 'nullable|numeric|min:0',
            'imps_neft_weekly_limit'       => 'nullable|numeric|min:0',
            'imps_neft_monthly_limit'      => 'nullable|numeric|min:0',
            'app_type'                     => 'required|in:1,0',
            'app_type_associate'           => 'required|in:1,0',
            'app_type_member'              => 'required|in:1,0',
            'active'                       => 'required|in:1,0',
        ]);

        $scheme->update([
            'scheme_name'                   => $validated['scheme_name'],
            'scheme_code'                   => $validated['scheme_code'],
            'min_opening_balance'          => $validated['min_opening_balance'],
            'min_monthly_avg_balance'      => $validated['min_monthly_avg_balance'],
            'annual_int_rate'              => $validated['annual_int_rate'],
            'sr_citizen_add_on_int_rate'   => $validated['sr_citizen_add_on_int_rate'],
            'interest_pay_cycle'           => $validated['interest_pay_cycle'],
            'lock_in_amount'               => $validated['lock_in_amount'],
            'min_monthly_avg_bal_charge'   => $validated['min_monthly_avg_bal_charge'],
            'service_charge_freq'          => $validated['service_charge_freq'],
            'service_charges'              => $validated['service_charges'],
            'sms_charge_freq'              => $validated['sms_charge_freq'],
            'sms_charges'                  => $validated['sms_charges'],
            'free_ifsc_collect_per_month'  => $validated['free_ifsc_collect_per_month'],
            'free_imps_neft_transactions'  => $validated['free_imps_neft_transactions'],
            'single_transaction_limit'     => $validated['single_transaction_limit'],
            'imps_neft_daily_limit'        => $validated['imps_neft_daily_limit'],
            'imps_neft_weekly_limit'       => $validated['imps_neft_weekly_limit'],
            'imps_neft_monthly_limit'      => $validated['imps_neft_monthly_limit'],
            'app_type'                     => $validated['app_type'],
            'app_type_associate'           => $validated['app_type_associate'],
            'app_type_member'              => $validated['app_type_member'],
            'active'                       => $validated['active'],
        ]);

        $limits = [1000, 2500, 5000, 10000, 17500, 25000, 37500, 50000, 75000, 100000, 150000, 200000, 300000, 400000, 500000, 1000000];

        foreach ($limits as $limit) {
            $imps = $request->input("IMPS_Charges_$limit");
            $neft = $request->input("NEFT_Charges_$limit");
            $upi  = $request->input("UPI_Charges_$limit");

            if (
                (is_null($imps) || floatval($imps) == 0) &&
                (is_null($neft) || floatval($neft) == 0) &&
                (is_null($upi) || floatval($upi) == 0)
            ) {
                continue;
            }
            SchemeCharges::updateOrCreate(
                [
                    'scheme_id' => $scheme->id,
                    'limit'     => $limit,
                ],
                [
                    'imps_charge' => $imps ?? 0,
                    'neft_charge' => $neft ?? 0,
                    'upi_charge'  => $upi ?? 0,
                ]
            );
        }

        return redirect()->route('schemes.index')->with('success', 'Scheme updated successfully.');
    }

    public function destroy(string $id)
    {
        
    }
}
