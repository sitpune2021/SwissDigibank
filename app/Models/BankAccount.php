<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;

    protected $table = 'bank_account';

    protected $fillable = [
        'bank_id',
        'account_id',
        'branch_id',
        'account_open_date',
        'account_no',
        'ifsc_code',
        'account_type',
        'address',
        'account_active',
        'use_for_printing',
        'accounting_bank',
    ];

    protected $casts = [
        'account_active' => 'boolean',
        'use_for_printing' => 'boolean',
        'accounting_bank' => 'boolean',
        'account_open_date' => 'date',
    ];

    // Relationships
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
 
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
