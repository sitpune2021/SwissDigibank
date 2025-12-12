<div class="tab-panel hidden">
    <!-----------------Transfer Settings------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Transfer Settings</div>
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
                    <input type="checkbox" id="ni_fund_trans_set" name="permissions[ni_fund_trans_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ni_fund_trans_set" class="text-base font-semibold cursor-pointer mb-0">
                        NEFT / IMPS Fund Transfer/ Collection Settings
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ni_fund_coll_set" name="permissions[ni_fund_coll_set]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ni_fund_coll_set" class="text-base font-semibold cursor-pointer mb-0">
                        Set/ Edit NEFT / IMPS Fund Transfer/ Collection Settings
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-----------------Transfer Beneficiaries------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Transfer Beneficiaries
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
                    <input type="checkbox" id="trans_ben_list" name="permissions[trans_ben_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="trans_ben_list" class="text-base font-semibold cursor-pointer mb-0">
                        Transfer Beneficiary List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_trans_ben_inf" name="permissions[shw_trans_ben_inf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_trans_ben_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Transfer Beneficiary Info
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------- Transfer Fund Transfers-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Transfer Fund Transfers
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
                    <input type="checkbox" id="trans_fund_his" name="permissions[trans_fund_his]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="trans_fund_his" class="text-base font-semibold cursor-pointer mb-0">
                        Transfer Fund Transfer History
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mark_trans_ff" name="permissions[mark_trans_ff]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mark_trans_ff" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Transaction Failed Forcefully
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
   

</div>