<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JournalEntryLine;

class LedgerService
{


    public function calculateLedgerBalance($ledgerCode)
    {
        
        $ledgerCode = strtoupper($ledgerCode);

        // FD InterestLIABILITY MODULES FIRST
        if ($ledgerCode === 'FD_INTEREST') {
            return $this->fdInterestBalance();
        }

        // FD Accounts
        if ($ledgerCode === 'FD_ACCOUNTS') {
            return $this->fdAccountsBalance();
        }

        // MIS MODULES
        if ($ledgerCode === 'MIS_ACCOUNTS') {
            return $this->misAccountsBalance();
        }

        // MIS INTEREST
        if ($ledgerCode === 'MIS_INTEREST') {
            return $this->misInterestBalance();
        }

        // DD MODULES
        if ($ledgerCode === 'DD_ACCOUNTS') {
            return $this->ddAccountsBalance();
        }

        // DD INTEREST
        if ($ledgerCode === 'DD_INTEREST') {
            return $this->ddInterestBalance();
        }

        // RD MODULES
        if ($ledgerCode === 'RD_ACCOUNTS') {
            return $this->rdAccountsBalance();
        }

        // RD INTEREST
        if ($ledgerCode === 'RD_INTEREST') {
            return $this->rdInterestBalance();
        }

        // SAVING Account MODULES

        if (Str::contains($ledgerCode, 'SAVING')) {
            return $this->savingAccountsBalance();
        }

        // Current Account MODULES

        if (Str::contains($ledgerCode, 'CURRENT')) {
            return $this->currentAccountsBalance();
        }

        // ASSET MODULES  -  All Loan Module

        // GOLD LOAN INTEREST FIRST
        if ($ledgerCode === 'GOLD_LOAN_INTEREST') {
            return $this->goldLoanInterestBalance();
        }

        // Then general GOLD
        if (Str::contains($ledgerCode, 'GOLD')) {
            return $this->goldLoanBalance();
        }

        if ($ledgerCode === 'MORTGAGE_LOAN_INTEREST') {
            return $this->mortgageLoanInterestBalance();
        }

        if ($ledgerCode === 'PROPERTY_LOAN_INTEREST') {
            return $this->mortgageLoanInterestBalance();
        }

        if (Str::contains($ledgerCode, 'MORTGAGE')) {
            return $this->mortgageBalance();
        }

        if ($ledgerCode === 'LOAN_AGINST_INTEREST') {
            return $this->againstLoanInterestBalance();
        }

        if (Str::contains($ledgerCode, 'AGINST')) {
            return $this->loanagainstBalance();
        }

        if ($ledgerCode === 'PERSONAL_LOAN_INTEREST') {
            return $this->personalInterestBalance();
        }
        if ($ledgerCode === 'VEHICAL_LOAN_INTEREST') {
            return $this->vehicalInterestBalance();
        }
        if ($ledgerCode === 'DAILY_WEEKLY_LOAN_INTEREST') {
            return $this->dailyweeklyLoanInterestBalance();
        }
        if ($ledgerCode === 'CC_OD_LOAN_INTEREST') {
            return $this->ccodLoanInterestBalance();
        }
        if ($ledgerCode === 'BUSSINESS_LOAN_INTEREST') {
            return $this->bussinessLoanInterestBalance();
        }

        if (Str::contains($ledgerCode, 'PERSONAL')) {
            return $this->personalloanBalance();
        }

        if (Str::contains($ledgerCode, 'BUSINESS')) {
            return $this->businessloanBalance();
        }

        if (Str::contains($ledgerCode, 'CC_OD')) {
            return $this->ccodloanBalance();
        }

        if (Str::contains($ledgerCode, ['DAILY', 'WEEKLY'])) {
            return $this->dailyweeklyloanBalance();
        }

        if (Str::contains($ledgerCode, ['VEHICLE', 'VEHICAL'])) {
            return $this->vehicalloanBalance();
        }

        return [0,0];
    }

     // Interest = P × R × T / 100 
    public function calculateFlatInterest($principal, $rate, $months)
    {
        $years = $months / 12;

        return ($principal * $rate * $years) / 100;
    }

    // EMI = P × r × (1+r)^n / ((1+r)^n - 1)
    public function calculateReducingInterest($principal, $annualRate, $months)
    {
        $monthlyRate = $annualRate / 12 / 100;

        $emi = $principal * $monthlyRate * pow(1 + $monthlyRate, $months)
            / (pow(1 + $monthlyRate, $months) - 1);

        $totalPayment = $emi * $months;

        return $totalPayment - $principal;
    }

    public function calculateAdvanceInterest($principal, $rate, $months)
    {
        $interest = $this->calculateFlatInterest($principal, $rate, $months);

        return $interest; // deducted upfront
    }

    public function calculateBulletInterest($principal, $rate, $months)
    {
        return $this->calculateFlatInterest($principal, $rate, $months);
    }

    public function calculateLoanInterest($loanTable, $schemeTable)
    {
        $loans = DB::table($loanTable)
            ->where('status', 2)
            ->get();

        $totalInterest = 0;

        foreach ($loans as $loan) {

            $scheme = DB::table($schemeTable)
                ->where('id', $loan->scheme_id)
                ->first();

            if (!$scheme) continue;

            $principal = $loan->loan_amount;
            $rate      = $scheme->annual_interest_rate;
            $months    = $scheme->tenure;

            switch ($scheme->interest_type ?? $scheme->gold_loan_setting ?? 'flat') {

                case 'reducing_emi':
                    $interest = $this->calculateReducingInterest($principal, $rate, $months);
                    break;

                case 'advance':
                    $interest = $this->calculateAdvanceInterest($principal, $rate, $months);
                    break;

                case 'no_emi':
                    $interest = $this->calculateBulletInterest($principal, $rate, $months);
                    break;

                default:
                    $interest = $this->calculateFlatInterest($principal, $rate, $months);
            }

            $totalInterest += $interest;
        }

        return [$loans->count(), $totalInterest];
    }

    public function calculateGroupBalance($groupId)
    {
        $ledgers = Ledger::where('group_id', $groupId)->get();

        if ($ledgers->isEmpty()) {
            return [0,0]; // no ledger → no balance
        }

        $totalAccounts = 0;
        $totalBalance  = 0;

        foreach ($ledgers as $ledger) {

            [$accounts, $balance] = $this->calculateLedgerBalance($ledger->code);

            $totalAccounts += $accounts;
            $totalBalance  += $balance;
        }

        return [$totalAccounts, $totalBalance];
    }

    public function calculateLedgersBalance($code)
    {
        $code = strtoupper(Str::slug($code, '_'));

        // Specific matches first

        if (Str::contains($code, 'GOLD_LOAN_INTEREST')) {
            return $this->goldLoanInterestBalance();
        }

        if (Str::contains($code, ['MORTGAGE_LOAN_INTEREST', 'PROPERTY_LOAN_INTEREST'])) {
            return $this->mortgageLoanInterestBalance();
        }

        if (Str::contains($code, ['DEPOSIT_LOAN_INTEREST', 'LOAN_AGAINST_INTEREST'])) {
            return $this->againstLoanInterestBalance();
        }

        if (Str::contains($code, ['DEPOSIT_LOAN_INTEREST', 'LOAN_AGAINST_INTEREST'])) {
            return $this->againstLoanInterestBalance();
        }

        if (Str::contains($code, 'PERSONAL_LOAN_INTEREST')) {
            return $this->personalInterestBalance();
        }
        if (Str::contains($code, 'VEHICAL_LOAN_INTEREST')) {
            return $this->vehicalInterestBalance();
        }
        if (Str::contains($code, 'DAILY_WEEKLY_LOAN_INTEREST')) {
            return $this->dailyweeklyLoanInterestBalance();
        }
        if (Str::contains($code, 'CC_OD_LOAN_INTEREST')) {
            return $this->ccodLoanInterestBalance();
        }
        if (Str::contains($code, 'BUSSINESS_LOAN_INTEREST')) {
            return $this->bussinessLoanInterestBalance();
        }

        if (Str::contains($code, 'GOLD')) {
            return $this->goldLoanBalance();
        }

        if (Str::contains($code, ['MORTGAGE', 'PROPERTY'])) {
            return $this->mortgageBalance();
        }

        if (Str::contains($code, ['AGAINST', 'DEPOSITE'])) {
            return $this->loanagainstBalance();
        }

        if (Str::contains($code, 'BUSINESS')) {
            return $this->businessloanBalance();
        }

        if (Str::contains($code, ['CC_OD', 'CCOD'])) {
            return $this->ccodloanBalance();
        }

        if (Str::contains($code, ['DAILY', 'WEEKLY'])) {
            return $this->dailyweeklyloanBalance();
        }

        if (Str::contains($code, 'PERSONAL')) {
            return $this->personalloanBalance();
        }

        if (Str::contains($code, ['VEHICLE', 'CAR'])) {
            return $this->vehicalloanBalance();
        }
        if (Str::contains($code, 'SAVING')) {
            return $this->savingAccountsBalance();
        }
        // INTEREST FIRST
        if (Str::contains($code, 'FD_INTEREST')) {
            return $this->fdInterestBalance();
        }

        if (Str::contains($code, 'RD_INTEREST')) {
            return $this->rdInterestBalance();
        }

        if (Str::contains($code, 'MIS_INTEREST')) {
            return $this->misInterestBalance();
        }

        if (Str::contains($code, 'DD_INTEREST')) {
            return $this->ddInterestBalance();
        }
        if (Str::contains($code, 'FD')) {
            return $this->fdAccountsBalance();
        }
         if (Str::contains($code, 'RD')) {
            return $this->rdAccountsBalance();
        }
         if (Str::contains($code, 'MIS')) {
            return $this->misAccountsBalance();
        }
        if (Str::contains($code, 'DD')) {
            return $this->ddAccountsBalance();
        }
       
        return [0, 0];
    }

    private function fdAccountsBalance()
    {
        $fds = DB::table('fd_accounts')
            ->where('status', 1)   // Approved
            ->where('active', 1)   // Active
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->fd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function fdInterestBalance()
    {
        $fds = DB::table('fd_accounts')
            ->where('status', 1)
            ->where('active', 1)
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->fd_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
    }

    private function misAccountsBalance()
    {
        $fds = DB::table('misaccounts')
            ->where('status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->mis_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function misInterestBalance()
    {
        $fds = DB::table('misaccounts')
            ->where('status', 1)
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->mis_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
    }

    private function ddAccountsBalance()
    {
        $fds = DB::table('dds_accounts')
            ->where('status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->maturity_amount ?? $fd->dd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function ddInterestBalance()
    {
        $fds = DB::table('dds_accounts')
            ->where('status', 1)
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->dd_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
    }

    private function rdAccountsBalance()
    {
        $fds = DB::table('rd_accounts')
            ->where('approve_status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->rd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function savingAccountsBalance()
    {
        $accounts = DB::table('accounts')
            ->where('account_type', 'SAVING')
            ->where('approve_status', '1')   // string match
            ->where('account_status', 1)
            ->get();

        $totalAccounts = $accounts->count();
        $totalBalance = $accounts->sum('amount_deposit');

        return [$totalAccounts, $totalBalance];
    }

    private function currentAccountsBalance()
    {
        $accounts = DB::table('accounts')
            ->where('account_type', 'CURRENT')
            ->where('approve_status', '1')   // string match
            ->where('account_status', 1)
            ->get();

        $totalAccounts = $accounts->count();
        $totalBalance = $accounts->sum('amount_deposit');

        return [$totalAccounts, $totalBalance];
    }

    private function rdInterestBalance()
    {
        $fds = DB::table('rd_accounts')
            ->where('approve_status', 'Approved')
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->rd_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
    }

    private function goldLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'loan_applications',
            'gold_loan_schemes'
        );
    }

    private function mortgageLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'mortgage_loan_applications',
            'mortgage_schemes'
        );
    }

    private function againstLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'loan_against_applications',
            'loan_against_schemes'
        );
    }

    private function bussinessLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'bussiness_loan_applications',
            'business_loan_schemes'
        );
    }

    private function ccodLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'cc_od_loan_applications',
            'cc_od_loan_schemes'
        );
    }

    private function dailyweeklyLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'daily_weekly_applications',
            'daily_weekly_schemes'
        );
    }

    private function personalInterestBalance()
    {
        return $this->calculateLoanInterest(
            'personal_loan_applications',
            'personal_schemes'
        );
    }

    private function vehicalInterestBalance()
    {
        return $this->calculateLoanInterest(
            'vehical_applications',
            'vehical_schemes'
        );
    }

    private function goldLoanBalance()
    {
        $loans = DB::table('loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('gold_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('gold_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('gold_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function mortgageBalance()
    {
        $loans = DB::table('mortgage_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('mortgage_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('mortgage_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('mortgage_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function loanagainstBalance()
    {
        $loans = DB::table('loan_against_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('loan_against_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('loan_against_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('loan_against_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function businessloanBalance()
    {
        $loans = DB::table('bussiness_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('business_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('business_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('business_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function ccodloanBalance()
    {
        $loans = DB::table('cc_od_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('cc_od_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('cc_od_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('cc_od_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function dailyweeklyloanBalance()
    {
        $loans = DB::table('daily_weekly_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function personalloanBalance()
    {
        $loans = DB::table('personal_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('personal_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('personal_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('personal_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function vehicalloanBalance()
    {
        $loans = DB::table('vehical_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('vehical_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('vehical_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('vehical_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    public function calculateNetProfit($tillDate = null)
    {
        $ledgers = Ledger::all();

        $totalRevenue = 0;
        $totalExpense = 0;

        foreach ($ledgers as $ledger) {

            [$acc, $balance] =
                $this->calculateLedgerBalance($ledger->code, $tillDate);

            if ($ledger->type == 'Revenue') {
                $totalRevenue += $balance;
            }

            if ($ledger->type == 'Expense') {
                $totalExpense += $balance;
            }
        }

        return [0, $totalRevenue - $totalExpense];
    }

    public function generateTrialBalance($fromDate, $toDate)
    {
        $ledgers = Ledger::with('group')->get();

        $result = [];

        foreach ($ledgers as $ledger) {

            // Opening balance (before fromDate)
            $openingDebit = JournalEntryLine::where('ledger_code', $ledger->code)
                ->whereDate('created_at', '<', $fromDate)
                ->sum('debit');

            $openingCredit = JournalEntryLine::where('ledger_code', $ledger->code)
                ->whereDate('created_at', '<', $fromDate)
                ->sum('credit');

            // Period transactions
            $periodDebit = JournalEntryLine::where('ledger_code', $ledger->code)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('debit');

            $periodCredit = JournalEntryLine::where('ledger_code', $ledger->code)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('credit');

            // Opening logic by nature
            if (in_array($ledger->type, ['Asset','Expense'])) {
                $opening = $ledger->opening_balance + $openingDebit - $openingCredit;
                $closing = $opening + $periodDebit - $periodCredit;
            } else {
                $opening = $ledger->opening_balance + $openingCredit - $openingDebit;
                $closing = $opening + $periodCredit - $periodDebit;
            }

            $result[] = [
                'code' => $ledger->code,
                'name' => $ledger->display_name,
                'system_name' => $ledger->name,
                'group' => $ledger->group->name ?? '',
                'type' => $ledger->type,
                'opening' => $opening,
                'debit' => $periodDebit,
                'credit' => $periodCredit,
                'balance' => $closing
            ];
        }

        return $result;
    }


}