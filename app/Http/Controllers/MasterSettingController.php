<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterSettingController extends Controller
{
   public function index(){

    return view('master-settings.index');
   }
   public function edit(){
     return view('master-settings.edit');
   }
   public function edit_attendence(){
     return view('master-settings.edit-attendence');
   }
   public function bank_list(){
     return view('master-settings.bank-list');
   }
    public function edit_bussiness_type(){
     return view('master-settings.edit-bussiness-type');
   }
    public function npa_provisioning_settings(){
     return view('master-settings.npa-provisioning-settings');
   }
   public function edit_goldloan_settings(){
     return view('master-settings.edit-goldloan-settings');
   }
   public function edit_personal_loan_settings(){
     return view('master-settings.edit-personal-loan-settings');
   }
    public function edit_deposit_loan(){
     return view('master-settings.edit-deposit-loan');
   }
     public function edit_cc_limit(){
     return view('master-settings.edit-cc-limit');
   }
     public function loan_apr_level_name(){
     return view('master-settings.loan-apr-level-name');
   }
   public function dailycash_deposit(){
     return view('master-settings.dailycash-deposit');
   }
    public function daily_reminder_setting(){
     return view('master-settings.daily-reminder-setting');
   }
    public function edit_rd_settings(){
     return view('master-settings.edit-rd-settings');
   }
   public function edit_dd_settings(){
     return view('master-settings.edit-dd-settings');
   }
    public function edit_bussiness_loan(){
     return view('master-settings.edit-bussiness-loan');
   }
   public function edit_property_loan(){
     return view('master-settings.edit-property-loan');
   }
   public function edit_vehicle_settings(){
     return view('master-settings.edit-vehicle-settings');
   }
    public function edit_daily_weekly_settings(){
     return view('master-settings.edit-daily-weekly-settings');
   }
}

