<div class="tab-panel hidden">
    <!-----------------Beneficiaries------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Beneficiaries</div>
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
                    <input type="checkbox" id="wib_ben_lis" name="permissions[wib_ben_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="wib_ben_lis" class="text-base font-semibold cursor-pointer mb-0">
                       With In Bank Beneficiary List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_ben_info" name="permissions[shw_ben_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_ben_info" class="text-base font-semibold cursor-pointer mb-0">
                     Show Beneficiary Info
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!-----------------Fund Transfer Histories------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
           Fund Transfer Histories
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
                    <input type="checkbox" id="new_fund_wit_bank" name="permissions[new_fund_wit_bank]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="new_fund_wit_bank" class="text-base font-semibold cursor-pointer mb-0">
                     New Fund Transfer Within Bank
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="wib_fth" name="permissions[wib_fth]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="wib_fth" class="text-base font-semibold cursor-pointer mb-0">
                 With In Bank Fund Transfer History
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_trans_info" name="permissions[shw_trans_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_trans_info" class="text-base font-semibold cursor-pointer mb-0">
                   Show Transfer Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mul_wit_acc_trans" name="permissions[mul_wit_acc_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mul_wit_acc_trans" class="text-base font-semibold cursor-pointer mb-0">
                 Multiple With In Accounts Transfer
                    </label>
                </div>
            </div>
             <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mul_acc_trans_auto_apr" name="permissions[mul_acc_trans_auto_apr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mul_acc_trans_auto_apr" class="text-base font-semibold cursor-pointer mb-0">
               Multiple With In Accounts Transfer - Auto Approve
                    </label>
                </div>
            </div>
            
        </div>
    </div>
    <br>
</div>