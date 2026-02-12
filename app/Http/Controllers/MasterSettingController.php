<?php

namespace App\Http\Controllers;

use App\Models\MasterSettingEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class MasterSettingController extends Controller
{
   public function index(){
     $setting = MasterSettingEdit::first();
    return view('master-settings.index', compact('setting'));
   }
   public function edit(){
     $setting = MasterSettingEdit::first();
     return view('master-settings.edit',compact('setting'));
   }


public function update(Request $request)
{
    Log::info('Master Settings Update Request Received', [
        'user_id' => auth()->id(),
        'input'   => $request->all()
    ]);
    // dd('controller reached');

    $data = $request->validate([
        'member_playstore_url' => 'nullable|url',
        'member_ios_url'       => 'nullable|url',
        'tax_deduction_limit'  => 'required|numeric',
        'tax_deduction_limit_senior' => 'required|numeric',
        'membership_fee'       => 'nullable|numeric',
        'associate_fee'        => 'nullable|numeric',
        'share_transfer_mode'  => 'required|in:split,allocate',
        'default_shares'       => 'nullable|integer',
    ]);

    Log::info('Validation Passed', $data);

    $data['membership_fee_enabled'] = $request->has('membership_fee_enabled');
    $data['associate_fee_enabled']  = $request->has('associate_fee_enabled');
    $data['disable_share_selection']= $request->has('disable_share_selection');

    Log::info('Checkbox Values Mapped', [
        'membership_fee_enabled' => $data['membership_fee_enabled'],
        'associate_fee_enabled'  => $data['associate_fee_enabled'],
        'disable_share_selection'=> $data['disable_share_selection'],
    ]);
    $record = MasterSettingEdit::first();
// dd($record);
if ($record) {
    $record->update($data);
} else {
    $record = MasterSettingEdit::create($data);
}
;
    // $record = MasterSettingEdit::updateOrCreate(
    //     ['id'=>1],
    //     $data
    // );

    Log::info('Master Settings Saved Successfully', [
        'id' => $record->id,
        'data' => $record->toArray()
    ]);

    return back()->with('success','Settings Updated Successfully');
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

