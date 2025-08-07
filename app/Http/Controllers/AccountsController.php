<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\Branch;
use App\Models\Member;
use App\Models\User;
use App\Models\Address;
use App\Models\Minor;
use App\Models\Scheme;
use App\Models\SchemeCharge;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Helpers\AccountsTransactionsHelper;




class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $Accounts = Account::orderBy('created_at', 'desc')->paginate(10); // Optional: change to ->get() if no pagination

        $Accounts = Account::with(['members', 'users','minor','scheme', 'address'])
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

        $members = Member::pluck('member_info_first_name', 'id', 'member_info_mobile_no');
        $branches = Branch::pluck('branch_name', 'id');
        $address = Address::pluck('member_address_line_1', 'id');
        $schemeMinimums = Scheme::pluck('min_opening_balance', 'id');
        $minors = Minor::pluck('first_name', 'id');

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
            'minors',
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
            'account_type'  => 'required|in:saving,current',
            'firm_d'        => 'nullable|required_if:account_type,current|max:255',
            'member_id'     => 'required|exists:members,id',
            'branch_id'     => 'required|exists:branches,id',
            'advisor_id'    => 'nullable|exists:users,id',
            'scheme_id'     => 'required|integer|exists:schemes,id',
            'open_date'     => 'required|date',
            'amount'        => 'required|numeric|min:0',
            'account_holder_type'   => 'required|in:single,joint',
            'member_id_one'         => 'nullable|required_if:account_holder_type,joint',
            'member_id_two'         => 'nullable',
            'mode_of_operation'     => 'required_if:account_holder_type,joint|in:single,jointly,either_or_survivor',
            'nominee'               => 'required|in:yes,no',
            'payment_mode'          => 'required|in:cash,online,cheque',
            'transaction_date'      => 'nullable|required|date',
        ];

        if ($request->input('nominee') === 'yes') 
        {
            $rules['nominee_relation'] = 'required|string|max:255';
            $rules['nominee_name'] = 'required|string|max:255';
            $rules['nominee_address'] = 'required|string|max:500';
        }

        // ✅ Validate input
        $validated = $request->validate($rules);

        // ✅ Check scheme minimum amount
        $scheme = \App\Models\Scheme::find($validated['scheme_id']);

        if ($scheme && $validated['amount'] < $scheme->min_opening_balance) 
        {
            return back()->withErrors([
                'amount' => 'Minimum required amount for this scheme is ₹' . $scheme->min_opening_balance,
            ])->withInput();
        }

        // ✅ Create account

        try {
    DB::beginTransaction();

    $account = Account::create([
        'account_type'          => $request->account_type,
        'account_no'            => rand(100000, 999999), // Temporary
        'firm_name'             => $request->firm_d,
        'member_id'             => $request->member_id,
        'branch_id'             => $request->branch_id,
        'advisor_id'            => $request->advisor_id,
        'scheme_id'             => $request->scheme_id,
        'open_date'             => Carbon::parse($request->open_date)->format('Y-m-d'),
        'amount_deposit'        => $request->amount,
        'account_holder_type'   => $request->account_holder_type,
        'joint_member1'         => $request->member_id_one,
        'joint_member2'         => $request->member_id_two,
        'mode_of_operation'     => $request->account_holder_type === 'joint' ? $request->mode_of_operation : null,
        'payment_mode'          => $request->payment_mode,
        'transaction_date'      => Carbon::parse($request->transaction_date)->format('Y-m-d H:i:s'),
    ]);

    $account->account_no = 'SA' . str_pad($account->id, 6, '0', STR_PAD_LEFT);
    $account->save();

    // Save nominee(s)
    if ($request->nominee === 'yes') {
        AccountNominee::create([
            'account_id'        => $account->id,
            'nominee_name'      => $request->nominee_name,
            'nominee_relation'  => $request->nominee_relation,
            'nominee_address'   => $request->nominee_address,
            'share_percentage'  => 100.00,
        ]);

        if (is_array($request->additional_nominee_name)) {
            $count = count($request->additional_nominee_name);

            foreach ($request->additional_nominee_name as $index => $name) {
                if (trim($name) !== '') {
                    AccountNominee::create([
                        'account_id'        => $account->id,
                        'nominee_name'      => $name,
                        'nominee_relation'  => $request->additional_nominee_relation[$index] ?? '',
                        'nominee_address'   => $request->additional_nominee_address[$index] ?? '',
                        'share_percentage'  => round(100 / ($count + 1), 2),
                    ]);
                }
            }

            // Update primary nominee share
            AccountNominee::where('account_id', $account->id)
                ->where('nominee_name', $request->nominee_name)
                ->update(['share_percentage' => round(100 / ($count + 1), 2)]);
        }
    }

    // Save initial transaction
    Transaction::create([
        'account_id'        => $account->id,
        'payment_mode'      => $request->payment_mode,
        'amount'            => $request->amount,
        'transaction_type'  => 'credit',
        'transaction_date'  => now(),
        'approve_status'    => 'pending',
        'comment'           => 'Opening deposit',
        // Optional fields (uncomment if needed)
        // 'utr_number'        => $request->utr_number ?? null,
        // 'transfer_mode'     => $request->transfer_mode ?? null,
        // 'transfer_date'     => $request->transfer_date ?? null,
        // 'credited_in'       => $request->credited_in ?? null,
        // 'bank_name'         => $request->bank_name ?? null,
        // 'cheque_no'         => $request->cheque_no ?? null,
        // 'cheque_date'       => $request->cheque_date ?? null,
    ]);

    DB::commit();

   return redirect()->route('accounts.show', base64_encode($account->id))
    ->with('success', 'Account added successfully.');

} catch (\Exception $e) {
    DB::rollBack();
    return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
}

        

    }

    /**
     * Display the specified resource.
     */

    public function getBalance(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer|exists:accounts,id',
        ]);

        $balances = AccountsTransactionsHelper::getAccountBalacec([$request->account_id]);

       return response()->json([
            'balance' => $balances['total_balance'] ?? 0,
            'formatted' => '₹' . number_format($balances['total_balance'] ?? 0, 2),
        ]);

    }
    public function show(string $id)
    {
       
        $decryptedId = base64_decode($id);

        $account = Account::with(['minor', 'members', 'branch', 'address', 'users', 'transaction', 'nominee', 'scheme'])->findOrFail($decryptedId);

        $combined_balace = AccountsTransactionsHelper::getAccountBalacec([$decryptedId]);
        $combined_balace = $combined_balace['total_balance'] ?? 0;

        return view('saving-current-ac.accounts.view-account', compact('account', 'decryptedId', 'combined_balace'));
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
