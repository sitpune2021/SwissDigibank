<div class="tab-panel hidden">
<!-----------------Deposit Accounts --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Deposit Accounts</div>
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
                    <input type="checkbox" id="saving_acc_req_lis"
                     name="permissions[saving_acc_req_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="saving_acc_req_lis" class="text-base font-semibold cursor-pointer mb-0">
                Saving/ FD/ MIS/ RD/ DD Accounts Approval Request List
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="app_acc_req" 
                    name="permissions[app_acc_req]" value=""
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="app_acc_req" class="text-base font-semibold cursor-pointer mb-0">
                 Approve/ Reject Saving/ FD/ MIS/ RD/ DD Account Request
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cls_req_lis" name="permissions[cls_req_lis]" value=""
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="cls_req_lis" class="text-base font-semibold cursor-pointer mb-0">
               FD/ MIS/ RD/ DD Closure Request List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="app_cls_req" 
                    name="permissions[app_cls_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="app_cls_req" class="text-base font-semibold cursor-pointer mb-0">
                 Approve/ Reject FD/ MIS/ RD/ DD Closure Request
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Loan Accounts --------------------> 
  
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Loan Accounts
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
                    <input type="checkbox" id="la_apr_req_lis" name="permissions[la_apr_req_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="la_apr_req_lis" class="text-base font-semibold cursor-pointer mb-0">
            Loan Applications Approvals Request List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_app_req" name="permissions[apr_rej_app_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_app_req" class="text-base font-semibold cursor-pointer mb-0">
                 Approve/ Reject Loan Application Request
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="non_comp_lis" name="permissions[non_comp_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="non_comp_lis" class="text-base font-semibold cursor-pointer mb-0">
               Non-Compliance List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_nc" name="permissions[apr_rej_nc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_nc" class="text-base font-semibold cursor-pointer mb-0">
                 Approve/ Reject Non-Compliance
                    </label>
                </div>
            </div>
          
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="la_cls_req_lis" name="permissions[la_cls_req_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="la_cls_req_lis" class="text-base font-semibold cursor-pointer mb-0">
                 Loan Account Closure Request List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_lcr" name="permissions[apr_rej_lcr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_lcr" class="text-base font-semibold cursor-pointer mb-0">
               Approve/ Reject Loan Closure Request
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Accounting Approvals-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Accounting Approvals
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
                    <input type="checkbox" id="acc_voc_lis" name="permissions[acc_voc_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="acc_voc_lis" class="text-base font-semibold cursor-pointer mb-0">
                Accounting Voucher List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_oth_lon" name="permissions[apr_rej_lon]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_fix_lon" class="text-base font-semibold cursor-pointer mb-0">
                Approve/ Reject Voucher
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
     <!----------------- Printing Approvals-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
           Printing Approvals
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
                    <input type="checkbox" id="pr_lis" name="permissions[pr_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="pr_lis" class="text-base font-semibold cursor-pointer mb-0">
                Print Request List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_pr" name="permissions[apr_rej_pr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_pr" class="text-base font-semibold cursor-pointer mb-0">
             Approve/ Reject Print Request
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
     <!----------------- Reschedule Loan Approvals-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
           Reschedule Loan Approvals
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
                    <input type="checkbox" id="lon_re_sch_ext_rl" name="permissions[lon_re_sch_ext_rl]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="lon_re_sch_ext_rl" class="text-base font-semibold cursor-pointer mb-0">
               Loan Re-schedule/ Extension Request List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_lr_req" name="permissions[apr_rej_lr_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_lr_req" class="text-base font-semibold cursor-pointer mb-0">
             Approve/ Reject Loan Re-schedule/ Extension Request
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
  <!-----------------Approval Requests--------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Approval Requests</div>
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
                    <input type="checkbox" id="tra_apr_lis" 
                    name="permissions[tra_apr_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="tra_apr_lis" class="text-base font-semibold cursor-pointer mb-0">
             Cash/ Cheque/ Online Transactions Approval List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="onl_trans" name="permissions[onl_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="onl_trans" class="text-base font-semibold cursor-pointer mb-0">
             Approve/ Reject Cash/ Cheque/ Online Transaction
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_cash_trans" 
                    name="permissions[apr_rej_cash_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_cash_trans" class="text-base font-semibold cursor-pointer mb-0">
                Approve/ Reject Cash All Transaction
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rev_trans_lis" name="permissions[rev_trans_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rev_trans_lis" class="text-base font-semibold cursor-pointer mb-0">
              Reverse Transaction List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rev_trans_req" name="permissions[rev_trans_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rev_trans_req" class="text-base font-semibold cursor-pointer mb-0">
                Approve/ Reject Reverse Transaction Request
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_shr_req" name="permissions[apr_shr_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_shr_req" class="text-base font-semibold cursor-pointer mb-0">
              Approve/ Reject Share Transfer Request
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shr_sur_req_lis" name="permissions[shr_sur_req_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shr_sur_req_lis" class="text-base font-semibold cursor-pointer mb-0">
               Share Surrender Request List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fix_lon_sms_enb" name="permissions[fix_lon_sms_enb]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shr_sur_req" class="text-base font-semibold cursor-pointer mb-0">
              Approve/ Reject Share Surrender Request
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_cash_fun_trans" name="permissions[apr_cash_fun_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_cash_fun_trans" class="text-base font-semibold cursor-pointer mb-0">
            Approve Cashfree Fund Transfer
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_cf_lt" name="permissions[apr_cf_lt]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_cf_lt" class="text-base font-semibold cursor-pointer mb-0">
            Approve Cashfree Loan Transfer
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_cf_lt2" name="permissions[apr_cf_lt2]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_cf_lt2" class="text-base font-semibold cursor-pointer mb-0">
             Approve Cashfree Loan Transfer
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_win_bft" name="permissions[apr_win_bft" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_win_bft" class="text-base font-semibold cursor-pointer mb-0">
           Approve Within Bank Fund Transfer
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_apr_lis" name="permissions[mem_apr_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_apr_lis" class="text-base font-semibold cursor-pointer mb-0">
         Member Approval List
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_mem_req" name="permissions[apr_rej_mem_req]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_mem_req" class="text-base font-semibold cursor-pointer mb-0">
          Approve/ Reject Member Request

                    </label>
                </div>
            </div>
            
       </div>
    </div>

     <!-----------------Approval History--------------------> 
    <div class="payload-section">
        <div class="mb-3 mt-5 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Approval History</div>
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
                    <input type="checkbox" id="acc_apr_his" 
                    name="permissions[acc_apr_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="acc_apr_his" class="text-base font-semibold cursor-pointer mb-0">
            Accounts Approval History
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="loan_app_apr_his" name="permissions[loan_app_apr_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="loan_app_apr_his" class="text-base font-semibold cursor-pointer mb-0">
             Loan Applications Approval History
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ot_apr_his" 
                    name="permissions[ot_apr_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ot_apr_his" class="text-base font-semibold cursor-pointer mb-0">
                Cash/ Cheque/ Online Transactions Approval History
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="la_cls_rah" name="permissions[la_cls_rah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="la_cls_rah" class="text-base font-semibold cursor-pointer mb-0">
            Loan Account Closure Request Approval History
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cls_req_ah" name="permissions[cls_req_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cls_req_ah" class="text-base font-semibold cursor-pointer mb-0">
                FD/ MIS/ RD/ DD Closure Request Approval History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shr_req_ah"
                     name="permissions[shr_req_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shr_req_ah" class="text-base font-semibold cursor-pointer mb-0">
             Share Transfer Request Approval History
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shr_sur_req_his" name="permissions[shr_sur_req_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shr_sur_req_his" class="text-base font-semibold cursor-pointer mb-0">
               Share Surrender Request Approval History
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cf_ftah" name="permissions[cf_ftah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cf_ftah" class="text-base font-semibold cursor-pointer mb-0">
            Cashfree Fund Transfer Approval History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="lon_ftah" name="permissions[lon_ftah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="lon_ftah" class="text-base font-semibold cursor-pointer mb-0">
            Loan Fund Transfer Approval History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sal_ptah" name="permissions[sal_ptah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sal_ptah" class="text-base font-semibold cursor-pointer mb-0">
          Salary PG Transfer Approval History
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="wbft_ah" name="permissions[wbft_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="wbft_ah" class="text-base font-semibold cursor-pointer mb-0">
             Within Bank Fund Transfer Approval History
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="act_voc_ah" name="permissions[act_voc_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="act_voc_ah" class="text-base font-semibold cursor-pointer mb-0">
          Accounting Voucher Approval History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="pr_ah" name="permissions[pr_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="pr_ah" class="text-base font-semibold cursor-pointer mb-0">
             Print Request Approval History
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_ah" name="permissions[mem_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_ah" class="text-base font-semibold cursor-pointer mb-0">
         Members Approval History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rs_la_ah" name="permissions[rs_la_ah]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rs_la_ah" class="text-base font-semibold cursor-pointer mb-0">
                  RS Loan Account Approval History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="aph_xls_down" name="permissions[aph_xls_down]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="aph_xls_down" class="text-base font-semibold cursor-pointer mb-0">
             Accounts Approval History - xls Download
                    </label>
                </div>
            </div>
           <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="tah_xls_down" name="permissions[tah_xls_down]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="tah_xls_down" class="text-base font-semibold cursor-pointer mb-0">
             Transactions Approval History - xls Download
                    </label>
                </div>
            </div>
            
       </div>
    </div>
     <!-----------------Master Slave Permission--------------------> 
    <div class="payload-section">
        <div class="mb-3 mt-5 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Master Slave Permission</div>
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
                    <input type="checkbox" id="cus_req_ms" 
                    name="permissions[cus_req_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cus_req_ms" class="text-base font-semibold cursor-pointer mb-0">
          Approve/ Reject New Member/ Customer Request Master Slave
                    </label>
                </div>
            </div>

             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="loan_app_apr_his" 
                    name="permissions[loan_app_apr_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="loan_app_apr_his" class="text-base font-semibold cursor-pointer mb-0">
            Approve/ Reject Saving/ FD/ MIS/ RD/ DD Account Request Master Slave
                    </label>
                </div>
            </div>
                   <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cls_req_ms" 
                    name="permissions[cls_req_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cls_req_ms" class="text-base font-semibold cursor-pointer mb-0">
              Approve/ Reject FD/ MIS/ RD/ DD Closure Request Master Slave
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_lar_ms"
                     name="permissions[apr_rej_lar_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_lar_ms" class="text-base font-semibold cursor-pointer mb-0">
            Approve/ Reject Loan Application Request Master Slave
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_nc_ms" 
                    name="permissions[apr_rej_nc_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_nc_ms" class="text-base font-semibold cursor-pointer mb-0">
                Approve/ Reject Non-Compliance Master Slave
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_lcr_ms"
                     name="permissions[apr_rej_lcr_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_lcr_ms" class="text-base font-semibold cursor-pointer mb-0">
            Approve/ Reject Loan Closure Request Master Slave
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_vms" name="permissions[apr_rej_vms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_vms" class="text-base font-semibold cursor-pointer mb-0">
              Approve/ Reject Voucher Master Slave
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_prms" name="permissions[apr_rej_prms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_prms" class="text-base font-semibold cursor-pointer mb-0">
            Approve/ Reject Print Request Master Slave
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ot_ms" name="permissions[ot_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ot_ms" class="text-base font-semibold cursor-pointer mb-0">
           Approve/ Reject Cash/ Cheque/ Online Transaction Master Slave
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_catms" name="permissions[apr_rej_catms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_catms" class="text-base font-semibold cursor-pointer mb-0">
          Approve/ Reject Cash All Transaction Master Slave
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="arp_rej_rtrms" 
                    name="permissions[arp_rej_rtrms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="arp_rej_rtrms" class="text-base font-semibold cursor-pointer mb-0">
             Approve/ Reject Reverse Transaction Request Master Slave
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_rej_strms" name="permissions[apr_rej_strms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_rej_strms" class="text-base font-semibold cursor-pointer mb-0">
        Approve/ Reject Share Transfer Request Master Slave
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sur_req_ms" name="permissions[sur_req_ms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sur_req_ms" class="text-base font-semibold cursor-pointer mb-0">
            Approve/ Reject Share Surrender Request Master Slave
                    </label>
                </div>
            </div>
              <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_cf_ftms" name="permissions[apr_cf_ftms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_cf_ftms" class="text-base font-semibold cursor-pointer mb-0">
        Approve Cashfree Fund Transfer Master Slave

                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="apr_wbf_tms" name="permissions[apr_wbf_tms]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="apr_wbf_tms" class="text-base font-semibold cursor-pointer mb-0">
                  Approve Within Bank Fund Transfer Master Slave
                    </label>
                </div>
            </div>
            
       </div>
    </div>

</div>