<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RdAccount extends Model
{
    protected $table = 'rd_accounts';
    protected $fillable = [
        'member_id',
        'minor_id',
        'branch_id',
        'advisor_staff',
        'collection_advisor_staff',
        'scheme_id',
        'rd_amount',
        'open_date',
        'tds',
        'account_type',
        'payment_mode',

        'maturity_date',
        'maturity_amount',   // changed from maturity_value
        'principal',         // changed from total_deposit
        'total_interest'
    ];

    public function rdTransactions()
    {
        return $this->hasMany(RdTransactions::class);
    }

    public function nominee()
    {
        return $this->hasMany(AccountNominee::class, 'rd_account_id');
    }


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scheme()
    {
        return $this->belongsTo(Rdscheme::class, 'scheme_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function minor()
    {
        return $this->belongsTo(Minor::class);
    }
    public function comments()
    {
        return $this->hasMany(Comments::class, 'rd_account_id');
    }
    public function jointMember()
    {
        return $this->belongsTo(Member::class, 'joint_member_id');
    }
    public function getFinalStatusAttribute()
    {
        if ($this->approve_status == 2) {
            return 'Disapproved';
        }

        if ($this->approve_status == 0) {
            return 'Pending';
        }

        if ($this->approve_status == 1 && $this->status == 0) {
            return 'Closed';
        }

        if ($this->approve_status == 1 && $this->status == 1) {
            return 'Active';
        }

        return '--';
    }
}
