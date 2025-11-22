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
        'nominee_name',
        'nominee_relation',
        'nominee_address',
        'final_amount',
        'transaction_date',
        'mis_joint_date',
        'monthly_interest',
        'total_interest',
        'maturity_amount',
        'maturity_date',

    ];

    protected $casts = [
        'open_date' => 'date',
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
        return $this->hasMany(AccountNominee::class, 'mis_account_id');
    }


    public function fdScheme()
    {
        return $this->belongsTo(FDScheme::class, 'fd_scheme_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function getFinalStatusAttribute()
    {
        if ($this->status == 2) {
            return 'Disapproved';
        }

        if ($this->status == 0) {
            return 'Pending';
        }

        if ($this->status == 1 && $this->account_status == 0) {
            return 'Closed';
        }

        if ($this->status == 1 && $this->account_status == 1) {
            return 'Active';
        }

        return '--';
    }
}
