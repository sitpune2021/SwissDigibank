<div class="tab-panel hidden">
    <!-----------------Employees------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Employees</div>
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
                    <input type="checkbox" id="emp_list" name="permissions[emp_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_list" class="text-base font-semibold cursor-pointer mb-0">
                        Employee List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emp_lis_down" name="permissions[emp_lis_down]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_lis_down" class="text-base font-semibold cursor-pointer mb-0">
                        Employee List Download
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_new_emp" name="permissions[add_new_emp]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_new_emp" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Employee
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_emp_inf" name="permissions[shw_emp_inf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_emp_inf " class="text-base font-semibold cursor-pointer mb-0">
                        Show Employee Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_emp_inf" name="permissions[edit_emp_inf]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_emp_inf" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Employee Info
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rem_emp_all_det" name="permissions[rem_emp_all_det]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rem_emp_all_det" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Employee & all details
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="upl_emp_photo" name="permissions[upl_emp_photo]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="upl_emp_photo" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Employee Photo
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_emp_inf" name="permissions[upl_webcam_emp_photo]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_emp_inf " class="text-base font-semibold cursor-pointer mb-0">
                        Upload WebCam Employee Photo
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="upl_emp_doc" name="permissions[upl_emp_doc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="upl_emp_doc" class="text-base font-semibold cursor-pointer mb-0">
                        Upload Employee Documents
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="del_emp_doc" name="permissions[del_emp_doc]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="del_emp_doc" class="text-base font-semibold cursor-pointer mb-0">
                        Delete Employee Document
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="dis_emp" name="permissions[dis_emp]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="dis_emp" class="text-base font-semibold cursor-pointer mb-0">
                        Discard Employee
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rej_for_dis_emp" name="permissions[rej_for_dis_emp]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rej_for_dis_emp" class="text-base font-semibold cursor-pointer mb-0">
                        Rejoining for Discard Employee
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="set_emp_sal" name="permissions[set_emp_sal]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="set_emp_sal" class="text-base font-semibold cursor-pointer mb-0">
                        Settle Employee Salary
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emp_trans_list" name="permissions[emp_trans_list]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_trans_list" class="text-base font-semibold cursor-pointer mb-0">
                        Employee Transaction List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_emp_trans" name="permissions[shw_emp_trans]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_emp_trans" class="text-base font-semibold cursor-pointer mb-0">
                        Show Employee Transaction
                    </label>
                </div>
            </div>
        </div>
    </div>

    <br>
    <!-----------------Attendance------------------->

    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Attendance
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
                    <input type="checkbox" id="mark_time_att" name="permissions[mark_time_att]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mark_time_att" class="text-base font-semibold cursor-pointer mb-0">
                        Mark In Time Attendance
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mark_out_ta" name="permissions[mark_out_ta]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mark_out_ta" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Out Time Attendance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="back_date_att_mark" name="permissions[back_date_att_mark]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="back_date_att_mark" class="text-base font-semibold cursor-pointer mb-0">
                        Back Date Attendance Mark
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="edit_atten" name="permissions[edit_atten]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="edit_atten" class="text-base font-semibold cursor-pointer mb-0">
                        Edit Attendance
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="update_att_status" name="permissions[update_att_status]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="update_att_status" class="text-base font-semibold cursor-pointer mb-0">
                        Update Attendance Status
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!----------------Employee Salary------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Employee Salary
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
                    <input type="checkbox" id="emp_sal_nw" name="permissions[emp_sal_nw]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_sal_nw" class="text-base font-semibold cursor-pointer mb-0">
                        Employee Salary - New
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emp_sal_edit" name="permissions[emp_sal_edit]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_sal_edit" class="text-base font-semibold cursor-pointer mb-0">
                        Employee Salary - Edit
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emp_sal_show" name="permissions[emp_sal_show]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_sal_show" class="text-base font-semibold cursor-pointer mb-0">
                        Employee Salary - Show
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mark_clo_for_ns" name="permissions[mark_clo_for_ns]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mark_clo_for_ns" class="text-base font-semibold cursor-pointer mb-0">
                        Mark Close for New Salary
                    </label>
                </div>
            </div>

        </div>
    </div>
    <br>

    <!-----------------Salary Disbursements------------------->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">
                Salary Disbursements
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
                    <input type="checkbox" id="sal_dis_lis" name="permissions[sal_dis_lis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sal_dis_lis" class="text-base font-semibold cursor-pointer mb-0">
                        Salary Disbursement List
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="add_nw_sal_dis" name="permissions[add_nw_sal_dis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="add_nw_sal_dis" class="text-base font-semibold cursor-pointer mb-0">
                        Add New Salary Disbursement
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mul_emp_sal_dis" name="permissions[mul_emp_sal_dis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mul_emp_sal_dis" class="text-base font-semibold cursor-pointer mb-0">
                        Multiple Employee Salary Disbursement
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="shw_sal_dis" name="permissions[shw_sal_dis]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="shw_sal_dis" class="text-base font-semibold cursor-pointer mb-0">
                        Show Salary Disbursement
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="reg_sal_bal_led" name="permissions[reg_sal_bal_led]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="reg_sal_bal_led" class="text-base font-semibold cursor-pointer mb-0">
                        Re Generate Salary Balance Ledger
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="rm_sal_dis_all_det" name="permissions[rm_sal_dis_all_det]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="rm_sal_dis_all_det" class="text-base font-semibold cursor-pointer mb-0">
                        Remove Salary Disbursement & all details
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sal_dis_edit_tds" name="permissions[sal_dis_edit_tds]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sal_dis_edit_tds" class="text-base font-semibold cursor-pointer mb-0">
                        Salary Disbursement - Edit TDS
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sd_edit_emp_tax" name="permissions[sd_edit_emp_tax]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sd_edit_emp_tax" class="text-base font-semibold cursor-pointer mb-0">
                        Salary Disbursement - Edit Employee Professional Tax
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emp_pay_sal" name="permissions[emp_pay_sal]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_pay_sal" class="text-base font-semibold cursor-pointer mb-0">
                        Employee Pay Salary
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="sal_dis_adv_pay" name="permissions[sal_dis_adv_pay]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="sal_dis_adv_pay" class="text-base font-semibold cursor-pointer mb-0">
                        Salary Disbursement - Advance Pay
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="emp_pay_mul_sal_pg" name="permissions[emp_pay_mul_sal_pg]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="emp_pay_mul_sal_pg" class="text-base font-semibold cursor-pointer mb-0">
                        Employee Pay Multiple Salary with PG
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="mon_sal_pay" name="permissions[mon_sal_pay]" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="mon_sal_pay" class="text-base font-semibold cursor-pointer mb-0">
                        Monthly Salary Payable
                    </label>
                </div>
            </div>

        </div>
    </div>


</div>