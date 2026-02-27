<div class="tab-panel hidden">

<!-----------------Fixed Loan Schemes --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Loan Schemes</div>
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
                    <input type="checkbox" id="fixed_scheme"
                     name="permissions[]" value="fixed_loan.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="fixed_scheme" class="text-base font-semibold cursor-pointer mb-0">
                 Fixed Loan Scheme List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_fixed_scheme" 
                    name="permissions[]" value="fixed_loan.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.schemes.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="new_fixed_scheme" class="text-base font-semibold cursor-pointer mb-0">
                  Add New Fixed Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fl_sch_info" name="permissions[]" value="fixed_loan.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.schemes.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_fl_sch_info" class="text-base font-semibold cursor-pointer mb-0">
                 Show Fixed Loan Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_fl_lon_sch" 
                    name="permissions[]" value="fixed_loan.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.schemes.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_fl_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                  Edit Fixed Loan Scheme
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Fixed Loan Applications --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Fixed Loan Applications
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
                    <input type="checkbox" id="fix_lon_app_lis" name="permissions[]" value="fixed_loan.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="fix_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
              Fixed Loan Applications List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_fix_ln_app" name="permissions[]" value="fixed_loan.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.applications.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="new_fix_ln_app" class="text-base font-semibold cursor-pointer mb-0">
                  New fixed Loan Applications
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fix_ln_app" name="permissions[]" value="fixed_loan.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.applications.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_fix_ln_app" class="text-base font-semibold cursor-pointer mb-0">
                  Show Fixed Loan Application
                    </label>
                </div>
            </div>
            
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_fix_lon_app" name="permissions[]" value="fixed_loan.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.applications.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edi_fix_lon_app" class="text-base font-semibold cursor-pointer mb-0">
               Edit Fixed Loan Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_fix_lon_app" name="permissions[]" value="fixed_loan.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rem_fix_lon_app" class="text-base font-semibold cursor-pointer mb-0">
               Remove Fixed Loan Application
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Fixed Loan Disbursements-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Fixed Loan Disbursements
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
                    <input type="checkbox" id="fix_lon_dis_lis" name="permissions[]" value="fixed_loan.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.disbursements.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="fix_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                 Fixed Loan Disbursements List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_oth_lon" name="permissions[]" value="fixed_loan.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.disbursements.disburse-loan', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="dis_fix_lon" class="text-base font-semibold cursor-pointer mb-0">
                 Disburse Fixed Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_fix_lon" name="permissions[]" value="fixed_loan.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.cancel', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="can_fix_lon" class="text-base font-semibold cursor-pointer mb-0">
                Cancel Fixed Loan
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
<!-----------------Fixed Loan Accounts--------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Loan Accounts</div>
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
                    <input type="checkbox" id="fix_lon_acc_lis" 
                    name="permissions[]" value="fixed_loan.account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.account.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="fix_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
             Fixed Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fix_lon_acc" name="permissions[]" value="fixed_loan.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.account.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_fix_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
              Show Fixed Loan Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_fix_lon_acc" 
                    name="permissions[]" value="fixed_loan.account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('fixed_loan.account.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rm_fix_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                Remove Fixed Loan Account
                    </label>
                </div>
            </div>

       </div>
    </div>

</div>