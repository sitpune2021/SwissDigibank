<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalLoanComment extends Model
{
        use HasFactory;

    protected $table = 'personal_loan_comments';

    protected $fillable = [
        'loan_id',
        'date',
        'comment',
        'commented_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // public function loanagainsst()
    // {
    //     return $this->belongsTo(MortgageLoanDisbursement::class, 'loan_id');
    // }
}
