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
use App\Http\Controllers\GoldLoanAccountController;
use App\Http\Controllers\GoldLoanController;
use App\Http\Controllers\PersonalDisbursementController;
use App\Http\Controllers\PersonalAccountController;
use App\Http\Controllers\MDSController;
use App\Http\Controllers\MisaccountController;
use App\Http\Controllers\MortgageLoneController;
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
use App\Http\Controllers\CcOdLoanControllerDisburments;
use App\Http\Controllers\CcOdLoanControllerAccount;
use App\Http\Controllers\BusinessLoanDisburments;
use App\Http\Controllers\BusinessLoanAccount;
use App\Http\Controllers\CutReportController;
use App\Http\Controllers\DailyWeeklyController;
use App\Http\Controllers\DailyWeeklyDisburments;
use App\Http\Controllers\DailyWeeklyAccount;
use App\Http\Controllers\DaybookController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LedgergroupController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\VehicalDisbursementController;
use App\Http\Controllers\VehicalController;
use App\Http\Controllers\VehicalAccountController;
use App\Http\Controllers\VehicalDistributorController;
use App\Http\Controllers\VendorController;

// Clear cache 
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
        Route::get('/dds-accounts/{id}/installment-receipt', [DdsAccountsController::class, 'installmentReceipt'])
            ->name('dds.installment.receipt');
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
        Route::post(
            'dds-accounts/{id}/credit-interest/store',
            [DdsAccountsController::class, 'storeCreditInterest']
        )
            ->name('ddsaccounts.storeCreditInterest');

        Route::get('dds-accounts/{id}/mark-lien-account', [DdsAccountsController::class, 'createMarkLienAccount'])
            ->name('ddsaccounts.MarkLienAccount');
        Route::get(
            '/dds-accounts/dds-nominee/{id}',
            [DdsAccountsController::class, 'accountNominee']
        )
            ->name('dds-accounts.nominee');

        Route::post(
            '/dds-accounts/{id}/nominees',
            [DdsAccountsController::class, 'saveNominees']
        )
            ->name('dds-accounts.nominees.save');

        Route::get('/change-account-info/{id}', [DdsAccountsController::class, 'changeAccountInfo'])->name('dd.change.account.info');
        Route::post('/change-account-info/{id}', [DdsAccountsController::class, 'updateAccountInfo'])
            ->name('dd.update.account.info');

        Route::get('/change-minor-info/{id}', [DdsAccountsController::class, 'changeMinorInfo'])->name('ddChange.minor.info');
        Route::post(
            '/ddsaccounts/{id}/update-minor',
            [DdsAccountsController::class, 'updateMinor']
        )->name('ddsaccounts.updateMinor');


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
    });
    Route::resource('rd-calculator', RDCalculatorController::class)
        ->only(['index', 'create', 'store']);
    Route::get('/rd-schemes/{scheme_code}', [RDCalculatorController::class, 'getScheme']);

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
        // Route to handle clearing dues (POST request)
        Route::post('members/{id}/transactions/other-charges/{chargeId}/clear-due', [MemberController::class, 'storeChargesDue'])
            ->name('members.other-charges.clearDue.handle');
        Route::get('/members/receipt/print/{id}', [MemberController::class, 'printReceipt'])
            ->middleware('auth')
            ->name('transactions.print-receipt');

        Route::get('/members/application-form/{id}', [MemberController::class, 'applicationForm'])->name('members.application_form');

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

    Route::get('/accounts/account-nominee/{id}', [AccountsController::class, 'accountNominee'])->name('saving.accounts.nominee');
    Route::post('/accounts/{id}/nominees', [AccountsController::class, 'saveNominees'])->name('accounts.nominees.save');

    Route::get('/accounts/close-account/{id}', [AccountsController::class, 'closeAccount'])->name('saving.accounts.close.account');
    Route::get('/accounts/account-form/{id}', [AccountsController::class, 'accountOpenForm'])->name('saving.accounts.open.form');
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

    // Route::resource('misaccount', MisaccountController::class);
    // Route::get('/misaccount/payout/{id}', [MisaccountController::class, 'misPayout'])->name('misaccount.mispayout');
    // Route::Post('/misaccount/process/payout/{id}', [MisaccountController::class, 'processPayout'])->name('mis.processPayout');

    // //Transactions Info
    // Route::get('/misaccount/member/{memberId}/accounts', [MisaccountController::class, 'getByMember']);
    // Route::get('/mistransaction/{id}', [MisaccountController::class, 'viewTransaction'])->name('mis.transaction');
    // Route::get('/mistransaction/view/{id}', [MisaccountController::class, 'transaction'])->name('mis.transaction.view');

    // //Route::get('fd-mis-schemes/misaccount/{id}/change-account-info', [MisaccountController::class, 'changeAccountInfo'])->name('misaccount.changeAccountInfo');
    // // Show change account info form
    // Route::get('misaccount/{id}/change-account-info', [MisaccountController::class, 'changeAccountInfo'])
    //     ->name('misaccount.changeAccountInfo');

    // // Update account info (form submit)
    // Route::post('misaccount/{id}/change-account-info', [MisaccountController::class, 'updateAccountInfo'])
    //     ->name('misaccount.updateAccountInfo');

    // // Add Nominee
    // Route::get('misaccount/{id}/add-nominee', [MisaccountController::class, 'addNominee'])
    //     ->name('misaccount.addNominee');

    // Route::post('misaccount/{id}/update-nominee', [MisaccountController::class, 'updateNominee'])
    //     ->name('misaccount.updateNominee');

    // //edit and update branches

    // Route::put('/misaccount/member/{misaccountId}/update-branch', [MisaccountController::class, 'updateBranch'])
    //     ->name('misaccount.update-branch');

    // Route::get('/misaccount/foreclose/{id}', [MisaccountController::class, 'foreclose'])->name('misaccount.foreclose');
    // Route::get('/misaccount/{id}/remove-account', [MisaccountController::class, 'removeAccount'])->name('misaccount.removeAccount');

    // Route::get('/misaccount/make-lien/{id}', [MisaccountController::class, 'makeLien'])->name('misaccount.makelien');

    // Route::get('/misaccount/credit-debit-interest/{id}', [MisaccountController::class, 'creditDebitInterest'])->name('misaccount.creditDebitInterest');
    // Route::post('/misaccount/{id}/credit-debit-interest', [MisAccountController::class, 'storeCreditDebitInterestAndTDS'])
    //     ->name('mis.creditdebit.store');


    // Route::get('/misaccount/deduct-reverse-tds/{id}', [MisaccountController::class, 'deductReverseTds'])->name('misaccount.deductReverseTds');
    // Route::post('/misaccount/{id}/deduct-reverse-tds', [MisAccountController::class, 'storeCreditDebitInterestAndTDS'])
    //     ->name('mis.creditdebit.store');

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
    Route::get('misaccount/{id}/add-nominee', [MisaccountController::class, 'addNominee'])
        ->name('misaccount.addNominee');

    Route::post('misaccount/{id}/update-nominee', [MisaccountController::class, 'updateNominee'])
        ->name('misaccount.updateNominee');

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

    Route::get('/misaccount/{id}/print-bond', [MisaccountController::class, 'misBondForm'])->name('misaccount.printbond');
    Route::get('/mis-opening-form/{id}', [MisaccountController::class, 'misOpeningForm'])->name('misaccount.openingform');
    Route::get('/mis-account/{id}/closing-form', [MisaccountController::class, 'misClosingForm'])
        ->name('misaccount.closingform');
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


    // GOld Loan Account Page
        Route::get('account/index', [GoldLoanAccountController::class, 'index'])
            ->name('gold-loan.account.index');

        Route::get('account/show/{id}', [GoldLoanAccountController::class, 'show'])
            ->name('gold-loan.account.show');
        // emi chart for process button
        Route::post('/emi/save-status', [GoldLoanAccountController::class, 'saveEmiStatus'])
            ->name('emi.saveEmiStatus');

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

    Route::get('disbursements/index', [MortgageDisbursementController::class, 'index'])->name('mortgage.disbursements.index');
    Route::post('disbursements/cancel/{id}', [MortgageDisbursementController::class, 'cancelLoan'])->name('mortgagedisbursements.cancel');
    Route::get('disbursements/disburse-loan/{id}', [MortgageDisbursementController::class, 'show'])->name('mortgage.disbursements.disburse-loan');
    Route::post('disbursements/store', [MortgageDisbursementController::class, 'store'])->name('mortgagedisbursements.store');

    Route::get('account/index', [MortgageAccountController::class, 'index'])->name('mortgage.account.index');
    Route::get('account/show/{id}', [MortgageAccountController::class, 'show'])
        ->name('mortgage.account.show');
    Route::get('mortgage-account/transaction/{id}', [MortgageAccountController::class, 'mortgageTransaction'])
        ->name('mortgage.account.transaction');
    Route::get('mortgage-account/payemi/{id}', [MortgageAccountController::class, 'mortgagePayEmi'])
        ->name('mortgage.account.pay-emi');
    Route::post('mortgage-account/payemi/{id}/pay', [MortgageAccountController::class, 'payEmiLoan'])->name('mortgage.payEmiLoan');
    Route::get('mortgage-account/pay/{id}', [MortgageAccountController::class, 'mortgagePay'])
        ->name('mortgage.account.pay');
    Route::post('/mortgage/pay-emi', [MortgageAccountController::class, 'payEmi'])->name('mortgage.payEmi');


    Route::get('lineproperty/index', [MortgageController::class, 'linepropertyindex'])->name('mortgage.lineproperty.index');
    Route::get('lineproperty/export', [MortgageController::class, 'exportLineProperty'])->name('mortgage.lineproperty.export');
    Route::get('{id}/emi-chart', [MortgageController::class, 'emiChart'])->name('mortgage.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [MortgageController::class, 'mortgagecol_process_fee'])
        ->name('mortgage.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [MortgageController::class, 'mortgagestoreProcessFee'])
        ->name('mortgage.col_process_fee.store');
    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
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
    Route::get('loanagainst/export', [LoanAgainstController::class, 'exportLoanAgainst'])->name('loanagainst.lineproperty.export');

    // Show emi chart 
    Route::get('{id}/emi-chart', [LoanAgainstController::class, 'emiChart'])->name('loanagainst.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [LoanAgainstController::class, 'loanagainst_process_fee'])
        ->name('loanagainst.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [LoanAgainstController::class, 'loanagainststoreProcessFee'])
        ->name('loanagainst.col_process_fee.store');

    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
});


/////////////////////////////////////   END DEPOSIT LOAN  REPORT   ////////////////////////////////////////////////////////


/////////////////////////////////////   Bussiness LOAN   ////////////////////////////////////////////////////////


Route::group(['prefix' => 'bussiness'], function () {

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


    // bussiness Loan Account Page
    Route::get('account/index', [BusinessLoanAccount::class, 'index'])
        ->name('bussiness.account.index');

    // Show emi chart 
    Route::get('{id}/emi-chart', [BusinessLoan::class, 'emiChart'])->name('bussiness.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [BusinessLoan::class, 'bussiness_process_fee'])
        ->name('bussiness.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [BusinessLoan::class, 'bussinessstoreProcessFee'])
        ->name('bussiness.col_process_fee.store');

    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
});


/////////////////////////////////////   END Bussiness LOAN   ////////////////////////////////////////////////////////


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


    // cc_od Loan Account Page
    Route::get('account/index', [CcOdLoanControllerAccount::class, 'index'])
        ->name('cc_od.account.index');

    // Collect Processing fee page in application view page
    Route::get('cc-od/col-process-fee/{id}', [CcOdLoanController::class, 'col_process_fee'])
        ->name('cc_od.applications.view-buttons.col_process_fee');

    Route::post('cc-od/col-process-fee/store/{id}', [CcOdLoanController::class, 'storeProcessFee'])
        ->name('ccod.col_process_fee.store');

    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
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


    // daily_weekly Loan Account Page
    Route::get('account/index', [DailyWeeklyAccount::class, 'index'])
        ->name('daily_weekly.account.index');

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

    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
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

    Route::get('account/index', [PersonalAccountController::class, 'index'])->name('personal.account.index');

    Route::get('{id}/emi-chart', [PersonalController::class, 'emiChart'])->name('personal.applications.view-buttons.show-emi-chart');

    Route::get('col-process-fee/{id}', [PersonalController::class, 'personalcol_process_fee'])
        ->name('personal.applications.view-buttons.col_process_fee');
    Route::post('col-process-fee/store/{id}', [PersonalController::class, 'personalstoreProcessFee'])
        ->name('personal.col_process_fee.store');

    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
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

    // Account
    Route::get('account/index', [VehicalAccountController::class, 'index'])->name('vehical.account.index');

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

    Route::post('applications/{id}/submit-for-approval', [MortgageController::class, 'submitForApproval'])
        ->name('applications.submitForApproval');
});


/////////////////////////////////////  END Vehical LOAN   ////////////////////////////////////////////////////////


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
    Route::get('member-locker/view', [LockerController::class, 'member_locker_view'])
        ->name('lockers.member-locker.view');
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


    Route::get('associates/add', [AdvisorController::class, 'add_adc_asc'])
        ->name('associates-advisor.associates-advisors.add');

    Route::get('associates/adv-index', [AdvisorController::class, 'adv_index'])
        ->name('associates-advisor.associates-advisors.index');

    Route::get('associates/adv-view', [AdvisorController::class, 'adv_view'])
        ->name('associates-advisor.associates-advisors.view');

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


Route::group(['prefix' => 'cut-report'], function () {
    Route::get('report/saving', [CutReportController::class, 'savingIndex'])->name('report.saving.index');
    Route::get('report/fd', [CutReportController::class, 'fdIndex'])->name('report.fd.index');
    Route::get('report/mis', [CutReportController::class, 'misIndex'])->name('report.mis.index');
    Route::get('report/dd', [CutReportController::class, 'ddIndex'])->name('report.dd.index');
    Route::get('report/rd', [CutReportController::class, 'rdIndex'])->name('report.rd.index');
});
// ledger 
Route::group(['prefix' => 'ledger-group'], function () {
    Route::get('ledger-group/index', [LedgergroupController::class, 'index'])
        ->name('ledger-group.index');

    Route::get('ledger-group/add-ledger-group', [LedgergroupController::class, 'add_ledger_group'])
        ->name('ledger-group.add-ledger-group');

    Route::get('ledger-group/view', [LedgergroupController::class, 'view'])
        ->name('ledger-group.view');

    Route::get('ledger-group/asset-ledger', [LedgergroupController::class, 'asset_ledger'])
        ->name('ledger-group.asset-ledger');



    Route::get('ledger-group/edit-ledger', [LedgergroupController::class, 'edit_ledger'])
        ->name('ledger-group.edit-ledger');

    Route::get('ledger-group/journal-entry', [LedgergroupController::class, 'journal_entry'])
        ->name('ledger-group.journal-entry');
});

// ledger
Route::group(['prefix' => 'ledger'], function () {
    Route::get('ledger/index', [LedgergroupController::class, 'led_index'])
        ->name('ledger.index');

    Route::get('ledger/add-ledger', [LedgergroupController::class, 'add_leg'])
        ->name('ledger.add-ledger');

    Route::get('ledger/update-bulkrisk', [LedgergroupController::class, 'update_bulkrisk'])
        ->name('ledger.update-bulkrisk');

    Route::get('ledger/view', [LedgergroupController::class, 'revenue_ledger'])
        ->name('ledger.view');

    Route::get('ledger/edit-ledger', [LedgergroupController::class, 'edit_ledgers'])
        ->name('ledger.edit-ledger');

    Route::get('ledger/journal-entry', [LedgergroupController::class, 'journal_entry_ledger'])
        ->name('ledger.journal-entry');
});

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

            case 'seed-menu':
                Artisan::call('db:seed', ['--class' => 'MenuSeeder']);
                return "MenuSeeder database seeding completed!";

            case 'seed-role':
                Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
                return "RoleSeeder database seeding completed!";

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
