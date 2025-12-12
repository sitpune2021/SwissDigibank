<div class="tab-panel hidden collection-center">
    <!---Devices--->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Devices</div>
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
                    <input type="checkbox" id="dev_lis" name="permissions[dev_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dev_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Device List
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_mac" name="permissions[add_new_mac]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_mac" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Machine
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_msc_det" name="permissions[shw_msc_det]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_msc_det" class="text-base font-semibold cursor-pointer mb-0">
                        Show Machine Details
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edi_up_mac" name="permissions[edi_up_mac]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edi_up_mac" class="text-base font-semibold cursor-pointer mb-0">
                        Edit / Update Machine
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----Machine Collection----->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Machine Collection</div>
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
                    <input type="checkbox" id="col_ent_lis" name="permissions[col_ent_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_ent_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Collection Entry List
                    </label>
                </div>
            </div>


            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sow_mac_file" name="permissions[sow_mac_file]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sow_mac_file" class="text-base font-semibold cursor-pointer mb-0">
                        Download Machine File
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="up_mac_file" name="permissions[up_mac_file]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_mup_mac_filesc_det" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Machine File
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="prs_upl_ent" name="permissions[prs_upl_ent]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="prs_upl_ent" class="text-base font-semibold cursor-pointer mb-0">
                        Process Uploaded Entries
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_col_entry" name="permissions[del_col_entry]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_col_entry" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Collection Entry
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_entry_auto_apr" name="permissions[col_entry_auto_apr]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_entry_auto_apr" class="text-base font-semibold cursor-pointer mb-0">
                        Collection Entry - Auto Approve
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="col_entry_pupe" name="permissions[col_entry_pupe]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="col_entry_pupe" class="text-base font-semibold cursor-pointer mb-0">
                        Collection Entry - Process Uploaded Pending Entries
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>