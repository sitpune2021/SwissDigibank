<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcOdLoanCreditScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'cibil_type',
        'cibil_score',
        'report_date',
        'report_file_path',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(CcOdLoanApplication::class, 'loan_application_id');
    }

}
