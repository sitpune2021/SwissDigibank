<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FDScheme extends Model
{
    protected $table="fd_schemes";

    protected $fillable = [
        'scheme_name',
        'scheme_code',
        'min_amount',
        'lock_in_period',
        'interest_lock_in',
        'bonus_rate',
        'bonus_type',
        'cancellation_charge',
        'cancellation_type',
        'penal_charge',
        'effective_date',
        'stationary_fee',
        'admin',
        'associate',
        'member',
        'is_active'
    ];
}
