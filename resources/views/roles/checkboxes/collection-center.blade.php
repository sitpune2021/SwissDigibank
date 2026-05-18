<div">

<!----------------- Collection Centers --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Collection Centers</div>
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
                    <input type="checkbox" id="coll_list" name="permissions[]" value="collection-centers.index"
                        class="form-checkbox item-checkbox h-5 w-5 text-primary">
                    <label for="coll_list" class="text-base font-semibold cursor-pointer mb-0">
                      Collection Center List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_coll_center" name="permissions[]" value="collection-centers.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_coll_center" class="text-base font-semibold cursor-pointer mb-0">
                        Add Collection Center
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_coll_center" name="permissions[]" value="collection-centers.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_coll_center" class="text-base font-semibold cursor-pointer mb-0">
                        Show Collection Center
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_coll_center" name="permissions[]" value="collection-centers.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_coll_center" class="text-base font-semibold cursor-pointer mb-0">
                       Edit Collection Center
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
<!----------------- Member Groups --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Member Groups</div>
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
                    <input type="checkbox" id="groups_index" name="permissions[]" value="groups.index" class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="g_list" class="text-base font-semibold cursor-pointer mb-0">
                      Group List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_group" name="permissions[]" value="groups.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_group" class="text-base font-semibold cursor-pointer mb-0">
                        Add Group
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_group" name="permissions[]" value="groups.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_group" class="text-base font-semibold cursor-pointer mb-0">
                        Show Group
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_group" name="permissions[]" value="groups.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_group" class="text-base font-semibold cursor-pointer mb-0">
                      Edit Group
                    </label>
                </div>
            </div>

        </div>
    </div>
    
</div>