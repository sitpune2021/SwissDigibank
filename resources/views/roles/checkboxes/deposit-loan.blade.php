<div class="tab-panel hidden">

    <!----------------- Deposit Loan Schemes -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Deposit Loan Schemes</div>
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
                    <input type="checkbox" id="dep_lon_sch_lis" name="permissions[]" value="loanagainst.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_lon_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Deposit Loan Schemes List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_dep_lon_sch" name="permissions[]" value="loanagainst.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_dep_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Deposit Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_dep_lon_sch" name="permissions[]" value="loanagainst.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_dep_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Show Deposit Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_dep_lon_sch" name="permissions[]" value="loanagainst.schemes.edit"
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="edit_dep_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Deposit Loan Scheme
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
    <!-----------------Deposit Loan Calculator -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Deposit Loan Calculator</div>
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
                    <input type="checkbox" id="dep_lon_calc" name="permissions[]" value="loanagainst.calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_lon_calc" class="text-base font-semibold cursor-pointer mb-0">
                        Deposit Loan Calculator
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
    <!----------------- Deposit Loan Applications -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Deposit Loan Applications
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

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-4">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dep_lon_app_lis" name="permissions[]" value="loanagainst.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Deposit Loan Application List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="op_new_dep_lon_app" name="permissions[]" value="loanagainst.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="op_new_dep_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Open New Deposit Loan Application
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_dep_app_inf" name="permissions[]" value="loanagainst.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_dep_app_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Deposit Loan Application Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_dep_lon_app_apr" name="permissions[]" value="loanagainst.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_dep_lon_app_apr" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Deposit Loan Application Info before Application is 'APPROVED'
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_dep_lon_app" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_dep_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Deposit Loan Application
                    </label>
                </div>
            </div>

        </div>

    </div>

    <br>
    <!-----------------Deposit Items-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Deposit Items</div>
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
                    <input type="checkbox" id="dep_lien_rep" name="permissions[]" value="loanagainst.lineproperty.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_lien_rep" class="text-base font-semibold cursor-pointer mb-0">
                        Lien Accounts Report
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Deposit Loan Disbursements -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Deposit Loan Disbursements
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
                    <input type="checkbox" id="dep_lon_dis_lis" name="permissions[]" value="loanagainst.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Deposit Loan Disbursement List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_rel_dep_lon" name="permissions[]" value="loanagainst.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_rel_dep_lon" class="text-base font-semibold cursor-pointer mb-0">
                        Disburse / Release Deposit Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_dep_lon_dis" name="permissions[]" value="disbursements.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="can_dep_lon_dis" class="text-base font-semibold cursor-pointer mb-0">
                        Cancel Deposit Loan
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Deposit Loan Accounts -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Deposit Loan Accounts</div>
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
                    <input type="checkbox" id="dep_lon_acc_lis" name="permissions[]" value="loanagainst.account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Deposit Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_dep_lon_acc" name="permissions[]" value="loanagainst.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_dep_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Show Deposit Loan Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_dep_lon_acc" name="permissions[]" value="loanagainst.remove"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rm_dep_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Deposit Loan Account
                    </label>
                </div>
            </div>

        </div>
    </div>

</div>