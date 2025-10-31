<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldLoanTransaction extends Model
{
    protected $fillable = [
        'loan_id',
        'transaction_date',
        'current_debt',
        'other_charges',
        'total_payable',
        'amount_collected',
        'remarks',
        'created_by',
    ];

   
}
