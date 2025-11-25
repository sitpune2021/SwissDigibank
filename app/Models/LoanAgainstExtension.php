<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAgainstExtension extends Model
{
     use HasFactory;

     protected $fillable = [
        'loan_id','remaining_amount','interest_reverse','interest_accrued','overdue_total',
        'penalty_amount','penalty_gst','penalty_total','notice_amount','notice_gst','notice_total',
        'service_amount','service_gst','service_total','total_amount_h','rounding_off_i',
        'closure_discount_j','net_amount_k','transaction_date','amount_paid','payment_mode',
        'bank_id','cheque_no','cheque_date','transfer_date','utr_no','transfer_mode','credited',
        'new_principal','reschedule_date','first_emi_date','interest_rate','emi_type','tenure','reason'
    ];

    public function loan(){
        return $this->belongsTo(LoanAgainstApplication::class,'loan_id');
    }
}
