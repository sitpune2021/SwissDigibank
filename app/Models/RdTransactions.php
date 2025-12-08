<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RdTransactions extends Model
{

    protected $fillable = [
        'rd_account_id',
        'payment_mode',
        't_date',
        'amount',
        'transaction_type',
        'transfer_date',
        'transaction_no',
        'transfer_mode',
        'credited',
        'cheque_bank_name',
        'cheque_no',
        'installment_no',
        'cheque_date',
        'due_date',
        'remark',
        'approve_status',
        'savings_account',
        'reverse_status',
        'payment_rev_rel',
        'paid_on',
        'print_flag'
    ];

    public function rdaccount()
    {
        return $this->belongsTo(RdAccount::class, 'rd_account_id', 'id');
    }
}
