<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcOdLoanDisbursment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'disbursal_date',
        'loan_amount',
        'final_amount',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(CcOdLoanApplication::class, 'loan_application_id');
    }
}
