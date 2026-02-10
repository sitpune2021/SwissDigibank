<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixeLoanDisburments extends Model
{
    // use HasFactory;

    // protected $fillable = [
    //     'loan_application_id',
    //     'disbursal_date',
    //     'emi_date',
    //     'loan_amount',
    //     'processing_fee',
    //     'gst_percent',
    //     'sgst',
    //     'cgst',
    //     'igst',
    //     'processing_fee_total',
    //     'stamp_duty_fee',
    //     'insurance_fee',
    //     'advance_interest',
    //     'final_amount',

    //     'disburse_mode1',
    //     'payment_mode1',
    //     'bank_id1',
    //     'cheque_no1',
    //     'cheque_date1',
    //     'transfer_date1',
    //     'utr_no1',
    //     'transfer_mode1',
    //     'saving_acc1',

    //     'disburse_mode2',
    //     'payment_mode2',
    //     'bank_id2',
    //     'cheque_no2',
    //     'cheque_date2',
    //     'transfer_date2',
    //     'utr_no2',
    //     'transfer_mode2',
    //     'saving_acc2',
    //     'status'
    // ];

    // public function FixedLoanApplication()
    // {
    //     return $this->belongsTo(FixedLoanApplication::class, 'loan_application_id');
    // }


     use SoftDeletes;
     use HasFactory;
    protected $table = 'fixe_loan_disburments';

    protected $fillable = [

        /* ===============================
         |  Core Loan Info
         ===============================*/
        'loan_application_id',
        'disbursal_date',
        'emi_date',
        'loan_amount',

        /* ===============================
         |  Processing Fee
         ===============================*/
        'processing_fee',
        'processing_fee_gst_percent',
        'processing_fee_sgst',
        'processing_fee_cgst',
        'processing_fee_igst',
        'processing_fee_total',
        'processingfee_payment_mode',
        'processing_fee_bank_id',
        'processing_fee_cheque_no',
        'processing_fee_cheque_date',
        'processing_fee_transfer_date',
        'processing_fee_utr_no',
        'processing_fee_transfer_mode',

        /* ===============================
         |  Stamp Duty Fee
         ===============================*/
        'stamp_duty_fee',
        'stamp_gst_percent',
        'stamp_duty_fee_sgst',
        'stamp_duty_fee_cgst',
        'stamp_duty_fee_igst',
        'stamp_duty_total',
        'stamp_duty_fee_payment_mode',
        'stamp_duty_fee_bank_id',
        'stamp_duty_fee_cheque_no',
        'stamp_duty_fee_cheque_date',
        'stamp_duty_fee_transfer_date',
        'stamp_duty_fee_utr_no',
        'stamp_duty_fee_transfer_mode',

        /* ===============================
         |  Insurance Fee
         ===============================*/
        'insurance_fee',
        'insurance_gst_percent',
        'insurance_fee_sgst',
        'insurance_fee_cgst',
        'insurance_fee_igst',
        'insurance_total',
        'insurance_fee_payment_mode',
        'insurance_fee_bank_id',
        'insurance_fee_cheque_no',
        'insurance_fee_cheque_date',
        'insurance_fee_transfer_date',
        'insurance_fee_utr_no',
        'insurance_fee_transfer_mode',

        /* ===============================
         |  Fitness Fee
         ===============================*/
        'fitness_fee',
        'fitness_fee_gst_percent',
        'fitness_fee_sgst',
        'fitness_fee_cgst',
        'fitness_fee_igst',
        'fitness_fee_total',
        'fitness_fee_payment_mode',
        'fitness_fee_bank_id',
        'fitness_fee_cheque_no',
        'fitness_fee_cheque_date',
        'fitness_fee_transfer_date',
        'fitness_fee_utr_no',
        'fitness_fee_transfer_mode',

        /* ===============================
         |  Final Amount
         ===============================*/
        'final_amount',

        /* ===============================
         |  Disbursement Mode 1
         ===============================*/
        'D_mode_1',
        'payment_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'saving',

        /* ===============================
         |  Disbursement Mode 2
         ===============================*/
        'D_mode_2',
        'payment_mode2',
        'bank_id2',
        'cheque_no2',
        'cheque_date2',
        'transfer_date2',
        'utr_no2',
        'transfer_mode2',
        'saving2',
    ];

    /* ===============================
     |  Relationships
     ===============================*/
    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id');
    }
}
