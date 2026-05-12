<div>
    
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Dashboard Settings</div>
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
                    <input type="checkbox" id="show_sms_bal" name="permissions[dash_show_sms_bal]" value="show_sms_bal"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance_1" class="text-base font-semibold cursor-pointer mb-0">Show SMS
                        Balance</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sms_wallet" name="permissions[]"
                        value="dashboard.sms-wallet.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sms_balance_1" class="text-base font-semibold cursor-pointer mb-0">Show SMS
                        Wallet Info</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_activate_sms" name="permissions[]"
                        value="dashboard.sms-service.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_activate_sms" class="text-base font-semibold cursor-pointer mb-0">Activate
                        SMS Service</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_mob_recharge" name="permissions[]"
                        value="dashboard.recharge-balance.view" class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_mob_recharge" class="text-base font-semibold cursor-pointer mb-0">Show Mobile
                        Recharge Balance</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_generate_mob_bill" name="permissions[]"
                        value="dashboard.mob-bill-payment-wallet.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_generate_mob_bill" class="text-base font-semibold cursor-pointer mb-0">Generate
                        Mobile / Bill Payment Wallet</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_verification_bal"
                        name="permissions[]" value="dashboard.verification-suite-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_verification_bal" class="text-base font-semibold cursor-pointer mb-0">Show
                        Verification Suite Balance</label>
                </div>
            </div>

        </div>

    </div>

</div>