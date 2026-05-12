<div>

    <!----------------- PROFILE -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Profile</div>
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
                    <input type="checkbox" id="show_company_profile" name="permissions[]" value="company.index"
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="show_company_profile" class="text-base font-semibold cursor-pointer mb-0">Show Company
                        Profile</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_company_profile" name="permissions[]" value="company.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_company_profile" class="text-base font-semibold cursor-pointer mb-0">Edit Company
                        Profile</label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Branches -------------------->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Branches</div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox"
                        id="check_all_branch"
                        class="check-all form-checkbox h-5 w-5 text-primary">

                    <label for="check_all_branch"
                        class="text-base font-semibold cursor-pointer mb-0">

                        Check All

                    </label>

                </div>
            </div>
            
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            {{-- BRANCH LIST --}}
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox"
                        id="branch_list"
                        name="permissions[]"
                        value="branch.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="branch_list"
                        class="text-base font-semibold cursor-pointer mb-0">

                        Branch List

                    </label>

                </div>
            </div>

            {{-- ADD BRANCH --}}
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox"
                        id="branch_create"
                        name="permissions[]"
                        value="branch.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="branch_create"
                        class="text-base font-semibold cursor-pointer mb-0">

                        Add New Branch

                    </label>

                </div>
            </div>

            {{-- SHOW BRANCH --}}
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox"
                        id="branch_show"
                        name="permissions[]"
                        value="branch.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="branch_show"
                        class="text-base font-semibold cursor-pointer mb-0">

                        Show Branch Info

                    </label>

                </div>
            </div>

            {{-- EDIT BRANCH --}}
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox"
                        id="branch_edit"
                        name="permissions[]"
                        value="branch.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="branch_edit"
                        class="text-base font-semibold cursor-pointer mb-0">

                        Edit Branch Info

                    </label>

                </div>
            </div>

            {{-- DELETE BRANCH --}}
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox"
                        id="branch_delete"
                        name="permissions[]"
                        value="branch.delete"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="branch_delete"
                        class="text-base font-semibold cursor-pointer mb-0">

                        Delete Branch Info

                    </label>

                </div>
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
                    <input type="checkbox" id="promotor_list"
                     name="permissions[]" value="promotor.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="promotor_list" class="text-base font-semibold cursor-pointer mb-0">Promoters
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="promotor_create" name="permissions[]" value="promotor.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="promotor_create" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Promoter</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="promotor_show" name="permissions[]" value="promotor.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="promotor_show" class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="promotor_edit" name="permissions[]" value="promotor.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="promotor_edit" class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="promotor_delete" name="permissions[]" value="promotor.delete"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="promotor_delete" class="text-base font-semibold cursor-pointer mb-0">Delete Promoter
                        Transaction</label>
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
                    <input type="checkbox" id="shareholding_index" name="permissions[]" value="shareholding.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shareholding_index" class="text-base font-semibold cursor-pointer mb-0">Promoter Share
                        Holdings</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shareholding_create" name="permissions[]" value="shareholding.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shareholding_create" class="text-base font-semibold cursor-pointer mb-0">Allocate New
                        Shares
                        to Promoter's</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shareholding_show" name="permissions[]" value="shareholding.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shareholding_show" class="text-base font-semibold cursor-pointer mb-0">Show Promoter
                        Share
                        Holding Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shareholding_edit" name="permissions[]" value="shareholding.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shareholding_edit" class="text-base font-semibold cursor-pointer mb-0">Edit Promoter
                        Share
                        Holding Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shareholding_transfer" name="permissions[]" value="shareholding.transfer"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shareholding_transfer" class="text-base font-semibold cursor-pointer mb-0">Select/ Update
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
                    <input type="checkbox" id="director_index" name="permissions[]" value="director.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="director_index" class="text-base font-semibold cursor-pointer mb-0">Directors
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="director_create" name="permissions[]" value="director.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="director_create" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Director</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="director_show" name="permissions[]" value="director.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="director_show" class="text-base font-semibold cursor-pointer mb-0">Show Director
                        Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="director_edit" name="permissions[]" value="director.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="director_edit" class="text-base font-semibold cursor-pointer mb-0">Edit Director
                        Info</label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!-----------------Encumbered Deposits-------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Unencumbered Deposits</div>
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
                    <input type="checkbox" id="unencumbered_deposits_index" name="permissions[]" value="unencumbered-deposits.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unencumbered_deposits_index" class="text-base font-semibold cursor-pointer mb-0">Encumbered
                        Deposits
                        List</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="unencumbered_deposits_create" name="permissions[]" value="unencumbered-deposits.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unencumbered_deposits_create" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Encumbered
                        Deposit</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="unencumbered_deposits_show" name="permissions[]" value="unencumbered-deposits.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unencumbered_deposits_show" class="text-base font-semibold cursor-pointer mb-0">Show Encumbered
                        Deposit Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="unencumbered_deposits_edit" name="permissions[]" value="unencumbered-deposits.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unencumbered_deposits_edit" class="text-base font-semibold cursor-pointer mb-0">Edit Encumbered
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
                    <input type="checkbox" id="bank_account_index" name="permissions[]" value="bank-account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="bank_account_index" class="text-base font-semibold cursor-pointer mb-0">
                        Bank Accounts
                        List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="bank_account_create" name="permissions[]" value="bank-account.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="bank_account_create" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Bank
                        Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="bank_account_show" name="permissions[]" value="bank-account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="bank_account_edit" class="text-base font-semibold cursor-pointer mb-0">
                        Show Bank
                        Account
                        Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="bank_account_edit" name="permissions[]" value="bank-account.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="bank_account_edit" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Bank
                        Account
                        Info
                    </label>
                </div>
            </div>

        </div>
    </div>

</div>