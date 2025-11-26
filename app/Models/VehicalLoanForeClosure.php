<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicalLoanForeClosure extends Model
{
    protected $table = 'vehical_loan_fore_closures';

      protected $fillable = [
        'loan_id',
        'remaining_amount',
        'interest_accrued',
        'overdue_interest',
        'notice_charges',
        'service_charges',
        'other_charges',
        'foreclosure_charges',
        'total_amount_h',
        'rounding_off_i',
        'closure_discount_j',
        'net_amount_k',
        'transaction_date',
        'remarks',
        'payment_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'credited',
        'status'
    ];
}
