<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Member;
use App\Models\User;
use App\Models\Address;
use App\Models\Scheme;
use App\Models\SchemeCharge;
use Illuminate\Support\Facades\DB;


class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $Accounts = Account::orderBy('created_at', 'desc')->paginate(10); // Optional: change to ->get() if no pagination
        
        $Accounts = Account::with(['members','users'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('saving-current-ac.accounts.index', compact('Accounts'));
       
    }

    /**
     * Show the form for creating a new resource.
     * Created by: Deepak
     */
    
    public function create()
    {

        $members = Member::pluck('member_info_first_name', 'id','member_info_mobile_no');
        $branches = Branch::pluck('branch_name', 'id');
        $address = Address::pluck('member_address_line_1', 'id');
        $schemeMinimums = Scheme::pluck('min_opening_balance', 'id');

       

        // $minors = Minor::pluck('name', 'id');
        // $minors =[];
        // $schemes = [];
        $schemes = Scheme::pluck('scheme_name', 'id');
        $advisors = User::pluck('fname', 'id');

        $members = Member::all();
        $address = Member::with('address')->get();

        $formFields = config('accounts.form_fields'); // Optional, only if you're using dynamic form fields

        $route = route('accounts.store');
        $method = 'POST';

        return view('saving-current-ac.accounts.add-account', compact(
            'members',
            'branches',
            'address',
            // 'minors',
            'schemes',
            'address',
            'advisors',
            'formFields',
            'route',
            'method',
            'schemeMinimums'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    $rules = [
        'account_type' => 'required|in:saving,current',
        'firm_d' => 'nullable|required_if:account_type,current|max:255',
        'member_id' => 'required|exists:members,id',
        'branch_id' => 'required|exists:branches,id',
        'advisor_id' => 'nullable|exists:users,id',
        'scheme_id' => 'required|integer|exists:schemes,id',
        'open_date' => 'required|date_format:d-m-Y h:i:s A',
        'amount' => 'required|numeric|min:0',
        'account_holder_type' => 'required|in:single,joint',
        'member_id_one' => 'nullable|required_if:account_holder_type,joint|exists:members,id',
        'member_id_two' => 'nullable|required_if:account_holder_type,joint|exists:members,id|different:member_id_one',
        'mode_of_operation' => 'required_if:account_holder_type,joint|in:single,jointly,either_or_survivor',
        'nominee' => 'required|in:yes,no',
        'payment_mode' => 'required|in:cash,online,cheque',
        'transaction_date' => 'nullable|date',
    ];

    if ($request->input('nominee') === 'yes') {
        $rules['nominee_relation'] = 'required|string|max:255';
        $rules['nominee_name'] = 'required|string|max:255';
        $rules['nominee_address'] = 'required|string|max:500';
    }

    // ✅ Validate input
    $validated = $request->validate($rules);

    // ✅ Check scheme minimum amount
    $scheme = \App\Models\Scheme::find($validated['scheme_id']);
    if ($scheme && $validated['amount'] < $scheme->min_opening_balance) {
        return back()->withErrors([
            'amount' => 'Minimum required amount for this scheme is ₹' . $scheme->min_opening_balance,
        ])->withInput();
    }
     

    // ✅ Create account
    try {
            $account = Account::create([
                'account_type' => $request->account_type,
                'account_no' => 'SA' . time() . rand(1000, 9999),
                'firm_name' => $request->firm_d,
                'member_id' => $request->member_id,
                'branch_id' => $request->branch_id,
                'advisor_id' => $request->advisor_id,
                'scheme_id' => $request->scheme_id,
                'open_date' => '2025-07-29',
                'amount_deposit' => $request->amount,
                // 'account_holder_type' => $request->account_holder_type,
                'joint_member1' => $request->member_id_one,
                'joint_member2' => $request->member_id_two,
                'mode_of_operation' => $request->mode_of_operation,
                'payment_mode' => $request->payment_mode,
                'transaction_date' => '2025-07-29 18:18:34',
            ]);

         return redirect('/saving-current-ac/accounts')
       ->with('success', 'Account added successfully.');


           

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
        

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $decryptedId = base64_decode($id);
        $account = Account::findOrFail($decryptedId); // Only account data
        return view('saving-current-ac.accounts.view-account', compact('account', 'decryptedId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
