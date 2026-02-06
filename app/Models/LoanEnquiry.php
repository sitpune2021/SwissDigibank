<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanEnquiry extends Model
{
    protected $table = 'loan_enquiry';
    protected $fillable = [
        'application_no',
        'name',
        'dob',
        'gender',
        'mobile',
        'address',
        'residential_type',
        'occupation_type',
        'monthly_income',
        'scheme_id',
        'loan_amount',
        'tenure_months',
        'interest_rate',
        'margin',
        'credit_account',
        'branch_code',
        'status'
    ];

    public function ornaments()
    {
        return $this->hasMany(LoanOrnamentsEnquiry::class);
    }
      public function scheme()
    {
        return $this->belongsTo(GoldLoanScheme::class, 'scheme_id');
    }
}
