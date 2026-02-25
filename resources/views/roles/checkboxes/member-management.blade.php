<div class="tab-panel hidden">
    
    <!----------------- Members -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">CUSTOMER</div>
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
                    <input type="checkbox" id="members_list" name="permissions[members_list]" value=""
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="members_list" class="text-base font-semibold cursor-pointer mb-0">
                        Customer List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_mem" name="permissions[add_new_mem]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_mem" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Member
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="skip_mob_ver" name="permissions[skip_mob_ver]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="skip_mob_ver" class="text-base font-semibold cursor-pointer mb-0">
                        Allow Skip Mobile No Verification
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_member_info" name="permissions[show_member_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_member_info" class="text-base font-semibold cursor-pointer mb-0">
                        Show Member Info
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_total_dep" name="permissions[mem_total_dep]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_total_dep" class="text-base font-semibold cursor-pointer mb-0">
                        Show Member Info - Total Deposit
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="tot_loan_outstand" name="permissions[tot_loan_outstand]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="tot_loan_outstand" class="text-base font-semibold cursor-pointer mb-0">
                        Show Member Info - Total Loan Outstanding
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_mem_info" name="permissions[edit_mem_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_mem_info" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Member Info
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sms_enb_dsb" name="permissions[sms_enb_dsb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sms_enb_dsb" class="text-base font-semibold cursor-pointer mb-0">
                        Member SMS Enable/ Disable
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="upload_mem_docs" name="permissions[upload_mem_docs]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="upload_mem_docs" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Member Documents
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_mem_com" name="permissions[add_mem_com]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_mem_com" class="text-base font-semibold cursor-pointer mb-0">
                        Add Member Comment
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_rem_docs" name="permissions[up_rem_docs]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_rem_docs" class="text-base font-semibold cursor-pointer mb-0">
                        Update/ Remove Member Documents
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_edit_con" name="permissions[up_edit_con]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_edit_con" class="text-base font-semibold cursor-pointer mb-0">
                        Edit/ Update Member Contact Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_edit_bank" name="permissions[up_edit_bank]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_edit_bank" class="text-base font-semibold cursor-pointer mb-0">
                        Edit/ Update Member Bank Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_edit_em_ph" name="permissions[up_edit_em_ph]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_edit_em_ph" class="text-base font-semibold cursor-pointer mb-0">
                        Edit/Update Member Email Phone
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_share_hol_info" name="permissions[mem_share_hol_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_share_hol_info" class="text-base font-semibold cursor-pointer mb-0">
                        Show Member Share Holdings Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mon_trans_enb_dsb" name="permissions[mon_trans_enb_dsb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mon_trans_enb_dsb" class="text-base font-semibold cursor-pointer mb-0">
                        Member's Money Transfer Enable/ Disable
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="inter_bank_enb_dsb" name="permissions[inter_bank_enb_dsb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="inter_bank_enb_dsb" class="text-base font-semibold cursor-pointer mb-0">
                        Member's Internet Banking Enable/ Disable
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_del_mem_det" name="permissions[rm_del_mem_det]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rm_del_mem_det" class="text-base font-semibold cursor-pointer mb-0">
                        Remove/ Delete Member & all details
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_cha_active" name="permissions[mem_cha_active]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_cha_active" class="text-base font-semibold cursor-pointer mb-0">
                        Member Change Status to Active
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_cha_inactive" name="permissions[mem_cha_inactive]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_cha_inactive" class="text-base font-semibold cursor-pointer mb-0">
                        Member Change Status to Inactive
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_cha_kyc_stat" name="permissions[mem_cha_kyc_stat]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_cha_kyc_stat" class="text-base font-semibold cursor-pointer mb-0">
                        Member Change KYC Status
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_hide_con" name="permissions[show_hide_con]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_hide_con" class="text-base font-semibold cursor-pointer mb-0">
                        Member Show / Hide Contact Details
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_adh_ver" name="permissions[mem_adh_ver]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_adh_ver" class="text-base font-semibold cursor-pointer mb-0">
                        Member Aadhaar Verification without OTP
                    </label>
                </div>
            </div> -->

        </div>
    </div>

    <br>
    <!----------------- Members Login Credentials -------------------->
    <!-- <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Members Login Credentials</div>
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
                    <input type="checkbox" id="res_mem_pass" name="permissions[res_mem_pass]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="res_mem_pass" class="text-base font-semibold cursor-pointer mb-0">
                        Reset Member Password
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="loc_unloc_mem" name="permissions[loc_unloc_mem]" value="show_branch"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="loc_unloc_mem" class="text-base font-semibold cursor-pointer mb-0">
                        Lock/ Unlock Member Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="res_send_mem_log" name="permissions[res_send_mem_log]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="res_send_mem_log" class="text-base font-semibold cursor-pointer mb-0">
                        Reset & Send Member's Login Credentials via SMS
                    </label>
                </div>
            </div>



        </div>
    </div> -->

    <br>
    <!----------------- Minors -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Minors</div>
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
                    <input type="checkbox" id="minors_list" name="permissions[minors_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="minors_list" class="text-base font-semibold cursor-pointer mb-0">
                        Minors List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_minor" name="permissions[add_minor]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_minor" class="text-base font-semibold cursor-pointer mb-0">
                        Add Minor
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_min" name="permissions[show_min]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_min" class="text-base font-semibold cursor-pointer mb-0">
                        Show Minor
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_min" name="permissions[edit_min]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_min" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Minor
                    </label>
                </div>
            </div>


        </div>

    </div>

    <br>
    <!----------------- Auth Persons -------------------->
    <!-- <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Auth Persons</div>
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
                    <input type="checkbox" id="auth_per_lis" name="permissions[auth_per_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="auth_per_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Authorized Persons List
                    </label>
                </div>
            </div>
        </div>
    </div> -->

    <br>
    <!----------------- Member Transactions-------------------->
    <!-- <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Member Transactions</div>
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
                    <input type="checkbox" id="mem_trans_lis" name="permissions[mem_trans_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_trans_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Member's Transaction List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="coll_mem_cha" name="permissions[coll_mem_cha]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="coll_mem_cha" class="text-base font-semibold cursor-pointer mb-0">
                        Collect Membership Charges
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_share_amt" name="permissions[col_share_amt]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_share_amt" class="text-base font-semibold cursor-pointer mb-0">
                        Collect Share Amount - Member
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_mem_trans" name="permissions[del_mem_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_shardel_mem_transe_amt" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Member Transaction
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="oth_cha_tran" name="permissions[oth_cha_tran]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="oth_cha_tran" class="text-base font-semibold cursor-pointer mb-0">
                        Other Charges - Member Transaction
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_oth_cha" name="permissions[del_oth_cha]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_oth_cha" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Other Charges - Member Transaction
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

        </div>
    </div> -->

    <br>
    <!-----------------Share Holdings-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Share Holdings
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
                    <input type="checkbox" id="com_mem_sha_lis" name="permissions[com_mem_sha_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="com_mem_sha_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Company Customer's Share Holdings List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="all_new_shar" name="permissions[all_new_shar]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="all_new_shar" class="text-base font-semibold cursor-pointer mb-0">
                        Allocate/ Transfer New Shares to Customer
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_sha_hol" name="permissions[edit_sha_hol]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_sha_hol" class="text-base font-semibold cursor-pointer mb-0">
                        Edit/ Update Share Holding
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rai_sha_trans_req" name="permissions[rai_sha_trans_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rai_sha_trans_req" class="text-base font-semibold cursor-pointer mb-0">
                        Raise Share Transfer Request from Member
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="all_wout_app" name="permissions[all_wout_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="all_wout_app" class="text-base font-semibold cursor-pointer mb-0">
                        Allocate New Share - Directly Without Approval and Fill Share to Allocate
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="trans_share_wout_app" name="permissions[trans_share_wout_app]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="trans_share_wout_app" class="text-base font-semibold cursor-pointer mb-0">
                        Transfer Share - Directly Without Approval and Fill Share to Transfer
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_rem_share_hol" name="permissions[del_rem_share_hol]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_rem_share_hol" class="text-base font-semibold cursor-pointer mb-0">
                        Delete/ Remove Share Holding
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="raise_share_sur_req" name="permissions[raise_share_sur_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="raise_share_sur_req" class="text-base font-semibold cursor-pointer mb-0">
                        Raise Share Surrender Request
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="raise_share_trans_req" name="permissions[raise_share_trans_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="raise_share_trans_req" class="text-base font-semibold cursor-pointer mb-0">
                        Raise Share Transfer Request from Member
                    </label>
                </div>
            </div> -->

        </div>
    </div>

    <br>
    <!-----------------Share Certificates-------------------->
    <!-- <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Share Certificates</div>
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
                    <input type="checkbox" id="comp_mem_sha_lis" name="permissions[comp_mem_sha_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="comp_mem_sha_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Company Member's Share Certificates List
                    </label>
                </div>
            </div>

        </div>

    </div> -->

    <br>
    <!-----------------Share Transfer History-------------------->
    <!-- <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Share Transfer History</div>
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
                    <input type="checkbox" id="com_sha_tran_reg" name="permissions[com_sha_tran_reg]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="com_sha_tran_reg" class="text-base font-semibold cursor-pointer mb-0">
                        Company Share Transfer Register/ History
                    </label>
                </div>
            </div>

        </div>
    </div> -->

    <br>
    <!-----------------Form 15g-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Form 15g</div>
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
                    <input type="checkbox" id="form_g_h_lis" name="permissions[form_g_h_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="form_g_h_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Form 15G/ 15H List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_g_h_lis" name="permissions[show_g_h_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_g_h_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Show Form 15G/ 15H Info
                    </label>
                </div>
            </div>

            <!-- <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_new_for_g_h" name="permissions[up_new_for_g_h]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="up_new_for_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Upload New Form 15G/ 15H
                    </label>
                </div>
            </div> -->

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_form_g_h" name="permissions[edit_form_g_h]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_form_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Form 15G/ 15H
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_form_g_h" name="permissions[del_form_g_h]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_form_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Form 15G/ 15H
                    </label>
                </div>
            </div>

        </div>

    </div>

</div>