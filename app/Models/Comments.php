<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'misaccount_id',
        'date',
        'rd_account_id',
        'comment',
        'commented_by',
        'dds_account_id',
        'fd_account_id'
    ];

    public function misaccount()
    {
        return $this->belongsTo(Misaccount::class, 'id');
    }
    public function rdAccount()
    {
        return $this->belongsTo(RdAccount::class, 'rd_account_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'commented_by', 'id');
    }
     public function ddsaccount()
    {
        return $this->belongsTo(DdsAccount::class, 'dds_account_id');
    }
    public function fdAccount()
    {
        return $this->belongsTo(FdAccount::class, 'fd_account_id');
    }

}
