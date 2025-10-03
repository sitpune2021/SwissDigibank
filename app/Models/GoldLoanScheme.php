<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldLoanScheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheme_name',
        'scheme_code',
        'max_loan_amount',
        'min_loan_amount',
        'max_loan_limit',
        'overdue_interest_rate',
        'tenure',
        'annual_interest_rate',
        'penalty_charge',
        'processing_fee',
        'stamp_duty_charge',
        'insurance_fee',
        'fore_closer_charge',
        'credit_period',
        'gold_loan_setting',
        'charge_floting',
        'sms_charge',
        'fuel_charge',
        'stationary_charge',
        'maintenace_charge',
        'collcetion',
        'from_date',
        'to_date',
        'penal_rate_intererst',
        'annual_rate_interest',
        'is_active'
    ];

    public function applications()
    {
        return $this->hasMany(LoanApplication::class, 'scheme_id');
    }


}
