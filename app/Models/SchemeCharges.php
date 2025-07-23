<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeCharges extends Model
{
    protected $table="tbl_scheme_charges";
    protected $fillable = [
        'scheme_id','limit','imps_charge','neft_charge','upi_charge'
    ];
}
