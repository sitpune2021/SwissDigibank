<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
    
     
    
}
