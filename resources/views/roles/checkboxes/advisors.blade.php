<div class="tab-panel hidden">
    <!-----------------Rank Structure -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Rank Structure</div>
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
                    <input type="checkbox" id="adv_rank_str_lis" name="permissions[adv_rank_str_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="adv_rank_str_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Advisor Rank Structure List
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_rank" name="permissions[add_new_rank]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_rank" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Rank
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_rank" name="permissions[edit_rank]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_rank" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Rank
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_rank" name="permissions[del_rank]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_rank" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Rank
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
    <!-----------------Incentive Charts -------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Incentive Charts
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard" class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="check-all form-checkbox font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-4">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ins_char_lis" name="permissions[ins_char_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ins_char_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Incentive Chart List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ins_char_lis" name="permissions[new_inc_chart]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ins_char_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Incentive Chart

                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_inc_chart" name="permissions[edit_inc_chart]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_inc_chart" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Incentive Chart
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Advisors-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Advisors
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard" class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="check-all form-checkbox text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="adv_list" name="permissions[adv_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="adv_list" class="text-base font-semibold cursor-pointer mb-0">
                        Advisor/ Advisor List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ad_list_down" name="permissions[ad_list_down]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ad_list_down" class="text-base font-semibold cursor-pointer mb-0">
                        Advisor/ Advisor List Download
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ad_nw_adv" name="permissions[ad_nw_adv]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ad_nw_adv" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Advisor/ Advisor
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_adv" name="permissions[shw_adv]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_adv" class="text-base font-semibold cursor-pointer mb-0">
                        Show Advisor/ Advisor Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_adv_info" name="permissions[edi_adv_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_adv_info" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Advisor/ Advisor Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="reset_adv_lp" name="permissions[reset_adv_lp]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="reset_adv_lp" class="text-base font-semibold cursor-pointer mb-0">
                        Reset Advisor/ Advisor Login Password
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="lc_ul_adv_acc" name="permissions[lc_ul_adv_acc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="lc_ul_adv_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Lock/ Unlock Advisor/ Advisor Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_sup_nam" name="permissions[shw_sup_nam]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_sup_nam" class="text-base font-semibold cursor-pointer mb-0">
                        Show Self Supervisor Name
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="adv_log_cred_sms" name="permissions[adv_log_cred_sms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="adv_log_cred_sms" class="text-base font-semibold cursor-pointer mb-0">
                        Reset & Send Advisor/ Advisor Login Credentials via SMS
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="upload_adv_pho" name="permissions[upload_adv_pho]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="upload_adv_pho" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Advisor/ Advisor Photo
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_adv_mon_inc" name="permissions[shw_adv_mon_inc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_adv_mon_inc" class="text-base font-semibold cursor-pointer mb-0">
                        Show Advisor Monthly Incentive in Advisor Login
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="lin_sav_acc_agent" name="permissions[lin_sav_acc_agent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="lin_sav_acc_agent" class="text-base font-semibold cursor-pointer mb-0">
                        Link Saving Account To Agent
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="unlink_sav_acc_agent" name="permissions[unlink_sav_acc_agent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="unlink_sav_acc_agent" class="text-base font-semibold cursor-pointer mb-0">
                        Unlink Saving Account From Agent
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Agent Transactions-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Agent Transactions
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard" class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="check-all form-checkbox text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="agent_trans" name="permissions[agent_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="agent_trans" class="text-base font-semibold cursor-pointer mb-0">
                        Agent's Transactions
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_auto_apr" name="permissions[del_auto_apr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_auto_apr" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Agent Transaction
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Commission Payouts -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Commission Payouts
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard" class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="check-all  form-checkbox text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="incentive_payout" name="permissions[incentive_payout]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="incentive_payout" class="text-base font-semibold cursor-pointer mb-0">
                        Incentive Payouts
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="new_incentive_payout" name="permissions[new_incentive_payout]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_incentive_payout" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Incentive Payout
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_incentive_payout" name="permissions[shw_incentive_payout]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_incentive_payout" class="text-base font-semibold cursor-pointer mb-0">
                        Show Incentive Payout
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mul_com_payout" name="permissions[mul_com_payout]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mul_com_payout" class="text-base font-semibold cursor-pointer mb-0">
                        Multiple Commission Payout
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_inc_payout" name="permissions[del_inc_payout]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_inc_payout" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Incentive Payout
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="re_gen_inc" name="permissions[re_gen_inc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="re_gen_inc" class="text-base font-semibold cursor-pointer mb-0">
                        Regenerate Incentive
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_del_inc" name="permissions[rem_del_inc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_del_inc" class="text-base font-semibold cursor-pointer mb-0">
                        Remove/ Delete Incentive
                    </label>
                </div>
            </div>


        </div>
    </div>
    <br>

</div>