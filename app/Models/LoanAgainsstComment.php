<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanAgainsstComment extends Model
{
       use HasFactory;

    protected $table = 'loan_againsst_comments';

    protected $fillable = [
        'loan_id',
        'date',
        'comment',
        'commented_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function loanagainsst()
    {
        return $this->belongsTo(MortgageLoanDisbursement::class, 'loan_id');
    }
}
