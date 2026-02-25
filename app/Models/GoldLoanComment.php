<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoldLoanComment extends Model
{
    use HasFactory;

    protected $table = 'gold_loan_comments';

    protected $fillable = [
        'gold_loan_id',
        'date',
        'comment',
        'commented_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationship (Optional)
    public function goldLoan()
    {
        return $this->belongsTo(GoldLoanDisbursement::class, 'gold_loan_id');
    }
}
