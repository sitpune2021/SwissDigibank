<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\RdAccount;
use App\Models\Member;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccountNominee;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use App\Models\Rdscheme;
use App\Models\SavingsAccount;
use App\Models\Branch;
use App\Models\Minor;
use App\Models\RdTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RdAccountController extends Controller
{
    public function index()
    {

        $rdAccounts = RdAccount::with(['member', 'branch', 'minor', 'scheme'])
            ->latest()
            ->paginate(10);

        return view('mds_rd_accounts.mds-rd-account.index', compact('rdAccounts'));
    }

    public function create()
    {
        $members = Member::select(
            'id',
            'member_info_first_name',
            'member_info_middle_name',
            'member_info_last_name'
        )->get();
        $banks = Bank::all();
        $selectedBankId = 'bank_name';
        $schemes = Rdscheme::all();
        $accounts = Account::all();

        return view('mds_rd_accounts.mds-rd-account.create-rd-account', compact('members', 'schemes', 'accounts','banks','selectedBankId'));
    }

    // get member for rd creation
    public function getMember($id)
    {
        $member = Member::with('address', 'branch', 'minors')->find($id);

        $accounts = Account::where('member_id', $id)->get();

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        return response()->json([
            'member' => $member,
            'accounts' => $accounts

        ]);
    }

    public function store(Request $request)
    {
        try {
            Log::info('RD Account Store Request Received', $request->all());

            $rules = [
                'member_id' => 'required|exists:members,id',
                'minor_id' => 'nullable|exists:minors,id',
                'branch_id' => 'required|exists:branches,id',
                'advisor_staff' => 'nullable|string',
                'collection_advisor_staff' => 'nullable|string',
                'scheme' => [
                    'required',
                    'exists:rdschemes,id',
                ],
                'rd_amount' => 'required|numeric|min:1',
                'open_date' => 'required',
                'tds' => 'required|string|max:250',
                'accountType' => 'required|string|max:285',
                'nominee' => 'required|string|in:yes,no',
                'payment_mode' => 'required|in:cash,onlineTr,cheque,savingAcc',
                't_date' => 'required',

                // Online Transfer fields
                'transfer_date'   => 'nullable|required_if:payment_mode,onlineTr',
                'transaction_no'  => 'nullable|required_if:payment_mode,onlineTr|string|max:255',
                'transfer_mode'   => 'nullable|required_if:payment_mode,onlineTr|in:IMPS,VPA,NEFT/RTGS',
                'credited'        => 'nullable|required_if:payment_mode,onlineTr|in:yes,no',

                // Cheque fields
                'cheque_bank_name' => 'nullable|required_if:payment_mode,cheque|string|max:255',
                'cheque_no'        => 'nullable|required_if:payment_mode,cheque|string|max:50',
                'cheque_date'      => 'nullable|required_if:payment_mode,cheque',

                // Saving Account fields
                'savings_account'  => 'nullable|required_if:payment_mode,savingAcc|string|max:255',
            ];

            if ($request->nominee === 'yes') {
                $rules['nominees'] = 'required|array|min:1';
                $rules['nominees.*.name'] = 'required|string|max:258';
                $rules['nominees.*.relation'] = 'required|string|max:255';
                $rules['nominees.*.address'] = 'required|string|max:255';
            }

            $validated = $request->validate($rules);

            Log::info('RD Account Validated Data', $validated);

            $validated['open_date'] =  Carbon::createFromFormat('d-m-Y', $request->open_date)->format('Y-m-d');

            if (!empty($validated['t_date'])) {
                $validated['t_date'] = Carbon::createFromFormat('d-m-Y', $request->t_date)->format('Y-m-d');
            }
            if (!empty($validated['cheque_date'])) {
                $validated['cheque_date'] = Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d');
            }
            if (!empty($validated['transfer_date'])) {
                $validated['transfer_date'] = Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d');
            }

            $scheme = Rdscheme::findOrFail($request->scheme);
            Log::info('RD Scheme Data', $scheme->toArray());

            $summary = $this->calculateRDAccount(
                $request->rd_amount,
                $scheme->tenure_of_rd_dd_value,
                $scheme->tenure_of_rd_dd_type,
                $scheme->anuual_interest_rate,
                $scheme->sr_citizen_add_on_interest_rate ?? 0,
                $request->open_date
            );

            Log::info('RD Summary Calculated', $summary);

            $rdAccount = RdAccount::create([
                'member_id'   => $validated['member_id'],
                'minor_id'    => $validated['minor_id'] ?? null,
                'branch_id'   => $validated['branch_id'],
                'advisor_staff' => $validated['advisor_staff'] ?? null,
                'collection_advisor_staff' => $validated['collection_advisor_staff'] ?? null,
                'scheme'      => $validated['scheme'],
                'rd_amount'   => $validated['rd_amount'],
                'open_date'   => $validated['open_date'],
                'tds'         => $validated['tds'],
                'account_type' => $validated['accountType'],
                'payment_mode' => $validated['payment_mode'],

                'maturity_date'  => $summary['maturity_date'],
                'maturity_amount' => $summary['maturity_amount'],
                'principal'      => $summary['principal'] ?? $request->rd_amount,
                'total_interest' => $summary['total_interest'],
            ]);

            Log::info('RD Account Created', $rdAccount->toArray());

            if ($validated['nominee'] === 'yes' && isset($validated['nominees'])) {
                foreach ($validated['nominees'] as $nominee) {
                    AccountNominee::create([
                        'rd_account_id'    => $rdAccount->id,
                        'nominee_name'     => $nominee['name'],
                        'nominee_relation' => $nominee['relation'],
                        'nominee_address'  => $nominee['address'],
                    ]);
                }
                Log::info('RD Account Nominees Saved', $validated['nominees']);
            }

            $transactionData = [
                'rd_account_id'    => $rdAccount->id,
                'payment_mode'     => $validated['payment_mode'],
                't_date'           => $validated['t_date'],
                'amount'           => $validated['rd_amount'],
                'transaction_type' => 'credit',
                'approve_status'   => 'pending',
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            switch ($validated['payment_mode']) {
                case 'onlineTr':
                    $transactionData['transfer_date']  = $validated['transfer_date'] ?? null;
                    $transactionData['transaction_no'] = $validated['transaction_no'] ?? null;
                    $transactionData['transfer_mode']  = $validated['transfer_mode'] ?? null;
                    $transactionData['credited']       = $validated['credited'] ?? null;
                    break;

                case 'cheque':
                    $transactionData['cheque_bank_name'] = $validated['cheque_bank_name'] ?? null;
                    $transactionData['cheque_no']        = $validated['cheque_no'] ?? null;
                    $transactionData['cheque_date']      = $validated['cheque_date'] ?? null;
                    break;

                case 'savingAcc':
                    $transactionData['savings_account'] = $validated['savings_account'] ?? null;
                    break;
            }

            DB::table('rd_transactions')->insert($transactionData);
            Log::info('RD Transaction Saved', $transactionData);

            return redirect()
                ->route('mds-rd-accounts.rd-account-index')
                ->with('success', 'RD Account created successfully!');
        } catch (ValidationException $e) {
            // rethrow so Laravel handles it (shows validation errors in the view)
            throw $e;
        } catch (\Exception $e) {
            Log::error('RD Account Store Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()->withErrors('Something went wrong! Check logs for details.');
        }
    }

    function calculateRDAccount(
        $monthlyInstallment,
        $tenureValue,
        $tenureType,
        $annualRate,
        $srCitizenRate = 0,
        $openDate = null
    ) {
        // Apply Sr. Citizen extra interest if applicable
        $effectiveRate = $annualRate + $srCitizenRate;

        // Calculate total tenure in months
        switch ($tenureType) {
            case 'days':
                $tenureMonths = ceil($tenureValue / 30); // approx.
                break;
            case 'weeks':
                $tenureMonths = ceil(($tenureValue * 7) / 30);
                break;
            default: // months
                $tenureMonths = $tenureValue;
                break;
        }

        // Principal
        $principal = $monthlyInstallment * $tenureMonths;

        // RD Maturity Formula (quarterly compounding)
        // M = P * n + P * (n * (n + 1) / 2) * (r / 1200)
        $maturityAmount = $monthlyInstallment * $tenureMonths
            + $monthlyInstallment * ($tenureMonths * ($tenureMonths + 1) / 2) * ($effectiveRate / 1200);

        $totalInterest = $maturityAmount - $principal;

        // Maturity date calculation
        $openDateCarbon = $openDate ? Carbon::parse($openDate) : Carbon::now();
        $maturityDate = $openDateCarbon->copy()->addMonths($tenureMonths);

        return [
            'principal'       => round($principal, 2),
            'total_interest'  => round($totalInterest, 2),
            'maturity_amount' => round($maturityAmount, 2),
            'maturity_date'   => $maturityDate->format('Y-m-d'),
        ];
    }

    public function show($id)
    {
        $rdAccount = RdAccount::with(['member.address', 'branch', 'minor', 'nominees', 'rdTransactions' => function ($q) {
            $q->whereIn('approve_status', ['Pending', 'Approved'])
                ->orderBy('t_date', 'desc')
                ->limit(5);
        }])->findOrFail($id);
        $branches = Branch::all();
        $scheme = $rdAccount->rdScheme ?? $rdAccount->scheme;

        $calc = $this->computeRdMaturity($rdAccount, $scheme);

        return view('mds_rd_accounts.mds-rd-account.view.view-rd-account', compact('rdAccount', 'branches', 'calc'));
    }


    public function installmentPlan($id)
    {
        try {
            $rdAccount = RdAccount::with(['rdScheme'])->findOrFail($id);

            $scheme = $rdAccount->rdScheme ?? RdScheme::find($rdAccount->scheme);
            if (!$scheme) {
                $scheme = (object)[
                    'tenure_of_rd_dd_value' => 0,
                    'tenure_of_rd_dd_type'  => 'MONTHS',
                    'anuual_interest_rate'  => 0,
                    'interest_compounding_interval' => 'QUARTERLY',
                    'bonus_rate_type'       => null,
                    'bonus_rate_value'      => 0,
                ];
            }

            $installments = RdTransactions::where('rd_account_id', $rdAccount->id)
                ->orderBy('installment_no')
                ->get();

            $firstInstallment = $installments->where('installment_no', 1)->first();

            if (!$firstInstallment || $firstInstallment->approve_status !== 'Approved') {
                Log::warning('Installment plan blocked: First installment not approved', [
                    'rd_account_id'  => $rdAccount->id,
                    'installment_id' => $firstInstallment?->id,
                    'approve_status' => $firstInstallment?->approve_status,
                    'user_id'        => Auth::id(),
                ]);

                return redirect()->back()->with('error', 'Installment plan cannot be generated until the first installment is approved.');
            }

            // Compute maturity
            $computed = $this->computeRdMaturity($rdAccount, $scheme);

            Log::info('Installment plan generated successfully', [
                'rd_account_id'      => $rdAccount->id,
                'total_installments' => $installments->count(),
                'computed_maturity'  => $computed,
                'user_id'            => Auth::id(),
            ]);

            return view('mds_rd_accounts.mds-rd-account.view.installment-plan', compact('rdAccount', 'computed', 'installments'));
        } catch (\Throwable $e) {
            Log::error('Error generating installment plan', [
                'rd_account_id' => $id,
                'error'         => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
                'user_id'       => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Failed to generate installment plan. Please try again later.');
        }
    }

    public function showDepositForm($id)
    {
        $rdAccount = RdAccount::with('member', 'rdScheme', 'rdTransactions')->findOrFail($id);

        $totalReceived = $rdAccount->rdTransactions()->whereNotNull('paid_on')->where('transaction_type', 'credit')->sum('amount_received');

        return view('mds-rd-accounts.view.deposit-money', compact('rdAccount', 'totalReceived'));
    }

    public function showWithdrawForm($id)
    {
        $rdAccount = RdAccount::with('member', 'rdScheme', 'rdTransactions')->findOrFail($id);

        $totalReceived = $rdAccount->rdTransactions()->whereNotNull('paid_on')->where('transaction_type', 'credit')->sum('amount_received');
        $totalWithdrawn = $rdAccount->rdTransactions()->where('transaction_type', 'debit')->sum('amount');

        return view('mds_rd_accounts.mds-rd-account.view.withdraw-money', compact('rdAccount', 'totalReceived', 'totalWithdrawn'));
    }

    public function storeDeposit(Request $request, $rdAccountId)
    {
        try {
            Log::info("RD Deposit Request received", $request->all());

            $validated = $request->validate([
                'amount'            => 'required|numeric|min:1',
                't_date'            => 'required|date',
                'payment_mode'      => 'required|in:cash,online,cheque,saving',
                'remark'           => 'nullable|string|max:245',
                'collected_by'      => 'nullable|string|max:255',
                'transfer_date'     => 'nullable|required_if:payment_mode,online|date',
                'utr_no'            => 'nullable|required_if:payment_mode,online|string|max:255',
                'transfer_mode'     => 'nullable|required_if:payment_mode,online|in:IMPS,VPA,NEFT/RTGS',
                'cheque_bank_name'  => 'nullable|required_if:payment_mode,cheque|integer',
                'cheque_no'         => 'nullable|required_if:payment_mode,cheque|string|max:50',
                'cheque_date'       => 'nullable|required_if:payment_mode,cheque|date',
                'saving_account_id' => 'nullable|required_if:payment_mode,saving|integer',
            ]);

            Log::info("RD Deposit Validation passed", $validated);

            $rdAccount = RdAccount::with('rdscheme')->findOrFail($rdAccountId);

            $fixedAmount = $rdAccount->rd_amount;
            $depositAmount = $validated['amount'];
            $transactionDate = Carbon::parse($validated['t_date'])->format('Y-m-d');

            if (!$fixedAmount || $fixedAmount <= 0) {
                return back()->withErrors("Invalid scheme amount. Please check scheme setup.");
            }
            if ($depositAmount % $fixedAmount !== 0) {
                return back()->withErrors("Deposit amount must be the scheme amount (₹$fixedAmount) or a multiple of it.");
            }

            // Number of installments to pay
            $installmentsToPay = $depositAmount / $fixedAmount;

            // Fetch next pending installments
            $installments = RdTransactions::where('rd_account_id', $rdAccount->id)
                ->where('approve_status', null)
                ->orderBy('installment_no', 'asc')
                ->limit($installmentsToPay)
                ->get();

            if ($installments->count() < $installmentsToPay) {
                return back()->withErrors("Not enough pending installments for this deposit.");
            }


            foreach ($installments as $installment) {
                $installment->update([
                    'approve_status'   => 'Pending',
                    'payment_mode'     => $validated['payment_mode'],
                    'transaction_type' => 'credit',
                    'remarks'          => $validated['remarks'] ?? null,
                    'amount_received'  => $fixedAmount,
                    't_date'           => $transactionDate,
                    'paid_on'          => null,
                ]);
            }

            Log::info("RD Deposit updated installments", $installments->toArray());

            return redirect()->route('rd-accounts.show', $rdAccount->id)->with('success', 'Deposit submitted successfully for approval!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error("RD Deposit Error", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return back()->withErrors("Something went wrong while processing the deposit.");
        }
    }

    public function storeWithdraw(Request $request, $rdAccountId)
    {
        try {
            Log::info("RD Withdraw Request received", $request->all());

            $validated = $request->validate([
                'amount'            => 'required|numeric|min:1',
                't_date'            => 'required|date',
                'payment_mode'      => 'required|in:cash,online,cheque,saving',
                'remark'           => 'nullable|string|max:255',
                'transfer_date'     => 'nullable|required_if:payment_mode,online|date',
                'utr_no'            => 'nullable|required_if:payment_mode,online|string|max:255',
                'transfer_mode'     => 'nullable|required_if:payment_mode,online|in:IMPS,VPA,NEFT/RTGS',
                'cheque_bank_name'  => 'nullable|required_if:payment_mode,cheque|integer',
                'cheque_no'         => 'nullable|required_if:payment_mode,cheque|string|max:50',
                'cheque_date'       => 'nullable|required_if:payment_mode,cheque|date',
                'saving_account_id' => 'nullable|required_if:payment_mode,saving|integer',
            ]);

            Log::info("RD Withdraw Validation passed", $validated);

            $rdAccount = RdAccount::with('rdscheme')->findOrFail($rdAccountId);

            $totalReceived = $rdAccount->rdTransactions()->whereNotNull('paid_on')->where('transaction_type', 'credit')->sum('amount_received');

            // $totalWithdrawn = $rdAccount->rdTransactions()->where('transaction_type', 'debit')->sum('amount');
            $withdrawAmount = $validated['amount'];

            $availableBalance = $totalReceived - $withdrawAmount;

            $transactionDate = Carbon::parse($validated['t_date'])->format('Y-m-d');

            // Create withdrawal transaction
            RdTransactions::create([
                'rd_account_id'    => $rdAccount->id,
                'amount'           => $withdrawAmount,
                't_date'           => $transactionDate,
                'approve_status'   => 'Pending',
                'transaction_type' => 'debit',
                'payment_mode'     => $validated['payment_mode'],
                'balance'          => $availableBalance ?? null,
                'remark'           => $validated['remark'] ?? null,
            ]);
            Log::info("RD Withdraw created transaction", [
                'rd_account_id' => $rdAccount->id,
                'amount'        => $withdrawAmount,
                't_date'        => $transactionDate,
            ]);
            return redirect()->route('rd-accounts.show', $rdAccount->id)->with('success', 'Withdrawal submitted successfully for approval!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error("RD Withdraw Error", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return back()->withErrors("Something went wrong while processing the withdrawal.");
        }
    }

    public function approveTransaction($transactionId)
    {
        try {
            $transaction = RdTransactions::findOrFail($transactionId);

            if ($transaction->approve_status !== 'Pending') {
                return back()->withErrors('Only pending transactions can be approved.');
            }

            $rdAccount = $transaction->rdAccount;

            $lastApproved = RdTransactions::where('rd_account_id', $rdAccount->id)
                ->where('approve_status', 'Approved')
                ->orderBy('id', 'desc')
                ->first();

            $currentBalance = $lastApproved ? $lastApproved->balance : 0;

            if ($transaction->transaction_type === 'credit') {
                $fixedAmount = $rdAccount->rd_amount;

                if (!$fixedAmount || $fixedAmount <= 0) {
                    return back()->withErrors("Invalid scheme amount. Please check scheme setup.");
                }

                $transaction->update([
                    'approve_status'   => 'Approved',
                    'paid_on'          => now(),
                    't_date'           => now(),
                    'amount_received'  => $transaction->amount_received ?? $fixedAmount,
                    'balance'          => $currentBalance + ($transaction->amount_received ?? $fixedAmount),
                    'print_flag'       => 1,
                ]);

                Log::info("RD Deposit Approved", [
                    'transaction_id' => $transaction->id,
                    'rd_account_id'  => $rdAccount->id,
                    'amount'         => $transaction->amount_received ?? $fixedAmount,
                    'balance'        => $transaction->balance,
                ]);

                return back()->with('success', "Deposit approved successfully!");
            }

            if ($transaction->transaction_type === 'debit') {
                if ($transaction->amount > $currentBalance) {
                    return back()->withErrors("Insufficient balance for this withdrawal.");
                }

                $transaction->update([
                    'approve_status'   => 'Approved',
                    'paid_on'          => now(),
                    't_date'           => now(),
                    'balance'          => $currentBalance - $transaction->amount,
                    'print_flag'       => 1,
                ]);

                Log::info("RD Withdraw Approved", [
                    'transaction_id' => $transaction->id,
                    'rd_account_id'  => $rdAccount->id,
                    'amount'         => $transaction->amount,
                    'balance'        => $transaction->balance,
                ]);

                return back()->with('success', "Withdrawal approved successfully!");
            }

            return back()->withErrors("Invalid transaction type.");
        } catch (\Exception $e) {
            Log::error("RD Approval Error", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return back()->withErrors("Something went wrong while approving the transaction.");
        }
    }

    public function viewTransactions($id)
    {
        $rdAccount = RdAccount::with(['rdTransactions' => function ($query) {
            $query->where('approve_status', 'approved');
        }])->findOrFail($id);

        $rdAccounts = $rdAccount->rdTransactions;

        return view('mds_rd_accounts.mds-rd-account.view.view-transaction.view-rd-transactions', compact('rdAccount', 'rdAccounts'));
    }

    public function viewRdTransactionSummary($transactionId)
    {
        $transaction = RdTransactions::with(['rdAccount.member', 'rdAccount.rdScheme', 'rdAccount.branch'])
            ->findOrFail($transactionId);

        $rdAccount = $transaction->rdAccount;



        return view('mds_rd_accounts.mds-rd-account.view.view-transaction.view-transaction', compact('transaction', 'rdAccount'));
    }

    public function showChangeInfoForm($id)
    {
        $rdAccount = RdAccount::with(['member', 'rdScheme', 'minor'])->findOrFail($id);
        $schemes = RdScheme::all();
        $members = Member::where('id', '!=', $rdAccount->member_id)->get();
        return view('mds_rd_accounts.mds-rd-account.view.account-detail.change-account-info', compact('rdAccount', 'schemes', 'members'));
    }

    // Show Add Nominee Form
    public function showAddNomineeForm($id)
    {
        $rdAccount = RdAccount::with(['member', 'rdScheme', 'minor', 'nominees'])
            ->findOrFail($id);

        return view('mds_rd_accounts.mds-rd-account.view.account-detail.add-nominee', compact('rdAccount'));
    }


    public function saveNominee(Request $request, $id)
    {
        try {
            $rdAccount = RdAccount::with('nominees')->findOrFail($id);

            $request->validate([
                'nominees'            => 'required|array|min:1',
                'nominees.*.name'     => 'required|string|max:255',
                'nominees.*.relation' => 'required|string|max:255',
                'nominees.*.address'  => 'required|string|max:255',
            ]);

            $existingNominees = $rdAccount->nominees;

            foreach ($request->nominees as $index => $nomineeData) {
                // If nominee exists at this index → update
                if (isset($existingNominees[$index])) {
                    $existingNominees[$index]->update([
                        'nominee_name'     => $nomineeData['name'],
                        'nominee_relation' => $nomineeData['relation'],
                        'nominee_address'  => $nomineeData['address'],
                    ]);

                    Log::info('Nominee updated', [
                        'rd_account_id' => $rdAccount->id,
                        'nominee_id'    => $existingNominees[$index]->id,
                        'updated_data'  => $nomineeData,
                        'user_id'       => Auth::id() ?? null,
                    ]);
                } else {
                    // Else create a new nominee
                    $newNominee = $rdAccount->nominees()->create([
                        'nominee_name'     => $nomineeData['name'],
                        'nominee_relation' => $nomineeData['relation'],
                        'nominee_address'  => $nomineeData['address'],
                    ]);

                    Log::info('Nominee created', [
                        'rd_account_id' => $rdAccount->id,
                        'nominee_id'    => $newNominee->id,
                        'created_data'  => $nomineeData,
                        'user_id'       => Auth::id() ?? null,
                    ]);
                }
            }

            return redirect()->route('rd-accounts.show', $rdAccount->id)
                ->with('success', 'Nominees saved successfully.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error saving nominees', [
                'rd_account_id' => $id,
                'error_message' => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
                'user_id'       => Auth::id() ?? null,
            ]);

            return redirect()->route('rd-accounts.show', $id)
                ->with('error', 'An error occurred while saving nominees. Please try again.');
        }
    }

    public function showMinorForm($id)
    {
        $rdAccount = RdAccount::with(['member', 'rdScheme', 'minor', 'branch'])->findOrFail($id);
        $minors = Minor::where('member_id', $rdAccount->member_id)
            ->where('id', '!=', $rdAccount->minor_id)
            ->get();
        $totalReceived = $rdAccount->rdTransactions()->whereNotNull('paid_on')->where('transaction_type', 'credit')->sum('amount_received');


        return view('mds_rd_accounts.mds-rd-account.view.account-detail.add-minor', compact('rdAccount', 'minors', 'totalReceived'));
    }

    private function computeRdMaturity($rdAccount, $scheme): array
    {
        try {
            // Dates
            $startDate = !empty($rdAccount->open_date) ? Carbon::parse($rdAccount->open_date) : now();

            $tenureValue = (int)($scheme->tenure_of_rd_dd_value ?? 0);
            $tenureType  = strtoupper(trim($scheme->tenure_of_rd_dd_type ?? 'MONTHS'));

            if ($tenureType === 'YEAR' || $tenureType === 'YEARS') {
                $months = $tenureValue * 12;
            } elseif ($tenureType === 'DAY' || $tenureType === 'DAYS') {

                $maturityDate = (clone $startDate)->addDays($tenureValue);
                $months = (int) ceil($tenureValue / 30);
            } else {

                $months = $tenureValue;

                $maturityDate = (clone $startDate)->copy();
                for ($i = 0; $i < $months; $i++) {
                    $maturityDate->addMonthNoOverflow();
                }
            }

            // Amounts / Rates
            $P = (float)($rdAccount->rd_amount ?? 0);                       // monthly deposit
            $annualRatePct = (float)($scheme->anuual_interest_rate ?? 0);   // annual %
            $r = $annualRatePct / 100.0;

            // Compounding frequency
            $comp = strtoupper(trim($scheme->interest_compounding_interval ?? 'QUARTERLY'));
            $m = match ($comp) {
                'MONTHLY'   => 12,
                'QUARTERLY' => 4,
                'HALFYEARLY', 'HALF-YEARLY', 'SEMIANNUAL', 'SEMI-ANNUAL' => 2,
                'YEARLY', 'ANNUALLY', 'ANNUAL' => 1,
                default     => 4,
            };

            // Effective monthly rate (convert compounding -> monthly)
            $i = $r > 0 ? pow(1 + $r / $m, $m / 12) - 1 : 0.0;

            $N = max(0, (int)$months);
            $principal = $P * $N;

            if ($i == 0.0) {
                $maturity = $principal;
            } else {
                $maturity = $P * ((pow(1 + $i, $N) - 1) / $i) * (1 + $i);
            }

            $interest = $maturity - $principal;

            $bonusType = strtolower((string)($scheme->bonus_rate_type ?? ''));
            $bonusVal  = (float)($scheme->bonus_rate_value ?? 0);
            $bonus = in_array($bonusType, ['percent', 'percentage', '%'], true)
                ? $maturity * ($bonusVal / 100.0)
                : $bonusVal;

            $maturityAmount = $maturity + $bonus;

            $computed = [
                'maturity_date'   => $maturityDate,
                'principal'       => round($principal, 2),
                'total_interest'  => round($interest, 2),
                'bonus'           => round($bonus, 2),
                'maturity_amount' => round($maturityAmount, 2),
                'effective_monthly_rate_pct' => round($i * 100, 6),
                'compounding_per_year'       => $m,
                'tenure_months'              => $months,
                'annual_rate_pct'            => $annualRatePct,
            ];

            $rdAccount->update([
                'principal'       => $computed['principal'],
                'total_interest'  => $computed['total_interest'],
                'maturity_amount' => $computed['maturity_amount'],
                'maturity_date'   => $computed['maturity_date'],
            ]);

            return $computed;
        } catch (\Throwable $e) {
            Log::error('Error computing RD maturity', [
                'account_id' => $rdAccount->id ?? null,
                'scheme_id'  => $scheme->id ?? null,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return [
                'maturity_date'   => null,
                'principal'       => 0,
                'total_interest'  => 0,
                'bonus'           => 0,
                'maturity_amount' => 0,
                'effective_monthly_rate_pct' => 0,
                'compounding_per_year'       => 0,
                'tenure_months'              => 0,
                'annual_rate_pct'            => 0,
            ];
        }
    }
}
