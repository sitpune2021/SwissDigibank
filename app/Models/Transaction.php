<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'account_id',
        'payment_mode',
        'amount',
        'transaction_type',
        'transaction_date',
        'transfer_date',
        'utr_number',
        'transfer_mode',
        'credited_in',
        'bank_name',
        'cheque_no',
        'cheque_date',
        'reverse_status',
        'approve_status',
        'comment',
        'remarks'
    ];

    public function accounts()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
