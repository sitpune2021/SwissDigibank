<div class="tab-panel hidden">
    <!-----------------Cashfree Settings------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Cashfree Settings</div>
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
                    <input type="checkbox" id="cashfree_ft_col_set" name="permissions[cashfree_ft_col_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cashfree_ft_col_set" class="text-base font-semibold cursor-pointer mb-0">
                       CashFree Fund Transfer/ Auto Collect Settings
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="auto_gen_vir_acc" name="permissions[auto_gen_vir_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="auto_gen_vir_acc" class="text-base font-semibold cursor-pointer mb-0">
                       CashFree Auto Collect Settings - Auto Generate Virtual Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="auto_gen_vir_upi" name="permissions[auto_gen_vir_upi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="auto_gen_vir_upi" class="text-base font-semibold cursor-pointer mb-0">
                       CashFree Auto Collect Settings - Auto Generate Virtual UPI
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_auto_col_com" name="permissions[cf_auto_col_com]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_auto_col_com" class="text-base font-semibold cursor-pointer mb-0">
                        Set CashFree Fund Transfer/ Auto Collect Commission
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!-----------------Cashfree Virtual Accounts------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
               Cashfree Virtual Accounts
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
                    <input type="checkbox" id="cashfree_vir_ac_lis" name="permissions[cashfree_vir_ac_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cashfree_vir_ac_lis" class="text-base font-semibold cursor-pointer mb-0">
                       CashFree Virtual Account List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_cf_va" name="permissions[add_new_cf_va]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_cf_va" class="text-base font-semibold cursor-pointer mb-0">
                     Add New CashFree Virtual Account
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_cf_vaf" name="permissions[shw_cf_vaf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_cf_vaf" class="text-base font-semibold cursor-pointer mb-0">
                     Show CashFree Virtual Account Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_cf_va" name="permissions[edit_cf_va]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_cf_va" class="text-base font-semibold cursor-pointer mb-0">
                    Edit CashFree Virtual Account
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_vir_ac_status" name="permissions[cf_vir_ac_status]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_vir_ac_status" class="text-base font-semibold cursor-pointer mb-0">
                   CashFree Virtual Account Status
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <div class="">
                        <input type="checkbox" id="shw_va_pass" name="permissions[shw_va_pass]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    
                    <label for="shw_va_pass" class="text-base font-semibold cursor-pointer mb-0">
                  CashFree Virtual Account - Show on Passbook / App / Internet Banking
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_va_ru" name="permissions[cf_va_ru]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_va_ru" class="text-base font-semibold cursor-pointer mb-0">
                 CashFree Virtual Account Recent Update
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="send_sms_va" name="permissions[send_sms_va]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="send_sms_va" class="text-base font-semibold cursor-pointer mb-0">
                Send SMS Virtual Account
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-----------------Cashfree Virtual Upis-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
             Cashfree Virtual Upis
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
                    <input type="checkbox" id="cf_upi_list" name="permissions[cf_upi_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_upi_list" class="text-base font-semibold cursor-pointer mb-0">
                        CashFree Virtual UPI List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_cf_vupi" name="permissions[new_cf_vupi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_cf_vupi" class="text-base font-semibold cursor-pointer mb-0">
                      Add New CashFree Virtual UPI
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_cf_upi_info" name="permissions[shw_cf_upi_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_cf_upi_info" class="text-base font-semibold cursor-pointer mb-0">
                   Show CashFree Virtual UPI Info
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_cf_vir_upi" name="permissions[edi_cf_vir_upi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_cf_vir_upi" class="text-base font-semibold cursor-pointer mb-0">
                      Edit CashFree Virtual UPI
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_upi_acc_sta" name="permissions[cf_upi_acc_sta]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_upi_acc_sta" class="text-base font-semibold cursor-pointer mb-0">
                     CashFree UPI Account Status
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_upi" name="permissions[cf_upi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_upi" class="text-base font-semibold cursor-pointer mb-0">
                      CashFree UPI - Show on Passbook / App / Internet Banking
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_upi_qr_code" name="permissions[cf_upi_qr_code]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_upi_qr_code" class="text-base font-semibold cursor-pointer mb-0">
                    CashFree UPI QR Code - Regenerate
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="vir_acc_ru" name="permissions[vir_acc_ru]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="vir_acc_ru" class="text-base font-semibold cursor-pointer mb-0">
                      CashFree Virtual Account Recent Update
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="send_sms_vir_upi" name="permissions[send_sms_vir_upi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="send_sms_vir_upi" class="text-base font-semibold cursor-pointer mb-0">
                      Send SMS Virtual UPI
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>

     <!-----------------Cashfree Fund Transfers------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
              Cashfree Fund Transfers
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
                    <input type="checkbox" id="new_fund_tc" name="permissions[new_fund_tc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_fund_tc" class="text-base font-semibold cursor-pointer mb-0">
                      New Fund Transfer CashFree
                    </label>
                </div>
            </div>

        </div>
    </div>
   

</div>