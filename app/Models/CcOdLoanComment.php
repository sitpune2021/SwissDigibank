<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CcOdLoanComment extends Model
{
     use HasFactory;

    protected $table = 'cc_od_loan_comments';

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
    public function ccod()
    {
        return $this->belongsTo(
            CcOdLoanDisbursment::class,
            'loan_id'
        );
    }
}
