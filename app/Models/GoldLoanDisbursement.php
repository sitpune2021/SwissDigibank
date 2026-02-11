<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldLoanDisbursement extends Model
{
    use HasFactory;

    protected $table = 'gold_loan_disbursements';

    // mass assignable fields
    protected $fillable = [
        'loan_application_id',
        'disbursal_date',
        'emi_date',
        'loan_amount',
        'processing_fee',
        'gst_percent',
        'sgst',
        'cgst',
        'igst',
        'processing_fee_total',
        'stamp_duty_fee',
        'insurance_fee',
        'advance_interest',
        'final_amount',
        'stamp_duty_total',
        'insurance_total',
        // disbursement modes
        'disburse_mode1',
        'payment_mode1',
        'bank_id1',
        'cheque_no1',
        'cheque_date1',
        'transfer_date1',
        'utr_no1',
        'transfer_mode1',
        'saving_acc1',

        'disburse_mode2',
        'payment_mode2',
        'bank_id2',
        'cheque_no2',
        'cheque_date2',
        'transfer_date2',
        'utr_no2',
        'transfer_mode2',
        'saving_acc2',
    ];
}
