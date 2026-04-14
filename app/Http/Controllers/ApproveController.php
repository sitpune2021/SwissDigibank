<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsTransactionsHelper;
use App\Models\FdTransaction;
use App\Models\ShareTransfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\FdAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\LoanApplication;
use App\Models\MortgageLoanApplication;
use App\Models\LoanAgainstApplication;
use App\Models\BusinessLoanApplication;
use App\Models\CcOdLoanApplication;
use App\Models\DailyWeeklyApplication;
use App\Models\DdsAccount;
use App\Models\VehicalApplication;
use App\Models\FixedLoanApplication;
use App\Models\MembershipChargeTransaction;
// use Illuminate\Http\Request;
use App\Models\PersonalLoanApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use App\Models\GoldLoanForeClosure;
use App\Models\GoldLoanTransaction;

class ApproveController extends Controller
{

    public function index(Request $request)
    {
        try {

            $perPage = $request->input('perPage', 10);

            Log::info('================ PENDING APPROVAL FETCH START ================');
            Log::info('Step 1: Request Received', [
                'perPage' => $perPage,
                'requested_at' => now()
            ]);


            Log::info('Step 2: Building Saving Transaction Query');

            $transactionQuery = DB::table('transactions')
                ->select(
                    'transactions.id',
                    DB::raw("'transaction' AS source_table"),
                    'transactions.payment_mode',
                    'transactions.amount',
                    'transactions.bank_name',
                    'transactions.approve_status',
                    'transactions.created_at',
                    'branches.branch_name',
                    'accounts.account_no',
                    'accounts.account_type',
                    'accounts.account_holder_type',
                    'accounts.firm_name',
                    'accounts.branch_id',
                    'accounts.member_id',
                    'accounts.account_status',
                    DB::raw("'Saving' AS transaction_type")
                )
                ->join('accounts', 'accounts.id', '=', 'transactions.account_id')
                ->join('branches', 'branches.id', '=', 'accounts.branch_id')
                ->where('transactions.approve_status', '!=', 'approved')
                ->whereNull('transactions.deleted_at');

            Log::info('Saving Transaction Query Built Successfully');

            Log::info('Step 3: Building Membership Charges Query');

            $membershipQuery = DB::table('membership_charges_transaction')
                ->select(
                    'membership_charges_transaction.id',
                    DB::raw("'membership_charges_transaction' AS source_table"),
                    'membership_charges_transaction.charges_pay_mode AS payment_mode',
                    'membership_charges_transaction.membership_fee AS amount',
                    'membership_charges_transaction.cheque_bank_name AS bank_name',
                    'membership_charges_transaction.approve_status',
                    'membership_charges_transaction.created_at',
                    'branches.branch_name',
                    'accounts.account_no',
                    DB::raw("'Share amount' AS account_type"),
                    'accounts.account_holder_type',
                    DB::raw('NULL AS firm_name'),
                    'accounts.branch_id',
                    'accounts.member_id',
                    'accounts.account_status',
                    DB::raw("'Share amount' AS transaction_type")
                )
                ->leftJoin('accounts', 'accounts.id', '=', 'membership_charges_transaction.member_id')
                ->leftJoin('members', 'members.id', '=', 'accounts.member_id')
                ->leftJoin('branches', 'branches.id', '=', 'members.general_branch')
                ->where('membership_charges_transaction.type', '=', 'Share amount')
                ->where('membership_charges_transaction.approve_status', '!=', 1)
                ->whereNull('membership_charges_transaction.deleted_at');

            Log::info('Membership Query Built Successfully');



            Log::info('Step 4: Building Foreclosure Pending Query');

            $foreclosureQuery = DB::table('gold_loan_fore_closures')
                ->select(
                    'gold_loan_fore_closures.id',
                    DB::raw("'gold_loan_fore_closures' AS source_table"),
                    'gold_loan_fore_closures.payment_mode AS payment_mode',
                    'gold_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'gold_loan_fore_closures.status AS approve_status',
                    'gold_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'loan_applications.id AS account_no',
                    DB::raw("'Gold Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join('loan_applications', 'loan_applications.id', '=', 'gold_loan_fore_closures.loan_id')
                ->join('branches', 'branches.id', '=', 'loan_applications.branch_id')
                ->where('gold_loan_fore_closures.status', '=', 0);

            Log::info('Foreclosure Query Built Successfully');


            $misForeclosureQuery = DB::table('misaccounts')
                ->select(
                    'misaccounts.id',
                    DB::raw("'misaccounts' AS source_table"),
                    DB::raw("'Cash' AS payment_mode"),
                    'misaccounts.foreclose_final_amount AS amount',
                    DB::raw("NULL AS bank_name"),
                    'misaccounts.status AS approve_status',
                    DB::raw("COALESCE(misaccounts.foreclose_request_date, misaccounts.created_at) AS created_at"),
                    'branches.branch_name',
                    'misaccounts.mis_account_no AS account_no',
                    DB::raw("'MIS' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'misaccounts.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join('branches', 'branches.id', '=', 'misaccounts.branch_id')
                ->where('misaccounts.status', '=', 1)
                ->where('misaccounts.foreclose_status', '=', 1); // request raised

            $fdForeclosureQuery = DB::table('fd_accounts')
                ->select(
                    'fd_accounts.id',
                    DB::raw("'fd_accounts' AS source_table"),
                    DB::raw("'Cash' AS payment_mode"),
                    'fd_accounts.foreclose_final_amount AS amount',
                    DB::raw("NULL AS bank_name"),
                    'fd_accounts.status AS approve_status',
                    DB::raw("COALESCE(fd_accounts.foreclose_request_date, fd_accounts.created_at) AS created_at"),
                    'branches.branch_name',
                    'fd_accounts.fd_no AS account_no',
                    DB::raw("'FD' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'fd_accounts.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'FD Foreclosure' AS transaction_type")
                )
                ->join('branches', 'branches.id', '=', 'fd_accounts.branch_id')
                ->where('fd_accounts.status', '=', 1)
                ->where('fd_accounts.foreclose_status', '=', 1); // request raised

            $ccOdForeclosureQuery = DB::table('cc_od_loan_fore_closures')
                ->select(
                    'cc_od_loan_fore_closures.id',
                    DB::raw("'cc_od_loan_fore_closures' AS source_table"),
                    'cc_od_loan_fore_closures.payment_mode AS payment_mode',
                    'cc_od_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'cc_od_loan_fore_closures.status AS approve_status',
                    'cc_od_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'cc_od_loan_applications.id AS account_no',
                    DB::raw("'CC / OD Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'cc_od_loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join('cc_od_loan_disbursments', 'cc_od_loan_disbursments.loan_application_id', '=', 'cc_od_loan_fore_closures.loan_id')
                ->join('cc_od_loan_applications', 'cc_od_loan_applications.id', '=', 'cc_od_loan_disbursments.loan_application_id')
                ->join('branches', 'branches.id', '=', 'cc_od_loan_applications.branch_id')
                ->where('cc_od_loan_fore_closures.status', '=', 0);
            /*
        |--------------------------------------------------------------------------
        | 4️⃣ GOLD LOAN EMI QUERY
        |--------------------------------------------------------------------------
        */

            Log::info('Step 5: Building Gold Loan EMI Pending Query');

            $goldLoanEmiQuery = DB::table('gold_loan_transactions')
                ->select(
                    'gold_loan_transactions.id',
                    DB::raw("'gold_loan_transactions' AS source_table"),
                    'gold_loan_transactions.fee_mode AS payment_mode',
                    'gold_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'gold_loan_transactions.status AS approve_status',
                    'gold_loan_transactions.created_at',
                    'branches.branch_name',
                    'loan_applications.id AS account_no',
                    DB::raw("'Gold Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join('loan_applications', 'loan_applications.id', '=', 'gold_loan_transactions.loan_id')
                ->join('branches', 'branches.id', '=', 'loan_applications.branch_id')
                ->where('gold_loan_transactions.status', '=', 'pending');

            Log::info('Gold Loan EMI Query Built Successfully');

            $mortgageEmiQuery = DB::table('mortgage_loan_transactions')
                ->select(
                    'mortgage_loan_transactions.id',
                    DB::raw("'mortgage_loan_transactions' AS source_table"),
                    'mortgage_loan_transactions.fee_mode AS payment_mode',
                    'mortgage_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'mortgage_loan_transactions.status AS approve_status',
                    'mortgage_loan_transactions.created_at',
                    'branches.branch_name',
                    'mortgage_loan_transactions.loan_id AS account_no',
                    DB::raw("'Mortgage Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    DB::raw("NULL AS member_id"),
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join('mortgage_loan_applications', 'mortgage_loan_applications.id', '=', 'mortgage_loan_transactions.loan_id')
                ->join('branches', 'branches.id', '=', 'mortgage_loan_applications.branch_id')
                ->where('mortgage_loan_transactions.status', 'pending');
            Log::info('morgage Loan EMI Query Built Successfully');

            Log::info('Step 4B: Building Mortgage Foreclosure Pending Query');

            $mortgageForeclosureQuery = DB::table('mortgage_loan_fore_closures')
                ->select(
                    'mortgage_loan_fore_closures.id',
                    DB::raw("'mortgage_loan_fore_closures' AS source_table"),
                    'mortgage_loan_fore_closures.payment_mode AS payment_mode',
                    'mortgage_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'mortgage_loan_fore_closures.status AS approve_status',
                    'mortgage_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'mortgage_loan_applications.id AS account_no',
                    DB::raw("'Mortgage Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'mortgage_loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join('mortgage_loan_applications', 'mortgage_loan_applications.id', '=', 'mortgage_loan_fore_closures.loan_id')
                ->join('branches', 'branches.id', '=', 'mortgage_loan_applications.branch_id')
                ->where('mortgage_loan_fore_closures.status', '=', 0);

            Log::info('Mortgage Foreclosure Query Built Successfully');

            Log::info('Step 5B: Building Loan Against EMI Pending Query');

            $loanAgainstEmiQuery = DB::table('loan_against_transactions')
                ->select(
                    'loan_against_transactions.id',
                    DB::raw("'loan_against_transactions' AS source_table"),
                    'loan_against_transactions.fee_mode AS payment_mode',
                    'loan_against_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'loan_against_transactions.status AS approve_status',
                    'loan_against_transactions.created_at',
                    'branches.branch_name',
                    'loan_against_applications.id AS account_no',
                    DB::raw("'Loan Against Deposit' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'loan_against_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join('loan_against_applications', 'loan_against_applications.id', '=', 'loan_against_transactions.loan_id')
                ->join('branches', 'branches.id', '=', 'loan_against_applications.branch_id')
                ->where('loan_against_transactions.status', '=', 'pending');

            Log::info('Loan Against EMI Query Built Successfully');
            Log::info('Step X: Building Loan Against Foreclosure Pending Query');

            $loanAgainstForeclosureQuery = DB::table('loan_against_fore_closures')
                ->select(
                    'loan_against_fore_closures.id',
                    DB::raw("'loan_against_fore_closures' AS source_table"),
                    'loan_against_fore_closures.payment_mode AS payment_mode',
                    'loan_against_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'loan_against_fore_closures.status AS approve_status',
                    'loan_against_fore_closures.created_at',
                    'branches.branch_name',
                    'loan_against_applications.id AS account_no',
                    DB::raw("'Loan Against Deposit' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'loan_against_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join('loan_against_applications', 'loan_against_applications.id', '=', 'loan_against_fore_closures.loan_id')
                ->join('branches', 'branches.id', '=', 'loan_against_applications.branch_id')
                ->where('loan_against_fore_closures.status', '=', 0);

            Log::info('Loan Against Foreclosure Query Built Successfully');

            $businessEmiQuery = DB::table('business_loan_transactions')
                ->select(
                    'business_loan_transactions.id',
                    DB::raw("'business_loan_transactions' AS source_table"),
                    'business_loan_transactions.fee_mode AS payment_mode',
                    'business_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'business_loan_transactions.status AS approve_status',
                    'business_loan_transactions.created_at',
                    'branches.branch_name',
                    'business_loan_transactions.loan_id AS account_no',
                    DB::raw("'Business Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    DB::raw("NULL AS member_id"),
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join(
                    'bussiness_loan_applications',
                    'bussiness_loan_applications.id',
                    '=',
                    'business_loan_transactions.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'bussiness_loan_applications.branch_id'
                )
                ->where('business_loan_transactions.status', 'pending');

            Log::info('Business Loan EMI Query Built Successfully');

            $businessForeclosureQuery = DB::table('business_loan_fore_closures')
                ->select(
                    'business_loan_fore_closures.id',
                    DB::raw("'business_loan_fore_closures' AS source_table"),
                    'business_loan_fore_closures.payment_mode AS payment_mode',
                    'business_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'business_loan_fore_closures.status AS approve_status',
                    'business_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'bussiness_loan_applications.id AS account_no',
                    DB::raw("'Business Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'bussiness_loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join(
                    'bussiness_loan_applications',
                    'bussiness_loan_applications.id',
                    '=',
                    'business_loan_fore_closures.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'bussiness_loan_applications.branch_id'
                )
                ->where('business_loan_fore_closures.status', '=', 0);

            Log::info('Business Loan Foreclosure Query Built Successfully');

            $dailyWeeklyEmiQuery = DB::table('daily_weekly_loan_transactions')
                ->select(
                    'daily_weekly_loan_transactions.id',
                    DB::raw("'daily_weekly_loan_transactions' AS source_table"),
                    'daily_weekly_loan_transactions.fee_mode AS payment_mode',
                    'daily_weekly_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'daily_weekly_loan_transactions.status AS approve_status',
                    'daily_weekly_loan_transactions.created_at',
                    'branches.branch_name',
                    'daily_weekly_loan_transactions.loan_id AS account_no',
                    DB::raw("'Daily Weekly Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    DB::raw("NULL AS member_id"),
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join(
                    'daily_weekly_applications',
                    'daily_weekly_applications.id',
                    '=',
                    'daily_weekly_loan_transactions.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'daily_weekly_applications.branch_id'
                )
                ->where('daily_weekly_loan_transactions.status', 'pending');

            Log::info('Daily Weekly EMI Query Built Successfully');

            $dailyWeeklyForeclosureQuery = DB::table('daily_weekly_loan_fore_closures')
                ->select(
                    'daily_weekly_loan_fore_closures.id',
                    DB::raw("'daily_weekly_loan_fore_closures' AS source_table"),
                    'daily_weekly_loan_fore_closures.payment_mode AS payment_mode',
                    'daily_weekly_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'daily_weekly_loan_fore_closures.status AS approve_status',
                    'daily_weekly_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'daily_weekly_applications.id AS account_no',
                    DB::raw("'Daily Weekly Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'daily_weekly_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join(
                    'daily_weekly_applications',
                    'daily_weekly_applications.id',
                    '=',
                    'daily_weekly_loan_fore_closures.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'daily_weekly_applications.branch_id'
                )
                ->where('daily_weekly_loan_fore_closures.status', '=', 0);

            Log::info('Daily Weekly Foreclosure Query Built Successfully');

            $vehicleEmiQuery = DB::table('vehical_loan_transactions')
                ->select(
                    'vehical_loan_transactions.id',
                    DB::raw("'vehical_loan_transactions' AS source_table"),
                    'vehical_loan_transactions.fee_mode AS payment_mode',
                    'vehical_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'vehical_loan_transactions.status AS approve_status',
                    'vehical_loan_transactions.created_at',
                    'branches.branch_name',
                    'vehical_loan_transactions.loan_id AS account_no',
                    DB::raw("'Vehicle Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    DB::raw("NULL AS member_id"),
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join(
                    'vehical_applications',
                    'vehical_applications.id',
                    '=',
                    'vehical_loan_transactions.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'vehical_applications.branch_id'
                )
                ->where('vehical_loan_transactions.status', 'pending');

            $vehicleForeclosureQuery = DB::table('vehical_loan_fore_closures')
                ->select(
                    'vehical_loan_fore_closures.id',
                    DB::raw("'vehical_loan_fore_closures' AS source_table"),
                    'vehical_loan_fore_closures.payment_mode AS payment_mode',
                    'vehical_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'vehical_loan_fore_closures.status AS approve_status',
                    'vehical_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'vehical_applications.id AS account_no',
                    DB::raw("'Vehicle Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'vehical_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join(
                    'vehical_applications',
                    'vehical_applications.id',
                    '=',
                    'vehical_loan_fore_closures.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'vehical_applications.branch_id'
                )
                ->where('vehical_loan_fore_closures.status', 0);
            Log::info('Building Personal Loan Foreclosure Pending Query');

            $personalForeclosureQuery = DB::table('personal_loan_fore_closures')
                ->select(
                    'personal_loan_fore_closures.id',
                    DB::raw("'personal_loan_fore_closures' AS source_table"),
                    'personal_loan_fore_closures.payment_mode AS payment_mode',
                    'personal_loan_fore_closures.net_amount_k AS amount',
                    DB::raw("NULL AS bank_name"),
                    'personal_loan_fore_closures.status AS approve_status',
                    'personal_loan_fore_closures.created_at',
                    'branches.branch_name',
                    'personal_loan_applications.id AS account_no',
                    DB::raw("'Personal Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'personal_loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'Foreclosure' AS transaction_type")
                )
                ->join(
                    'personal_loan_applications',
                    'personal_loan_applications.id',
                    '=',
                    'personal_loan_fore_closures.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'personal_loan_applications.branch_id'
                )
                ->where('personal_loan_fore_closures.status', '=', 0); // 0 = pending
            Log::info('Building Personal Loan EMI Pending Query');

            $personalLoanEmiQuery = DB::table('personal_loan_transactions')
                ->select(
                    'personal_loan_transactions.id',
                    DB::raw("'personal_loan_transactions' AS source_table"),
                    'personal_loan_transactions.fee_mode AS payment_mode',
                    'personal_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'personal_loan_transactions.status AS approve_status',
                    'personal_loan_transactions.created_at',
                    'branches.branch_name',
                    'personal_loan_applications.id AS account_no',
                    DB::raw("'Personal Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'personal_loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join(
                    'personal_loan_applications',
                    'personal_loan_applications.id',
                    '=',
                    'personal_loan_transactions.loan_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'personal_loan_applications.branch_id'
                )
                ->where('personal_loan_transactions.status', '=', 'pending');


            $fdPrincipalQuery = DB::table('fd_transactions')
                ->select(
                    'fd_transactions.id',
                    DB::raw("'fd_transactions' AS source_table"),
                    'fd_transactions.mode AS payment_mode',
                    'fd_transactions.amount AS amount',
                    DB::raw("NULL AS bank_name"),
                    'fd_transactions.status AS approve_status',
                    'fd_transactions.created_at',
                    'branches.branch_name',
                    'fd_accounts.fd_no AS account_no',
                    DB::raw("'FD Account' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'fd_accounts.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'FD Principal Deposit' AS transaction_type")
                )
                ->join(
                    'fd_accounts',
                    'fd_accounts.id',
                    '=',
                    'fd_transactions.fd_account_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'fd_accounts.branch_id'
                )
                ->where('fd_transactions.transaction_purpose', '=', 'principal')
                ->where('fd_transactions.transaction_type', '=', 1) // credit
                ->where(function ($q) {
                    $q->whereNull('fd_transactions.status')
                        ->orWhere('fd_transactions.status', 'pending');
                });

            Log::info('FD Principal Pending Query');

            $misInitialDepositQuery = DB::table('mis_transactions')
                ->select(
                    'mis_transactions.id',
                    DB::raw("'mis_transactions' AS source_table"),
                    'mis_transactions.pay_mode AS payment_mode',
                    'mis_transactions.amount AS amount',
                    DB::raw("NULL AS bank_name"),
                    'mis_transactions.approve_status AS approve_status',
                    'mis_transactions.created_at',
                    'branches.branch_name',
                    'misaccounts.mis_account_no AS account_no',
                    DB::raw("'MIS Account' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'misaccounts.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'MIS Initial Deposit' AS transaction_type")
                )
                ->join(
                    'misaccounts',
                    'misaccounts.id',
                    '=',
                    'mis_transactions.misaccount_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'misaccounts.branch_id'
                )
                ->where('mis_transactions.remark', '=', 'Initial Deposit')
                ->where(function ($q) {
                    $q->whereNull('mis_transactions.approve_status')
                        ->orWhere('mis_transactions.approve_status', 'pending');
                });

            Log::info('MIS Initial Deposit Pending Query');

            $rdTransactionQuery = DB::table('rd_transactions')
                ->select(
                    'rd_transactions.id',
                    DB::raw("'rd_transactions' AS source_table"),
                    'rd_transactions.payment_mode',
                    'rd_transactions.amount',
                    'rd_transactions.cheque_bank_name AS bank_name',
                    'rd_transactions.status',
                    'rd_transactions.created_at',
                    'branches.branch_name',
                    'rd_accounts.rd_no AS account_no',
                    DB::raw("'RD Account' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'rd_accounts.member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'RD Installment' AS transaction_type")
                )
                ->join(
                    'rd_accounts',
                    'rd_accounts.id',
                    '=',
                    'rd_transactions.rd_account_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'rd_accounts.branch_id'
                )
                ->where('rd_accounts.approve_status', 'approved')
                ->where('rd_transactions.transaction_type', '=', 'credit')
                ->where(function ($q) {
                    $q->whereNull('rd_transactions.status')
                        ->orWhere('rd_transactions.status', 0);
                });

            Log::info('RD Pending Transactions Query');

            $ddTransactionQuery = DB::table('dd_transactions')
                ->select(
                    'dd_transactions.id',
                    DB::raw("'dd_transactions' AS source_table"),
                    'dd_transactions.pay_mode AS payment_mode',
                    'dd_transactions.amount',
                    'dd_transactions.bank_name',
                    DB::raw("NULL AS approve_status"),
                    'dd_transactions.created_at',
                    'branches.branch_name',
                    'dds_accounts.dd_no AS account_no',
                    DB::raw("'DD Account' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'dds_accounts.member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'DD Collection' AS transaction_type")
                )
                ->join(
                    'dds_accounts',
                    'dds_accounts.id',
                    '=',
                    'dd_transactions.dds_account_id'
                )
                ->join(
                    'branches',
                    'branches.id',
                    '=',
                    'dds_accounts.branch_id'
                )
                ->where('dds_accounts.status', 1) // 1 = Approved
                ->where('dd_transactions.status', 0)
                ->whereNull('dd_transactions.deleted_at');

            Log::info('DD Pending Transactions Query');

            // ️UNION ALL
            $ccOdLoanEmiQuery = DB::table('cc_od_loan_transactions')
                ->select(
                    'cc_od_loan_transactions.id',
                    DB::raw("'cc_od_loan_transactions' AS source_table"),
                    'cc_od_loan_transactions.fee_mode AS payment_mode',
                    'cc_od_loan_transactions.amount_collected AS amount',
                    DB::raw("NULL AS bank_name"),
                    'cc_od_loan_transactions.status AS approve_status',
                    'cc_od_loan_transactions.created_at',
                    'branches.branch_name',
                    'cc_od_loan_applications.id AS account_no',
                    DB::raw("'CC / OD Loan' AS account_type"),
                    DB::raw("'-' AS account_holder_type"),
                    DB::raw("NULL AS firm_name"),
                    'branches.id AS branch_id',
                    'cc_od_loan_applications.member_id AS member_id',
                    DB::raw("'Active' AS account_status"),
                    DB::raw("'EMI Payment' AS transaction_type")
                )
                ->join('cc_od_loan_disbursments', 'cc_od_loan_disbursments.loan_application_id', '=', 'cc_od_loan_transactions.loan_id')
                ->join('cc_od_loan_applications', 'cc_od_loan_applications.id', '=', 'cc_od_loan_disbursments.loan_application_id')
                ->join('branches', 'branches.id', '=', 'cc_od_loan_applications.branch_id')
                ->where('cc_od_loan_transactions.status', '=', 'pending');
            Log::info('Step 6: Combining All Queries Using UNION');

            $unionQuery = $transactionQuery
                ->unionAll($membershipQuery)
                ->unionAll($foreclosureQuery)
                ->unionAll($misForeclosureQuery)
                ->unionAll($fdForeclosureQuery)
                ->unionAll($goldLoanEmiQuery)
                ->unionAll($mortgageEmiQuery)
                ->unionAll($loanAgainstEmiQuery)
                ->unionAll($mortgageForeclosureQuery)
                ->unionAll($loanAgainstForeclosureQuery)
                ->unionAll($businessForeclosureQuery)
                ->unionAll($businessEmiQuery)
                ->unionAll($dailyWeeklyEmiQuery)
                ->unionAll($dailyWeeklyForeclosureQuery)
                ->unionAll($vehicleEmiQuery)
                ->unionAll($fdPrincipalQuery)
                ->unionAll($misInitialDepositQuery)
                ->unionAll($rdTransactionQuery)
                ->unionAll($ddTransactionQuery)
                ->unionAll($ccOdLoanEmiQuery)
                ->unionAll($ccOdForeclosureQuery)
                ->unionAll($vehicleForeclosureQuery)
                ->unionAll($personalForeclosureQuery)
                ->unionAll($personalLoanEmiQuery);



            Log::info('Union Created Successfully');

            //  6️⃣ FINAL QUERY
            Log::info('Step 7: Creating Final Combined Query');

            $finalQuery = DB::query()
                ->fromSub($unionQuery, 'combined')
                ->orderByDesc('created_at');

            Log::info('Step 8: Paginating Results');

            $results = $finalQuery->paginate($perPage);

            Log::info('================ FETCH COMPLETED SUCCESSFULLY ================', [
                'total_records' => $results->total(),
                'per_page' => $results->perPage(),
                'current_page' => $results->currentPage()
            ]);

            return view('approvals.pending_transactions', [
                'pending_transactions' => $results
            ]);
        } catch (\Exception $e) {

            Log::error('❌ PENDING TRANSACTION FETCH FAILED', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            dd('Error fetching pending transactions: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Approval Update Called', [
                'id' => $id,
                'source_table' => $request->input('source_table'),
                'status' => $request->input('transaction_status'),
            ]);

            $sourceTable = $request->input('source_table');

            $status = $request->input('transaction_status');
            $remarks = $request->input('remarks');
            $paymentStatus = $request->input('payment_status');

            // NEW Foreclosure Condition
            if ($sourceTable === 'gold_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('gold_loan_fore_closures')
                        ->where('id', $id)
                        ->first();

                    if (!$foreclosure) {
                        return redirect()->back()->with('error', 'Foreclosure record not found.');
                    }

                    DB::table('gold_loan_fore_closures')
                        ->where('id', $id)
                        ->update([
                            'status' => $status === 'approved' ? 1 : 0,
                            'remarks' => $remarks,
                            'updated_at' => now(),
                        ]);

                    // ⭐ EMI auto mark PAID when approved
                    if ($status === 'approved') {

                        DB::table('gold_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now()->format('Y-m-d'),
                                'updated_at' => now()
                            ]);

                        DB::table('loan_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return redirect()->back()->with('success', 'Foreclosure transaction approved successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'mortgage_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('mortgage_loan_fore_closures')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$foreclosure) {
                        DB::rollBack();
                        return back()->with('error', 'Foreclosure record not found.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark foreclosure approved
                        DB::table('mortgage_loan_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 1,
                                'updated_at' => now()
                            ]);



                        // 3️⃣ Mark all EMI as PAID
                        DB::table('mortgage_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 4️⃣ Close loan
                        DB::table('mortgage_loan_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'Mortgage Foreclosure approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'loan_against_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('loan_against_fore_closures')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$foreclosure) {
                        DB::rollBack();
                        return back()->with('error', 'Foreclosure record not found.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark foreclosure approved
                        DB::table('loan_against_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 1,
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Mark all EMI as PAID
                        DB::table('loan_against_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 3️⃣ Close loan
                        DB::table('loan_against_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'Loan Against Foreclosure approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'fd_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('fd_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'FD transaction not found.');
                    }

                    if (strtolower($status) === 'approved') {

                        // Get FD account
                        $fdAccount = DB::table('fd_accounts')
                            ->where('id', $transaction->fd_account_id)
                            ->lockForUpdate()
                            ->first();

                        if (!$fdAccount) {
                            DB::rollBack();
                            return back()->with('error', 'FD Account not found.');
                        }

                        // Approve only if account status = 1
                        if ($fdAccount->status != 1) {
                            DB::rollBack();
                            return back()->with('error', 'FD Account is not in pending state for approval.');
                        }

                        // 1️⃣ Mark transaction approved
                        // DB::table('fd_transactions')
                        //     ->where('id', $id)
                        //     ->update([
                        //         'status' => 'Approved',
                        //         'processed' => 1,
                        //         'paid_on' => now(),
                        //         'updated_at' => now()
                        //     ]);
                         DB::table('fd_transactions')
                            ->where('id', $id)
                            ->where('processed', 0)
                            ->update([
                                'status' => 'Approved',
                                'processed' => 1,
                                'paid_on' => now(),
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'FD principal transaction approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();

                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'mis_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('mis_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'MIS transaction not found.');
                    }

                    // Only allow approval for Initial Deposit
                    if ($transaction->remark !== 'Initial Deposit') {
                        DB::rollBack();
                        return back()->with('error', 'Only Initial Deposit transactions can be approved.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Approve transaction
                        DB::table('mis_transactions')
                            ->where('id', $id)
                            ->update([
                                'approve_status' => 'approved',
                                'processed' => 1,
                                'status' => 'Paid',
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'MIS Initial Deposit approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();

                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'rd_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('rd_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'RD transaction not found.');
                    }

                    // Optional: Only allow approval for CREDIT transactions
                    if ($transaction->transaction_type !== 'credit') {
                        DB::rollBack();
                        return back()->with('error', 'Only credit transactions can be approved.');
                    }

                    if ($status === 'approved') {

                        DB::table('rd_transactions')
                            ->where('id', $id)
                            ->update([
                                'status'         => 1,
                                'paid_on'        => now(),
                                'updated_at'     => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'RD transaction approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();

                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'dd_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('dd_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'DD transaction not found.');
                    }

                    // Prevent double approval
                    if ($transaction->status === 1) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction already approved.');
                    }

                    //Only allow credit entries
                    if ($transaction->type !== 'credit') {
                        DB::rollBack();
                        return back()->with('error', 'Only credit transactions can be approved.');
                    }

                    if ($status === 'approved') {

                        // Update transaction
                        DB::table('dd_transactions')
                            ->where('id', $id)
                            ->update([
                                'status'     => 1, // if you have this column
                                'updated_at' => now()
                            ]);

                        // Update DD account balance
                        DB::table('dds_accounts')
                            ->where('id', $transaction->dds_account_id)
                            ->increment('balance', $transaction->amount);

                        // Update paid installments
                        DB::table('dds_accounts')
                            ->where('id', $transaction->dds_account_id)
                            ->increment('paid_installments', 1);
                    }

                    DB::commit();

                    return back()->with('success', 'DD transaction approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();

                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'misaccounts') {

                DB::beginTransaction();

                try {

                    $mis = DB::table('misaccounts')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$mis) {
                        DB::rollBack();
                        return back()->with('error', 'MIS account not found.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Approve foreclosure request
                        DB::table('misaccounts')
                            ->where('id', $id)
                            ->update([
                                'foreclose_status' => 2, // approved
                                'status' => 3, // closed
                                'closing_date' => now(),
                                'updated_at' => now()
                            ]);
                    }

                    if ($status === 'disapproved') {

                        DB::table('misaccounts')
                            ->where('id', $id)
                            ->update([
                                'foreclose_status' => 3, // rejected
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'MIS Foreclosure updated successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'fd_accounts') { // fore close

                DB::beginTransaction();

                try {

                    $fd = DB::table('fd_accounts')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$fd) {
                        DB::rollBack();
                        return back()->with('error', 'FD account not found.');
                    }

                    if ($status === 'approved') {

                        DB::table('fd_accounts')
                            ->where('id', $id)
                            ->update([
                                'foreclose_status' => 2, // approved
                                'status' => 3, // closed
                                'close_date' => now(),
                                'updated_at' => now()
                            ]);
                    }

                    if ($status === 'disapproved') {

                        DB::table('fd_accounts')
                            ->where('id', $id)
                            ->update([
                                'foreclose_status' => 3, // rejected
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'FD Foreclosure updated successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'business_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('business_loan_fore_closures')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$foreclosure) {
                        DB::rollBack();
                        return back()->with('error', 'Business Loan Foreclosure record not found.');
                    }

                    if ($status === 'approved') {

                        Log::info('Approving Business Loan Foreclosure', [
                            'foreclosure_id' => $id,
                            'loan_id' => $foreclosure->loan_id
                        ]);

                        // 1️⃣ Mark foreclosure approved
                        DB::table('business_loan_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 1,
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Mark all EMI as PAID
                        DB::table('business_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 3️⃣ Close Business Loan
                        DB::table('bussiness_loan_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2, // Closed
                                'updated_at' => now()
                            ]);

                        Log::info('Business Loan Foreclosure Approved Successfully');
                    }

                    DB::commit();

                    return back()->with('success', 'Business Loan Foreclosure approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();

                    Log::error('Business Loan Foreclosure Approval Failed', [
                        'error' => $e->getMessage()
                    ]);

                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'daily_weekly_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('daily_weekly_loan_fore_closures')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$foreclosure) {
                        DB::rollBack();
                        return back()->with('error', 'Daily Weekly Foreclosure record not found.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark foreclosure approved
                        DB::table('daily_weekly_loan_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 1,
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Mark all EMI as PAID
                        DB::table('daily_weekly_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 3️⃣ Close Loan
                        DB::table('daily_weekly_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'Daily Weekly Foreclosure approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'vehical_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('vehical_loan_fore_closures')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$foreclosure) {
                        DB::rollBack();
                        return back()->with('error', 'Vehicle Loan Foreclosure not found.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Approve Foreclosure
                        DB::table('vehical_loan_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 1,
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Mark All EMI Paid
                        DB::table('vehical_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 3️⃣ Close Loan
                        DB::table('vehical_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();
                    return back()->with('success', 'Vehicle Loan Foreclosure approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'personal_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('personal_loan_fore_closures')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$foreclosure) {
                        DB::rollBack();
                        return back()->with('error', 'Foreclosure record not found.');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Update foreclosure status
                        DB::table('personal_loan_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 1,
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Mark all EMI as PAID
                        DB::table('personal_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 3️⃣ Close loan
                        DB::table('personal_loan_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2, // Closed
                                'updated_at' => now()
                            ]);
                    } elseif ($status === 'disapproved') {

                        DB::table('personal_loan_fore_closures')
                            ->where('id', $id)
                            ->update([
                                'status' => 0,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'Personal Loan Foreclosure updated successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'cc_od_loan_fore_closures') {

                DB::beginTransaction();

                try {

                    $foreclosure = DB::table('cc_od_loan_fore_closures')
                        ->where('id', $id)
                        ->first();

                    if (!$foreclosure) {
                        return back()->with('error', 'Foreclosure record not found.');
                    }

                    DB::table('cc_od_loan_fore_closures')
                        ->where('id', $id)
                        ->update([
                            'status' => $status === 'approved' ? 1 : 0,
                            'remarks' => $remarks,
                            'updated_at' => now(),
                        ]);

                    if ($status === 'approved') {

                        DB::table('cc_od_loan_emi_status')
                            ->where('loan_id', $foreclosure->loan_id)
                            ->update([
                                'status' => 'PAID',
                                'remaining_amount' => 0,
                                'paid_date' => now()->format('Y-m-d'),
                                'updated_at' => now()
                            ]);

                        DB::table('cc_od_loan_applications')
                            ->where('id', $foreclosure->loan_id)
                            ->update([
                                'status' => 2,
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return back()->with('success', 'CC / OD Foreclosure approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            }


            if ($sourceTable === 'transaction') {

                $transaction = Transaction::with('accounts.members')->findOrFail($id);

                $transaction->approve_status = $status;
                $transaction->remarks = $remarks;
                $transaction->payment_rev_rel = $paymentStatus;

                if (strtolower($transaction->payment_mode) === 'online') {
                    $transaction->bank_name = $request->input('bank_account_id');
                }

                if ($transaction->save()) {
                    $mobile = $transaction->accounts->members->member_info_mobile_no ?? '';
                    $AccountNo = $transaction->accounts->account_no;
                    $type = $transaction->transaction_type;
                    $amount = $transaction->amount;
                    $account_id = $transaction->accounts->id;
                    $updated_balances = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec([$account_id]);
                    $available_balance = $updated_balances['total_balance'];
                    $date = $transaction->transaction_date;

                    $dlttemplateid = '1707172234108850512';
                    $message = "Dear Customer, your Account $AccountNo has been $type with INR $amount on $date. The Available Balance is INR $available_balance. SBC GLOBAL";
                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                    $Account = $transaction;
                    $member = $transaction->accounts->members;

                    if (!empty($member->member_info_email)) {

                        if ($transaction->transaction_type === 'debit') {
                            $pdf = Pdf::loadView('emails.saving_account_withdraw', compact('member', 'Account', 'available_balance'));
                            $pdfPath = storage_path('app/public/account_details_' .  $Account->id . '.pdf');
                            $pdf->save($pdfPath);
                            // MONEY WITHDRAWN
                            Mail::to($member->member_info_email)->send(
                                new \App\Mail\AccountWithdrawMail($member, $Account, $pdfPath)

                            );
                        } elseif ($transaction->transaction_type === 'credit') {

                            $pdf = Pdf::loadView('emails.saving_account_deposit', compact('member', 'Account', 'available_balance'));
                            $pdfPath = storage_path('app/public/account_details_' .  $Account->id . '.pdf');
                            $pdf->save($pdfPath);

                            // MONEY DEPOSITED
                            Mail::to($member->member_info_email)->send(
                                new \App\Mail\AccountDepositMail($member, $Account, $pdfPath)
                            );
                        }
                    } else {
                        Log::warning('No email found for member', ['member_id' => $member->id]);
                    }
                    return redirect()->back()->with('success', 'Saving transaction approved successfully.');
                }
            } elseif ($sourceTable === 'membership_charges_transaction') {

                $updated = DB::table('membership_charges_transaction')
                    ->where('id', $id)
                    ->update([
                        'approve_status' => 1,
                        'updated_at' => now(),
                    ]);

                if ($updated) {
                    return redirect()->back()->with('success', 'Membership Share Amount approved successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to update Membership Share Amount.');
                }
            } elseif ($sourceTable === 'gold_loan_transactions') {

                DB::beginTransaction();

                try {

                    $emi = DB::table('gold_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$emi) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction not found');
                    }

                    if ($status === 'approved') {

                        // ✅ 1️⃣ Mark transaction as paid
                        DB::table('gold_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 🔥 FULL PAYMENT CASE (emi_no NULL)
                        if (is_null($emi->emi_no) && $emi->flag === 'full_payment') {

                            DB::table('gold_loan_emi_status')
                                ->where('loan_id', $emi->loan_id)
                                ->update([
                                    'status' => 'PAID',
                                    'remaining_amount' => 0,
                                    'paid_date' => now()->format('Y-m-d'),
                                    'updated_at' => now()
                                ]);

                            DB::table('loan_applications')
                                ->where('id', $emi->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);

                            DB::commit();
                            return redirect()->back()->with('success', 'Loan fully closed successfully.');
                        }

                        // ✅ NORMAL EMI PAYMENT CASE
                        $emiStatus = DB::table('gold_loan_emi_status')
                            ->where('loan_id', $emi->loan_id)
                            ->where('emi_no', $emi->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $amountCollected = round($emi->amount_collected, 2);
                            $currentRemaining = round($emiStatus->remaining_amount, 2);

                            $newRemaining = round($currentRemaining - $amountCollected, 2);

                            if ($newRemaining <= 0) {

                                DB::table('gold_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PAID',
                                        'remaining_amount' => 0,
                                        'paid_date' => now()->format('Y-m-d'),
                                        'updated_at' => now()
                                    ]);
                            } else {

                                DB::table('gold_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PARTIAL',
                                        'remaining_amount' => $newRemaining,
                                        'paid_date' => now()->format('Y-m-d'),
                                        'updated_at' => now()
                                    ]);
                            }
                        }

                        // ✅ CHECK LOAN CLOSE CONDITION
                        $totalRemaining = DB::table('gold_loan_emi_status')
                            ->where('loan_id', $emi->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {

                            DB::table('loan_applications')
                                ->where('id', $emi->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }
                    } elseif ($status === 'disapproved') {

                        DB::table('gold_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'rejected',
                                'updated_at' => now()
                            ]);
                    }

                    DB::commit();

                    return redirect()->back()->with('success', 'Gold Loan EMI updated successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'mortgage_loan_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('mortgage_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction not found');
                    }

                    // ==============================
                    // ✅ APPROVE CASE
                    // ==============================
                    if ($status === 'approved') {

                        // 1️⃣ Mark transaction as paid
                        DB::table('mortgage_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 🔥 FULL PAYMENT CASE
                        if (is_null($transaction->emi_no) && $transaction->flag === 'full_payment') {

                            DB::table('mortgage_loan_emi_status')
                                ->where('loan_id', $transaction->loan_id)
                                ->update([
                                    'status' => 'PAID',
                                    'remaining_amount' => 0,
                                    'paid_date' => now(),
                                    'updated_at' => now()
                                ]);

                            DB::table('mortgage_loan_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2, // CLOSED
                                    'updated_at' => now()
                                ]);

                            DB::commit();
                            return back()->with('success', 'Mortgage Loan fully closed successfully.');
                        }

                        // ✅ NORMAL EMI PAYMENT CASE
                        $emiStatus = DB::table('mortgage_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->where('emi_no', $transaction->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $paidAmount = round($transaction->amount_collected, 2);
                            $currentRemaining = round($emiStatus->remaining_amount, 2);

                            $newRemaining = round($currentRemaining - $paidAmount, 2);

                            if ($newRemaining <= 0) {

                                DB::table('mortgage_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PAID',
                                        'remaining_amount' => 0,
                                        'paid_date' => now(),
                                        'updated_at' => now()
                                    ]);
                            } else {

                                DB::table('mortgage_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PARTIAL',
                                        'remaining_amount' => $newRemaining,
                                        'updated_at' => now()
                                    ]);
                            }
                        }

                        // 3️⃣ Auto Close Loan If All EMI Paid
                        $totalRemaining = DB::table('mortgage_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {

                            DB::table('mortgage_loan_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }

                        DB::commit();
                        return back()->with('success', 'Mortgage EMI approved successfully.');
                    }


                    // ==============================
                    // ❌ DISAPPROVE
                    // ==============================
                    if ($status === 'disapproved') {

                        DB::table('mortgage_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'rejected',
                                'updated_at' => now()
                            ]);

                        DB::commit();
                        return back()->with('success', 'Mortgage EMI rejected.');
                    }
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'loan_against_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('loan_against_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction not found');
                    }

                    if ($status === 'approved') {

                        DB::table('loan_against_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 🔥 Update EMI STATUS TABLE
                        $emiStatus = DB::table('loan_against_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->where('emi_no', $transaction->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $paidAmount = round($transaction->amount_collected, 2);
                            $currentRemaining = round($emiStatus->remaining_amount, 2);

                            $newRemaining = round($currentRemaining - $paidAmount, 2);

                            if ($newRemaining <= 0) {

                                DB::table('loan_against_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PAID',
                                        'remaining_amount' => 0,
                                        'paid_date' => now(),
                                        'updated_at' => now()
                                    ]);
                            } else {

                                DB::table('loan_against_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PARTIAL',
                                        'remaining_amount' => $newRemaining,
                                        'updated_at' => now()
                                    ]);
                            }
                        }

                        DB::commit();
                        return back()->with('success', 'Loan Against EMI approved successfully.');
                    }

                    if ($status === 'disapproved') {

                        DB::table('loan_against_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'rejected',
                                'updated_at' => now()
                            ]);

                        DB::commit();
                        return back()->with('success', 'Loan Against EMI rejected.');
                    }
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'business_loan_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('business_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'Business Loan transaction not found');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark Transaction Paid
                        DB::table('business_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 🔥 FULL PAYMENT CASE
                        if ($transaction->flag === 'full_payment') {

                            DB::table('business_loan_emi_status')
                                ->where('loan_id', $transaction->loan_id)
                                ->update([
                                    'status' => 'PAID',
                                    'remaining_amount' => 0,
                                    'paid_date' => now(),
                                    'updated_at' => now()
                                ]);

                            DB::table('bussiness_loan_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2, // CLOSED
                                    'updated_at' => now()
                                ]);

                            DB::commit();
                            return back()->with('success', 'Business Loan fully closed successfully.');
                        }

                        // ✅ NORMAL EMI PAYMENT
                        $emiStatus = DB::table('business_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->where('emi_no', $transaction->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {
                            $paidAmount = round($transaction->amount_collected, 2);
                            $currentRemaining = round($emiStatus->remaining_amount, 2);

                            // Safety check
                            if ($paidAmount >= $currentRemaining) {

                                $newRemaining = 0;

                                DB::table('business_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PAID',
                                        'remaining_amount' => 0,
                                        'paid_date' => now(),
                                        'updated_at' => now()
                                    ]);
                            } else {

                                $newRemaining = round($currentRemaining - $paidAmount, 2);

                                DB::table('business_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PARTIAL',
                                        'remaining_amount' => $newRemaining,
                                        'updated_at' => now()
                                    ]);
                            }
                        }
                        // 🔄 AUTO CLOSE CHECK
                        $totalRemaining = DB::table('business_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {

                            DB::table('bussiness_loan_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }

                        DB::commit();
                        return back()->with('success', 'Business Loan EMI approved successfully.');
                    }

                    if ($status === 'disapproved') {

                        DB::table('business_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'rejected',
                                'updated_at' => now()
                            ]);

                        DB::commit();
                        return back()->with('success', 'Business Loan EMI rejected.');
                    }
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'daily_weekly_loan_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('daily_weekly_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'Daily Weekly transaction not found');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark Transaction Paid
                        DB::table('daily_weekly_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 🔥 FULL PAYMENT CASE
                        if (is_null($transaction->emi_no) && $transaction->flag === 'full_payment') {

                            DB::table('daily_weekly_loan_emi_status')
                                ->where('loan_id', $transaction->loan_id)
                                ->update([
                                    'status' => 'PAID',
                                    'remaining_amount' => 0,
                                    'paid_date' => now(),
                                    'updated_at' => now()
                                ]);

                            DB::table('daily_weekly_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);

                            DB::commit();
                            return back()->with('success', 'Daily Weekly Loan fully closed successfully.');
                        }

                        // ✅ NORMAL EMI PAYMENT
                        $emiStatus = DB::table('daily_weekly_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->where('emi_no', $transaction->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $paidAmount = round($transaction->amount_collected, 2);
                            $currentRemaining = round($emiStatus->remaining_amount, 2);

                            if ($paidAmount >= $currentRemaining) {

                                DB::table('daily_weekly_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PAID',
                                        'remaining_amount' => 0,
                                        'paid_date' => now(),
                                        'updated_at' => now()
                                    ]);
                            } else {

                                $newRemaining = round($currentRemaining - $paidAmount, 2);

                                DB::table('daily_weekly_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PARTIAL',
                                        'remaining_amount' => $newRemaining,
                                        'updated_at' => now()
                                    ]);
                            }
                        }

                        // 🔄 AUTO CLOSE CHECK
                        $totalRemaining = DB::table('daily_weekly_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {

                            DB::table('daily_weekly_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }

                        DB::commit();
                        return back()->with('success', 'Daily Weekly EMI approved successfully.');
                    }

                    if ($status === 'disapproved') {

                        DB::table('daily_weekly_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'rejected',
                                'updated_at' => now()
                            ]);

                        DB::commit();
                        return back()->with('success', 'Daily Weekly EMI rejected.');
                    }
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'vehical_loan_transactions') {

                DB::beginTransaction();

                try {

                    $transaction = DB::table('vehical_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$transaction) {
                        DB::rollBack();
                        return back()->with('error', 'Vehicle transaction not found');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark EMI Paid
                        DB::table('vehical_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Update EMI Status
                        $emiStatus = DB::table('vehical_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->where('emi_no', $transaction->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $paidAmount = round($transaction->amount_collected, 2);
                            $remaining = round($emiStatus->remaining_amount, 2);

                            if ($paidAmount >= $remaining) {

                                DB::table('vehical_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PAID',
                                        'remaining_amount' => 0,
                                        'paid_date' => now(),
                                        'updated_at' => now()
                                    ]);
                            } else {

                                DB::table('vehical_loan_emi_status')
                                    ->where('id', $emiStatus->id)
                                    ->update([
                                        'status' => 'PARTIAL',
                                        'remaining_amount' => $remaining - $paidAmount,
                                        'updated_at' => now()
                                    ]);
                            }
                        }

                        // 3️⃣ Auto Close Loan
                        $totalRemaining = DB::table('vehical_loan_emi_status')
                            ->where('loan_id', $transaction->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {

                            DB::table('vehical_applications')
                                ->where('id', $transaction->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }

                        DB::commit();
                        return back()->with('success', 'Vehicle EMI approved successfully.');
                    }

                    if ($status === 'disapproved') {

                        DB::table('vehical_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'rejected',
                                'updated_at' => now()
                            ]);

                        DB::commit();
                        return back()->with('success', 'Vehicle EMI rejected.');
                    }
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'personal_loan_transactions') {

                DB::beginTransaction();

                try {

                    $emi = DB::table('personal_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$emi) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction not found');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark transaction paid
                        DB::table('personal_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Update EMI status
                        $emiStatus = DB::table('personal_loan_emi_status')
                            ->where('loan_id', $emi->loan_id)
                            ->where('emi_no', $emi->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $newRemaining = round(
                                $emiStatus->remaining_amount - $emi->amount_collected,
                                2
                            );

                            DB::table('personal_loan_emi_status')
                                ->where('id', $emiStatus->id)
                                ->update([
                                    'status' => $newRemaining <= 0 ? 'PAID' : 'PARTIAL',
                                    'remaining_amount' => $newRemaining <= 0 ? 0 : $newRemaining,
                                    'paid_date' => now()->format('Y-m-d'),
                                    'updated_at' => now()
                                ]);
                        }

                        // 3️⃣ Close loan if no remaining
                        $totalRemaining = DB::table('personal_loan_emi_status')
                            ->where('loan_id', $emi->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {
                            DB::table('personal_loan_applications')
                                ->where('id', $emi->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }
                    }

                    DB::commit();

                    return back()->with('success', 'Personal Loan EMI approved successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } elseif ($sourceTable === 'cc_od_loan_transactions') {

                DB::beginTransaction();

                try {

                    $emi = DB::table('cc_od_loan_transactions')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();

                    if (!$emi) {
                        DB::rollBack();
                        return back()->with('error', 'Transaction not found');
                    }

                    if ($status === 'approved') {

                        // 1️⃣ Mark transaction paid
                        DB::table('cc_od_loan_transactions')
                            ->where('id', $id)
                            ->update([
                                'status' => 'paid',
                                'paid_date' => now(),
                                'updated_at' => now()
                            ]);

                        // 2️⃣ Update EMI status
                        $emiStatus = DB::table('cc_od_loan_emi_status')
                            ->where('loan_id', $emi->loan_id)
                            ->where('emi_no', $emi->emi_no)
                            ->lockForUpdate()
                            ->first();

                        if ($emiStatus) {

                            $newRemaining = round(
                                $emiStatus->remaining_amount - $emi->amount_collected,
                                2
                            );

                            DB::table('cc_od_loan_emi_status')
                                ->where('id', $emiStatus->id)
                                ->update([
                                    'status' => $newRemaining <= 0 ? 'PAID' : 'PARTIAL',
                                    'remaining_amount' => $newRemaining <= 0 ? 0 : $newRemaining,
                                    'paid_date' => now()->format('Y-m-d'),
                                    'updated_at' => now()
                                ]);
                        }

                        // 3️⃣ Close loan if fully paid
                        $totalRemaining = DB::table('cc_od_loan_emi_status')
                            ->where('loan_id', $emi->loan_id)
                            ->whereIn('status', ['DUE', 'PARTIAL', 'UNPAID'])
                            ->sum('remaining_amount');

                        if ($totalRemaining <= 0) {

                            DB::table('cc_od_loan_applications')
                                ->where('id', $emi->loan_id)
                                ->update([
                                    'status' => 2,
                                    'updated_at' => now()
                                ]);
                        }
                    }

                    DB::commit();

                    return back()->with('success', 'CC / OD EMI approved successfully.');
                } catch (\Exception $e) {

                    DB::rollBack();
                    return back()->with('error', $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Invalid source table specified.');
            }
        } catch (\Exception $e) {
            dd('Error updating status: ' . $e->getMessage());
        }
    }

    // Approve account status
    public function updateAccountStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'transaction_status' => 'required|in:0,1,2',
                'remarks' => 'nullable|string|max:255',
                'source_table' => 'required|in:accounts,fd_accounts,misaccounts,rd_accounts,dds_accounts',
            ]);

            if ($validated['source_table'] === 'accounts') {
                // 🔹 For normal accounts
                $account = Account::findOrFail($id);
                $account->approve_status = $validated['transaction_status'];
                $account->remarks = $validated['remarks'];
                $account->save();

                try {
                    $Account = Account::with('members', 'branch')->find($account->id);
                    $mobile = $Account->members->member_info_mobile_no;
                    $accountNo = $Account->account_no;

                    $member = $Account->members;

                    if ($account->approve_status == "1") {
                        $dlttemplateid = 1707172234095362675;
                        $message = "Dear Customer, congratulations! your saving a/c $accountNo is approved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                        $pdf = Pdf::loadView('emails.saving_account_open', compact('member', 'Account'));
                        $pdfPath = storage_path('app/public/account_details_' .  $Account->id . '.pdf');
                        $pdf->save($pdfPath);

                        // ✅ 3. Send Email with PDF
                        if (!empty($member->member_info_email)) {
                            Mail::to($member->member_info_email)->send(new \App\Mail\AccountOpenedMail($member, $Account, $pdfPath));
                        } else {
                            Log::warning('No email found for member', ['member_id' => $member->id]);
                        }

                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        $dlttemplateid = 1707172234098348936;
                        $message = "Dear Customer, your saving a/c $accountNo is disapproved. Please contact branch for details. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
                }

                Log::info('Account status updated', [
                    'table' => 'accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'fd_accounts') {
                // 🔹 For FD accounts
                $fdAccount = FdAccount::findOrFail($id);
                $fdAccount->status = $validated['transaction_status'];
                $fdAccount->remarks = $validated['remarks'];
                $fdAccount->save();


                try {
                    $fdaccount = \App\Models\FdAccount::with('member')->find($fdAccount->id);
                    $mobile = $fdaccount->member->member_info_mobile_no;
                    $account = $fdaccount->fd_no;

                    if ($fdaccount->status == 1) {
                        $dlttemplateid = 1707172234113442938;
                        $message = "Congratulations! Your FD no $account is approved. SBC GLOBAL";
                    } elseif ($fdaccount->status == 2) {
                        $dlttemplateid = 1707172234115386436;
                        $message = "Dear Customer, your FD no $account is disapproved. SBC GLOBAL";
                    }

                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                    if ($fdaccount->status == 1) {
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
                }

                Log::info('FD Account status updated', [
                    'table' => 'fd_accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'misaccounts') {
                // 🔹 MIS Accounts
                $misAccount = \App\Models\Misaccount::findOrFail($id);
                $misAccount->status = $validated['transaction_status'];
                $misAccount->remarks = $validated['remarks'];
                $misAccount->save();

                try {
                    $mis_account = \App\Models\Misaccount::with('member')->find($misAccount->member_id);
                    $mobile = $mis_account->member->member_info_mobile_no;
                    $misAccountNo = $misAccount->mis_account_no;

                    if ($misAccount->status == 1) {
                        $dlttemplateid = 1707172234273006430;
                        $message = "Congratulations! your MIS no $misAccountNo is approved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        $dlttemplateid = 1707172234274327934;
                        $message = "Dear Customer, your MIS no $misAccountNo is disapproved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS for MIS Account', ['error' => $e->getMessage()]);
                }

                Log::info('MIS Account status updated', [
                    'table' => 'misaccounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'rd_accounts') {
                // 🔹 RD Accounts
                $rdAccount = \App\Models\RdAccount::findOrFail($id);
                $status = $validated['transaction_status'] == 1 ? 'Approved' : 'Disapproved';
                $rdAccount->approve_status = $status;
                $rdAccount->remarks = $validated['remarks'];
                $rdAccount->save();

                try {
                    $member = \App\Models\Member::find($rdAccount->member_id);
                    $dlttemplateid = 1707172234135070517;
                    $mobile = $member->member_info_mobile_no;
                    $rdAccountNo = $rdAccount->rd_no;
                    $message = "Congratulations! your RD no. $rdAccountNo is approved. SBC GLOBAL";
                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                    if ($rdAccount->approve_status == 'Approved') {
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS for RD Account', ['error' => $e->getMessage()]);
                }

                Log::info('RD Account status updated', [
                    'table' => 'rd_accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'dds_accounts') {
                // 🔹 DDS Accounts (✅ Corrected Section)
                $ddsAccount = \App\Models\DdsAccount::findOrFail($id);
                $ddsAccount->status = (int) $validated['transaction_status'];
                $ddsAccount->remarks = $validated['remarks'];
                $ddsAccount->save();

                try {
                    $mobile = $ddsAccount->member_mobile;
                    $accountNo = $ddsAccount->dd_no;

                    if (!$mobile) {
                        Log::warning("Mobile number missing for DDS account ID: {$ddsAccount->id}");
                        return redirect()->back()->with('error', 'Mobile number missing. SMS not sent.');
                    }

                    if ($ddsAccount->status == 1) {
                        // ✅ Approved Message
                        $dlttemplateid = '1707172234296835518';
                        $message = "Congratulations! your DD no. $accountNo is approved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('success', 'DDS Account approved successfully.');
                    } elseif ($ddsAccount->status == 2) {
                        // ❌ Disapproved Message
                        $dlttemplateid = '1707172234298099036';
                        $message = "Dear Customer, your DD no. $accountNo is disapproved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('error', 'DDS Account disapproved.');
                    } else {
                        return redirect()->back()->with('info', 'DDS Account status updated but no SMS sent.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS for DDS Account', ['error' => $e->getMessage()]);
                    return redirect()->back()->with('error', 'Something went wrong while sending SMS.');
                }

                Log::info('DDS Account status updated', [
                    'table' => 'dds_accounts',
                    'id' => $ddsAccount->id,
                    'new_status' => $ddsAccount->status,
                    'remarks' => $ddsAccount->remarks,
                    'updated_by' => Auth::id(),
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Account not found', [
                'id' => $id,
                'source_table' => $request->input('source_table'),
                'updated_by' => Auth::id(),
            ]);
            abort(404);
        } catch (\Exception $e) {
            Log::error('Error updating account status', [
                'message' => $e->getMessage(),
                'id' => $id,
                'request' => $request->all(),
                'updated_by' => Auth::id(),
            ]);
            return redirect()->back()->withErrors(['error' => 'Something went wrong while updating account status.']);
        }
    }

    public function approveAccounts(Request $request)
    {
        // Log incoming request
        Log::info("approveAccounts() called", [
            'request_data' => $request->all()
        ]);

        try {

            $search = $request->input('search');
            $perPage = $request->input('perPage', 10);

            Log::info("approveAccounts() - Parameters", [
                'search'  => $search,
                'perPage' => $perPage
            ]);

            // Main SQL
            $sql = "
        SELECT 
            accounts.id,
            accounts.account_no,
            accounts.account_type,
            accounts.firm_name,
            accounts.amount_deposit,
            accounts.payment_mode,
            accounts.account_holder_type,
            accounts.mode_of_operation,
            accounts.approve_status,
            accounts.open_date,
            accounts.branch_id,
            accounts.member_id,
            JSON_OBJECT(
                'id', members.id,
                'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
            JSON_OBJECT(
                'branch_name', branches.branch_name
            ) AS branch,
            'accounts' AS source_table,
            accounts.created_at
        FROM accounts
        INNER JOIN branches ON accounts.branch_id = branches.id
        INNER JOIN members ON accounts.member_id = members.id
        WHERE accounts.account_type IN ('SAVING', 'CURRENT', 'RD', 'MIS')
        AND accounts.approve_status = '0'

        UNION ALL

        SELECT 
            fd_accounts.id,
            fd_accounts.account_no AS account_no,
            'FD' AS account_type,
            NULL,
            fd_accounts.fd_amount AS amount_deposit,
            fd_accounts.payment_mode,
            fd_accounts.account_holder_type,
            fd_accounts.mode_of_operation,
            fd_accounts.status AS approve_status,
            fd_accounts.open_date,
            fd_accounts.branch_id,
            fd_accounts.member_id,
            JSON_OBJECT(
                'id', members.id,
                'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
            JSON_OBJECT(
                'branch_name', branches.branch_name
            ) AS branch,
            'fd_accounts' AS source_table,
            fd_accounts.created_at
        FROM fd_accounts
        INNER JOIN branches ON fd_accounts.branch_id = branches.id
        INNER JOIN members ON fd_accounts.member_id = members.id
        WHERE fd_accounts.status = '0'

        UNION ALL

        SELECT 
            misaccounts.id,
            misaccounts.mis_account_no AS account_no,
            'MIS' AS account_type,
            NULL AS firm_name,
            misaccounts.mis_amount AS amount_deposit,
            NULL AS payment_mode,
            NULL AS account_holder_type,
            NULL AS mode_of_operation,
            misaccounts.status AS approve_status,
            misaccounts.open_date,
            misaccounts.branch_id,
            misaccounts.member_id,
            JSON_OBJECT(
                'id', members.id,
                'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
            JSON_OBJECT(
                'branch_name', branches.branch_name
            ) AS branch,
            'misaccounts' AS source_table,
            misaccounts.created_at
        FROM misaccounts
        INNER JOIN branches ON misaccounts.branch_id = branches.id
        INNER JOIN members ON misaccounts.member_id = members.id
        WHERE misaccounts.status = '0'

        UNION ALL

        SELECT 
            rd_accounts.id,
            rd_accounts.rd_no AS account_no,
            'RD' AS account_type,
            NULL AS firm_name,
            rd_accounts.rd_amount AS amount_deposit,
            NULL AS payment_mode,
            NULL AS account_holder_type,
            NULL AS mode_of_operation,
            rd_accounts.approve_status AS approve_status,
            rd_accounts.open_date,
            rd_accounts.branch_id,
            rd_accounts.member_id,
            JSON_OBJECT(
                'id', members.id,
                'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
            JSON_OBJECT(
                'branch_name', branches.branch_name
            ) AS branch,
            'rd_accounts' AS source_table,
            rd_accounts.created_at
        FROM rd_accounts
        INNER JOIN branches ON rd_accounts.branch_id = branches.id
        INNER JOIN members ON rd_accounts.member_id = members.id
        WHERE rd_accounts.approve_status = 'Pending'

        UNION ALL

        SELECT
            dds_accounts.id,
            dds_accounts.dd_no AS account_no,
            'DDS' AS account_type,
            NULL AS firm_name,
            dds_accounts.dd_amount AS amount_deposit,
            NULL AS payment_mode,
            NULL AS account_holder_type,
            NULL AS mode_of_operation,
            dds_accounts.status AS approve_status,
            dds_accounts.open_date,
            dds_accounts.branch_id,
            dds_accounts.member_id,
            JSON_OBJECT(
                'id', members.id,
                'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
            JSON_OBJECT(
                'branch_name', branches.branch_name
            ) AS branch,
            'dds_accounts' AS source_table,
            dds_accounts.created_at
        FROM dds_accounts
        INNER JOIN branches ON dds_accounts.branch_id = branches.id
        INNER JOIN members ON dds_accounts.member_id = members.id
        WHERE dds_accounts.status = 0
        ";

            Log::info("approveAccounts() - Executing SQL UNION Query");

            $query = DB::table(DB::raw("({$sql}) as combined"))
                ->orderBy('created_at', 'desc');

            Log::info("approveAccounts() - Query Built Successfully");

            if ($search) {
                Log::info("approveAccounts() - Applying Search Filter", [
                    'search' => $search
                ]);
            }

            $pending_transactions = $query->paginate($perPage)->appends($request->all());

            Log::info("approveAccounts() - Pagination Completed", [
                'total_records' => $pending_transactions->total(),
                'current_page'  => $pending_transactions->currentPage()
            ]);

            $pending_transactions->getCollection()->transform(function ($item) {
                $item->members = json_decode($item->members);
                $item->branch = json_decode($item->branch);
                return $item;
            });

            Log::info("approveAccounts() - Transformation Completed");

            return view('approvals.saving_rd_fd_mis', compact('pending_transactions'));
        } catch (\Exception $e) {

            Log::error("approveAccounts() FAILED", [
                'error_message' => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
                'trace'         => $e->getTraceAsString(),
                'request_data'  => $request->all(),
                'sql'           => isset($sql) ? $sql : null,
                'search'        => $request->input('search'),
                'perPage'       => $request->input('perPage'),
            ]);

            return back()->withErrors(['error' => 'Something went wrong. Check logs.']);
        }
    }


    // Approve Share Transfer - LIST PAGE
    public function approveTransfer(Request $request)
    {
        try {

            $search = $request->input('search');

            Log::info('approveTransfer() - Fetching pending share transfers', [
                'search'     => $search,
                'requested_by' => Auth::id(),
                'ip'         => $request->ip(),
            ]);

            $share_transfers = ShareTransfer::with('shareholdings.promotor.branch', 'members')
                ->where('status', '!=', 'approved')
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->whereHas('members', function ($q2) use ($search) {
                            $q2->where('member_info_first_name', 'like', "%$search%");
                        })
                            ->orWhere('business_type', 'like', "%$search%")
                            ->orWhere('shares', 'like', "%$search%");
                    });
                })
                ->orderBy('id', 'desc')
                ->paginate(10);

            Log::info('approveTransfer() - Records fetched successfully', [
                'total_records'  => $share_transfers->total(),
                'current_page'   => $share_transfers->currentPage(),
                'per_page'       => $share_transfers->perPage(),
                'search_applied' => $search ? true : false,
            ]);

            return view('approvals.share_transfer_approval', compact('share_transfers', 'search'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            Log::error('approveTransfer() - Record not found', [
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            abort(404);
        } catch (\Exception $e) {

            Log::error('approveTransfer() - Unexpected error', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while fetching share transfers.');
        }
    }


    // Approve Share Transfer - SUBMIT ACTION
    public function approveShareTransfer(Request $request)
    {
        Log::info('approveShareTransfer() - Request received', [
            'share_transfer_id' => $request->input('share_transfer_id'),
            'status'            => $request->input('status'),
            'remarks'           => $request->input('remarks'),
            'requested_by'      => Auth::id(),
            'ip'                => $request->ip(),
        ]);

        try {

            // Step 1: Validate
            $validated = $request->validate([
                'share_transfer_id' => 'required|exists:share_transfer,id',
                'status'            => 'required|in:approved,not approve',
                'remarks'           => 'nullable|string|max:255',
            ]);

            Log::info('approveShareTransfer() - Validation passed', [
                'share_transfer_id' => $validated['share_transfer_id'],
                'status'            => $validated['status'],
            ]);

            // Step 2: Find record
            $transfer = ShareTransfer::with('members')->find($validated['share_transfer_id']);

            if (!$transfer) {
                Log::warning('approveShareTransfer() - ShareTransfer record not found after validation', [
                    'share_transfer_id' => $validated['share_transfer_id'],
                ]);
                return redirect()->back()->with('error', 'Share transfer record not found.');
            }

            Log::info('approveShareTransfer() - Record found', [
                'share_transfer_id' => $transfer->id,
                'current_status'    => $transfer->status,
                'member_id'         => $transfer->members?->id ?? null,
                'member_name'       => $transfer->members?->member_info_first_name ?? null,
            ]);

            // Step 3: Update status
            $transfer->status  = $validated['status'];
            $transfer->remarks = $validated['remarks'];

            if ($validated['status'] === 'approved') {
                $transfer->certificate_number = $transfer->id;
                Log::info('approveShareTransfer() - Assigning certificate number', [
                    'share_transfer_id'  => $transfer->id,
                    'certificate_number' => $transfer->id,
                ]);
            } else {
                $transfer->certificate_number = null;
                Log::info('approveShareTransfer() - Status set to not approve, clearing certificate number', [
                    'share_transfer_id' => $transfer->id,
                ]);
            }

            // Step 4: Save transfer
            if ($transfer->save()) {

                Log::info('approveShareTransfer() - ShareTransfer saved successfully', [
                    'share_transfer_id' => $transfer->id,
                    'new_status'        => $transfer->status,
                ]);

                // Step 5: Update member share_allocated
                if ($transfer->members) {

                    $transfer->members->share_allocated = 1;
                    $transfer->members->save();

                    Log::info('approveShareTransfer() - Member share_allocated updated', [
                        'member_id'       => $transfer->members->id,
                        'share_allocated' => 1,
                    ]);
                } else {

                    Log::warning('approveShareTransfer() - No member found on transfer, share_allocated not updated', [
                        'share_transfer_id' => $transfer->id,
                    ]);
                }
            } else {

                Log::error('approveShareTransfer() - Failed to save ShareTransfer', [
                    'share_transfer_id' => $transfer->id,
                ]);

                return redirect()->back()->with('error', 'Failed to update share transfer. Please try again.');
            }

            Log::info('approveShareTransfer() - Completed successfully', [
                'share_transfer_id' => $transfer->id,
                'final_status'      => $transfer->status,
            ]);

            return redirect()->back()->with('success', 'Share transfer updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {

            Log::warning('approveShareTransfer() - Validation failed', [
                'errors'            => $e->errors(),
                'share_transfer_id' => $request->input('share_transfer_id'),
                'status'            => $request->input('status'),
                'requested_by'      => Auth::id(),
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            Log::error('approveShareTransfer() - Model not found', [
                'share_transfer_id' => $request->input('share_transfer_id'),
                'error'             => $e->getMessage(),
                'file'              => $e->getFile(),
                'line'              => $e->getLine(),
            ]);

            abort(404);
        } catch (\Exception $e) {

            Log::error('approveShareTransfer() - Unexpected error', [
                'share_transfer_id' => $request->input('share_transfer_id'),
                'status'            => $request->input('status'),
                'error'             => $e->getMessage(),
                'file'              => $e->getFile(),
                'line'              => $e->getLine(),
                'trace'             => $e->getTraceAsString(),
                'requested_by'      => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Approve reverse transaction
    public function reverseTransactionView(Request $request, $id)
    {
        try {
            $decodedId = base64_decode($id);
            $transaction = Transaction::findOrFail($decodedId);
            return view('saving-current-ac.accounts.reverse-transaction', compact('transaction', 'id'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function reverseTransactionApprove(Request $request, $id)
    {
        try {
            $decodedId = base64_decode($id);

            $validator = Validator::make($request->all(), [
                'reverse_amount' => 'required|numeric|min:0|max:1000',
                'remarks'        => 'nullable|string|max:255',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $originalTransaction = Transaction::findOrFail($decodedId);

            $newTransaction = new Transaction();
            $newTransaction->account_id    = $originalTransaction->account_id;
            $newTransaction->amount        = $request->input('reverse_amount');
            $newTransaction->transaction_type = 'debit';
            $newTransaction->approve_status        = 'pending';
            $newTransaction->remarks       = $request->input('remarks');
            // $newTransaction->account_id = $originalTransaction->id;
            $newTransaction->comment = "Reverse Transaction";
            $newTransaction->reverse_status = 0;
            // $newTransaction->account_id    = Auth::id();
            $newTransaction->save();

            return redirect()->route('transaction.show', base64_encode($originalTransaction->id))
                ->with('success', 'Please approve reversed transaction.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function approveReverseTransaction()
    {
        try {
            $transactions = Transaction::with('accounts.members', 'accounts.branch')->where('approve_status', 'pending')
                ->where('reverse_status', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('approvals.reverse_transaction', compact('transactions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function approveTransaction($encodedId, Request $request)
    {
        dd('hii');
        try {

            $id = base64_decode($encodedId);

            /*
        |--------------------------------------------------------------------------
        | 1️⃣ FIRST CHECK – TRY NORMAL TRANSACTION (OLD LOGIC)
        |--------------------------------------------------------------------------
        */
            $transaction = Transaction::find($id);

            if ($transaction) {

                if ($transaction->approve_status !== 'pending' || $transaction->reverse_status != 0) {
                    return redirect()->back()->with('error', 'Invalid transaction status.');
                }

                // 🔥 OLD LOGIC (UNCHANGED)
                $transaction->transaction_type = 'debit';
                $transaction->approve_status = $request->input('transaction_status');
                $transaction->reverse_status = 1;
                $transaction->save();

                return redirect()->route('reverse-transaction.reverse_transaction')
                    ->with('success', 'Transaction approved successfully.');
            }

            /*
        |--------------------------------------------------------------------------
        | 2️⃣ IF NOT FOUND IN TRANSACTION → CHECK EMI TABLE
        |--------------------------------------------------------------------------
        */
            $emi = GoldLoanTransaction::find($id);

            if ($emi) {

                if ($emi->status != 'pending') {
                    return redirect()->back()->with('error', 'Invalid EMI status.');
                }

                $emi->status = 'paid';
                $emi->paid_date = now();
                $emi->save();

                // 🔥 Recalculate Loan
                $loan = LoanApplication::find($emi->loan_id);

                if ($loan) {
                    $totalPaid = GoldLoanTransaction::where('loan_id', $loan->id)
                        ->where('status', 'paid')
                        ->sum('amount_collected');

                    $remaining = max($loan->loan_amount - $totalPaid, 0);

                    if ($remaining <= 0) {
                        $loan->status = 'closed';
                        $loan->save();
                    }
                }

                return redirect()->back()->with('success', 'EMI approved successfully.');
            }

            /*
        |--------------------------------------------------------------------------
        | 3️⃣ IF NOTHING FOUND
        |--------------------------------------------------------------------------
        */
            return redirect()->back()->with('error', 'Invalid source table specified.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }



    public function loans()
    {
        // Normal Loan Applications
        $loanApplications = LoanApplication::with(['creditScores', 'branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'loan';
                return $item;
            });

        // Mortgage Loan Applications
        $mortgageLoans = MortgageLoanApplication::with(['branch', 'member'])
            // ->whereNotIn('status', [1, 2, 3])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'mortgage';
                return $item;
            });

        // Loan Against Applications
        $loanAgainst = LoanAgainstApplication::with(['branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'loan_against';
                return $item;
            });

        // Business Loan Applications
        $businessLoans = BusinessLoanApplication::with(['branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'business_loan';
                return $item;
            });

        // cc od Loan Applications
        $cc_od = CcOdLoanApplication::with(['branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'cc_od';
                return $item;
            });

        // Daily Weekly Loan Applications
        $daily_weekly = DailyWeeklyApplication::with(['branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'daily_weekly';
                return $item;
            });

        // Personal Loan Applications
        $personal = PersonalLoanApplication::with(['branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'personal';
                return $item;
            });

        // Vehical Loan Applications
        $vehical = VehicalApplication::with(['branch', 'member'])
            ->where('status', 3)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'vehical';
                return $item;
            });

        // Fixed Loan Applications
        $fixed = FixedLoanApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'fixed';
                return $item;
            });


        $applications = $loanApplications
            ->concat($mortgageLoans)
            ->concat($loanAgainst)
            ->concat($businessLoans)
            ->concat($cc_od)
            ->concat($daily_weekly)
            ->concat($personal)
            ->concat($vehical)
            ->concat($fixed)
            ->sortByDesc(function ($item) {
                return $item->updated_at ?? $item->created_at;
            });


        // Account types array
        $types = [
            'loan' => 'Gold Loan',
            'mortgage' => 'Mortgage Loan',
            'loan_against' => 'Loan Against',
            'business_loan' => 'Business Loan',
            'cc_od' => 'CC OD',
            'daily_weekly' => 'Daily Weekly',
            'personal' => 'Personal Loan',
            'vehical' => 'Vehical Loan',
            'fixed' => 'Fixed Loan',
        ];

        $routeMap = [
            'loan' => 'gold-loan.applications.view',
            'mortgage' => 'mortgage.applications.view',
            'loan_against' => 'loanagainst.applications.view',
            'business_loan' => 'bussiness.applications.view',
            'cc_od' => 'cc_od.applications.view',
            'daily_weekly' => 'daily_weekly.applications.view',
            'personal' => 'personal.applications.view',
            'vehical' => 'vehical.applications.view',
            'fixed' => 'fixed_loan.schemes.view',
        ];


        return view('approvals.loans', compact('applications', 'types', 'routeMap'));
    }


    public function updateStatus(Request $request, $id)
    {
        Log::info('updateStatus() - Request received', [
            'id'         => $id,
            'model_type' => $request->input('model_type'),
            'status'     => $request->input('status'),
            'remarks'    => $request->input('remarks'),
            'requested_by' => Auth::id(),
            'ip'         => $request->ip(),
        ]);

        $modelType = $request->input('model_type');
        $status    = $request->input('status');
        $remarks   = $request->input('remarks');

        // Step 1: Resolve model class from model_type
        $modelMap = [
            'loan'          => LoanApplication::class,
            'mortgage'      => MortgageLoanApplication::class,
            'loan_against'  => LoanAgainstApplication::class,
            'business_loan' => BusinessLoanApplication::class,
            'cc_od'         => CcOdLoanApplication::class,
            'daily_weekly'  => DailyWeeklyApplication::class,
            'personal'      => PersonalLoanApplication::class,
            'vehical'       => VehicalApplication::class,
            'fixed'         => FixedLoanApplication::class,
        ];

        $redirectMap = [
            'loan'          => 'gold-loan.disbursements.index',
            'mortgage'      => 'mortgage.disbursements.index',
            'loan_against'  => 'loanagainst.disbursements.index',
            'business_loan' => 'bussiness.disbursements.index',
            'cc_od'         => 'cc_od.disbursements.index',
            'daily_weekly'  => 'daily_weekly.disbursements.index',
            'personal'      => 'personal.disbursements.index',
            'vehical'       => 'vehical.disbursements.index',
            'fixed'         => 'fixed_loan.disbursements.index',
        ];

        // Step 2: Validate model_type
        if (!array_key_exists($modelType, $modelMap)) {
            Log::warning('updateStatus() - Invalid model_type received', [
                'model_type'   => $modelType,
                'id'           => $id,
                'requested_by' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Invalid loan type specified.');
        }

        // Step 3: Find application
        $modelClass   = $modelMap[$modelType];
        $application  = $modelClass::find($id);

        if (!$application) {
            Log::error('updateStatus() - Application not found', [
                'model_type'   => $modelType,
                'id'           => $id,
                'requested_by' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Application not found!');
        }

        Log::info('updateStatus() - Application found', [
            'model_type'     => $modelType,
            'id'             => $id,
            'current_status' => $application->status,
            'new_status'     => $status,
        ]);

        // Step 4: Update status
        $previousStatus      = $application->status;
        $application->status = $status;

        if ($remarks) {
            $application->remarks = $remarks;
        }

        if (!$application->save()) {
            Log::error('updateStatus() - Failed to save application', [
                'model_type'   => $modelType,
                'id'           => $id,
                'requested_by' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Failed to update status. Please try again.');
        }

        Log::info('updateStatus() - Status updated successfully', [
            'model_type'      => $modelType,
            'id'              => $id,
            'previous_status' => $previousStatus,
            'new_status'      => $status,
            'requested_by'    => Auth::id(),
        ]);

        // Step 5: Redirect to disbursements
        $redirectRoute = $redirectMap[$modelType] ?? null;

        if ($redirectRoute) {
            Log::info('updateStatus() - Redirecting to disbursements', [
                'route'      => $redirectRoute,
                'model_type' => $modelType,
                'id'         => $id,
            ]);
            return redirect()->route($redirectRoute)
                ->with('success', 'Status updated successfully!');
        }

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function approvals_history()
    {
        // gold Loan Applications (approved)
        $loanApplications = LoanApplication::with(['creditScores', 'branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'loan';
            });

        // Mortgage Loan Applications (approved)
        $mortgageLoans = MortgageLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'mortgage';
            });

        // Loan Against Applications (approved)
        $loanAgainst = LoanAgainstApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'loan_against';
            });

        // cc_od Applications (approved)
        $cc_od = CcOdLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'cc_od';
            });

        // daily_weekly Applications (approved)
        $daily_weekly = DailyWeeklyApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'daily_weekly';
            });

        // Personal Loan Applications (approved)
        $personal = PersonalLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'personal';
            });

        // Vehical Loan Applications (approved)
        $vehical = VehicalApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'vehical';
            });

        // Fixed Loan Applications (approved)
        $fixed = FixedLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'fixed';
            });

        $routeMap = [
            'loan' => 'gold-loan.applications.view',
            'mortgage' => 'mortgage.applications.view',
            'loan_against' => 'loanagainst.applications.view',
            'business_loan' => 'bussiness.applications.view',
            'cc_od' => 'cc_od.applications.view',
            'daily_weekly' => 'daily_weekly.applications.view',
            'personal' => 'personal.applications.view',
            'vehical' => 'vehical.applications.view',
            'fixed' => 'fixed_loan.applications.view',
        ];

        // Account types array
        $types = [
            'loan' => 'Gold Loan',
            'mortgage' => 'Mortgage Loan',
            'loan_against' => 'Loan Against',
            'business_loan' => 'Business Loan',
            'cc_od' => 'CC OD',
            'daily_weekly' => 'Daily Weekly',
            'personal' => 'Personal Loan',
            'vehical' => 'Vehical Loan',
            'fixed' => 'Fixed Loan',
        ];


        // Merge all 5 collections
        $applications = $loanApplications
            ->concat($mortgageLoans)
            ->concat($loanAgainst)
            ->concat($cc_od)
            ->concat($daily_weekly)
            ->concat($personal)
            ->concat($vehical)
            ->concat($fixed)
            ->sortByDesc('created_at');

        return view('approvals.approvals_history', compact('applications', 'routeMap', 'types'));
    }
}
