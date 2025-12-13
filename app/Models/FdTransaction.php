<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class FdTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'fd_transactions';

    protected $fillable = [
        'fd_account_id',
        'transaction_date',
        'transaction_type',
        'paid_on',
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
        'processed',
        'status',
        'due_date',
        'transaction_purpose',

    ];

  

    public function fdAccount()
    {
        return $this->belongsTo(FdAccount::class, 'fd_account_id');
    }

    public function getFinalStatusAttribute()
    {
        $fdStatus = $this->fdAccount->status;

        // FD Approved OR Fore-close Approved
        if ($fdStatus == 1) {
            return 'approved';
        }

        if ($fdStatus == 0) {
            return 'pending';
        }

        return 'rejected';
    }
}
