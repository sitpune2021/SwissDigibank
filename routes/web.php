<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
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
    Route::get('create-branch', [BranchController::class, 'create'])->name('create.branch');
    Route::get('manage-branch', [BranchController::class, 'index'])->name('manage.branch');
    Route::post('add-branch', [BranchController::class, 'store'])->name('add.branch');
    Route::get('/branch/{id}/view', [BranchController::class, 'show'])->name('branch.view');
    Route::get('/branch/{id}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    Route::post('/branch/{id}/update', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('/branch/{id}/delete', [BranchController::class, 'destroy'])->name('branch.delete');

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


    //Schemes
    Route::resource('schemes', SchemesController::class);

    //Account
    Route::resource('accounts', AccountsController::class);
    // Permission & Roles
    Route::get('manage-permission', [RoleController::class, 'index'])->name('manage.permission');
    Route::get('CreateRole', [RoleController::class, 'create'])->name('CreateRole');
    Route::get('manage-user', [UserController::class, 'index'])->name('manage.user');

    Route::get('CreateUser', [UserController::class, 'create'])->name('CreateUser');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('user.update');

    Route::get('HR/ManageEmployee', [HRController::class, 'index'])->name('ManageEmployee');
    Route::get('CreateEmployee', [HRController::class, 'create'])->name('CreateEmployee');
    Route::post('AddEmployee', [HRController::class, 'store'])->name('AddEmployee');
    Route::get('/employee/{id}/view', [HRController::class, 'show'])->name('employee.view');
    Route::get('/employee/{id}/edit', [HRController::class, 'edit'])->name('employee.edit');
    Route::put('/employee/{id}/update', [HRController::class, 'update'])->name('employee.update');
});

Route::get('create-role', [RoleController::class, 'create'])->name('create.role');

