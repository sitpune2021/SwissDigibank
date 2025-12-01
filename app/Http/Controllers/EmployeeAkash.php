<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeAkash extends Controller
{
    public function index(){
        
        return view("hr-management.employee.index");
    }
    public function view(){
        
        return view("hr-management.employee.view");
    }
    public function create(){
        
        return view("hr-management.employee.create");
    }
     public function view_transactions(){
        
        return view("hr-management.employee.view-transactions");
    }
    public function view_trans(){
        
        return view("hr-management.employee.view-trans-view");
    }
    public function pay_salary(){
        
        return view("hr-management.employee.pay-salary");
    }
     public function salary_settelment(){

        return view("hr-management.employee.salary-settelment");
    }
      public function new_salary(){
        
        return view("hr-management.employee.new-salary");
    }
     public function change_photo(){
        
        return view("hr-management.employee.change-photo");
    }
     public function web_cam(){
        
        return view("hr-management.employee.web-cam");
    }
     public function upload_documents(){
        
        return view("hr-management.employee.upload-documents");
    }
     public function calender(){
        
        return view("hr-management.employee.calender");
    }
      public function discard_employee(){
        
        return view("hr-management.employee.discard-employee");
    }
      public function view_tran(){
        
        return view("hr-management.employee.view-trans");
    }
     public function attendance_index(){
        
        return view("hr-management.attendance.index");
    }
     public function disbursement_index(){
        
        return view("hr-management.salary-disbursement.index");
    }
     
     public function disbursement_view(){
        
        return view("hr-management.salary-disbursement.view");
    }
     public function release_salary(){
        
        return view("hr-management.salary-disbursement.release-salary");
    }
    public function multiple_payout(){
        
        return view("hr-management.salary-disbursement.multiple-payout");
    }
     public function monthly_salaries(){
        
        return view("hr-management.salary-disbursement.monthly-salary");
    }
     public function pay_salaries(){
        
        return view("hr-management.salary-disbursement.pay-salary");
    }

}
