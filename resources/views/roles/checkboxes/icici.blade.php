<div class="tab-panel hidden">
    <!-----------------Icici Settings------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Icici Settings</div>
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
                    <input type="checkbox" id="ic_payout_col_set" name="permissions[ic_payout_col_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_payout_col_set" class="text-base font-semibold cursor-pointer mb-0">
                       ICICI Payout / Collection Settings
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="set_ic_pay_comm" name="permissions[set_ic_pay_comm]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="set_ic_pay_comm" class="text-base font-semibold cursor-pointer mb-0">
                      Set ICICI Payout / Collection Commission
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_auto_coll_set" name="permissions[ic_auto_coll_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_auto_coll_set" class="text-base font-semibold cursor-pointer mb-0">
                       ICICI Auto Collect Settings - Auto Generate Virtual Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ag_vupi" name="permissions[ag_vupi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ag_vupi" class="text-base font-semibold cursor-pointer mb-0">
                       ICICI Auto Collect Settings - Auto Generate Virtual UPI
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_auto_col_set" name="permissions[ic_auto_col_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_auto_col_set" class="text-base font-semibold cursor-pointer mb-0">
                     ICICI Auto Collect Settings - Auto Generate Static QR
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-----------------Icici Virtual Accounts------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
             Icici Virtual Accounts
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
                    <input type="checkbox" id="ic_vir_al" name="permissions[ic_vir_al]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_vir_al" class="text-base font-semibold cursor-pointer mb-0">
                       ICICI Virtual Account List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_nw_ic_va" name="permissions[add_nw_ic_va]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_nw_ic_va" class="text-base font-semibold cursor-pointer mb-0">
                  Add New ICICI Virtual Account
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_ic_va_info" name="permissions[shw_ic_va_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_ic_va_info" class="text-base font-semibold cursor-pointer mb-0">
                     Show ICICI Virtual Account Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_virtual_as" name="permissions[ic_virtual_as]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_virtual_as" class="text-base font-semibold cursor-pointer mb-0">
                  ICICI Virtual Account Status
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_vir_ac_ib" name="permissions[ic_vir_ac_ib]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_vir_ac_ib" class="text-base font-semibold cursor-pointer mb-0">
                 ICICI Virtual Account - Show on Passbook / App / Internet Banking
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="set_sms_va" name="permissions[set_sms_va]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="set_sms_va" class="text-base font-semibold cursor-pointer mb-0">
               Send SMS Virtual Account
                    </label>
                </div>
            </div>
            
        </div>
    </div>
    <br>
    <!-----------------Icici Virtual Upis-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
           Icici Virtual Upis
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
                    <input type="checkbox" id="ic_vir_upi_lis" name="permissions[ic_vir_upi_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_vir_upi_lis" class="text-base font-semibold cursor-pointer mb-0">
                   ICICI Virtual UPI List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_vir_upi" name="permissions[add_new_vir_upi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_vir_upi" class="text-base font-semibold cursor-pointer mb-0">
                    Add New ICICI Virtual UPI
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_ic_upi_info" name="permissions[shw_ic_upi_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_ic_upi_info" class="text-base font-semibold cursor-pointer mb-0">
                  Show ICICI Virtual UPI Info
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_upi_acc_sta" name="permissions[ic_upi_acc_sta]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_upi_acc_sta" class="text-base font-semibold cursor-pointer mb-0">
                     ICICI UPI Account Status
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_upi_shw_pass_ib" name="permissions[ic_upi_shw_pass_ib]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_upi_shw_pass_ib" class="text-base font-semibold cursor-pointer mb-0">
                     ICICI UPI - Show on Passbook / App / Internet Banking
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_upi_code_gen" name="permissions[ic_upi_code_gen]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_upi_code_gen" class="text-base font-semibold cursor-pointer mb-0">
                      ICICI UPI QR Code - Regenerate
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="send_sms_vir_ac" name="permissions[send_sms_vir_ac]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="send_sms_vir_ac" class="text-base font-semibold cursor-pointer mb-0">
                 Send SMS Virtual Account
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
     <!-----------------Icici Static Qrs-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
          Icici Static Qrs
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
                    <input type="checkbox" id="ic_static_qr_lis" name="permissions[ic_static_qr_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_static_qr_lis" class="text-base font-semibold cursor-pointer mb-0">
                  ICICI Static QR List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_ic_qr" name="permissions[add_new_ic_qr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_ic_qr" class="text-base font-semibold cursor-pointer mb-0">
                  Add New ICICI Static QR
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_ic_qr_info" name="permissions[shw_ic_qr_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_ic_qr_info" class="text-base font-semibold cursor-pointer mb-0">
                  Show ICICI Static QR Info
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_sta_qr_status" name="permissions[ic_sta_qr_status]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_sta_qr_status" class="text-base font-semibold cursor-pointer mb-0">
                    ICICI Static QR Status
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="val_ic_sta_qp_xls" name="permissions[val_ic_sta_qp_xls]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="val_ic_sta_qp_xls" class="text-base font-semibold cursor-pointer mb-0">
                     Validate ICICI Static QR Payments via XLS
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="static_qr_trans" name="permissions[static_qr_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="static_qr_trans" class="text-base font-semibold cursor-pointer mb-0">
                     ICICI Static QR Trasactions - Download XLS
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="static_qr_post_ent" name="permissions[static_qr_post_ent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="static_qr_post_ent" class="text-base font-semibold cursor-pointer mb-0">
                ICICI Static QR Trasactions - Post Entry
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_qr_ib" name="permissions[shw_qr_ib]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_qr_ib" class="text-base font-semibold cursor-pointer mb-0">
              ICICI UPI - Show on Passbook / App / Internet Banking
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_upi_qr_regnarate" name="permissions[ic_upi_qr_regnarate]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ic_upi_qr_regnarate" class="text-base font-semibold cursor-pointer mb-0">
              ICICI UPI QR Code - Regenerate
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ic_upi_qr_regnarate_qr" name="permissions[send_sms_static_qr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="send_sms_static_qr" class="text-base font-semibold cursor-pointer mb-0">
             Send SMS Static QR
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>

     <!-----------------Icici Fund Transfers------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
             Icici Fund Transfers
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
                    <input type="checkbox" id="new_fund_taf_ic" name="permissions[new_fund_taf_ic]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_fund_taf_ic" class="text-base font-semibold cursor-pointer mb-0">
                    New Fund Transfer ICICI
                    </label>
                </div>
            </div>

        </div>
    </div>
   

</div>