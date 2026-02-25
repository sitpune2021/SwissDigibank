<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicalLoanComment extends Model
{
     use HasFactory;

    protected $table = 'vehical_loan_comments';

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
    public function vehical()
    {
        return $this->belongsTo(
            VehicalDisbursement::class,
            'loan_id'
        );
    }
}
