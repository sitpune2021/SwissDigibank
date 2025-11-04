<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingOtherCharge extends Model
{
    protected $fillable = [
        'account_id',
        'charge_type',
        'amount',
        'gst_rate',
        'total_amount',
        'charge_date',
        'remarks',
        'created_by'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
