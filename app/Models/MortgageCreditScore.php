<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortgageCreditScore extends Model
{
    use HasFactory;
    protected $table = 'mortgage_loan_credit_scores';

    protected $fillable = [
        'loan_application_id',
        'cibil_type',
        'cibil_score',
        'report_date',
        'report_file_path',
    ];

    
public function application()
{
    return $this->belongsTo(MortgageLoanApplication::class, 'loan_application_id');
}

}
