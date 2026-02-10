<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $fillable = [
        'code',
        'display_name',
        'system_name',
        'type',
        'group_id',
        'is_bank_acc',
        'show_in_day',
        'opening_balance'
    ];

    public function group()
    {
        return $this->belongsTo(LedgerGroup::class, 'group_id');
    }
}
