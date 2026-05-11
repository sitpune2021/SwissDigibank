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
                    <input type="checkbox" id="members_list" name="permissions[members_list]" value=""
                        class="item-checkbox  form-checkbox h-5 w-5 text-primary">
                    <label for="members_list" class="text-base font-semibold cursor-pointer mb-0">
                        Customer List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_mem" name="permissions[add_new_mem]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_mem" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Member
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_member_info" name="permissions[show_member_info]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_member_info" class="text-base font-semibold cursor-pointer mb-0">
                        Show Member Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_mem_info" name="permissions[edit_mem_info]" value=""
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
                    <input type="checkbox" id="minors_list" name="permissions[minors_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="minors_list" class="text-base font-semibold cursor-pointer mb-0">
                        Minors List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_minor" name="permissions[add_minor]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_minor" class="text-base font-semibold cursor-pointer mb-0">
                        Add Minor
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_min" name="permissions[show_min]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_min" class="text-base font-semibold cursor-pointer mb-0">
                        Show Minor
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_min" name="permissions[edit_min]" value=""
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
                    <input type="checkbox" id="com_mem_sha_lis" name="permissions[com_mem_sha_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="com_mem_sha_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Company Customer's Share Holdings List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="all_new_shar" name="permissions[all_new_shar]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="all_new_shar" class="text-base font-semibold cursor-pointer mb-0">
                        Allocate/ Transfer New Shares to Customer
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_sha_hol" name="permissions[edit_sha_hol]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_sha_hol" class="text-base font-semibold cursor-pointer mb-0">
                        Edit/ Update Share Holding
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_rem_share_hol" name="permissions[del_rem_share_hol]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_rem_share_hol" class="text-base font-semibold cursor-pointer mb-0">
                        Delete/ Remove Share Holding
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
                    <input type="checkbox" id="form_g_h_lis" name="permissions[form_g_h_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="form_g_h_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Form 15G/ 15H List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_g_h_lis" name="permissions[show_g_h_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_g_h_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Show Form 15G/ 15H Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_form_g_h" name="permissions[edit_form_g_h]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_form_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Form 15G/ 15H
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_form_g_h" name="permissions[del_form_g_h]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_form_g_h" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Form 15G/ 15H
                    </label>
                </div>
            </div>

        </div>

    </div>

</div>