<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rdscheme extends Model
{
   
    protected $table = 'rdschemes';

    protected $fillable = [
        'scheme_name',
        'scheme_code',
        'min_rd_dd_amount',
        'rd_dd_frequency',
        'anuual_interest_rate',
        'sr_citizen_add_on_interest_rate',
        'bonus_rate_type',
        'bonus_rate_value',
        'interest_compounding_interval',
        'rd_dd_lock_in_period',
        'interest_lock_in_period',
        'tenure_of_rd_dd_type',
        'tenure_of_rd_dd_value',
        'cancellation_charges_type',
        'cancellation_charges_value',
        'stationary_charges',
        'penalty_charges_type',
        'penalty_charges_value',
        'penal_charges',
        'app_type_admin',
        'app_type_associate',
        'app_type_member',
        'active',
         'commission_chart',
    ];
}
