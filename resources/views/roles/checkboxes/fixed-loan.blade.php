<div class="tab-panel hidden">

<!-----------------Fixed Loan Schemes --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Loan Schemes</div>
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
                    <input type="checkbox" id="fixed_scheme"
                     name="permissions[fixed_scheme]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fixed_scheme" class="text-base font-semibold cursor-pointer mb-0">
                 Fixed Loan Scheme List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_fixed_scheme" 
                    name="permissions[new_fixed_scheme]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_fixed_scheme" class="text-base font-semibold cursor-pointer mb-0">
                  Add New Fixed Loan Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fl_sch_info" name="permissions[shw_fl_sch_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_fl_sch_info" class="text-base font-semibold cursor-pointer mb-0">
                 Show Fixed Loan Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_fl_lon_sch" 
                    name="permissions[edit_fl_lon_sch]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_fl_lon_sch" class="text-base font-semibold cursor-pointer mb-0">
                  Edit Fixed Loan Scheme
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Fixed Loan Applications --------------------> 
  
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Fixed Loan Applications
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
                    <input type="checkbox" id="fix_lon_app_lis" name="permissions[fix_lon_app_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_app_lis" class="text-base font-semibold cursor-pointer mb-0">
              Fixed Loan Applications List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_fix_ln_app" name="permissions[new_fix_ln_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_fix_ln_app" class="text-base font-semibold cursor-pointer mb-0">
                  New fixed Loan Applications
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fix_ln_app" name="permissions[shw_fix_ln_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_fix_ln_app" class="text-base font-semibold cursor-pointer mb-0">
                  Show Fixed Loan Application
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="set_dis_fix_set" name="permissions[set_dis_fix_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="set_dis_fix_set" class="text-base font-semibold cursor-pointer mb-0">
                  Set Disbursement Setting
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_dis_set_enach_fix" name="permissions[edi_dis_set_enach_fix]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_dis_set_enach_fix" class="text-base font-semibold cursor-pointer mb-0">
                  Edit Disbursement Setting After eNach Creation
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_fix_lon_app" name="permissions[edi_fix_lon_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_fix_lon_app" class="text-base font-semibold cursor-pointer mb-0">
               Edit Fixed Loan Application
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_fix_lon_app" name="permissions[rem_fix_lon_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_fix_lon_app" class="text-base font-semibold cursor-pointer mb-0">
               Remove Fixed Loan Application
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_lon_app_sms_enb" name="permissions[fix_lon_app_sms_enb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_app_sms_enb" class="text-base font-semibold cursor-pointer mb-0">
                 Fixed Loan Application SMS Enabled/Disabled
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sub_re_apr_app_fix" name="permissions[sub_re_apr_app_fix]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sub_re_apr_app_fix" class="text-base font-semibold cursor-pointer mb-0">
           Submit for Re-Approval Fixed Loan Application
                    </label>
                </div>
            </div>    
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_fix_lon_app" name="permissions[up_fix_lon_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_fix_lon_app" class="text-base font-semibold cursor-pointer mb-0">
        Upload Fixed Loan Application Documents
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_oth_lon_app" name="permissions[del_oth_lon_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_fix_lon_app" class="text-base font-semibold cursor-pointer mb-0">
        Delete Fixed Loan Application Documents
                    </label>
                </div>
            </div> -->

        </div>
    </div>

    <br>
    <!----------------- Fixed Loan Disbursements-------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Fixed Loan Disbursements
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
                    <input type="checkbox" id="fix_lon_dis_lis" name="permissions[fix_lon_dis_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                 Fixed Loan Disbursements List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_oth_lon" name="permissions[dis_fix_lon]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_fix_lon" class="text-base font-semibold cursor-pointer mb-0">
                 Disburse Fixed Loan
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="can_fix_lon" name="permissions[can_fix_lon]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="can_fix_lon" class="text-base font-semibold cursor-pointer mb-0">
                Cancel Fixed Loan

                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
  <!-----------------Fixed Loan Accounts--------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Loan Accounts</div>
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
                    <input type="checkbox" id="fix_lon_acc_lis" 
                    name="permissions[fix_lon_acc_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
             Fixed Loan Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fix_lon_acc" name="permissions[shw_fix_lon_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_fix_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
              Show Fixed Loan Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_fix_lon_acc" 
                    name="permissions[rm_fix_lon_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rm_fix_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
                Remove Fixed Loan Account
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_lon_tran_lis" name="permissions[fix_lon_tran_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_tran_lis" class="text-base font-semibold cursor-pointer mb-0">
              Fixed Loan Transactions List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_fix_lon_trans" name="permissions[up_fix_lon_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_fix_lon_trans" class="text-base font-semibold cursor-pointer mb-0">
                 Update Fixed Loan Transaction Time
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_fix_lon_trans" name="permissions[shw_fix_lon_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_fix_lon_trans" class="text-base font-semibold cursor-pointer mb-0">
               Show Fixed Loan Transactions
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_fix_lon_trans" name="permissions[rem_fix_lon_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_fix_lon_trans" class="text-base font-semibold cursor-pointer mb-0">
                 Remove Fixed Loan Transaction
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_lon_sms_enb" name="permissions[fix_lon_sms_enb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_sms_enb" class="text-base font-semibold cursor-pointer mb-0">
               Fixed Loan Account SMS Enabled/Disabled
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_acc_hold_enb" name="permissions[fix_acc_hold_enb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_acc_hold_enb" class="text-base font-semibold cursor-pointer mb-0">
             Fixed Loan Account HOLD Enabled/ Disabled
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_lon_acc_rem_enb" name="permissions[fix_lon_acc_rem_enb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_lon_acc_rem_enb" class="text-base font-semibold cursor-pointer mb-0">
              Fixed Loan Accounts Reminder SMS Enabled / Disabled
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="link_sav_fix_acc" name="permissions[link_sav_fix_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="link_sav_fix_acc" class="text-base font-semibold cursor-pointer mb-0">
              Link Saving Account To Fixed Loan Account
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="unlink_fix_lon_acc" name="permissions[unlink_fix_lon_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unlink_fix_lon_acc" class="text-base font-semibold cursor-pointer mb-0">
             Unlink Saving Account To Fixed Loan Account
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_pay_emi_fl" name="permissions[col_pay_emi_fl]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_pay_emi_fl" class="text-base font-semibold cursor-pointer mb-0">
          Collect/ Pay Fixed Loan EMI
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_pay_fix_due_emi" name="permissions[col_pay_fix_due_emi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_pay_fix_due_emi" class="text-base font-semibold cursor-pointer mb-0">
            Collect/ Pay Fixed Loan Over Due EMI
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_old_acc_no_fl" name="permissions[ch_old_acc_no_fl]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_old_acc_no_fl" class="text-base font-semibold cursor-pointer mb-0">
                   Change/ Update Fixed Loan Account Old Account No
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_fl_acc_brc" name="permissions[ch_fl_acc_brc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_fl_acc_brc" class="text-base font-semibold cursor-pointer mb-0">
              Change/ Update Fixed Loan Account Branch
                    </label>
                </div>
            </div>
           <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fl_acc_agent" name="permissions[fl_acc_agent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fl_acc_agent" class="text-base font-semibold cursor-pointer mb-0">
               Change/ Update Fixed Loan Account Agent
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_fl_acc_gur" name="permissions[ch_up_fl_acc_gur]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_fl_acc_gur" class="text-base font-semibold cursor-pointer mb-0">
               Change/ Update Fixed Loan Account Guarantor
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_fix_lon_amt" name="permissions[dis_fix_lon_amt]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_fix_lon_amt" class="text-base font-semibold cursor-pointer mb-0">
             Disburse Fixed Loan Amount
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="on_hold_fl_enach" name="permissions[on_hold_fl_enach]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="on_hold_fl_enach" class="text-base font-semibold cursor-pointer mb-0">
             On-Hold E-Nach Subscription
                    </label>
                </div>
            </div>         
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_ch_fl_acc" name="permissions[oth_ch_fl_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_ch_fl_acc" class="text-base font-semibold cursor-pointer mb-0">
                   Other Charges - Fixed Loan Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_otch_fl_acc" name="permissions[del_otch_fl_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_otch_fl_acc" class="text-base font-semibold cursor-pointer mb-0">
           Delete Other Charges - Fixed Loan Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_ch_clr_due" name="permissions[oth_ch_clr_due]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_ch_clr_due" class="text-base font-semibold cursor-pointer mb-0">
            Other Charges - Clear Due
                   </label>
                </div>
            </div>         
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_chr_waive_amt" name="permissions[oth_chr_waive_amt]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_chr_waive_amt" class="text-base font-semibold cursor-pointer mb-0">
               Other Charges - Waive Amount
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_loan_trans_rec" name="permissions[fix_loan_trans_rec]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_loan_trans_rec" class="text-base font-semibold cursor-pointer mb-0">
                    Fixed Loan Transaction Receipt
                 </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_fl_pen_ch" name="permissions[ch_up_fl_pen_ch]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_fl_pen_ch" class="text-base font-semibold cursor-pointer mb-0">
         Change/ Update Fixed Loan Penalty Charges
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_fl_ovdue_int" 
                    name="permissions[ch_fl_ovdue_int]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_fl_ovdue_int" class="text-base font-semibold cursor-pointer mb-0">
         Change/ Update Fixed Loan Account Overdue Interest
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="pay_amt_fl" name="permissions[pay_amt_fl]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="pay_amt_fl" class="text-base font-semibold cursor-pointer mb-0">
            Pay Amount Fixed Loan
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_loan_sch_ext" name="permissions[fix_loan_sch_ext]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fix_loan_sch_ext" class="text-base font-semibold cursor-pointer mb-0">
              Fixed Loan RE-SCHEDULE/ Extension
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ln_set_fl_acc" name="permissions[ln_set_fl_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ln_set_fl_acc" class="text-base font-semibold cursor-pointer mb-0">
                 Loan Settlement - Fixed Loan Account
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="foreclose_fl_lon" name="permissions[foreclose_fl_lon]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="foreclose_fl_lon" class="text-base font-semibold cursor-pointer mb-0">
                  Foreclose Fixed Loan
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cls_fix_lon" name="permissions[cls_fix_lon]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cls_fix_lon" class="text-base font-semibold cursor-pointer mb-0">
       Close Fixed Loan

                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="man_prs_fl_emi" name="permissions[man_prs_fl_emi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="man_mrk_paid_lon_emi" class="text-base font-semibold cursor-pointer mb-0">
       Manually Process Fixed Loan EMI
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="man_mark_fl_loan_due" name="permissions[man_mark_fl_loan_due]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="man_mark_fl_loan_due" class="text-base font-semibold cursor-pointer mb-0">
                  Manually Mark Fixed Loan EMI Over Due
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="man_mark_paid_loan_emi" name="permissions[man_mark_paid_loan_emi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="man_mark_paid_loan_emi" class="text-base font-semibold cursor-pointer mb-0">
          Manually Mark Paid Loan EMI
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_fl_acc_doc"
                     name="permissions[up_fl_acc_doc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_fl_acc_doc" class="text-base font-semibold cursor-pointer mb-0">
               Upload Fixed Loan Account Documents
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_fix_loan_acc_doc" name="permissions[del_fix_loan_acc_doc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_fix_loan_acc_doc" class="text-base font-semibold cursor-pointer mb-0">
             Delete Fixed Loan Account Documents
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_fl_acc_com" name="permissions[add_fl_acc_com]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_fl_acc_com" class="text-base font-semibold cursor-pointer mb-0">
            Add Fixed Loan Account Comment
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="reg_fl_acc_led" 
                    name="permissions[reg_fl_acc_led]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="reg_fl_acc_led" class="text-base font-semibold cursor-pointer mb-0">
            Regenerate Fixed Loan Account Ledger
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_open_fl_acc" name="permissions[re_open_fl_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_open_fl_acc" class="text-base font-semibold cursor-pointer mb-0">
           Reopen Fixed Loan Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_emi_fl_acc" name="permissions[up_emi_fl_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_emi_fl_acc" class="text-base font-semibold cursor-pointer mb-0">
          Update EMI Chart- Fixed Loan Account
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_ini_pg_trans" name="permissions[re_ini_pg_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_ini_pg_trans" class="text-base font-semibold cursor-pointer mb-0">
           Re-Initiate PG Transaction- Fixed Loan Account
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_gen_del_ent" name="permissions[re_gen_del_ent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_gen_del_ent" class="text-base font-semibold cursor-pointer mb-0">
            Re-Generate Deleted Entry
                   </label>
                </div>
            </div> -->

       </div>
    </div>

</div>