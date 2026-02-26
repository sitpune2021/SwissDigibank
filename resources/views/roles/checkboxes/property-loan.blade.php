<div id="property-loan" class="tab-panel hidden">

<!----------------- Property Loan Schemes --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Property Loan Schemes</div>
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
                    <input type="checkbox" id="pl_sch_lis"
                     name="permissions[]" value="mortgage.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="pl_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                     Property Loan Scheme List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_pro_lon_sch" 
                    name="permissions[]" value="mortgage.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.schemes.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="add_new_pro_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                     Add New Property Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_pro_lon_sch_inf" name="permissions[]" value="mortgage.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.schemes.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_pro_lon_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                    Show Property Loan Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_pro_lon_sch" 
                    name="permissions[]" value="mortgage.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.schemes.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_pro_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                      Edit Property Loan Scheme
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!-----------------Property Loan Calculator --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Property Loan Calculator</div>
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
                    <input type="checkbox" id="pro_lon_calc" name="permissions[]" value="mortgage.calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.calculator.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="pro_lon_calc" class="text-base font-semibold cursor-pointer mb-0">
                      Property Loan Calculator
                    </label>
                </div>
            </div>          

        </div>
    </div>

    <br>
<!----------------- Property Loan Applications --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Property Loan Applications
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
                    <input type="checkbox" id="pro_lon_app_lis" name="permissions[]" value="mortgage.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="pro_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
                  Property Loan Applications List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="op_new_pro_lon_app" name="permissions[]" value="mortgage.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.applications.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="op_new_pro_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                     Open New Property Loan Application
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_pro_app_inf" name="permissions[]" value="mortgage.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.applications.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_pro_app_inf" class="text-base font-semibold cursor-pointer mb-0">
                    Show Property Loan Application Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_pro_lon_app_apr" name="permissions[]" value="mortgage.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.applications.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edi_pro_lon_app_apr" class="text-base font-semibold cursor-pointer mb-0">
                  Edit Property Loan Application Info before Application is 'APPROVED'
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_pro_lon_app" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.calculator.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rem_pro_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                 Remove Property Loan Application
                    </label>
                </div>
            </div>

        </div>

    </div>

    <br>
<!-----------------Property Loan Items-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Property Loan Items</div>
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
                    <input type="checkbox" id="pro_itm_rep" name="permissions[]" value="mortgage.lineproperty.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.lineproperty.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="pro_itm_rep" class="text-base font-semibold cursor-pointer mb-0">
                  Property Loan Items Report
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
<!----------------- Property Loan Disbursements -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Property Loan Disbursements
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
                    <input type="checkbox" id="pro_lon_dis_lis" name="permissions[]" value="mortgage.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.disbursements.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="pro_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                    Property Loan Disbursements List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_rel_pro_lon" name="permissions[]" value="mortgage.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.disbursements.disburse-loan', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="dis_rel_pro_lon" class="text-base font-semibold cursor-pointer mb-0">
                      Disburse / Release Property Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_pro_lon_dis" name="permissions[]" value="mortgagedisbursements.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgagedisbursements.cancel', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="can_pro_lon_dis" class="text-base font-semibold cursor-pointer mb-0">
                    Cancel Property Loan
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
<!----------------- Property Loan Accounts --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Property Loan Accounts</div>
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
                    <input type="checkbox" id="pro_lon_acc_lis" 
                    name="permissions[]" value="mortgage.account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.account.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="pro_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
                   Property Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_pro_lon_acc" name="permissions[]" value="mortgage.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.account.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_pro_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                  Show Property Account Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_pro_lon_acc" 
                    name="permissions[]" value="mortgage.remove"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('mortgage.remove', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rm_pro_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                    Remove Property Loan Account
                    </label>
                </div>
            </div>

       </div>
    </div>
    
</div>