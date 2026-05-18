<div>
    
    <!----------------- Members -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">CUSTOMER</div>
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
                    <input type="checkbox" id="members_list" name="permissions[]" value="member.index"
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="members_list" class="text-base font-semibold cursor-pointer mb-0">
                        Customer List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_mem" name="permissions[]" value="member.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_mem" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Member
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_member_info" name="permissions[]" value="member.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_member_info" class="text-base font-semibold cursor-pointer mb-0">
                        Show Member Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_mem_info" name="permissions[]" value="member.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_mem_info" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Member Info
                    </label>
                </div>
            </div>

        </div> {{-- grid close --}}
    </div> {{-- payload-section close --}}

    <br>
    <!----------------- Minors -------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Minors</div>
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
                    <input type="checkbox" id="minors_list" name="permissions[]" value="minor.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="minors_list" class="text-base font-semibold cursor-pointer mb-0">
                        Minors List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_minor" name="permissions[]" value="minor.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_minor" class="text-base font-semibold cursor-pointer mb-0">
                        Add Minor
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_min" name="permissions[]" value="minor.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_min" class="text-base font-semibold cursor-pointer mb-0">
                        Show Minor
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_min" name="permissions[]" value="minor.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_min" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Minor
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br> 
    <!-----------------Share Holdings-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Share Holdings
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
                    <input type="checkbox" id="com_mem_sha_lis" name="permissions[]" value="shares-transfer.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="com_mem_sha_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Company Customer's Share Holdings List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="all_new_shar" name="permissions[]" value="shareholding.transfer.form"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="all_new_shar" class="text-base font-semibold cursor-pointer mb-0">
                        Allocate / Transfer New Shares to Customer
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_sha_hol" name="permissions[]" value="shares-transfer.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_sha_hol" class="text-base font-semibold cursor-pointer mb-0">
                        Edit / Update Share Holding
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_rem_share_hol" name="permissions[]" value="shares-transfer.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_rem_share_hol" class="text-base font-semibold cursor-pointer mb-0">
                        Show Share Holding
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shares_transfer_print" name="permissions[]" value="shares-transfer.print"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shares_transfer_print" class="text-base font-semibold cursor-pointer mb-0">
                        Print Share Holding
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
    <!-----------------Form 15g-------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Form 15g</div>
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
                    <input type="checkbox" id="form_g_h_lis" name="permissions[]" value="form15g15h.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="form_g_h_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Form 15G/ 15H List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_g_h_lis" name="permissions[]" value="form15g15h.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_g_h_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Show Form 15G/ 15H Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_form_g_h" name="permissions[]" value="form15g15h.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_form_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Form 15G/ 15H
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_form_g_h" name="permissions[]" value="form15g15h.delete"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_form_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Form 15G/ 15H
                    </label>
                </div>
            </div>

        </div>
    </div>

</div>