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
use App\Http\Controllers\HRController;


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

Route::get('/migrate/menu', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_11_051649_create_menu_table.php',
        '--force' => true,
    ]);
    return 'Menu table migration ran successfully!';
});

/* Route::get('/migrate/icon', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_11_084635_add_icon_to_menu_table.php',
        '--force' => true,
    ]);
    return 'Icon migration ran successfully on menu!';
}); */

Route::get('/migrate/member', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_095106_create_members_table.php',
        '--force' => true,
    ]);
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_095810_create_addresses_table.php',
        '--force' => true,
    ]);

    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_100020_create_kyc_and_nominees_table.php',
        '--force' => true,
    ]);

    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_111226_create_directors_table.php',
        '--force' => true,
    ]);

    return 'Icon migration ran successfully on menu!';
});


Route::get('/migrate/menus', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_072005_create_menus_table',
        '--force' => true,
    ]);
    return 'Menu table migration ran successfully!';
});

Route::get('/migrate/submenu', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_072039_create_submenus_table.php',
        '--force' => true,
    ]);
    return 'Sub Menu table migration ran successfully!';
});

Route::get('/seed/BankNameSeeder', function () {
    Artisan::call('db:seed', [
        '--class' => 'BankNameSeeder',
        '--force' => true,
    ]);
    return 'Bank Seeder has been run successfully!';
});

Route::get('/seed/BloodGroupSeeder', function () {
    Artisan::call('db:seed', [
        '--class' => 'BloodGroupSeeder',
        '--force' => true,
    ]);
    return 'BloodGroupSeeder has been run successfully!';
});
Route::get('/seed/PayableExpenseSeeder', function () {
    Artisan::call('db:seed', [
        '--class' => 'PayableExpenseSeeder',
        '--force' => true,
    ]);
    return 'PayableExpenseSeeder has been run successfully!';
});
Route::get('/seed/PayableLedgerSeeder', function () {
    Artisan::call('db:seed', [
        '--class' => 'PayableLedgerSeeder',
        '--force' => true,
    ]);
    return 'PayableLedgerSeeder has been run successfully!';
});
Route::get('/seed/RelationshipSeeder', function () {
    Artisan::call('db:seed', [
        '--class' => 'RelationshipSeeder',
        '--force' => true,
    ]);
    return 'RelationshipSeeder has been run successfully!';
});
// Route::get('/seed/menu', function () {
//     Artisan::call('db:seed', [
//         '--class' => 'MenuSeeder',
//         '--force' => true,
//     ]);
//     return 'MenuSeeder has been run successfully!';
// });

Route::get('/migrate/shareholdings', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_12_173835_create_shareholdings_table.php',
        '--force' => true,
    ]);
    return 'Shareholdings migration ran successfully!';
});

Route::get('/migrate/directors', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_12_172739_directors_table.php',
        '--force' => true,
    ]);
    return 'Directors migration ran successfully!';
});

Route::get('/migrate/menus', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_13_072005_create_menus_table',
        '--force' => true,
    ]);
    return 'Menu table migration ran successfully!';
});

Route::get('/migrate/employee', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_14_045750_create_employees_table',
        '--force' => true,
    ]);
    return 'Employee table migration ran successfully!';
});

Route::get('/migrate/blood_group', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_14_063616_create_blood_group_table',
        '--force' => true,
    ]);
    return 'Blood Group table migration ran successfully!';
});

Route::get('/migrate/bank_name', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_14_075832_create_banks_name_table',
        '--force' => true,
    ]);
    return 'Bank Name table migration ran successfully!';
});

Route::get('/migrate/relation', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_14_090604_create_relationship_table',
        '--force' => true,
    ]);
    return 'Relation table migration ran successfully!';
});

Route::get('/migrate/payable/ledger', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_14_093548_create_payable_ledgers_table',
        '--force' => true,
    ]);
    return 'Payable Ledger table migration ran successfully!';
});

Route::get('/migrate/expense/ledger', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/database/migrations/2025_07_14_093834_create_expense_ledgers_table',
        '--force' => true,
    ]);
    return 'Expense ledger table migration ran successfully!';
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
    // Route::delete('/company/{id}/delete', [CompanyController::class, 'destroy'])->name('company.delete');

    // Branch 
    Route::get('create-branch', [BranchController::class, 'create'])->name('create.branch');
    Route::get('manage-branch', [BranchController::class, 'index'])->name('manage.branch');
    Route::post('add-branch', [BranchController::class, 'store'])->name('add.branch');
    Route::get('/branch/{id}/view', [BranchController::class, 'show'])->name('branch.view');
    Route::get('/branch/{id}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    Route::post('/branch/{id}/update', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('/branch/{id}/delete', [BranchController::class, 'destroy'])->name('branch.delete');

    
    // // Branch 
    // Route::get('create-branch', [BranchController::class, 'create'])->name('create.branch');
    // //Route::get('manage-branch', [BranchController::class, 'index'])->name('manage.branch');
    // Route::get('ManageBranch', [BranchController::class, 'index'])->name('manage.branch');
    // Route::post('add-branch', [BranchController::class, 'store'])->name('add.branch');
    // Route::get('/branch/{id}/view', [BranchController::class, 'show'])->name('branch.view');
    // Route::get('/branch/{id}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    // Route::post('/branch/{id}/update', [BranchController::class, 'update'])->name('branch.update');
    // Route::delete('/branch/{id}/delete', [BranchController::class, 'destroy'])->name('branch.delete');
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

Route::get('/migrate/relation', function () {
    Artisan::call('migrate', [
        '--path' => 'database/migrations/2025_07_14_063750_create_relation_table',
        '--force' => true,
    ]);
    return 'Relation table migration ran successfully!';
});

Route::middleware('auth.user')->group(function () {
    // Company profile
      Route::get('ManageProfile', [CompanyController::class, 'index'])->name('ManageProfile');
    Route::get('CompanyView', [CompanyController::class, 'show'])->name('company.view');
    // Route::delete('/company/{id}/delete', [CompanyController::class, 'destroy'])->name('company.delete');

    // Branch 
    Route::get('create-branch', [BranchController::class, 'create'])->name('create.branch');
    //Route::get('manage-branch', [BranchController::class, 'index'])->name('manage.branch');
    Route::get('ManageBranch', [BranchController::class, 'index'])->name('manage.branch');
    Route::post('add-branch', [BranchController::class, 'store'])->name('add.branch');
    Route::get('/branch/{id}/view', [BranchController::class, 'show'])->name('branch.view');
    Route::get('/branch/{id}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    Route::post('/branch/{id}/update', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('/branch/{id}/delete', [BranchController::class, 'destroy'])->name('branch.delete');

    // Promotors
    // Route::get('manage-promotor', [PromotorController::class, 'index'])->name('manage.promotor');
    Route::get('ManagePromotor', [PromotorController::class, 'index'])->name('ManagePromotor');
    Route::get('create-promotor', [PromotorController::class, 'create'])->name('create.promotor');
    Route::post('add-promotor', [PromotorController::class, 'store'])->name('add.promotor');
    Route::get('/promotor/{id}/view', [PromotorController::class, 'show'])->name('promotor.view');
    Route::get('/promotor/{id}/edit', [PromotorController::class, 'edit'])->name('promotor.edit');
    Route::post('/promotor/{id}/update', [PromotorController::class, 'update'])->name('promotor.update');
    Route::delete('/promotor/{id}/delete', [PromotorController::class, 'destroy'])->name('promotor.delete');
    Route::get('/get-promoters', [PromotorController::class, 'getPromoters']);
    Route::get('/get-relation', [HRController::class, 'getRelations']);
    Route::get('/get-bank', [HRController::class, 'getBanks']);
    Route::get('/get-payable-expense', [HRController::class, 'payableExpense']);
    Route::get('/get-payable-ledger', [HRController::class, 'payableLedger']);
    Route::get('/get-blood-group', [HRController::class, 'bloodGroup']);

    Route::get('/get-branches', [BranchController::class, 'getBranches']);
    Route::get('/get-marital-statuses', [PromotorController::class, 'getMariatalStatuses']);
    Route::get('/get-religion-statuses', [PromotorController::class, 'getReligion']);

    // Promoters & Share Holdings
    // Route::get('manage-shareholding', [ShareHoldingController::class, 'index'])->name('manage.shareholding');
    Route::get('ManageShareholding', [ShareHoldingController::class, 'index'])->name('manage.shareholding');
    Route::get('create-shareholding', [ShareHoldingController::class, 'create'])->name('create.shareholding');
    Route::post('add-shareholding', [ShareHoldingController::class, 'store'])->name('add.shareholding');


    // Directors
    Route::resource('director', DirectorController::class);
    Route::get('CreateDirector', [DirectorController::class, 'create'])->name('CreateDirector');
    Route::post('storeDirector', [DirectorController::class, 'store'])->name('storeDirector');

    // Member
    Route::resource('member', MemberController::class);

    // Permission & Roles
    // Route::get('ManagePermission', [RoleController::class, 'index'])->name('manage.permission');
    Route::get('CreateRole', [RoleController::class, 'create'])->name('CreateRole');


    // Users
    Route::get('ManageUser', [UserController::class, 'index'])->name('ManageUser');
    Route::get('CreateUser', [UserController::class, 'create'])->name('CreateUser');


    //HR & Management
    Route::get('HR/ManageEmployee', [HRController::class, 'index'])->name('ManageEmployee');
    Route::get('CreateEmployee', [HRController::class, 'create'])->name('CreateEmployee');
    Route::post('AddEmployee', [HRController::class, 'store'])->name('AddEmployee');
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
});

Route::view('/components', 'components')->name('components');
