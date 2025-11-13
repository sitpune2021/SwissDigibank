<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MembershipChargeTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'membership_charges_transaction'; // Use the plural form here

    protected $fillable = [
        'transaction_date',
        'membership_fee',
        'net_fee_to_collect',
        'remarks',
        'charges_pay_mode',
        'type',  
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
        'comment',
        'status',

    ];

    protected $dates = [
        'transaction_date',
        'transfer_date',
        'cheque_date',
        
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'saving_account_id');
    }

    public function members() {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id'); // Ensure 'member_id' is the correct foreign key
    }
}
