<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

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
        'approve_status',
        'comment',
    ];
}
