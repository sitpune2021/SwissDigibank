<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BusinessLoanPrintDocumentController;
use App\Http\Controllers\CollectionCenterController;
use App\Http\Controllers\EmployeeAttendenceController;
use App\Http\Controllers\GroupCommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LogoImgUploadController;
use App\Http\Controllers\MasterSettingController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\PrintDocumentsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\SoftwareSettingsController;
use App\Http\Controllers\UnencumberedDepositController;
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
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\RDCalculatorController;
use App\Http\Controllers\DdsAccountsController;
use App\Http\Controllers\FDController;
use App\Http\Controllers\GoldLoanAccountController;
use App\Http\Controllers\GoldLoanController;
use App\Http\Controllers\PersonalDisbursementController;
use App\Http\Controllers\PersonalAccountController;
use App\Http\Controllers\MDSController;
use App\Http\Controllers\MisaccountController;
use App\Http\Controllers\RdAccountController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RdschemesController;
use App\Http\Controllers\PassbookController;
use App\Http\Controllers\MortgageController;
use App\Http\Controllers\LoanAgainstController;
use App\Http\Controllers\LoanAgainstAccountController;
use App\Http\Controllers\LoanAgainstDisbursementController;
use App\Http\Controllers\MortgageDisbursementController;
use App\Http\Controllers\MortgageAccountController;
use App\Helpers\SmsHelper;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\BusinessLoan;
use App\Http\Controllers\CcOdLoanController;
use App\Http\Controllers\FixedLoanDisburments;
use App\Http\Controllers\CcOdLoanControllerDisburments;
use App\Http\Controllers\CcOdLoanControllerAccount;
use App\Http\Controllers\BusinessLoanDisburments;
use App\Http\Controllers\BusinessLoanAccount;
use App\Http\Controllers\CutReportController;
use App\Http\Controllers\DailyWeeklyController;
use App\Http\Controllers\DailyWeeklyDisburments;
use App\Http\Controllers\DailyWeeklyAccount;
use App\Http\Controllers\FixedLoanAccount;
use App\Http\Controllers\DaybookController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LedgergroupController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\PaymentsToCollectController;
use App\Http\Controllers\VehicalDisbursementController;
use App\Http\Controllers\VehicalController;
use App\Http\Controllers\VehicalAccountController;
use App\Http\Controllers\VehicalDistributorController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\SessionProtection;
use App\Http\Controllers\EmployeeAkash;
use App\Http\Controllers\GoldLoanPrintDocument;
use App\Http\Controllers\FixedLoanController;
use App\Http\Controllers\AgriculturController;
use App\Http\Controllers\MortgageLoanPrintDocumentController;
use App\Http\Controllers\PersonalLoanPrintDocumentController;
use App\Http\Controllers\VehicleLoanPrintDocumentController;



Route::view('/privacy-policy', 'privacy-policy')
    ->name('privacy.policy');

Route::middleware(['guest', SessionProtection::class])->group(function () {
    Route::get('/', [AuthenticationController::class, 'signIn'])->name('sign.in');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('log.in');
    Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('reset.password');
});

Route::middleware('auth.user')->group(function () {
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('log.out');

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
        Route::post('/branch/toggle-status', [BranchController::class, 'toggleStatus'])
            ->name('branch.toggle.status');

        Route::get('/ajax/branches/search', [BranchController::class, 'search'])->name('ajax.branches.search');
        Route::resource('promotor', PromotorController::class);
        Route::get('/promotor/{id}/address', [PromotorController::class, 'addressedit'])->name('promotor.address');
        Route::put('/promotor/{id}/address', [PromotorController::class, 'addressupdate'])->name('promotor.address.update');
        Route::get('/company/promotor/{id}/documents', [PromotorController::class, 'documentShow'])->name('promotor.document');
        Route::post('/company/promotor/{id}/documents/update', [PromotorController::class, 'documentUpdate'])->name('promoter.documentupdate');
        // Show edit nominee page
        Route::get('/promotor/{id}/nominee/edit', [PromotorController::class, 'editNominee'])
            ->name('nominee.edit');

        //kyc status
        // Route::post('/promotor-kyc/{id}/status', [PromotorController::class, 'updateStatus'])
        //     ->name('promotor-kyc.updateStatus');

        // Save updated nominee
        Route::put('/promotor/{id}/nominee', [PromotorController::class, 'updateNominee'])
            ->name('nominee.update');
        Route::get('/promotor/{id}/transactions', [PromotorController::class, 'viewTransactions'])->name('promotor.transactions');


        Route::resource('shareholding', ShareHoldingController::class);
        Route::post('shareholding/transfer', [ShareholdingController::class, 'IsTransforror'])
            ->name('shareholding.transfer');
        Route::resource('director', DirectorController::class);
        //------------------------------18-12-2025------------------------------------------//
        Route::resource('unencumbered-deposits', UnencumberedDepositController::class);
        Route::resource('bank-account', BankAccountController::class);
    });

    // Route::group(['prefix' => 'user'], function () {
    //     Route::resource('roles', RoleController::class);
    //     Route::resource('users', UserController::class);
    // });

    // Route::post('/role-permission-store', [RoleController::class, 'store'])->name('role_permission.store');

    Route::group(['prefix' => 'user'], function () {

        // ROLES ROUTES
        Route::get('/roles', [RoleController::class, 'index'])
            ->name('roles.index');

        Route::get('/roles/create', [RoleController::class, 'create'])
            ->name('roles.create');

        Route::post('/roles', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::get('/roles/{id}', [RoleController::class, 'show'])
            ->name('roles.show');

        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])
            ->name('roles.edit');

        Route::put('/roles/{id}', [RoleController::class, 'update'])
            ->name('roles.update');

        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])
            ->name('roles.destroy');


        // USERS ROUTES
        Route::resource('users', UserController::class);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/calculator', [CalculatorController::class, 'create'])->name('calculator.index');
        Route::get('/calculator/create', [CalculatorController::class, 'create'])->name('calculator.create');
        Route::post('/calculator/store', [CalculatorController::class, 'store'])->name('calculator.store');
        Route::get('/calculator/calculate', [CalculatorController::class, 'calculateInvestment'])->name('calculator.calculate');
        Route::post('/calculate-investment', [CalculatorController::class, 'calculateInvestmentAjax'])->name('calculate.investment');
        Route::get('/fetch-schemes', [CalculatorController::class, 'getSchemes'])->name('fd.schemes.fetch');
        Route::get('/fd-scheme-details/{id}', [CalculatorController::class, 'getSchemeDetails'])
            ->name('fd.scheme.details');
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
        // Route::delete('/dds-accounts/transactions/{id}', [DdsAccountsController::class, 'destroyTransaction'])->name('dds-accounts.transactions.destroy');
        Route::delete('/dds-accounts/transactions/{ddsAccountId}/{tranxId}', [DdsAccountsController::class, 'destroyTransaction'])
            ->name('dds-accounts.transactions.destroy');
        Route::get('/dds-accounts/{account}/transactions/{transaction}', [DdsAccountsController::class, 'transactionShow'])
            ->name('dds-accounts.transactions.show');
        Route::put('/ddsaccounts/{ddaccount}/update-member', [DdsAccountsController::class, 'updateMember'])->name('ddsaccounts.updateMember');
        Route::put('/ddsaccounts/{ddaccount}/update-branch', [DdsAccountsController::class, 'updateBranch'])->name('ddsaccounts.updateBranch');
        Route::get('/calculateMaturity', [DdsAccountsController::class, 'calculateMaturity'])->name('ddsaccounts.calculateMaturity');
        Route::get('/dds-accounts/{id}/installments', [DdsAccountsController::class, 'installments'])
            ->name('ddsaccounts.installments');
        Route::get('/dds/{id}/regenerate', [DdsAccountsController::class, 'regenerateInstallment'])
            ->name('dds.installments.regenerate');
        Route::get(
            '/dds-accounts/{id}/installment-receipt/{instNo}',
            [DdsAccountsController::class, 'installmentReceipt']
        )->name('dds.installment.receipt');
        Route::get('/dds-accounts/{id}/transactions/{transaction_id?}', [DdsAccountsController::class, 'transactions'])
            ->name('dds.transactions');
        // Deposit Routes
        Route::get('dds-accounts/{id}/deposit', [DdsAccountsController::class, 'createDeposit'])
            ->name('ddsaccounts.createDeposit');
        Route::post('dds-accounts/{id}/deposit', [DdsAccountsController::class, 'deposit'])
            ->name('ddsaccounts.deposit');
        Route::get('dds-accounts/{id}/withdraw', [DdsAccountsController::class, 'createWithdraw'])
            ->name('ddsaccounts.withdraw-create');
        Route::post('dds-accounts/{id}/withdraw', [DdsAccountsController::class, 'withdraw'])
            ->name('ddsaccounts.withdraw');
        Route::get('dds-accounts/{id}/link-saving-account', [DdsAccountsController::class, 'createLinkSavingAcc'])
            ->name('ddsaccounts.createLinkSavingAcc');
        Route::post(
            'dds-accounts/{id}/link-saving',
            [DdsAccountsController::class, 'storeLinkSavingAcc']
        )->name('ddsaccounts.storeLinkSavingAcc');
        Route::get('ddsaccounts/{id}/unlink', [DdsAccountsController::class, 'confirmUnlink'])
            ->name('ddsaccounts.confirmUnlink');
        Route::post('ddsaccounts/{id}/unlink', [DdsAccountsController::class, 'storeLinkSavingAcc'])
            ->name('ddsaccounts.storeLinkSavingAcc');
        Route::get('dds-accounts/{id}/credit-interest', [DdsAccountsController::class, 'createCreditInterest'])
            ->name('ddsaccounts.createCreditInterest');
        Route::post('dds-accounts/{id}/credit-interest/store', [DdsAccountsController::class, 'storeCreditInterest'])
            ->name('ddsaccounts.storeCreditInterest');
        Route::get('dds-accounts/{id}/mark-lien-account', [DdsAccountsController::class, 'createMarkLienAccount'])
            ->name('ddsaccounts.MarkLienAccount');
        Route::get('/dd/account-nominee/{type}/{id}', [AccountsController::class, 'accountNominee'])->name('dd.accounts.nominee');
        Route::post('/dds-accounts/{type}/{id}', [AccountsController::class, 'saveNominees'])->name('dds-accounts.nominees.save');
        Route::get('/change-account-info/{id}', [DdsAccountsController::class, 'changeAccountInfo'])->name('dd.change.account.info');
        Route::post('/change-account-info/{id}', [DdsAccountsController::class, 'updateAccountInfo'])
            ->name('dd.update.account.info');
        Route::get('/change-minor-info/{id}', [DdsAccountsController::class, 'changeMinorInfo'])->name('ddChange.minor.info');
        Route::post(
            '/ddsaccounts/{id}/update-minor',
            [DdsAccountsController::class, 'updateMinor']
        )->name('ddsaccounts.updateMinor');
        Route::get('/dds-accounts/{id}/fore-close', [DdsAccountsController::class, 'createforeClose'])->name('dds-accounts.fore-close');
        // Route::post('/dds-accounts/{id}/fore-close', [DdsAccountsController::class, 'storeForeClose'])->name('dds-accounts.store-fore-close');
        Route::get('/dds-account/comment/{id}', [DdsAccountsController::class, 'addComment'])->name('dds.addComment');
        Route::post('/dds-account/store-comment/{id}', [DdsAccountsController::class, 'storeComment'])->name('dds.storeComment');
        Route::get('/dds-account/uploadDocuments/{id}', [DdsAccountsController::class, 'uploadDocuments'])->name('dds.uploadDocuments');
        Route::post('/dds-account/storeDocuments/{id}', [DdsAccountsController::class, 'storeDocuments'])->name('dds.storeDocuments');
        Route::delete('/dds-account/{id}', [DdsAccountsController::class, 'destroy'])->name('documents.destroy');
        // Show Account Details
        Route::get('dds-accounts/{id}', [DdsAccountsController::class, 'show'])
            ->name('ddsaccounts.show');
        // Route::get('ddsaccounts/transactions/printReceipt/{id}', [DdsAccountsController::class, 'printReceipt'])->name('dds-accounts.transactions.printReceipt');
        Route::get('ddsaccounts/transactions/printReceipt/{id}/{transactionId}', [DdsAccountsController::class, 'printReceipt'])
            ->name('dds-accounts.transactions.printReceipt');
        Route::get(
            '/print-documents/transaction-receipt/{accountId}/{transactionId}',
            [DdsAccountsController::class, 'printReceipt1']
        )->name('dds.transaction.receipt');

        //print documents
        Route::get('ddsaccounts/bond/{id}', [DdsAccountsController::class, 'ddBondForm'])
            ->name('dd.bond.form');


        Route::get('ddsaccounts/opening-form-view/{id}', [DdsAccountsController::class, 'ddOpeningFormView'])
            ->name('dd.opening-view');
        Route::get('ddsaccounts/opening-form/{id}', [DdsAccountsController::class, 'ddOpeningForm'])
            ->name('dd.opening.form');

        Route::get('ddsaccounts/closing-form-view/{id}', [DdsAccountsController::class, 'ddClosingFormView'])
            ->name('dd.closing-view');
        Route::get('ddsaccounts/closing-form/{id}', [DdsAccountsController::class, 'ddClosingForm'])
            ->name('dd.closing.form');
    });


    // RD route 
    Route::resource('rd-calculator', RDCalculatorController::class)
        ->only(['index', 'create', 'store']);
    Route::get('/rd-schemes/{scheme_code}', [RDCalculatorController::class, 'getScheme']);

    // MEMBER Route
    Route::group(['prefix' => 'members'], function () {
        Route::resource('member', MemberController::class);
        Route::resource('minor', MinorController::class);
        Route::get('/members/{member_id}/add-comment', [MemberController::class, 'addComment'])->name('member.addComment');
        // Route::get('/members/add-comment', [MemberController::class, 'addComment'])->name('member.addComment');
        Route::post('/members/member/store-comment', [MemberController::class, 'storeComment'])->name('member.storeComment');
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
        Route::post('members/{id}/transactions/other-charges/{chargeId}/clear-due', [MemberController::class, 'storeChargesDue'])
            ->name('members.other-charges.clearDue.handle');
        Route::get('/members/receipt/print/{id}', [MemberController::class, 'printReceipt'])
            ->middleware('auth')
            ->name('transactions.print-receipt');
        Route::get('/members/application-form/{id}', [MemberController::class, 'applicationForm'])->name('members.application_form');
        Route::get('/members/{id}/transactions/other-charges', [MemberController::class, 'otherCharges'])
            ->name('members.other-charges');
        Route::post('/members/{id}/transactions/other-charges', [MemberController::class, 'storeOtherCharges'])->name('members.other-charges.store');

        // -------------------------------------Shareholding Route----------------------------------------
        Route::get('/members/members/member/{id}/shareholding', [ShareHoldingController::class, 'shareholding'])->name('members.shareholding');
        Route::get('/shareholding/view/{id}', [ShareholdingController::class, 'viewShareholding'])->name('viewShareholding');
        Route::get('/shareholding/{id}', [MemberController::class, 'shareholding'])->name('shareholding');
        Route::resource('shares-holdings', ShareholdersController::class);
        Route::resource('share-certificates', controller: ShareCertificateController::class);
        Route::resource('share_transfer_histories', ShareTrasferHistoryController::class);

        //-------------------------------------- Form 15 route-------------------------------------------------
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

//---------------------------- Saving Account route-------------------------------------------------------
Route::group(['prefix' => 'saving-current-ac'], function () {
    Route::resource('schemes', SchemesController::class);
    Route::resource('accounts', AccountsController::class);
    Route::get('/saving/passbook/{id}', [AccountsController::class, 'viewPassbook'])->name('saving.passbook');
    Route::post('/accounts/passbook/search', [AccountsController::class, 'passbookSearch'])->name('accounts.passbook.search');
    Route::post('/ajax/get-account-balance', [AccountsController::class, 'getBalance'])->name('ajax.get.account.balance');

    Route::get('/view/{id}/transaction', [AccountTransactionController::class, 'index'])->name('account.transaction');
    Route::resource('transaction', AccountTransactionController::class);
    Route::get('/export-transaction/{id}', [AccountTransactionController::class, 'downloadCsvExample'])->name('export.transaction');
    Route::get('/transaction/{id}/print', [AccountTransactionController::class, 'printReceipt'])->name('transaction.print');

    Route::get('/accounts/other-debit-charges/{id}', [AccountsController::class, 'debitChargeList'])->name('accounts.other.debit-charges');
    Route::get('/accounts/other-charges/{id}', [AccountsController::class, 'otherCharges'])->name('accounts.other.charges');
    Route::post('/saving-other-charges/store/{id}', [AccountsController::class, 'storeOtherCharges'])->name('storeOtherCharges');

    Route::get('/accounts/clear-due/{id}', [AccountsController::class, 'clearDue'])->name('accounts.clear.due');
    Route::post('/saving/other-charge/debit/{id}', [AccountsController::class, 'storeDebitCharge'])
        ->name('saving.other.charge.debit');

    Route::get('/accounts/credit-interest/{id}', [AccountsController::class, 'creditInterest'])->name('accounts.credit.interest');
    Route::post('/store-accounts/credit-interest/{id}', [AccountsController::class, 'storeCreditDebitInterest'])
        ->name('storeCreditDebitInterest');

    Route::get('/accounts/account-nominee/{type}/{id}', [AccountsController::class, 'accountNominee'])->name('saving.accounts.nominee');
    Route::post('accounts/{type}/{id}/nominee/save', [AccountsController::class, 'saveNominees'])->name('accounts.nominees.save');

    Route::get('/accounts/close-account/{id}', [AccountsController::class, 'closeAccount'])->name('saving.accounts.close.account');
    // Preview (Blade)
    Route::get(
        '/saving-account/open-form/{id}',
        [AccountsController::class, 'accountOpenFormPreview']
    )->name('saving.account.openform.preview');
    // Download PDF
    Route::get(
        '/saving-account/{id}/opening-form',
        [AccountsController::class, 'accountOpenFormDownload']
    )->name('saving.account.opening.pdf');

    Route::get('/account/print/{id}', [AccountsController::class, 'printForm'])
        ->name('account.print');
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
    Route::get('/fd-accounts/{id}/transactions', [FdController::class, 'viewTransactions'])->name('fd-accounts.transactions');
    Route::get('/fd-accounts/{account}/transactions/{transaction}', [FdController::class, 'transactionsDetails'])
        ->name('fd-accounts.transactions.details');
    Route::delete('/fd-accounts/transactions/{fdAccountId}/{tranxId}', [FdController::class, 'destroyTransaction'])
        ->name('fd-accounts.transactions.destroy');
    Route::get('fd-accounts/transactions/printReceipt/{id}/{transactionId}', [FdController::class, 'printReceipt'])
        ->name('fd-accounts.transactions.printReceipt');
    Route::get('/change-account-info/{id}', [FdController::class, 'changeAccountInfo'])->name('fd.change.account.info');
    // Update Account Info (FORM SUBMIT)
    Route::post(
        'fd-account/update-info/{id}',
        [FDController::class, 'updateAccountInfo']
    )->name('fd.account.updateInfo');
    Route::get('fd-accounts/{id}/link-saving-account', [FdController::class, 'createLinkSavingAcc'])
        ->name('fd-accounts.createLinkSavingAcc');

    Route::post(
        'fd-accounts/{id}/link-saving',
        [FdController::class, 'storeLinkSavingAcc']
    )->name('fd-accounts.storeLinkSavingAcc');

    Route::get('fd-accounts/{id}/unlink', [FdController::class, 'confirmUnlink'])
        ->name('fd-accounts.confirmUnlink');

    Route::post('fd-accounts/{id}/unlink', [FdController::class, 'storeLinkSavingAcc'])
        ->name('fd-accounts.unlinkSavingAcc');

    Route::get('/fd-account/uploadDocuments/{id}', [FdController::class, 'uploadDocuments'])->name('fd.uploadDocuments');
    Route::post('/fd-account/storeDocuments/{id}', [FdController::class, 'storeDocuments'])->name('fd.storeDocuments');
    Route::delete('/documents/{id}', [FdController::class, 'destroy'])->name('documents.destroy');

    Route::get('/fd-acccount/comment/{id}', [FdController::class, 'addComment'])->name('fd.addComment');
    Route::post('/fd-account/store-comment/{id}', [FdController::class, 'storeComment'])->name('fd.storeComment');
    //////
    Route::get('/fd-account/credit-debit-interest/{id}', [FdController::class, 'creditDebitInterest'])->name('fd-account.creditDebitInterest');
    Route::post('/fd-account/{id}/credit-debit-interest', [FdController::class, 'storeCreditDebitInterestAndTDS'])
        ->name('fd.creditdebit.store');
    Route::get('/fd-account/deduct-reverse-tds/{id}', [FdController::class, 'deductReverseTds'])->name('fd-account.deductReverseTds');
    Route::post('/fd-account/{id}/deduct-reverse-tds', [FdController::class, 'storeCreditDebitInterestAndTDS'])
        ->name('fd.creditdebit.store');

    Route::post('/fetch-fd-slab', [FdController::class, 'fetchSlab'])->name('fd.fetch.slab');

    //////

    Route::get('/fd-add-nominee/{type}/{id}', [AccountsController::class, 'accountNominee'])->name('fd.add.nominee');
    Route::post('fd/{type}/{id}/nominee/save', [AccountsController::class, 'saveNominees'])->name('fd.nominees.save');

    //print document

    Route::get('/fd-bond/view/{id}', [FdController::class, 'fdBondFormView'])
        ->name('fd.bond.view');
    Route::get('/Fd-Bond/{id}', [FdController::class, 'fdBondForm'])
        ->name('fd.bond.form');

    Route::get('/opening-form/view/{id}', [FdController::class, 'fdOpeningFormView'])
        ->name('fd.opening.view');

    Route::get('/opening-form/{id}', [FdController::class, 'fdOpeningForm'])
        ->name('fd.opening.form');

    Route::get('/closing-form/view/{id}', [FdController::class, 'fdClosingFormview'])
        ->name('fd.closing.view');

    Route::get('/closing-form/{id}', [FdController::class, 'fdClosingForm'])
        ->name('fd.closing.form');


    Route::resource('misaccount', MisaccountController::class);
    // Route::get('misaccount/create', [MisaccountController::class, 'create']);
    // Route::get('/misaccount/create/{member}', [MisAccountController::class, 'create']);
    Route::get('/misaccount/payout/{id}', [MisaccountController::class, 'misPayout'])->name('misaccount.mispayout');
    Route::Post('/misaccount/process/payout/{id}', [MisaccountController::class, 'processPayout'])->name('mis.processPayout');

    Route::get('misaccount/link-savings-account/{id}', [MisaccountController::class, 'linkSavingsAccount'])->name('misaccount.linkSavingsAccount');
    Route::post('misaccount/store-linked-savings-account/{id}', [MisaccountController::class, 'storeLinkedSavingsAccount'])->name('misaccount.storeLinkedSavingsAccount');

    //Transactions Info
    Route::get('/misaccount/member/{memberId}/accounts', [MisaccountController::class, 'getByMember']);
    Route::get('/mistransaction/{id}', [MisaccountController::class, 'viewTransaction'])->name('mis.transaction');
    Route::get('/mistransaction/view/{id}', [MisaccountController::class, 'transaction'])->name('mis.transaction.view');
    Route::get('mis/receipt/{id}', [MisaccountController::class, 'printReceipt'])
        ->name('mis.print.receipt');

    //Route::get('fd-mis-schemes/misaccount/{id}/change-account-info', [MisaccountController::class, 'changeAccountInfo'])->name('misaccount.changeAccountInfo');
    // Show change account info form
    Route::get('misaccount/{id}/change-account-info', [MisaccountController::class, 'changeAccountInfo'])
        ->name('misaccount.changeAccountInfo');

    // Update account info (form submit)
    Route::post('misaccount/{id}/change-account-info', [MisaccountController::class, 'updateAccountInfo'])
        ->name('misaccount.updateAccountInfo');

    // Add Nominee
    Route::get('/mis/account-nominee/{type}/{id}', [AccountsController::class, 'accountNominee'])->name('mis.accounts.nominee');
    Route::post('mis/{type}/{id}/nominee/save', [AccountsController::class, 'saveNominees'])->name('mis.nominees.save');


    //edit and update branches
    Route::put('/misaccount/member/{misaccountId}/update-branch', [MisaccountController::class, 'updateBranch'])
        ->name('misaccount.update-branch');

    Route::get('/misaccount/foreclose/{id}', [MisaccountController::class, 'foreclose'])->name('misaccount.foreclose');
    Route::get('/misaccount/{id}/remove-account', [MisaccountController::class, 'removeAccount'])->name('misaccount.removeAccount');

    Route::get('/misaccount/make-lien/{id}', [MisaccountController::class, 'makeLien'])->name('misaccount.makelien');

    Route::get('/misaccount/credit-debit-interest/{id}', [MisaccountController::class, 'creditDebitInterest'])->name('misaccount.creditDebitInterest');
    Route::post('/misaccount/{id}/credit-debit-interest', [MisaccountController::class, 'storeCreditDebitInterestAndTDS'])
        ->name('mis.creditdebit.store');


    Route::get('/misaccount/deduct-reverse-tds/{id}', [MisaccountController::class, 'deductReverseTds'])->name('misaccount.deductReverseTds');
    Route::post('/misaccount/{id}/deduct-reverse-tds', [MisaccountController::class, 'storeCreditDebitInterestAndTDS'])
        ->name('mis.creditdebit.store');

    Route::get('/misaccount/uploadDocuments/{id}', [MisaccountController::class, 'uploadDocuments'])->name('mis.uploadDocuments');
    Route::post('/misaccount/storeDocuments/{id}', [MisaccountController::class, 'storeDocuments'])->name('mis.storeDocuments');
    Route::delete('/documents/{id}', [MisaccountController::class, 'destroy'])->name('documents.destroy');

    Route::get('/misacccount/comment/{id}', [MisaccountController::class, 'addComment'])->name('mis.addComment');
    Route::post('/misaccount/store-comment/{id}', [MisaccountController::class, 'storeComment'])->name('mis.storeComment');

    Route::post('/misaccount/{id}/update-setting', [MisaccountController::class, 'updateSetting'])
        ->name('mis.updateSetting');
    Route::post('/misaccount/{id}/update-setting', [MisaccountController::class, 'updateSetting'])
        ->name('mis.updateSetting');

    //print document
    Route::get('/misaccount/{id}/print-bond-view', [MisaccountController::class, 'misBondPreview'])
        ->name('misaccount.printbond.view');

    Route::get('/misaccount/{id}/print-bond', [MisaccountController::class, 'misBondForm'])->name('misaccount.printbond');
    Route::get('/mis-bond/{id}/print', [MisaccountController::class, 'misBondPrint'])
        ->name('misBondPrint');
    Route::get('/mis-bond/{id}/print-view', [MisaccountController::class, 'misBondPrintView'])
        ->name('misBondPrintView');
    // Preview (Blade)
    Route::get(
        '/mis-opening-form/{id}/view',
        [MisaccountController::class, 'misOpeningFormPreview']
    )->name('misaccount.openingform.preview');
    Route::get('/mis-opening-form/{id}', [MisaccountController::class, 'misOpeningForm'])->name('misaccount.openingform');
    Route::get(
        '/mis-account/{id}/closing-form/view',
        [MisaccountController::class, 'misClosingFormPreview']
    )->name('misaccount.closingform.preview');

    Route::get('/mis-account/{id}/closing-form', [MisaccountController::class, 'misClosingForm'])
        ->name('misaccount.closingform');

    Route::get('/sweep-in-accounts', [FdController::class, 'sweepInAccount'])
        ->name('sweep-in-accounts');
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

    // Add nominee
    Route::get('/rd/account-nominee/{type}/{id}', [AccountsController::class, 'accountNominee'])->name('rd.accounts.nominee');
    Route::post('/accounts/{type}/{id}/save-nominee', [AccountsController::class, 'saveNominees'])->name('rd-accounts.saveNominee');

    Route::get('/rd-accounts/{id}/upload-documents', [RdAccountController::class, 'uploadDocuments'])
        ->name('rd.uploadDocuments');
    Route::post('/rd-accounts/{id}/upload-documents', [RdAccountController::class, 'storeDocuments'])
        ->name('rd.storeDocuments');
    Route::delete('/rd-documents/{id}', [RdAccountController::class, 'destroy'])
        ->name('rd.documents.destroy');

    // add Comments
    Route::get('/rd-accounts/{id}/add-comment', [RdAccountController::class, 'addComment'])->name('rd.addComment');
    Route::post('/rd-accounts/{id}/store-comment', [RdAccountController::class, 'storeComment'])
        ->name('rd.storeComment');

    Route::post('/rdaccount/{id}/update-setting', [RdAccountController::class, 'updateSetting'])->name('rd.updateSetting');

    // print documents
    Route::get('/rdaccount/{id}/print-bond-view', [RdAccountController::class, 'rdBondFormView'])->name('rdaccount.printbondView');

    Route::get('/rdaccount/{id}/print-bond', [RdAccountController::class, 'rdBondForm'])->name('rdaccount.printbond');

    Route::get('/rdaccount/opening-form-view/{id}', [RdAccountController::class, 'rdOpeningFormView'])->name('opening.form-view');
    Route::get('/rdaccount/opening-form/{id}', [RdAccountController::class, 'rdOpeningForm'])->name('opening.form');

    Route::get('/rdaccount/closing-form-view/{id}', [RdAccountController::class, 'rdClosingFormView'])->name('closing.form-view');

    Route::get('/rdaccount/closing-form/{id}', [RdAccountController::class, 'rdClosingForm'])->name('closing.form');
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
    Route::post(
        'applications/{id}/submit-approval',
        [GoldLoanController::class, 'submitForApproval']
    )->name('gold-loan.submit.approval');


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


    // GOld Loan Account Page
    Route::get('account/index', [GoldLoanAccountController::class, 'index'])
        ->name('gold-loan.account.index');

    Route::get('account/show/{id}', [GoldLoanAccountController::class, 'show'])
        ->name('gold-loan.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [GoldLoanAccountController::class, 'saveEmiStatus'])
        ->name('gold-loan.emi.saveStatus');

    // transiction page tab
    Route::get('goldloan-account/transaction/{id}', [GoldLoanAccountController::class, 'goldLoanTransaction'])
        ->name('gold-loan.account.transaction');

    // pay emi tab
    Route::get('goldloan-account/payemi/{id}', [GoldLoanAccountController::class, 'goldLoanPayEmi'])
        ->name('gold-loan.account.pay-emi');
    Route::post('goldloan-account/payemi/{id}/pay', [GoldLoanAccountController::class, 'payEmiLoan'])->name('goldloan.payEmiLoan');

    // only pay tab
    Route::get('goldloan-account/pay/{id}', [GoldLoanAccountController::class, 'goldLoanPay'])
        ->name('gold-loan.account.pay');
    Route::post('/update-emi-status', [GoldLoanAccountController::class, 'updateEmiStatus'])->name('emi.updateStatus');

    Route::post('/goldloan/pay-emi', [GoldLoanAccountController::class, 'payEmi'])->name('goldloan.payEmi');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/gold-loan/{id}/remove', [GoldLoanAccountController::class, 'removeAccount'])
        ->name('goldloan.remove');

    // foure close account
    Route::get('account/fourcloser/{id}', [GoldLoanAccountController::class, 'fourcloser'])
        ->name('gold-loan.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [GoldLoanAccountController::class, 'storeForeCloser'])
        ->name('gold-loan.account.forecloser.store');

    // loan extension
    Route::get('account/extension/{id}', [GoldLoanAccountController::class, 'loanextension'])
        ->name('gold-loan.account.extension');
    // POST - FINAL SAVE
    Route::post('/loan-extension/store/{id}', [GoldLoanAccountController::class, 'storeLoanExtension'])->name('loan.extension.store');

    // link saving account
    Route::get('account/linksaving/{id}', [GoldLoanAccountController::class, 'linksaving'])
        ->name('gold-loan.account.linksaving');
    Route::post('account/linksaving/{id}', [GoldLoanAccountController::class, 'storeSavingAccount'])
        ->name('gold-loan.account.storeSavingAccount');


    // show audit trial
    Route::get('account/audit', [GoldLoanAccountController::class, 'audit'])
        ->name('gold-loan.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/gold-loan/{id}/debit-charges-list', [GoldLoanAccountController::class, 'showDebitChargesList'])
        ->name('gold-loan.debitChargesList.form');

    Route::get('/gold-loan/{id}/debit-other-charges', [GoldLoanAccountController::class, 'DebitOtherCharges'])
        ->name('gold-loan.debitOtherCharges.form');

    // Store/Process Debit Other Charges
    Route::post('/gold-loan/{id}/debit-other-charges', [GoldLoanAccountController::class, 'storeDebitOtherCharges'])
        ->name('gold-loan.debitOtherCharges.store');

    Route::get('/gold-loan/{id}/clear-due', [GoldLoanAccountController::class, 'goldLoanClearDues'])
        ->name('gold-loan.clear-due.form');

    Route::post('/gold-loan/{loan_id}/other-charge', [GoldLoanAccountController::class, 'clearDue'])->name('gold-loan.clear-due');

    // Fore close functionality
    Route::post('/gold-loan/foreclose/{loan_id}', [GoldLoanAccountController::class, 'foreClose'])
        ->name('goldloan.foreclose');

    // commnets and documents route
    Route::get('gold-loan/{id}/add-comment', [GoldLoanAccountController::class, 'addComment'])
        ->name('goldloan.addComment');

    Route::post('gold-loan/store-comment', [GoldLoanAccountController::class, 'storeComment'])
        ->name('goldloan.storeComment');

    // other pages url
    Route::get('applications/disburse-setting', [GoldLoanController::class, 'showdisbursesetting'])
        ->name('gold-loan.applications.view-buttons.disburse-setting');

    Route::get('applications/col_process_fee', [GoldLoanController::class, 'col_process_fee'])
        ->name('gold-loan.applications.view-buttons.col_process_fee');

    Route::get('applications/upload_documents', [GoldLoanController::class, 'upload_documents'])
        ->name('gold-loan.applications.upload_documents');

    Route::get('applications/upload-cibil-score', [GoldLoanController::class, 'upload_cibil_score'])
        ->name('gold-loan.applications.upload-cibil-score');


    // Collect Processing fee page in application view page
    Route::get('applications/col-process-fee/{id}', [GoldLoanController::class, 'col_process_fee'])
        ->name('gold-loan.applications.view-buttons.col_process_fee');
    Route::post('applications/col-process-fee/store/{id}', [GoldLoanController::class, 'storeProcessFee'])
        ->name('gold-loan.col_process_fee.store');

    Route::post('applications/{id}/submit-for-approval', [GoldLoanController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');

    // Show EMI chart in a new tab
    Route::get('applications/{id}/emi-chart', [GoldLoanController::class, 'emiChart'])
        ->name('gold-loan.applications.view-buttons.show-emi-chart');

    // Disbusrment setting
    Route::get('applications/{id}/disbursment', [GoldLoanController::class, 'disbursment'])
        ->name('gold-loan.applications.view-buttons.disburse-setting');

    Route::get('disburse-setting/{id}', [GoldLoanController::class, 'showdisbursesetting'])->name('disburse.setting');

    // Print Document
    //Route::get('agreement', [GoldLoanPrintDocument::class, 'loan_agreement'])->name('loan.agreement.pdf');
    Route::get(
        '/loan/{loan}/loan-agreement-view',
        [GoldLoanPrintDocument::class, 'loanAgreementView']
    )->name('loan.loanAgreement-view');
    Route::get(
        '/loan/{loan}/loan-agreement',
        [GoldLoanPrintDocument::class, 'loanAgreement']
    )->name('loan.loanAgreement');

    Route::get('/disburse-letter-view/{loan}', [GoldLoanPrintDocument::class, 'disburse_letter_view'])
        ->name('loan.disburse_letter.view');

    Route::get('/disburse-letter/{loan}', [GoldLoanPrintDocument::class, 'disburse_letter'])
        ->name('loan.disburse_letter.pdf');

    Route::get('/letter-udertaking-gold-view/{loan}', [GoldLoanPrintDocument::class, 'letter_udertaking_gold_view'])->name('loan.letter_udertaking_gold-view');
    Route::get('/letter-udertaking-gold/{loan}', [GoldLoanPrintDocument::class, 'letter_udertaking_gold'])->name('loan.letter_udertaking_gold.pdf');

    Route::get('/payout-chart-view/{loan}', [GoldLoanPrintDocument::class, 'payout_chart_gold_appli_view'])->name('loan.payout_chart_loan_application_view');
    Route::get('/payout-chart/{loan}', [GoldLoanPrintDocument::class, 'payout_chart_gold_appli'])->name('loan.payout_chart_loan_application.pdf');

    Route::get('/promissory-note-view/{loan}', [GoldLoanPrintDocument::class, 'promisary_note_view'])->name('loan.gold_loan_application-view-promisary');

    Route::get('/promissory-note/{loan}', [GoldLoanPrintDocument::class, 'promisary_note'])->name('loan.payout_chart_gold_loan_application.pdf');


    Route::get('/gold-loan-app/sanction-letter-view/{loan}', [GoldLoanPrintDocument::class, 'sanction_letter_view'])->name('loan.sanction_letter-view');
    Route::get('/gold-loan-app/sanction-letter/{loan}', [GoldLoanPrintDocument::class, 'sanction_letter'])->name('loan.sanction_letter.pdf');
    Route::get('/gold-loan-app/pplication-letter-view/{loan}', [GoldLoanPrintDocument::class, 'application_letter_view'])->name('loan.application-letter-view');
    Route::get('/gold-loan-app/application-letter/{loan}', [GoldLoanPrintDocument::class, 'application_letter'])->name('loan.application_letter.pdf');
    Route::get('/gold-loan-app/application-letter-print/{loan}', [GoldLoanPrintDocument::class, 'print_application_letter'])->name('loan.application_letter_print.pdf');

    Route::get('/gold-loan-app/letter-of-evidencing-view/{loan}', [GoldLoanPrintDocument::class, 'letterOf_evidencing_view'])->name('loan.letter-of-evidencing-view.pdf');
    Route::get('/gold-loan-app/letter-of-evidencing/{loan}', [GoldLoanPrintDocument::class, 'letterOf_evidencing'])->name('loan.letter-of-evidencing.pdf');
    Route::get('/gold-loan-app/letter-of-evidencing-print/{loan}', [GoldLoanPrintDocument::class, 'print_letterOf_evidencing'])->name('loan.letter-of-evidencing-print.pdf');


    Route::get('/gold-loan-app/letter-of-jurisdiction-view/{loan}', [GoldLoanPrintDocument::class, 'jurisdiction_ack_letter_view'])->name('loan.letter-of-jurisdiction-view.pdf');
    Route::get('/gold-loan-app/letter-of-jurisdiction/{loan}', [GoldLoanPrintDocument::class, 'jurisdiction_ack_letter'])->name('loan.letter-of-jurisdiction.pdf');
    Route::get(
        '/gold-loan-app/emi-receipt-view/{loan}/{emiNo}',
        [GoldLoanPrintDocument::class, 'emi_receipt_view']
    )->name('gold-loan.emi_receipt.view');

    Route::get(
        '/gold-loan-app/emi-receipt/{loan}/{emiNo}',
        [GoldLoanPrintDocument::class, 'emi_receipt_pdf']
    )->name('gold-loan.emi_receipt.pdf');

    Route::get(
        '/gold-loan-app/emi-receipt-print/{loan}/{emiNo}',
        [GoldLoanPrintDocument::class, 'emi_receipt_print']
    )->name('gold-loan.emi_receipt.print');
});


/////////////////////////////////////   END GOLD LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   Mortgage LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'mortgage'], function () {

    Route::get('scheme/index', [MortgageController::class, 'index'])->name('mortgage.schemes.index');
    Route::get('scheme/create', [MortgageController::class, 'create'])->name('mortgage.schemes.create');
    Route::post('scheme/store', [MortgageController::class, 'store'])->name('mortgage.schemes.store');
    Route::get('scheme/{id}', [MortgageController::class, 'show'])->name('mortgage.schemes.show');
    Route::get('scheme/{id}/edit', [MortgageController::class, 'edit'])->name('mortgage.schemes.edit');
    Route::put('scheme/{id}', [MortgageController::class, 'update'])->name('mortgage.schemes.update');
    Route::get('scheme/view/{id}', [MortgageController::class, 'view'])->name('mortgage.schemes.view');

    Route::get('calculator/index', [MortgageController::class, 'calculator'])->name('mortgage.calculator.index');
    Route::get('scheme/{id}/details', [MortgageController::class, 'getSchemeDetails'])->name('mortgage.scheme.details');
    Route::get('calculator/calculation', [MortgageController::class, 'calculation'])->name('mortgage.calculator.calculation');
    Route::post('calculate', [MortgageController::class, 'calculateResult'])->name('mortgage.calculator.calculate');

    Route::get('applications/index', [MortgageController::class, 'appindex'])->name('mortgage.applications.index');
    Route::get('applications/create', [MortgageController::class, 'appcreate'])->name('mortgage.applications.create');
    Route::post('loan-applications/store', [MortgageController::class, 'storeLoanApplication'])->name('mortgage.store');
    Route::get('members/{id}/info', [MortgageController::class, 'getMemberInfo'])->name('members.info');
    Route::get('applications/view/{id}', [MortgageController::class, 'appview'])->name('mortgage.applications.view');
    Route::get('applications/{id}/edit', [MortgageController::class, 'appedit'])->name('mortgage.applications.edit');
    Route::put('applications/{id}', [MortgageController::class, 'appupdate'])->name('mortgage.applications.update');
    Route::get('applications/show-emi-chart', [MortgageController::class, 'showEmiChart'])->name('mortgage.applications.view-buttons.show-emi-chart');
    // show audit trial tab
    Route::get('applications/audit', [MortgageAccountController::class, 'audit'])
        ->name('mortgage.applications.audit-trail');

    Route::get('disbursements/index', [MortgageDisbursementController::class, 'index'])->name('mortgage.disbursements.index');
    Route::post('disbursements/cancel/{id}', [MortgageDisbursementController::class, 'cancelLoan'])->name('mortgagedisbursements.cancel');
    Route::get('disbursements/disburse-loan/{id}', [MortgageDisbursementController::class, 'show'])->name('mortgage.disbursements.disburse-loan');
    Route::post('disbursements/store', [MortgageDisbursementController::class, 'store'])->name('mortgagedisbursements.store');

    Route::get('mortgage-loan/{id}/add-comment', [MortgageAccountController::class, 'addComment'])
        ->name('mortgageloan.addComment');

    Route::post('mortgage-loan/store-comment', [MortgageAccountController::class, 'storeComment'])
        ->name('mortgageloan.storeComment');

    // account section start
    Route::get('account/index', [MortgageAccountController::class, 'index'])->name('mortgage.account.index');
    Route::get('account/show/{id}', [MortgageAccountController::class, 'show'])
        ->name('mortgage.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [MortgageAccountController::class, 'saveEmiStatus'])
        ->name('mortgage.emi.saveEmiStatus');

    // pay emi tab
    Route::get('mortgage-account/payemi/{id}', [MortgageAccountController::class, 'mortgagePayEmi'])
        ->name('mortgage.account.pay-emi');
    Route::post('mortgage-account/payemi/{id}/pay', [MortgageAccountController::class, 'mortgagepayEmiLoan'])->name('mortgage.payEmiLoan');

    // View Transction tab
    Route::get('mortgage-account/transaction/{id}', [MortgageAccountController::class, 'mortgageTransaction'])
        ->name('mortgage.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [MortgageAccountController::class, 'loanextension'])
        ->name('mortgage.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [MortgageAccountController::class, 'storeLoanExtension'])->name('mortgageloan.extension.store');

    // only pay tab
    Route::get('mortgage-account/pay/{id}', [MortgageAccountController::class, 'mortgagePay'])
        ->name('mortgage.account.pay');
    Route::post('/update-emi-status', [MortgageAccountController::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/mortgage/pay-emi', [MortgageAccountController::class, 'payEmi'])->name('mortgage.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [MortgageAccountController::class, 'fourcloser'])
        ->name('mortgage.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [MortgageAccountController::class, 'storeForeCloser'])
        ->name('mortgage.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [MortgageAccountController::class, 'linksaving'])
        ->name('mortgage.account.linksaving');
    Route::post('account/linksaving/{id}', [MortgageAccountController::class, 'storeSavingAccount'])
        ->name('mortgage.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/mortgage/{id}/remove', [MortgageAccountController::class, 'removeAccount'])
        ->name('mortgage.remove');

    // show audit trial tab
    Route::get('account/audit', [MortgageAccountController::class, 'audit'])
        ->name('mortgage.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/mortgage/{id}/debit-charges-list', [MortgageAccountController::class, 'showDebitChargesList'])
        ->name('mortgage.debitChargesList.form');
    // debit other charge page    
    Route::get('/mortgage/{id}/debit-other-charges', [MortgageAccountController::class, 'DebitOtherCharges'])
        ->name('mortgage.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/mortgage/{id}/debit-other-charges', [MortgageAccountController::class, 'storeDebitOtherCharges'])
        ->name('mortgage.debitOtherCharges.store');

    //clear due 
    Route::get('/mortgage/{id}/clear-due', [MortgageAccountController::class, 'mortgageLoanClearDues'])
        ->name('mortgage.clear-due.form');
    Route::post('/mortgage/{loan_id}/other-charge', [MortgageAccountController::class, 'clearDue'])->name('mortgage.clear-due');

    // account section end

    Route::get('lineproperty/index', [MortgageController::class, 'linepropertyindex'])->name('mortgage.lineproperty.index');
    Route::get('lineproperty/export', [MortgageController::class, 'exportLineProperty'])->name('mortgage.lineproperty.export');
    Route::get('{id}/emi-chart', [MortgageController::class, 'emiChart'])->name('mortgage.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [MortgageController::class, 'mortgagecol_process_fee'])
        ->name('mortgage.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [MortgageController::class, 'mortgagestoreProcessFee'])
        ->name('mortgage.col_process_fee.store');
    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');

    //print documents view page  
    Route::get('/payout-chart-view/{loan}', [MortgageLoanPrintDocumentController::class, 'payout_chart_mortgage_appli_view'])->name('mortgage_loan.payout_chart_loan_application_view');
    Route::get('/payout-chart/{loan}', [MortgageLoanPrintDocumentController::class, 'payout_chart_mortgage_appli'])->name('mortgage_loan.payout_chart_loan_application.pdf');

    Route::get('/sanction-letter-view/{loan}', [MortgageLoanPrintDocumentController::class, 'sanction_letter_view'])->name('mortgage_loan.sanction_letter-view');
    Route::get('/sanction-letter/{loan}', [MortgageLoanPrintDocumentController::class, 'sanction_letter'])->name('mortgage_loan.sanction_letter.pdf');

    Route::get('/{loan}/loan-agreement-view', [MortgageLoanPrintDocumentController::class, 'loanAgreementView'])->name('mortgage_loan.loanAgreement-view');
    Route::get('/{loan}/loan-agreement', [MortgageLoanPrintDocumentController::class, 'loanAgreement'])->name('mortgage_loan.loanAgreement.pdf');

    Route::get('/disburse-letter-view/{loan}', [MortgageLoanPrintDocumentController::class, 'disburse_letter_view'])->name('mortgage_loan.disburse_letter.view');
    Route::get('/disburse-letter/{loan}', [MortgageLoanPrintDocumentController::class, 'disburse_letter'])->name('mortgage_loan.disburse_letter.pdf');

    Route::get('/promissory-note-view/{loan}', [MortgageLoanPrintDocumentController::class, 'promissory_note_view'])->name('mortgage_loan.promissory.view');
    Route::get('/promissory-note/{loan}', [MortgageLoanPrintDocumentController::class, 'promissory_note'])->name('mortgage_loan.promissory.pdf');

    Route::get('/undertaking-letter-view/{loan}', [MortgageLoanPrintDocumentController::class, 'undertaking_letter_view'])->name('mortgage_loan.undertaking_letter.view');
    Route::get('/undertaking-letter/{loan}', [MortgageLoanPrintDocumentController::class, 'undertaking_letter'])->name('mortgage_loan.undertaking_letter.pdf');
});

Route::prefix('mortgage-loan-app')->group(function () {

    Route::get(
        '/emi-receipt-view/{loan}/{emiNo}',
        [MortgageLoanPrintDocumentController::class, 'emi_receipt_view']
    )->name('mortgage_loan.emi_receipt.view');

    Route::get(
        '/emi-receipt/{loan}/{emiNo}',
        [MortgageLoanPrintDocumentController::class, 'emi_receipt_pdf']
    )->name('mortgage_loan.emi_receipt.pdf');

    Route::get(
        '/emi-receipt-print/{loan}/{emiNo}',
        [MortgageLoanPrintDocumentController::class, 'emi_receipt_print']
    )->name('mortgage_emi.receipt.print');
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

    //comments and documents 
    Route::get(
        'loan-against/{id}/add-comment',
        [LoanAgainstAccountController::class, 'addComment']
    )->name('loanagainst.addComment');

    Route::post(
        'loan-against/store-comment',
        [LoanAgainstAccountController::class, 'storeComment']
    )->name('loanagainst.storeComment');

    // account section start

    Route::get('account/index', [LoanAgainstAccountController::class, 'index'])->name('loanagainst.account.index');
    Route::get('account/show/{id}', [LoanAgainstAccountController::class, 'show'])
        ->name('loanagainst.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [LoanAgainstAccountController::class, 'saveEmiStatus'])
        ->name('loanagainst.emi.saveEmiStatus');

    // pay emi tab
    Route::get('loanagainst-account/payemi/{id}', [LoanAgainstAccountController::class, 'mortgagePayEmi'])
        ->name('loanagainst.account.pay-emi');
    Route::post('loanagainst-account/payemi/{id}/pay', [LoanAgainstAccountController::class, 'mortgagepayEmiLoan'])->name('loanagainst.payEmiLoan');

    // View Transction tab
    Route::get('loanagainst-account/transaction/{id}', [LoanAgainstAccountController::class, 'mortgageTransaction'])
        ->name('loanagainst.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [LoanAgainstAccountController::class, 'loanextension'])
        ->name('loanagainst.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [LoanAgainstAccountController::class, 'storeLoanExtension'])->name('loanagainst.extension.store');

    // only pay tab
    Route::get('loanagainst-account/pay/{id}', [LoanAgainstAccountController::class, 'mortgagePay'])
        ->name('loanagainst.account.pay');
    Route::post('/update-emi-status', [LoanAgainstAccountController::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/loanagainst/pay-emi', [LoanAgainstAccountController::class, 'payEmi'])->name('loanagainst.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [LoanAgainstAccountController::class, 'fourcloser'])
        ->name('loanagainst.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [LoanAgainstAccountController::class, 'storeForeCloser'])
        ->name('loanagainst.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [LoanAgainstAccountController::class, 'linksaving'])
        ->name('loanagainst.account.linksaving');
    Route::post('account/linksaving/{id}', [LoanAgainstAccountController::class, 'storeSavingAccount'])
        ->name('loanagainst.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/loanagainst/{id}/remove', [LoanAgainstAccountController::class, 'removeAccount'])
        ->name('loanagainst.remove');

    // show audit trial tab
    Route::get('account/audit', [LoanAgainstAccountController::class, 'audit'])
        ->name('loanagainst.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get(
        '/loanagainst/{id}/debit-charges-list',
        [LoanAgainstAccountController::class, 'showDebitChargesList']
    )
        ->name('loanagainst.debitChargesList.list');

    // debit other charge page    
    Route::get('/loanagainst/{id}/debit-other-charges', [LoanAgainstAccountController::class, 'DebitOtherCharges'])
        ->name('loanagainst.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/loanagainst/{id}/debit-other-charges', [LoanAgainstAccountController::class, 'storeDebitOtherCharges'])
        ->name('loanagainst.debitOtherCharges.store');

    //clear due 
    Route::get('/loanagainst/{id}/clear-due', [LoanAgainstAccountController::class, 'mortgageLoanClearDues'])
        ->name('loanagainst.clear-due.form');
    Route::post('/loanagainst/{loan_id}/other-charge', [LoanAgainstAccountController::class, 'clearDue'])->name('loanagainst.clear-due');

    // account section end


    // line property
    Route::get('lineproperty/index', [LoanAgainstController::class, 'linepropertyindex'])
        ->name('loanagainst.lineproperty.index');
    // Download excel sheet
    Route::get('loanagainst/export', [LoanAgainstController::class, 'exportLoanAgainst'])->name('loanagainst.lineproperty.export');

    // Show emi chart 
    Route::get('{id}/emi-chart', [LoanAgainstController::class, 'emiChart'])->name('loanagainst.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [LoanAgainstController::class, 'loanagainst_process_fee'])
        ->name('loanagainst.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [LoanAgainstController::class, 'loanagainststoreProcessFee'])
        ->name('loanagainst.col_process_fee.store');

    Route::post('applications/{id}/submit-for-approval', [LoanAgainstController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
});


/////////////////////////////////////   END DEPOSIT LOAN  REPORT   ////////////////////////////////////////////////////////


/////////////////////////////////////   Business LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'business'], function () {

    // bussiness Loan Scheme
    Route::get('scheme/index', [BusinessLoan::class, 'index'])
        ->name('bussiness.schemes.index');

    // create form
    Route::get('scheme/create', [BusinessLoan::class, 'create'])
        ->name('bussiness.schemes.create');
    // store form data
    Route::post('scheme/store', [BusinessLoan::class, 'store'])
        ->name('bussiness.schemes.store');

    // view list
    Route::get('scheme/{id}', [BusinessLoan::class, 'show'])
        ->name('bussiness.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [BusinessLoan::class, 'edit'])
        ->name('bussiness.schemes.edit');
    Route::put('scheme/{id}', [BusinessLoan::class, 'update'])
        ->name('bussiness.schemes.update');

    Route::get('scheme/view/{id}', [BusinessLoan::class, 'view'])
        ->name('bussiness.schemes.view');

    // bussiness Loan Calculation
    Route::get('calculator/index', [BusinessLoan::class, 'calculator'])
        ->name('bussiness.calculator.index');
    // get scheme data
    Route::get('bussiness/scheme/{id}', [BusinessLoan::class, 'getSchemeDetails'])
        ->name('bussiness.scheme.details');


    // Calculation page  
    Route::get('calculator/calculation', [BusinessLoan::class, 'calculation'])->name('bussiness.calculator.calculation');
    Route::post('bussiness/calculate', [BusinessLoan::class, 'calculateResult'])->name('bussiness.calculator.calculate');


    // bussiness Application page
    Route::get('applications/index', [BusinessLoan::class, 'appindex'])
        ->name('bussiness.applications.index');

    Route::get('applications/create', [BusinessLoan::class, 'appcreate'])
        ->name('bussiness.applications.create');

    Route::post('/businessloan/store', [BusinessLoan::class, 'storeLoanApplication'])->name('businessloan.store');

    Route::get('/members/{id}/info', [BusinessLoan::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('bussiness/applications/view/{id}', [BusinessLoan::class, 'appview'])
        ->name('bussiness.applications.view');

    // Edit form
    Route::get('/bussiness/applications/{id}/edit', [BusinessLoan::class, 'appedit'])
        ->name('bussiness.applications.edit');

    // Update
    Route::put('/bussiness/applications/{id}', [BusinessLoan::class, 'appupdate'])
        ->name('bussiness.applications.update');

    Route::get('applications/show-emi-chart', [BusinessLoan::class, 'showEmiChart'])
        ->name('bussiness.applications.view-buttons.show-emi-chart');


    // Disbursement bussiness Loan
    Route::get('disbursements/index', [BusinessLoanDisburments::class, 'index'])
        ->name('bussiness.disbursements.index');
    Route::post('/bussiness/disbursements/cancel/{id}', [BusinessLoanDisburments::class, 'cancelLoan'])->name('businessdisbursements.cancel');

    // disburse-loan page  
    Route::get('disbursements/disburse-loan/{id}', [BusinessLoanDisburments::class, 'show'])
        ->name('bussiness.disbursements.disburse-loan');
    Route::post('/bussiness/disbursements/store', [BusinessLoanDisburments::class, 'store'])->name('businessdisbursements.store');

    //comments and documents 
    Route::get(
        'bussiness/{id}/add-comment',
        [BusinessLoanAccount::class, 'addComment']
    )->name('bussiness.addComment');

    Route::post(
        'bussiness/store-comment',
        [BusinessLoanAccount::class, 'storeComment']
    )->name('bussiness.storeComment');

    // account section start

    Route::get('account/index', [BusinessLoanAccount::class, 'index'])->name('bussiness.account.index');
    Route::get('account/show/{id}', [BusinessLoanAccount::class, 'show'])
        ->name('bussiness.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [BusinessLoanAccount::class, 'saveEmiStatus'])
        ->name('business.emi.saveEmiStatus');

    // pay emi tab
    Route::get('bussiness-account/payemi/{id}', [BusinessLoanAccount::class, 'mortgagePayEmi'])
        ->name('bussiness.account.pay-emi');
    Route::post('bussiness-account/payemi/{id}/pay', [BusinessLoanAccount::class, 'mortgagepayEmiLoan'])->name('bussiness.payEmiLoan');

    // View Transction tab
    Route::get('bussiness-account/transaction/{id}', [BusinessLoanAccount::class, 'mortgageTransaction'])
        ->name('bussiness.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [BusinessLoanAccount::class, 'loanextension'])
        ->name('bussiness.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [BusinessLoanAccount::class, 'storeLoanExtension'])->name('bussiness.extension.store');

    // only pay tab
    Route::get('bussiness-account/pay/{id}', [BusinessLoanAccount::class, 'mortgagePay'])
        ->name('bussiness.account.pay');
    Route::post('/update-emi-status', [BusinessLoanAccount::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/bussiness/pay-emi', [BusinessLoanAccount::class, 'payEmi'])->name('bussiness.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [BusinessLoanAccount::class, 'fourcloser'])
        ->name('bussiness.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [BusinessLoanAccount::class, 'storeForeCloser'])
        ->name('bussiness.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [BusinessLoanAccount::class, 'linksaving'])
        ->name('bussiness.account.linksaving');
    Route::post('account/linksaving/{id}', [BusinessLoanAccount::class, 'storeSavingAccount'])
        ->name('bussiness.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/bussiness/{id}/remove', [BusinessLoanAccount::class, 'removeAccount'])
        ->name('bussiness.remove');

    // show audit trial tab
    Route::get('account/audit', [BusinessLoanAccount::class, 'audit'])
        ->name('bussiness.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/bussiness/{id}/debit-charges-list', [BusinessLoanAccount::class, 'showDebitChargesList'])
        ->name('bussiness.debitChargesList.form');

    // debit other charge page    
    Route::get('/bussiness/{id}/debit-other-charges', [BusinessLoanAccount::class, 'DebitOtherCharges'])
        ->name('bussiness.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/bussiness/{id}/debit-other-charges', [BusinessLoanAccount::class, 'storeDebitOtherCharges'])
        ->name('bussiness.debitOtherCharges.store');

    //clear due
    Route::get('/bussiness/{id}/clear-due', [BusinessLoanAccount::class, 'mortgageLoanClearDues'])
        ->name('bussiness.clear-due.form');
    Route::post('/bussiness/{loan_id}/other-charge', [BusinessLoanAccount::class, 'clearDue'])->name('bussiness.clear-due');

    // account section end



    // Show emi chart
    Route::get('{id}/emi-chart', [BusinessLoan::class, 'emiChart'])->name('bussiness.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [BusinessLoan::class, 'bussiness_process_fee'])
        ->name('bussiness.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [BusinessLoan::class, 'bussinessstoreProcessFee'])
        ->name('bussiness.col_process_fee.store');

    // Route::post('applications/{id}/submit-for-approval', [BusinessLoan::class, 'submitForApproval'])
    //     ->name('applications.submitForApproval');

    //print documents view page  
    Route::get('/payout-chart-view/{loan}', [BusinessLoanPrintDocumentController::class, 'payout_chart_business_appli_view'])->name('business_loan.payout_chart_business_loan_application_view');
    Route::get('/payout-chart/{loan}', [BusinessLoanPrintDocumentController::class, 'payout_chart_business_appli'])->name('business_loan.payout_chart_loan_application.pdf');

    Route::get('/sanction-letter-view/{loan}', [BusinessLoanPrintDocumentController::class, 'sanction_letter_view'])->name('business_loan.sanction_letter-view');
    Route::get('/sanction-letter/{loan}', [BusinessLoanPrintDocumentController::class, 'sanction_letter'])->name('business_loan.sanction_letter.pdf');

    Route::get('/{loan}/loan-agreement-view', [BusinessLoanPrintDocumentController::class, 'loanAgreementView'])->name('business_loan.loanAgreement-view');
    Route::get('/{loan}/loan-agreement', [BusinessLoanPrintDocumentController::class, 'loanAgreement'])->name('business_loan.loanAgreement.pdf');

    Route::get('/disburse-letter-view/{loan}', [BusinessLoanPrintDocumentController::class, 'disburse_letter_view'])->name('business_loan.disburse_letter.view');
    Route::get('/disburse-letter/{loan}', [BusinessLoanPrintDocumentController::class, 'disburse_letter'])->name('business_loan.disburse_letter.pdf');

    Route::get('/promissory-note-view/{loan}', [BusinessLoanPrintDocumentController::class, 'promissory_note_view'])->name('business_loan.promissory.view');
    Route::get('/promissory-note/{loan}', [BusinessLoanPrintDocumentController::class, 'promissory_note'])->name('business_loan.promissory.pdf');

    Route::get('/undertaking-letter-view/{loan}', [BusinessLoanPrintDocumentController::class, 'undertaking_letter_view'])->name('business_loan.undertaking_letter.view');
    Route::get('/undertaking-letter/{loan}', [BusinessLoanPrintDocumentController::class, 'undertaking_letter'])->name('business_loan.undertaking_letter.pdf');
    Route::get(
        '/business-loan-app/emi-receipt-view/{loan}/{emiNo}',
        [BusinessLoanPrintDocumentController::class, 'emi_receipt_view']
    )->name('loan.emi_receipt.view');

    Route::get(
        '/business-loan-app/emi-receipt/{loan}/{emiNo}',
        [BusinessLoanPrintDocumentController::class, 'emi_receipt_pdf']
    )->name('loan.emi_receipt.pdf');
    Route::get('/emi-receipt/{loan}/{emiNo}', [BusinessLoanPrintDocumentController::class, 'emi_receipt_print'])
        ->name('emi.receipt.print');
});


/////////////////////////////////////   END Business LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   CC / OD LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'cc_od'], function () {

    // cc_od Loan Scheme
    Route::get('scheme/index', [CcOdLoanController::class, 'index'])
        ->name('cc_od.schemes.index');

    // create form
    Route::get('scheme/create', [CcOdLoanController::class, 'create'])
        ->name('cc_od.schemes.create');
    // store form data
    Route::post('scheme/store', [CcOdLoanController::class, 'store'])
        ->name('cc_od.schemes.store');

    // view list
    Route::get('scheme/{id}', [CcOdLoanController::class, 'show'])
        ->name('cc_od.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [CcOdLoanController::class, 'edit'])
        ->name('cc_od.schemes.edit');
    Route::put('scheme/{id}', [CcOdLoanController::class, 'update'])
        ->name('cc_od.schemes.update');

    Route::get('scheme/view/{id}', [CcOdLoanController::class, 'view'])
        ->name('cc_od.schemes.view');

    // cc_od Application page
    Route::get('applications/index', [CcOdLoanController::class, 'appindex'])
        ->name('cc_od.applications.index');

    Route::get('applications/create', [CcOdLoanController::class, 'appcreate'])
        ->name('cc_od.applications.create');

    Route::post('/CcOdLoanController/store', [CcOdLoanController::class, 'storeLoanApplication'])->name('cc_od.store');

    Route::get('/members/{id}/info', [CcOdLoanController::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('cc_od/applications/view/{id}', [CcOdLoanController::class, 'appview'])
        ->name('cc_od.applications.view');

    // Edit form
    Route::get('/cc_od/applications/{id}/edit', [CcOdLoanController::class, 'appedit'])
        ->name('cc_od.applications.edit');

    // Update
    Route::put('/cc_od/applications/{id}', [CcOdLoanController::class, 'appupdate'])
        ->name('cc_od.applications.update');

    Route::get('applications/show-emi-chart', [CcOdLoanController::class, 'showEmiChart'])
        ->name('cc_od.applications.view-buttons.show-emi-chart');

    Route::get('cc-od/credit-score/upload/{id}', [CcOdLoanController::class, 'upload'])
        ->name('cc_od.credit_score.upload');


    // Disbursement cc_od Loan
    Route::get('disbursements/index', [CcOdLoanControllerDisburments::class, 'index'])
        ->name('cc_od.disbursements.index');
    Route::post('/cc_od/disbursements/cancel/{id}', [CcOdLoanControllerDisburments::class, 'cancelLoan'])->name('cc_od.cancel');

    // disburse-loan page  
    Route::get('disbursements/disburse-loan/{id}', [CcOdLoanControllerDisburments::class, 'show'])
        ->name('cc_od.disbursements.disburse-loan');
    Route::post('/cc_od/disbursements/store', [CcOdLoanControllerDisburments::class, 'store'])->name('cc_od_disbursment.store');

    //comments and documents 
    Route::get(
        'account/{id}/add-comment',
        [CcOdLoanControllerAccount::class, 'addComment']
    )->name('ccod.addComment');

    Route::post(
        'account/store-comment',
        [CcOdLoanControllerAccount::class, 'storeComment']
    )->name('ccod.storeComment');
    // account section start

    Route::get('account/index', [CcOdLoanControllerAccount::class, 'index'])->name('cc_od.account.index');
    Route::get('account/show/{id}', [CcOdLoanControllerAccount::class, 'show'])
        ->name('cc_od.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [CcOdLoanControllerAccount::class, 'saveEmiStatus'])
        ->name('cc_od.emi.saveEmiStatus');

    // pay emi tab
    Route::get('cc_od-account/payemi/{id}', [CcOdLoanControllerAccount::class, 'mortgagePayEmi'])
        ->name('cc_od.account.pay-emi');
    Route::post('cc_od-account/payemi/{id}/pay', [CcOdLoanControllerAccount::class, 'mortgagepayEmiLoan'])->name('cc_od.payEmiLoan');

    // View Transction tab
    Route::get('cc_od-account/transaction/{id}', [CcOdLoanControllerAccount::class, 'mortgageTransaction'])
        ->name('cc_od.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [CcOdLoanControllerAccount::class, 'loanextension'])
        ->name('cc_od.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [CcOdLoanControllerAccount::class, 'storeLoanExtension'])->name('cc_od.extension.store');

    // only pay tab
    Route::get('cc_od-account/pay/{id}', [CcOdLoanControllerAccount::class, 'mortgagePay'])
        ->name('cc_od.account.pay');
    Route::post('/update-emi-status', [CcOdLoanControllerAccount::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/cc_od/pay-emi', [CcOdLoanControllerAccount::class, 'payEmi'])->name('cc_od.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [CcOdLoanControllerAccount::class, 'fourcloser'])
        ->name('cc_od.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [CcOdLoanControllerAccount::class, 'storeForeCloser'])
        ->name('cc_od.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [CcOdLoanControllerAccount::class, 'linksaving'])
        ->name('cc_od.account.linksaving');
    Route::post('account/linksaving/{id}', [CcOdLoanControllerAccount::class, 'storeSavingAccount'])
        ->name('cc_od.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/cc_od/{id}/remove', [CcOdLoanControllerAccount::class, 'removeAccount'])
        ->name('cc_od.remove');

    // show audit trial tab
    Route::get('account/audit', [CcOdLoanControllerAccount::class, 'audit'])
        ->name('cc_od.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/cc_od/{id}/debit-charges-list', [CcOdLoanControllerAccount::class, 'showDebitChargesList'])
        ->name('cc_od.debitChargesList.form');

    // debit other charge page    
    Route::get('/cc_od/{id}/debit-other-charges', [CcOdLoanControllerAccount::class, 'DebitOtherCharges'])
        ->name('cc_od.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/cc_od/{id}/debit-other-charges', [CcOdLoanControllerAccount::class, 'storeDebitOtherCharges'])
        ->name('cc_od.debitOtherCharges.store');

    //clear due 
    Route::get('/cc_od/{id}/clear-due', [CcOdLoanControllerAccount::class, 'mortgageLoanClearDues'])
        ->name('cc_od.clear-due.form');
    Route::post('/cc_od/{loan_id}/other-charge', [CcOdLoanControllerAccount::class, 'clearDue'])->name('cc_od.clear-due');

    // account section end



    // Collect Processing fee page in application view page
    Route::get('cc-od/col-process-fee/{id}', [CcOdLoanController::class, 'col_process_fee'])
        ->name('cc_od.applications.view-buttons.col_process_fee');

    Route::post('cc-od/col-process-fee/store/{id}', [CcOdLoanController::class, 'storeProcessFee'])
        ->name('ccod.col_process_fee.store');

    // Route::post('applications/{id}/submit-for-approval', [CcOdLoanController::class, 'submitForApproval'])
    //     ->name('applications.submitForApproval');
});


/////////////////////////////////////   END CC / OD LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   Daily / Weekly LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'daily_weekly'], function () {

    // daily_weekly Loan Scheme
    Route::get('scheme/index', [DailyWeeklyController::class, 'index'])
        ->name('daily_weekly.schemes.index');

    // create form
    Route::get('scheme/create', [DailyWeeklyController::class, 'create'])
        ->name('daily_weekly.schemes.create');
    // store form data
    Route::post('scheme/store', [DailyWeeklyController::class, 'store'])
        ->name('daily_weekly.schemes.store');

    // view list
    Route::get('scheme/{id}', [DailyWeeklyController::class, 'show'])
        ->name('daily_weekly.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [DailyWeeklyController::class, 'edit'])
        ->name('daily_weekly.schemes.edit');
    Route::put('scheme/{id}', [DailyWeeklyController::class, 'update'])
        ->name('daily_weekly.schemes.update');

    Route::get('scheme/view/{id}', [DailyWeeklyController::class, 'view'])
        ->name('daily_weekly.schemes.view');


    // daily_weekly Application page
    Route::get('applications/index', [DailyWeeklyController::class, 'appindex'])
        ->name('daily_weekly.applications.index');

    Route::get('applications/create', [DailyWeeklyController::class, 'appcreate'])
        ->name('daily_weekly.applications.create');

    Route::post('/DailyWeekly/store', [DailyWeeklyController::class, 'storeLoanApplication'])->name('daily_weekly.store');

    Route::get('/members/{id}/info', [DailyWeeklyController::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('daily_weekly/applications/view/{id}', [DailyWeeklyController::class, 'appview'])
        ->name('daily_weekly.applications.view');

    // Edit form
    Route::get('/daily_weekly/applications/{id}/edit', [DailyWeeklyController::class, 'appedit'])
        ->name('daily_weekly.applications.edit');

    // Update
    Route::put('/daily_weekly/applications/{id}', [DailyWeeklyController::class, 'appupdate'])
        ->name('daily_weekly.applications.update');

    Route::get('applications/show-emi-chart', [DailyWeeklyController::class, 'showEmiChart'])
        ->name('daily_weekly.applications.view-buttons.show-emi-chart');

    Route::get('cc-od/credit-score/upload/{id}', [DailyWeeklyController::class, 'upload'])
        ->name('daily_weekly.credit_score.upload');


    // Disbursement daily_weekly Loan
    Route::get('disbursements/index', [DailyWeeklyDisburments::class, 'index'])
        ->name('daily_weekly.disbursements.index');
    Route::post('/daily_weekly/disbursements/cancel/{id}', [DailyWeeklyDisburments::class, 'cancelLoan'])->name('daily_weekly.cancel');

    // disburse-loan page  
    Route::get('disbursements/disburse-loan/{id}', [DailyWeeklyDisburments::class, 'show'])
        ->name('daily_weekly.disbursements.disburse-loan');
    Route::post('/daily_weekly/disbursements/store', [DailyWeeklyDisburments::class, 'store'])->name('daily_weekly_disbursment.store');

    //comments and documents 
    Route::get(
        'account/{id}/add-comment',
        [DailyWeeklyAccount::class, 'addComment']
    )->name('dailyw.addComment');

    Route::post(
        'account/store-comment',
        [DailyWeeklyAccount::class, 'storeComment']
    )->name('dailyw.storeComment');
    // account section start

    Route::get('account/index', [DailyWeeklyAccount::class, 'index'])->name('daily_weekly.account.index');
    Route::get('account/show/{id}', [DailyWeeklyAccount::class, 'show'])
        ->name('daily_weekly.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [DailyWeeklyAccount::class, 'saveEmiStatus'])
        ->name('daily_weekly.emi.saveEmiStatus');

    // pay emi tab
    Route::get('daily_weekly-account/payemi/{id}', [DailyWeeklyAccount::class, 'mortgagePayEmi'])
        ->name('daily_weekly.account.pay-emi');
    Route::post('daily_weekly-account/payemi/{id}/pay', [DailyWeeklyAccount::class, 'mortgagepayEmiLoan'])->name('daily_weekly.payEmiLoan');

    // View Transction tab
    Route::get('daily_weekly-account/transaction/{id}', [DailyWeeklyAccount::class, 'mortgageTransaction'])
        ->name('daily_weekly.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [DailyWeeklyAccount::class, 'loanextension'])
        ->name('daily_weekly.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [DailyWeeklyAccount::class, 'storeLoanExtension'])->name('daily_weekly.extension.store');

    // only pay tab
    Route::get('daily_weekly-account/pay/{id}', [DailyWeeklyAccount::class, 'mortgagePay'])
        ->name('daily_weekly.account.pay');
    Route::post('/update-emi-status', [DailyWeeklyAccount::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/daily_weekly/pay-emi', [DailyWeeklyAccount::class, 'payEmi'])->name('daily_weekly.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [DailyWeeklyAccount::class, 'fourcloser'])
        ->name('daily_weekly.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [DailyWeeklyAccount::class, 'storeForeCloser'])
        ->name('daily_weekly.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [DailyWeeklyAccount::class, 'linksaving'])
        ->name('daily_weekly.account.linksaving');
    Route::post('account/linksaving/{id}', [DailyWeeklyAccount::class, 'storeSavingAccount'])
        ->name('daily_weekly.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/daily_weekly/{id}/remove', [DailyWeeklyAccount::class, 'removeAccount'])
        ->name('daily_weekly.remove');

    // show audit trial tab
    Route::get('account/audit', [DailyWeeklyAccount::class, 'audit'])
        ->name('daily_weekly.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/daily_weekly/{id}/debit-charges-list', [DailyWeeklyAccount::class, 'showDebitChargesList'])
        ->name('daily_weekly.debitChargesList.form');

    // debit other charge page    
    Route::get('/daily_weekly/{id}/debit-other-charges', [DailyWeeklyAccount::class, 'DebitOtherCharges'])
        ->name('daily_weekly.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/daily_weekly/{id}/debit-other-charges', [DailyWeeklyAccount::class, 'storeDebitOtherCharges'])
        ->name('daily_weekly.debitOtherCharges.store');

    //clear due 
    Route::get('/daily_weekly/{id}/clear-due', [DailyWeeklyAccount::class, 'mortgageLoanClearDues'])
        ->name('daily_weekly.clear-due.form');
    Route::post('/daily_weekly/{loan_id}/other-charge', [DailyWeeklyAccount::class, 'clearDue'])->name('daily_weekly.clear-due');

    // account section end



    // Collect Processing fee page in application view page
    Route::get('daily_weekly/col-process-fee/{id}', [DailyWeeklyController::class, 'col_process_fee'])
        ->name('daily_weekly.applications.view-buttons.col_process_fee');
    Route::post('daily_weekly/col-process-fee/store/{id}', [DailyWeeklyController::class, 'storeProcessFee'])
        ->name('daily_weekly.col_process_fee.store');


    // Show EMI chart in a new tab
    Route::get('daily_weekly/{id}/emi-chart', [DailyWeeklyController::class, 'emiChart'])
        ->name('daily_weekly.applications.view-buttons.show-emi-chart');

    // Disbusrment setting
    Route::get('daily_weekly/{id}/disbursment', [DailyWeeklyController::class, 'disbursment'])
        ->name('daily_weekly.applications.view-buttons.disburse-setting');

    // Route::post('applications/{id}/submit-for-approval', [DailyWeeklyController::class, 'submitForApproval'])
    //     ->name('applications.submitForApproval');
});


/////////////////////////////////////   END Daily / Weekly LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   personal LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'personal'], function () {

    Route::get('scheme/index', [PersonalController::class, 'index'])->name('personal.schemes.index');
    Route::get('scheme/create', [PersonalController::class, 'create'])->name('personal.schemes.create');
    Route::post('scheme/store', [PersonalController::class, 'store'])->name('personal.schemes.store');
    Route::get('scheme/{id}', [PersonalController::class, 'show'])->name('personal.schemes.show');
    Route::get('scheme/{id}/edit', [PersonalController::class, 'edit'])->name('personal.schemes.edit');
    Route::put('scheme/{id}', [PersonalController::class, 'update'])->name('personal.schemes.update');
    Route::get('scheme/view/{id}', [PersonalController::class, 'view'])->name('personal.schemes.view');

    Route::get('calculator/index', [PersonalController::class, 'calculator'])->name('personal.calculator.index');
    Route::get('scheme/{id}/details', [PersonalController::class, 'getSchemeDetails'])->name('personal.scheme.details');
    Route::get('calculator/calculation', [PersonalController::class, 'calculation'])->name('personal.calculator.calculation');
    Route::post('calculate', [PersonalController::class, 'calculateResult'])->name('personal.calculator.calculate');

    Route::get('applications/index', [PersonalController::class, 'appindex'])->name('personal.applications.index');
    Route::get('applications/create', [PersonalController::class, 'appcreate'])->name('personal.applications.create');
    Route::post('loan-applications/store', [PersonalController::class, 'storeLoanApplication'])->name('personal.store');
    Route::get('members/{id}/info', [PersonalController::class, 'getMemberInfo'])->name('members.info');
    Route::get('applications/view/{id}', [PersonalController::class, 'appview'])->name('personal.applications.view');
    Route::get('applications/{id}/edit', [PersonalController::class, 'appedit'])->name('personal.applications.edit');
    Route::put('applications/{id}', [PersonalController::class, 'appupdate'])->name('personal.applications.update');
    Route::get('applications/show-emi-chart', [PersonalController::class, 'showEmiChart'])->name('personal.applications.view-buttons.show-emi-chart');

    Route::get('disbursements/index', [PersonalDisbursementController::class, 'index'])->name('personal.disbursements.index');
    Route::post('disbursements/cancel/{id}', [PersonalDisbursementController::class, 'cancelLoan'])->name('personal.cancel');
    Route::get('disbursements/disburse-loan/{id}', [PersonalDisbursementController::class, 'show'])->name('personal.disbursements.disburse-loan');
    Route::post('disbursements/store', [PersonalDisbursementController::class, 'store'])->name('personaldisbursements.store');


    // account section start

    Route::get('account/index', [PersonalAccountController::class, 'index'])->name('personal.account.index');
    Route::get('account/show/{id}', [PersonalAccountController::class, 'show'])
        ->name('personal.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [PersonalAccountController::class, 'saveEmiStatus'])
        ->name('personal.emi.saveEmiStatus');

    // pay emi tab
    Route::get('personal-account/payemi/{id}', [PersonalAccountController::class, 'mortgagePayEmi'])
        ->name('personal.account.pay-emi');
    Route::post('personal-account/payemi/{id}/pay', [PersonalAccountController::class, 'mortgagepayEmiLoan'])->name('personal.payEmiLoan');

    // View Transction tab
    Route::get('personal-account/transaction/{id}', [PersonalAccountController::class, 'mortgageTransaction'])
        ->name('personal.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [PersonalAccountController::class, 'loanextension'])
        ->name('personal.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [PersonalAccountController::class, 'storeLoanExtension'])->name('personal.extension.store');

    // only pay tab
    Route::get('personal-account/pay/{id}', [PersonalAccountController::class, 'mortgagePay'])
        ->name('personal.account.pay');
    Route::post('/update-emi-status', [PersonalAccountController::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/personal/pay-emi', [PersonalAccountController::class, 'payEmi'])->name('personal.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [PersonalAccountController::class, 'fourcloser'])
        ->name('personal.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [PersonalAccountController::class, 'storeForeCloser'])
        ->name('personal.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [PersonalAccountController::class, 'linksaving'])
        ->name('personal.account.linksaving');
    Route::post('account/linksaving/{id}', [PersonalAccountController::class, 'storeSavingAccount'])
        ->name('personal.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/personal/{id}/remove', [PersonalAccountController::class, 'removeAccount'])
        ->name('personal.remove');

    // show audit trial tab
    Route::get('account/audit', [PersonalAccountController::class, 'audit'])
        ->name('personal.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/personal/{id}/debit-charges-list', [PersonalAccountController::class, 'showDebitChargesList'])
        ->name('personal.debitChargesList.form');

    // debit other charge page    
    Route::get('/personal/{id}/debit-other-charges', [PersonalAccountController::class, 'DebitOtherCharges'])
        ->name('personal.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/personal/{id}/debit-other-charges', [PersonalAccountController::class, 'storeDebitOtherCharges'])
        ->name('personal.debitOtherCharges.store');

    //clear due 
    Route::get('/personal/{id}/clear-due', [PersonalAccountController::class, 'mortgageLoanClearDues'])
        ->name('personal.clear-due.form');
    Route::post('/personal/{loan_id}/other-charge', [PersonalAccountController::class, 'clearDue'])->name('personal.clear-due');
    //comments and documents 
    Route::get(
        'account/{id}/add-comment',
        [PersonalAccountController::class, 'addComment']
    )->name('personal.addComment');

    Route::post(
        'account/store-comment',
        [PersonalAccountController::class, 'storeComment']
    )->name('personal.storeComment');

    // account section end



    Route::get('{id}/emi-chart', [PersonalController::class, 'emiChart'])->name('personal.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [PersonalController::class, 'personalcol_process_fee'])
        ->name('personal.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [PersonalController::class, 'personalstoreProcessFee'])
        ->name('personal.col_process_fee.store');

    // Route::post('applications/{id}/submit-for-approval', [PersonalController::class, 'submitForApproval'])
    //     ->name('applications.submitForApproval');

    //print documents view page  
    Route::get('/payout-chart-view/{loan}', [PersonalLoanPrintDocumentController::class, 'payout_chart_personal_appli_view'])->name('personal_loan.payout_chart_personal_loan_application_view');
    Route::get('/payout-chart/{loan}', [PersonalLoanPrintDocumentController::class, 'payout_chart_personal_appli'])->name('personal_loan.payout_chart_loan_application.pdf');

    Route::get('/sanction-letter-view/{loan}', [PersonalLoanPrintDocumentController::class, 'sanction_letter_view'])->name('personal_loan.sanction_letter-view');
    Route::get('/sanction-letter/{loan}', [PersonalLoanPrintDocumentController::class, 'sanction_letter'])->name('personal_loan.sanction_letter.pdf');

    Route::get('/{loan}/loan-agreement-view', [PersonalLoanPrintDocumentController::class, 'loanAgreementView'])->name('personal_loan.loanAgreement-view');
    Route::get('/{loan}/loan-agreement', [PersonalLoanPrintDocumentController::class, 'loanAgreement'])->name('personal_loan.loanAgreement.pdf');

    Route::get('/disburse-letter-view/{loan}', [PersonalLoanPrintDocumentController::class, 'disburse_letter_view'])->name('personal_loan.disburse_letter.view');
    Route::get('/disburse-letter/{loan}', [PersonalLoanPrintDocumentController::class, 'disburse_letter'])->name('personal_loan.disburse_letter.pdf');

    Route::get('/promissory-note-view/{loan}', [PersonalLoanPrintDocumentController::class, 'promissory_note_view'])->name('personal_loan.promissory.view');
    Route::get('/promissory-note/{loan}', [PersonalLoanPrintDocumentController::class, 'promissory_note'])->name('personal_loan.promissory.pdf');

    Route::get('/undertaking-letter-view/{loan}', [PersonalLoanPrintDocumentController::class, 'undertaking_letter_view'])->name('personal_loan.undertaking_letter.view');
    Route::get('/undertaking-letter/{loan}', [PersonalLoanPrintDocumentController::class, 'undertaking_letter'])->name('personal_loan.undertaking_letter.pdf');
});


/////////////////////////////////////   END personal LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   Vehical LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'vehical'], function () {

    // Scheme
    Route::get('scheme/index', [VehicalController::class, 'index'])->name('vehical.schemes.index');
    Route::get('scheme/create', [VehicalController::class, 'create'])->name('vehical.schemes.create');
    Route::post('scheme/store', [VehicalController::class, 'store'])->name('vehical.schemes.store');
    Route::get('scheme/{id}', [VehicalController::class, 'show'])->name('vehical.schemes.show');
    Route::get('scheme/{id}/edit', [VehicalController::class, 'edit'])->name('vehical.schemes.edit');
    Route::put('scheme/{id}', [VehicalController::class, 'update'])->name('vehical.schemes.update');
    Route::get('scheme/view/{id}', [VehicalController::class, 'view'])->name('vehical.schemes.view');

    // Calculation
    Route::get('calculator/index', [VehicalController::class, 'calculator'])->name('vehical.calculator.index');
    Route::get('scheme/{id}/details', [VehicalController::class, 'getSchemeDetails'])->name('vehical.scheme.details');
    Route::get('calculator/calculation', [VehicalController::class, 'calculation'])->name('vehical.calculator.calculation');
    Route::post('calculate', [VehicalController::class, 'calculateResult'])->name('vehical.calculator.calculate');

    // Application
    Route::get('applications/index', [VehicalController::class, 'appindex'])->name('vehical.applications.index');
    Route::get('applications/create', [VehicalController::class, 'appcreate'])->name('vehical.applications.create');
    Route::post('loan-applications/store', [VehicalController::class, 'storeLoanApplication'])->name('vehical.store');
    Route::get('members/{id}/info', [VehicalController::class, 'getMemberInfo'])->name('members.info');
    Route::get('applications/view/{id}', [VehicalController::class, 'appview'])->name('vehical.applications.view');
    Route::get('applications/{id}/edit', [VehicalController::class, 'appedit'])->name('vehical.applications.edit');
    Route::put('applications/{id}', [VehicalController::class, 'appupdate'])->name('vehical.applications.update');
    Route::get('applications/show-emi-chart', [VehicalController::class, 'showEmiChart'])->name('vehical.applications.view-buttons.show-emi-chart');

    // Disbursment
    Route::get('disbursements/index', [VehicalDisbursementController::class, 'index'])->name('vehical.disbursements.index');
    Route::post('disbursements/cancel/{id}', [VehicalDisbursementController::class, 'cancelLoan'])->name('vehicaldisbursements.cancel');
    Route::get('disbursements/disburse-loan/{id}', [VehicalDisbursementController::class, 'show'])->name('vehical.disbursements.disburse-loan');
    Route::post('disbursements/store', [VehicalDisbursementController::class, 'store'])->name('vehicaldisbursements.store');
    //comments and documents 
    Route::get(
        'account/{id}/add-comment',
        [VehicalAccountController::class, 'addComment']
    )->name('vehical.addComment');

    Route::post(
        'account/store-comment',
        [DailyWeeklyAccount::class, 'storeComment']
    )->name('vehical.storeComment');

    // account section start

    Route::get('account/index', [VehicalAccountController::class, 'index'])->name('vehical.account.index');
    Route::get('account/show/{id}', [VehicalAccountController::class, 'show'])
        ->name('vehical.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [VehicalAccountController::class, 'saveEmiStatus'])
        ->name('vehical.emi.saveEmiStatus');

    // pay emi tab
    Route::get('vehical-account/payemi/{id}', [VehicalAccountController::class, 'mortgagePayEmi'])
        ->name('vehical.account.pay-emi');
    Route::post('vehical-account/payemi/{id}/pay', [VehicalAccountController::class, 'mortgagepayEmiLoan'])->name('vehical.payEmiLoan');

    // View Transction tab
    Route::get('vehical-account/transaction/{id}', [VehicalAccountController::class, 'mortgageTransaction'])
        ->name('vehical.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [VehicalAccountController::class, 'loanextension'])
        ->name('vehical.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [VehicalAccountController::class, 'storeLoanExtension'])->name('vehical.extension.store');

    // only pay tab
    Route::get('vehical-account/pay/{id}', [VehicalAccountController::class, 'mortgagePay'])
        ->name('vehical.account.pay');
    Route::post('/update-emi-status', [VehicalAccountController::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/vehical/pay-emi', [VehicalAccountController::class, 'payEmi'])->name('vehical.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [VehicalAccountController::class, 'fourcloser'])
        ->name('vehical.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [VehicalAccountController::class, 'storeForeCloser'])
        ->name('vehical.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [VehicalAccountController::class, 'linksaving'])
        ->name('vehical.account.linksaving');
    Route::post('account/linksaving/{id}', [VehicalAccountController::class, 'storeSavingAccount'])
        ->name('vehical.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/vehical/{id}/remove', [VehicalAccountController::class, 'removeAccount'])
        ->name('vehical.remove');

    // show audit trial tab
    Route::get('account/audit', [VehicalAccountController::class, 'audit'])
        ->name('vehical.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/vehical/{id}/debit-charges-list', [VehicalAccountController::class, 'showDebitChargesList'])
        ->name('vehical.debitChargesList.form');

    // debit other charge page    
    Route::get('/vehical/{id}/debit-other-charges', [VehicalAccountController::class, 'DebitOtherCharges'])
        ->name('vehical.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/vehical/{id}/debit-other-charges', [VehicalAccountController::class, 'storeDebitOtherCharges'])
        ->name('vehical.debitOtherCharges.store');

    //clear due 
    Route::get('/vehical/{id}/clear-due', [VehicalAccountController::class, 'mortgageLoanClearDues'])
        ->name('vehical.clear-due.form');
    Route::post('/vehical/{loan_id}/other-charge', [VehicalAccountController::class, 'clearDue'])->name('vehical.clear-due');

    // account section end


    // Distributors 
    Route::get('distributor/index', [VehicalDistributorController::class, 'index'])->name('vehical.distributors.index');
    Route::get('distributor/create', [VehicalDistributorController::class, 'create'])->name('vehical.distributors.create');
    Route::post('vehicle-distributor/store', [VehicalDistributorController::class, 'store'])->name('vehicle-distributor.store');
    Route::get('distributors/{id}', [VehicalDistributorController::class, 'show'])->name('distributors.show');
    Route::get('distributors/{id}/edit', [VehicalDistributorController::class, 'edit'])->name('edit');
    Route::put('distributors/{id}', [VehicalDistributorController::class, 'update'])
        ->name('vehical.distributors.update');

    // Application view emi chart
    Route::get('{id}/emi-chart', [VehicalController::class, 'emiChart'])->name('vehical.applications.view-buttons.show-emi-chart');

    // Application view page collcet processing fee
    Route::get('col-process-fee/{id}', [VehicalController::class, 'vehical_col_process_fee'])
        ->name('vehical.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [VehicalController::class, 'VehicalstoreProcessFee'])
        ->name('vehical.col_process_fee.store');

    // Route::post('applications/{id}/submit-for-approval', [VehicalController::class, 'submitForApproval'])
    //     ->name('applications.submitForApproval');


    //print documents view page  
    Route::get('/payout-chart-view/{loan}', [vehicleLoanPrintDocumentController::class, 'payout_chart_vehicle_appli_view'])->name('vehicle_loan.payout_chart_vehicle_loan_application_view');
    Route::get('/payout-chart/{loan}', [vehicleLoanPrintDocumentController::class, 'payout_chart_vehicle_appli'])->name('vehicle_loan.payout_chart_loan_application.pdf');

    Route::get('/sanction-letter-view/{loan}', [vehicleLoanPrintDocumentController::class, 'sanction_letter_view'])->name('vehicle_loan.sanction_letter-view');
    Route::get('/sanction-letter/{loan}', [vehicleLoanPrintDocumentController::class, 'sanction_letter'])->name('vehicle_loan.sanction_letter.pdf');

    Route::get('/{loan}/loan-agreement-view', [vehicleLoanPrintDocumentController::class, 'loanAgreementView'])->name('vehicle_loan.loanAgreement-view');
    Route::get('/{loan}/loan-agreement', [vehicleLoanPrintDocumentController::class, 'loanAgreement'])->name('vehicle_loan.loanAgreement.pdf');

    Route::get('/disburse-letter-view/{loan}', [VehicleLoanPrintDocumentController::class, 'disburse_letter_view'])->name('vehicle_loan.disburse_letter.view');
    Route::get('/disburse-letter/{loan}', [vehicleLoanPrintDocumentController::class, 'disburse_letter'])->name('vehicle_loan.disburse_letter.pdf');

    Route::get('/promissory-note-view/{loan}', [vehicleLoanPrintDocumentController::class, 'promissory_note_view'])->name('vehicle_loan.promissory.view');
    Route::get('/promissory-note/{loan}', [vehicleLoanPrintDocumentController::class, 'promissory_note'])->name('vehicle_loan.promissory.pdf');

    Route::get('/undertaking-letter-view/{loan}', [vehicleLoanPrintDocumentController::class, 'undertaking_letter_view'])->name('vehicle_loan.undertaking_letter.view');
    Route::get('/undertaking-letter/{loan}', [vehicleLoanPrintDocumentController::class, 'undertaking_letter'])->name('vehicle_loan.undertaking_letter.pdf');
});


/////////////////////////////////////  END Vehical LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   Fixed Loan   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'fixed_loan'], function () {

    // fixed_loan Loan Scheme
    Route::get('scheme/index', [FixedLoanController::class, 'index'])
        ->name('fixed_loan.schemes.index');

    // create form
    Route::get('scheme/create', [FixedLoanController::class, 'create'])
        ->name('fixed_loan.schemes.create');
    // store form data
    Route::post('scheme/store', [FixedLoanController::class, 'store'])
        ->name('fixed_loan.schemes.store');

    // view list
    Route::get('scheme/{id}', [FixedLoanController::class, 'show'])
        ->name('fixed_loan.schemes.show');

    // edit form
    Route::get('scheme/{id}/edit', [FixedLoanController::class, 'edit'])
        ->name('fixed_loan.schemes.edit');
    Route::put('scheme/{id}', [FixedLoanController::class, 'update'])
        ->name('fixed_loan.schemes.update');

    Route::get('scheme/view/{id}', [FixedLoanController::class, 'view'])
        ->name('fixed_loan.schemes.view');


    // fixed_loan Application page
    Route::get('applications/index', [FixedLoanController::class, 'appindex'])
        ->name('fixed_loan.applications.index');

    Route::get('applications/create', [FixedLoanController::class, 'appcreate'])
        ->name('fixed_loan.applications.create');

    Route::post('/fixedloan/store', [FixedLoanController::class, 'storeLoanApplication'])->name('fixed_loan.store');

    Route::get('/members/{id}/info', [FixedLoanController::class, 'getMemberInfo'])
        ->name('members.info');

    Route::get('fixed_loan/applications/view/{id}', [FixedLoanController::class, 'appview'])
        ->name('fixed_loan.applications.view');

    Route::put(
        'fixed-loan/applications/{id}/disapprove',
        [FixedLoanController::class, 'disapprove']
    )->name('fixed-loan.applications.disapprove');


    // Edit form
    Route::get('/fixed_loan/applications/{id}/edit', [FixedLoanController::class, 'appedit'])
        ->name('fixed_loan.applications.edit');

    // Update
    Route::put('/fixed_loan/applications/{id}', [FixedLoanController::class, 'appupdate'])
        ->name('fixed_loan.applications.update');

    Route::get('applications/show-emi-chart', [FixedLoanController::class, 'showEmiChart'])
        ->name('fixed_loan.applications.view-buttons.show-emi-chart');

    Route::get('cc-od/credit-score/upload/{id}', [FixedLoanController::class, 'upload'])
        ->name('fixed_loan.credit_score.upload');


    // Disbursement fixed_loan Loan
    Route::get('disbursements/index', [FixedLoanDisburments::class, 'index'])
        ->name('fixed_loan.disbursements.index');
    Route::post('/fixed_loan/disbursements/cancel/{id}', [FixedLoanDisburments::class, 'cancelLoan'])->name('fixed_loan.cancel');

    // disburse-loan page  
    Route::get('disbursements/disburse-loan/{id}', [FixedLoanDisburments::class, 'show'])
        ->name('fixed_loan.disbursements.disburse-loan');
    Route::post('/fixed_loan/disbursements/store', [FixedLoanDisburments::class, 'store'])->name('fixed_loan_disbursment.store');


    // account section start

    Route::get('account/index', [FixedLoanAccount::class, 'index'])->name('fixed_loan.account.index');
    Route::get('account/show/{id}', [FixedLoanAccount::class, 'show'])
        ->name('fixed_loan.account.show');
    // emi chart for process button
    Route::post('/emi/save-status', [FixedLoanAccount::class, 'saveEmiStatus'])
        ->name('fixed_loan.emi.saveEmiStatus');

    // pay emi tab
    Route::get('fixed_loan-account/payemi/{id}', [FixedLoanAccount::class, 'mortgagePayEmi'])
        ->name('fixed_loan.account.pay-emi');
    // Route::post('fixed_loan-account/payemi/{id}/pay', [FixedLoanAccount::class, 'mortgagepayEmiLoan'])->name('daily_weekly.payEmiLoan');

    // View Transction tab
    Route::get('fixed_loan-account/transaction/{id}', [FixedLoanAccount::class, 'mortgageTransaction'])
        ->name('fixed_loan.account.transaction');

    // loan extension tab
    Route::get('account/extension/{id}', [FixedLoanAccount::class, 'loanextension'])
        ->name('fixed_loan.account.extension');
    // POST - FINAL SAVE loan extension
    Route::post('/loan-extension/store/{id}', [FixedLoanAccount::class, 'storeLoanExtension'])->name('daily_weekly.extension.store');

    // only pay tab
    Route::get('fixed_loan-account/pay/{id}', [FixedLoanAccount::class, 'mortgagePay'])
        ->name('fixed_loan.account.pay');
    Route::post('/update-emi-status', [FixedLoanAccount::class, 'updateEmiStatus'])->name('emi.updateStatus');
    Route::post('/fixed_loan/pay-emi', [FixedLoanAccount::class, 'payEmi'])->name('daily_weekly.payEmi');

    // foure close account
    Route::get('account/fourcloser/{id}', [FixedLoanAccount::class, 'fourcloser'])
        ->name('fixed_loan.account.fourcloser');
    Route::post('account/fourcloser/store/{id}', [FixedLoanAccount::class, 'storeForeCloser'])
        ->name('fixed_loan.account.forecloser.store');

    // link saving account
    Route::get('account/linksaving/{id}', [FixedLoanAccount::class, 'linksaving'])
        ->name('fixed_loan.account.linksaving');
    Route::post('account/linksaving/{id}', [FixedLoanAccount::class, 'storeSavingAccount'])
        ->name('fixed_loan.account.storeSavingAccount');

    // Remove account (POST to avoid CSRF problems with GET)
    Route::post('/fixed_loan/{id}/remove', [FixedLoanAccount::class, 'removeAccount'])
        ->name('fixed_loan.remove');

    // show audit trial tab
    Route::get('account/audit', [FixedLoanAccount::class, 'audit'])
        ->name('fixed_loan.account.audit-trail');

    // DEBIT OTHER CHARGES in gold loangold-loan.debitChargesList.form
    Route::get('/fixed_loan/{id}/debit-charges-list', [FixedLoanAccount::class, 'showDebitChargesList'])
        ->name('fixed_loan.debitChargesList.form');

    // debit other charge page    
    Route::get('/fixed_loan/{id}/debit-other-charges', [FixedLoanAccount::class, 'DebitOtherCharges'])
        ->name('fixed_loan.debitOtherCharges.form');
    // Store Debit Other Charges page
    Route::post('/fixed_loan/{id}/debit-other-charges', [FixedLoanAccount::class, 'storeDebitOtherCharges'])
        ->name('fixed_loan.debitOtherCharges.store');

    //clear due 
    Route::get('/fixed_loan/{id}/clear-due', [FixedLoanAccount::class, 'mortgageLoanClearDues'])
        ->name('fixed_loan.clear-due.form');
    Route::post('/fixed_loan/{loan_id}/other-charge', [FixedLoanAccount::class, 'clearDue'])->name('daily_weekly.clear-due');

    // account section end


    // Collect Processing fee page in application view page
    Route::get('fixed_loan/col-process-fee/{id}', [FixedLoanController::class, 'col_process_fee'])
        ->name('fixed_loan.applications.view-buttons.col_process_fee');
    Route::post('fixed_loan/col-process-fee/store/{id}', [FixedLoanController::class, 'storeProcessFee'])
        ->name('fixed_loan.col_process_fee.store');


    // Show EMI chart in a new tab
    Route::get('fixed_loan/{id}/emi-chart', [FixedLoanController::class, 'emiChart'])
        ->name('fixed_loan.applications.view-buttons.show-emi-chart');

    // Disbusrment setting
    Route::get('fixed_loan/{id}/disbursment', [FixedLoanController::class, 'disbursment'])
        ->name('fixed_loan.applications.view-buttons.disburse-setting');

    // Route::post('applications/{id}/submit-for-approval', [FixedLoanController::class, 'submitForApproval'])
    //     ->name('applications.submitForApproval');
});


/////////////////////////////////////   END Fixed LOAN   ////////////////////////////////////////////////////////


/////////////////////////////////////   Agricultural Loan   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'Agricultural_loan'], function () {

    // Agricultural loan Loan Scheme
    Route::get('scheme/index', [AgriculturController::class, 'index'])
        ->name('agricultural_loan.schemes.index');
});


/////////////////////////////////////   End Agricultural Loan   ////////////////////////////////////////////////////////


/////////////////////////////////////   CONSUMER DURABLE LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'consumer_loan'], function () {

    // Agricultural loan Loan Scheme
    Route::get('scheme/index', [AgriculturController::class, 'index'])
        ->name(name: 'consumer_loan.schemes.index');
});


/////////////////////////////////////   End CONSUMER DURABLE LOAN   ////////////////////////////////////////////////////////


//////////////////////////////////////////    START LOCKER    ///////////////////////////////////////////////


Route::group(['prefix' => 'locker'], function () {

    Route::get('locker-list/index', [LockerController::class, 'locker_list_index'])
        ->name('lockers.locker-list.index');

    // Create Form
    Route::get('locker-list/add', [LockerController::class, 'locker_list_add'])
        ->name('lockers.locker-list.add');
    // Store Form
    Route::post('locker-list/store', [LockerController::class, 'locker_list_store'])
        ->name('lockers.locker-list.store');

    // View Form details
    Route::get('locker-list/view/{id}', [LockerController::class, 'locker_list_view'])
        ->name('lockers.locker-list.view');

    // Edit Form
    Route::get('locker-list/edit/{id}', [LockerController::class, 'locker_list_edit'])
        ->name('lockers.locker-list.edit');
    // Update
    Route::post('locker-list/update/{id}', [LockerController::class, 'locker_list_update'])
        ->name('lockers.locker-list.update');

    // show assign form (GET)
    Route::get('locker-list/assign/{id}', [LockerController::class, 'assign_locker'])
        ->name('lockers.locker-list.assign-locker');
    // get member details
    Route::get('/get-member-accounts/{member_id}', [LockerController::class, 'getMemberAccounts']);
    // handle assign form submit (POST)
    Route::post('locker-list/assign/{id}', [LockerController::class, 'assign_locker_store'])
        ->name('lockers.locker-list.assign-locker.store');


    Route::get('locker-list/release-locker/{id}', [LockerController::class, 'release_locker'])
        ->name('lockers.locker-list.release-locker');
    Route::post('locker-list/release/{id}', [LockerController::class, 'release_locker_store'])
        ->name('lockers.locker-list.release.store');

    Route::get('member-locker/index', [LockerController::class, 'member_locker_index'])
        ->name('lockers.member-locker.index');
    // Route::get('member-locker/view/{id}', [LockerController::class, 'member_locker_view'])
    //     ->name('lockers.member-locker.view');
    Route::get(
        'locker/member/view/{locker_id}/{index}',
        [LockerController::class, 'member_locker_view']
    )->name('locker.member-locker.view');
});


//////////////////////////////////////    END LOCKER      /////////////////////////////////////////////


////////////////////////////////////    START associate-advisor     /////////////////////////////////////////////


Route::group(['prefix' => 'associate-advisor'], function () {

    // Rank Strucutre index
    Route::get('associates/index', [AdvisorController::class, 'index'])
        ->name('associates-advisor.rank-structure.index');

    // Rank Strucutre store
    Route::get('associates/add-new-rank', [AdvisorController::class, 'add_new_rank'])
        ->name('associates-advisor.rank-structure.add-new-rank');
    Route::post('associates/add-new-rank', [AdvisorController::class, 'store_new_rank'])
        ->name('associates-advisor.rank-structure.store');

    // Rank Strucutre view
    Route::get('associates/view/{id}', [AdvisorController::class, 'view_rank'])
        ->name('associates-advisor.rank-structure.view');

    // Rank Strucutre Edit & Update
    // EDIT RANK
    Route::get('associates/edit/{id}', [AdvisorController::class, 'edit_rank'])
        ->name('associates-advisor.rank-structure.edit');
    // UPDATE RANK
    Route::post('associates/update/{id}', [AdvisorController::class, 'update_rank'])
        ->name('associates-advisor.rank-structure.update');

    // add associate 
    Route::get('associates/add', [AdvisorController::class, 'add_adc_asc'])
        ->name('associates-advisor.associates-advisors.add');
    Route::post('associate/store', [AdvisorController::class, 'store_adc_asc'])
        ->name('associate.store');

    // index associate page
    Route::get('associates/adv-index', [AdvisorController::class, 'adv_index'])
        ->name('associates-advisor.associates-advisors.index');

    // view
    Route::get('associates/adv-view/{id}', [AdvisorController::class, 'adv_view'])
        ->name('associates-advisor.associates-advisors.view');

    // SHOW EDIT FORM
    Route::get('associate/{id}/edit', [AdvisorController::class, 'edit'])
        ->name('associate.edit');

    // UPDATE REQUEST
    Route::put('associate/{id}', [AdvisorController::class, 'update'])
        ->name('associate.update');


    Route::get('associates/chnage-photo', [AdvisorController::class, 'change_photo'])
        ->name('associates-advisor.associates-advisors.change-photo');

    Route::get('associates/link-saving-account', [AdvisorController::class, 'link_saving_account'])
        ->name('associates-advisor.associates-advisors.link-saving-account');

    Route::get('associates/reset-password', [AdvisorController::class, 'reset_password'])
        ->name('associates-advisor.associates-advisors.reset-password');

    // Commession
    Route::get('associates/commission-index', [AdvisorController::class, 'commission_index'])
        ->name('associates-advisor.commission-payout.index');

    Route::get('associates/new-com-pay', [AdvisorController::class, 'new_com_pay'])
        ->name('associates-advisor.commission-payout.new-com-pay');

    Route::get('commission/view', [AdvisorController::class, 'com_view'])
        ->name('associates-advisor.commission-payout.view');

    Route::get('commission/multiple-payout', [AdvisorController::class, 'multiple_payout'])
        ->name('associates-advisor.commission-payout.multiple-payout');

    Route::get('commission/regenerate-commission', [AdvisorController::class, 'regenerate_com'])
        ->name('associates-advisor.commission-payout.regenerate-com');

    Route::get('commission/remove-payout-com', [AdvisorController::class, 'remove_payout_com'])
        ->name('associates-advisor.commission-payout.remove-payout-com');

    // Comission Chart
    Route::get('commission/commission-charts-index', [AdvisorController::class, 'commission_charts_index'])
        ->name('associates-advisor.commission-charts.index');

    Route::get('commission/add-chart', [AdvisorController::class, 'add_chart'])
        ->name('associates-advisor.commission-charts.add-chart');
    Route::post('commission/add-chart', [AdvisorController::class, 'chartstore'])
        ->name('associates-advisor.commission-charts.store');

    Route::get('commission/view/{id}', [AdvisorController::class, 'comission_view'])
        ->name('associates-advisor.commission-charts.view');

    // edit (reuse create view)
    Route::get('commission/{id}/edit', [AdvisorController::class, 'edit_chart'])
        ->name('associates-advisor.commission-charts.edit');

    // update
    Route::put('commission/{id}', [AdvisorController::class, 'update_chart'])
        ->name('associates-advisor.commission-charts.update');
});


/////////////////////////////////////////   END associate-advisor   ////////////////////////////////////////////////////


////////////////////////////////////    START payment to collect     /////////////////////////////////////////////


Route::get('payments-to-collect/index', [PaymentsToCollectController::class, 'payment_index'])
    ->name('payments-to-collect.index');
Route::get('payments-to-collect/comments', [PaymentsToCollectController::class, 'payment_comments'])
    ->name('payments-to-collect.comments');
Route::get(
    'generate-collection-link/{loan_type}/{loan_id}',
    [PaymentsToCollectController::class, 'generateLink']
)
    ->name('loan.generate.collection.link');
// mark done tab on index page
Route::get(
    'loan/mark-done/{type}/{loan_id}/{emi_no}/{amount}',
    [PaymentsToCollectController::class, 'markDone']
)->name('loan.mark.done');



////////////////////////////////////    END payment to collect     /////////////////////////////////////////////


////////////////////////////////////    Start Cut Report     /////////////////////////////////////////////


Route::group(['prefix' => 'cut-report'], function () {
    //reports
    Route::get('report/promoter-member', [CutReportController::class, 'promoterMemberIndex'])
        ->name('report.promoter-member');

    Route::get('report/customer-list', [CutReportController::class, 'customerListIndex'])
        ->name('report.customer-list');

    Route::get('/members/print', [CutReportController::class, 'printMembers'])
        ->name('members.print');

    Route::get('/promoter-members/download', [CutReportController::class, 'downloadPromoterMemberCsv'])->name('promoter.members.download');


    Route::get('report/share-holdings', [CutReportController::class, 'shareHoldingIndex'])
        ->name('report.share-holdings');

    Route::get('/share-holding/print', [CutReportController::class, 'shareHoldingPrint'])
        ->name('share.holding.print');

    Route::get('/promoter-report/download', [CutReportController::class, 'downloadPromoterCSV'])
        ->name('promoter.report.csv');

    Route::get('/share-allotment-report', [CutReportController::class, 'shareAllotmentSearchBox'])->name('share-allotment.report');

    Route::get('report/share-transfer-history', [CutReportController::class, 'shareTransferHistoryIndex'])
        ->name('report.share-transfer-history');

    Route::get(
        '/share-transfer-history/print',
        [CutReportController::class, 'shareTransferHistoryPrint']
    )->name('share.transfer.print');

    Route::get('/share-transfer-history/csv', [CutReportController::class, 'downloadShareTransferHistoryCsv'])
        ->name('shareTransfer.csv')
    ;
    Route::get('/share-transfer-history-report', [CutReportController::class, 'shareTransferHistorySearchBox'])->name('share.transfer.history.report');


    Route::get('report/saving-account', [CutReportController::class, 'savingacc_index'])
        ->name('report.saving-account');

    Route::get('/accounts/export/csv', [CutReportController::class, 'exportCsv'])
        ->name('accounts.export.csv');
    Route::get('report/saving', [CutReportController::class, 'savingIndex'])->name('report.saving.index');

    Route::get('/report/saving/print', [CutReportController::class, 'printSaving'])
        ->name('reports.saving.print');

    Route::get('report/fd-account', [CutReportController::class, 'fdaccount_index'])
        ->name('report.fd-account');
    Route::get('/fd-accounts/export/csv', [CutReportController::class, 'fdExportCsv'])
        ->name('fd-accounts.export.csv');
    Route::get('fd-accounts/report/saving', [CutReportController::class, 'FDIndex'])->name('fd-accounts.report.saving.index');
    Route::get('/report/fd/print', [CutReportController::class, 'printFd'])
        ->name('reports.printFd.print');

    Route::get('report/mis-account', [CutReportController::class, 'misaccount_index'])
        ->name('report.mis-account');
    Route::get('report/mis', [CutReportController::class, 'misIndex'])->name('report.mis.index');
    Route::get('/report/Mis/print', [CutReportController::class, 'printMis'])
        ->name('reports.printmis.print');
    Route::get('/mis-account/download-csv', [CutReportController::class, 'downloadMisCsv'])
        ->name('mis.account.csv');



    Route::get('report/dd-accounts', [CutReportController::class, 'ddaccount_index'])
        ->name('report.dd-accounts');
    Route::get('/report/dd/print', [CutReportController::class, 'printDD'])
        ->name('reports.printdd.print');
    Route::get('report/rd-account', [CutReportController::class, 'rd_account_index'])
        ->name('report.rd-account');
    Route::get('/report/Rd/print', [CutReportController::class, 'printRD'])
        ->name('reports.printrd.print');

    Route::get('report/dd', [CutReportController::class, 'ddIndex'])->name('report.dd.index');
    Route::get('/dd-accounts/download-csv', [CutReportController::class, 'ddAccountCsv'])
        ->name('ddaccounts.csv');

    Route::get('report/rd', [CutReportController::class, 'rdIndex'])->name('report.rd.index');
    Route::get('/rd-account/csv', [CutReportController::class, 'rdAccountCsv'])->name('rd-account.csv');


    // Gold Loan Report
    Route::get('report/gold-loan-account', [CutReportController::class, 'gold_loan_index'])
        ->name('report.gold-loan-account');
    Route::get('/gold-loan-report/print', [CutReportController::class, 'goldLoanPrint'])
        ->name('gold.loan.print');

    Route::get('/accounts/gold-loan-export/csv', [CutReportController::class, 'gold_loan_exportCsv'])
        ->name('accounts.export.csv');

    // Mortgage Cut Report
    Route::get('report/Mortgage-loan-account', [CutReportController::class, 'mortgage_index'])
        ->name('report.mortgage-loan-account');

    Route::get('/mortgage-report/print', [CutReportController::class, 'mortgage_print'])
        ->name('mortgage.print');

    Route::get('/accounts/Mortgage-loan-export/csv', [CutReportController::class, 'mortgage_exportCsv'])
        ->name('accounts.mortgage.export.csv');

    // loanagainst Cut Report
    Route::get('report/loanagainst-account', [CutReportController::class, 'loanagainst_index'])
        ->name('report.loanagainst-account');
    Route::get('/loan-against/pdf', [CutReportController::class, 'loanagainst_pdf'])
        ->name('loanagainst.pdf');
    Route::get('/accounts/loanagainst-export/csv', [CutReportController::class, 'loanagainst_exportCsv'])
        ->name('accounts.loanagainst.export.csv');

    // Business Loan Accounts
    Route::get('report/business-account', [CutReportController::class, 'business_index'])
        ->name('report.business-loan-account');

    Route::get(
        '/business-loan/print',
        [CutReportController::class, 'business_print']
    )->name('business.print');

    Route::get('/accounts/business-export/csv', [CutReportController::class, 'business_exportCsv'])
        ->name('accounts.business.export.csv');

    // Personal Cut Report
    Route::get('report/personal-account', [CutReportController::class, 'personal_index'])
        ->name('report.personal-loan-account');
    Route::get(
        '/personal-loan/print',
        [CutReportController::class, 'personal_print']
    )->name('personal.print');
    Route::get('/accounts/personal-export/csv', [CutReportController::class, 'personal_exportCsv'])
        ->name('accounts.personal.export.csv');

    // Daily Weekly Cut Report
    Route::get('report/daily-weekly-account', [CutReportController::class, 'daily_weekly_index'])
        ->name('report.daily_weekly-loan-account');
    Route::get(
        '/daily-weekly-loan/print',
        [CutReportController::class, 'daily_weekly_print']
    )->name('dailyweekly.print');
    Route::get('/accounts/daily-weekly-export/csv', [CutReportController::class, 'dailyweekly_exportCsv'])
        ->name('accounts.dailyweekly.export.csv');

    // Vehical Cut Report
    Route::get('report/vehical-account', [CutReportController::class, 'vehical_index'])
        ->name('report.vehical-loan-account');

    Route::get(
        '/vehicle-loan/print',
        [CutReportController::class, 'vehicle_print']
    )->name('vehicle.print');

    Route::get('/accounts/vehical-export/csv', [CutReportController::class, 'vehical_exportCsv'])
        ->name('accounts.vehical.export.csv');

    // CC OD Cut Report
    Route::get('report/cc-od-account', [CutReportController::class, 'cc_od_index'])
        ->name('report.cc_od-loan-account');
    Route::get(
        '/cc-od-loan/print',
        [CutReportController::class, 'cc_od_print']
    )->name('ccod.print');
    Route::get('/accounts/cc_od-export/csv', [CutReportController::class, 'cc_od_exportCsv'])
        ->name('accounts.cc_od.export.csv');

    // Transactions Cut Report
    Route::get('report/transactions', [CutReportController::class, 'transactions_index'])
        ->name('report.transactions');


    // loan-emi Cut Report
    Route::get('report/loan-emi', [CutReportController::class, 'loan_emi_index'])
        ->name('report.loan-emi');

    // rd-installment Cut Report
    Route::get('report/rd-installment', [CutReportController::class, 'rd_installment_index'])
        ->name('report.rd-installment');

    // Deposits Balance  Cut Report
    Route::get('report/deposit-balance-report', [CutReportController::class, 'deposit_balance_index'])
        ->name('report.deposit-balance-report');

    // Loan Balance  Cut Report
    Route::get('report/loan-balance-report', [CutReportController::class, 'loan_balance_index'])
        ->name('report.loan-balance-report');

    // Loan Accrued Interest  Cut Report
    Route::get('report/loan-accrued-report', [CutReportController::class, 'loan_accrued_index'])
        ->name('report.loan-accrued-report');

    // Group  Cut Report
    Route::get('report/group-report', [CutReportController::class, 'group_report_index'])
        ->name('report.group-report');

    // Interest & TDS Report
    Route::get('report/tds-report', [CutReportController::class, 'tds_report_index'])
        ->name('report.tds-report');

    //Attendance Report
    Route::get('report/attendance-report', [CutReportController::class, 'attendance_report_index'])
        ->name('report.attendance-report');

    //Loan Portfolio Report
    Route::get('report/loan-portfolio-report', [CutReportController::class, 'loan_portfolio_index'])
        ->name('report.loan-portfolio-report');
});

////////////////////////////////////    END Cut Report     /////////////////////////////////////////////


////////////////////////////////////    Account Section tab Start     /////////////////////////////////////////////


// ledger-group Tab 

Route::prefix('ledger-group')->group(function () {

    Route::get('/', [LedgergroupController::class, 'index'])->name('ledger-group.index');

    Route::get('/create', [LedgergroupController::class, 'create'])->name('ledger-group.create');

    Route::post('/store', [LedgergroupController::class, 'store'])->name('ledger-group.store');

    Route::get('/{id}/ledgers', [LedgergroupController::class, 'groupLedgers'])
        ->name('ledger-group.ledgers');

    Route::delete('/{id}', [LedgergroupController::class, 'destroy'])
        ->name('ledger-group.destroy');
});

// Only ledger Tab
Route::group(['prefix' => 'ledger'], function () {

    Route::get('ledger/index', [LedgergroupController::class, 'led_index'])
        ->name('ledger.index');

    Route::get('ledger/add-ledger', [LedgergroupController::class, 'add_leg'])
        ->name('ledger.add-ledger');

    Route::get('ledger-groups-by-type/{type}', [LedgergroupController::class, 'groupsByType'])
        ->name('ledger.groups.by.type');


    Route::post('/store', [LedgergroupController::class, 'led_store'])
        ->name('ledger.store');

    Route::get('ledger/update-bulkrisk', [LedgergroupController::class, 'update_bulkrisk'])
        ->name('ledger.update-bulkrisk');

    Route::get('ledger/view/{id}', [LedgergroupController::class, 'ledgerView'])
        ->name('ledger.view');

    Route::get('ledger/edit-ledger', [LedgergroupController::class, 'edit_ledgers'])
        ->name('ledger.edit-ledger');

    Route::get('ledger/journal-entry', [LedgergroupController::class, 'journal_entry_ledger'])
        ->name('ledger.journal-entry');
});

// Only Profit & Loss Tab
Route::group(['prefix' => 'profit-loss'], function () {

    Route::get('profit_loss', [LedgergroupController::class, 'profit_loss'])
        ->name('profit-loss.profit_loss');
});

Route::get('/balance-sheet', [LedgergroupController::class, 'balance_sheet'])
    ->name('balance.sheet');

Route::get(
    '/trial-balance',
    [LedgergroupController::class, 'trial_balance']
)->name('trial.balance');

Route::get('/day-book', [LedgergroupController::class, 'dayBook'])
    ->name('day.book');

Route::get('/accounting-tree', [LedgergroupController::class, 'accountingTree'])
    ->name('accounting.tree');

Route::get('/income-statement', [LedgergroupController::class, 'incomeStatement'])
    ->name('income.statement');


////////////////////////////////////    Account Section tab End     /////////////////////////////////////////////


Route::group(['prefix' => 'hr-managment'], function () {
    Route::resource('employee', HRController::class);

    Route::get('employee/index', [HRController::class, 'index'])
        ->name('hr-management.employee.index');

    Route::get('employee/view', [HRController::class, 'view'])
        ->name('hr-management.employee.view');

    Route::get('employee/view-transactions', [EmployeeController::class, 'view_transactions'])
        ->name('hr-management.employee.view-transactions');

    Route::get('employee/view-transactions-view', [EmployeeController::class, 'view_trans'])
        ->name('hr-management.employee.view-trans-view');

    Route::get('employee/pay-salary', [EmployeeController::class, 'pay_salary'])
        ->name('hr-management.employee.pay-salary');

    Route::get('employee/salary-settelment', [EmployeeController::class, 'salary_settelment'])
        ->name('hr-management.employee.salary-settelment');

    Route::get('employee/new-salary', [EmployeeController::class, 'new_salary'])
        ->name('hr-management.employee.new-salary');

    Route::get('employee/change-photo', [EmployeeController::class, 'change_photo'])
        ->name('hr-management.employee.change-photo');

    Route::get('employee/web-cam', [EmployeeController::class, 'web_cam'])
        ->name('hr-management.employee.web-cam');

    Route::get('employee/upload-documents', [EmployeeController::class, 'upload_documents'])
        ->name('hr-management.employee.upload-documents');

    Route::get('employee/calender', [EmployeeController::class, 'calender'])
        ->name('hr-management.employee.calender');

    Route::get('employee/discard-employee', [EmployeeController::class, 'discard_employee'])
        ->name('hr-management.employee.discard-employee');

    Route::get('employee/view-tran', [EmployeeController::class, 'view_tran'])
        ->name('hr-management.employee.view-trans');
});

//Employee attendance 
Route::get('attendance/attendance-index', [EmployeeAttendenceController::class, 'index'])
    ->name('hr-management.attendance.index');
Route::post('/attendance/store', [EmployeeAttendenceController::class, 'store'])
    ->name('attendance.store');
Route::get(
    '/hr-management/attendance/calendar/{employee}',
    [EmployeeAttendenceController::class, 'calendar']
)->name('hr-management.attendance.calender');

/////////Akash//////////

Route::get('salary-disbursement/disbursement-index', [EmployeeAkash::class, 'disbursement_index'])
    ->name('hr-management.salary-disbursement.index');

Route::get('salary-disbursement/disbursement-view', [EmployeeAkash::class, 'disbursement_view'])
    ->name('hr-management.salary-disbursement.view');

Route::get('salary-disbursement/release-salary', [EmployeeAkash::class, 'release_salary'])
    ->name('hr-management.salary-disbursement.release-salary');

Route::get('salary-disbursement/multiple-payout', [EmployeeAkash::class, 'multiple_payout'])
    ->name('hr-management.salary-disbursement.multiple-payout');

Route::get('salary-disbursement/pay-salary', [EmployeeAkash::class, 'pay_salaries'])
    ->name('hr-management.salary-disbursement.pay-salary');

Route::get('salary-disbursement/monthly-salary', [EmployeeAkash::class, 'monthly_salaries'])
    ->name('hr-management.salary-disbursement.monthly-salary');



// vendors
Route::group(['prefix' => 'vendor'], function () {
    Route::get('vendor/index', [VendorController::class, 'vendor_index'])
        ->name('vendors.index');
    Route::get('vendor/add-vendor', [VendorController::class, 'add_vendor'])
        ->name('vendors.add-vendor');
    Route::get('vendor/view', [VendorController::class, 'vendor_view'])
        ->name('vendors.view');

    Route::get('vendor/libality-ledger', [VendorController::class, 'libality_ledger'])
        ->name('vendors.libality-ledger');

    Route::get('vendor/edit-ledger', [VendorController::class, 'edit_ledger'])
        ->name('vendors.edit-ledger');
});

// Day Book
Route::group(['prefix' => 'day-book'], function () {
    Route::get('daybook/day-book', [DaybookController::class, 'day_book'])
        ->name('day-book.day-book');

    Route::get('daybook/cash-book', [DaybookController::class, 'cash_book'])
        ->name('day-book.cash-book');

    Route::get('daybook/bank-book', [DaybookController::class, 'bank_book'])
        ->name('day-book.bank-book');


    Route::get('daybook/wallet-book', [DaybookController::class, 'wallet_book'])
        ->name('day-book.wallet-book');

    Route::get('daybook/edit-ledger', [DaybookController::class, 'edit_ledger'])
        ->name('day-book.edit-ledger');

    Route::get('daybook/journal-entry', [DaybookController::class, 'journal_entry'])
        ->name('day-book.journal-entry');
    Route::get('daybook/ledger-book', [DaybookController::class, 'ledger_book'])
        ->name('day-book.ledger-book');
});

// Payments & payment collections

//payments to release

Route::get('payments-to-release/index', [PaymentsToCollectController::class, 'release_index'])
    ->name('payments-to-release.index');

Route::get('payments-to-release/payments-history', [PaymentsToCollectController::class, 'payments_history'])
    ->name('payments-to-release.payments-history');

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
    // Change password page
    Route::get('/profile/change-password', [SettingsController::class, 'change_password'])->name('profile-change-password');
    // Wrapper POST route
    Route::post('/profile/change-password', [SettingsController::class, 'updatePasswordFromProfile'])
        ->name('profile-update-password');

    Route::post('/profile/photo', [SettingsController::class, 'updateProfilePhoto'])
        ->name('profile-photo.update');;

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

/////////////////////////////////////   Passbook   ////////////////////////////////////////////////////////

Route::resource('passbook', PassbookController::class);
Route::get('index', [PassbookController::class, 'index'])->name('passbook.index');
Route::get('create-passbook', [PassbookController::class, 'create'])->name('passbook.create-passbook');
Route::post('store-passbook', [PassbookController::class, 'store'])->name('passbook.store-passbook');
Route::get('passbook/{passbook}', [PassbookController::class, 'show'])->name('passbook.show');
Route::get('edit-passbook/{id}', [PassbookController::class, 'edit'])->name('passbook.edit-passbook');
Route::delete('/passbook/{id}', [PassbookController::class, 'destroy'])->name('passbook.destroy');


/////////////////////////////////////   end Passbook   ////////////////////////////////////////////////////////


/////////////////////////////Notice Board ///////////////////////////////

Route::resource('notice-boards', NoticeBoardController::class);

/////////////////////////////End Notice Board //////////////////////////




/////////////////////////////Collection Center and Groups //////////////////////////
Route::resource('collection-centers', CollectionCenterController::class);
Route::resource('groups', GroupController::class);

Route::get('/branches-by-center/{centerId}', [GroupController::class, 'getBranches']);



// Route::get('/commnets/view', [GroupCommentController::class, 'view'])->name('commnet.view');

Route::get('groups/{group}/comments', [GroupCommentController::class, 'index'])
    ->name('groups.comments.index');

Route::post('groups/{group}/comments', [GroupCommentController::class, 'store'])
    ->name('groups.comments.store');



/////////////////////////////end Collection Center and Groups //////////////////////////

/////////////////////////////print-documents //////////////////////////
Route::get(
    '/print/fd-mis-bond',
    [PrintDocumentsController::class, 'fd_mis_bond']
)->name('print-documents.fd-mis-bond.index');

Route::match(['get', 'post'], '/print/fd-mis-bond/search', [PrintDocumentsController::class, 'searchBond'])
    ->name('fd.mis.bond.search');

Route::get(
    '/get-account-numbers/{type}',
    [PrintDocumentsController::class, 'getAccountNumbers']
)->name('get.account.numbers');
// FD bond download
Route::get('/fd/bond/{id}', [FDController::class, 'fdBondForm'])
    ->name('fd.bond.download');
// MIS bond download    
Route::get(
    '/mis/bond/{id}',
    [MisaccountController::class, 'misBondForm']
)->name('mis.bond.download');

//rd-dd
// RD / DD Bond Page
Route::get('/print/rd-dd-bond', [PrintDocumentsController::class, 'rdDdBond'])
    ->name('print.rd-dd-bond.index');

// // RD / DD Search
Route::match(
    ['get', 'post'],
    'print/rd-dd-bond/search',
    [PrintDocumentsController::class, 'searchRdDdBond']
)->name('rd.dd.bond.search');
// Route::post('/print/rd-dd-bond/search', [PrintDocumentsController::class, 'searchRdDdBond'])
//     ->name('rd.dd.bond.search');

// // RD / DD Account Numbers (AJAX)
Route::get('/get-rd-dd-account-numbers/{type}', [PrintDocumentsController::class, 'getRdDdAccountNumbers'])
    ->name('get.rd.dd.account.numbers');

// // RD Bond Download

Route::get('/rd/bond/{id}', [RdAccountController::class, 'rdBondForm'])
    ->name('rd.bond.download');

// // DD Bond Download

Route::get('/dd/bondview/{id}', [DdsAccountsController::class, 'ddBondFormView'])
    ->name('dd-bondView');
Route::get('/dd/bond/{id}', [DdsAccountsController::class, 'ddBondForm'])
    ->name('dd.bond.download');

//fd-mis-passbooks
// Route::get('/fd-mis-passbook', [PrintDocumentsController::class, 'fd_mis_passbook']);

// Route::post('/fd-mis-passbook/search', [PrintDocumentsController::class, 'searchPassbook'])
//     ->name('passbook.search');

// Route::get('/fd-mis-passbook/download/{id}', [PrintDocumentsController::class, 'printpassbook'])
//     ->name('passbook.download');

// Route::get('/fd-mis-passbook/accounts/{type}', [PrintDocumentsController::class, 'getAccountsByType']);

//letter head
Route::get('/view/letter-head', [PrintDocumentsController::class, 'letter_head'])->name('print.letter-head');

Route::get('/letter-head', [PrintDocumentsController::class, 'print_letter_head'])
    ->name('letterhead.download');



Route::get('/index-from-i', [PrintDocumentsController::class, 'index_formi'])
    ->name('index-from-i');

Route::get(
    '/form-i-j-view',
    [PrintDocumentsController::class, 'generateFormJview']
)->name('formj.view');
Route::get(
    '/form-i-and-j',
    [PrintDocumentsController::class, 'generateFormJ']
)->name('formj.download');
Route::get('/form-i-and-j/print', [PrintDocumentsController::class, 'generateFormJPrint'])->name('generateFormJPrint');


Route::get('/from-i-view', [PrintDocumentsController::class, 'formiView'])
    ->name('from-i-view');

Route::get('/form-i-pdf', [PrintDocumentsController::class, 'generateFormI'])
    ->name('formi.pdf');
Route::get('/form-i-pdf/print', [PrintDocumentsController::class, 'generateFormIPrint'])->name('generateFormIPrint');

Route::get('/proceding-book-view', [PrintDocumentsController::class, 'procedingBookView'])
    ->name('proceding-book.view');
Route::get('/proceding-book', [PrintDocumentsController::class, 'procedingBook'])
    ->name('proceding-book.pdf');
Route::get('/proceding-book/print', [PrintDocumentsController::class, 'procedingBookPrint'])->name('procedingBookPrint');
//   Route::get(
//     '/form-j/{member}',
//     [PrintDocumentsController::class, 'generateFormJ']
// )->name('formj.download');


// form e

Route::get('/index-from-e', [PrintDocumentsController::class, 'index_forme'])
    ->name('index-from-e');

Route::get('/letterhead-e', [PrintDocumentsController::class, 'letterheadView'])
    ->name('letterhead-e');
Route::get('/letterhead-e-pdf', [PrintDocumentsController::class, 'letterhead'])
    ->name('letterhead-e.pdf');

Route::get('/letterheadPrint/print', [PrintDocumentsController::class, 'letterheadPrint'])->name('letterheadPrint');
Route::get('/e-one-view', [PrintDocumentsController::class, 'eOneView'])
    ->name('eOneView');
Route::get('/e-one', [PrintDocumentsController::class, 'eOneForm'])
    ->name('eOneForm');
Route::get('/form-e1/print', [PrintDocumentsController::class, 'eOnePrint'])->name('eOnePrint');

Route::get('/e-two-view', [PrintDocumentsController::class, 'eTwoView'])
    ->name('eTwoView');
Route::get('/e-two', [PrintDocumentsController::class, 'eTwo'])
    ->name('eTwoForm');

Route::get('/form-e2/print', [PrintDocumentsController::class, 'eTwoPrint'])->name('eTwoPrint');


//Management Information Systems
Route::get('/mis-index', [PrintDocumentsController::class, 'mis_index'])
    ->name('mis_index');
Route::get('/mis-one-view', [PrintDocumentsController::class, 'MisOneView'])
    ->name('MisOneView');
Route::get('/mis-one', [PrintDocumentsController::class, 'MisOneForm'])
    ->name('MisOneForm');
Route::get('/mis-one/print', [PrintDocumentsController::class, 'MisOneFormPrint'])->name('MisOneFormPrint');


Route::get('/management-info-two-view', [PrintDocumentsController::class, 'MisTwoView'])
    ->name('MisTwoView');
Route::get('/management-info-two', [PrintDocumentsController::class, 'MisTwo'])
    ->name('MisTwo');
Route::get('/mis-two/print', [PrintDocumentsController::class, 'MisTwoPrint'])->name('MisTwoPrint');
/////////////////////////////print-documents-end //////////////////////////

///////////////  Logo Img Upload  /////////////////////////////

Route::get('/pdf-images', [LogoImgUploadController::class, 'index'])->name('pdf-images.index');
Route::post('/pdf-images', [LogoImgUploadController::class, 'store'])->name('pdf-images.store');


////////////////// end Logo Img Upload//////////////////////////

///////////////  software-settings  /////////////////////////


Route::get('master-settings/index', [MasterSettingController::class, 'index'])->name('master-settings.index');

Route::get('master-settings/edit', [MasterSettingController::class, 'edit'])->name('master-settings.edit');
Route::put('/master-settings', [MasterSettingController::class, 'update'])->name('master-settings.update');
// Route::post('/master-settings',[MasterSettingController::class,'update'])->name('master-settings.update');

Route::get('master-settings/edit-attendence', [MasterSettingController::class, 'edit_attendence'])->name('master-settings.edit-attendence');
Route::get('master-settings/bank-list', [MasterSettingController::class, 'bank_list'])->name('master-settings.bank-list');
Route::get('master-settings/edit-business-type', [MasterSettingController::class, 'edit_business_type'])->name('master-settings.edit-business-type');

Route::get('master-settings/edit-npa-provisioning-settings', [MasterSettingController::class, 'npa_provisioning_settings'])->name('master-settings.npa-provisioning-settings');

Route::get('master-settings/edit-goldloan-settings', [MasterSettingController::class, 'edit_goldloan_settings'])->name('master-settings.edit-goldloan-settings');

Route::get('master-settings/edit-personal-loan-settings', [MasterSettingController::class, 'edit_personal_loan_settings'])->name('master-settings.edit-personal-loan-settings');

Route::get('master-settings/edit-deposit-loan', [MasterSettingController::class, 'edit_deposit_loan'])->name('master-settings.edit-deposit-loan');

Route::get('master-settings/edit-cc-limit', [MasterSettingController::class, 'edit_cc_limit'])->name('master-settings.edit-cc-limit');

Route::get('master-settings/loan-apr-level-name', [MasterSettingController::class, 'loan_apr_level_name'])->name('master-settings.loan-apr-level-name');

Route::get('master-settings/dailycash-deposit', [MasterSettingController::class, 'dailycash_deposit'])->name('master-settings.dailycash-deposit');


Route::get('master-settings/daily-reminder-setting', [MasterSettingController::class, 'daily_reminder_setting'])->name('master-settings.daily-reminder-setting');

Route::get('master-settings/edit-rd-settings', [MasterSettingController::class, 'edit_rd_settings'])->name('master-settings.edit-rd-settings');

Route::get('master-settings/edit-dd-settings', [MasterSettingController::class, 'edit_dd_settings'])->name('master-settings.edit-dd-settings');

Route::get('master-settings/edit-business-loan', [MasterSettingController::class, 'edit_business_loan'])->name('master-settings.edit-business-loan');
Route::get('master-settings/edit-property-loan', [MasterSettingController::class, 'edit_property_loan'])->name('master-settings.edit-property-loan');

Route::get('master-settings/edit-vehicle-settings', [MasterSettingController::class, 'edit_vehicle_settings'])->name('master-settings.edit-vehicle-settings');

Route::get('master-settings/edit-daily-weekly-settings', [MasterSettingController::class, 'edit_daily_weekly_settings'])->name('master-settings.edit-daily-weekly-settings');



//sms settings

Route::get('software-settings/add-sms', [SmsTemplateController::class, 'add_sms'])->name('software-settings.add-sms');
Route::post('/sms/store', [SmsTemplateController::class, 'store'])->name('sms.store');

Route::get('software-settings/sms-list', [SmsTemplateController::class, 'sms_list'])->name('software-settings.sms-list');

Route::post('/toggle-sms-status', [SmsTemplateController::class, 'toggleStatus'])
    ->name('software-settings.toggle-sms-status');

Route::get('software-settings/view-sms-list/{id}', [SmsTemplateController::class, 'view_sms_list'])->name('software-settings.view-sms-list');

Route::get('software-settings/edit-sms-setting/{id}', [SmsTemplateController::class, 'edit_sms_setting'])->name('software-settings.edit-sms-setting');

Route::post(
    'software-settings/update-sms-setting/{id}',
    [SmsTemplateController::class, 'update_sms_setting']
)->name('software-settings.update-sms-setting');

Route::post('software-settings/send-test-sms/{id}', [SmsTemplateController::class, 'sendTestSms'])
    ->name('software-settings.send-test-sms');


Route::get('software-settings/sms-history', [SoftwareSettingsController::class, 'sms_history'])->name('software-settings.sms-history');

Route::get('software-settings/mail-history', [SoftwareSettingsController::class, 'mail_history'])->name('software-settings.mail-history');

Route::get('software-settings/comment-history', [SoftwareSettingsController::class, 'comment_history'])->name('software-settings.comment-history');

Route::get('software-settings/internet_banking', [SoftwareSettingsController::class, 'internet_banking'])->name('software-settings.internet-banking.internet-banking');

Route::get('software-settings/internet-edit', [SoftwareSettingsController::class, 'internet_banking_edit'])->name('software-settings.internet-banking.internet-edit');

Route::get('software-settings/account-series-settings', [SoftwareSettingsController::class, 'account_series_settings'])->name('software-settings.account-series-settings');

Route::get('software-settings/software-alerts', [SoftwareSettingsController::class, 'software_alerts'])->name('software-settings.software-alerts.software-alerts');

Route::get('software-settings/update-software-alerts', [SoftwareSettingsController::class, 'update_software_alerts'])->name('software-settings.software-alerts.update-software-alerts');

Route::get('software-settings/form-field-setting', [SoftwareSettingsController::class, 'form_field_setting'])->name('software-settings.form-field-setting');

Route::get('software-settings/gold-rate-calender', [SoftwareSettingsController::class, 'gold_rate_calender'])->name('software-settings.gold-rate-calender');

Route::get('software-settings/event-calender', [SoftwareSettingsController::class, 'event_calender'])->name('software-settings.event-calender.event-calender');
Route::get('software-settings/all-event-list', [SoftwareSettingsController::class, 'all_event_list'])->name('software-settings.event-calender.all-event-list');
Route::get('software-settings/deleted-entry-log', [SoftwareSettingsController::class, 'deleted_entry_log'])->name('software-settings.deleted-logs.deleted-entry-log');

Route::get('software-settings/deleted-entry-log-view', [SoftwareSettingsController::class, 'deleted_entry_log_view'])->name('software-settings.deleted-logs.deleted-entry-log-view');

Route::get('software-settings/login-activity', [SoftwareSettingsController::class, 'login_activity'])->name('software-settings.login-activity');

Route::get('software-settings/user-activity-tracking', [SoftwareSettingsController::class, 'user_activity_tracking'])->name('software-settings.user-activity-tracking');
Route::get('software-settings/mail-setting', [SoftwareSettingsController::class, 'mail_setting'])->name('software-settings.mail-setting');
Route::get('software-settings/edit-mail-setting', [SoftwareSettingsController::class, 'edit_mail_setting'])->name('software-settings.edit-mail-setting');

Route::get('software-settings/software-service-agreement', [SoftwareSettingsController::class, 'software_service_agreement'])->name('software-settings.software-service-agreement');
/////////////// end software-settings  //////////////////////



///////////////////// Download REPORTs ///////////////////////////
Route::get('loan-report/index', [ReportController::class, 'loan_report_index'])->name('loan-report.index');
Route::get('maturity-indext/index', [ReportController::class, 'maturity_index'])->name('loan-report.maturity_index');
Route::get('/reports/branch-report', [ReportController::class, 'branch_index'])->name('reports.branch');


////////////////////Download REPORTs Ends Here////////////////////////////



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

            case 'seed-menu':
                Artisan::call('db:seed', ['--class' => 'MenuSeeder']);
                return "MenuSeeder database seeding completed!";

            case 'seed-role':
                Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
                return "RoleSeeder database seeding completed!";

            case 'storage-link':
                Artisan::call('storage:link');
                $output = Artisan::output();
                return "Storage link created!" . nl2br($output);

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
