<div class="tab-panel active">
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

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_email_token" name="permissions[]"
                        value="dashboard.token-balance.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_email_token" class="text-base font-semibold cursor-pointer mb-0">Show Email
                        Token Balance</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_cashfree_wallet_bal"
                        name="permissions[]" value="dashboard.cashfree-wallet-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_cashfree_wallet_bal" class="text-base font-semibold cursor-pointer mb-0">Show
                        CashFree Wallet Balance</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_hypto_bal" name="permissions[]"
                        value="dashboard.wallet.balance" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_hypto_bal" class="text-base font-semibold cursor-pointer mb-0">Show Hypto
                        Wallet Balance</label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_prepaid_bal" name="permissions[]"
                        value="dashboard.prepaid-card-balance.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_prepaid_bal" class="text-base font-semibold cursor-pointer mb-0">
                        Show Happay
                        Prepaid Card Balance
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_debit_bal" name="permissions[]"
                        value="dashboard.debit-card-balance.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_debit_bal" class="text-base font-semibold cursor-pointer mb-0">
                        Show Happay
                        Debit Card Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_debit_card_wallet"
                        name="permissions[]" value="dashboard.debit-card-wallet.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_debit_card_wallet" class="text-base font-semibold cursor-pointer mb-0">
                        Show Happay Debit Card Wallet Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_zro_card_balance" name="permissions[]" value="dashboard.zero-card-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_zro_card_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show Zro Card Balance
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_zro_card_wallet_info" name="permissions[]"
                        value="dashboard.zero-card.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_zro_card_wallet_info" class="text-base font-semibold cursor-pointer mb-0">
                        Show Zro Card Wallet Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_cashyear_card_balance"
                        name="permissions[]" value="dashboard.cashyear-card-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_cashyear_card_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show CashYear Card Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_cashyear_wallet_info" name="permissions[]"
                        value="dashboard.cashyear-wallet.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_cashyear_wallet_info" class="text-base font-semibold cursor-pointer mb-0">
                        Show CashYear Card Wallet Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_fidyPay_balance" name="permissions[]" 
                    value="dashboard.fidypay-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_fidyPay_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show FidyPay Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_busybox_balance" name="permissions[]"
                    value="dashboard.busybox-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_busybox_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show BusyBox Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_ids_pay_balance" name="permissions[]"
                    value="dashboard.ids-pay-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_ids_pay_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show IDS Pay Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_yesbank_balance" name="permissions[]"
                    value="dashboard.yesbank-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_yesbank_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show Yesbank Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_icici_balance" name="permissions[]"
                    value="dashboard.icici-balance.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_icici_balance" class="text-base font-semibold cursor-pointer mb-0">
                        Show ICICI Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_notification_in_header"
                        name="permissions[]" value="dashboard.notification-in-header.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_notification_in_header" class="text-base font-semibold cursor-pointer mb-0">
                        Show Notification Option in Header
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_support_option_header"
                        name="permissions[]" value="dashboard.support-option-in-header.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_support_option_header" class="text-base font-semibold cursor-pointer mb-0">
                        Show Support Option in Header
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_google_play_link" name="permissions[]"
                    value="dashboard.google-play-link.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_google_play_link" class="text-base font-semibold cursor-pointer mb-0">
                        Show Google Play Link on Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_calendar_dashboard" name="permissions[]"
                        value="dashboard.calender-rate.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_calendar_dashboard" class="text-base font-semibold cursor-pointer mb-0">
                        Show Rate Calendar Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_notice_board" name="permissions[]"
                    value="dashboard.notice-board.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_notice_board" class="text-base font-semibold cursor-pointer mb-0">
                        Show Notice Board Dashboard
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_appointments" name="permissions[]"
                        value="dashboard.appointments.view" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_appointments" class="text-base font-semibold cursor-pointer mb-0">
                        Show Appointments on Dashboard
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_show_banners" name="permissions[]"
                    value="dashboard.banner.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_show_banners" class="text-base font-semibold cursor-pointer mb-0">
                        Show Banners on Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_search_member_on" name="permissions[]"
                    value="dashboard.search-member.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_search_member_on" class="text-base font-semibold cursor-pointer mb-0">
                        Show Search Member on Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_loan_dashboard" name="permissions[]"
                    value="dashboard.loan.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_loan_dashboard" class="text-base font-semibold cursor-pointer mb-0">
                        Loan Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_enach_dashboard" name="permissions[]"
                    value="dashboard.enach.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_enach_dashboard" class="text-base font-semibold cursor-pointer mb-0">
                        Enach Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_notification_dashboard"
                        name="permissions[]" value="dashboard.notification.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_notification_dashboard" class="text-base font-semibold cursor-pointer mb-0">
                        Notification Dashboard
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_emi_due_notifi" name="permissions[]"
                    value="dashboard.emi-due-notification.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_emi_due_notifi" class="text-base font-semibold cursor-pointer mb-0">
                        Lender EMI Due Notification
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dash_job_stuck_alert" name="permissions[]" value="dashboard.job-stuck-alert.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dash_job_stuck_alert" class="text-base font-semibold cursor-pointer mb-0">
                        Show Background Job Stuck Alert
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>