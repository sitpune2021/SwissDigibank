<div id="gold-loan" class="tab-panel">
    
    <!----------------- Gold Loan Schemes -------------------->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Gold Loan Schemes</div> 
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
                    <input type="checkbox"
                        id="gl_lon_sch"
                        name="permissions[]"
                        value="gold-loan.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="gl_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Scheme List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_gol_sch"
                        name="permissions[]" 
                        value="gold-loan.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.schemes.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="add_new_gol_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Gold Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_gol_lon_sch_inf" 
                    name="permissions[]" 
                    value="gold-loan.schemes.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.schemes.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_gol_lon_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Gold Loan Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_gol_lon_sch"
                        name="permissions[]" value="gold-loan.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.schemes.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_gol_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Gold Loan Scheme
                    </label>
                </div>
            </div>

        </div>

    </div>
        
    <!----------------- Gold Loan Calculator -------------------->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Gold Loan Calculator</div>
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
                    <input type="checkbox" id="gol_loan_calc" name="permissions[]" value="gold-loan.calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.calculator.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="gol_loan_calc" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Calculator
                    </label>
                </div>
            </div>
        </div>

    </div>

    <br>
    <!----------------- Gold Loan Applications -------------------->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Gold Loan Applications</div>
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
                    <input type="checkbox" id="gol_lon_app_lis" name="permissions[]" value="gold-loan.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="gol_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Applications List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="op_new_gol_lon_app" name="permissions[]" value="gold-loan.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.applications.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="op_new_gol_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Open New Gold Loan Application
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_gol_app_inf" name="permissions[]" value="gold-loan.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.applications.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_gol_app_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Gold Loan Application Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_gol_lon_app_apr" name="permissions[]" value="gold-loan.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.applications.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edi_gol_lon_app_apr" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Gold Loan Application Info before Application is 'APPROVED'
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_gol_lon_app" name="permissions[]" value="gold-loan.application.delete-application"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.application.delete-application', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rem_gol_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Gold Loan Application
                    </label>
                </div>
            </div>
           
        </div>

    </div>

    <br>
    <!----------------- Gold Items -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Gold Items</div>
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
                    <input type="checkbox" id="gol_orn_inv" name="permissions[]" value="gold-loan.ornaments.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.ornaments.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="gol_orn_inv" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Ornaments Inventory
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_gol_orn_sta" name="permissions[]" value="gold-loan.ornaments.update"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.ornaments.update', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="up_gol_orn_sta" class="text-base font-semibold cursor-pointer mb-0">
                        Update Gold Ornaments Status
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Gold Loan Disbursements -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Gold Loan Disbursements</div>
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
                    <input type="checkbox" id="gol_lon_dis_lis" name="permissions[]" value="gold-loan.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.disbursements.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="gol_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Disbursements List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_rel_gol_lon" name="permissions[]" value="gold-loan.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.disbursements.disburse-loan', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="dis_rel_gol_lon" class="text-base font-semibold cursor-pointer mb-0">
                        Disburse / Release Gold Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_gol_lon_dis" name="permissions[]" value="golddisbursements.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('golddisbursements.cancel', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="can_gol_lon_dis" class="text-base font-semibold cursor-pointer mb-0">
                        Cancel Gold Loan Disbursement
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------- Gold Loan Accounts -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Gold Loan Accounts</div>
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
                    <input type="checkbox" id="gl_lon_acc_lis"
                        name="permissions[]" value="gold-loan.account.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.account.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="gl_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_gol_lon_acc" name="permissions[]" value="gold-loan.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('gold-loan.account.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_gol_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Show Gold Loan Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_gol_lon_acc" name="permissions[]" value="goldloan.remove"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('goldloan.remove', $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rm_gol_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Gold Loan Account
                    </label>
                </div>
            </div>

        </div>
    </div>
    
</div>