<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DdTransaction extends Model
{
        use SoftDeletes;

    protected $fillable = [
        'account_id',
        'pay_mode',
        'remarks',
        'transaction_date',
        'balance_available',
        'transfer_date',
        'transfer_mode',
        'utr_no',
        'credited_in_company',
        'bank_id',
        'cheque_no',
        'bank_name',
        'cheque_date',
        'saving_account_id',
        'dds_account_id',
        'collected_by',
        't_receipt',
        'member_sign',
        'member_photo',
        'amount',
        'type',
        
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

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
