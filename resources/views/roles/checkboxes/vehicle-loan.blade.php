<div class="tab-panel hidden">

    <!----------------Vehicle Loan Distributors------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Vehicle Loan Distributors
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
                    <input type="checkbox" id="veh_dist_list" name="permissions[]" value="vehical.distributors.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.distributors.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="veh_dist_list" class="text-base font-semibold cursor-pointer mb-0">
                        Vehicle Distributors List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_veh_dist" name="permissions[]" value="vehical.distributors.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.distributors.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="add_new_veh_dist" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Vehicle Distributor
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_veh_dist" name="permissions[]" value="distributors.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('distributors.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_veh_dist" class="text-base font-semibold cursor-pointer mb-0">
                        Show Vehicle Distributor
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_veh_dist" name="permissions[]" value="edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_veh_dist" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Vehicle Distributor
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------Vehicle Loan Schemes------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Vehicle Loan Schemes
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
                    <input type="checkbox" id="veh_loan_sch_lis" name="permissions[]" value="vehical.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="veh_loan_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Vehicle Loan Scheme List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_vlsch" name="permissions[]" value="vehical.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.schemes.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="add_new_vlsch" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Vehicle Loan Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_veh_loan_sch_inf" name="permissions[]" value="vehical.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.schemes.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_veh_loan_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Vehicle Loan Scheme Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_veh_loan_sch" name="permissions[]" value="vehical.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.schemes.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_veh_loan_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Vehicle Loan Scheme
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------Vehicle Loan Calculator------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Vehicle Loan Calculator
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
                    <input type="checkbox" id="veh_loan_calc" name="permissions[]" value="vehical.calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.calculator.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="veh_loan_calc" class="text-base font-semibold cursor-pointer mb-0">
                        Vehicle Loan Calculator
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------Vehicle Loan Applications------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Vehicle Loan Applications
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
                    <input type="checkbox" id="veh_loan_app_list" name="permissions[]" value="vehical.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="veh_loan_app_list" class="text-base font-semibold cursor-pointer mb-0">
                        Vehicle Loan Applications List
                    </label>
                </div>
            </div>
            
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="opn_new_veh_lon_app" name="permissions[]" value="vehical.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.applications.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="opn_new_veh_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Open New Vehicle Loan Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_vla_inf" name="permissions[]" value="vehical.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.applications.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_vla_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Vehicle Loan Application Info
                    </label>
                </div>
            </div>
            
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <div class="">
                        <input type="checkbox" id="shw_vla_inf" name="permissions[]" value="vehical.applications.edit"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary"
                            {{ in_array('vehical.applications.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}></div>
                        <label for="shw_vla_inf" class="text-base font-semibold cursor-pointer mb-0">
                            Edit Vehicle Loan Application Info before Application is 'APPROVED'
                        </label>
                    
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_veh_loan_app" name="permissions[]" value="vehical.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rm_veh_loan_app" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Vehicle Loan Application
                    </label>
                </div>
            </div>
            
        </div>
    </div>

    <br>
    <!--------------Vehicle Loan Disbursements------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Vehicle Loan Disbursements
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
                    <input type="checkbox" id="veh_lon_dis_list" name="permissions[]" value="vehical.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.disbursements.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="veh_lon_dis_list" class="text-base font-semibold cursor-pointer mb-0">
                        Vehicle Loan Disbursements List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_rel_veh_loan" name="permissions[]" value="vehical.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('vehical.disbursements.disburse-loan', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="dis_rel_veh_loan" class="text-base font-semibold cursor-pointer mb-0">
                        Disburse/ Release Vehicle Loan
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_veh_loan" name="permissions[]" value="vehicaldisbursements.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="can_veh_loan" class="text-base font-semibold cursor-pointer mb-0">
                        Cancel Vehicle Loan
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>

    @php
    $vehLoanAcc = [
    ['key' => 'vehical.account.index', 'label' => 'Vehicle Loan Accounts List'],
    ['key' =>
    'vehical.account.show', 'label' => 'Show Vehicle Account Loan'],
    ['key' =>
    'vehical.remove', 'label' => 'Remove Vehicle Loan Account'],
    ];
    @endphp

    <!----Vehicle Loan Accounts----->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Vehicle Loan Accounts</div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all  form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            @foreach ($vehLoanAcc as $perm)
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox" id="permission_{{ $perm['key'] }}" name="permissions[]"
                        value="{{ $perm['key'] }}" class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array($perm['key'], $selectedPermissions ?? []) ? 'checked' : '' }}
                        {{ ($readOnly ?? false) ? 'disabled' : '' }}>

                    <label for="permission_{{ $perm['key'] }}" class="text-base font-semibold cursor-pointer mb-0">
                        {{ $perm['label'] }}
                    </label>

                </div>
            </div>
            @endforeach

        </div>
    </div>
    
</div>