<div>

<!----------------- Fixed Deposit Schemes --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Deposit Schemes</div>
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
                    <input type="checkbox" id="fd_mis_list"
                     name="permissions[]" value="fd-mis-schemes.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_list" class="text-base font-semibold cursor-pointer mb-0">
                       FD / MIS Scheme List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fd_mis_scheme" 
                    name="permissions[]" value="fd-mis-schemes.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_scheme" class="text-base font-semibold cursor-pointer mb-0">
                      Add New FD / MIS Scheme
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fd_mis_scheme_info" name="permissions[]" value="fd-mis-schemes.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_scheme_info" class="text-base font-semibold cursor-pointer mb-0">
                    Show FD / MIS Scheme Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_fd_mis_scheme_info" 
                    name="permissions[]" value="fd-mis-schemes.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_fd_mis_scheme_info" class="text-base font-semibold cursor-pointer mb-0">
                       Edit FD / MIS Scheme Info
                    </label>
                </div>
            </div>

        </div>
    </div>

    <br>
<!----------------- Fixed Deposit Calculator --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Deposit Calculator</div>
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
                    <input type="checkbox" id="fd_mis_calc" name="permissions[]" value="calculator.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_calc" class="text-base font-semibold cursor-pointer mb-0">
                        FD/ MIS Calculator
                    </label>
                </div>
            </div>         
        </div>
    </div>

    <br>
 <!----------------- Fixed Deposit Accounts --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Fixed Deposit Accounts</div>
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
                    <input type="checkbox" id="fd_mis_acc_list" 
                    name="permissions[]" value="fd-mis-schemes.fd_index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_acc_list" class="text-base font-semibold cursor-pointer mb-0">
                      FD Accounts List
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fd_mis_acc_amt" name="permissions[]" value="fd-mis-schemes.fd_create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_acc_amt" class="text-base font-semibold cursor-pointer mb-0">
                    Open New FD Account
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fd_mis_acc_acc_info" 
                    name="permissions[]" value="fd-mis-schemes.fd_show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_acc_acc_info" class="text-base font-semibold cursor-pointer mb-0">
                       Show FD Account Info
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="ch_up_fd_mis_cm_ch" name="permissions[]" value="misaccount.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_fd_mis_cm_ch" class="text-base font-semibold cursor-pointer mb-0">
                    MIS Account List Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fd_mis_up_acc" name="permissions[]" value="misaccount.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_up_acc" class="text-base font-semibold cursor-pointer mb-0">
                   Add MIS New Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cha_up_mis_branch" name="permissions[]" value="misaccount.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cha_up_mis_branch" class="text-base font-semibold cursor-pointer mb-0">
                  Update MIS Account Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cha_up_mis_agent" name="permissions[]" value="misaccount.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cha_up_mis_agent" class="text-base font-semibold cursor-pointer mb-0">
                  Show MIS Account Info
                    </label>
                </div>
            </div>

       </div>
    </div>

    <br>
<!----------------- MIS Accounts --------------------> 
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">MIS Accounts</div>
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
                    <input type="checkbox" id="ch_up_fd_mis_cm_ch" name="permissions[]" value="misaccount.index"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="ch_up_fd_mis_cm_ch" class="text-base font-semibold cursor-pointer mb-0">
                    MIS Account List Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="fd_mis_up_acc" name="permissions[]" value="misaccount.create"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="fd_mis_up_acc" class="text-base font-semibold cursor-pointer mb-0">
                   Add MIS New Account
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cha_up_mis_branch" name="permissions[]" value="misaccount.edit"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cha_up_mis_branch" class="text-base font-semibold cursor-pointer mb-0">
                  Update MIS Account Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="cha_up_mis_agent" name="permissions[]" value="misaccount.show"
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="cha_up_mis_agent" class="text-base font-semibold cursor-pointer mb-0">
                  Show MIS Account Info
                    </label>
                </div>
            </div>

        </div>
    </div>
    
</div>