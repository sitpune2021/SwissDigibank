<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessLoanComment extends Model
{
     use HasFactory;

    protected $table = 'business_loan_comments';

    protected $fillable = [
        'loan_id',
        'date',
        'commented_by',
        'comment',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relationship: Comment belongs to Business Loan Disbursement
     */
    public function disbursement()
    {
        return $this->belongsTo(
            BusinessLoanDisbursment::class,
            'loan_id'
        );
    }
}
