<div class="tab-panel hidden">
<!-----------------Notifications --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Notifications</div>
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
                    <input type="checkbox" id="shw_pay_col_lis"
                     name="permissions[shw_pay_col_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_pay_col_lis" class="text-base font-semibold cursor-pointer mb-0">
              Show Payment Collection List (RD, Loan Installments)
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="clr_nof_pc" 
                    name="permissions[clr_nof_pc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="clr_nof_pc" class="text-base font-semibold cursor-pointer mb-0">
                Clear Notifications for Payment Collections
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sr_fpc" name="permissions[sr_fpc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sr_fpc" class="text-base font-semibold cursor-pointer mb-0">
             Send Reminder For Payment Collections
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sen_pay_pc" 
                    name="permissions[sen_pay_pc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sen_pay_pc" class="text-base font-semibold cursor-pointer mb-0">
                 Send Payment Link For Payment Collections
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>
<!----------------- Single Collection --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
           Single Collection
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
                    <input type="checkbox" id="spc" name="permissions[spc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="spc" class="text-base font-semibold cursor-pointer mb-0">
           Single Payment Collection
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ssw" name="permissions[ssw]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ssw" class="text-base font-semibold cursor-pointer mb-0">
                Single Saving Withdraw
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="spc_rec" name="permissions[spc_rec]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="spc_rec" class="text-base font-semibold cursor-pointer mb-0">
               Single Payment Collection T. Receipt
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Multi Collection-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
           Multi Collection
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
                    <input type="checkbox" id="mul_pay_col" name="permissions[mul_pay_col]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mul_pay_col" class="text-base font-semibold cursor-pointer mb-0">
               Multiple Payment Collection
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mpc_auto_pay" name="permissions[mpc_auto_pay]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mpc_auto_pay                        " class="text-base font-semibold cursor-pointer mb-0">
              Multiple Payment Collection - Auto Approve
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
     <!----------------- Group Collections-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
          Group Collections
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
                    <input type="checkbox" id="gpc" name="permissions[gpc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gpc" class="text-base font-semibold cursor-pointer mb-0">
               Group Payment Collection
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gpc_auto_apr" name="permissions[gpc_auto_apr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gpc_auto_apr" class="text-base font-semibold cursor-pointer mb-0">
           Group Payment Collection - Auto Approve
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
     <!----------------- Agent Group Collection -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
          Agent Group Collection
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
                    <input type="checkbox" id="agpc" name="permissions[agpc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="agpc" class="text-base font-semibold cursor-pointer mb-0">
              Agent Group Payment Collection
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="gpc_ap" name="permissions[gpc_ap]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="gpc_ap" class="text-base font-semibold cursor-pointer mb-0">
            Group Payment Collection - Auto Approve
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
       <!----------------- Multi Debit -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
          Multi Debit
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
                    <input type="checkbox" id="mw" name="permissions[mw]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mw" class="text-base font-semibold cursor-pointer mb-0">
             Multiple Withdraw
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mw_ap" name="permissions[mw_ap]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mw_ap" class="text-base font-semibold cursor-pointer mb-0">
           Multiple Withdraw - Auto Approve
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>