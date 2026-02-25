<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MortgageLoanComment extends Model
{
    use HasFactory;

    protected $table = 'mortgage_loan_comments';

    protected $fillable = [
        'mortgage_loan_id',
        'date',
        'comment',
        'commented_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function mortgageLoan()
    {
        return $this->belongsTo(MortgageLoanDisbursement::class, 'mortgage_loan_id');
    }
}
