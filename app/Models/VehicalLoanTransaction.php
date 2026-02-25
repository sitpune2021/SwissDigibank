<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicalLoanTransaction extends Model
{
    protected $table = 'vehical_loan_transactions';

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
        'credited_to_company'
    ];

    public function vehicalapplication()
{
    return $this->belongsTo(VehicalApplication::class, 'loan_id', 'id');
}
    public function VehicalLoanTransaction()
    {
        
        return $this->hasMany(VehicalLoanTransaction::class, 'loan_id', 'id');
    }
}
