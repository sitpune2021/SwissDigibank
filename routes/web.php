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
// use App\Http\Controllers\ShareHoldingsController;
// use App\Http\Controllers\ShareCertificateController;
// use App\Http\Controllers\ShareTrasferHistoryController;
use App\Http\Controllers\Form15Gor15HController;
use App\Http\Controllers\SchemesController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ShareTransferController;
use App\Http\Controllers\WithdrawController;

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
        Route::resource('promotor', PromotorController::class);
        Route::resource('shareholding', ShareHoldingController::class);
        Route::resource('director', DirectorController::class);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    });

    Route::group(['prefix' => 'members'], function () {
        Route::resource('member', MemberController::class);
        Route::resource('minor', MinorController::class);
        Route::resource('shares-transfer', ShareTransferController::class);
        Route::get('/shares-transfer/print/{id}', [ShareTransferController::class, 'print'])->name('shares-transfer.print');

        Route::post('/promoter/select-split', [ShareTransferController::class, 'selectForShareSplit'])->name('promoter.select.split');
        Route::get('/share/allocate', [ShareTransferController::class, 'transferForm'])->name('shareholding.transfer.form');
        Route::post('/share/allocate', [ShareTransferController::class, 'store'])->name('shares.allocate');
        // Route::get('/shares-transfer/{id}/download', [ShareTransferController::class, 'downloadPdf'])->name('shares-transfer.download');

        // Route::resource('shares-holdings', ShareHoldingsController::class);
        // Route::resource('share-certificates', controller: ShareCertificateController::class);
        // Route::resource('share_transfer_histories', ShareTrasferHistoryController::class);
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
        Route::post('/ajax/get-account-balance', [AccountsController::class, 'getBalance'])->name('ajax.get.account.balance');

        Route::get('/view/{id}/transaction', [AccountTransactionController::class, 'index'])->name('account.transaction');
        Route::resource('transaction', AccountTransactionController::class);
        Route::get('/export-transaction', [AccountTransactionController::class, 'downloadCsvExample'])->name('export.transaction');
        Route::get('/transaction/{id}/print', [AccountTransactionController::class, 'print'])->name('transaction.print');
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
    });

    Route::group(['prefix' => 'hr-managment'], function () {
        Route::resource('employee', HRController::class);
    });
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
