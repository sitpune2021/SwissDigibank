<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdMaturityStatement extends Model
{
    use HasFactory;

    protected $table = 'fd_maturity_statements';

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'principal_amount',
        'interest_earned',
        'tds_deducted',
        'net_interest_earned',
        'maturity_bonus_amount',
        'maturity_amount',
        'maturity_date',
        'statement_from',
        'statement_to',
        'currency',
    ];

    // Dates to be treated as Carbon instances
    protected $dates = [
        'maturity_date',
        'statement_from',
        'statement_to',
        'created_at',
        'updated_at',
    ];

    // Relation: A maturity statement belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function interestPeriods()
{
    return $this->hasMany(FdInterestPeriod::class, 'maturity_statement_id');
}

}
