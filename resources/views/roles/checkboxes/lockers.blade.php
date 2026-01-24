<div class="tab-panel hidden">
    <!-----------------Lockers------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
             Lockers
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
                    <input type="checkbox" id="locker_list" name="permissions[locker_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="locker_list" class="text-base font-semibold cursor-pointer mb-0">
                     Locker List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_locker"
                     name="permissions[add_locker]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_locker" class="text-base font-semibold cursor-pointer mb-0">
                   Add Locker
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_loc" name="permissions[edit_loc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_loc" class="text-base font-semibold cursor-pointer mb-0">
                    Edit Locker
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="locker_assign" name="permissions[locker_assign]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="locker_assign" class="text-base font-semibold cursor-pointer mb-0">
                 Locker Assign
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="locker_release" name="permissions[locker_release]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="locker_release" class="text-base font-semibold cursor-pointer mb-0">
                   Locker Release
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mem_loc_list_show" name="permissions[mem_loc_list_show]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mem_loc_list_show" class="text-base font-semibold cursor-pointer mb-0">
                     Member Lockers List / Show
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>  