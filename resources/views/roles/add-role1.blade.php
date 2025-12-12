@extends('layout.main')
@php
use App\Models\Menu;
$menuItems = Menu::where('active', 1)->with('submenus')->orderBy('position')->get();
@endphp
@section('page-title', '')

@section('content')
<style>
    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browsers */
    }
</style>
<div class="box col-span-12 lg:col-span-6">
    <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
        <h3 class="h3">ADD NEW ROLE / PERMISSION</h3>
        <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
        </ol>
        <hr class="my-2 border-gray-300" />
    </div>
    <form action="{{ route('role_permission.store') }}" method="POST" class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
        @csrf
        <div class="col-span-2 md:col-span-1">
            <label for="name" class="mb-4 md:text-lg font-medium block">
                ROLE NAME
            </label>

            <select name="role_id"
                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                placeholder="Select Role">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
            <label for="role_position" class="mb-4 md:text-lg font-medium block">
                ROLE POSITION/ WEIGHT-AGE
            </label>
            <input type="text" name="role_position"
                class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                placeholder="Enter Permission / Role Name" id="role_position" />
        </div>

        <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
            <label for="permission_type" class="uppercase md:text-lg font-medium block mb-4">
                Permission Type
                <span class="text-error">*</span>
            </label>
            <div class="flex">
                <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="permission_type" value="admin"
                        class="text-green-600 focus:ring-green-500">
                    <span class="text-gray-70 capitalize">Admin Type</span>
                </label>
                <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="permission_type" value="agent"
                        class="text-green-600 focus:ring-green-500">
                    <span class="text-gray-70 capitalize">Agent Type</span>
                </label>
                <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="permission_type" value="both"
                        class="text-green-600 focus:ring-green-500" checked>
                    <span class="text-gray-70 capitalize">Both Type</span>
                </label>
            </div>

        </div>
        <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
            <label for="active" class="uppercase md:text-lg font-medium block mb-4">
                Active
                <span class="text-error">*</span>
            </label>
            <div class="flex">
                <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="active" value="Yes"
                        class="text-green-600 focus:ring-green-500" checked>
                    <span class="text-gray-70 capitalize">Yes</span>
                </label>
                <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="active" value="No"
                        class="text-green-600 focus:ring-green-500">
                    <span class="text-gray-70 capitalize">No</span>
                </label>
            </div>
        </div>

        <div class="col-span-2 md:col-span-6 md:grid-cols-2 lg:grid-cols-3">
            <div class="main-inner">
                <button id="menuToggleBtn" type="button"
                    class="md:hidden flex items-center gap-2 min-w-max py-2 px-3 relative z-[3] rounded-lg bg-primary text-n0 chatbtn">
                    <i class="las la-bars"></i> <span>Menu</span>
                </button>
                <div class="grid grid-cols-12 relative gap-4 xxl:gap-6 max-md:mt-3 tabs">
                    <div id="chat-sidebar"
                        class="max-md:box md:bg-transparent duration-500 max-md:w-[280px] max-md:max-h-[600px]
                     max-md:overflow-y-auto max-md:rounded-xl max-md:absolute ltr:max-md:left-0 rtl:max-md:right-0 z-[3] max-md:bg-n0 max-md:dark:bg-bg4
                     max-md:top-0 md:col-span-5 xl:col-span-4 max-md:min-w-[300px] chathide">
                        <div class="md:box sticky top-20">
                            <ul class="flex flex-col gap-4 lg:gap-6 bb-dashed mb-6 pb-6">

                                @foreach ($menuItems as $key => $item)
                                <li>
                                    <button class="provider-btn tab-link active">
                                        <div>
                                            <p class="text-base xxl:text-lg font-medium">
                                                {{ $item->title }}
                                            </p>
                                        </div>
                                        <span class="icon">
                                            <i class="{{ $item->icon }}"></i>
                                        </span>
                                    </button>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-7 xl:col-span-8 box xl:p-8">
                        <!-- <div class="flex justify-between items-center gap-2 bb-dashed pb-4 mb-4 lg:mb-6 lg:pb-6">
                                               
                                                @include('partials._horizontal-options')
                                             </div> -->
                        <div class="bb-dashed border-secondary/20 mb-4 pb-4 lg:mb-6 lg:pb-6">
                            <div>
                                <!---------------------Dashboard------------------------>

                                <div class="tab-panel active">
                                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="check_all_dashboard"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="check_all"
                                                    class="text-base font-semibold cursor-pointer mb-0">Check
                                                    All</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="show_sms_bal"
                                                    name="permissions[dash_show_sms_bal]" value="show_sms_bal"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="show_sms_balance_1"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show SMS
                                                    Balance</label>
                                            </div>
                                        </div>


                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="show_sms_wallet"
                                                    name="permissions[dash_show_sms_wallet]" value="show_sms_wallet"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="show_sms_balance_1"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show SMS
                                                    Wallet Info</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_activate_sms"
                                                    name="permissions[dash_activate_sms]" value="dash_activate_sms"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_activate_sms"
                                                    class="text-base font-semibold cursor-pointer mb-0">Activate
                                                    SMS
                                                    Service</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_mob_recharge"
                                                    name="permissions[dash_show_mob_recharge]"
                                                    value="dash_show_mob_recharge"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_show_mob_recharge"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Mobile
                                                    Recharge Balance</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_generate_mob_bill"
                                                    name="permissions[dash_generate_mob_bill]"
                                                    value="dash_generate_mob_bill"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_generate_mob_bill"
                                                    class="text-base font-semibold cursor-pointer mb-0">Generate
                                                    Mobile / Bill Payment Wallet</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_verification_bal"
                                                    name="permissions[dash_show_verification_bal]"
                                                    value="dash_show_verification_bal"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_show_verification_bal"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show
                                                    Verification Suite Balance</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_email_token"
                                                    name="permissions[dash_show_email_token]"
                                                    value="dash_show_email_token"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_show_email_token"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Email
                                                    Token Balance</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_cashfree_wallet_bal"
                                                    name="permissions[dash_show_cashfree_wallet_bal]"
                                                    value="dash_show_cashfree_wallet_bal"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_show_cashfree_wallet_bal"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show
                                                    CashFree Wallet Balance</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_hypto_bal"
                                                    name="permissions[dash_show_hypto_bal]"
                                                    value="dash_show_hypto_bal"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_show_hypto_bal"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Hypto
                                                    Wallet Balance</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_prepaid_bal"
                                                    name="permissions[dash_show_prepaid_bal]"
                                                    value="dash_show_prepaid_bal"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                                <label for="dash_show_prepaid_bal"
                                                    class="text-base font-semibold cursor-pointer mb-0">Show Happay
                                                    Prepaid Card Balance</label>
                                            </div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1">
                                            <div class="flex items-center gap-2 space-x-2">
                                                <input type="checkbox" id="dash_show_debit_bal"
                                                    name="permissions[dash_show_debit_bal]"
                                                    value="dash_show_debit_bal"
                                                    class="form-checkbox h-5 w-5 text-primary">
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
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all_profile"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_1" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance_1"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Company
                                                Profile</label>
                                        </div>
                                    </div>


                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_1" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance_1"
                                                class="text-base font-semibold cursor-pointer mb-0">Upload Company
                                                Logo</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_3" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance_3"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Company
                                                Profile</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_4" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance_4"
                                                class="text-base font-semibold cursor-pointer mb-0">Upload Company
                                                Favicon</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_5" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance_5"
                                                class="text-base font-semibold cursor-pointer mb-0">Upload Company
                                                Login BG Image</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
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
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Branch
                                                List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Branch</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_branch" name="permissions[]"
                                                value="show_branch" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Branch
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Branch
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Branch Deposit
                                                Cash
                                                Lock</label>
                                        </div>
                                    </div>

                                </div>


                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Promoters</h4>
                                    <hr>
                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Promoters
                                                List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Promoter</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Transaction
                                                List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                                                Transaction</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Delete Promoter
                                                Transaction</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Upload Promoter
                                                Documents</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Update/ Remove
                                                Promoter Documents</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                                                Contact Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                                                Bank
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add Promoter's
                                                Share
                                                Holding Nominees</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Promoter's SMS
                                                Enable/ Disable</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Promoter's
                                                Money
                                                Transfer Enable/ Disable</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Promoter Change
                                                KYC
                                                Status</label>
                                        </div>
                                    </div>

                                </div>





                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Minors</h4>
                                    <hr>
                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add
                                                Minor</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit
                                                Minor</label>
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Login Credentials</h4>
                                    <hr>
                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Reset Promoter
                                                Login
                                                Password</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Lock/Unlock
                                                Promoter
                                                Account</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
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
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Promoter Share
                                                Holdings</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Allocate New
                                                Shares
                                                to Promoter's</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                                                Share
                                                Holding Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-2">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
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
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Directors
                                                List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Director</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Director
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
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
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Encumbered
                                                Deposits
                                                List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New
                                                Encumbered
                                                Deposit</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Encumbered
                                                Deposit Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
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
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Bank Accounts
                                                List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New Bank
                                                Account</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Bank
                                                Account
                                                Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_sms_balance"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Bank
                                                Account
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
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Permission/ Role
                                            List</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Add New Permission/
                                            Role</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Show Permission/
                                            Role Info</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
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
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Users List</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">User List
                                            Download</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Show User
                                            Info</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Edit User
                                            Info</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Remove User & all
                                            details</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Reset User Login
                                            Password</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Lock/ Unlock User
                                            Account</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Reset & Send User
                                            Login Credentials via SMS</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                                    <div class="flex items-center gap-2 col-span-6">
                                        <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                            value="" class="form-checkbox h-5 w-5 text-primary">
                                        <label for="show_sms_balance"
                                            class="text-base font-semibold cursor-pointer mb-0">Upload User
                                            Photo</label>
                                    </div>
                                </div>
                            </div>

                            <!---------------------Member (Customer)------------------------>

                            <div class="tab-panel hidden">
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Customer</h4>
                                    <hr>
                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all_profile"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_1" name="permissions[]"
                                                value="customer_list" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="customer_list"
                                                class="text-base font-semibold cursor-pointer mb-0">Customer List</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_1" name="permissions[]"
                                                value="add_new_customer" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="add_new_customer"
                                                class="text-base font-semibold cursor-pointer mb-0">Add New Customer</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_3" name="permissions[]"
                                                value="allow_skip_mobile_verification" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="allow_skip_mobile_verification"
                                                class="text-base font-semibold cursor-pointer mb-0">Allow Skip Mobile No Verification</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_4" name="permissions[]"
                                                value="show_customer_info" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_customer_info"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Customer Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance_5" name="permissions[]"
                                                value="how_customer_total_deposit" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="how_customer_total_deposit"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Customer Info - Total Deposit</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="show_customer_total_loan" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_customer_total_loan"
                                                class="text-base font-semibold cursor-pointer mb-0">Show Customer Info - Total Loan Outstanding</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="edit_customer_info" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_customer_info"
                                                class="text-base font-semibold cursor-pointer mb-0">Edit Customer Info</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_sms_balance" name="permissions[]"
                                                value="customer_sms_toggle" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="customer_sms_toggle"
                                                class="text-base font-semibold cursor-pointer mb-0">Customer SMS Enable/ Disable</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="upload_customer_docs" name="permissions[]" value="Upload Customer Documents"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="upload_customer_docs" class="text-base font-semibold cursor-pointer mb-0">
                                                Upload Customer Documents
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="add_customer_comment" name="permissions[]" value="Add Customer Comment"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="add_customer_comment" class="text-base font-semibold cursor-pointer mb-0">
                                                Add Customer Comment
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="update_remove_docs" name="permissions[]" value="Update/ Remove Customer Documents"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="update_remove_docs" class="text-base font-semibold cursor-pointer mb-0">
                                                Update/ Remove Customer Documents
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="edit_contact_info" name="permissions[]" value="Edit/ Update Customer Contact Info"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_contact_info" class="text-base font-semibold cursor-pointer mb-0">
                                                Edit/ Update Customer Contact Info
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="edit_bank_info" name="permissions[]" value="Edit/ Update Customer Bank Info"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_bank_info" class="text-base font-semibold cursor-pointer mb-0">
                                                Edit/ Update Customer Bank Info
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="edit_email_phone" name="permissions[]" value="Edit/Update Customer Email Phone"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_email_phone" class="text-base font-semibold cursor-pointer mb-0">
                                                Edit/Update Customer Email Phone
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_share_holdings" name="permissions[]" value="Show Customer Share Holdings Info"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_share_holdings" class="text-base font-semibold cursor-pointer mb-0">
                                                Show Customer Share Holdings Info
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="money_transfer_toggle" name="permissions[]" value="Customer's Money Transfer Enable/ Disable"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="money_transfer_toggle" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer's Money Transfer Enable/ Disable
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="internet_banking_toggle" name="permissions[]" value="Customer's Internet Banking Enable/ Disable"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="internet_banking_toggle" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer's Internet Banking Enable/ Disable
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="remove_customer" name="permissions[]" value="Remove/ Delete Customer & all details"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="remove_customer" class="text-base font-semibold cursor-pointer mb-0">
                                                Remove/ Delete Customer & all details
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="status_active" name="permissions[]" value="Customer Change Status to Active"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="status_active" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer Change Status to Active
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="status_inactive" name="permissions[]" value="Customer Change Status to Inactive"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="status_inactive" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer Change Status to Inactive
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="kyc_status_change" name="permissions[]" value="Customer Change KYC Status"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="kyc_status_change" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer Change KYC Status
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_hide_contact" name="permissions[]" value="Customer Show / Hide Contact Details"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_hide_contact" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer Show / Hide Contact Details
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="aadhaar_verification_no_otp" name="permissions[]" value="Customer Aadhaar Verification without OTP"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="aadhaar_verification_no_otp" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer Aadhaar Verification without OTP
                                            </label>
                                        </div>
                                    </div>


                                </div>

                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Members Login Credentials</h4>
                                    <hr>
                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all"
                                                class="text-base font-semibold cursor-pointer mb-0">Check
                                                All</label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="reset_customer_password" name="permissions[]" value="Reset Customer Password"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="reset_customer_password" class="text-base font-semibold cursor-pointer mb-0">
                                                Reset Customer Password
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="lock_unlock_customer_account" name="permissions[]" value="Lock/ Unlock Customer Account"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="lock_unlock_customer_account" class="text-base font-semibold cursor-pointer mb-0">
                                                Lock/ Unlock Customer Account
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <div>
                                                <input type="checkbox" id="reset_send_login_credentials" name="permissions[]" value="Reset & Send Customer's Login Credentials via SMS"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                            </div>
                                            <div>
                                                <label for="reset_send_login_credentials" class="text-base font-semibold cursor-pointer mb-0">
                                                    Reset & Send Customer's Login Credentials via SMS
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Minors</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all_minors" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all_minors" class="text-base font-semibold cursor-pointer mb-0">
                                                Check All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="minors_list" name="permissions[]" value="Minors List"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="minors_list" class="text-base font-semibold cursor-pointer mb-0">
                                                Minors List
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="add_minor" name="permissions[]" value="Add Minor"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="add_minor" class="text-base font-semibold cursor-pointer mb-0">
                                                Add Minor
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_minor" name="permissions[]" value="Show Minor"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_minor" class="text-base font-semibold cursor-pointer mb-0">
                                                Show Minor
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="edit_minor" name="permissions[]" value="Edit Minor"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_minor" class="text-base font-semibold cursor-pointer mb-0">
                                                Edit Minor
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Auth Persons</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all_auth_person" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all_auth_person" class="text-base font-semibold cursor-pointer mb-0">
                                                Check All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="authorized_person_list" name="permissions[]" value="Authorized Persons List"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="authorized_person_list" class="text-base font-semibold cursor-pointer mb-0">
                                                Authorized Persons List
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Customer Transactions</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all_customer_transactions" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all_customer_transactions" class="text-base font-semibold cursor-pointer mb-0">
                                                Check All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="customer_transaction_list" name="permissions[]" value="Customer's Transaction List"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="customer_transaction_list" class="text-base font-semibold cursor-pointer mb-0">
                                                Customer's Transaction List
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="collect_membership_charges" name="permissions[]" value="Collect Membership Charges"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="collect_membership_charges" class="text-base font-semibold cursor-pointer mb-0">
                                                Collect Membership Charges
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="collect_share_amount_customer" name="permissions[]" value="Collect Share Amount - Customer"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="collect_share_amount_customer" class="text-base font-semibold cursor-pointer mb-0">
                                                Collect Share Amount - Customer
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="delete_customer_transaction" name="permissions[]" value="Delete Customer Transaction"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="delete_customer_transaction" class="text-base font-semibold cursor-pointer mb-0">
                                                Delete Customer Transaction
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="other_charges_customer_transaction" name="permissions[]" value="Other Charges - Customer Transaction"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="other_charges_customer_transaction" class="text-base font-semibold cursor-pointer mb-0">
                                                Other Charges - Customer Transaction
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="delete_other_charges_customer_transaction" name="permissions[]" value="Delete Other Charges - Customer Transaction"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="delete_other_charges_customer_transaction" class="text-base font-semibold cursor-pointer mb-0">
                                                Delete Other Charges - Customer Transaction
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="other_charges_clear_due" name="permissions[]" value="Other Charges - Clear Due"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="other_charges_clear_due" class="text-base font-semibold cursor-pointer mb-0">
                                                Other Charges - Clear Due
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================== SHARE HOLDINGS ================== -->
                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                                    <h4 class="h4">Share Holdings</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="check_all_share_holdings" class="form-checkbox h-5 w-5 text-primary">
                                            <label for="check_all_share_holdings" class="text-base font-semibold cursor-pointer mb-0">
                                                Check All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="customer_share_holdings_list" name="permissions[]" value="Company Customer's Share Holdings List"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="customer_share_holdings_list" class="text-base font-semibold cursor-pointer mb-0">
                                                Company Customer's Share Holdings List
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="allocate_transfer_new_shares" name="permissions[]" value="Allocate/ Transfer New Shares to Customers"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="allocate_transfer_new_shares" class="text-base font-semibold cursor-pointer mb-0">
                                                Allocate/ Transfer New Shares to Customers
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="edit_update_share_holding" name="permissions[]" value="Edit/ Update Share Holding"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_update_share_holding" class="text-base font-semibold cursor-pointer mb-0">
                                                Edit/ Update Share Holding
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="raise_share_transfer_request" name="permissions[]" value="Raise Share Transfer Request from Customer"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="raise_share_transfer_request" class="text-base font-semibold cursor-pointer mb-0">
                                                Raise Share Transfer Request from Customer
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2 ">
                                            <div>
                                                <input type="checkbox" id="allocate_new_share_direct" name="permissions[]" value="Allocate New Share - Directly Without Approval and Fill Share to Allocate"
                                                    class="form-checkbox h-5 w-5 text-primary">
                                            </div>
                                            <div>
                                                <label for="allocate_new_share_direct" class="text-base font-semibold cursor-pointer mb-0">
                                                    Allocate New Share - Directly Without Approval and Fill Share to Allocate
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex space-x-2 items-center gap-2 ">
                                            <div>
                                                <input type="checkbox" id="transfer_share_direct" name="permissions[]" value="Transfer Share - Directly Without Approval and Fill Share to Transfer"
                                                    class="w-5 form-checkbox h-5 text-primary">
                                            </div>
                                            <div>
                                                <label for="transfer_share_direct" class="w-full text-base  font-semibold cursor-pointer mb-0">
                                                    Transfer Share - Directly Without Approval and Fill Share to Transfer
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="delete_share_holding" name="permissions[]" value="Delete/ Remove Share Holding"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="delete_share_holding" class="text-base font-semibold cursor-pointer mb-0">
                                                Delete/ Remove Share Holding
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="raise_share_surrender_request" name="permissions[]" value="Raise Share Surrender Request"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="raise_share_surrender_request" class="text-base font-semibold cursor-pointer mb-0">
                                                Raise Share Surrender Request
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================== SHARE CERTIFICATES ================== -->
                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-6">
                                    <h4 class="h4">Share Certificates</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="share_certificates_list" name="permissions[]" value="Company Customer's Share Certificates List"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="share_certificates_list" class="text-base font-semibold cursor-pointer mb-0">
                                                Company Customer's Share Certificates List
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================== SHARE TRANSFER HISTORY ================== -->
                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-6">
                                    <h4 class="h4">Share Transfer History</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="share_transfer_history" name="permissions[]" value="Share Transfer History"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="share_transfer_history" class="text-base font-semibold cursor-pointer mb-0">
                                                Share Transfer History
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="company_share_transfer_register" name="permissions[]" value="Company Share Transfer Register/ History"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="company_share_transfer_register" class="text-base font-semibold cursor-pointer mb-0">
                                                Company Share Transfer Register/ History
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- ================== FORM 15G / 15H ================== -->
                                <br>
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-6">
                                    <h4 class="h4">Form 15G / 15H</h4>
                                    <hr>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="form15g_list" name="permissions[]" value="Form 15G/ 15H List"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="form15g_list" class="text-base font-semibold cursor-pointer mb-0">
                                                Form 15G/ 15H List
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="show_form15g_info" name="permissions[]" value="Show Form 15G/ 15H Info"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="show_form15g_info" class="text-base font-semibold cursor-pointer mb-0">
                                                Show Form 15G/ 15H Info
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="upload_form15g" name="permissions[]" value="Upload New Form 15G/ 15H"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="upload_form15g" class="text-base font-semibold cursor-pointer mb-0">
                                                Upload New Form 15G/ 15H
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="edit_form15g" name="permissions[]" value="Edit Form 15G/ 15H"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="edit_form15g" class="text-base font-semibold cursor-pointer mb-0">
                                                Edit Form 15G/ 15H
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-span-2 md:col-span-1">
                                        <div class="flex items-center gap-2 space-x-2">
                                            <input type="checkbox" id="delete_form15g" name="permissions[]" value="Delete Form 15G/ 15H"
                                                class="form-checkbox h-5 w-5 text-primary">
                                            <label for="delete_form15g" class="text-base font-semibold cursor-pointer mb-0">
                                                Delete Form 15G/ 15H
                                            </label>
                                        </div>
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
@endsection
@push('script')
<script>
    document.getElementById('menuToggleBtn').addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const checkAllBoxes = document.querySelectorAll('[id^="check_all_"]');
        checkAllBoxes.forEach(checkAll => {
            checkAll.addEventListener('change', function() {
                const parentGrid = this.closest('.grid');
                const checkboxes = parentGrid.querySelectorAll(
                    'input[type="checkbox"]:not([id^="check_all_"])');
                const sectionTitle = parentGrid.querySelector('h4')?.textContent.trim()
                    .toLowerCase().replace(/\s+/g, '_');
                checkboxes.forEach((checkbox, index) => {
                    checkbox.checked = checkAll.checked;
                    const labelText = checkbox.nextElementSibling?.textContent.trim()
                        .toLowerCase().replace(/\s+/g, '_');
                    const uniqueId = `${sectionTitle}_${labelText}_${index + 1}`;
                    const uniqueName = `permissions[${sectionTitle}_${index + 1}]`;
                    checkbox.id = uniqueId;
                    checkbox.name = uniqueName;
                    const label = checkbox.nextElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.setAttribute('for', uniqueId);
                    }
                });
            });
        });
    });
</script>
@endpush