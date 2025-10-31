<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCreditScore extends Model
{
    
    protected $fillable = [
        'loan_application_id',
        'cibil_type',
        'cibil_score',
        'report_date',
        'report_file_path',
    ];

    
public function application()
{
    return $this->belongsTo(PersonalLoanApplication::class, 'loan_application_id');
}

}
