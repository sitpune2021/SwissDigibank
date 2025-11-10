<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionChart extends Model
{
    protected $fillable = [
    'chart_name',
    'payout_type',
    'commission_type',
    'chart_type',
    'tenure_months',
    'rank_month_values',
];


    protected $casts = [
        'rank_month_values' => 'array',
    ];
}

