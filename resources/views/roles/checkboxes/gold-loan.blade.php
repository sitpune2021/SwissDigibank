<div class="tab-panel hidden">
    
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
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
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
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
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
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="shw_gol_lon_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                            Show Gold Loan Scheme Info
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="edit_gol_lon_sch"
                            name="permissions[]" value="gold-loan.schemes.edit"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
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
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
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
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Applications List
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_app_sms_enb" name="permissions[]" value="gold-loan.applications.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_app_sms_enb" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Application SMS Enabled/Disabled
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="op_new_gol_lon_app" name="permissions[]" value="gold-loan.applications.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="op_new_gol_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Open New Gold Loan Application
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_gol_app_inf" name="permissions[]" value="gold-loan.applications.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_gol_app_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Gold Loan Application Info
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="set_dis_set" name="permissions[]" value="gold-loan.disbursements.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="set_dis_set" class="text-base font-semibold cursor-pointer mb-0">
                        Set Disbursement Setting
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_dis_set_enach" name="permissions[]" value="gold-loan.application.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_dis_set_enach" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Disbursement Setting After eNach Creation
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_gol_lon_app_apr" name="permissions[]" value="gold-loan.applications.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_gol_lon_app_apr" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Gold Loan Application Info before Application is 'APPROVED'
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_new_orn_img" name="permissions[]" value="gold-loan.ornaments.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_new_orn_img" class="text-base font-semibold cursor-pointer mb-0">
                        Upload New Ornament Image
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_upl_orn_img" name="permissions[]" value="gold-loan.ornaments.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_upl_orn_img" class="text-base font-semibold cursor-pointer mb-0">
                        Change Uploaded Ornament Image
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_gol_lon_app" name="permissions[]" value="gold-loan.application.delete-application"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_gol_lon_app" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Gold Loan Application
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sub_gol_lon_app_adm" name="permissions[]" value="gold-loan.application.submit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sub_gol_lon_app_adm" class="text-base font-semibold cursor-pointer mb-0">
                        Submit Gold Loan Application for Admin Re-Approval
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="upl_gol_lon_app_doc" name="permissions[upl_gol_lon_app_doc]" value="gold-loan.application.upload-documents"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="upl_gol_lon_app_doc" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Gold Loan Application Document
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_gol_lon_app" name="permissions[del_gol_lon_app]" value="gold-loan.application.delete-documents"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Gold Loan Application Document
                    </label>
                </div>
            </div> -->

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
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_orn_inv" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Ornaments Inventory
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_gol_orn_sta" name="permissions[]" value="gold-loan.ornaments.update"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
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
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Disbursements List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_rel_gol_lon" name="permissions[]" value="gold-loan.disbursements.disburse-loan"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_rel_gol_lon" class="text-base font-semibold cursor-pointer mb-0">
                        Disburse / Release Gold Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_gol_lon_dis" name="permissions[]" value="golddisbursements.cancel"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
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
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gl_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_gol_lon_acc" name="permissions[]" value="gold-loan.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_gol_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Show Gold Loan Account
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gl_lon_acc_rem_sms"
                        name="permissions[]" value="gold-loan.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gl_lon_acc_rem_sms" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Accounts Reminder SMS Enabled / Disabled
                    </label>
                </div>
            </div> -->

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_acc_hol_enb" name="permissions[]" value="gold-loan.account.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_acc_hol_enb" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Account HOLD Enabled / Disabled
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_gol_lon_acc" name="permissions[]" value="goldloan.remove"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rm_gol_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Gold Loan Account
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_trans_list" name="permissions[]" value="gold-loan.account.transaction"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_trans_list" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Transactions List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_gol_lon_trans" name="permissions[]" value="gold-loan.account.transaction"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_gol_lon_trans" class="text-base font-semibold cursor-pointer mb-0">
                        Show Gold Loan Transactions
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_gol_tran_time" name="permissions[]" value="gold-loan.account.transaction"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_gol_tran_time" class="text-base font-semibold cursor-pointer mb-0">
                        Update Gold Loan Transaction Time
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_gol_trans" name="permissions[]" value="gold-loan.account.transaction"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_gol_trans" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Gold Loan Transaction
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_sms_enb_dsb" name="permissions[]" value="gold-loan.account.view"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_sms_enb_dsb" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Account SMS Enabled/ Disabled
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="link_sav_acc_to_gold" name="permissions[]" value="gold-loan.account.link-saving-account"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="link_sav_acc_to_gold" class="text-base font-semibold cursor-pointer mb-0">
                        Link Saving Account To Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="unlink_sav_acc_to_gol" name="permissions[]" value="gold-loan.account.unlink-saving-account"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unlink_sav_acc_to_gol" class="text-base font-semibold cursor-pointer mb-0">
                        Unlink Saving Account To Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_pay_int_of_gl" name="permissions[]" value="gold-loan.account.collect-interest"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_pay_int_of_gl" class="text-base font-semibold cursor-pointer mb-0">
                        Collect/ Pay Interest of Gold Loan
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_pay_gol_due_emi" name="permissions[]" value="gold-loan.account.collect-overdue-emi"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_pay_gol_due_emi" class="text-base font-semibold cursor-pointer mb-0">
                        Collect/ Pay Gold Loan Over Due EMI
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="lon_set_gol_acc" name="permissions[]" value="gold-loan.settlement"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="lon_set_gol_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Loan Settlement - Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="on_hol_enach_sub" name="permissions[]" value="gold-loan.account.on-hold-enach-subscription"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="on_hol_enach_sub" class="text-base font-semibold cursor-pointer mb-0">
                        On-Hold E-Nach Subscription
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_cha_gol_lon_acc" name="permissions[]" value="gold-loan.account.other-charges"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_cha_gol_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Other Charges - Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_oth_cha_lon_acc" name="permissions[]" value="gold-loan.account.delete-other-charges"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_oth_cha_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Other Charges - Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_cha_clr_due" name="permissions[]" value="gold-loan.account.other-charges-clear-due"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_cha_clr_due" class="text-base font-semibold cursor-pointer mb-0">
                        Other Charges - Clear Due
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_cha_wav_amt" name="permissions[]" value="gold-loan.account.other-charges-waive-amount"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_cha_wav_amt" class="text-base font-semibold cursor-pointer mb-0">
                        Other Charges - Waive Amount
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_trans_rec" name="permissions[]" value="gold-loan.account.transaction-recipt"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_trans_rec" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan Transaction Receipt
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="chg_up_gol_pen_ch" name="permissions[]" value="gold-loan.account.update-penalty-charges"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="chg_up_gol_pen_ch" class="text-base font-semibold cursor-pointer mb-0">
                        Change/ Update Gold Loan Penalty Charges
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_over_in" name="permissions[]" value="gold-loan.account.update-overdue-interest"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_over_in" class="text-base font-semibold cursor-pointer mb-0">
                        Change/ Update Gold Loan Account Overdue Interest
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_gol_acc_brc" name="permissions[]" value="gold-loan.account.update-branch"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_gol_acc_brc" class="text-base font-semibold cursor-pointer mb-0">
                        Change/ Update Gold Loan Account Branch

                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_acc_agent" name="permissions[]" value="gold-loan.account.update-agent"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_acc_agent" class="text-base font-semibold cursor-pointer mb-0">
                        Change/ Update Gold Loan Account Agent
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="acc_gen" name="permissions[]" value="gold-loan.account.update-guarantor"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="acc_gen" class="text-base font-semibold cursor-pointer mb-0">
                        Change/ Update Gold Loan Account Guarantor
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="py_amt_gol_lon" name="permissions[]" value="gold-loan.account.pay-amount"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="py_amt_gol_lon" class="text-base font-semibold cursor-pointer mb-0">
                        Pay Amount Gold Loan
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_sch_ext" name="permissions[]" value="gold-loan.account.extension"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_sch_ext" class="text-base font-semibold cursor-pointer mb-0">
                        Gold Loan RE-SCHEDULE/ Extension
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rai_req_for_cl" name="permissions[]" value="gold-loan.account.foreclose-request"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rai_req_for_cl" class="text-base font-semibold cursor-pointer mb-0">
                        Raise Request to Fore Close Gold Loan
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cls_gold_lon" name="permissions[]" value="gold-loan.account.close"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cls_gold_lon" class="text-base font-semibold cursor-pointer mb-0">
                        Close Gold Loan
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emi_to_due" name="permissions[]" value="gold-loan.account.mark-emi-to-due"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emi_to_due" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Gold Loan EMI to DUE if (System/ Software FAILS).
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mar_gol_emi_ovr_due" name="permissions[]" value="gold-loan.account.mark-emi-to-overdue"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mar_gol_emi_ovr_due" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Gold Loan EMI to OVER DUE if (System/ Software FAILS).
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gl_paid_emi_ovr_due" name="permissions[]" value="gold-loan.account.mark-paid-emi-to-due-or-overdue"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gl_paid_emi_ovr_due" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Gold Loan PAID EMI to DUE or OVER DUE
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mrk_gol_due_paid_st" name="permissions[]" value="gold-loan.account.mark-due-to-paid-state"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mrk_gol_due_paid_st" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Gold Loan DUE to Paid state
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_lon_acc_doc" name="permissions[]" value="gold-loan.account.upload-documents"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_lon_acc_doc" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Gold Loan Account Document
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_gol_acc_doc" name="permissions[]" value="gold-loan.account.delete-documents"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_gol_acc_doc" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Gold Loan Account Document
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gol_cc_comment" name="permissions[]" value="gold-loan.account.add-comment"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gol_cc_comment" class="text-base font-semibold cursor-pointer mb-0">
                        Add Gold Loan Account Comment
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="reg_gol_acc_led" name="permissions[]" value="gold-loan.account.regenerate-ledger"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="reg_gol_acc_led" class="text-base font-semibold cursor-pointer mb-0">
                        Regenerate Gold Loan Account Ledger
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rep_gol_lon_acc" name="permissions[]" value="gold-loan.account.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rep_gol_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Reopen Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emi_ch_gl_acc" name="permissions[]" value="gold-loan.account.update-emi-chart"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emi_ch_gl_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Update EMI Chart- Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_initaite_pg_trans" name="permissions[]" value="gold-loan.account.re-initiate-pg-transaction"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_initaite_pg_trans" class="text-base font-semibold cursor-pointer mb-0">
                        Re-Initiate PG Transaction- Gold Loan Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_gen_del_entry" name="permissions[]" value="gold-loan.account.re-generate-deleted-entry"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_gen_del_entry" class="text-base font-semibold cursor-pointer mb-0">
                        Re-Generate Deleted Entry
                    </label>
                </div>
            </div> -->

        </div>
    </div>

</div>