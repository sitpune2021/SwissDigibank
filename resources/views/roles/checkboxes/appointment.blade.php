<div class="tab-panel hidden">
    <!----------------Appointments------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Appointments
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
                    <input type="checkbox" id="app_lis" name="permissions[app_lis]" value=""
                        class="form-checkbox item-checkbox  h-5 w-5 text-primary">
                    <label for="app_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Appointments List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dwn_app_xls" name="permissions[dwn_app_xls]" value=""
                        class="form-checkbox item-checkbox  h-5 w-5 text-primary">
                    <label for="dwn_app_xls" class="text-base font-semibold cursor-pointer mb-0">
                        Download Appointments XLS
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="create_new_app" name="permissions[create_new_app]" value=""
                        class="form-checkbox item-checkbox  h-5 w-5 text-primary">
                    <label for="create_new_app" class="text-base font-semibold cursor-pointer mb-0">
                        Create New Appointment
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="destroy_app" name="permissions[destroy_app]" value=""
                        class="form-checkbox item-checkbox  h-5 w-5 text-primary">
                    <label for="destroy_app" class="text-base font-semibold cursor-pointer mb-0">
                        Destroy Appointment
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mark_app_comp" name="permissions[mark_app_comp]" value=""
                        class="form-checkbox item-checkbox  h-5 w-5 text-primary">
                    <label for="mark_app_comp" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Appointment Complete
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_comm_app" name="permissions[add_comm_app]" value=""
                        class="form-checkbox item-checkbox  h-5 w-5 text-primary">
                    <label for="add_comm_app" class="text-base font-semibold cursor-pointer mb-0">
                        Add Comments in Appointment
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>

</div>