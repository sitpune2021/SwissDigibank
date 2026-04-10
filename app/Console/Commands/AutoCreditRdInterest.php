<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use App\Models\RdAccount;
use App\Models\RdTransactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log as FacadesLog;
 
//*********command for test php artisan rd:auto-credit-interest --simulate-months=3 -----fro futer months
// ********and for now php artisan rd:auto-credit-interest*********** */
 
class AutoCreditRdInterest extends Command
{
    protected $signature = 'rd:auto-credit-interest';
// protected $signature = 'rd:auto-credit-interest {--simulate-months=0}';
    protected $description = 'Auto credit RD interest based on compounding frequency using computeInterestTillToday()';
 
    public function handle()
    {
        $today = Carbon::today();
    //     $simulateMonths = (int)$this->option('simulate-months'); //for testing
    //     $today = $simulateMonths > 0
    // ? Carbon::today()->addMonths($simulateMonths)
    // : Carbon::today();                                          //-->
 
        $accounts = RdAccount::with('scheme')->get();
 
        FacadesLog::info("RD Interest Running With Date = " . $today->toDateString());
 
 
        foreach ($accounts as $acc) {
 
            $schemes = $acc->scheme;
            if (!$schemes) continue;
 
            $tenureValue = (int)($schemes->tenure_of_rd_dd_value ?? 0);
            $tenureType = strtolower(trim((string)($schemes->tenure_of_rd_dd_type ?? 'months')));
 
            $tenureMonths = match ($tenureType) {
                'year', 'years', 'yr', 'yrs' => $tenureValue * 12,
                'month', 'months' => $tenureValue,
                default => $tenureValue,
            };
 
            // Compute interest till today's date
            $computed = $this->computeInterestTillToday($acc, $schemes,$today);
 
 
            $principal = $computed['principal'];
            $interestShouldBe = $computed['interest_till_now'];
 
            // interest already credited
            $interestAlreadyCredited = RdTransactions::where('rd_account_id', $acc->id)
                ->where('payment_mode', 'System')
                ->sum('amount');
 
            // remaining interest to credit today
            $interestToCredit = $interestShouldBe - $interestAlreadyCredited;
 
            $bonusAmount = 0;
 
            if ($interestToCredit > 0.01) {
 
                RdTransactions::create([
                    'rd_account_id'    => $acc->id,
                    'amount'           => round($interestToCredit, 2),
                    'transaction_type' => 'credit',
                    'payment_mode'     => 'System',
                    't_date'           => $today->format('Y-m-d'),
                    'status'           => 1, // directly mark as credited   
                    'remark'           => "Auto interest credit as per compounding",
                ]);
 
                FacadesLog::info("Auto Interest Credited", [
                    'rd_account_id' => $acc->id,
                    'credited'      => round($interestToCredit, 2),
                    'balance_after' => $this->getAccountBalance($acc->id),
                ]);
 
                FacadesLog::info('DEBUG INTEREST', [
                    'acc_id' => $acc->id,
                    'open_date' => $acc->open_date,
                    'today' => $today->format('Y-m-d'),
                    'months_elapsed' => $computed['months_elapsed'],
                    'interest_till_now' => $computed['interest_till_now'],
                    'interestAlreadyCredited' => $interestAlreadyCredited,
                    'interestToCredit' => $interestToCredit,
                ]);
            }
 
            $bonusType = strtolower($schemes->bonus_rate_type ?? '');
            $bonusValue = (float) ($schemes->bonus_rate_value ?? 0);
 
            // if ($bonusValue > 0) {
 
            // Calculate bonus
            // if (in_array($bonusType, ['percentage', '%'])) {
            //     $bonusAmount = ($principal) * ($bonusValue / 100);
            // } else {
            //     $bonusAmount = $bonusValue;
            // }
 
            // Already months → no change
            // If someone stores 'month' or 'months', it stays as it is
 
            //  Check if maturity month reached
            $isMaturityMonth = $computed['months_elapsed'] >= $tenureMonths;
 
            //  Check if bonus already credited
            $bonusAlreadyCredited = RdTransactions::where('rd_account_id', $acc->id)
                ->where('remark', "Bonus credited ({$bonusType})")
                ->exists();
 
            //  If bonus exists AND maturity reached AND not credited before → credit now
            if ($bonusValue > 0 && $isMaturityMonth && !$bonusAlreadyCredited) {
 
                // Calculate bonus amount
                if (in_array($bonusType, ['percentage', '%', 'percent'])) {
                    $bonusAmount = $principal * ($bonusValue / 100);
                } else {
                    $bonusAmount = $bonusValue; // flat bonus
                }
 
                // Create bonus transaction
                RdTransactions::create([
                    'rd_account_id'    => $acc->id,
                    'amount'           => round($bonusAmount, 2),
                    'transaction_type' => 'credit',
                    'payment_mode'     => 'System',
                    't_date'           => $today->format('Y-m-d'),
                    'status'           => 1, // directly mark as credited
                    'remark'           => "Bonus credited ({$bonusType})"
                ]);
 
                FacadesLog::info("Bonus Credited", [
                    'rd_account_id' => $acc->id,
                    'bonus_amount'  => round($bonusAmount, 2),
                ]);
            }
        }
 
        $this->info('RD auto-interest + bonus credit completed.');
    }
 
 
    // ----------------------------------------------------------
    // Core RD Interest Computation Till Today
    // ----------------------------------------------------------
 
    private function computeInterestTillToday($rdAccount, $schemes,$today): array
{
    FacadesLog::info("RD CALC START", [
        'acc_id'         => $rdAccount->id,
        'open_date'      => $rdAccount->open_date,
    ]);
 
    $startDate = Carbon::parse($rdAccount->open_date)->startOfDay();
    $today     = $today->startOfDay();
 
    if ($today->lessThanOrEqualTo($startDate)) {
        return [
            'principal'         => 0,
            'interest_till_now' => 0,
            'months_elapsed'    => 0,
            'compounding_per_year' => 0,
        ];
    }
 
    // integer months only
    $monthsElapsed = $startDate->diffInMonths($today);
 
    FacadesLog::info("MONTHS ELAPSED", [
        'acc_id'         => $rdAccount->id,
        'months_elapsed' => $monthsElapsed,
        'start_date'     => $startDate->toDateString(),
        'today'          => $today->toDateString(),
    ]);
 
    // get all principal installments (exclude System interest/bonus)
    $installments = RdTransactions::where('rd_account_id', $rdAccount->id)
         ->where('transaction_type', 'credit')
    ->where(function($q) {
        $q->where('payment_mode', '!=', 'System')
          ->orWhereNull('payment_mode');
    })
    ->where(function($q) {
        $q->whereNull('remark')
          ->orWhereNotLike('remark', '%interest%')
          ->orWhereNotLike('remark', '%bonus%');
    })
    ->orderBy('t_date')
    ->get();
 
    $principal = (float) $installments->sum('amount');
 
    if ($principal <= 0 || $monthsElapsed === 0) {
        return [
            'principal'         => round($principal, 2),
            'interest_till_now' => 0,
            'months_elapsed'    => $monthsElapsed,
            'compounding_per_year' => 0,
        ];
    }
 
    // Interest rate
    $annualRate = (float)$schemes->anuual_interest_rate / 100;
 
    // Compounding frequency
    $comp = strtoupper($schemes->interest_compounding_interval);
    $m = match ($comp) {
        'MONTHLY'   => 12,
        'QUARTERLY' => 4,
        'HALFYEARLY', 'HALF-YEARLY', 'HALF YEARLY' => 2,
        'YEARLY'    => 1,
        default     => 4,
    };
 
    FacadesLog::info("SCHEME INFO", [
        'acc_id'               => $rdAccount->id,
        'annual_rate'          => $annualRate,
        'compounding'          => $schemes->interest_compounding_interval,
        'm'                    => $m,
    ]);
 
    // Effective monthly rate
    $monthlyRate = pow(1 + $annualRate / $m, $m / 12) - 1;
 
    FacadesLog::info("MONTHLY RATE", [
        'acc_id'       => $rdAccount->id,
        'monthly_rate' => $monthlyRate,
    ]);
 
    $balance       = 0.0;
    $accInterest   = 0.0;
    $creditInterval = (int) round(12 / $m);   // months between compounding
    $currentMonthStart = $startDate->copy();
 
    FacadesLog::info("SIMULATION START", [
        'acc_id'                 => $rdAccount->id,
        'credit_interval_months' => $creditInterval
    ]);
 
    for ($month = 1; $month <= $monthsElapsed; $month++) {
        $nextMonthStart = $currentMonthStart->copy()->addMonth();
 
        // sum all installments paid in this month
        $monthDeposits = $installments->filter(function ($txn) use ($currentMonthStart, $nextMonthStart) {
            $d = Carbon::parse($txn->t_date)->startOfDay();
            return $d->greaterThanOrEqualTo($currentMonthStart)
                && $d->lessThan($nextMonthStart);
        })->sum('amount');
 
        if ($monthDeposits > 0) {
            $balance += $monthDeposits;
            FacadesLog::info("MONTH DEPOSIT", [
                'acc_id'   => $rdAccount->id,
                'month_no' => $month,
                'deposit'  => $monthDeposits,
                'balance'  => $balance,
            ]);
        }
 
        // interest on current balance
        $accInterest += $balance * $monthlyRate;
 
        FacadesLog::info("MONTH LOOP", [
            'acc_id'              => $rdAccount->id,
            'month'               => $month,
            'balance'             => $balance,
            'accumulated_interest'=> $accInterest,
        ]);
 
        // credit interest at compounding interval
        if ($creditInterval > 0 && $month % $creditInterval === 0) {
            FacadesLog::info("CREDIT INTEREST", [
                'acc_id'           => $rdAccount->id,
                'credited_month'   => $month,
                'interest_credited'=> $accInterest
            ]);
 
            $balance += $accInterest;
            $accInterest = 0.0;
        }
 
        $currentMonthStart = $nextMonthStart;
    }
 
    // leftover interest (partial current interval) till "today"
    $balance += $accInterest;
 
    FacadesLog::info("LEFTOVER INTEREST ADDED", [
        'acc_id'            => $rdAccount->id,
        'leftover_interest' => $accInterest,
        'final_balance'     => $balance
    ]);
 
    $interestEarned = $balance - $principal;
 
    FacadesLog::info("RD CALC FINAL", [
        'acc_id'            => $rdAccount->id,
        'principal'         => $principal,
        'interest_till_now' => $interestEarned,
    ]);
 
    return [
        'principal'         => round($principal, 2),
        'interest_till_now' => max(0, round($interestEarned, 2)), // no negative interest
        'months_elapsed'    => $monthsElapsed,
        'compounding_per_year' => $m,
    ];
}
 
 
    private function getAccountBalance($id)
    {
        return RdTransactions::where('rd_account_id', $id)
            ->where('transaction_type', 'credit')
            ->sum('amount')
            -
            RdTransactions::where('rd_account_id', $id)
            ->where('transaction_type', 'debit')
            ->sum('amount');
    }
}
 
 