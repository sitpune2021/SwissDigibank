<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    
    protected $table = "transactions";
    protected $fillable = [
        'account_id',
        'payment_mode',
        'transaction_date',
        'transfer_date',
        'utr_number',
        'transfer_mode',
        'credited_in',
        'bank_name',
        'cheque_no',
        'cheque_date',
        'reverse_status'
    ];

    public function accounts()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
