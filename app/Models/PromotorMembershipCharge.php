<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotorMembershipCharge extends Model
{
     protected $fillable = [
        'promotor_id',
        'transaction_date',
        'amount',
        'gst_rate',
        'total_amount',
        'net_fee',
        'remarks',
        'pay_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'credited'
    ];
}

