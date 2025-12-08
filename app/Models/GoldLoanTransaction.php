<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldLoanTransaction extends Model
{
    protected $fillable = [
        'loan_id',
        'emi_no',
        'transaction_date',
        'current_debt',
        'other_charges',
        'total_payable',
        'amount_collected',
        'remarks',
        'created_by',
        'status',
        'paid_date',
        'fee_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'utr_no',
        'transfer_mode',
        'transfer_date',
        'credited_to_company'
    ];

    public function goldApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_id');
    }

    public function loan()
    {
        return $this->belongsTo(\App\Models\LoanApplication::class, 'loan_id', 'id');
    }
}
