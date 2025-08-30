<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FdTransaction extends Model
{
    protected $table = 'fd_transactions';

    protected $fillable = [
        'fd_account_id',
        'transaction_date',

        'amount',
        'mode',
        'bank',
        'cheque_no',
        'cheque_date',
        'transfer_date',
        'transaction_no',
        'transfer_mode',
        'credited',
        'saving_account',
    ];

    public function fdAccount()
    {
        return $this->belongsTo(FdAccount::class, 'fd_account_id');
    }
}
