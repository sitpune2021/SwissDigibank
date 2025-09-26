<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberOtherCharge extends Model
{
        use SoftDeletes;

    protected $fillable = [
        'member_id',
        'charge_type',
        'transaction_date',
        'charges',
        'remarks',
        // Updated field (renamed from state)
        'status',

        // Clear Dues Details
        'charges_due',
        'waived_amount',
        'gst_rate',
        'total_amount',
        'rounding_off',
        'net_amount',
        'clear_due_remarks',

        // Payment Info
        'pay_mode',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'credited_in_account',
        'bank_id',
        'cheque_no',
        'cheque_date',
    ];
    
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
      public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
