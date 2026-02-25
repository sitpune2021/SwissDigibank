<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLoanTransaction extends Model
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
        'flag',
        'cheque_no',
        'cheque_date',
        'utr_no',
        'transfer_mode',
        'credited_to_company'
    ];

    public function businessloanApplication()
{
    return $this->belongsTo(BusinessLoanApplication::class, 'loan_id', 'id');
}
    public function BusinessLoanTransaction()
    {
        
        return $this->hasMany(BusinessLoanTransaction::class, 'loan_id', 'id');
    }
}
