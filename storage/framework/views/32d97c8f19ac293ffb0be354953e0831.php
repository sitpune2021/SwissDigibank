<?php
use App\Models\Menu;
$menuItems = Menu::where('active',1)->with('submenus')->orderBy('position')->get();
?>
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 30px;
    text-align: center;
    line-height: 30px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}

.slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked+.slider {
    background-color: #4CAF50;
}

input:checked+.slider:before {
    transform: translateX(30px);
}

.slider .switch-on,
.slider .switch-off {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider .switch-on {
    left: 0;
}

.slider .switch-off {
    right: 0;
}

.breadcrumb {
    list-style: none;
    display: flex;
    padding: 0;
    margin-bottom: 1rem;
    font-size: 14px;
}

.breadcrumb li+li::before {
    content: "/";
    padding: 0 8px;
    color: #888;
}

.breadcrumb li a {
    text-decoration: none;
    color: #007bff;
}
</style>
<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="box mb-4 xxxl:mb-6">
        <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
            <h4 class="h4">Add New Role / Permission</h4>
            <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                <!-- <li><a href="<?php echo e(url('/manage-permission')); ?>" class="text-blue-600 hover:underline">Roles</a></li>
               <li class="text-gray-500">New</li> -->
            </ol>
            <hr class="my-2 border-gray-300" />
        </div>
        <form class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
            <div class="col-span-2 md:col-span-1">
                <label for="name" class="mb-4 md:text-lg font-medium block">
                    Role Name
                </label>
                <input type="text"
                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Permission / Role Name" id="name" />
            </div>
            <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                <label for="role_position" class="mb-4 md:text-lg font-medium block">
                    Role Position/ Weight-age
                </label>
                <input type="text"
                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Permission / Role Name" id="role_position" />
            </div>
            <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                <label for="permission_type" class="mb-4 md:text-lg font-medium block">
                    Permission Type
                </label>
                <div class="flex flex-wrap gap-4 items-center">
                    <div class="flex items-center relative">
                        <input type="checkbox" id="admin_type" name="permission_types[]" value="admin"
                            class="opacity-0 absolute h-8 w-8">
                        <div
                            class="bg-n0 dark:bg-bg4 border border-gray-400 rounded-full w-5 h-5 flex justify-center items-center ltr:mr-2 focus-within:border-primary">
                        </div>
                        <label for="admin_type"
                            class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                            Admin Type
                        </label>
                    </div>
                    <div class="flex items-center relative">
                        <input type="checkbox" id="agent_type" name="permission_types[]" value="agent"
                            class="opacity-0 absolute h-8 w-8">
                        <div
                            class="bg-n0 dark:bg-bg4 border border-gray-400 rounded-full w-5 h-5 flex justify-center items-center ltr:mr-2 focus-within:border-primary">
                        </div>
                        <label for="agent_type"
                            class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                            Agent Type
                        </label>
                    </div>
                    <div class="flex items-center relative">
                        <input type="checkbox" id="both_type" name="permission_types[]" value="both"
                            class="opacity-0 absolute h-8 w-8">
                        <div
                            class="bg-n0 dark:bg-bg4 border border-gray-400 rounded-full w-5 h-5 flex justify-center items-center ltr:mr-2 focus-within:border-primary">
                        </div>
                        <label for="both_type"
                            class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                            Both Type
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                <label for="active" class="mb-4 md:text-lg font-medium block">
                    Active
                </label>
                <div class="flex flex-wrap gap-4 items-center">
                    <div class="flex items-center relative">
                        <input type="checkbox" id="yes" name="active[]" value="admin"
                            class="opacity-0 absolute h-8 w-8">
                        <div
                            class="bg-n0 dark:bg-bg4 border border-gray-400 rounded-full w-5 h-5 flex justify-center items-center ltr:mr-2 focus-within:border-primary">
                        </div>
                        <label for="admin_type"
                            class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                            yes
                        </label>
                    </div>
                    <div class="flex items-center relative">
                        <input type="checkbox" id="no" name="active[]" value="both" class="opacity-0 absolute h-8 w-8">
                        <div
                            class="bg-n0 dark:bg-bg4 border border-gray-400 rounded-full w-5 h-5 flex justify-center items-center ltr:mr-2 focus-within:border-primary">
                        </div>
                        <label for="both_type"
                            class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-span-2 md:col-span-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="main-inner">
                    <!-- <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                  <h2 class="h2">Payment Providers</h2>
                  
                  <button class="btn-primary ac-modal-btn">
                  
                      <i class="las la-plus-circle text-base md:text-lg"></i>
                  
                      Open an Account
                  
                  </button>
                  
                  </div> -->
                    <!-- Payment Providers -->
                    <button id="menuToggleBtn" type="button"
                        class="md:hidden flex items-center gap-2 min-w-max py-2 px-3 relative z-[3] rounded-lg bg-primary text-n0 chatbtn">
                        <i class="las la-bars"></i> <span>Menu</span>
                    </button>
                    <div class="grid grid-cols-12 relative gap-4 xxl:gap-6 max-md:mt-3 tabs">
                        <div id="chat-sidebar" class="max-md:box md:bg-transparent duration-500 max-md:w-[280px] max-md:max-h-[600px]
                     max-md:overflow-y-auto max-md:rounded-xl max-md:absolute ltr:max-md:left-0 rtl:max-md:right-0 z-[3] max-md:bg-n0 max-md:dark:bg-bg4
                     max-md:top-0 md:col-span-5 xl:col-span-4 max-md:min-w-[300px] chathide">
                            <div class="md:box sticky top-20">
                                <ul class="flex flex-col gap-4 lg:gap-6 bb-dashed mb-6 pb-6">

                                    <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <li>
                                        <button class="provider-btn tab-link active">
                                            <div>
                                                <p class="text-base xxl:text-lg font-medium">
                                                    <?php echo e($item->title); ?>

                                                </p>
                                            </div>
                                            <span class="icon">
                                                <i class="<?php echo e($item->icon); ?>"></i>
                                            </span>
                                        </button>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-7 xl:col-span-8 box xl:p-8">
                            <!-- <div class="flex justify-between items-center gap-2 bb-dashed pb-4 mb-4 lg:mb-6 lg:pb-6">
                       
                        <?php echo $__env->make('partials._horizontal-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     </div> -->
                            <div class="bb-dashed border-secondary/20 mb-4 pb-4 lg:mb-6 lg:pb-6">
                                <div>
                                    <!---------------------Dashboard------------------------>

                                    <div class="tab-panel active">
                                        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="check_all_dashboard" class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="check_all"
                                                        class="text-base font-semibold cursor-pointer mb-0">Check
                                                        All</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="show_sms_bal" name="permissions[dash_show_sms_bal]"
                                                        value="show_sms_bal"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="show_sms_balance_1"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show SMS
                                                        Balance</label>
                                                </div>
                                            </div>


                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="show_sms_wallet" name="permissions[dash_show_sms_wallet]"
                                                        value="show_sms_wallet"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="show_sms_balance_1"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show SMS Wallet Info</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_activate_sms" name="permissions[dash_activate_sms]"
                                                        value="dash_activate_sms"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_activate_sms"
                                                        class="text-base font-semibold cursor-pointer mb-0">Activate SMS
                                                        Service</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_mob_recharge" name="permissions[dash_show_mob_recharge]" value="dash_show_mob_recharge" class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_mob_recharge"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show Mobile
                                                        Recharge Balance</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_generate_mob_bill" name="permissions[dash_generate_mob_bill]" value="dash_generate_mob_bill" class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_generate_mob_bill"
                                                        class="text-base font-semibold cursor-pointer mb-0">Generate Mobile / Bill Payment Wallet</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_verification_bal" name="permissions[dash_show_verification_bal]"
                                                        value="dash_show_verification_bal"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_verification_bal"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show
                                                        Verification Suite Balance</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_email_token" name="permissions[dash_show_email_token]"
                                                        value="dash_show_email_token"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_email_token"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show Email Token Balance</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_cashfree_wallet_bal" name="permissions[dash_show_cashfree_wallet_bal]"
                                                        value="dash_show_cashfree_wallet_bal"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_cashfree_wallet_bal"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show
                                                        CashFree Wallet Balance</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_hypto_bal" name="permissions[dash_show_hypto_bal]"
                                                        value="dash_show_hypto_bal"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_hypto_bal"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show Hypto
                                                        Wallet Balance</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_prepaid_bal" name="permissions[dash_show_prepaid_bal]"
                                                        value="dash_show_prepaid_bal"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_prepaid_bal"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show Happay
                                                        Prepaid Card Balance</label>
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="dash_show_debit_bal" name="permissions[dash_show_debit_bal]"
                                                        value="dash_show_debit_bal"
                                                        class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                    <label for="dash_show_debit_bal"
                                                        class="text-base font-semibold cursor-pointer mb-0">Show Happay
                                                        Debit Card Balance</label>
                                                </div>
                                            </div>

                                            

                                        </div>


                                    </div>
                                </div>

                                <!---------------------Company Profile------------------------>

                                <div class="tab-panel hidden">

                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Profile</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all_profile"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance_1" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance_1"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Company
                                                    Profile</label>
                                            </div>
                                        </div>


                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance_1" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance_1"
                                                    class="text-base font-semibold cursor-pointer mb-0">Upload Company
                                                    Logo</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance_3" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance_3"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Company
                                                    Profile</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance_4" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance_4"
                                                    class="text-base font-semibold cursor-pointer mb-0">Upload Company
                                                    Favicon</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance_5" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance_5"
                                                    class="text-base font-semibold cursor-pointer mb-0">Upload Company
                                                    Login BG Image</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Software Theme
                                                    Settings</label>
                                            </div>
                                        </div>


                                    </div>
                                   
                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Branches</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Branch List</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Branch</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Branch
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Branch
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Branch Deposit Cash
                                                Lock</label>
                                            </div>
                                        </div>

                                    </div>

                                    
                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Promoters</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Promoters
                                                List</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Promoter</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Transaction
                                                List</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                                                Transaction</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Delete Promoter
                                                Transaction</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Upload Promoter
                                                Documents</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Update/ Remove
                                                Promoter Documents</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                                                Contact Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Promoter Bank
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add Promoter's Share
                                                Holding Nominees</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Promoter's SMS
                                                Enable/ Disable</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Promoter's Money
                                                Transfer Enable/ Disable</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Promoter Change KYC
                                                Status</label>
                                            </div>
                                        </div>

                                    </div>


                                    
                                    
                                    
                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Minors</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add Minor</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Minor</label>
                                            </div>
                                        </div>
                                    </div>


                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Login Credentials</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Reset Promoter Login
                                                Password</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Lock/Unlock Promoter
                                                Account</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Reset & Send
                                                Promoter Login Credentials via SMS</label>
                                            </div>
                                        </div>
                                    </div>



                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Promoters Share Holdings</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Promoter Share
                                                Holdings</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Allocate New Shares
                                                to Promoter's</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Promoter Share
                                                Holding Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-2">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Select/ Update
                                                Promoter who's Share needs to split for (New Membership
                                                Registration)</label>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    
                                    
                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Directors</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Directors
                                                List</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Director</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Director
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Director
                                                Info</label>
                                            </div>
                                        </div>
                                    </div>


                                   
                                    
                                    
                                    
                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Encumbered Deposits</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Encumbered Deposits
                                                List</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add New Encumbered
                                                Deposit</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Encumbered
                                                Deposit Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Encumbered
                                                Deposit Info</label>
                                            </div>
                                        </div>

                                    </div>



                                    <br>
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                        <h4 class="h4">Bank Accounts</h4>
                                        <hr>
                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="check_all"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Bank Accounts
                                                List</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Add New Bank
                                                Account</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Bank Account
                                                Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                    value="Thames Water"
                                                    class="form-checkbox h-5 w-5 text-primary">&nbsp;
                                                <label for="show_sms_balance"
                                                    class="text-base font-semibold cursor-pointer mb-0">Edit Bank Account
                                                Info</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>

                                <!---------------------User Management------------------------>

                                <div class="tab-panel hidden">
                                    <h4 class="text-lg font-semibold mb-4">Roles</h4>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Permission/ Role
                                                List</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New Permission/
                                                Role</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Permission/
                                                Role Info</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Permission/
                                                Role Info</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="text-lg font-semibold mb-4">Users</h4>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Users List</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">User List
                                                Download</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show User
                                                Info</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit User
                                                Info</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Remove User & all
                                                details</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Reset User Login
                                                Password</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Lock/ Unlock User
                                                Account</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Reset & Send User
                                                Login Credentials via SMS</label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                        <div class="flex items-center gap-2 col-span-6">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="Thames Water" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Upload User
                                                Photo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-panel hidden">
                                </div>
                                <div class="tab-panel hidden">
                                </div>
                                <div class="tab-panel hidden">
                                </div>
                                <div class="tab-panel hidden">
                                </div>
                                <div class="tab-panel hidden">
                                </div>
                                <div class="tab-panel hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
        <button class="btn-primary" type="submit">
            Add Role
        </button>
        <button class="btn-outline" type="reset">
            Cancel
        </button>
    </div>
    </form>
</div>
</div>
<?php $__env->stopSection(); ?>
<script>
document.getElementById('menuToggleBtn').addEventListener('click', function() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
});



document.addEventListener('DOMContentLoaded', function () {
    // Select all "Check All" checkboxes
    const checkAllBoxes = document.querySelectorAll('[id^="check_all_"]');

    checkAllBoxes.forEach(checkAll => {
        checkAll.addEventListener('change', function () {
            // Find the parent grid div (the section containing the checkboxes)
            const parentGrid = this.closest('.grid');

            // Select all checkboxes within this grid, excluding the "Check All" checkbox
            const checkboxes = parentGrid.querySelectorAll('input[type="checkbox"]:not([id^="check_all_"])');

            // Get the section title for generating unique IDs and names
            const sectionTitle = parentGrid.querySelector('h4')?.textContent.trim().toLowerCase().replace(/\s+/g, '_');

            // Toggle the checked state of all checkboxes and update IDs/names
            checkboxes.forEach((checkbox, index) => {
                // Set checked state to match "Check All"
                checkbox.checked = checkAll.checked;

                // Generate unique ID and name
                const labelText = checkbox.nextElementSibling?.textContent.trim().toLowerCase().replace(/\s+/g, '_');
                const uniqueId = `${sectionTitle}_${labelText}_${index + 1}`;
                const uniqueName = `permissions[${sectionTitle}_${index + 1}]`;

                // Update checkbox attributes
                checkbox.id = uniqueId;
                checkbox.name = uniqueName;

                // Update the corresponding label's 'for' attribute
                const label = checkbox.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    label.setAttribute('for', uniqueId);
                }
            });
        });
    });
});
</script>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Office_Work_2025\new_swiss\resources\views/roles/add-role.blade.php ENDPATH**/ ?>