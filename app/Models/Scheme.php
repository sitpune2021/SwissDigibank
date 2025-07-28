<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SchemeCharge;

class Scheme extends Model
{
      protected $fillable = [
    'scheme_name',
    'scheme_code',
    'min_opening_balance',
    'min_monthly_avg_balance',
    'annual_int_rate',
    'sr_citizen_add_on_int_rate',
    'interest_pay_cycle',
    'lock_in_amount',
    'min_monthly_avg_bal_charge',
    'service_charge_freq',
    'service_charges',
    'sms_charge_freq',
    'sms_charges',
    'free_ifsc_collect_per_month',
    'free_imps_neft_transactions',
    'single_transaction_limit',
    'imps_neft_daily_limit',
    'imps_neft_weekly_limit',
    'imps_neft_monthly_limit',
    'active',
    'app_type',
    'app_type_associate',
    'app_type_member'

  ];
  public function schemeCharges()
  {
    return $this->hasMany(SchemeCharge::class, 'scheme_id');
  }
}
