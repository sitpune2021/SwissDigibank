<div>

    <!-----------------Recurring Deposit Schemes -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Recurring Deposit Schemes</div>
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
                    <input type="checkbox" id="rd_dd_scheme_lis" name="permissions[]" value="rdschemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rd_dd_scheme_lis" class="text-base font-semibold cursor-pointer mb-0">
                        RD / DD Schemes List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_rd_dd_scheme_new" name="permissions[]" value="rdschemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_rd_dd_scheme_new" class="text-base font-semibold cursor-pointer mb-0">
                        Add New RD / DD Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_rd_dd_sch_inf" name="permissions[]" value="rdschemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_rd_dd_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show RD / DD Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_rd_dd_sch_inf" name="permissions[]" value="rdschemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_rd_dd_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Edit RD / DD Scheme Info
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Recurring Deposit Calculator-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Recurring Deposit Calculator
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
                    <input type="checkbox" id="rd_dd_cal" name="permissions[]" value="rd-calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rd_dd_cal" class="text-base font-semibold cursor-pointer mb-0">
                        RD / DD Calculator
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Recurring Deposit Accounts -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Recurring Deposit Accounts
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
                    <input type="checkbox" id="rd_dd_acc_list" name="permissions[]" value="mds-rd-accounts.rd-account-index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rd_dd_acc_list" class="text-base font-semibold cursor-pointer mb-0">
                        RD Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="opn_rd_dd_acc" name="permissions[]" value="mds-rd-accounts.create-rd-account"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="opn_rd_dd_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Open New RD Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_rd_dd_ac_inf" name="permissions[]" value="rd-accounts.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_rd_dd_ac_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show RD Account Info
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
    <!----------------- DD Accounts -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                DD Accounts
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
                    <input type="checkbox" id="rd_dd_acc_list" name="permissions[]" value="dds-accounts.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rd_dd_acc_list" class="text-base font-semibold cursor-pointer mb-0">
                        DD Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="opn_rd_dd_acc" name="permissions[]" value="dds-accounts.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="opn_rd_dd_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Open New DD Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_rd_dd_ac_inf" name="permissions[]" value="dds-accounts.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_rd_dd_ac_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show DD Account Info
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>