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
use Illuminate\Support\Facades\DB;
use App\Models\Rdscheme;
use App\Models\SavingsAccount;
use Illuminate\Validation\ValidationException;

class RdAccountController extends Controller
{
    public function index()
    {

        $rdAccounts = RdAccount::with(['member', 'branch', 'minor'])
            ->latest()
            ->paginate(2);

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
        $schemes = Rdscheme::all();
        $accounts = Account::all();

        return view('mds_rd_accounts.mds-rd-account.create-rd-account', compact('members', 'schemes', 'accounts'));
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

    // public function store(Request $request)
    // {
    //     try {
    //         $rules = [
    //             'member_id' => 'required|exists:members,id',
    //             'minor_id' => 'nullable|exists:minors,id',
    //             'branch_id' => 'required|exists:branches,id',
    //             'advisor_staff' => 'nullable|string',
    //             'collection_advisor_staff' => 'nullable|string',
    //             'scheme' => [
    //                 'required',
    //                 'exists:rdschemes,id',
    //             ],
    //             'rd_amount' => 'required|numeric|min:1',
    //             'open_date' => 'required|date',
    //             'tds' => 'required|string|max:250',
    //             'accountType' => 'required|string|max:285',
    //             'nominee' => 'required|string|in:yes,no',
    //             'payment_mode' => 'required|in:cash,onlineTr,cheque,savingAcc',
    //             't_date' => 'required|date',

    //             // Online Transfer fields
    //             'transfer_date'   => 'nullable|required_if:payment_mode,onlineTr|date',
    //             'transaction_no'  => 'nullable|required_if:payment_mode,onlineTr|string|max:255',
    //             'transfer_mode'   => 'nullable|required_if:payment_mode,onlineTr|in:IMPS,VPA,NEFT/RTGS',
    //             'credited'        => 'nullable|required_if:payment_mode,onlineTr|in:yes,no',

    //             // Cheque fields
    //             'cheque_bank_name' => 'nullable|required_if:payment_mode,cheque|string|max:255',
    //             'cheque_no'        => 'nullable|required_if:payment_mode,cheque|string|max:50',
    //             'cheque_date'      => 'nullable|required_if:payment_mode,cheque|date',

    //             // Saving Account fields
    //             'savings_account'  => 'nullable|required_if:payment_mode,savingAcc|string|max:255',
    //         ];


    //         // Add nominee rules dynamically if 'yes'
    //         if ($request->nominee === 'yes') {
    //             $rules['nominees'] = 'required|array|min:1';
    //             $rules['nominees.*.name'] = 'required|string|max:258';
    //             $rules['nominees.*.relation'] = 'required|string|max:255';
    //             $rules['nominees.*.address'] = 'required|string|max:255';
    //         }

    //         $validated = $request->validate($rules);

    //         // Format open_date
    //         $validated['open_date'] = Carbon::parse($validated['open_date'])->format('Y-m-d');


    //         // Format t_date
    //         if (!empty($validated['t_date'])) {
    //             $validated['t_date'] = Carbon::parse($validated['t_date'])->format('Y-m-d');
    //         }

    //         // Format cheque_date if payment_mode is cheque
    //         if (!empty($validated['cheque_date'])) {
    //             $validated['cheque_date'] = Carbon::parse($validated['cheque_date'])->format('Y-m-d');
    //         }

    //         if (!empty($validated['transfer_date'])) {
    //             $validated['transfer_date'] = Carbon::parse($validated['transfer_date'])->format('Y-m-d');
    //         }


    //         $scheme = Rdscheme::findOrFail($request->scheme);

    //         $summary = $this->calculateRDAccount(
    //             $request->rd_amount,             // from form
    //             $scheme->tenure_of_rd_dd_value,          // e.g., 24
    //             $scheme->tenure_of_rd_dd_type,           // months/days/weeks
    //             $scheme->anuual_interest_rate,           // base annual rate
    //             $scheme->sr_citizen_add_on_interest_rate ?? 0, // optional add-on
    //             $request->open_date                       // account opening date
    //         );

    //         // Save RD Account
    //         $rdAccount = RdAccount::create([
    //             'member_id'   => $validated['member_id'],
    //             'minor_id'    => $validated['minor_id'] ?? null,
    //             'branch_id'   => $validated['branch_id'],
    //             'advisor_staff' => $validated['advisor_staff'] ?? null,
    //             'collection_advisor_staff' => $validated['collection_advisor_staff'] ?? null,
    //             'scheme'      => $validated['scheme'],
    //             'rd_amount'   => $validated['rd_amount'],
    //             'open_date'   => $validated['open_date'],
    //             'tds'         => $validated['tds'],
    //             'account_type' => $validated['accountType'],
    //             'payment_mode' => $validated['payment_mode'],

    //             'maturity_date'  => $summary['maturity_date'],
    //             'maturity_value' => $summary['maturity_value'],
    //             'total_deposit'  => $summary['total_deposit'],
    //             'interest'       => $summary['interest'],
    //         ]);

    //             dd($rdAccount);

    //         // Save nominees if provided
    //         if ($validated['nominee'] === 'yes' && isset($validated['nominees'])) {
    //             foreach ($validated['nominees'] as $nominee) {
    //                 AccountNominee::create([
    //                     'rd_account_id'    => $rdAccount->id,
    //                     'nominee_name'     => $nominee['name'],
    //                     'nominee_relation' => $nominee['relation'],
    //                     'nominee_address'  => $nominee['address'],

    //                 ]);
    //             }
    //         }

    //         // Prepare transaction fields
    //         $transactionData = [
    //             'rd_account_id'    => $rdAccount->id,
    //             'payment_mode'     => $validated['payment_mode'],
    //             't_date'           => $validated['t_date'],
    //             'amount'           => $validated['rd_amount'],
    //             'transaction_type' => 'credit',
    //             'approve_status'   => 'pending',
    //             'created_at'       => now(),
    //             'updated_at'       => now(),
    //         ];



    //         switch ($validated['payment_mode']) {

    //             case 'cash':
    //                 // Nothing extra
    //                 break;

    //             case 'onlineTr':
    //                 $transactionData['transfer_date']  = $validated['transfer_date'] ?? null;
    //                 $transactionData['transaction_no'] = $validated['transaction_no'] ?? null;
    //                 $transactionData['transfer_mode']  = $validated['transfer_mode'] ?? null;
    //                 $transactionData['credited']       = $validated['credited'] ?? null;
    //                 break;

    //             case 'cheque':
    //                 $transactionData['cheque_bank_name'] = $validated['cheque_bank_name'] ?? null;
    //                 $transactionData['cheque_no']        = $validated['cheque_no'] ?? null;
    //                 $transactionData['cheque_date']      = $validated['cheque_date'] ?? null;
    //                 break;

    //             case 'savingAcc':
    //                 $transactionData['savings_account'] = $validated['savings_account'] ?? null;
    //                 break;


    //             default:
    //                 Log::error('Unknown payment_mode detected: ' . $validated['payment_mode']);
    //         }

    //         // Insert into rd_transactions table
    //         DB::table('rd_transactions')->insert($transactionData);

    //         return redirect()
    //             ->route('mds-rd-accounts.rd-account-index')
    //             ->with('success', 'RD Account created successfully!');
    //     } catch (\Exception $e) {
    //         // Log full error details
    //         Log::error('RD Account Store Error:', [
    //             'message' => $e->getMessage(),
    //             'file'    => $e->getFile(),
    //             'line'    => $e->getLine(),
    //             'trace'   => $e->getTraceAsString(),
    //         ]);

    //         return back()->withErrors('Something went wrong! Check logs for details.');
    //     }
    // }

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
                'open_date' => 'required|date',
                'tds' => 'required|string|max:250',
                'accountType' => 'required|string|max:285',
                'nominee' => 'required|string|in:yes,no',
                'payment_mode' => 'required|in:cash,onlineTr,cheque,savingAcc',
                't_date' => 'required|date',

                // Online Transfer fields
                'transfer_date'   => 'nullable|required_if:payment_mode,onlineTr|date',
                'transaction_no'  => 'nullable|required_if:payment_mode,onlineTr|string|max:255',
                'transfer_mode'   => 'nullable|required_if:payment_mode,onlineTr|in:IMPS,VPA,NEFT/RTGS',
                'credited'        => 'nullable|required_if:payment_mode,onlineTr|in:yes,no',

                // Cheque fields
                'cheque_bank_name' => 'nullable|required_if:payment_mode,cheque|string|max:255',
                'cheque_no'        => 'nullable|required_if:payment_mode,cheque|string|max:50',
                'cheque_date'      => 'nullable|required_if:payment_mode,cheque|date',

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

            $validated['open_date'] = Carbon::parse($validated['open_date'])->format('Y-m-d');

            if (!empty($validated['t_date'])) {
                $validated['t_date'] = Carbon::parse($validated['t_date'])->format('Y-m-d');
            }
            if (!empty($validated['cheque_date'])) {
                $validated['cheque_date'] = Carbon::parse($validated['cheque_date'])->format('Y-m-d');
            }
            if (!empty($validated['transfer_date'])) {
                $validated['transfer_date'] = Carbon::parse($validated['transfer_date'])->format('Y-m-d');
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

    public function show()
    {
        return view('mds-rd-accounts.mds-rd-account.view-rd-account');
    }
}
