<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdsAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'member_name',
        'member_address',
        'member_mobile',
        'minor_id',
        'branch_id',
        'advisor_id',
        'collection_advisor_id',
        'scheme_id',
        'dd_amount',
        'rd_dd_frequency',
        'open_date',
        'tds_deduction',
        'account_type',
        'nominee',
        'status',
        'account_id',
    ];
    protected $casts = [
        'open_date' => 'date',
        'maturity_date' => 'date',

    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function minor()
    {
        return $this->belongsTo(Member::class, 'minor_id');
    }

    public function transactions()
    {
        return $this->hasMany(DdTransaction::class, 'dds_account_id');
    }
    public function scheme()
    {
        return $this->belongsTo(Rdscheme::class, 'scheme_id', 'id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function nominee()
    {
        return $this->hasMany(AccountNominee::class, 'dds_account_id');
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
