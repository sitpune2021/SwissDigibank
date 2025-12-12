<div class="tab-panel hidden collection-center">
    <!----Passbooks----->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Passbooks</div>
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
                    <input type="checkbox" id="pass_lis" name="permissions[pass_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="pass_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Passbook List
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_pass_inf" name="permissions[shw_pass_inf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_pass_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Show Passbook Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_pass" name="permissions[add_new_pass]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_pass" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Passbook
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_pass" name="permissions[edit_pass]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_pass" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Passbook
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_pass" name="permissions[del_pass]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_pass" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Passbook
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>