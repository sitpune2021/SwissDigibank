<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipChargeTransaction extends Model
{
    protected $table = 'membership_charges_transaction'; // Use the plural form here

    protected $fillable = [
        'transaction_date',
        'membership_fee',
        'net_fee_to_collect',
        'remarks',
        'charges_pay_mode',
        'transfer_date',
        'online_utr_no',
        'transfer_mode',
        'cheque_bank_name',
        'cheque_no',
        'cheque_date',
    ];

    protected $dates = [
        'transaction_date',
        'transfer_date',
        'cheque_date',
    ];
}
