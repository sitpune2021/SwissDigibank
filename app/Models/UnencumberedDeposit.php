<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnencumberedDeposit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bank_id',
        'fd_amount',
        'fd_no',
        'open_date',
        'annual_interest_rate',
        'maturity_date',
        'receipt_scan_copy',
        'fd_from_deposit_money'
    ];

    protected $casts = [
        'open_date' => 'date',
        'maturity_date' => 'date',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
