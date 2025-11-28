<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountNominee extends Model
{
    protected $fillable = [
        'account_id',
        'fd_account_id',
        'rd_account_id',
        'dds_account_id',
        'mis_account_id',
        'nominee_name',
        'nominee_relation',
        'nominee_address',
        'share_percentage',
    ];
    public function savingAccount()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function rdAccount()
    {
        return $this->belongsTo(RdAccount::class, 'rd_account_id');
    }

    public function fdAccount()
    {
        return $this->belongsTo(FdAccount::class, 'fd_account_id');
    }

    public function ddsAccount()
    {
        return $this->belongsTo(DdsAccount::class, 'dds_account_id');
    }

    public function misAccount()
    {
        return $this->belongsTo(MisAccount::class, 'mis_account_id');
    }
}
