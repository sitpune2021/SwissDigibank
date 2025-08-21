<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    protected $fillable = [
        'open_date',
        'amount',
        'interest_payout_type',
        'annual_interest_rate',
        'tenure_year',
        'tenure_month',
        'tenure_day',
        'bonus',
        'tds_deduction',
        'is_senior_citizen',
    ];

    protected $casts = [
        'open_date' => 'date',
        'tds_deduction' => 'boolean',
        'is_senior_citizen' => 'boolean',
    ];
}
