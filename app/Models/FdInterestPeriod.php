<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdInterestPeriod extends Model
{
    use HasFactory;

    protected $table = 'fd_interest_periods';

    protected $fillable = [
        'maturity_statement_id',
        'period_from',
        'period_to',
        'days',
        'principal',
        'interest',
        'tds',
        'net_interest',
        'cumulative_net_interest',
        'principal_at_eoy',
        'due_by',
        'is_due_date_row',
        'note',
    ];

    protected $casts = [
        'is_due_date_row' => 'boolean',
    ];

    protected $dates = [
        'period_from',
        'period_to',
        'created_at',
        'updated_at',
    ];

    public function maturityStatement()
    {
        return $this->belongsTo(FdMaturityStatement::class, 'maturity_statement_id');
    }
    
}
