<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyWeeklyLoanComment extends Model
{
         use HasFactory;

    protected $table = 'daily_weekly_loan_comments';

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
    public function dailyweekly()
    {
        return $this->belongsTo(
            DailyWeeklyDisburment::class,
            'loan_id'
        );
    }
}
