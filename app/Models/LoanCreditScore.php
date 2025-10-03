<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCreditScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'cibil_type',
        'cibil_score',
        'report_date',
        'report_file_path',
    ];

   // app/Models/LoanCreditScore.php
public function loanApplication()
{
    return $this->belongsTo(LoanApplication::class, 'loan_application_id');
}

}
