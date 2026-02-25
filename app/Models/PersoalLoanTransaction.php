<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersoalLoanTransaction extends Model
{
    protected $table = 'personal_loan_transactions';

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

    public function persoalLoanApplication()
{
    return $this->belongsTo(PersonalLoanApplication::class, 'loan_id', 'id');
}
    public function PersoalLoanTransaction()
    { 
        
        return $this->hasMany(PersoalLoanTransaction::class, 'loan_id', 'id');
    }
}
