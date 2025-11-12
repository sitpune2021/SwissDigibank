<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldLoanOtherCharge extends Model
{
    use HasFactory;

    protected $table = 'gold_loan_other_charges';

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
        return $this->belongsTo(LoanApplication::class, 'loan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
