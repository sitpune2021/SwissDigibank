<div class="tab-panel hidden">
    <!----------------Personal Loan Schemes------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Personal Loan Schemes
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
                    <input type="checkbox" id="per_loan_sch_list" name="permissions[]" value="personal.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.schemes.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="per_loan_sch_list" class="text-base font-semibold cursor-pointer mb-0">
                        Personal Loan Schemes List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_personal_loan_sch" name="permissions[]" value="personal.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.schemes.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="new_personal_loan_sch" class="text-base font-semibold cursor-pointer mb-0">
                        New Personal Loan Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_per_loan_sch" name="permissions[]" value="personal.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.schemes.show', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_per_loan_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Show Personal Loan Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_per_loan_sch" name="permissions[]" value="personal.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.schemes.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_per_loan_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Personal Loan Scheme
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!---------------Personal Loan Calculator------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Personal Loan Calculator
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
                    <input type="checkbox" id="per_loan_calc" name="permissions[]" value="personal.calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.calculator.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="per_loan_calc" class="text-base font-semibold cursor-pointer mb-0">
                        Personal Loan Calculator
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------Personal Loan Applications------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Personal Loan Applications
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
                    <input type="checkbox" id="per_lon_app_lis" name="permissions[]" value="personal.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="per_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Personal Loan Applications List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_per_loan_app" name="permissions[]" value="personal.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.applications.create', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="new_per_loan_app" class="text-base font-semibold cursor-pointer mb-0">
                        New Personal Loan Applications
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_per_lon_app" name="permissions[]" value="personal.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.applications.view', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="shw_per_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Show Personal Loan Application
                    </label>
                </div>
            </div>
            
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_per_loan_app" name="permissions[]" value="personal.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.applications.edit', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="edit_per_loan_app" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Personal Loan Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_personal_loan_app" name="permissions[]" value="personal.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.applications.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="rem_personal_loan_app" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Personal Loan Application
                    </label>
                </div>
            </div>
            
        </div>
    </div>
    <br>
    <!----------------Personal Loan Disbursements------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Personal Loan Disbursements
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
                    <input type="checkbox" id="per_ld_lis" name="permissions[]" value="personal.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.disbursements.index', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="per_ld_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Personal Loan Disbursements List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_per_loan" name="permissions[]" value="personal.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.disbursements.disburse-loan', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="dis_per_loan" class="text-base font-semibold cursor-pointer mb-0">
                        Disburse Personal Loan
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_personal_loan" name="permissions[]" value="personal.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary"
                        {{ in_array('personal.cancel', $selectedPermissions ?? []) ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}>
                    <label for="can_personal_loan" class="text-base font-semibold cursor-pointer mb-0">
                        Cancel Personal Loan
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>

    @php
    $perLoanAcc = [
    ['key' => 'personal.account.index', 'label' => 'Personal Loan Accounts List'],
    ['key' =>
    'personal.account.show', 'label' => 'Show Personal Loan Account'],
    ['key' =>
    'personal.remove', 'label' => 'Remove Personal Loan Account'],
    ];
    @endphp

    <!----Personal Loan Accounts----->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Personal Loan Accounts</div>
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

            @foreach ($perLoanAcc as $perm)
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