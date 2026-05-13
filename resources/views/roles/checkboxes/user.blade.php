<div>

    <!---------------------------Roles---------------------------->
    <div class="mb-3 payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Roles</div>
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

            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="roles_index" name="permissions[]" value="roles.index"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="roles_index" class="text-base font-semibold cursor-pointer mb-0">Permission/ Role
                        List</label>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="roles_create" name="permissions[]" value="roles.create"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="roles_create" class="text-base font-semibold cursor-pointer mb-0">Add New
                        Permission/
                        Role</label>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="roles_show" name="permissions[]" value="roles.show"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="roles_show" class="text-base font-semibold cursor-pointer mb-0">Show Permission/
                        Role Info</label>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="roles_edit" name="permissions[]" value="roles.edit"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="roles_edit" class="text-base font-semibold cursor-pointer mb-0">Edit Permission/
                        Role Info</label>
                </div>
            </div>

        </div>
    </div>

    <!---------------------------Users---------------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Users</div>
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

            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="users_index" name="permissions[]" value="users.index"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="users_index" class="text-base font-semibold cursor-pointer mb-0">Users List</label>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="users_create" name="permissions[]" value="users.create"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="users_create" class="text-base font-semibold cursor-pointer mb-0">Add Users</label>
                </div>
            </div>           
            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="users_show" name="permissions[]" value="users.show"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="users_show" class="text-base font-semibold cursor-pointer mb-0">
                        Show User
                        Info
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 xxl:gap-2">
                <div class="flex items-center gap-2 col-span-6">
                    <div class="">
                        <input type="checkbox" id="users_edit" name="permissions[]" value="users.edit"
                            class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    </div>
                    <label for="users_edit" class="text-base font-semibold cursor-pointer mb-0">Edit User
                        Info</label>
                </div>
            </div>
            
        </div>
    </div>

</div>