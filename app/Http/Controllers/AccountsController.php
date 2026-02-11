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
use App\Mail\AccountOpenedMail;
use App\Models\Bank;
use App\Models\MembershipChargeTransaction;
use App\Helpers\AccountHelper;
use App\Helpers\SmsHelper;
use App\Models\DdsAccount;
use App\Models\FdAccount;
use App\Models\Misaccount;
use App\Models\RdAccount;
use App\Models\SavingOtherCharge;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $Accounts = Account::with(['members', 'users', 'minor', 'scheme', 'address'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $Transactions = MembershipChargeTransaction::orderBy('created_at', 'desc')->get();

            return view('saving-current-ac.accounts.index', compact('Accounts', 'Transactions'));
        } catch (\Exception $e) {
            abort(404, 'Data not found.');
        }
    }

    /**
     * Show the form for creating a new resource.
     * Created by: Deepak
     */

    public function create()
    {
        try {
           
            $members = Member::pluck('member_info_first_name', 'id', 'member_info_mobile_no');
            $branches = Branch::pluck('branch_name', 'id');
            $address = Address::pluck('member_address_line_1', 'id');
            $schemeMinimums = Scheme::pluck('min_opening_balance', 'id');
            $minors = Minor::pluck('first_name', 'id');

            // $banks = Bank::all();
            $banks = Bank::pluck('name'); // returns collection of bank names
            $selectedBankId = 'bank_name';

            $schemes = Scheme::pluck('scheme_name', 'id');
            $advisors = User::pluck('fname', 'id');

            $members = Member::all();

            $address = Member::with('address')->get();

            $formFields = config('accounts.form_fields');

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
                'schemeMinimums',
                'selectedBankId',
                'banks'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            Log::info('Account store request started', ['request_data' => $request->all()]);

            $rules = [
                'account_type' => 'required|in:saving,current',
                'firm_d' => 'nullable|required_if:account_type,current|max:255',
                'member_id' => 'required|exists:members,id',
                'branch_id' => 'required|exists:branches,id',
                'advisor_id' => 'nullable|exists:users,id',
                'scheme_id' => 'required|integer|exists:schemes,id',
                'open_date' => 'required|date',
                'amount' => 'required|numeric|min:0',
                'account_holder_type' => 'required|in:single,joint',
                'member_id_one' => 'nullable|required_if:account_holder_type,joint',
                'member_id_two' => 'nullable',
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

            if ($request->payment_mode === 'online') {
                $rules['pay1_transfer_utr'] = 'required|string|max:50';
                $rules['transfer_mode'] = 'nullable|string|max:50';
                $rules['credited'] = 'nullable|numeric|max:100';
            }

            if ($request->payment_mode === 'cheque') {
                 $rules['bank_name'] = 'required|string|max:100';
                $rules['pay1_cheque_no'] = 'required|numeric';
                $rules['pay1_cheque_date'] = 'nullable|date';
            }

            $validator = Validator::make($request->all(), $rules);

            $validator->after(function ($validator) use ($request) {
                $member = Member::with('shareTransfers')->find($request->member_id);
                if (!$member || $member->shareTransfers->isEmpty()) {
                    $validator->errors()->add('member_id', 'This member has no shares allocated. You cannot open a saving account.');
                }
            });

            if ($validator->fails()) {
                Log::warning('Validation failed', ['errors' => $validator->errors()]);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validated = $validator->validated();

            $scheme = \App\Models\Scheme::find($validated['scheme_id']);
            if ($scheme && $validated['amount'] < $scheme->min_opening_balance) {
                return back()->withErrors([
                    'amount' => 'Minimum required amount for this scheme is ₹' . $scheme->min_opening_balance,
                ])->withInput();
            }

            DB::beginTransaction();
            Log::info('DB transaction started');

            $account = Account::create([
                'account_type' => $request->account_type,
                'account_no' => rand(100000, 999999), // Temporary
                'firm_name' => $request->firm_d,
                'member_id' => $request->member_id,
                'branch_id' => $request->branch_id,
                'advisor_id' => $request->advisor_id,
                'scheme_id' => $request->scheme_id,
                'open_date' => Carbon::parse($request->open_date)->format('Y-m-d'),
                'amount_deposit' => $request->amount,
                'account_holder_type' => $request->account_holder_type,
                'joint_member1' => $request->member_id_one,
                'joint_member2' => $request->member_id_two,
                'mode_of_operation' => $request->account_holder_type === 'joint' ? $request->mode_of_operation : null,
                'payment_mode' => $request->payment_mode,
                'transaction_date' => $request->transaction_date ? Carbon::parse($request->transaction_date)->format('Y-m-d H:i:s') : null,
            ]);

            $account->account_no = 'SBC111' . str_pad($account->id, 9, '0', STR_PAD_LEFT);

            $account->save();

            if ($request->nominee === 'yes') {
                AccountNominee::create([
                    'account_id' => $account->id,
                    'nominee_name' => $request->nominee_name,
                    'nominee_relation' => $request->nominee_relation,
                    'nominee_address' => $request->nominee_address,
                    'share_percentage' => 100.00,
                ]);

                if (is_array($request->additional_nominee_name)) {
                    foreach ($request->additional_nominee_name as $index => $name) {
                        if (trim($name) !== '') {
                            AccountNominee::create([
                                'account_id' => $account->id,
                                'nominee_name' => $name,
                                'nominee_relation' => $request->additional_nominee_relation[$index] ?? '',
                                'nominee_address' => $request->additional_nominee_address[$index] ?? '',
                                'share_percentage' => round(100 / (count($request->additional_nominee_name) + 1), 2),
                            ]);
                        }
                    }
                }
            }

            // Transaction
            Transaction::create([
                'account_id' => $account->id,
                'payment_mode' => $request->payment_mode,
                'amount' => $request->amount,
                'transaction_type' => 'credit',
                'transaction_date' => now(),
                'approve_status' => 'approved',
                'comment' => 'Opening deposit',
                'utr_number' => $request->pay1_transfer_utr ?? null,
                'transfer_mode' => $request->transfer_mode ?? null,
                'transfer_date' => $request->pay1_transfer_date ? Carbon::parse($request->pay1_transfer_date)->format('Y-m-d') : null,
                'credited_in' => $request->credited ?? null,
                'bank_name' => $request->bank_name ?? null,
                'cheque_no' => $request->pay1_cheque_no ?? null,
                'cheque_date' => $request->pay1_cheque_date ? Carbon::parse($request->pay1_cheque_date)->format('Y-m-d') : null,
            ]);

            DB::commit();
            Log::info('DB transaction committed');

            try {
                $member = \App\Models\Member::find($account->member_id);

                $dlttemplateid = 1707172234093782668;
                $mobile = $member->member_info_mobile_no;

                $account1 = $account->account_no;

                $message = "Dear Customer, we have received your saving a/c application. Your temp. a/c no. is $account1. SBC GLOBAL";

                \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            } catch (\Exception $e) {
                Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
            }
            return redirect()->route('accounts.show', base64_encode($account->id))
                ->with('success', 'Please approve status!.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store account', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */

    public function getBalance(Request $request)
    {
        try {
            $request->validate([
                'account_id' => 'required|integer|exists:accounts,id',
            ]);

            $balances = AccountsTransactionsHelper::getAccountBalacec([$request->account_id]);

            return response()->json([
                'balance' => $balances['total_balance'] ?? 0,
                'formatted' => '₹' . number_format($balances['total_balance'] ?? 0, 2),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function show(string $id)
    {

        try {
            $decryptedId = base64_decode($id);

            $account = Account::with(['minor', 'members', 'branch', 'address', 'users', 'transaction', 'nominee', 'scheme'])->findOrFail($decryptedId);

            $combined_balace = AccountsTransactionsHelper::getAccountBalacec([$decryptedId]);
            $combined_balace = $combined_balace['total_balance'] ?? 0;


            return view('saving-current-ac.accounts.view-account', compact('account', 'decryptedId', 'combined_balace'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }


    public function destroy(string $id)
    {
    }

    public function viewPassbook($id)
    {
        $id = base64_decode($id);
        $accounts = Account::with(
            'transaction',
             'members.address.state',
           
            'branch',
            // 'address',
            'nominee',
          )  
        ->findOrFail($id);
        //  ->where('id', $id)->get();

        // dd($accounts);
        return view('saving-current-ac.accounts.passbook', compact('accounts'));
    }

    public function passbookSearch(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'from_date' => 'required|date_format:d-m-Y',
            'to_date' => 'required|date_format:d-m-Y|after_or_equal:from_date',
            'print' => 'required|in:front,statement,full',
        ]);

        $accountId = $request->account_id;

        $account = Account::with([
          
             'members.address.state',
               // 'members',
         'branch',
          'nominee',
           'scheme',
            // 'address.state'
            'jointMemberOne',
    'jointMemberTwo'
            ])
            ->find($accountId);

        $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->startOfDay();
        $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->endOfDay();

        $transactions = Transaction::where('account_id', $accountId)
            ->whereBetween('transaction_date', [$fromDate, $toDate])
            ->orderBy('transaction_date')
            ->get();

        $startingBalance = AccountsTransactionsHelper::getAccountBalanceBeforeDate($accountId, $fromDate);
        $runningBalance = $startingBalance;

        $transactions = $transactions->transform(function ($txn) use (&$runningBalance) {
            if ($txn->transaction_type === 'debit') {
                $runningBalance -= $txn->amount;
            } elseif ($txn->transaction_type === 'credit') {
                $runningBalance += $txn->amount;
            }

            return [
                'date' => $txn->transaction_date ? \Carbon\Carbon::parse($txn->transaction_date)->format('d-m-Y') : null,
                'description' => $txn->description ?? '-',
                'cheque_no' => $txn->cheque_no ?? '-',
                'debit_amount' => $txn->transaction_type === 'debit' ? $txn->amount : null,
                'credit_amount' => $txn->transaction_type === 'credit' ? $txn->amount : null,
                'balance' => $runningBalance,

            ];
        });

        $transactions->prepend([
            'date' => $fromDate->format('d-m-Y'),
            'description' => 'Opening Balance',
            'cheque_no' => '-',
            'debit_amount' => null,
            'credit_amount' => null,
            'balance' => $startingBalance,
        ]);

        return response()->json([
            'success' => true,
            'account' => $account,
            'transactions' => $transactions,
            'printType' => $request->print,
            'fromDate' => $request->from_date,
            'toDate' => $request->to_date,
            'scheme_name' => $account->scheme?->scheme_name ?? '-',
            'open_date' => optional($account->open_date)->format('d-m-Y'),

        ]);
    }

    // Other debit charges list
    public function debitChargeList(string $id)
    {
        $account_id = base64_decode($id);
        // $charges  = SavingOtherCharge::with('account')->where('account_id', $account_id)->first();
        $charges = Account::with('savingOtherCharges')->where('id', $account_id)->first();

        return view('saving-current-ac.accounts.debit-other-charges.debit-other-chargelist', compact('charges'));
    }

    public function otherCharges(string $id)
    {
        $account = Account::with(['members.kyc', 'scheme', 'branch'])->findOrFail($id);
        return view('saving-current-ac.accounts.debit-other-charges.debit-other-charges', compact('account'));
    }

    public function storeOtherCharges(Request $request, $id)
    {
        try {
            $request->validate([
                'charge_type' => 'required',
                'amount' => 'required|numeric|min:0',
                'gst_rate' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'charge_date' => 'required|date',
            ]);

            $formattedDate = \Carbon\Carbon::parse($request->charge_date)->format('Y-m-d');

            $charge = SavingOtherCharge::create([
                'account_id' => $id,
                'charge_type' => $request->charge_type,
                'amount' => $request->amount,
                'gst_rate' => $request->gst_rate,
                'total_amount' => $request->total_amount,
                'charge_date' => $formattedDate,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            ]);

            Log::info('Other charge debited successfully', [
                'user_id' => Auth::id(),
                'account_id' => $request->account_id,
                'charge_id' => $charge->id ?? null,
                'data' => $request->all(),
            ]);

            return redirect()->route('accounts.other.debit-charges', base64_encode($id))->with('success', 'Other charge debited successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed while debiting other charge', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error occurred while storing other charge', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'input_data' => $request->all(),
            ]);

            return back()->with('error', 'Something went wrong while saving the other charge. Please try again.');
        }
    }

    // clear due
    public function clearDue(string $id)
    {
        $account_id = base64_decode($id);
        $account = SavingOtherCharge::with('account')->where('account_id', $account_id)->first();
        return view('saving-current-ac.accounts.debit-other-charges.clear-dues', compact('account'));
    }

    public function storeDebitCharge(Request $request, $id)
    {
        $account_id = base64_decode($id);

        $validated = $request->validate([
            'charges_due' => 'nullable|numeric',
            'waived_amount' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'gst_rate' => 'nullable|numeric|min:0|max:100',
            'total_amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
            'charge_date' => 'required|date',
        ]);

        $state = null;
        if ($validated['waived_amount'] > 0 && $validated['waived_amount'] < $validated['total_amount']) {
            $state = 'PARTIAL_WAIVED';
        } elseif ($validated['waived_amount'] == $validated['total_amount']) {
            $state = 'WAIVED';
        }

        try {
            $charge = new SavingOtherCharge();
            $charge->account_id = $account_id;
            $charge->charge_date = $validated['charge_date'];
            $charge->amount = $validated['amount'];
            $charge->gst_rate = $validated['gst_rate'] ?? 0;
            $charge->total_amount = $validated['total_amount'];
            $charge->waived_amount = $validated['waived_amount'];
            $charge->remarks = $validated['remarks'] ?? null;
            $charge->state = $state;
            $charge->status = 'approved'; // active
            $charge->created_by = Auth::id();

            $charge->save();

            Log::info('Debit charge recorded successfully', [
                'user_id' => Auth::id(),
                'account_id' => $account_id,
                'charge_id' => $charge->id,
                'charge_date' => $validated['charge_date'],
                'amount' => $validated['amount'],
                'gst_rate' => $validated['gst_rate'],
                'total_amount' => $validated['total_amount'],
                'waived_amount' => $validated['waived_amount'],
                'state' => $state,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            return redirect()->back()->with('success', 'Debit charge recorded successfully.');
        } catch (\Exception $e) {
            Log::error('Error while recording debit charge', [
                'user_id' => Auth::id(),
                'account_id' => $account_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Failed to record debit charge. Please try again.');
        }
    }

    public function creditInterest(string $id)
    {
        $account_id = base64_decode($id);
        $account = SavingOtherCharge::with('account')->where('account_id', $account_id)->first();

        return view('saving-current-ac.accounts.account-details.credit_debit_interest', compact('account'));
    }

    public function storeCreditDebitInterest(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'remarks' => 'nullable|string|max:255',
        ]);

        $account = Account::findOrFail($id);

        $transaction = new Transaction();
        $transaction->account_id = $account->id;
        $transaction->transaction_date = Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');
        $transaction->transaction_type = "credit"; // CREDIT / DEBIT
        $transaction->amount = $request->amount;
        $transaction->remarks = $request->remarks ?? null;
        $transaction->payment_mode = "system";
        $transaction->comment = "Deposit";

        $transaction->save();

        Log::info('Interest transaction recorded', [
            'user_id' => Auth::id(),
            'account_id' => $account->id,
            'transaction_id' => $transaction->id,
            'transaction_type' => $transaction->transaction_type,
            'payment_mode' => $transaction->payment_mode,
            'amount' => $transaction->amount,
            'remarks' => $transaction->remarks,
            'transaction_date' => $transaction->transaction_date,
            'timestamp' => now()->toDateTimeString(),
        ]);

        return redirect()
            ->route('accounts.show', base64_encode($account->id))
            ->with('success', 'Interest ' . ucfirst($request->transaction_type) . ' recorded successfully.');
    }

    public function accountNominee($type, $id)
    {

        $account_id = base64_decode($id);

        switch ($type) {

            case 'saving-account':
                $account = Account::with('members', 'nominee')->findOrFail($account_id);
                $member = $account->member ?? $account->members ?? null;
                $view = 'saving-current-ac.accounts.account-details.account-nominee';
                break;

            case 'rd':
                $account = RdAccount::with('member', 'nominee')->findOrFail($account_id);
                $member = $account->member ?? null;
                $view = 'mds_rd_accounts.mds-rd-account.view.account-detail.add-nominee';
                break;

            case 'fd':
                $account = FdAccount::with('member', 'nominee')->findOrFail($account_id);
                $member = $account->member ?? null;
                $view = 'fd_mis_account.fd-account.fd-accountnominee';
                break;

            case 'dd':
                $account = DdsAccount::with('member', 'nominee')->findOrFail($account_id);
                $member = $account->member ?? null;
                $view = 'fd_account.ddsaccounts.account-nominee';
                break;

            case 'mis':
                $account = Misaccount::with('member', 'nominee')->findOrFail($account_id);
                $member = $account->member ?? null;
                $view = 'fd_mis_account.misaccount.account-details.add_nominee';
                break;
            default:
                abort(404, 'Invalid account type');
        }

        try {
            $hasNominee = method_exists($account, 'nominee')
                ? ($account->nominee()->count() > 0)
                : (is_countable($account->nominee) ? count($account->nominee) > 0 : false);
        } catch (\Throwable $e) {

            Log::warning('Could not determine nominee count', [
                'account_id' => $account->id ?? $account_id,
                'error' => $e->getMessage()
            ]);
            $hasNominee = false;
        }

        return view($view, compact('account', 'member', 'hasNominee', 'type'));
    }

    public function saveNominees(Request $request, $type, $accountId)
    {

        Log::info("Nominee save process started", [
            'account_id' => $accountId,
            'type' => $type,
            'request' => $request->all()
        ]);
        try {

            // 1️⃣ VALIDATION
            $request->validate([
                'nominee' => 'required|in:yes,no',
                'nominees' => 'nullable|array',
                'nominees.*.relation' => 'required_if:nominee,yes',
                'nominees.*.name' => 'required_if:nominee,yes',
                'nominees.*.address' => 'required_if:nominee,yes',
            ]);

            Log::info("Validation passed successfully");

            switch ($type) {
                case 'saving-account':
                    $account = Account::findOrFail($accountId);
                    $column = 'account_id';
                    break;

                case 'rd':
                    $account = RdAccount::findOrFail($accountId);
                    $column = 'rd_account_id';
                    break;

                case 'fd':
                    $account = FdAccount::findOrFail($accountId);
                    $column = 'fd_account_id';
                    break;

                case 'dd':
                    $account = DdsAccount::findOrFail($accountId);
                    $column = 'dds_account_id';
                    break;

                case 'mis':
                    $account = Misaccount::findOrFail($accountId);
                    $column = 'mis_account_id';
                    break;

                default:
                    Log::error("Invalid account type detected", ['type' => $type]);
                    return back()->with('error', 'Invalid account type.');
            }

            Log::info("Account model resolved", [
                'column' => $column,
                'account_id' => $account->id
            ]);

            if ($request->nominees === 'no') {

                $deleted = $account->nominee()->count();
                $account->nominee()->delete();

                Log::info("All nominees deleted from account", [
                    'account_id' => $account->id,
                    'deleted_count' => $deleted
                ]);

                return back()->with('success', 'Nominee removed successfully.');
            }

            $submittedIds = collect($request->nominees)
                ->pluck('id')
                ->filter()
                ->toArray();

            Log::info("Submitted nominee IDs", ['ids' => $submittedIds]);

            $deleted = $account->nominee()
                ->whereNotIn('id', $submittedIds)
                ->delete();

            if ($deleted > 0) {
                Log::info("Old nominees removed", [
                    'account_id' => $account->id,
                    'deleted_count' => $deleted
                ]);
            }

            foreach ($request->nominees as $nominee) {

                if (!empty($nominee['id'])) {

                    Log::info("Updating nominee record", [
                        'nominee_id' => $nominee['id'],
                        'account_id' => $account->id
                    ]);

                    AccountNominee::where('id', $nominee['id'])->update([
                        'nominee_relation' => $nominee['relation'],
                        'nominee_name' => $nominee['name'],
                        'nominee_address' => $nominee['address'],
                    ]);
                } else {

                    $newNominee = AccountNominee::create([
                        $column => $account->id,
                        'nominee_relation' => $nominee['relation'],
                        'nominee_name' => $nominee['name'],
                        'nominee_address' => $nominee['address'],
                    ]);

                    Log::info("New nominee created", [
                        'nominee_id' => $newNominee->id,
                        'account_id' => $account->id
                    ]);
                }
            }

            Log::info("Nominee operation completed successfully", [
                'account_id' => $account->id
            ]);

            return back()->with('success', 'Nominee saved successfully.');
        } catch (\Throwable $e) {

            Log::error("Nominee save failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'account_id' => $accountId,
                'type' => $type
            ]);

            return back()->with('error', 'Something went wrong while saving nominees.');
        }
    }


    public function closeAccount($id)
    {
        $account_id = base64_decode($id);
        $account = Account::with(['transaction', 'members.kyc', 'scheme', 'savingOtherCharges'])->where('id', $account_id)->first();

        $balance = AccountsTransactionsHelper::getAccountBalacec($account_id);
        $available_balance = $balance['total_balance'];

        $interest_accrued = $this->calculateInterestAccrued($account);
        // $penalty_charges   = $account->penaltyCharges->sum('amount');
        // $other_charges     = $account->savingOtherCharges->sum('amount');

        $penalty_charges = optional($account->penaltyCharges)->sum('amount') ?? 0;
        $other_charges = optional($account->savingOtherCharges)->sum('amount') ?? 0;

        // Formula: E = A + B - C - D
        $total_value = $available_balance + $interest_accrued - $penalty_charges - $other_charges;

        // Rounding off
        $round_off = round($total_value, 0);
        return view('saving-current-ac.accounts.close-acc', compact(
            'account',
            'available_balance',
            'interest_accrued',
            'penalty_charges',
            'other_charges',
            'total_value',
            'round_off'
        ));
    }

    private function calculateInterestAccrued($account)
    {

        // Example logic — replace with your business logic
        $rate = $account->scheme->interest_rate ?? 0;
        $available_balance = AccountsTransactionsHelper::getAccountBalacec($account->id);
        $balance = $available_balance['total_balance'];
        $days = now()->diffInDays($account->created_at);

        return round(($balance * $rate * $days) / (365 * 100), 2);
    }

    // public function accountOpenForm($id)
    // {

    //     $account_id = base64_decode($id);
    //     $account = Account::with(['transaction', 'members.kyc', 'members.address.state', 'scheme', 'savingOtherCharges'])->where('id', $account_id)->first();
    //     return view('saving-current-ac.accounts.saving-account-application-form', compact('account'));
    // }


    public function accountOpenFormPreview($id)
    {
        $account_id = base64_decode($id);

        $account = Account::with([
            'transaction',
            'members.kyc',
            'members.address.state',
            'scheme',
            'savingOtherCharges'
        ])->findOrFail($account_id);

        return view(
            'saving-current-ac.accounts.saving-account-application-form',
            compact('account')
        );
    }

    public function accountOpenFormDownload($id)
    {
        // Decode ID
        $account_id = base64_decode($id);

        // Fetch account with relations
        $account = Account::with([
            'transaction',
            'members.kyc',
            'members.address.state',
            'scheme',
            'savingOtherCharges'
        ])->findOrFail($account_id);


        // Generate PDF
        $pdf = Pdf::loadView('saving-current-ac.accounts.saving-account-appli-download', compact('account'))
            ->setPaper('A4', 'portrait');

        // Stream in browser
        return $pdf->download('saving-account-opening-form.pdf');
    }

}






