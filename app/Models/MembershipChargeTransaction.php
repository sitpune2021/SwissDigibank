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
        'type',  // ✅ Make sure this is present
        'approve_status',
        'is_accounted',
        'member_id',
        'transfer_date',
        'online_utr_no',
        'transfer_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'saving_account_id',

    ];

    protected $dates = [
        'transaction_date',
        'transfer_date',
        'cheque_date',
    ];
}
