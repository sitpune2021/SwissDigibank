<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeCharge extends Model
{
    protected $fillable = [
        'scheme_id',
        'limit',
        'imps_charge',
        'neft_charge',
        'upi_charge'
    ];
}
