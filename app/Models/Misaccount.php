<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Misaccount extends Model
{
    protected $fillable = [
        'member_id',
        'member_name',
        'member_address',
        'member_mobile',
        'minor_id',
        'branch_id',
        'fd_scheme_id',
        'advisor_id',
        'open_date',
        'tenure_year',
        'tenure_month',
        'tenure_day',
        'mis_amount',
        'interest_payout_type',
        'tds_deduction',
        'senior_citizen',
        'account_type',
        'joint_member_id',
        'nominee',
        'final_amount',
        'transaction_date',

        'monthly_interest',
        'total_interest',
        'maturity_amount',
        'maturity_date',
    ];


    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function transactions()
    {
        return $this->hasMany(MisTransaction::class, 'misaccount_id');
    }

    public function nominees()
    {
        return $this->hasMany(AccountNominee::class, 'account_id');
    }
    public function fdScheme()
    {
        return $this->belongsTo(FDScheme::class, 'fd_scheme_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // protected $appends = ['monthly_dates', 'maturity_date'];

    // // ✅ Computed maturity date
    // public function getMaturityDateAttribute()
    // {
    //     return Carbon::parse($this->open_date)
    //         ->addYears($this->tenure_year ?? 0)
    //         ->addMonths($this->tenure_month ?? 0)
    //         ->addDays($this->tenure_day ?? 0);
    // }

    // // ✅ Computed monthly dates
    // public function getMonthlyDatesAttribute()
    // {
    //     $dates = [];
    //     $current = Carbon::parse($this->open_date);

    //     while ($current < $this->maturity_date) {
    //         $dates[] = [
    //             'from' => $current->copy()->startOfMonth(),
    //             'to' => $current->copy()->endOfMonth(),
    //             'year' => $current->year,
    //             'days_in_month' => $current->daysInMonth,
    //         ];
    //         $current->addMonth();
    //     }

    //     return $dates;
    // }
}
