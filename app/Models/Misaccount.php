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
        'mis_joint_date',
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

   public function misnominees()
{
    return $this->hasMany(MisaccountNominee::class, 'mis_account_id'); // 👈 fix
}


    public function fdScheme()
    {
        return $this->belongsTo(FDScheme::class, 'fd_scheme_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

   
}
