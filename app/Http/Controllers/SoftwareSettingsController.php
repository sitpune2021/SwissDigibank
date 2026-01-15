<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoftwareSettingsController extends Controller
{
     public function sms_list()
    {
        return view("software-settings.sms-list");
    }
     public function view_sms_list()
    {
        return view("software-settings.view-sms-list");
    }
     public function edit_sms_setting()
    {
        return view("software-settings.edit-sms-setting");
    }
       public function all_event_list()
    {
        return view("software-settings.event-calender.all-event-list");
    }
    
     public function sms_history()
    {
        return view("software-settings.sms-history");
    }
     public function mail_history()
    {
        return view("software-settings.mail-history");
    }
     public function comment_history()
    {
        return view("software-settings.comment-history");
    }
      public function internet_banking()
    {
          return view("software-settings.internet-banking.internet-banking");
    }
     public function internet_banking_edit()
    {
          return view("software-settings.internet-banking.internet-edit");
    }
      public function account_series_settings()
    {
          return view("software-settings.account-series-settings");
    }
      public function software_alerts()
    {
          return view("software-settings.software-alerts.software-alerts");
    }
      public function update_software_alerts()
    {
          return view("software-settings.software-alerts.update-software-alerts");
    }
     public function form_field_setting()
    {
          return view("software-settings.form-field-setting");
    }
    
     public function gold_rate_calender()
    {
          return view("software-settings.gold-rate-calender");
    }
      public function deleted_entry_log()
    {
          return view("software-settings.deleted-logs.deleted-entry-log");
    }
     public function deleted_entry_log_view()
    {
          return view("software-settings.deleted-logs.deleted-entry-log-view");
    }
      public function login_activity()
    {
          return view("software-settings.login-activity");
    }
      public function user_activity_tracking()
    {
          return view("software-settings.user-activity-tracking");
    }
      public function mail_setting()
    {
          return view("software-settings.mail-setting");
    }
      public function edit_mail_setting()
    {
          return view("software-settings.edit-mail-setting");
    }
       public function software_service_agreement()
    {
          return view("software-settings.software-service-agreement");
    }
       public function event_calender()
    {
          return view("software-settings.event-calender.event-calender");
    }
}

