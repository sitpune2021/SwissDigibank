<div class="tab-panel hidden">
    <!-----------------Reports------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
            Reports
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
                    <input type="checkbox" id="agent_busi_rep" name="permissions[agent_busi_rep]" value=""
                        class=" item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="agent_busi_rep" class="text-base font-semibold cursor-pointer mb-0">
                   Agent Business Report
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="branch_business_rep" name="permissions[branch_business_rep]" value=""
                        class=" item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="branch_business_rep" class="text-base font-semibold cursor-pointer mb-0">
                     Branch Business Report
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="maturity_report" name="permissions[maturity_report]" value=""
                        class=" item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="maturity_report" class="text-base font-semibold cursor-pointer mb-0">
                   Maturity Report
                    </label>
                </div>
            </div>
            
        </div>
    </div>

    <br>
    <!----------------Loan Reports------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
             Loan Reports

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

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6 mt-4">

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="loan_report" name="permissions[loan_report]" value=""
                        class=" item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="loan_report" class="text-base font-semibold cursor-pointer mb-0">
               Loan Reports
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>
</div>  