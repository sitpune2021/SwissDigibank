<div class="tab-panel hidden">
    <!----------------Member Inquiries------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Member Inquiries
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
                    <input type="checkbox" id="inq_lis" name="permissions[inq_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="inq_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Inquiry Listing
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="show_inq" name="permissions[show_inq]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="show_inq" class="text-base font-semibold cursor-pointer mb-0">
                        Show Inquiry
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="copy_and_create_mem" name="permissions[copy_and_create_mem]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="create_new_app" class="text-base font-semibold cursor-pointer mb-0">
                        Copy & Create Member
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>

</div>