<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DdsAccountSchemeDetail extends Model
{

    protected $fillable = [
        'dds_account_id',
        'scheme_code',
        'scheme_name',
        'rd_dd_lock_in_period',
        'interest_lock_in_period',
        'anuual_interest_rate',
        'interest_compounding_interval',
        'tenure_of_rd_dd_value',
        'cancellation_charges_value',
        'bonus_rate_value',
        'min_rd_dd_amount',
        'rd_dd_frequency',
        'commission_chart',
    ];

    public function ddsAccount()
    {
        return $this->belongsTo(DdsAccount::class, 'dds_account_id');
    }
}
