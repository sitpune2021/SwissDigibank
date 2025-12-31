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
use App\Models\Comments;
use App\Models\Document;
use App\Models\Minor;
use App\Models\Passbook;
use App\Models\RdTransactions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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

        return view('mds_rd_accounts.mds-rd-account.create-rd-account', compact('members', 'schemes', 'accounts', 'banks', 'selectedBankId'));
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
                'scheme_id' => [
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

            $scheme = Rdscheme::findOrFail($request->scheme_id);
            Log::info('RD Scheme Data', $scheme->toArray());
            if ($request->rd_amount < $scheme->min_rd_dd_amount) {
                return back()
                    ->withErrors(['rd_amount' => "RD amount must be at least ₹ {$scheme->min_rd_dd_amount}."])
                    ->withInput();
            }

            $summary = $this->calculateRdEstimate(
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
                'scheme_id'      => $validated['scheme_id'],
                'rd_amount'   => $validated['rd_amount'],
                'open_date'   => $validated['open_date'],
                'tds'         => $validated['tds'],
                'account_type' => $validated['accountType'],
                'payment_mode' => $validated['payment_mode'],

                'maturity_date'  => $summary['maturity_date'],
                'maturity_amount' => $summary['maturity_amount'],
                'principal'      => $validated['rd_amount'],
                'total_interest' => $summary['total_interest'],
            ]);

            $rdAccount->rd_no = 'RD' . str_pad($rdAccount->id, 10, '0', STR_PAD_LEFT);
            $rdAccount->save();

            Log::info('RD Account Created', $rdAccount->toArray());

            try {
                $rdaccount = \App\Models\RdAccount::with('member')->find($rdAccount->id);
                $mobile = $rdaccount->member->member_info_mobile_no;
                $dlttemplateid = 1707172234132264486;

                $message = "Dear Customer, we have received your request for opening RD. Your temp. RD no. is  $rdaccount->rd_no. SBC GLOBAL";
                \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            } catch (\Exception $e) {
                Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
            }

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
                'installment_no'   => 1,
                'due_date'         => $validated['open_date'],
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


    private function calculateRdEstimate(
        $monthlyInstallment,
        $tenureValue,
        $tenureType,
        $annualRate,
        $srCitizenRate = 0,
        $openDate = null,
        $bonusRate = 0  // NEW: separate bonus %
    ) {
        $effectiveRate = $annualRate + $srCitizenRate; // interest only

        $tenureType  = strtoupper(trim($tenureType));
        $tenureValue = (int) $tenureValue;

        if (in_array($tenureType, ['YEAR', 'YEARS'])) {
            $tenureMonths = $tenureValue * 12;
        } elseif (in_array($tenureType, ['MONTH', 'MONTHS'])) {
            $tenureMonths = $tenureValue;
        } else {
            throw new \InvalidArgumentException("Invalid tenure type '{$tenureType}'. Only MONTHS or YEARS are supported.");
        }

        if ($tenureMonths <= 0) {
            throw new \InvalidArgumentException("Tenure value must be greater than zero.");
        }

        $principal = $monthlyInstallment * $tenureMonths;

        // RD compound formula (monthly compounding)
        $r = $effectiveRate / 100; // annual rate in decimal
        $m = 12;                   // compounding per year (monthly)
        $n = $tenureMonths;        // months

        $maturityWithoutBonus = $monthlyInstallment
            * ((pow(1 + $r / $m, $n) - 1) / (1 - pow(1 + $r / $m, -1)));

        $interest = $maturityWithoutBonus - $principal;

        // bonus as flat % of principal
        $bonusAmount = $bonusRate > 0 ? ($principal * $bonusRate / 100) : 0;

        $maturityAmount = $maturityWithoutBonus + $bonusAmount;

        $startDate    = $openDate ? Carbon::parse($openDate) : Carbon::now();
        $maturityDate = $startDate->copy()->addMonths($tenureMonths)->format('Y-m-d');

        return [
            'principal'       => round($principal, 2),
            'total_interest'  => round($interest, 2),
            'bonus_amount'    => round($bonusAmount, 2),
            'maturity_amount' => round($maturityAmount, 2),
            'maturity_date'   => $maturityDate,
            'tenure_months'   => $tenureMonths,
        ];
    }


    private function computeRdMaturity($rdAccount, $scheme): array
    {
        try {

            // START DATE
            $startDate = Carbon::parse($rdAccount->open_date)->startOfDay();

            // ------------------------------------------
            // 1) TENURE  → convert to months
            // ------------------------------------------
            $tenureValue = (int)($scheme->tenure_of_rd_dd_value ?? 0);
            $tenureType  = strtoupper(trim($scheme->tenure_of_rd_dd_type ?? 'MONTHS'));

            if (in_array($tenureType, ['YEAR', 'YEARS'])) {
                $months = $tenureValue * 12;
            } elseif (in_array($tenureType, ['MONTH', 'MONTHS'])) {
                $months = $tenureValue;
            } else {
                throw new \Exception("Invalid tenure type: {$tenureType}");
            }

            // ------------------------------------------
            // 2) MATURITY DATE
            // ------------------------------------------
            $maturityDate = $startDate->copy()->addMonthsNoOverflow($months);

            // ------------------------------------------
            // 3) AMOUNTS / INTEREST RATE
            // ------------------------------------------
            $P = (float)$rdAccount->rd_amount;             // monthly installment
            $annualRate = (float)$scheme->anuual_interest_rate;
            $r = $annualRate / 100;                        // convert to decimal

            // ------------------------------------------
            // 4) COMPOUNDING FREQUENCY
            // ------------------------------------------
            $comp = strtoupper(trim($scheme->interest_compounding_interval ?? 'MONTHLY'));

            $m = match ($comp) {
                'MONTHLY'     => 12,
                'QUARTERLY'   => 4,
                'HALFYEARLY', 'HALF-YEARLY', 'SEMIANNUAL', 'SEMI-ANNUAL' => 2,
                'YEARLY', 'ANNUALLY' => 1,
                default       => 12,
            };

            // Convert compounding rate to effective monthly rate
            $monthlyRate = pow(1 + $r / $m, $m / 12) - 1;

            // ------------------------------------------
            // 5) PRINCIPAL
            // ------------------------------------------
            $principal = $P * $months;

            // ------------------------------------------
            // 6) SIMULATE RD MONTH BY MONTH
            // ------------------------------------------
            $balance = 0;
            $accInterest = 0;
            $creditInterval = (int)(12 / $m);  // e.g. quarterly=3 months

            for ($month = 1; $month <= $months; $month++) {

                // Deposit this month
                $balance += $P;

                // Interest on current balance
                $accInterest += $balance * $monthlyRate;

                // Credit interest when compounding interval reached
                if ($month % $creditInterval === 0) {
                    $balance += $accInterest;
                    $accInterest = 0;
                }
            }

            // Add leftover interest
            $balance += $accInterest;

            $maturity = $balance;
            $interestEarned = $maturity - $principal;

            // ------------------------------------------
            // 7) BONUS (BANK STYLE = % OF PRINCIPAL ONLY)
            // ------------------------------------------
            $bonusType = strtolower($scheme->bonus_rate_type ?? '');
            $bonusVal  = (float)($scheme->bonus_rate_value ?? 0);

            $bonus = in_array($bonusType, ['percent', 'percentage', '%'])
                ? $principal * ($bonusVal / 100)
                : $bonusVal;

            $finalMaturity = $maturity + $bonus;

            // ------------------------------------------
            // 8) RETURN VALUES
            // ------------------------------------------
            $computed = [
                'maturity_date'   => $maturityDate->format('Y-m-d'),
                'principal'       => round($principal, 2),
                'total_interest'  => round($interestEarned, 2),
                'bonus'           => round($bonus, 2),
                'maturity_amount' => round($finalMaturity, 2),
                'effective_monthly_rate_pct' => round($monthlyRate * 100, 6),
                'compounding_per_year'       => $m,
                'tenure_months'              => $months,
                'annual_rate_pct'            => $annualRate,
            ];

            // Update DB fields
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



    public function show($id)
    {
        $rdAccount = RdAccount::with(['Scheme', 'member.address', 'branch', 'minor', 'nominee', 'rdTransactions' => function ($q) {
            $q->whereIn('approve_status', ['Pending', 'Approved'])
                ->orderBy('t_date', 'desc')
                ->limit(5);
        }])->findOrFail($id);
        $branches = Branch::all();
        $scheme = $rdAccount->scheme;
        $receivedAmount = RdTransactions::where('rd_account_id', $id)
            ->where('transaction_type', 'credit')
            ->where('approve_status', 'approved')
            ->sum('amount');
        $passbooks = Passbook::where('account_type', 'RD Accounts')
            ->where('account_no', $rdAccount->id)
            ->get();
        $balances = self::getAccountBalance($rdAccount->id);
        $balance  = $balances[$rdAccount->id] ?? 0;
        $documents = Document::where('rd_id', $rdAccount->id)->get();

        $calc = $this->computeRdMaturity($rdAccount, $scheme);

        return view('mds_rd_accounts.mds-rd-account.view.view-rd-account', compact('rdAccount', 'documents', 'passbooks', 'balance', 'branches', 'calc', 'receivedAmount'));
    }


    private function processRDInstallments($rdAccount, $scheme, $transactions = null)
    {
        $installment = (float) $rdAccount->rd_amount;
        $months      = (int) $scheme->tenure_of_rd_dd_value;
        $rate        = (float) $scheme->anuual_interest_rate;
        $srRate      = (float) ($rdAccount->sr_citizen_rate ?? 0);

        $rate += $srRate;

        $openDate = Carbon::parse($rdAccount->open_date);
        $results = [];
        $totalPrincipal = 0;
        $totalInterest  = 0;

        // Build txnMap → key = installment_no
        $txnMap = [];
        if (!empty($transactions)) {
            foreach ($transactions as $txn) {
                if (!empty($txn->installment_no)) {
                    $txnMap[$txn->installment_no] = $txn;
                }
            }
        }

        Log::info("RD Installment Processing Start", [
            'account_id' => $rdAccount->id,
            'months' => $months,
            'transaction_map_keys' => array_keys($txnMap)
        ]);

        for ($i = 1; $i <= $months; $i++) {

            $dueDate = $openDate->copy()->addMonthsNoOverflow($i - 1);

            $monthsRemaining = $months - $i + 1;
            $interest = ($installment * $monthsRemaining * $rate) / 1200;
            $interest = round($interest, 2);

            $totalPrincipal += $installment;
            $totalInterest  += $interest;

            $row = [
                'id'               => $i,
                'installment_no'   => $i,
                'amount'           => $installment,
                'due_date'         => $dueDate->format('Y-m-d'),
                'display_due_date' => $dueDate->format('d M Y'),
                'approve_status'   => 'Pending',
                'paid_on'          => null,
                'print_flag'       => false,
            ];

            // Apply transaction status
            if (isset($txnMap[$i])) {
                $txn = $txnMap[$i];

                $row['approve_status'] = 'approved';
                $row['paid_on']        = Carbon::parse($txn->paid_on)->format('d M Y');
                $row['print_flag']     = true;

                Log::info("Installment marked approved", [
                    'installment_no' => $i,
                    'txn_id' => $txn->id,
                    'paid_on' => $row['paid_on']
                ]);
            }

            $results[] = $row;
        }

        return $results;
    }

    public function installmentPlan($id)
    {
        $rdAccount = RdAccount::with('scheme')->findOrFail($id);

        if (!$rdAccount->Scheme) {
            return back()->with('error', 'RD Scheme not found');
        }

        // Get all transactions WITH installment_no for mapping
        $transactions = RdTransactions::where('rd_account_id', $id)->get();

        Log::info("Fetched RD transactions", [
            'account_id' => $id,
            'transaction_count' => $transactions->count()
        ]);

        $installments = $this->processRDInstallments($rdAccount, $rdAccount->scheme, $transactions);

        return view(
            'mds_rd_accounts.mds-rd-account.view.installment-plan',
            compact('rdAccount', 'installments')
        );
    }

    public function processInstallment(Request $request, $id)
    {

        $validated = $request->validate([
            'rd_account_id'  => 'required|exists:rd_accounts,id',
            'installment_no' => 'required|integer|min:1',
            'amount'         => 'required|numeric|min:0',
            'due_date'       => 'required|date',
        ]);

        try {

            $response = DB::transaction(function () use ($validated) {

                Log::info("RD Installment Processing Start", [
                    'account_id'      => $validated['rd_account_id'],
                    'installment_no'  => $validated['installment_no'],
                    'amount'          => $validated['amount'],
                ]);

                $saved = RdTransactions::create([
                    'rd_account_id'    => $validated['rd_account_id'],
                    'installment_no'   => $validated['installment_no'],
                    'amount'           => $validated['amount'],
                    'due_date'         => Carbon::parse($validated['due_date'])->format('Y-m-d'),
                    'approve_status'   => 'approved',
                    'transaction_type' => 'credit',
                    'remark'           => $validated['remark'] ?? null,
                    'paid_on'          => now(),
                    'print_flag'       => 1,
                    't_date'          => now(),
                ]);

                Log::info("Installment Saved", [
                    'txn_id'         => $saved->id,
                    'installment_no' => $validated['installment_no'],
                    'paid_on'        => now()->format('d M Y')
                ]);

                return [
                    'success'     => true,
                    'paid_on'     => now()->format('d M Y'),
                    'print_flag'  => true,
                ];
            });

            return response()->json($response);
        } catch (\Throwable $th) {
            Log::error("RD Installment Processing Failed", [
                'error' => $th->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save installment: ' . $th->getMessage(),
            ], 500);
        }
    }

    public static function getAccountBalance($rd_account_ids)
    {
        if (! is_array($rd_account_ids)) {
            $rd_account_ids = [$rd_account_ids];
        }

        $transactions = RdTransactions::whereIn('rd_account_id', $rd_account_ids)
            ->where('approve_status', 'approved')
            ->get();

        $balances = [];

        foreach ($transactions->groupBy('rd_account_id') as $rd_account_id => $group) {
            $credit                   = $group->where('transaction_type', 'credit')->sum('amount');
            $debit                    = $group->where('transaction_type', 'debit')->sum('amount');
            $balances[$rd_account_id] = $credit - $debit;
        }

        return $balances;
    }

    //     public static function getAccountBalance($rd_account_ids)
    // {
    //     if (!is_array($rd_account_ids)) {
    //         $rd_account_ids = [$rd_account_ids];
    //     }

    //     $transactions = RdTransactions::whereIn('rd_account_id', $rd_account_ids)
    //         ->where('approve_status', 'approved')
    //         ->where('reverse_status', 0)
    //         ->get();

    //     $balances = [];

    //     foreach ($transactions->groupBy('rd_account_id') as $rd_account_id => $group) {

    //         $credit = $group->where('transaction_type', 'credit')->sum(function ($t) {
    //             return $t->amount_received ?? $t->amount;
    //         });

    //         $debit = $group->where('transaction_type', 'debit')->sum(function ($t) {
    //             return $t->amount_received ?? $t->amount;
    //         });

    //         $balances[$rd_account_id] = $credit - $debit;
    //     }

    //     return $balances;
    // }



    public function installmentReceipt($id)
    {
        $rdaccount = RdTransactions::with([
            'rdaccount.member'
        ])->findOrFail($id);


        function numberToWords($number)
        {
            $hyphen      = '-';
            $dictionary  = [
                0 => 'zero',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 => 'nineteen',
                20 => 'twenty',
                30 => 'thirty',
                40 => 'forty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety',
                100 => 'hundred',
                1000 => 'thousand'
            ];

            if ($number < 21) return $dictionary[$number];
            elseif ($number < 100) {
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                return $dictionary[$tens] . ($units ? $hyphen . $dictionary[$units] : '');
            } elseif ($number < 1000) {
                $hundreds = (int)($number / 100);
                $remainder = $number % 100;
                return $dictionary[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
            }
            return $number;
        }

        $wordAmt = ucfirst(numberToWords((int)$rdaccount->rd_amount)) . ' Only';

        $txn = $rdaccount->transactions->sortByDesc('id')->first();
        $pay_mode = $txn->pay_mode ?? 'Cash';

        $dueDate = Carbon::parse($rdaccount->open_date)->format('d-m-Y');

        if ($txn) {
            $nextinsdue = Carbon::parse($txn->transaction_date)->addDay()->format('d-m-Y');
        } else {
            $nextinsdue = Carbon::parse($rdaccount->open_date)->addDay()->format('d-m-Y');
        }

        $depositAmountPerModeValue = $txn->amount
            ?? $txn->deposit_amount
            ?? $txn->installment_amount
            ?? $rdaccount->rd_amount
            ?? 0;

        $DepositAmountperMode = number_format($depositAmountPerModeValue, 2);

        $installmentNo = $rdaccount->transactions->count() + 1;
        $otherCharges = 0;
        $previousBalance = $txn->balance_available
            ?? $rdaccount->balance
            ?? 0;

        $previousBalanceFormatted = number_format($previousBalance, 2);
        $previousBalance = $txn->balance_available ?? $rdaccount->balance ?? 0;

        $currentInstallment = $depositAmountPerModeValue;

        $total = $previousBalance + $currentInstallment;

        $totalFormatted = number_format($total, 2);
        $data = [
            'name'               => trim(
                ($rdaccount->member->member_info_title ?? '') . ' ' .
                    ($rdaccount->member->member_info_first_name ?? '') . ' ' .
                    ($rdaccount->member->member_info_middle_name ?? '') . ' ' .
                    ($rdaccount->member->member_info_last_name ?? '')
            ),
            'state'              => $rdaccount->member->member_address_state ?? '',
            'branch'             => $rdaccount->branch->name ?? 'Main Branch',
            'receipt_no'         => 'DDS' . str_pad($rdaccount->id, 6, '0', STR_PAD_LEFT),
            'receiptno'          => 'DDS' . str_pad($rdaccount->id, 6, '0', STR_PAD_LEFT),
            'dated'              => Carbon::now()->format('d-m-Y'),
            'member_no'          => $rdaccount->member_id,
            'rd_no'              => $rdaccount->rd_no,
            'installment_amount' => number_format($rdaccount->rd_amount, 2),
            'total_installments' => $rdaccount->total_installments,
            'installmentNo'      => $installmentNo,      // 👈 ADDED HERE
            'open_date'          => Carbon::parse($rdaccount->open_date)->format('d-m-Y'),
            'maturity_date'      => Carbon::parse($rdaccount->maturity_date)->format('d-m-Y'),
            'maturity_amount'    => number_format($rdaccount->maturity_amount, 2),
            'status'             => $rdaccount->status ? 'Active' : 'Pending',
            'wordAmt'            => $wordAmt,
            'pay_mode'           => $pay_mode,
            'DepositAmountperMode' => $DepositAmountperMode,
            'dueDate'            => $dueDate,
            'depositAmount'         => $DepositAmountperMode,
            'otherCharges'          => $otherCharges,
            'previousBalance' => $previousBalanceFormatted,
            'total' => $totalFormatted,
            'nextinsdue'         => $nextinsdue,
        ];

        $pdf = Pdf::loadView('mds_rd_accounts.mds-rd-account.view.print-installments', $data);;
        return $pdf->stream('installment-receipt.pdf');
    }
    public function instalmlmentReceipt($id)
    {

        $transaction = RdTransactions::with([
            'rdaccount.member'
        ])->findOrFail($id);

        $accountId = $transaction->rd_account_id;
        //  dd($accountId );
        $balances = self::getAccountBalance($accountId);
        $balance  = $balances[$accountId] ?? 0;



        $printedOn = now()->format('d-m-Y h:i A');
        $printedBy = Auth::user()->name ?? 'System';

        $data = [
            'transaction' => $transaction,
            'balance'     => $balance,
            'printedOn'   => $printedOn,
            'printedBy'   => $printedBy,
        ];

        // Load PDF
        $pdf = app('dompdf.wrapper')
            ->loadView('mds_rd_accounts.mds-rd-account.view.print-installments', $data)
            ->setPaper([0, 0, 226.77, 800], 'portrait');

        return $pdf->stream('payment-receipt-' . $id . '.pdf');
    }


    public function showDepositForm($id)
    {
        $rdAccount = RdAccount::with('member', 'scheme', 'rdTransactions')->findOrFail($id);

        $receivedAmount = RdTransactions::where('rd_account_id', $id)
            ->whereNotNull('installment_no')
            ->where('transaction_type', 'credit')
            ->where('approve_status', 'approved')
            ->sum('amount');

        $balances = self::getAccountBalance($rdAccount->id);
        $balance  = $balances[$rdAccount->id] ?? 0;

        return view('mds_rd_accounts.mds-rd-account.view.deposit-money', compact('rdAccount', 'balance', 'receivedAmount'));
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


            $rdAccount = RdAccount::with('scheme')->findOrFail($rdAccountId);
            $fixedAmount = $rdAccount->rd_amount;
            $depositAmount = $validated['amount'];
            $transactionDate = Carbon::parse($validated['t_date'])->format('Y-m-d');


            if (!$fixedAmount || $fixedAmount <= 0) {
                return back()
                    ->withErrors(['amount' => "Invalid scheme amount. Please check scheme setup."])
                    ->withInput();
            }

            if ($depositAmount % $fixedAmount !== 0) {
                return back()
                    ->withErrors(['amount' => "Deposit amount must be the scheme amount (₹$fixedAmount) or a multiple of it."])
                    ->withInput();
            }


            $installmentsToCreate = $depositAmount / $fixedAmount;


            $totalInstallments = $rdAccount->scheme->tenure_of_rd_dd_value ?? null;  // 🔁 adjust field name if needed

            if (!$totalInstallments || $totalInstallments <= 0) {
                return back()
                    ->withErrors(['amount' => "Invalid scheme tenure. Please check scheme configuration."])
                    ->withInput();
            }


            $alreadyCreated = RdTransactions::where('rd_account_id', $rdAccount->id)->count();

            $remainingInstallments = $totalInstallments - $alreadyCreated;

            if ($remainingInstallments <= 0) {
                return back()
                    ->withErrors(['amount' => "All installments for this RD account are already paid. No further deposit allowed."])
                    ->withInput();
            }


            if ($installmentsToCreate > $remainingInstallments) {
                $maxAllowedAmount = $remainingInstallments * $fixedAmount;
                return back()
                    ->withErrors(['amount' => "You can only pay $remainingInstallments installment(s). Maximum deposit allowed is ₹$maxAllowedAmount."])
                    ->withInput();
            }

            $lastInstallmentNo = RdTransactions::where('rd_account_id', $rdAccount->id)
                ->max('installment_no');

            $nextInstallmentNo = $lastInstallmentNo ? $lastInstallmentNo + 1 : 1;

            for ($i = 0; $i < $installmentsToCreate; $i++) {
                $installmentNo = $nextInstallmentNo + $i;

                $installmentRequest = new Request([
                    'rd_account_id'  => $rdAccount->id,
                    'installment_no' => $installmentNo,
                    'amount'         => $fixedAmount,
                    't_date'       => $transactionDate,
                    'due_date'       => Carbon::parse($rdAccount->open_date)
                        ->addMonthsNoOverflow($installmentNo - 1)
                        ->format('Y-m-d'),
                    'remark' => $validated['remark'] ?? null,
                    'transfer_date'    => $validated['transfer_date'] ?? null,
                    'transaction_no'   => $validated['utr_no'] ?? null,
                    'transfer_mode'    => $validated['transfer_mode'] ?? null,

                    'cheque_bank_name' => $validated['cheque_bank_name'] ?? null,
                    'cheque_no'        => $validated['cheque_no'] ?? null,
                    'cheque_date'      => $validated['cheque_date'] ?? null,

                    'saving_account_id' => $validated['saving_account_id'] ?? null,
                ]);

                $this->processInstallment($installmentRequest, $rdAccount->id);
            }

            return redirect()
                ->route('rd-accounts.show', $rdAccount->id)
                ->with('success', 'Deposit submitted — installments created successfully!');
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


    public function showWithdrawForm($id)
    {
        $rdAccount = RdAccount::with('member', 'scheme', 'rdTransactions')->findOrFail($id);

        $receivedAmount = RdTransactions::where('rd_account_id', $id)
            ->whereNotNull('installment_no')
            ->where('transaction_type', 'credit')
            ->where('approve_status', 'approved')
            ->sum('amount');

        $balances = self::getAccountBalance($rdAccount->id);
        $balance  = $balances[$rdAccount->id] ?? 0;
        // $totalWithdrawn = $rdAccount->rdTransactions()->where('transaction_type', 'debit')->sum('amount');

        return view('mds_rd_accounts.mds-rd-account.view.withdraw-money', compact('rdAccount', 'receivedAmount'));
    }

    public function storeWithdraw(Request $request, $rdAccountId)
    {
        try {
            Log::info("RD Withdraw Request received", $request->all());

            $validated = $request->validate([
                'amount'            => 'required|numeric|min:1',
                't_date'            => 'required|date',
                'payment_mode'      => 'required|in:cash,onlineTr,cheque,savingAcc',
                'remark'           => 'nullable|string|max:255',
                'transfer_date'     => 'nullable|required_if:payment_mode,onlineTr|date',
                'utr_no'            => 'nullable|required_if:payment_mode,onlineTr|string|max:255',
                'transfer_mode'     => 'nullable|required_if:payment_mode,onlineTr|in:IMPS,VPA,NEFT/RTGS',
                'cheque_bank_name'  => 'nullable|required_if:payment_mode,cheque|integer',
                'cheque_no'         => 'nullable|required_if:payment_mode,cheque|string|max:50',
                'cheque_date'       => 'nullable|required_if:payment_mode,cheque|date',
                'saving_account_id' => 'nullable|required_if:payment_mode,savingAcc|integer',
            ]);

            Log::info("RD Withdraw Validation passed", $validated);

            $rdAccount = RdAccount::with('scheme')->findOrFail($rdAccountId);
            $withdrawAmount = $validated['amount'];
            $transactionDate = Carbon::parse($validated['t_date'])->format('Y-m-d');
            $balances = self::getAccountBalance($rdAccount->id);
            $balance  = $balances[$rdAccount->id] ?? 0;

            if ($withdrawAmount > $balance) {
                return back()
                    ->withErrors(['amount' => "Insufficient balance for this withdrawal. Current balance is ₹$balance."])
                    ->withInput();
            }

            $transferDate = isset($validated['transfer_date'])
                ? Carbon::createFromFormat('d-m-Y', $validated['transfer_date'])->format('Y-m-d')
                : null;

            $chequeDate = isset($validated['cheque_date'])
                ? Carbon::createFromFormat('d-m-Y', $validated['cheque_date'])->format('Y-m-d')
                : null;


            // Create withdrawal transaction
            RdTransactions::create([
                'rd_account_id'    => $rdAccount->id,
                'amount'           => $withdrawAmount,
                't_date'           => $transactionDate,
                'approve_status'   => 'Pending',
                'transaction_type' => 'debit',
                'payment_mode'     => $validated['payment_mode'],
                'remark'           => $validated['remark'] ?? null,

                'transfer_date'    => $transferDate,
                'transaction_no'   => $validated['utr_no'] ?? null,
                'transfer_mode'    => $validated['transfer_mode'] ?? null,

                'cheque_bank_name' => $validated['bank_id'] ?? null,
                'cheque_no'        => $validated['cheque_no'] ?? null,
                'cheque_date'      => $chequeDate,

                'saving_account_id' => $validated['saving_account_id'] ?? null,
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
        $transaction = RdTransactions::with(['rdAccount.member', 'rdAccount.scheme', 'rdAccount.branch'])
            ->findOrFail($transactionId);

        $rdAccount = $transaction->rdAccount;



        return view('mds_rd_accounts.mds-rd-account.view.view-transaction.view-transaction', compact('transaction', 'rdAccount'));
    }

    public function showChangeInfoForm($id)
    {
        $rdAccount = RdAccount::with(['member', 'scheme', 'minor'])->findOrFail($id);
        $schemes = RdScheme::all();
        $balances = self::getAccountBalance($rdAccount->id);
        $balance  = $balances[$rdAccount->id] ?? 0;
        $selectedMember = Member::find($rdAccount->member_id);
        $otherMembers = Member::where('id', '!=', $rdAccount->member_id)->get();
        $members = collect([$selectedMember])->merge($otherMembers);

        // $members = Member::where('id', '!=', $rdAccount->member_id)->get();
        return view('mds_rd_accounts.mds-rd-account.view.account-detail.change-account-info', compact('rdAccount', 'schemes', 'members', 'balance'));
    }

    public function updateAccountInfo(Request $request, $id)
    {
        $request->validate([
            'scheme' => 'required|exists:rdschemes,id',
            'account_type' => 'required|in:single,joint',
            'rd_amount'  => 'required|numeric|min:1',
            'open_date' => 'required|date',
            'joint_member_id' => 'nullable|exists:members,id',

        ]);

        $rdAccount = RdAccount::findOrFail($id);

        DB::beginTransaction();

        try {

            Log::info('RD Account Info Update Started', [
                'rd_account_id' => $rdAccount->id,
                'request_data'   => $request->all(),
                'old_values'     => [
                    'scheme' => $rdAccount->scheme_id,
                    'rd_amount' => $rdAccount->rd_amount,
                    'open_date' => $rdAccount->open_date,
                    'account_type' => $rdAccount->account_type
                ]
            ]);

            $rdAccount->scheme_id = $request->scheme;
            $rdAccount->rd_amount = $request->rd_amount;
            $rdAccount->open_date = Carbon::createFromFormat('d-m-Y', $request->open_date)->format('Y-m-d');
            $rdAccount->joint_member_id = $request->joint_member_id;
            $rdAccount->account_type = $request->account_type;
            $rdAccount->save();






            DB::commit();

            Log::info('RD Account Info Updated Successfully', [
                'rd_account_id' => $rdAccount->id,
                'new_values'     => [
                    'scheme' => $rdAccount->scheme_id,
                    'rd_amount' => $rdAccount->rd_amount,
                    'open_date' => $rdAccount->open_date,
                    'account_type' => $rdAccount->account_type
                ]
            ]);

            return redirect()
                ->route('rd-accounts.show', $rdAccount->id)
                ->with('success', 'Account Information Updated Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('RD Account Info Update Failed', [
                'rd_account_id' => $rdAccount->id,
                'error_message'  => $e->getMessage(),
                'line'           => $e->getLine(),
                'file'           => $e->getFile(),
            ]);

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    // Show Add Nominee Form
    // public function showAddNomineeForm($id)
    // {
    //     $rdAccount = RdAccount::with(['member', 'scheme', 'minor', 'nominee'])
    //         ->findOrFail($id);

    //     return view('mds_rd_accounts.mds-rd-account.view.account-detail.add-nominee', compact('rdAccount'));
    // }

    // public function saveNominee(Request $request, $id)
    // {
    //     try {
    //         $rdAccount = RdAccount::with('nominee')->findOrFail($id);

    //         $request->validate([
    //             'nominees'            => 'required|array|min:1',
    //             'nominees.*.name'     => 'required|string|max:255',
    //             'nominees.*.relation' => 'required|string|max:255',
    //             'nominees.*.address'  => 'required|string|max:255',
    //         ]);

    //         $existingNominees = $rdAccount->nominee;

    //         foreach ($request->nominees as $index => $nomineeData) {
    //             // If nominee exists at this index → update
    //             if (isset($existingNominees[$index])) {
    //                 $existingNominees[$index]->update([
    //                     'nominee_name'     => $nomineeData['name'],
    //                     'nominee_relation' => $nomineeData['relation'],
    //                     'nominee_address'  => $nomineeData['address'],
    //                 ]);

    //                 Log::info('Nominee updated', [
    //                     'rd_account_id' => $rdAccount->id,
    //                     'nominee_id'    => $existingNominees[$index]->id,
    //                     'updated_data'  => $nomineeData,
    //                     'user_id'       => Auth::id() ?? null,
    //                 ]);
    //             } else {
    //                 // Else create a new nominee
    //                 $newNominee = $rdAccount->nominee()->create([
    //                     'nominee_name'     => $nomineeData['name'],
    //                     'nominee_relation' => $nomineeData['relation'],
    //                     'nominee_address'  => $nomineeData['address'],
    //                 ]);

    //                 Log::info('Nominee created', [
    //                     'rd_account_id' => $rdAccount->id,
    //                     'nominee_id'    => $newNominee->id,
    //                     'created_data'  => $nomineeData,
    //                     'user_id'       => Auth::id() ?? null,
    //                 ]);
    //             }
    //         }

    //         return redirect()->route('rd-accounts.show', $rdAccount->id)
    //             ->with('success', 'Nominees saved successfully.');
    //     } catch (ValidationException $e) {
    //         throw $e;
    //     } catch (\Exception $e) {
    //         Log::error('Error saving nominees', [
    //             'rd_account_id' => $id,
    //             'error_message' => $e->getMessage(),
    //             'trace'         => $e->getTraceAsString(),
    //             'user_id'       => Auth::id() ?? null,
    //         ]);

    //         return redirect()->route('rd-accounts.show', $id)
    //             ->with('error', 'An error occurred while saving nominees. Please try again.');
    //     }
    // }


    // Show Add Nominee Form
    public function showAddNomineeForm($id)
    {
        $rdAccount = RdAccount::with(['member', 'rdScheme', 'minor', 'nominee'])
            ->findOrFail($id);

        return view('mds_rd_accounts.mds-rd-account.view.account-detail.add-nominee', compact('rdAccount'));
    }
    public function showMinorForm($id)
    {
        $rdAccount = RdAccount::with(['member', 'scheme', 'minor', 'branch'])->findOrFail($id);
        $minors = Minor::where('member_id', $rdAccount->member_id)
            ->where('id', '!=', $rdAccount->minor_id)
            ->get();
        $totalReceived = $rdAccount->rdTransactions()->whereNotNull('paid_on')->where('transaction_type', 'credit')->sum('amount_received');


        return view('mds_rd_accounts.mds-rd-account.view.account-detail.add-minor', compact('rdAccount', 'minors', 'totalReceived'));
    }

    public function uploadDocuments($id)
    {
        $rdAccount = RdAccount::with('member')->findOrFail($id);
        return view('mds_rd_accounts.mds-rd-account.view.upload_documents', compact('rdAccount'));
    }

    public function storeDocuments(Request $request, $id)
    {
        $rdAccount = RdAccount::findOrFail($id);

        // Validate fields properly
        $request->validate([
            'document_type.*' => 'required|string',
            'file_path.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Loop through uploaded documents
        foreach ($request->document_type as $index => $docType) {

            $file = $request->file('file_path')[$index] ?? null;

            if ($file) {
                $destinationPath = public_path('assets/documents');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move($destinationPath, $fileName);

                $path = 'assets/documents/' . $fileName;

                Document::create([
                    'rd_id' => $rdAccount->id,
                    'document_type' => $docType,
                    'file_path' => $path,
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('rd-accounts.show', $id)
            ->with('success', 'Documents uploaded successfully.');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Delete file from storage
        if (file_exists(storage_path('app/public/' . $document->file_path))) {
            unlink(storage_path('app/public/' . $document->file_path));
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    public function addComment($id)
    {
        $rdAccount = RdAccount::with('comments')->findOrFail($id);
        return view('mds_rd_accounts.mds-rd-account.view.add-comment', compact('rdAccount'));
    }

    public function storeComment(Request $request, $id)
    {
        // dd($id, $request->all());
        $request->validate([
            'comment'       => 'required|string',
        ]);

        Comments::create([
            'rd_account_id' => $id,
            'commented_by'  => auth::id(),
            'date'          => now()->toDateString(),
            'comment'       => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function updateSetting(Request $request, $id)
    {
        $rd = RdAccount::findOrFail($id);

        $field = $request->field;
        $value = $request->value;

        // Allowed fields
        if (!in_array($field, ['is_internet_enabled', 'money_transfer', 'is_locked', 'sms'])) {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        $rd->$field = $value;
        $rd->save();

        return response()->json(['success' => true]);
    }

    //print
    public function rdBondForm($id)
    {
        // Load RD account with required relations
        $rdAccount = RdAccount::with([
            'member',
            'nominee',
            'scheme'
        ])->findOrFail($id);

        $data = [
            'rdAccount'       => $rdAccount,
            'company_address' => 'HEAD OFFICE',
            'date'            => now()->format('d-m-Y'),
            'company_reg_no'  => 'Reg. No. 969/03-04',
        ];

        $pdf = app('dompdf.wrapper')
            ->loadView(
                'mds_rd_accounts.mds-rd-account.view.print-documents.rd-bond',
                $data
            )
            ->setPaper('a4', 'portrait');

        return $pdf->download('rd-bond-' . $rdAccount->id . '.pdf');
    }

    public function rdOpeningForm($id)
    {
        // Load RD account with required relations
        $account = RdAccount::with([
            'member.kyc',
            'member.address.state',
            'member.branch',
            'scheme'   // RD scheme relation
        ])->findOrFail($id);


        $interestRate = $account->scheme->anuual_interest_rate ?? 0;

        $member = $account->member;

        $pdf = app('dompdf.wrapper')
            ->loadView(
                'mds_rd_accounts.mds-rd-account.view.print-documents.accountopeningform',
                compact('account', 'member', 'interestRate')
            )
            ->setPaper('a4', 'portrait');

        return $pdf->stream('rd-opening-' . $id . '.pdf');
    }

    public function rdClosingForm($id)
    {
        $rdAccount = RdAccount::with(['member.branch'])->findOrFail($id);

        $data = [
            'name'           => $rdAccount->member->member_info_first_name . ' ' .
                $rdAccount->member->member_info_last_name,

            'date'           => now()->format('d-m-Y'),

            // RD Agreement / Account No
            'agreement_no'   => $rdAccount->rd_no ?? 'RD' . str_pad($rdAccount->id, 5, '0', STR_PAD_LEFT),

            'holder_name'    => strtoupper(
                $rdAccount->member->member_info_first_name . ' ' .
                    $rdAccount->member->member_info_last_name
            ),

            'expiry_date'    => \Carbon\Carbon::parse($rdAccount->maturity_date)->format('d-m-Y'),

            'branch_name'    => $rdAccount->member->branch->branch_name ?? '',

            'branch_address' => $rdAccount->member->branch->branch_address ?? '',
        ];

        $pdf = app('dompdf.wrapper')
            ->loadView(
                'mds_rd_accounts.mds-rd-account.view.print-documents.closingform',
                $data
            )
            ->setPaper('A4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('rd-closing-form-' . $rdAccount->id . '.pdf');
    }
}
