<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Member;
use App\Models\User;
use App\Models\Address;

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
       
        

        // $minors = Minor::pluck('name', 'id');
        // $minors =[];
        // $schemes = [];
        // $schemes = Scheme::pluck('scheme_name', 'id');
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
            // 'schemes',
            'address',
            'advisors',
            'formFields',
            'route',
            'method'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_type' => 'required|in:saving,current',
            'firm_d' => 'nullable|required_if:account_type,current|max:255',
            'member_id' => 'required|exists:members,id',
            'branch_id' => 'required|exists:branches,id',
            'advisor_id' => 'nullable|required|exists:users,id',
            'scheme_id' => 'required|integer',
            'open_date' => 'required|date_format:d-m-Y h:i:s A',
            'amount' => 'required|numeric|min:0',
            'account_holder_type' => 'required|in:single,joint',
            'member_id_one_main' => 'nullable|exists:members,id|required_if:account_holder_type,joint',
            'member_id_two_main' => 'nullable|exists:members,id|required_if:account_holder_type,joint|different:member_id_one',
            'mode_of_operation' => 'required|in:single,jointly,either_or_survivor',
            'nominee' => 'required|in:yes,no',
            'payment_mode' => 'required|in:cash,online,cheque',
            'transaction_date' => 'nullable|date',
        ], 
        [
            'account_type.required' => 'Please select an account type.',
            'firm_d.required_if' => 'Firm name is required for Current accounts.',
            'member_id.required' => 'Please select a member.',
            'member_id.exists' => 'Selected member does not exist.',
            'branch_id.required' => 'Please select a branch.',
            'scheme_id.required' => 'Please select a scheme.',
            'open_date.required' => 'Please provide an open date.',
            'amount.required' => 'Please enter the deposit amount.',
            'account_holder_type.required' => 'Please select the account holder type.',
            'member_id_one_main.required_if' => 'Joint member 1 is required for joint accounts.',
            'member_id_two_main.required_if' => 'Joint member 2 is required for joint accounts.',
            'member_id_two.different' => 'Joint member 1 and 2 must be different.',
            'mode_of_operation.required' => 'Please select mode of operation.',
            'nominee.required' => 'Please specify if there is a nominee.',
            'payment_mode.required' => 'Please choose a payment mode.',
        ]);


        $account = new Account();
        $account->account_type      = $validated['account_type'];
        $account->firm_d            = $validated['firm_d'] ?? null;
        $account->member_id         = $validated['member_id'];
        $account->branch_id         = $validated['branch_id'];
        $account->advisor_id        = $validated['advisor_id'] ?? null;
        $account->scheme_id         = $validated['scheme_id'];
        $account->open_date         = \Carbon\Carbon::createFromFormat('d-m-Y h:i:s A', $validated['open_date']);
        $account->amount            = $validated['amount'];
        $account->account_holder_type   = $validated['account_holder_type'];
        $account->member_id_one         = $validated['member_id_one'] ?? null;
        $account->member_id_two         = $validated['member_id_two'] ?? null;
        $account->mode_of_operation     = $validated['mode_of_operation'];
        $account->nominee               = $validated['nominee'];
        $account->payment_mode          = $validated['payment_mode'];
        $account->transaction_date  = $validated['transaction_date'] ?? now();

        $account->save();


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
