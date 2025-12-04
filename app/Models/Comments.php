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
        'commented_by'
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
}
