<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DdTransaction extends Model
{
    protected $fillable = [
        'account_id',
        'pay_mode',
        'transaction_date',
        'amount',
        'transfer_date',
        'transfer_mode',
        'utr_no',
        'credited_in_company',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'saving_account_id',
    ];

    public function ddsAccount()
    {
        return $this->belongsTo(DdsAccount::class, 'dds_account_id'); 
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function savingAccount()
    {
        return $this->belongsTo(Account::class, 'saving_account_id');
    }
}
