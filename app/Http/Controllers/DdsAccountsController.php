<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\DdsAccount;
use App\Models\Minor;
use App\Models\Account;
use App\Models\AccountNominee;
use App\Models\DdTransaction;
use App\Models\Rdscheme;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;

class DdsAccountsController extends Controller
{
    public function index()
    {
        $ddaccounts = DdsAccount::with(['member', 'branch', 'scheme'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fd_account.ddsaccounts.index', compact('ddaccounts'));
    }


    public function create()
    {
        $members  = Member::all();
        $branches = Branch::all();
        $schemes  = Scheme::all();
        $minors   = Minor::all();
        $savingAccounts = Account::where('account_type', 'saving')->get();
        $members = Member::orderBy('member_info_first_name')->get();

        return view('fd_account.ddsaccounts.create', compact('members', 'branches', 'schemes', 'minors', 'savingAccounts'));
    }
    public function show($id)
    {
        $ddaccount = DdsAccount::with(['member', 'branch', 'scheme', 'transactions'])->findOrFail($id);
        $branches = Branch::select('id', 'branch_name')->orderBy('branch_name')->get();
        $branches = Branch::all(); // or whatever query you need
        $members  = Member::all();

        return view('fd_account.ddsaccounts.show', compact('ddaccount', 'branches', 'members'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'member_id' => 'required|integer',
                'branch_id' => 'required|integer',
                'scheme_id' => 'required|integer',
                'open_date' => 'required|date',
                'amount' => 'required|numeric',
                'nominee' => 'required|in:yes,no',
                'pay_mode' => 'required|in:cash,onlineTr,cheque,saving',
                'dd_amount' => 'required|numeric|min:100',

            ]);
            // $scheme = Rdscheme::findOrFail($validated['scheme_id']);

            // $depositPerDay = $scheme->min_rd_dd_amount;

            // if ($scheme->tenure_of_rd_dd_type === 'months') {
            //     $days = $scheme->tenure_of_rd_dd_value * 30;
            // } elseif ($scheme->tenure_of_rd_dd_type === 'years') {
            //     $days = $scheme->tenure_of_rd_dd_value * 365;
            // } else {
            //     $days = $scheme->tenure_of_rd_dd_value;
            // }

            // $rate = $scheme->anuual_interest_rate; 

            // if ($scheme->bonus_rate_type === 'percentage') {
            //     $bonusRate = $scheme->bonus_rate_value;
            //     $fixedBonus = 0;
            // } elseif ($scheme->bonus_rate_type === 'fixed') {
            //     $bonusRate = 0;
            //     $fixedBonus = $scheme->bonus_rate_value;
            // } else {
            //     $bonusRate = 0;
            //     $fixedBonus = 0;
            // }
            
            // $calculation = $this->calculateDailyDeposit(
            //     $validated['deposit_per_day'],
            //     $validated['days'],
            //     $validated['rate'],
            //     $validated['bonus_rate'] ?? 0,
            //     $validated['fixed_bonus'] ?? 0
            // );

            Log::info("Validated data", $validated);

            $ddsAccount = new DdsAccount();
            $ddsAccount->member_id = $request->member_id;
            $ddsAccount->branch_id = $request->branch_id;
            $ddsAccount->scheme_id = $request->scheme_id;
            $ddsAccount->dd_amount = $request->amount;
            $ddsAccount->open_date = $request->open_date;
            $ddsAccount->nominee = ($request->nominee === 'yes') ? 1 : 0;
            $ddsAccount->account_type = 'single';
            $ddsAccount->tds_deduction = 0;
            $ddsAccount->save();

            Log::info("DdsAccount saved successfully", ['id' => $ddsAccount->id]);

            $transaction = new DdTransaction();
            $transaction->dds_account_id = $ddsAccount->id;
            $transaction->transaction_date = now()->format('Y-m-d');
            $transaction->amount = $request->amount;
            $transaction->pay_mode = $request->pay_mode;
            $transaction->save();

            if ($request->nominee === "yes" && $request->has('nominee_name')) {
                $totalNominees = count(array_filter($request->nominee_name));
                $share = $totalNominees > 0 ? round(100 / $totalNominees, 2) : 100;

                foreach ($request->nominee_name as $key => $name) {
                    if (!empty($name)) {
                        AccountNominee::create([
                            'account_id'       =>  $ddsAccount->id,
                            'nominee_name'     => $name,
                            'nominee_relation' => $request->nominee_relation[$key] ?? null,
                            'nominee_address'  => $request->nominee_address[$key] ?? null,
                            'share_percentage' => $share,
                        ]);
                    }
                }
                Log::info('Nominees saved', ['count' => $totalNominees]);
            }

            Log::info("DdTransaction saved successfully", ['id' => $transaction->id]);

            return redirect()->route('dds-accounts.index')
                ->with('success', 'DDS Account created successfully!');
        } catch (\Exception $e) {
            Log::error("Store error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            dd("Error => " . $e->getMessage());
        }
    }

    public function edit(DdsAccount $ddaccount)
    {
        $members = Member::select('id', 'member_info_first_name', 'member_info_last_name', 'mobile_no')
            ->orderBy('member_info_first_name')
            ->get();
        $branches = Branch::all(); // or whatever query you need
        $members  = Member::all();


        return view('dds-accounts.edit', compact('ddaccount', 'members', 'branches'));
    }

    // public function edit($id)
    // {
    //     $ddaccount = DdsAccount::findOrFail($id);
    //     $members = Member::all();
    //     $branches = Branch::all();
    //     $schemes = Scheme::all();
    //     $minors = Minor::all();
    //     $savingAccounts = Account::where('account_type', 'saving')->get();

    //     return view('fd_account.ddsaccounts.create', compact(
    //         'ddaccount',
    //         'members',
    //         'branches',
    //         'schemes',
    //         'minors',
    //         'savingAccounts'
    //     ));
    // }
    public function update(Request $request, string $id)
    {
        try {
            $account = DdsAccount::findOrFail($id);
            $validated = $request->validate([
                'member_id'             => 'required|exists:members,id',
                'member_name'           => 'required|string|max:255',
                'member_address'        => 'nullable|string|max:500',
                'member_mobile'         => 'nullable|string|max:15',
                'minor_id'              => 'nullable|exists:minors,id',
                'branch_id'             => 'required|exists:branches,id',
                'advisor_id'            => 'nullable|exists:staff,id',
                'collection_advisor_id' => 'nullable|exists:staff,id',
                'scheme_id'             => 'required|exists:schemes,id',
                'dd_amount'             => 'required|numeric|min:1',
                'open_date'             => 'required|date|before_or_equal:today',
                'tds_deduction'         => 'nullable|boolean',
                'account_type'          => ['required', Rule::in(['single', 'joint'])],
                'nominee'               => 'nullable|boolean',
                'pay_mode'              => 'required|string|in:cash,onlineTr,cheque,saving',
                'transaction_date'      => 'required|date',
                'amount'                => 'required|numeric|min:1',
                'transfer_date'         => 'nullable|date',
                'transfer_mode'         => 'nullable|string|max:50',
                'utr_no'                => 'nullable|string|max:100',
                'credited_in_company'   => 'nullable|boolean',
                'bank_id'               => 'nullable|exists:banks,id',
                'cheque_no'             => 'nullable|string|max:50',
                'cheque_date'           => 'nullable|date',
                'saving_account_id'     => [
                    'nullable',
                    Rule::requiredIf($request->pay_mode === 'saving'),
                    'exists:accounts,id'
                ],
            ]);

            $validated['tds_deduction']       = $request->has('tds_deduction');
            $validated['nominee']             = $request->has('nominee');
            $validated['credited_in_company'] = $request->has('credited_in_company');

            $account->update($validated);

            $transaction = $account->transactions()->first();
            if ($transaction) {
                $transaction->update([
                    'transaction_date' => $request->transaction_date,
                    'amount'           => $request->amount,
                    'pay_mode'         => $request->pay_mode,
                ]);
            }

            return redirect()->route('ddsaccounts.index')
                ->with('success', 'DDS Account updated successfully.');
        } catch (\Exception $e) {
            Log::error('DDS Account update failed: ' . $e->getMessage());
            return back()->withErrors('Something went wrong while updating the DDS account.')
                ->withInput();
        }
    }

    public function getMemberDetails($id)
    {
        $member = Member::with('branch')->findOrFail($id);

        return response()->json([
            'member_info_first_name' => $member->member_info_first_name,
            'member_info_last_name'  => $member->member_info_last_name,
            'member_address_line_1'  => $member->address->member_address_line_1 ?? '',
            'member_info_mobile_no'  => $member->member_info_mobile_no,
            'branch_id'   => $member->branch_id, // <-- हे पाठव
            'branch_name' => $member->branch->branch_name ?? '',
            'open_date'              => now()->format('Y-m-d'),
        ]);
    }

    public function updateMember(Request $request, DdsAccount $ddaccount)
    {
        $request->validate(['member_id' => 'required|exists:members,id']);
        $ddaccount->member_id = $request->member_id;
        $ddaccount->save();

        return back()->with('success', 'Member updated successfully');
    }

    public function updateBranch(Request $request, DdsAccount $ddaccount)
    {
        $request->validate(['branch_id' => 'required|exists:branches,id']);
        $ddaccount->branch_id = $request->branch_id;
        $ddaccount->save();

        return back()->with('success', 'Branch updated successfully');
    }

    function calculateDailyDeposit(

        $depositPerDay,

        $days,

        $rate,

        $bonusRate = 0,

        $fixedBonus = 0,

        $startDate = null

    ) {

        // --- Step 1: Total Deposit ---

        $totalDeposit = $depositPerDay * $days;

        // --- Step 2: Interest Calculation ---

        $interest = ($depositPerDay * $days * ($days + 1) * $rate) / (2 * 100 * 365);

        $interest = round($interest, 2);

        // --- Step 3: Bonus (applied only on maturity) ---

        $bonus = 0;

        if ($bonusRate > 0) {

            // percentage mode

            $bonus = ($totalDeposit * $bonusRate) / 100;
        } elseif ($fixedBonus > 0) {

            // fixed mode

            $bonus = $fixedBonus;
        }

        $bonus = round($bonus, 2);

        // --- Step 4: Maturity ---

        $maturity = $totalDeposit + $interest + $bonus;

        // --- Step 5: Maturity Date ---

        $maturityDate = null;

        if ($startDate) {
            $date = Carbon::parse($startDate)->addDays($days);
            $maturityDate = $date->format('d-m-Y');
        }

        return [

            'total_deposit'   => round($totalDeposit, 2),

            'interest_earned' => $interest,

            'bonus'           => $bonus,

            'maturity'        => round($maturity, 2),

            'maturity_date'   => $maturityDate,

        ];
    }
}
