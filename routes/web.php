<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrivateTransferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TradingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PromotorController;
use App\Http\Controllers\ShareHoldingController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MinorController;
use App\Http\Controllers\ShareHoldingsController;
use App\Http\Controllers\ShareCertificateController;
use App\Http\Controllers\ShareTrasferHistoryController;
use App\Http\Controllers\Form15Gor15HController;
// use App\Http\Controllers\SchemesController;
// use App\Http\Controllers\AccountController;
// use App\Http\Controllers\SavingAccountController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get(
    'clear-cache',
    function () {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        //  Artisan::call('storage:link');
        return "Cache cleared!";
    }
);
Route::get('/', [AuthenticationController::class, 'signIn'])->name('sign.in');

Route::post('/login', [AuthenticationController::class, 'login'])->name('log.in');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('log.out');
Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('reset.password');

Route::get('/api/states', [StateController::class, 'getStates']);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    // Route::resource('products', ProductController::class);
});

Route::middleware('auth.user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index1'])->name('index1');
    // Company profile
    Route::get('create-profile', [CompanyController::class, 'create'])->name('create.profile');
    Route::get('manage-profile', [CompanyController::class, 'index'])->name('manage.profile');
    Route::post('add-profile', [CompanyController::class, 'store'])->name('add.profile');
    Route::get('/company/view', [CompanyController::class, 'show'])->name('company.view');
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/company/update', [CompanyController::class, 'update'])->name('company.update');
    // Route::delete('/company/{id}/delete', [CompanyController::class, 'destroy'])->name('company.delete');

    // Branch 
    Route::get('create-branch', [BranchController::class, 'create'])->name('create.branch');
    Route::get('manage-branch', [BranchController::class, 'index'])->name('manage.branch');
    Route::post('add-branch', [BranchController::class, 'store'])->name('add.branch');
    Route::get('/branch/{id}/view', [BranchController::class, 'show'])->name('branch.view');
    Route::get('/branch/{id}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    Route::post('/branch/{id}/update', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('/branch/{id}/delete', [BranchController::class, 'destroy'])->name('branch.delete');

    // Promotors
    Route::get('manage-promotor', [PromotorController::class, 'index'])->name('manage.promotor');
    Route::get('create-promotor', [PromotorController::class, 'create'])->name('create.promotor');
    Route::post('add-promotor', [PromotorController::class, 'store'])->name('add.promotor');
    Route::get('/promotor/{id}/view', [PromotorController::class, 'show'])->name('promotor.view');
    Route::get('/promotor/{id}/edit', [PromotorController::class, 'edit'])->name('promotor.edit');
    Route::post('/promotor/{id}/update', [PromotorController::class, 'update'])->name('promotor.update');
    Route::delete('/promotor/{id}/delete', [PromotorController::class, 'destroy'])->name('promotor.delete');

    Route::get('/get-branches', [BranchController::class, 'getBranches']);
    Route::get('/get-marital-statuses', [PromotorController::class, 'getMariatalStatuses']);
    Route::get('/get-religion-statuses', [PromotorController::class, 'getReligion']);

    // Promoters & Share Holdings
    Route::get('manage-shareholding', [ShareHoldingController::class, 'index'])->name('manage.shareholding');
    Route::get('create-shareholding', [ShareHoldingController::class, 'create'])->name('create.shareholding');
    Route::post('add-shareholding', [ShareHoldingController::class, 'store'])->name('add.shareholding');

    // Director
 Route::resource('director', DirectorController::class);

//Member Management:
//Member
 Route::resource('member', MemberController::class);
 //Minor
 Route::resource('minor', MinorController::class);
// //Shareholding  
Route::resource('shares-holdings', ShareHoldingsController::class);
 //Share Certificate'
Route::resource('share-certificates', controller: ShareCertificateController::class);
//ShareTrasferHistory
Route::resource('share-transfer-histories', ShareTrasferHistoryController::class);
//Form15Gor15HController
Route::resource('Form 15G and 15H', Form15Gor15HController::class);

//saving and curent AC:-
// //Schemes
// Route::resource('scheme', SchemesController::class);
// //Account
// Route::resource('saving-current-account', AccountController::class);
// // SavingAccount
// Route::resource('SavingAccount', SavingAccountController::class);


    // Permission & Roles
    Route::get('manage-permission', [RoleController::class, 'index'])->name('manage.permission');
    Route::get('create-role', [RoleController::class, 'create'])->name('create.role');


    // Users
    Route::get('manage-user', [UserController::class, 'index'])->name('manage.user');
});



Route::get('create-role', [RoleController::class, 'create'])->name('create.role');

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/style-2', [DashboardController::class, 'index2'])->name('index2');
    Route::get('/style-3', [DashboardController::class, 'index3'])->name('index3');
    Route::get('/style-4', [DashboardController::class, 'index4'])->name('index4');
    Route::get('/style-5', [DashboardController::class, 'index5'])->name('index5');
});


Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Route::get('/admin/dashboard', [DashboardController::class, 'index1'])->name('index1');
});

Route::middleware(['auth', 'role:Company'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'index']);
});

Route::middleware(['auth', 'role:Branch'])->group(function () {
    // Route::get('/branch/dashboard', [BranchController::class, 'index']);
});

Route::middleware(['auth', 'role:Member'])->group(function () {
    // Route::get('/member/dashboard', [MemberController::class, 'index']);
});







Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
    Route::get('/bank-account', [AccountsController::class, 'bankAccount'])->name('bank.account');
    Route::get('/account-overview', [AccountsController::class, 'accountOverview'])->name('account.overview');
    Route::get('/account-details', [AccountsController::class, 'accountDetails'])->name('account.details');
    Route::get('/deposit-detail', [AccountsController::class, 'depositDetail'])->name('deposit.detail');
});

Route::group(['prefix' => 'cards', 'as' => 'cards.'], function () {
    Route::get('/overview', [CardsController::class, 'overview'])->name('overview');
    Route::get('/details', [CardsController::class, 'details'])->name('details');
});

Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
    Route::get('/style-1', [TransactionController::class, 'style1'])->name('style1');
    Route::get('/style-2', [TransactionController::class, 'style2'])->name('style2');
    Route::get('/style-3', [TransactionController::class, 'style3'])->name('style3');
});

Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
    Route::get('/overview', [PaymentController::class, 'overview'])->name('overview');
    Route::get('/providers', [PaymentController::class, 'providers'])->name('providers');
    Route::get('/exchange', [PaymentController::class, 'exchange'])->name('exchange');
    Route::get('/make-payment', [PaymentController::class, 'makePayment'])->name('make.payment');
});

Route::group(['prefix' => 'transfer', 'as' => 'transfer.'], function () {
    Route::get('/add-contact', [PrivateTransferController::class, 'addContact'])->name('add.contact');
    Route::get('/overview', [PrivateTransferController::class, 'overview'])->name('overview');
    Route::get('/make-transfer', [PrivateTransferController::class, 'makeTransfer'])->name('make.transfer');
    Route::get('/chat', [PrivateTransferController::class, 'chat'])->name('chat');
});

Route::group(['prefix' => 'invoicing', 'as' => 'invoicing.'], function () {
    Route::get('/add-new', [InvoicingController::class, 'addInvoicing'])->name('add.invoicing');
    Route::get('/style-1', [InvoicingController::class, 'style1'])->name('style1');
    Route::get('/style-2', [InvoicingController::class, 'style2'])->name('style2');
});

Route::group(['prefix' => 'trading', 'as' => 'trading.'], function () {
    Route::get('/style-1', [TradingController::class, 'style1'])->name('style1');
    Route::get('/style-2', [TradingController::class, 'style2'])->name('style2');
    Route::get('/style-3', [TradingController::class, 'style3'])->name('style3');
});

Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::get('/style-1', [ReportController::class, 'style1'])->name('style1');
    Route::get('/style-2', [ReportController::class, 'style2'])->name('style2');
});

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::get('/social-network', [SettingsController::class, 'socialNetwork'])->name('social.network');
    Route::get('/notification', [SettingsController::class, 'notification'])->name('notification');
    Route::get('/payment-limit', [SettingsController::class, 'paymentLimit'])->name('payment.limit');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('/sign-up', [AuthenticationController::class, 'signUp'])->name('sign.up');
    // Route::get('/sign-in', [AuthenticationController::class, 'signIn'])->name('sign.in');
    Route::get('/sign-in-qrcode', [AuthenticationController::class, 'signInQrcode'])->name('sign.in.qrcode');
    Route::get('/error', [AuthenticationController::class, 'error'])->name('error');
});

Route::group(['prefix' => 'support', 'as' => 'support.'], function () {
    Route::get('/help-center', [SupportController::class, 'helpCenter'])->name('help.center');
    Route::get('/privacy-policy', [SupportController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::get('/contact-us', [SupportController::class, 'contactUs'])->name('contact.us');
});

Route::view('/components', 'components')->name('components');
