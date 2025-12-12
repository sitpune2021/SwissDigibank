<div class="tab-panel hidden collection-center">
    <!-----------------Notifications-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Notifications</div>
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
                    <input type="checkbox" id="shw_pay_rl_frm" name="permissions[shw_pay_rl_frm]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_pay_rl_frm" class="text-base font-semibold cursor-pointer mb-0">
                        Show Payments to Release List (FD/ RD Maturity)
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="clr_nof_pp"
                     name="permissions[clr_nof_pp]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="clr_nof_pp" class="text-base font-semibold cursor-pointer mb-0">
                        Clear Notifications for Pending Payment
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ptr_xls_dow" name="permissions[ptr_xls_dow]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ptr_xls_dow" class="text-base font-semibold cursor-pointer mb-0">
                        Payments to Release - XLS Download
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-----------------Pending Payments History-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Pending Payments History
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
                    <input type="checkbox" id="ptr_his" name="permissions[ptr_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ptr_his" class="text-base font-semibold cursor-pointer mb-0">
                        Payments to Release - History
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>