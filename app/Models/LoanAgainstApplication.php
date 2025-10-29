<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAgainstApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_date',
        'member_id',
        'co_applicant_1_id',
        'co_applicant_2_id',
        'branch_id',
        'advisor_id',
        'securety_type',
        'security_amount',
        'guarantor_1_id',
        'guarantor_2_id',
        'guarantor_3_id',
        'guarantor_4_id',
        'scheme_id',
        'tenure_type',
        'tenure_value',
        'emi_collection',
        'credit_period',
        'loan_amount',
        'insurance_amount',
        'net_loan_amount',
        'purpose_of_loan',
        'processing_fee_value',
        'processing_fee_gst',
        'processing_fee_sgst',
        'processing_fee_cgst',
        'processing_fee_igst',
        'processing_fee_total',
        'fee_mode',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'credited',
        'collect_principal_as_emi',
        'collect_advance_processing_fee',
        'security_value',
        'max_loan_amount',
        'max_loan_limit',
        'maximum_approvable_amount',
        'approved_loan_amount',
        'status',
    ];

    protected $attributes = [
    'model_type' => 'loan_against',
];


public function creditScores()
{
    return $this->hasMany(LoanAgainstCreditScore::class, 'loan_application_id');
}
// LoanApplication.php
public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}
public function coApplicant1()
{
    return $this->belongsTo(Member::class, 'co_applicant_1_id');
}


public function guarantor1()
{
    return $this->belongsTo(Member::class, 'guarantor_1_id');
}

public function guarantor2()
{
    return $this->belongsTo(Member::class, 'guarantor_2_id');
}

public function guarantor3()
{
    return $this->belongsTo(Member::class, 'guarantor_3_id');
}

public function guarantor4()
{
    return $this->belongsTo(Member::class, 'guarantor_4_id');
}


public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}

public function scheme()
{
    return $this->belongsTo(LoanAgainstScheme::class, 'scheme_id');
}



}
