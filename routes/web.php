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
use App\Http\Controllers\KycDocumentsController;
// use App\Http\Middleware\CheckCustomHeader;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\FdCalculatorController;
use App\Http\Controllers\RDCalculatorController;
use App\Http\Controllers\DdsAccountsController;
use App\Http\Controllers\FDController;
use App\Http\Controllers\GoldLoanController;
use App\Http\Controllers\MDSController;
use App\Http\Controllers\MisaccountController;
use App\Http\Controllers\MortgageLoneController;
use App\Http\Controllers\RdAccountController;
use App\Http\Controllers\RdschemesController;
use App\Http\Controllers\PassbookController;

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
        Route::delete('transactions/{id}/soft-delete', [MemberController::class, 'softDeleteTransaction'])->name('transactions.softDelete');
        Route::get('/members/transactions/{id}/print', [MemberController::class, 'printTransaction'])->name('transactions.print');
        Route::get('/members/{id}/transactions/other-charges/list', [MemberController::class, 'otherChargesList'])->name('members.other-charges.list');
        Route::delete('/member-other-charges/{id}/delete', [MemberController::class, 'softDeleteothercharges'])->name('transactions.softDelete');
        // Route to show the form for clearing dues (GET request)
        Route::get('members/{id}/transactions/other-charges/{chargeId}/clear-due', [MemberController::class, 'showClearDueForm'])
            ->name('members.other-charges.clearDue.form');
        // Route to handle clearing dues (POST request)
        Route::post('members/{id}/transactions/other-charges/{chargeId}/clear-due', [MemberController::class, 'storeChargesDue'])
            ->name('members.other-charges.clearDue.handle');


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
    Route::get('/accounts/passbook/search', [AccountsController::class, 'passbookSearch'])->name('accounts.passbook.search');


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
});

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

// Gold Loan
Route::group(['prefix' => 'gold-loan'], function () {
    Route::get('scheme/index', [GoldLoanController::class, 'index'])
        ->name('gold-loan.schemes.index');

    Route::get('scheme/create', [GoldLoanController::class, 'create'])
        ->name('gold-loan.schemes.create');

    Route::get('scheme/view', [GoldLoanController::class, 'view'])
        ->name('gold-loan.schemes.view');

    Route::get('calculator/index', [GoldLoanController::class, 'calculator'])
        ->name('gold-loan.calculator.index');

    Route::get('calculator/calculation', [GoldLoanController::class, 'calculation'])
        ->name('gold-loan.calculator.calculation');

    Route::get('applications/index', [GoldLoanController::class, 'appindex'])
        ->name('gold-loan.applications.index');

    Route::get('applications/create', [GoldLoanController::class, 'appcreate'])
        ->name('gold-loan.applications.create');
    Route::get('applications/view', [GoldLoanController::class, 'appview'])
        ->name('gold-loan.applications.view');


    Route::get('applications/show-emi-chart', [GoldLoanController::class, 'showEmiChart'])
        ->name('gold-loan.applications.view-buttons.show-emi-chart');

    Route::get('applications/disburse-setting', [GoldLoanController::class, 'showdisbursesetting'])
        ->name('gold-loan.applications.view-buttons.disburse-setting');

    Route::get('applications/col_process_fee', [GoldLoanController::class, 'col_process_fee'])
        ->name('gold-loan.applications.view-buttons.col_process_fee');

    Route::get('applications/upload_documents', [GoldLoanController::class, 'upload_documents'])
        ->name('gold-loan.applications.upload_documents');

    Route::get('applications/upload-cibil-score', [GoldLoanController::class, 'upload_cibil_score'])
        ->name('gold-loan.applications.upload-cibil-score');
});

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
