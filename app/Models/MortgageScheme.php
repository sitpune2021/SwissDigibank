<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortgageScheme extends Model
{
    use HasFactory;

   protected $fillable = [
    'scheme_name',
    'scheme_code',
    'min_loan_amount',
    'max_loan_amount',
    'tenure',
    'annual_interest_rate',
    'processing_fee',
    'stamp_duty_charge',
    'insurance_fee',
    'is_active',
    'gold_loan_setting',
    'max_loan_limit',
    'overdue_interest_rate',
    'penalty_charge',
    'fore_closer_charge',
    'credit_period',
    'sms_charge',
    'fuel_charge',
    'stationary_charge',
    'maintenace_charge',
    'collcetion',
];

    public function applications()
    {
        return $this->hasMany(MortgageLoanApplication::class, 'scheme_id');
    }


}
