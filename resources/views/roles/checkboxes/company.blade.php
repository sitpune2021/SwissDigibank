<div class="tab-panel hidden">
    <!----------------- PROFILE -------------------->
<div class="payload-section">

    <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
        <div class="uppercase font-semibold text-lg">Profile</div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        <div>
            <input type="checkbox"
                   id="company_profile_view"
                   name="permissions[]"
                   value="company.profile.view"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="company_profile_view">Show Company Profile</label>
        </div>

        <div>
            <input type="checkbox"
                   id="company_logo_upload"
                   name="permissions[]"
                   value="company.logo.upload"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="company_logo_upload">Upload Company Logo</label>
        </div>

        <div>
            <input type="checkbox"
                   id="company_profile_edit"
                   name="permissions[]"
                   value="company.profile.edit"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="company_profile_edit">Edit Company Profile</label>
        </div>

        <div>
            <input type="checkbox"
                   id="company_favicon_upload"
                   name="permissions[]"
                   value="company.favicon.upload"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="company_favicon_upload">Upload Company Favicon</label>
        </div>

        <div>
            <input type="checkbox"
                   id="company_login_bg_upload"
                   name="permissions[]"
                   value="company.login_bg.upload"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="company_login_bg_upload">Upload Company Login BG Image</label>
        </div>

        <div>
            <input type="checkbox"
                   id="software_theme_settings"
                   name="permissions[]"
                   value="software.theme.settings"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="software_theme_settings">Software Theme Settings</label>
        </div>

    </div>
</div>


<br>

<!----------------- BRANCHES -------------------->
<div class="payload-section">

    <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
        <div class="uppercase font-semibold text-lg">Branches</div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        <div>
            <input type="checkbox"
                   id="branch_list"
                   name="permissions[]"
                   value="branch.list"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="branch_list">Branch List</label>
        </div>

        <div>
            <input type="checkbox"
                   id="branch_create"
                   name="permissions[]"
                   value="branch.create"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="branch_create">Add New Branch</label>
        </div>

        <div>
            <input type="checkbox"
                   id="branch_view"
                   name="permissions[]"
                   value="branch.view"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="branch_view">Show Branch Info</label>
        </div>

        <div>
            <input type="checkbox"
                   id="branch_edit"
                   name="permissions[]"
                   value="branch.edit"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="branch_edit">Edit Branch Info</label>
        </div>

        <div>
            <input type="checkbox"
                   id="branch_cash_lock"
                   name="permissions[]"
                   value="branch.cash.lock"
                   class="item-checkbox form-checkbox h-5 w-5 text-primary">
            <label for="branch_cash_lock">Branch Deposit Cash Lock</label>
        </div>

    </div>
</div>


    <br>
    <!----------------- Promoters -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Promoters</div>
          <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-4">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance"
                     name="permissions[show_sms_balance]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Promoters
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Promoter</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Transaction
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                        Transaction</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Delete Promoter
                        Transaction</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Upload Promoter
                        Documents</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Update/ Remove
                        Promoter Documents</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                        Contact Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                        Bank
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Add Promoter's
                        Share
                        Holding Nominees
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Promoter's SMS
                        Enable/ Disable</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Promoter's
                        Money
                        Transfer Enable/ Disable</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Promoter Change
                        KYC
                        Status</label>
                </div>
            </div>
        </div>

    </div>

    <br>
    <!----------------- Minors -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Minors</div>
           <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Add
                        Minor</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Edit
                        Minor</label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Promoters Login Credentials-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Promoters Login Credentials
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Reset Promoter
                        Login
                        Password</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Lock/Unlock
                        Promoter
                        Account</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Reset & Send
                        Promoter Login Credentials via SMS</label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Promoters Share Holdings-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Promoters Share Holdings
            </div>
           <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Promoter Share
                        Holdings</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Allocate New
                        Shares
                        to Promoter's</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                        Share
                        Holding Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Select/ Update
                        Promoter who's Share needs to split for (New Membership
                        Registration)</label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!-----------------Directors-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Directors</div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Directors
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Director</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Show Director
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Edit Director
                        Info</label>
                </div>
            </div>
        </div>

    </div>
    <br>
    <!-----------------Encumbered Deposits-------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Encumbered Deposits</div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Encumbered
                        Deposits
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Encumbered
                        Deposit</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Show Encumbered
                        Deposit Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">Edit Encumbered
                        Deposit Info</label>
                </div>
            </div>

        </div>
    </div>
    <br>
    <!-----------------Bank Accounts-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Bank Accounts</div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Bank Accounts
                        List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Bank
                        Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show Bank
                        Account
                        Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_balance" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Bank
                        Account
                        Info
                    </label>
                </div>
            </div>
        </div>

    </div>

</div>