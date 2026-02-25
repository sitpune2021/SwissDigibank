<div class="tab-panel hidden">

    <!----------------Cc Limit Schemes------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Cc Limit Schemes
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
                    <input type="checkbox" id="cc_lim_sch_lis" name="permissions[]" value="cc_od.schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cc_lim_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                        CC Limit Schemes List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="nw_cc_limit_sch" name="permissions[]" value="cc_od.schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="nw_cc_limit_sch" class="text-base font-semibold cursor-pointer mb-0">
                        New CC Limit Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_cc_limit_sch" name="permissions[]" value="cc_od.schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_cc_limit_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Show CC Limit Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_cc_limit_sch" name="permissions[]" value="cc_od.schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_cc_limit_sch" class="text-base font-semibold cursor-pointer mb-0">
                        Edit CC Limit Scheme
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!----------------Cc Limit Applicationss------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Cc Limit Applications
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
                    <input type="checkbox" id="cc_app_list" name="permissions[]" value="cc_od.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cc_app_list" class="text-base font-semibold cursor-pointer mb-0">
                        CC Limit Applications List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_cc_lim_app" name="permissions[]" value="cc_od.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_cc_lim_app" class="text-base font-semibold cursor-pointer mb-0">
                        New CC Limit Applications
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_cc_lim_app" name="permissions[]" value="cc_od.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_cc_lim_app" class="text-base font-semibold cursor-pointer mb-0">
                        Show CC Limit Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_cc_lim_app" name="permissions[]" value="cc_od.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_cc_lim_app" class="text-base font-semibold cursor-pointer mb-0">
                        Edit CC Limit Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rmv_cc_lim_app" name="permissions[]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rmv_cc_lim_app" class="text-base font-semibold cursor-pointer mb-0">
                        Remove CC Limit Application
                    </label>
                </div>
            </div>
              
        </div>
    </div>

    <br>
    <!----------------Cc Limit Disbursements------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Cc Limit Disbursements
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
                    <input type="checkbox" id="cc_lim_dl" name="permissions[]" value="cc_od.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cc_lim_dl" class="text-base font-semibold cursor-pointer mb-0">
                        CC Limit Disbursements List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_cc_lim" name="permissions[]" value="cc_od.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_cc_lim" class="text-base font-semibold cursor-pointer mb-0">
                        Disburse CC Limit
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_cc_limit" name="permissions[]" value="cc_od.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="can_cc_limit" class="text-base font-semibold cursor-pointer mb-0">
                        Cancel CC Limit
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>

    @php

    $ccLimitAcc=[
    ['key' => 'cc_od.account.index', 'label' => 'CC Limit Accounts List'],
    ['key' => 'cc_od.account.show', 'label' => 'Show CC Limit Account'],
    ['key' => 'cc_od.remove', 'label' => 'Remove CC Limit Account'],
    ];

    @endphp

    <!---Cc Limit Accounts----->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Cc Limit Accounts</div>
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

            @foreach ($ccLimitAcc as $perm)
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox" id="permission_{{ $perm['key'] }}" name="permissions[]"
                        value="{{ $perm['key'] }}" class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="permission_{{ $perm['key'] }}" class="text-base font-semibold cursor-pointer mb-0">
                        {{ $perm['label'] }}
                    </label>

                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>