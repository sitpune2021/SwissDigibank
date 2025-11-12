<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyWeeklyScheme extends Model
{
    use HasFactory;

   protected $fillable = [
    'scheme_name',
    'scheme_code',
    'min_loan_amount',
    'max_loan_amount',
    'no_of_emi',
    'emi_amount',
    'annual_interest_rate',
    'overdue_type',               
    'overdue_rate',
    'fitness_fee',
    'credit_period',        
    'processing_fee',
    'stamp_duty_charge',
    'insurance_fee',
    'is_active',
    'gold_loan_setting',
    'max_loan_limit',
    'penalty_charge',
    'fore_closer_charge',
    'sms_charge',
    'fuel_charge',
    'stationary_charge',
    'maintenance_charge',
    'collection',
];

    public function applications()
    {
        return $this->hasMany(CcOdLoanApplication::class, 'scheme_id');
    }


}
