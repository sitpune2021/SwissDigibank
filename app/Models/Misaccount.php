<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Misaccount extends Model
{

 use SoftDeletes;
    protected $fillable = [
        'member_id',
        'mis_account_no',
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
        'final_amount',
        'transaction_date',
        'mis_joint_date',
        'monthly_interest',
        'total_interest',
        'maturity_amount',
        'maturity_date',

        'foreclose_request_date',
        'foreclose_interest_left',
        'foreclose_tds',
        'foreclose_reverse_interest',

        'foreclose_penal_charges',
        'foreclose_cancellation_charges',

        'foreclose_total_amount',
        'foreclose_rounding',
        'foreclose_final_amount',

        'foreclose_status',

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

    public function comments()
    {
        return $this->hasMany(Comments::class, 'misaccount_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'mis_id');
    }
}
