<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MisTransaction extends Model
{
     use HasFactory;

    protected $fillable = [
        'misaccount_id',
        'amount',
        'pay_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'credited',
        'saving_account_id',
    ];

    public function misaccount()
    {
        return $this->belongsTo(MisAccount::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function savingAccount()
    {
         return $this->belongsTo(Account::class);
    }
}
