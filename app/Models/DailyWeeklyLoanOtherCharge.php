<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyWeeklyLoanOtherCharge extends Model
{
     protected $table = 'daily_weekly_loan_other_charges';

     protected $fillable = [
        'loan_id',
        'transaction_type',
        'charge_type',
        'amount',
        'charge_date',
        'remarks',
        'status',
        'created_by',
        'updated_by',
    ];

    public function loan()
    {
        return $this->belongsTo(DailyWeeklyApplication::class, 'loan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
