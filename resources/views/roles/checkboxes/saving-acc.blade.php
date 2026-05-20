<div>

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
                    <input type="checkbox" id="save_sch_lis" name="permissions[]" value="schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="save_sch_lis" class="text-base font-semibold cursor-pointer mb-0">
                       Saving Schemes List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_sav_sch" name="permissions[]" value="schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_sav_sch" class="text-base font-semibold cursor-pointer mb-0">
                       Add New Saving Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sav_sch_inf" name="permissions[]" value="schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sav_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                      Show Saving Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_sav_sch_inf" name="permissions[]" value="schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_sav_sch_inf" class="text-base font-semibold cursor-pointer mb-0">
                     Edit / Change Saving Scheme Info
                    </label>
                </div>
            </div>
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
                    name="permissions[]" value="accounts.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sav_acc_lis" class="text-base font-semibold cursor-pointer mb-0">
                       Saving Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="op_new_sav_acc" 
                    name="permissions[]" value="accounts.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="op_new_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                        Open New Saving Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_sav_acc" name="permissions[]" value="accounts.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_sav_acc" class="text-base font-semibold cursor-pointer mb-0">
                    Show Saving Account Info
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>

</div>