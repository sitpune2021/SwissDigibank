<div class="tab-panel hidden">

<!----------------- Saving Schemes --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Saving Schemes</div>
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
                    <input type="checkbox" id="save_sch_lis" name="permissions[save_sch_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="save_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                       Saving Schemes List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_sav_sch" name="permissions[add_new_sav_sch]" value="show_branch"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_sav_sch" class="text-base font-semibold cursor-pointer mb-0">
                       Add New Saving Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sav_sch_inf" name="permissions[show_sav_sch_inf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sav_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                      Show Saving Scheme Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_sav_sch_inf" name="permissions[edit_sav_sch_inf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_sav_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                     Edit/ Change Saving Scheme Info
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="set_com_chart" name="permissions[set_com_chart]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="set_com_chart" class="text-base font-semibold cursor-pointer mb-0">
                     Set Commission Chart
                    </label>
                </div>
            </div> -->

        </div>
    </div>

    <br>
    <!----------------- Saving Accounts --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Saving Accounts</div>
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
                    <input type="checkbox" id="sav_acc_lis" 
                    name="permissions[sav_acc_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sav_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
                       Saving Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_curr_bal" name="permissions[show_curr_bal]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_curr_bal" class="text-base font-semibold cursor-pointer mb-0">
                     Show Current Balance Saving Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="op_new_sav_acc" 
                    name="permissions[op_new_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="op_new_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Open New Saving Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sav_acc" name="permissions[show_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                    Show Saving Account Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_sav_acc" name="permissions[rm_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rm_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                   Remove Saving Account
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_sav_acc" name="permissions[ch_up_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                     Change/ Update Saving Account Member
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cha_up_sav_acc_old" name="permissions[cha_up_sav_acc_old]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cha_up_sav_acc_old" class="text-base font-semibold cursor-pointer mb-0">
                    Change/ Update Saving Account Old Account No
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_sav_re_lod" name="permissions[ch_up_sav_re_lod]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_sav_re_lod" class="text-base font-semibold cursor-pointer mb-0">
                   Change/ Update Saving Account Re-loadable Card No
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_sav_acc_op_date" name="permissions[ch_up_sav_acc_op_date]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_sav_acc_op_date" class="text-base font-semibold cursor-pointer mb-0">
                    Change/ Update Saving Account Open Date
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_sav_acc_branch" name="permissions[ch_up_sav_acc_branch]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_sav_acc_branch" class="text-base font-semibold cursor-pointer mb-0">
                    Change/ Update Saving Account Branch
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_sav_acc_agent" name="permissions[ch_up_sav_acc_agent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_sav_acc_agent" class="text-base font-semibold cursor-pointer mb-0">
                 Change/ Update Saving Account Agent
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_loc_bal" name="permissions[ch_up_loc_bal]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_loc_bal" class="text-base font-semibold cursor-pointer mb-0">
                   Change/ Update Saving Account Lock Balance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sb_swp_enb" name="permissions[sb_swp_enb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sb_swp_enb" class="text-base font-semibold cursor-pointer mb-0">
                SB Sweep-in Enabled/ Disabled
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_loc_bal_sb_fd" name="permissions[ch_up_loc_bal_sb_fd]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_loc_bal_sb_fd" class="text-base font-semibold cursor-pointer mb-0">
                Change/ Update SB Sweep-in FD Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sub_acc_adm_re_app" name="permissions[sub_acc_adm_re_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sub_acc_adm_re_app" class="text-base font-semibold cursor-pointer mb-0">
               Submit Saving Account for Admin Re-Approval
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sav_acc_sm_enb_dsb" name="permissions[sav_acc_sm_enb_dsb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sav_acc_sm_enb_dsb" class="text-base font-semibold cursor-pointer mb-0">
                     Saving Account SMS Enabled/ Disabled
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sav_acc_hol_en_dsb" name="permissions[sav_acc_hol_en_dsb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sav_acc_hol_en_dsb" class="text-base font-semibold cursor-pointer mb-0">
                    Saving Account Hold Enabled/ Disabled
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_sav_acc_new_sch" name="permissions[up_sav_acc_new_sch]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_sav_acc_new_sch" class="text-base font-semibold cursor-pointer mb-0">
                    Upgrade Saving Account to new Scheme
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_acc_type_sin_joi" name="permissions[ch_acc_type_sin_joi]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_acc_type_sin_joi" class="text-base font-semibold cursor-pointer mb-0">
                    Change Account Type Single/ Joint
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="clo_sav_acc" name="permissions[clo_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="clo_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                  Close Saving Account
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sav_acc_dec_ch" name="permissions[sav_acc_dec_ch]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sav_acc_dec_ch" class="text-base font-semibold cursor-pointer mb-0">
               Saving Account Deduct Charges Enabled/ Disabled
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_sav_acc_time_trans" name="permissions[up_sav_acc_time_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_sav_acc_time_trans" class="text-base font-semibold cursor-pointer mb-0">
             Update Saving Account Transaction Time
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dep_mon_sav_acc" name="permissions[dep_mon_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dep_mon_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                  Deposit Money in Saving Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="wit_mon_sav_acc" name="permissions[wit_mon_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="wit_mon_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                  Withdraw Money from Saving Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_ch_sav_acc" name="permissions[oth_ch_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_ch_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                 Other Charges - Saving Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_oth_ch_sav_acc" name="permissions[del_oth_ch_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_oth_ch_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                 Delete Other Charges - Saving Account
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_cha_cle_due" name="permissions[oth_cha_cle_due]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_cha_cle_due" class="text-base font-semibold cursor-pointer mb-0">
               Other Charges - Clear Due
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cre_int_sav_acc" name="permissions[cre_int_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cre_int_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
               Credit Interest in Saving Account
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_up_nom_info" name="permissions[add_up_nom_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_up_nom_info" class="text-base font-semibold cursor-pointer mb-0">
              Add/ Update Nominee Info in Saving Account
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_sav_acc_doc" name="permissions[up_sav_acc_doc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_sav_acc_doc" class="text-base font-semibold cursor-pointer mb-0">
             Upload Saving Account Documents
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_up_nom_info" name="permissions[del_up_nom_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_up_nom_info" class="text-base font-semibold cursor-pointer mb-0">
             Delete Saving Account Document
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rev_sav_trans" name="permissions[rev_sav_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rev_sav_trans" class="text-base font-semibold cursor-pointer mb-0">
            Reverse Saving Transaction
                   </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_sav_trans" name="permissions[del_sav_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_sav_trans" class="text-base font-semibold cursor-pointer mb-0">
              Delete Saving Transaction
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_op_sav_acc" name="permissions[re_op_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_op_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
             Re-Open Saving Account

                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_acc_typ_sav_acc" name="permissions[up_acc_typ_sav_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_acc_typ_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
            Update Account Type Saving/Current
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="reg_sav_acc_led" name="permissions[reg_sav_acc_led]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="reg_sav_acc_led" class="text-base font-semibold cursor-pointer mb-0">
            Regenerate Saving Account Ledger
                   </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_sav_acc_com" name="permissions[add_sav_acc_com]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_sav_acc_com" class="text-base font-semibold cursor-pointer mb-0">
                 Add Saving Account Comment
                   </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_sav_acc_tran_rec" name="permissions[add_sav_acc_tran_rec]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_sav_acc_tran_rec" class="text-base font-semibold cursor-pointer mb-0">
               Saving Account Transaction Receipt
                   </label>
                </div>
            </div> -->

       </div>
    </div>
    <br>

</div>