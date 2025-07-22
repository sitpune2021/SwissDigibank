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
use App\Http\Controllers\SchemesController;
use App\Http\Controllers\HRController;

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
    Route::get('ManageProfile', [CompanyController::class, 'index'])->name('ManageProfile');
    Route::post('add-profile', [CompanyController::class, 'store'])->name('add.profile');
    Route::get('/company/view', [CompanyController::class, 'show'])->name('company.view');
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/company/update', [CompanyController::class, 'update'])->name('company.update');

    // Branch 
    Route::resource('branch', BranchController::class);
    
    Route::resource('promotor', PromotorController::class);

    Route::get('/get-branches', [BranchController::class, 'getBranches']);
    Route::get('/get-marital-statuses', [PromotorController::class, 'getMariatalStatuses']);
    Route::get('/get-religion-statuses', [PromotorController::class, 'getReligion']);
    Route::get('/get-relation', [HRController::class, 'getRelations']);
    Route::get('/get-bank', [HRController::class, 'getBanks']);
    Route::get('/get-payable-expense', [HRController::class, 'payableExpense']);
    Route::get('/get-payable-ledger', [HRController::class, 'payableLedger']);
    Route::get('/get-blood-group', [HRController::class, 'bloodGroup']);

    // Promoters & Share Holdings
    Route::get('manage-shareholding', [ShareHoldingController::class, 'index'])->name('manage.shareholding');
    Route::get('create-shareholding', [ShareHoldingController::class, 'create'])->name('create.shareholding');
    Route::post('/add-shareholding', [ShareHoldingController::class, 'store'])->name('add.shareholding');
    Route::get('/shareholding/{id}/view', [ShareHoldingController::class, 'show'])->name('shareholding.view');
    Route::get('/shareholding/{id}/edit', [ShareHoldingController::class, 'edit'])->name('shareholding.edit');
    Route::put('/shareholding/{id}/update', [ShareHoldingController::class, 'update'])->name('shareholding.update');
    Route::get('/get-promoters', [PromotorController::class, 'getPromoters']);

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
 Route::resource('schemes', SchemesController::class);
// //Account
//Route::resource('account', AccountsController::class);




    // Permission & Roles
    Route::get('manage-permission', [RoleController::class, 'index'])->name('manage.permission');
    // Route::get('create-role', [RoleController::class, 'create'])->name('create.role');
    Route::get('CreateRole', [RoleController::class, 'create'])->name('CreateRole');


    // Users
    Route::get('manage-user', [UserController::class, 'index'])->name('manage.user');

    // Route::get('ManageUser', [UserController::class, 'index'])->name('ManageUser');
    Route::get('CreateUser', [UserController::class, 'create'])->name('CreateUser');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('user.update');
    

    //HR & Management
    Route::get('HR/ManageEmployee', [HRController::class, 'index'])->name('ManageEmployee');
    Route::get('CreateEmployee', [HRController::class, 'create'])->name('CreateEmployee');
    Route::post('AddEmployee', [HRController::class, 'store'])->name('AddEmployee');
    Route::get('/employee/{id}/view', [HRController::class, 'show'])->name('employee.view');
    Route::get('/employee/{id}/edit', [HRController::class, 'edit'])->name('employee.edit');
    Route::put('/employee/{id}/update', [HRController::class, 'update'])->name('employee.update');
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
