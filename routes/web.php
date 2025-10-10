<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\ApproveController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PromotorController;
use App\Http\Controllers\ShareHoldingController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MinorController;
use App\Http\Controllers\ShareholdersController;
use App\Http\Controllers\ShareCertificateController;
use App\Http\Controllers\ShareTrasferHistoryController;
use App\Http\Controllers\Form15Gor15HController;
use App\Http\Controllers\SchemesController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ShareTransferController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\DisbursementController;
use App\Http\Controllers\OrnamentController;
use App\Http\Controllers\KycDocumentsController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\FdCalculatorController;
use App\Http\Controllers\RDCalculatorController;
use App\Http\Controllers\DdsAccountsController;
use App\Http\Controllers\FDController;
use App\Http\Controllers\GoldLoanController;
use App\Http\Controllers\BussinessController;
use App\Http\Controllers\MDSController;
use App\Http\Controllers\MisaccountController;
use App\Http\Controllers\MortgageLoneController;
use App\Http\Controllers\RdAccountController;
use App\Http\Controllers\GoldloanAccountController;
use App\Http\Controllers\RdschemesController;
use App\Http\Controllers\PassbookController;
use App\Http\Controllers\MortgageController;
use App\Http\Controllers\LoanAgainstController;
use App\Http\Controllers\LoanAgainstAccountController;
use App\Http\Controllers\LoanAgainstDisbursementController;
use App\Http\Controllers\BussinessDisbursementController;
use App\Http\Controllers\MortgageDisbursementController;
use App\Http\Controllers\MortgageAccountController;
use App\Helpers\SmsHelper;

// Clear cache 
Route::get('/cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return 'Success! Cache Cleared';
});

// Storage link 
Route::get('/storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    return 'Success! Storage link created';
});

// DB Migrate
Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Success! Migrations have been run.';
    } catch (\Exception $e) {
        return 'Migration failed: ' . $e->getMessage();
    }
});

Route::get('/', [AuthenticationController::class, 'signIn'])->name('sign.in');

Route::post('/login', [AuthenticationController::class, 'login'])->name('log.in');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('log.out');
Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('reset.password');

Route::middleware('auth.user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index1'])->name('index1');
    Route::get('/get-branches', [BranchController::class, 'getBranches']);
    Route::get('/get-marital-statuses', [PromotorController::class, 'getMariatalStatuses']);
    Route::get('/get-religion-statuses', [PromotorController::class, 'getReligion']);
    Route::get('/get-relation', [HRController::class, 'getRelations']);
    Route::get('/get-bank', [HRController::class, 'getBanks']);
    Route::get('/get-payable-expense', [HRController::class, 'payableExpense']);
    Route::get('/get-payable-ledger', [HRController::class, 'payableLedger']);
    Route::get('/get-blood-group', [HRController::class, 'bloodGroup']);
    Route::get('/get-promoters', [PromotorController::class, 'getPromoters']);
    Route::get('/get-members', [MemberController::class, 'getMembers']);

    Route::group(['prefix' => 'company'], function () {
        Route::resource('company', CompanyController::class);
        Route::resource('branch', BranchController::class);
        Route::get('/ajax/branches/search', [BranchController::class, 'search'])->name('ajax.branches.search');
        Route::resource('promotor', PromotorController::class);
        Route::get('/promotor/{id}/address', [PromotorController::class, 'addressedit'])->name('promotor.address');
        Route::put('/promotor/{id}/address', [PromotorController::class, 'addressupdate'])->name('promotor.address.update');
        Route::get('/company/promotor/{id}/documents', [PromotorController::class, 'documentShow'])->name('promotor.document');
        Route::post('/company/promotor/{id}/documents/update', [PromotorController::class, 'documentUpdate'])->name('promoter.documentupdate');
        Route::resource('shareholding', ShareHoldingController::class);
        Route::post('shareholding/transfer', [ShareholdingController::class, 'IsTransforror'])
            ->name('shareholding.transfer');
        Route::resource('director', DirectorController::class);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/calculator', [CalculatorController::class, 'create'])->name('calculator.index');
        Route::get('/calculator/create', [CalculatorController::class, 'create'])->name('calculator.create');
        Route::post('/calculator/store', [CalculatorController::class, 'store'])->name('calculator.store');
        Route::get('/calculator/calculate', [CalculatorController::class, 'calculateInvestment'])->name('calculator.calculate');
        Route::post('/calculate-investment', [CalculatorController::class, 'calculateInvestmentAjax'])->name('calculate.investment');
        Route::get('/fetch-schemes', [CalculatorController::class, 'getSchemes'])->name('fd.schemes.fetch');
        Route::get('/fetch-scheme/{id}', [CalculatorController::class, 'getSchemeDetails'])->name('fd.scheme.details');

    });


    Route::middleware('auth')->group(function () {
        Route::get('/dds-accounts', [DdsAccountsController::class, 'index'])->name('dds-accounts.index');
        Route::get('/dds-accounts/create', [DdsAccountsController::class, 'create'])->name('dds-accounts.create');
        Route::post('/dds-accounts/store', [DdsAccountsController::class, 'store'])->name('dds-accounts.store');
        Route::get('/ajax/members/{id}', [DdsAccountsController::class, 'getMemberDetails'])
            ->name('ajax.members.show');
        Route::get('/dds-accounts/{id}', [DdsAccountsController::class, 'show'])->name('dds-accounts.show');
        Route::get('/dds-accounts/{id}/edit', [DdsAccountsController::class, 'edit'])->name('dds-accounts.edit');
        Route::post('/dds-accounts/calculate-deposit', [DdsAccountsController::class, 'calculateDeposit'])
            ->name('dds-accounts.calculate-deposit');
        Route::get('/dds-accounts/{id}/transactions', [DdsAccountsController::class, 'transactions'])->name('dds-accounts.transactions');
        Route::delete(
            '/dds-accounts/transactions/{id}',
            [DdsAccountsController::class, 'destroyTransaction']
        )
            ->name('dds-accounts.transactions.destroy');
        Route::get('/dds-accounts/{account}/transactions/{transaction}', [DdsAccountsController::class, 'transactionShow'])
            ->name('dds-accounts.transactions.show');

        Route::put('/ddsaccounts/{ddaccount}/update-member', [DdsAccountsController::class, 'updateMember'])->name('ddsaccounts.updateMember');
        Route::put('/ddsaccounts/{ddaccount}/update-branch', [DdsAccountsController::class, 'updateBranch'])->name('ddsaccounts.updateBranch');

        Route::get('/calculateMaturity', [DdsAccountsController::class, 'calculateMaturity'])->name('ddsaccounts.calculateMaturity');
        Route::get('/dds-accounts/{id}/installments', [DdsAccountsController::class, 'installments'])
            ->name('ddsaccounts.installments');
        Route::post('/dds/deposit/store', [DdsAccountsController::class, 'storeDeposit'])->name('dds.deposit.store');

        Route::get('/ddsaccount/{id}/deposit', [DdsAccountsController::class, 'createDeposit'])->name('ddsaccounts.createDeposit');
        // routes/web.php

        Route::get('/dds-accounts/{id}/transactions/{transaction_id?}', [DdsAccountsController::class, 'transactions'])
            ->name('dds.transactions');
    });

    Route::resource('rd-calculator', RDCalculatorController::class)
        ->only(['index', 'create', 'store']);
    
    Route::get('/rd-schemes/{scheme_code}', [RDCalculatorController::class, 'getScheme']);


    Route::group(['prefix' => 'members'], function () {
        Route::resource('member', MemberController::class);
        Route::resource('minor', MinorController::class);
        Route::get('/member/{id}/documents', [MemberController::class, 'documentShow'])->name('member.document');
        Route::post('/member/{id}/documents', [MemberController::class, 'documentUpdate'])->name('member.documentupdate');
        Route::get('/members/{id}/address', [MemberController::class, 'addressedit'])->name('member.address');
        Route::put('/members/{id}/address', [MemberController::class, 'addressupdate'])->name('member.address.update');
        Route::get('/member/{id}/mobile', [MemberController::class, 'editmobile'])->name('member.mobile');
        Route::put('/member/{id}/mobile', [MemberController::class, 'updatemobile'])->name('member.updatemobile');
        Route::get('/members/minor/create', [MemberController::class, 'createMinor'])->name('member.minor.creates');
        Route::get('/ajax/members/search', [MemberController::class, 'search'])->name('ajax.members.search');
        Route::get('/members/member/{id}/shareholding', [MemberController::class, 'shareholding'])->name('member.shareholding');
        Route::get('{id}/transactions', [MemberController::class, 'showTransactions'])->name('members.transactions');
        Route::post('{memberId}/transactions', [MemberController::class, 'storeTransaction'])->name('members.storeTransaction');
        Route::post('/members/{id}/transactions/share-amount', [MemberController::class, 'storeShareAmount'])
            ->name('members.transactions.share-amount.store');
        Route::get('/members/{id}/transactions/share-amount', [MemberController::class, 'createShareAmount'])
            ->name('members.transactions.share-amount.create');
        Route::get('/members/transactions/{id}', [MemberController::class, 'showTransactionDetails'])->name('transactions.show');
        Route::delete('transactions/{id}/soft-delete', [MemberController::class, 'softDeleteTransaction'])
            ->name('transactions.softDeletetransaction');
        Route::get('/members/{id}/transactions/other-charges/list', [MemberController::class, 'otherChargesList'])->name('members.other-charges.list');
        Route::delete('/member-other-charges/{id}/delete', [MemberController::class, 'softDeleteothercharges'])->name('transactions.softDelete');
        // Route to show the form for clearing dues (GET request)
        Route::get('members/{id}/transactions/other-charges/{chargeId}/clear-due', [MemberController::class, 'showClearDueForm'])
            ->name('members.other-charges.clearDue.form');
        // Route to handle clearing dues (POST request)
        Route::post('members/{id}/transactions/other-charges/{chargeId}/clear-due', [MemberController::class, 'storeChargesDue'])
            ->name('members.other-charges.clearDue.handle');
        Route::get('/members/receipt/print/{id}/{type}', [MemberController::class, 'printReceipt'])
            ->middleware('auth') 
            ->name('transactions.print-receipt');

        Route::get('/application-form', [MemberController::class, 'applicationForm'])->name('members.application_form');

        Route::get('/members/members/member/{id}/shareholding', [ShareHoldingController::class, 'shareholding'])->name('members.shareholding');
        Route::get('/members/{id}/transactions/other-charges', [MemberController::class, 'otherCharges'])
            ->name('members.other-charges');
        Route::post('/members/{id}/transactions/other-charges', [MemberController::class, 'storeOtherCharges'])->name('members.other-charges.store');

        Route::get('/shareholding/view/{id}', [ShareholdingController::class, 'viewShareholding'])->name('viewShareholding');
        Route::get('/shareholding/{id}', [MemberController::class, 'shareholding'])->name('shareholding');

        Route::resource('shares-holdings', ShareholdersController::class);
        Route::resource('share-certificates', controller: ShareCertificateController::class);
        Route::resource('share_transfer_histories', ShareTrasferHistoryController::class);
        Route::resource('form15g15h', Form15Gor15HController::class);
        Route::get('/form15g15h/download/{member_id}', [Form15Gor15HController::class, 'download'])->name('form15g15h.download');
        Route::get('/form15g15h/download/promoter/{promoter_id}', [Form15Gor15HController::class, 'downloadByPromoter'])->name('form15g15h.download.promoter');
    });
    Route::resource('shares-transfer', ShareTransferController::class);
    Route::get('/shares-transfer/print/{id}', [ShareTransferController::class, 'print'])->name('shares-transfer.print');

    Route::post('/promoter/select-split', [ShareTransferController::class, 'selectForShareSplit'])->name('promoter.select.split');
    Route::get('/share/allocate', [ShareTransferController::class, 'transferForm'])->name('shareholding.transfer.form');
    Route::post('/share/allocate', [ShareTransferController::class, 'store'])->name('shares.allocate');
    Route::get('/members/{member}/share-holdings', [ShareHoldingController::class, 'index'])
        ->name('members.share-holdings.index');

    Route::resource('form15g15h', Form15Gor15HController::class);
});

Route::get('/get-member-shares/{id}', function ($id) {
    $shares = \App\Models\Shareholding::where('promotor_id', $id)->sum('share_no');
    return response()->json(['shares' => $shares]);
});

Route::get('/get-promoter-shares/{id}', [ShareTransferController::class, 'getPromoterShares']);

Route::group(['prefix' => 'saving-current-ac'], function () {
    Route::resource('schemes', SchemesController::class);
    Route::resource('accounts', AccountsController::class);
    Route::get('/saving/passbook/{id}', [AccountsController::class, 'viewPassbook'])->name('saving.passbook');
    Route::post('/accounts/passbook/search', [AccountsController::class, 'passbookSearch'])->name('accounts.passbook.search');


    Route::post('/ajax/get-account-balance', [AccountsController::class, 'getBalance'])->name('ajax.get.account.balance');

    Route::get('/view/{id}/transaction', [AccountTransactionController::class, 'index'])->name('account.transaction');
    Route::resource('transaction', AccountTransactionController::class);
    Route::get('/export-transaction/{id}', [AccountTransactionController::class, 'downloadCsvExample'])->name('export.transaction');
    Route::get('/transaction/{id}/print', [AccountTransactionController::class, 'print'])->name('transaction.print');
});

Route::group(['prefix' => 'fd-mis-schemes'], function () {
    Route::resource('fd-mis-schemes', FDController::class);

    Route::get('fd-index', [FDController::class, 'fd_index'])->name('fd-mis-schemes.fd_index');
    Route::get('fd-account', [FDController::class, 'fd_create'])->name('fd-mis-schemes.fd_create');

    Route::post('add/fd-account', [FDController::class, 'fd_store'])->name('fd-mis-schemes.fd_store');
    // web.php
    Route::get('/account/balance/{id}', [FDController::class, 'getBalance'])->name('account.balance');

    Route::get('fd-account-view/{id}', [FDController::class, 'fd_show'])->name('fd-mis-schemes.fd_show');
    Route::get('/get-member-savings/{member_id}', [FDController::class, 'getMemberSavings'])
        ->name('member.savings');

    Route::put('/fd/{id}/update-branch', [FDController::class, 'updateBranch'])->name('fd.updateBranch');

    Route::get('/fdpayout/{id}', [FDController::class, 'fdpayout'])->name('fd-mis-account.fd-payoutplan.fdpayoutplan');
    Route::post('/fd/process-payout', [FdController::class, 'processPayout'])->name('fd.processPayout');

    Route::get('/change-account-info/{id}', [FdController::class, 'changeAccountInfo'])->name('fd.change.account.info');
    Route::get('/fd-add-nominee/{id}', [FdController::class, 'addNominee'])->name('fd.add.nominee');

    Route::resource('misaccount', MisaccountController::class);
    // Route::get('misaccount/create', [MisaccountController::class, 'create']);
    // Route::get('/misaccount/create/{member}', [MisAccountController::class, 'create']);


    //Transactions Info
    Route::get('/misaccount/member/{memberId}/accounts', [MisaccountController::class, 'getByMember']);


    //Route::get('fd-mis-schemes/misaccount/{id}/change-account-info', [MisaccountController::class, 'changeAccountInfo'])->name('misaccount.changeAccountInfo');
    // Show change account info form
    Route::get('misaccount/{id}/change-account-info', [MisaccountController::class, 'changeAccountInfo'])
        ->name('misaccount.changeAccountInfo');

    // Update account info (form submit)
    Route::post('misaccount/{id}/change-account-info', [MisaccountController::class, 'updateAccountInfo'])
        ->name('misaccount.updateAccountInfo');

    // Add Nominee
    Route::get('misaccount/{id}/add-nominee', [MisaccountController::class, 'addNominee'])
        ->name('misaccount.addNominee');

    Route::post('misaccount/{id}/update-nominee', [MisaccountController::class, 'updateNominee'])
        ->name('misaccount.updateNominee');

    //edit and update branches

    Route::put('/misaccount/member/{misaccountId}/update-branch', [MisaccountController::class, 'updateBranch'])
        ->name('misaccount.update-branch');
});
Route::group(['prefix' => 'mds-rds-dds'], function () {

    Route::resource('mds-rds-dds', MDSController::class);
    Route::resource('rdschemes', RdschemesController::class);

    Route::resource('mds-rd-account', RdAccountController::class);

    Route::get('rd-account-index', [RdAccountController::class, 'index'])->name('mds-rd-accounts.rd-account-index');
    Route::get('create-rd-account', [RdAccountController::class, 'create'])->name('mds-rd-accounts.create-rd-account');
    Route::get('rd-dd-calculator', [RdAccountController::class, 'rdDdCalculator'])->name('calculator.rd-dd-calculator');
    Route::get('/members/{id}', [RdAccountController::class, 'getMember'])->name('members.get');

    Route::post('/rd-accounts', [RdAccountController::class, 'store'])->name('rd-accounts.store');
    Route::get('/rd-accounts/{id}', [RdAccountController::class, 'show'])->name('rd-accounts.show');

    Route::get('/rd-accounts/{id}/installments', [RdAccountController::class, 'installmentPlan'])->name('installment.plan');
    Route::get('/rd-accounts/{id}/transactions', [RdAccountController::class, 'viewTransactions'])->name('view.viewTransaction');
    Route::get('/rd-accounts/{id}/transaction-summary', [RdAccountController::class, 'viewRdTransactionSummary'])->name('view.transactionSummary');
    Route::get('/rd-accounts/{id}/deposit', [RdAccountController::class, 'showDepositForm'])->name('rd-accounts.deposit.form');
    Route::post('/rd-accounts/{rdAccount}/deposit', [RdAccountController::class, 'storeDeposit'])->name('rd.deposit.store');
    Route::get('/rd-accounts/{id}/withdraw', [RdAccountController::class, 'showWithdrawForm'])->name('rd-accounts.withdraw.form');
    Route::post('/rd-accounts/{rdAccount}/withdraw', [RdAccountController::class, 'storeWithdraw'])->name('rd.withdraw.store');
    Route::get('/rd-accounts/{id}/change-info', [RdAccountController::class, 'showChangeInfoForm'])->name('rd-accounts.change-info');
    Route::post('/rd-accounts/{rdAccount}/change-info', [RdAccountController::class, 'storeChangeInfo'])->name('rd.change-info.store');
});

Route::group(['prefix' => 'deposits'], function () {
    Route::get('/deposit-create/{id}', [DepositController::class, 'create'])->name('deposit.create');
    Route::post('/deposit-money/{id}', [DepositController::class, 'store'])->name('deposit.money');
});
Route::group(['prefix' => 'withdraws'], function () {
    Route::get('/withdraw-create/{id}', [WithdrawController::class, 'create'])->name('withdraw.create');
    Route::post('/withdraw-money/{id}', [WithdrawController::class, 'store'])->name('withdraw.money');
});


////////////////////////////////////    APPROVALS    /////////////////////////////////////////////////////////////

Route::group(['prefix' => 'approvals'], function () {
    Route::resource('pending-transaction', ApproveController::class);

    Route::get('share-transfer-approval/approve-transfer', [ApproveController::class, 'approveTransfer'])->name('share-transfer-approval.approve_transfer');
    Route::post('/share-transfer/approve', [ApproveController::class, 'approveShareTransfer'])->name('share_transfer.approve');

    Route::get('/reverse-transaction/approve', [ApproveController::class, 'approveReverseTransaction'])->name('reverse-transaction.reverse_transaction');
    Route::get('approvals/reverse-transactions/{id}', [ApproveController::class, 'reverseTransactionView'])->name('reverse-transaction.view');
    Route::post('/reverse-transactions/{id}', [ApproveController::class, 'reverseTransactionApprove'])->name('reverse-transaction');
    Route::put('/reverse-transactions/approve/{id}', [ApproveController::class, 'approveTransaction'])->name('reverse-transaction.approve');
    Route::get('approveAccounts', [ApproveController::class, 'approveAccounts'])->name('approveAccounts');
    Route::post('/approvals/updateAccountStatus/{id}', [ApproveController::class, 'updateAccountStatus'])->name('transactions.updateAccountStatus');

    // Loan Approval
    Route::get('loans', [ApproveController::class, 'loans'])->name('loans');
    Route::post('loans/update-status/{id}', [App\Http\Controllers\ApproveController::class, 'updateStatus'])
        ->name('loans.update-status');

    Route::get('approvals_history', [ApproveController::class, 'approvals_history'])->name('approvals_history');
});

////////////////////////////////////   END APPROVALS    /////////////////////////////////////////////////////////////

// Mortgage Loan
Route::group(['prefix' => 'morgage-loan'], function () {
    Route::get('mortgage-loan/schemes', [MortgageLoneController::class, 'index'])->name('mortgage_schemes.index');
    Route::get('/create-mortgage-scheme', [MortgageLoneController::class, 'create'])->name('mortgage_schemes.create_mortgage_scheme');
    Route::get('/edit-mortgage-scheme', [MortgageLoneController::class, 'edit'])->name('mortgage_schemes.edit-mortgage-scheme');
    Route::get('/view-mortgage-scheme', [MortgageLoneController::class, 'view'])->name('mortgage_schemes.view-mortgage-scheme');

    Route::get('/calculator', [MortgageLoneController::class, 'calculator'])->name('mortgage_calculator.index');
    Route::get('/calculator/calculation', [MortgageLoneController::class, 'calculation'])->name('mortgage_calculator.calculation');
    Route::get('/application', [MortgageLoneController::class, 'applications'])->name('mortgage_application.index');
    // Route::get('/create-applications', [MortgageLoneController::class, 'applications'])->name('mortgage_application.create_application');
    Route::get('/edit-application', [MortgageLoneController::class, 'editApplication'])->name('mortgage_application.edit-application');

    Route::get('/view-application', [MortgageLoneController::class, 'viewApplication'])->name('mortgage_application.view.view-application');
    Route::get('/emi-chart', [MortgageLoneController::class, 'emiChart'])->name('mortgage_application.view.emi-chart');
    Route::get('/upload-documents', [MortgageLoneController::class, 'uploadDocuments'])->name('mortgage_appliction.view.upload-documents');
    Route::get('/collect-processing-fee', [MortgageLoneController::class, 'collectProcessFee'])->name('mortgage_appliction.view.processing-fee');
    Route::get('disburse-setting', [MortgageLoneController::class, 'disburseSetting'])->name('mortgage_application.view.disburse-setting');
    Route::get('/cibil-score', [MortgageLoneController::class, 'cibilScore'])->name('mortgage_application.view.cibil-score');
    Route::get('/disbursement', [MortgageLoneController::class, 'disbursementIndex'])->name('mortage_disbursements.index');
    Route::get('/disburse-loan', [MortgageLoneController::class, 'disburseLoan'])->name('mortage_disbursements.disburse-loan');
});


/////////////////////////////////////   GOLD LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'gold-loan'], function () {

    // Gold Loan Scheme
    Route::get('scheme/index', [GoldLoanController::class, 'index'])
            ->name('gold-loan.schemes.index');

    // create form
    Route::get('scheme/create', [GoldLoanController::class, 'create'])
        ->name('gold-loan.schemes.create');
    // store form data
    Route::post('scheme/store', [GoldLoanController::class, 'store'])
    ->name('gold-loan.schemes.store');

    // view list
    Route::get('scheme/{id}', [GoldLoanController::class, 'show'])
    ->name('gold-loan.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [GoldLoanController::class, 'edit'])
        ->name('gold-loan.schemes.edit');
    Route::put('scheme/{id}', [GoldLoanController::class, 'update'])
    ->name('gold-loan.schemes.update');

    Route::get('scheme/view/{id}', [GoldLoanController::class, 'view'])
    ->name('gold-loan.schemes.view');

    // Gold Loan Calculation
    Route::get('calculator/index', [GoldLoanController::class, 'calculator'])
        ->name('gold-loan.calculator.index');
    // get scheme data
    Route::get('gold-loan/scheme/{id}', [GoldLoanController::class, 'getSchemeDetails'])
        ->name('gold-loan.scheme.details');

    // Calculation page  
    Route::get('calculator/calculation', [GoldLoanController::class, 'calculation'])->name('gold-loan.calculator.calculation');
    Route::post('gold-loan/calculate', [GoldLoanController::class, 'calculateResult'])->name('gold-loan.calculator.calculate');


    // GOld Application page
    Route::get('applications/index', [GoldLoanController::class, 'appindex'])
        ->name('gold-loan.applications.index');

    Route::get('applications/create', [GoldLoanController::class, 'appcreate'])
        ->name('gold-loan.applications.create');
    
    Route::post('/loan-applications/store', [GoldLoanController::class, 'storeLoanApplication'])->name('loan-applications.store');

    Route::get('/members/{id}/info', [GoldLoanController::class, 'getMemberInfo'])
    ->name('members.info');

    Route::get('gold-loan/applications/view/{id}', [GoldLoanController::class, 'appview'])
    ->name('gold-loan.applications.view');

    // Edit form
    Route::get('/gold-loan/applications/{id}/edit', [GoldLoanController::class, 'appedit'])
        ->name('gold-loan.applications.edit');

    // Update
    Route::put('/gold-loan/applications/{id}', [GoldLoanController::class, 'appupdate'])
        ->name('gold-loan.applications.update');

    Route::get('applications/show-emi-chart', [GoldLoanController::class, 'showEmiChart'])
        ->name('gold-loan.applications.view-buttons.show-emi-chart');


    // Disbursement GOld Loan
    Route::get('disbursements/index', [DisbursementController::class, 'index'])
        ->name('gold-loan.disbursements.index');
    Route::post('/gold-loan/disbursements/cancel/{id}', [DisbursementController::class, 'cancelLoan'])->name('golddisbursements.cancel');

    // disburse-loan page   
    Route::get('disbursements/disburse-loan/{id}', [DisbursementController::class, 'show'])
        ->name('gold-loan.disbursements.disburse-loan');
    Route::post('/gold-loan/disbursements/store', [DisbursementController::class, 'store'])->name('golddisbursements.store');
    

    //  Ornament GOld Loan
    Route::get('ornaments/index', [OrnamentController::class, 'index'])
        ->name('gold-loan.ornaments.index');
    ////  Ornament Update
    Route::post('ornaments/update/{id}', [OrnamentController::class, 'update'])
        ->name('gold-loan.ornaments.update');
    // Download excel sheet
    Route::get('ornaments/export', [OrnamentController::class, 'exportXls'])->name('gold-loan.ornaments.export');


// Cebil score
    Route::get('applications/upload-cibil-score', [GoldLoanController::class, 'upload_cibil_score'])
        ->name('gold-loan.applications.upload-cibil-score');


// GOld Loan Account Page
    Route::get('account/index', [GoldloanAccountController::class, 'index'])
        ->name('gold-loan.account.index');


    // other pages url
    Route::get('applications/disburse-setting', [GoldLoanController::class, 'showdisbursesetting'])
        ->name('gold-loan.applications.view-buttons.disburse-setting');

    Route::get('applications/col_process_fee', [GoldLoanController::class, 'col_process_fee'])
        ->name('gold-loan.applications.view-buttons.col_process_fee');

    Route::get('applications/upload_documents', [GoldLoanController::class, 'upload_documents'])
        ->name('gold-loan.applications.upload_documents');

   
});


/////////////////////////////////////   END GOLD LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   Mortgage LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'mortgage'], function () {

    // Mortgage Loan Scheme
    Route::get('scheme/index', [MortgageController::class, 'index'])
        ->name('mortgage.schemes.index');

    // create form
    Route::get('scheme/create', [MortgageController::class, 'create'])
        ->name('mortgage.schemes.create');
    // store form data
    Route::post('scheme/store', [MortgageController::class, 'store'])
        ->name('mortgage.schemes.store');

    // view list
    Route::get('scheme/{id}', [MortgageController::class, 'show'])
        ->name('mortgage.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [MortgageController::class, 'edit'])
        ->name('mortgage.schemes.edit');
    Route::put('scheme/{id}', [MortgageController::class, 'update'])
        ->name('mortgage.schemes.update');

    Route::get('scheme/view/{id}', [MortgageController::class, 'view'])
        ->name('mortgage.schemes.view');

    // Mortgage Loan Calculation
    Route::get('calculator/index', [MortgageController::class, 'calculator'])
        ->name('mortgage.calculator.index');
    // get scheme data
    Route::get('mortgage/scheme/{id}', [MortgageController::class, 'getSchemeDetails'])
        ->name('mortgage.scheme.details');

    // Calculation page  
    Route::get('calculator/calculation', [MortgageController::class, 'calculation'])->name('mortgage.calculator.calculation');
    Route::post('mortgage/calculate', [MortgageController::class, 'calculateResult'])->name('mortgage.calculator.calculate');


    // Mortgage Application page
    Route::get('applications/index', [MortgageController::class, 'appindex'])
        ->name('mortgage.applications.index');

    Route::get('applications/create', [MortgageController::class, 'appcreate'])
        ->name('mortgage.applications.create');
    
    Route::post('/mortgageloan/store', [MortgageController::class, 'storeLoanApplication'])->name('mortgage.store');

    Route::get('/members/{id}/info', [MortgageController::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('mortgage/applications/view/{id}', [MortgageController::class, 'appview'])
        ->name('mortgage.applications.view');

    // Edit form
    Route::get('/mortgage/applications/{id}/edit', [MortgageController::class, 'appedit'])
        ->name('mortgage.applications.edit');

    // Update
    Route::put('/mortgage/applications/{id}', [MortgageController::class, 'appupdate'])
        ->name('mortgage.applications.update');

    Route::get('applications/show-emi-chart', [MortgageController::class, 'showEmiChart'])
        ->name('mortgage.applications.view-buttons.show-emi-chart');



    // Disbursement Mortgage Loan
    Route::get('disbursements/index', [MortgageDisbursementController::class, 'index'])
        ->name('mortgage.disbursements.index');
    Route::post('disbursements/cancel/{id}', [MortgageDisbursementController::class, 'cancelLoan'])
        ->name('mortgage.disbursements.cancel'); // unique name
        
    // disburse-loan page   
    Route::get('disbursements/disburse-loan/{id}', [MortgageDisbursementController::class, 'show'])
        ->name('mortgage.disbursements.disburse-loan');
    Route::post('disbursements/store', [MortgageDisbursementController::class, 'store'])
        ->name('mortgage.disbursements.store');


    // Mortgage Loan Account Page
    Route::get('account/index', [MortgageAccountController::class, 'index'])
        ->name('mortgage.account.index');

    // line property
    Route::get('lineproperty/index', [MortgageController::class, 'linepropertyindex'])
        ->name('mortgage.lineproperty.index');
    // Download excel sheet
    Route::get('ornaments/export', [MortgageController::class, 'exportXls'])->name('mortgage.lineproperty.export');
});


/////////////////////////////////////   END Mortgage LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   DEPOSIT LOAN  REPORT  ////////////////////////////////////////////////////////


Route::group(['prefix' => 'loanagainst'], function () {

    // loanagainst Loan Scheme
    Route::get('scheme/index', [LoanAgainstController::class, 'index'])
        ->name('loanagainst.schemes.index');

    // create form
    Route::get('scheme/create', [LoanAgainstController::class, 'create'])
        ->name('loanagainst.schemes.create');
    // store form data
    Route::post('scheme/store', [LoanAgainstController::class, 'store'])
        ->name('loanagainst.schemes.store');

    // view list
    Route::get('scheme/{id}', [LoanAgainstController::class, 'show'])
        ->name('loanagainst.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [LoanAgainstController::class, 'edit'])
        ->name('loanagainst.schemes.edit');
    Route::put('scheme/{id}', [LoanAgainstController::class, 'update'])
        ->name('loanagainst.schemes.update');

    Route::get('scheme/view/{id}', [LoanAgainstController::class, 'view'])
        ->name('loanagainst.schemes.view');

    // loanagainst Loan Calculation
    Route::get('calculator/index', [LoanAgainstController::class, 'calculator'])
        ->name('loanagainst.calculator.index');
    // get scheme data
    Route::get('loanagainst/scheme/{id}', [LoanAgainstController::class, 'getSchemeDetails'])
        ->name('loanagainst.scheme.details');

    // Calculation page  
    Route::get('calculator/calculation', [LoanAgainstController::class, 'calculation'])->name('loanagainst.calculator.calculation');
    Route::post('loanagainst/calculate', [LoanAgainstController::class, 'calculateResult'])->name('loanagainst.calculator.calculate');


    // loanagainst Application page
    Route::get('applications/index', [LoanAgainstController::class, 'appindex'])
        ->name('loanagainst.applications.index');

    Route::get('applications/create', [LoanAgainstController::class, 'appcreate'])
        ->name('loanagainst.applications.create');
    
    Route::post('/loan-against/store', [LoanAgainstController::class, 'storeLoanApplication'])->name('loan-against.store');

    Route::get('/members/{id}/info', [LoanAgainstController::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('loanagainst/applications/view/{id}', [LoanAgainstController::class, 'appview'])
        ->name('loanagainst.applications.view');

    // Edit form
    Route::get('/loanagainst/applications/{id}/edit', [LoanAgainstController::class, 'appedit'])
        ->name('loanagainst.applications.edit');

    // Update
    Route::put('/loanagainst/applications/{id}', [LoanAgainstController::class, 'appupdate'])
        ->name('loanagainst.applications.update');

    Route::get('applications/show-emi-chart', [LoanAgainstController::class, 'showEmiChart'])
        ->name('loanagainst.applications.view-buttons.show-emi-chart');


    // Disbursement loanagainst Loan
    Route::get('disbursements/index', [LoanAgainstDisbursementController::class, 'index'])
        ->name('loanagainst.disbursements.index');
    Route::post('/loanagainst/disbursements/cancel/{id}', [LoanAgainstDisbursementController::class, 'cancelLoan'])->name('disbursements.cancel');

    // disburse-loan page   
    Route::get('disbursements/disburse-loan/{id}', [LoanAgainstDisbursementController::class, 'show'])
        ->name('loanagainst.disbursements.disburse-loan');
    Route::post('/loanagainst/disbursements/store', [LoanAgainstDisbursementController::class, 'store'])->name('disbursements.store');


    // loanagainst Loan Account Page
    Route::get('account/index', [LoanAgainstAccountController::class, 'index'])
        ->name('loanagainst.account.index');

    // line property
    Route::get('lineproperty/index', [LoanAgainstController::class, 'linepropertyindex'])
        ->name('loanagainst.lineproperty.index');
    // Download excel sheet
    Route::get('loanagainst/export', [LoanAgainstController::class, 'exportXls'])->name('loanagainst.lineproperty.export');
});


/////////////////////////////////////   END DEPOSIT LOAN  REPORT   ////////////////////////////////////////////////////////

/////////////////////////////////////   business LOAN    ////////////////////////////////////////////////////////


Route::group(['prefix' => 'business'], function () {

    // business Loan Scheme
    Route::get('scheme/index', [BussinessController::class, 'index'])
        ->name('business.schemes.index');

    // create form
    Route::get('scheme/create', [BussinessController::class, 'create'])
        ->name('business.schemes.create');
    // store form data
    Route::post('scheme/store', [BussinessController::class, 'store'])
        ->name('business.schemes.store');

    // view list
    Route::get('scheme/{id}', [BussinessController::class, 'show'])
        ->name('business.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [BussinessController::class, 'edit'])
        ->name('business.schemes.edit');
    Route::put('scheme/{id}', [BussinessController::class, 'update'])
        ->name('business.schemes.update');

    Route::get('scheme/view/{id}', [BussinessController::class, 'view'])
        ->name('business.schemes.view');

    // business Loan Calculation
    Route::get('calculator/index', [BussinessController::class, 'calculator'])
        ->name('business.calculator.index');
    // get scheme data
    Route::get('business/scheme/{id}', [BussinessController::class, 'getSchemeDetails'])
        ->name('business.scheme.details');

    // Calculation page  
    Route::get('calculator/calculation', [BussinessController::class, 'calculation'])->name('business.calculator.calculation');
    Route::post('business/calculate', [BussinessController::class, 'calculateResult'])->name('business.calculator.calculate');


    // business Application page
    Route::get('applications/index', [BussinessController::class, 'appindex'])
        ->name('business.applications.index');

    Route::get('applications/create', [BussinessController::class, 'appcreate'])
        ->name('business.applications.create');
    
    Route::post('/loan-against/store', [BussinessController::class, 'storeLoanApplication'])->name('bussiness-loan.store');

    Route::get('/members/{id}/info', [BussinessController::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('business/applications/view/{id}', [BussinessController::class, 'appview'])
        ->name('business.applications.view');

    // Edit form
    Route::get('/business/applications/{id}/edit', [BussinessController::class, 'appedit'])
        ->name('business.applications.edit');

    // Update
    Route::put('/business/applications/{id}', [BussinessController::class, 'appupdate'])
        ->name('business.applications.update');

    Route::get('applications/show-emi-chart', [BussinessController::class, 'showEmiChart'])
        ->name('business.applications.view-buttons.show-emi-chart');


    // Disbursement business Loan
    Route::get('disbursements/index', [BussinessDisbursementController::class, 'index'])
        ->name('business.disbursements.index');
    Route::post('/business/disbursements/cancel/{id}', [BussinessDisbursementController::class, 'cancelLoan'])->name('disbursements.cancel');

    // disburse-loan page   
    Route::get('disbursements/disburse-loan/{id}', [BussinessDisbursementController::class, 'show'])
        ->name('loanagainst.disbursements.disburse-loan');
    Route::post('/loanagainst/disbursements/store', [BussinessDisbursementController::class, 'store'])->name('disbursements.store');


    // business Loan Account Page
    Route::get('account/index', [BussinessController::class, 'index'])
        ->name('business.account.index');

});


/////////////////////////////////////   END BUSSINESS LOAN    ////////////////////////////////////////////////////////


Route::group(['prefix' => 'hr-managment'], function () {
    Route::resource('employee', HRController::class);
});

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::get('/social-network', [SettingsController::class, 'socialNetwork'])->name('social.network');
    Route::get('/notification', [SettingsController::class, 'notification'])->name('notification');
    Route::get('/payment-limit', [SettingsController::class, 'paymentLimit'])->name('payment.limit');
    Route::post('/update-password', [SettingsController::class, 'updatePassword'])->name('update-password');
});

Route::group(['prefix' => 'support', 'as' => 'support.'], function () {
    Route::get('/help-center', [SupportController::class, 'helpCenter'])->name('help.center');
    Route::get('/privacy-policy', [SupportController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::get('/contact-us', [SupportController::class, 'contactUs'])->name('contact.us');
});
Route::prefix('fd_account/calculator')->name('calculator.')->group(function () {
    Route::get('/create', [CalculatorController::class, 'create'])->name('create');
    Route::post('/store', [CalculatorController::class, 'store'])->name('store');
});

Route::get('/dev/run/{action}', function ($action) {
    try {
        switch ($action) {
            case 'clear':
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                return "Cleared config, cache, route, and view.";

            case 'migrate':
                Artisan::call('session:table');
                Artisan::call('migrate');
                return "Migration completed successfully!";

            case 'migrate-fresh':
                Artisan::call('migrate:fresh', ['--seed' => true]);
                return "Fresh migration and seed completed!";

            case 'seed':
                Artisan::call('db:seed');
                return "Database seeding completed!";
            case 'storage-link':
                Artisan::call('storage:link');
                $output = Artisan::output();
                return "Storage link created!"  . nl2br($output);
            case 'install':
                exec('composer install');
                return "composer install executed!";
            default:
                return "Invalid action: $action";
        }
    } catch (\Exception $e) {
        return "Error running action [$action]: " . $e->getMessage();
    }
});
