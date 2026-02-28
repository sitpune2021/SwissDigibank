<div class="tab-panel hidden">

<!----------------- Business Loan Schemes --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Business Loan Schemes</div>
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
                    <input type="checkbox" id="oth_lon_sch_lis"
                     name="permissions[]" value="bussiness.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="oth_lon_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                  Business Loan Schemes List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_oth_lon_sch" 
                    name="permissions[]" value="bussiness.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.schemes.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="add_new_oth_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                   New Business Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_oth_lon_sch" name="permissions[]" value="bussiness.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.schemes.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_oth_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                  Show Business Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_oth_lon_sch" 
                    name="permissions[]" value="bussiness.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.schemes.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_oth_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                   Edit Business Loan Scheme
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Business Loan Calculator --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Business Loan Calculator</div>
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
                    <input type="checkbox" id="oth_lon_calc" name="permissions[]" value="bussiness.calculator.calculation"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.calculator.calculation', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="oth_lon_calc" class="text-base font-semibold cursor-pointer mb-0">
                      Business Loan Calculator
                    </label>
                </div>
            </div>          

        </div>
    </div>

    <br>
<!----------------- Business Loan Applications--------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
              Business Loan Applications
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
                    <input type="checkbox" id="oth_lon_app_lis" name="permissions[]" value="bussiness.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="oth_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
                Business Loan Applications List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_oth_ln_app" name="permissions[]" value="bussiness.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.applications.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="new_oth_ln_app" class="text-base font-semibold cursor-pointer mb-0">
                    New Business Loan Applications
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_oth_ln_app" name="permissions[]" value="bussiness.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.applications.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_oth_ln_app" class="text-base font-semibold cursor-pointer mb-0">
                  Show Business Loan Application
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_oth_lon_app" name="permissions[]" value="bussiness.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.applications.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edi_oth_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                Edit Business Loan Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_oth_lon_app" name="permissions[]" value="bussiness.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rem_oth_lon_app" class="text-base font-semibold cursor-pointer mb-0">
               Remove Business Loan Application
                    </label>
                </div>
            </div>

        </div>

    </div>

    <br>
    <!----------------- Business Loan Disbursements -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
              Other Loan Disbursements
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary"
                        {{ in_array('loanagainst.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
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
                    <input type="checkbox" id="oth_lon_dis_lis" name="permissions[]" value="bussiness.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.disbursements.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="oth_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                   Business Loan Disbursements List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_oth_lon" name="permissions[]" value="bussiness.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.disbursements.disburse-loan', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="dis_oth_lon" class="text-base font-semibold cursor-pointer mb-0">
                   Disburse Business Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_oth_lon" name="permissions[]" value="businessdisbursements.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('businessdisbursements.cancel', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="can_oth_lon" class="text-base font-semibold cursor-pointer mb-0">
                  Cancel Business Loan
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Business Loan Accounts --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Business Loan Accounts</div>
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
                    <input type="checkbox" id="oth_lon_acc_lis" 
                    name="permissions[]" value="bussiness.account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.account.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="oth_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
              Business Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_oth_lon_acc" name="permissions[]" value="bussiness.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.account.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_oth_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                Show Business Loan Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_oth_lon_acc" 
                    name="permissions[]" value="bussiness.remove"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('bussiness.remove', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rm_oth_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                  Remove Business Loan Account
                    </label>
                </div>
            </div>

       </div>
    </div>

</div>