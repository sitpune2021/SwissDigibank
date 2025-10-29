<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcOdLoanScheme extends Model
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
    'penalty_charge',
    'fore_closer_charge',
];

    public function applications()
    {
        return $this->hasMany(CcOdLoanApplication::class, 'scheme_id');
    }


}
