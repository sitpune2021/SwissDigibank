@extends('layout.main')
<style>
    /* Main Heading */
    .main-inner h3 {
        letter-spacing: 1px;
        color: #2d3748;
    }

    /* Filter Section */
    form input[type="date"] {
        border: 1px solid #d1d5db;
        font-size: 14px;
    }

    form button {
        font-weight: 600;
        transition: 0.3s;
    }

    form button:hover {
        background-color: #d97706;
    }

    /* Mode Tabs */
    .mode-tabs a {
        padding-bottom: 5px;
        transition: 0.3s;
    }

    .mode-tabs a:hover {
        color: #2563eb;
    }

    /* Table */
    table {
        border-collapse: collapse;
        background: #ffffff;
    }

    table th,
    table td {
        border: 1px solid #e5e7eb;
        padding: 8px 10px;
        font-size: 13px;
    }

    /* Header */
    thead {
        background: #5b4db2;
    }

    thead th {
        color: #ffffff;
        font-weight: 600;
        text-align: center;
    }

    /* Branch Header Row */
    .branch-header {
        background: #f3f4f6;
        font-weight: bold;
        font-size: 14px;
    }

    /* Account Header */
    .account-header {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    /* Deposit Row */
    .deposit-row {
        background-color: #c6f6d5;
        font-weight: 600;
        color: #065f46;
    }

    /* Withdraw Row */
    .withdraw-row {
        background-color: #fef3c7;
        font-weight: 600;
        color: #92400e;
    }

    /* Recovery Row */
    .recovery-row {
        background-color: #bbf7d0;
        font-weight: 600;
        color: #065f46;
    }

    /* Released Row */
    .released-row {
        background-color: #fde68a;
        font-weight: 600;
        color: #7c2d12;
    }

    /* Totals */
    .total-credit {
        font-weight: 700;
        color: #065f46;
    }

    .total-debit {
        font-weight: 700;
        color: #7c2d12;
    }

    /* Responsive */
    .overflow-x-auto {
        border-radius: 8px;
        overflow: auto;
    }
</style>
@section('content')
    <div class="main-inner">

        <h3 class="text-xl font-semibold uppercase mb-6">BRANCH REPORT</h3>

        {{-- FILTER --}}
        <form method="GET" class="flex gap-3 mb-6 items-center">
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="border px-3 py-2 rounded">

            <input type="date" name="to_date" value="{{ request('to_date') }}" class="border px-3 py-2 rounded">

            <button class="px-4 py-2 rounded text-primary">
                SEARCH
            </button>
        </form>

        {{-- MODE TABS --}}
        <div class="flex gap-6 mb-4 border-b pb-2 text-sm font-semibold">
            <a href="{{ route('reports.branch', ['mode' => 'all']) }}"
                class="{{ ($mode ?? 'all') == 'all' ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                CASH / CHEQUE / ONLINE
            </a>

            <a href="{{ route('reports.branch', ['mode' => 'cash']) }}"
                class="{{ ($mode ?? '') == 'cash' ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                CASH
            </a>

            <a href="{{ route('reports.branch', ['mode' => 'cheque']) }}"
                class="{{ ($mode ?? '') == 'cheque' ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                CHEQUE
            </a>

            <a href="{{ route('reports.branch', ['mode' => 'online']) }}"
                class="{{ ($mode ?? '') == 'online' ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                ONLINE
            </a>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-center border">

                <thead class="bg-purple-700 text-white uppercase">
                    <tr>
                        <th class="p-3">S NO.</th>
                        <th class="p-3">BRANCH NAME</th>
                        <th colspan="5">ACCOUNTS</th>
                        <th>TOTAL (CREDIT)</th>
                        <th>TOTAL (DEBIT)</th>
                    </tr>
                </thead>
                @php
                    $grandCredit = 0;
                    $grandDebit = 0;
                @endphp
                <tbody>

                    @foreach ($branches as $index => $branch)
                        @php

                            // ================= COMMON MODE FILTER =================
                            $modeColumn = function ($query, $columnName) use ($mode) {
                                if ($mode != 'all') {
                                    $query->where($columnName, $mode);
                                }
                                return $query;
                            };

                            // ================= SAVING =================
                            // accounts table madhun saving account_type = 'SAVING'

                            $savingDeposit = $modeColumn(
                                \DB::table('accounts')
                                    ->where('branch_id', $branch->id)
                                    ->where('account_type', 'SAVING')
                                    ->whereBetween('transaction_date', [$from, $to]),
                                'payment_mode',
                            )->sum('amount_deposit');

                            $savingWithdraw = 0; // If you have saving_transactions table then update here

                            // ================= RD =================

                            $rdDeposit = $modeColumn(
                                \DB::table('rd_transactions')
                                    ->join('rd_accounts', 'rd_accounts.id', '=', 'rd_transactions.rd_account_id')
                                    ->where('rd_accounts.branch_id', $branch->id)
                                    ->where('rd_transactions.transaction_type', 'credit')
                                    ->whereBetween('rd_transactions.t_date', [$from, $to]),
                                'rd_transactions.payment_mode',
                            )->sum('rd_transactions.amount');

                            $rdWithdraw = $modeColumn(
                                \DB::table('rd_transactions')
                                    ->join('rd_accounts', 'rd_accounts.id', '=', 'rd_transactions.rd_account_id')
                                    ->where('rd_accounts.branch_id', $branch->id)
                                    ->where('rd_transactions.transaction_type', 'debit')
                                    ->whereBetween('rd_transactions.t_date', [$from, $to]),
                                'rd_transactions.payment_mode',
                            )->sum('rd_transactions.amount');

                            // ================= DD =================

                            $ddDeposit = $modeColumn(
                                \DB::table('dd_transactions')
                                    ->join('dds_accounts', 'dds_accounts.id', '=', 'dd_transactions.dds_account_id')
                                    ->where('dds_accounts.branch_id', $branch->id)
                                    ->where('dd_transactions.type', 'credit')
                                    ->whereBetween('dd_transactions.transaction_date', [$from, $to]),
                                'dd_transactions.pay_mode',
                            )->sum('dd_transactions.amount');

                            $ddWithdraw = $modeColumn(
                                \DB::table('dd_transactions')
                                    ->join('dds_accounts', 'dds_accounts.id', '=', 'dd_transactions.dds_account_id')
                                    ->where('dds_accounts.branch_id', $branch->id)
                                    ->where('dd_transactions.type', 'debit')
                                    ->whereBetween('dd_transactions.transaction_date', [$from, $to]),
                                'dd_transactions.pay_mode',
                            )->sum('dd_transactions.amount');

                            // ================= FD =================

                            $fdDeposit = $modeColumn(
                                \DB::table('fd_transactions')
                                    ->join('fd_accounts', 'fd_accounts.id', '=', 'fd_transactions.fd_account_id')
                                    ->where('fd_accounts.branch_id', $branch->id)
                                    ->where('fd_transactions.transaction_type', 1)
                                    ->whereBetween('fd_transactions.transaction_date', [$from, $to]),
                                'fd_transactions.mode',
                            )->sum('fd_transactions.amount');

                            $fdWithdraw = $modeColumn(
                                \DB::table('fd_transactions')
                                    ->join('fd_accounts', 'fd_accounts.id', '=', 'fd_transactions.fd_account_id')
                                    ->where('fd_accounts.branch_id', $branch->id)
                                    ->where('fd_transactions.transaction_type', 0)
                                    ->whereBetween('fd_transactions.transaction_date', [$from, $to]),
                                'fd_transactions.mode',
                            )->sum('fd_transactions.amount');

                            // ================= MIS =================

                            $misDeposit = $modeColumn(
                                \DB::table('mis_transactions')
                                    ->join('misaccounts', 'misaccounts.id', '=', 'mis_transactions.misaccount_id')
                                    ->where('misaccounts.branch_id', $branch->id)
                                    ->where('mis_transactions.transaction_type', 'credit')
                                    ->whereBetween('mis_transactions.transaction_date', [$from, $to]),
                                'mis_transactions.pay_mode',
                            )->sum('mis_transactions.amount');

                            $misWithdraw = $modeColumn(
                                \DB::table('mis_transactions')
                                    ->join('misaccounts', 'misaccounts.id', '=', 'mis_transactions.misaccount_id')
                                    ->where('misaccounts.branch_id', $branch->id)
                                    ->where('mis_transactions.transaction_type', 'debit')
                                    ->whereBetween('mis_transactions.transaction_date', [$from, $to]),
                                'mis_transactions.pay_mode',
                            )->sum('mis_transactions.amount');

                            // ================= TOTALS =================

                            $totalCredit = $savingDeposit + $rdDeposit + $ddDeposit + $fdDeposit + $misDeposit;
                            $totalDebit = $savingWithdraw + $rdWithdraw + $ddWithdraw + $fdWithdraw + $misWithdraw;
                            // ================= LOAN MODE FILTER =================
                            $loanMode = function ($query) use ($mode) {
                                if ($mode != 'all') {
                                    $query->where('fee_mode', $mode);
                                }
                                return $query;
                            };

                            // ================= GOLD =================
                            $goldRecovery = DB::table('gold_loan_transactions')
                                ->join(
                                    'loan_applications',
                                    'loan_applications.id',
                                    '=',
                                    'gold_loan_transactions.loan_id',
                                )
                                ->where('loan_applications.branch_id', $branch->id)
                                ->where('gold_loan_transactions.status', 'paid')
                                ->whereBetween('gold_loan_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('gold_loan_transactions.fee_mode', $mode);
                                })
                                ->sum('gold_loan_transactions.amount_collected');
                            // ================= LOAN AGAINST =================
                            $loanAgainstRecovery = DB::table('loan_against_transactions')
                                ->join(
                                    'loan_against_applications',
                                    'loan_against_applications.id',
                                    '=',
                                    'loan_against_transactions.loan_id',
                                )
                                ->where('loan_against_applications.branch_id', $branch->id)
                                ->where('loan_against_transactions.status', 'paid')
                                ->whereBetween('loan_against_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('loan_against_transactions.fee_mode', $mode);
                                })
                                ->sum('loan_against_transactions.amount_collected');

                            // ================= PROPERTY / MORTGAGE =================
                            $mortgageRecovery = DB::table('mortgage_loan_transactions')
                                ->join(
                                    'mortgage_loan_applications',
                                    'mortgage_loan_applications.id',
                                    '=',
                                    'mortgage_loan_transactions.loan_id',
                                )
                                ->where('mortgage_loan_applications.branch_id', $branch->id)
                                ->where('mortgage_loan_transactions.status', 'paid')
                                ->whereBetween('mortgage_loan_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('mortgage_loan_transactions.fee_mode', $mode);
                                })
                                ->sum('mortgage_loan_transactions.amount_collected');
                            // ================= BUSINESS =================
                            $businessRecovery = DB::table('business_loan_transactions')
                                ->join(
                                    'bussiness_loan_applications', // ⚠ double s
                                    'bussiness_loan_applications.id',
                                    '=',
                                    'business_loan_transactions.loan_id',
                                )
                                ->where('bussiness_loan_applications.branch_id', $branch->id)
                                ->where('business_loan_transactions.status', 'paid')
                                ->whereBetween('business_loan_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('business_loan_transactions.fee_mode', $mode);
                                })
                                ->sum('business_loan_transactions.amount_collected');
                            // ================= FIXED =================
                            $fixedRecovery = DB::table('fixed_loan_transactions')
                                ->join(
                                    'fixed_loan_applications',
                                    'fixed_loan_applications.id',
                                    '=',
                                    'fixed_loan_transactions.loan_id',
                                )
                                ->where('fixed_loan_applications.branch_id', $branch->id)
                                ->where('fixed_loan_transactions.status', 'paid')
                                ->whereBetween('fixed_loan_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('fixed_loan_transactions.fee_mode', $mode);
                                })
                                ->sum('fixed_loan_transactions.amount_collected');
                            // ================= VEHICLE =================
                            $vehicleRecovery = DB::table('vehical_loan_transactions')
                                ->join(
                                    'vehical_applications',
                                    'vehical_applications.id',
                                    '=',
                                    'vehical_loan_transactions.loan_id',
                                )
                                ->where('vehical_applications.branch_id', $branch->id)
                                ->where('vehical_loan_transactions.status', 'paid')
                                ->whereBetween('vehical_loan_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('vehical_loan_transactions.fee_mode', $mode);
                                })
                                ->sum('vehical_loan_transactions.amount_collected'); // ================= PERSONAL =================
                            $personalRecovery = DB::table('personal_loan_transactions')
                                ->join(
                                    'personal_loan_applications',
                                    'personal_loan_applications.id',
                                    '=',
                                    'personal_loan_transactions.loan_id',
                                )
                                ->where('personal_loan_applications.branch_id', $branch->id)
                                ->where('personal_loan_transactions.status', 'paid')
                                ->whereBetween('personal_loan_transactions.transaction_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('personal_loan_transactions.fee_mode', $mode);
                                })
                                ->sum('personal_loan_transactions.amount_collected');
                            // ================= CC / OD =================
                            $ccRecovery = DB::table('cc_od_loan_disbursments')
                                ->join(
                                    'cc_od_loan_applications',
                                    'cc_od_loan_applications.id',
                                    '=',
                                    'cc_od_loan_disbursments.loan_application_id',
                                )
                                ->where('cc_od_loan_applications.branch_id', $branch->id)
                                ->whereBetween('cc_od_loan_disbursments.disbursal_date', [$from, $to])
                                ->sum('cc_od_loan_disbursments.loan_amount');

                            $goldReleased = DB::table('gold_loan_disbursements')
                                ->join(
                                    'loan_applications',
                                    'loan_applications.id',
                                    '=',
                                    'gold_loan_disbursements.loan_application_id',
                                )
                                ->where('loan_applications.branch_id', $branch->id)
                                ->whereBetween('gold_loan_disbursements.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('gold_loan_disbursements.disburse_mode1', $mode);
                                })
                                ->sum('gold_loan_disbursements.loan_amount');

                            $loanAgainstReleased = DB::table('loanagainsst_disbursements')
                                ->join(
                                    'loan_against_applications',
                                    'loan_against_applications.id',
                                    '=',
                                    'loanagainsst_disbursements.loan_application_id',
                                )
                                ->where('loan_against_applications.branch_id', $branch->id)
                                ->whereBetween('loanagainsst_disbursements.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('loanagainsst_disbursements.disburse_mode1', $mode);
                                })
                                ->sum('loanagainsst_disbursements.loan_amount');
                            $mortgageReleased = DB::table('mortgage_loan_disbursements')
                                ->join(
                                    'mortgage_loan_applications',
                                    'mortgage_loan_applications.id',
                                    '=',
                                    'mortgage_loan_disbursements.loan_application_id',
                                )
                                ->where('mortgage_loan_applications.branch_id', $branch->id)
                                ->whereBetween('mortgage_loan_disbursements.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('mortgage_loan_disbursements.disburse_mode1', $mode);
                                })
                                ->sum('mortgage_loan_disbursements.loan_amount');
                            $businessReleased = DB::table('business_loan_disbursements')
                                ->join(
                                    'bussiness_loan_applications',
                                    'bussiness_loan_applications.id',
                                    '=',
                                    'business_loan_disbursements.loan_application_id',
                                )
                                ->where('bussiness_loan_applications.branch_id', $branch->id)
                                ->whereBetween('business_loan_disbursements.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('business_loan_disbursements.disburse_mode1', $mode);
                                })
                                ->sum('business_loan_disbursements.loan_amount');
                            $fixedReleased = DB::table('fixe_loan_disburments')
                                ->join(
                                    'fixed_loan_applications',
                                    'fixed_loan_applications.id',
                                    '=',
                                    'fixe_loan_disburments.loan_application_id',
                                )
                                ->where('fixed_loan_applications.branch_id', $branch->id)
                                ->whereBetween('fixe_loan_disburments.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('fixe_loan_disburments.payment_mode', $mode);
                                })
                                ->sum('fixe_loan_disburments.loan_amount');
                            $vehicleReleased = DB::table('vehical_disbursements')
                                ->join(
                                    'vehical_applications',
                                    'vehical_applications.id',
                                    '=',
                                    'vehical_disbursements.loan_application_id',
                                )
                                ->where('vehical_applications.branch_id', $branch->id)
                                ->whereBetween('vehical_disbursements.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where(function ($query) use ($mode) {
                                        $query
                                            ->where('vehical_disbursements.payment_mode1', $mode)
                                            ->orWhere('vehical_disbursements.payment_mode2', $mode);
                                    });
                                })
                                ->sum('vehical_disbursements.loan_amount');
                            $personalReleased = DB::table('personal_disburments')
                                ->join(
                                    'personal_loan_applications',
                                    'personal_loan_applications.id',
                                    '=',
                                    'personal_disburments.loan_application_id',
                                )
                                ->where('personal_loan_applications.branch_id', $branch->id)
                                ->whereBetween('personal_disburments.disbursal_date', [$from, $to])
                                ->when($mode != 'all', function ($q) use ($mode) {
                                    $q->where('personal_disburments.disburse_mode1', $mode);
                                })
                                ->sum('personal_disburments.loan_amount');
                            $ccReleased = DB::table('cc_od_loan_disbursments')
                                ->join(
                                    'cc_od_loan_applications',
                                    'cc_od_loan_applications.id',
                                    '=',
                                    'cc_od_loan_disbursments.loan_application_id',
                                )
                                ->where('cc_od_loan_applications.branch_id', $branch->id)
                                ->whereBetween('cc_od_loan_disbursments.disbursal_date', [$from, $to])
                                ->sum('cc_od_loan_disbursments.loan_amount');
                            $releasedTotal =
                                ($goldReleased ?? 0) +
                                ($loanAgainstReleased ?? 0) +
                                ($mortgageReleased ?? 0) +
                                ($businessReleased ?? 0) +
                                ($fixedReleased ?? 0) +
                                ($vehicleReleased ?? 0) +
                                ($personalReleased ?? 0) +
                                ($ccReleased ?? 0);
                            $grandCredit += $totalCredit;
                            $grandDebit += $releasedTotal;
                        @endphp

                        {{-- ================= BRANCH HEADER ROW ================= --}}
                        <tr class="branch-header">
                            <td>{{ $index + 1 }}</td>
                            <td class="text-left">{{ strtoupper($branch->branch_name) }}</td>
                            <td colspan="7"></td>
                        </tr>

                        {{-- ================= ACCOUNT HEADER ================= --}}
                        <tr class="account-header">
                            <td></td>
                            <td></td>
                            <td>SAVING</td>
                            <td>RD</td>
                            <td>DD</td>
                            <td>FD</td>
                            <td>MIS</td>
                            <td></td>
                            <td></td>
                        </tr>

                        {{-- ================= DEPOSIT ROW ================= --}}
                        <tr class="deposit-row">
                            <td></td>
                            <td>DEPOSIT</td>

                            <td>{{ number_format($savingDeposit, 2) }}</td>
                            <td>{{ number_format($rdDeposit, 2) }}</td>
                            <td>{{ number_format($ddDeposit, 2) }}</td>
                            <td>{{ number_format($fdDeposit, 2) }}</td>
                            <td>{{ number_format($misDeposit, 2) }}</td>

                            <td>{{ number_format($totalCredit, 2) }}</td>
                            <td></td>
                        </tr>

                        {{-- ================= WITHDRAW ROW ================= --}}
                        <tr class="withdraw-row">
                            <td></td>
                            <td>WITHDRAW</td>

                            <td>{{ number_format($savingWithdraw, 2) }}</td>
                            <td>{{ number_format($rdWithdraw, 2) }}</td>
                            <td>{{ number_format($ddWithdraw, 2) }}</td>
                            <td>{{ number_format($fdWithdraw, 2) }}</td>
                            <td>{{ number_format($misWithdraw, 2) }}</td>

                            <td></td>
                            <td>{{ number_format($totalDebit, 2) }}</td>
                        </tr>

                        {{-- ================= LOAN HEADER ================= --}}
                        <tr class="font-semibold">
                            <td></td>
                            <td></td>
                            <td>GOLD</td>
                            <td>DEP.LOAN</td>
                            <td>PROPERTY</td>
                            <td>BUSINESS</td>
                            <td>FIXED</td>
                            <td>VEHICLE</td>
                            <td>PERSONAL</td>
                        </tr>

                        {{-- ================= RECOVERY ================= --}}
                        <tr class="recovery-row">
                            <td></td>
                            <td>RECOVERY</td>
                            <td>{{ number_format($goldRecovery, 2) }}</td>
                            <td>{{ number_format($loanAgainstRecovery, 2) }}</td>
                            <td>{{ number_format($mortgageRecovery, 2) }}</td>
                            <td>{{ number_format($businessRecovery, 2) }}</td>
                            <td>{{ number_format($fixedRecovery, 2) }}</td>
                            <td>{{ number_format($vehicleRecovery, 2) }}</td>
                            <td>{{ number_format($personalRecovery, 2) }}</td>
                            <td>{{ number_format($ccRecovery, 2) }}</td>
                        </tr>

                        {{-- ================= RELEASED ================= --}}
                        <tr class="released-row">
                            <td></td>
                            <td>RELEASED</td>

                            <td>{{ number_format($goldReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($loanAgainstReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($mortgageReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($businessReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($fixedReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($vehicleReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($personalReleased ?? 0, 2) }}</td>
                            <td>{{ number_format($ccReleased ?? 0, 2) }}</td>

                            {{-- TOTAL COLUMN --}}
                            <td class="total-credit">
                                {{ number_format($releasedTotal, 2) }}
                            </td>

                        </tr>
                        <tr style="background:#f3f4f6; font-weight:bold;">
                            <td colspan="7" class="text-right">GRAND TOTAL</td>

                            <td class="total-credit">
                                {{ number_format($grandCredit, 2) }}
                            </td>

                            <td class="total-debit">
                                {{ number_format($grandDebit, 2) }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection
