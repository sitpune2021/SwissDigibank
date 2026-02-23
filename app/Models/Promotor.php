<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\Models\MaritalStatus;
use App\Models\Religion;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PromotorKYC;
use App\Models\PromotorNomine;
use App\Models\Account;
use App\Models\Member;
use App\Models\KycDocument;
use App\Models\ShareHolding;

class Promotor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'enrollment_date',
        'title',
        'gender',
        'first_name',
        'middle_name',
        'last_name',
        'branch_id',
        'member_id',
        'date_of_birth',
        'occupation',
        'father_name',
        'mother_name',
        'marital_statuses_id',
        'religions_id',
        'husband_wife_name',
        'email',
        'mobile',
        'sms',
        'folio_no',
        'active',
        'form15g',
        'is_transfer'
    ];

    protected $casts = [
        'sms' => 'boolean',
        'enrollment_date' => 'date',
        'date_of_birth' => 'date',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_statuses_id');
    }
    public function accounts()
    {
        return $this->hasOne(Account::class, 'member_id', 'id');
    }
    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religions_id');
    }

    public function kyc()
    {
        return $this->hasOne(PromotorKYC::class);
    }

    public function nominees()
    {
        return $this->hasMany(PromotorNomine::class);
    }
    public function minor()
    {
        return $this->hasMany(Minor::class, 'promotor_id');
    }
    public function form15G15H()
    {
        return $this->hasMany(Form15G15H::class, 'promotor_id');
    }
    public function shareholdings()
    {
        return $this->hasMany(Shareholding::class, 'promotor_id');
    }
    public function documents()
    {
        return $this->hasMany(KycDocument::class, 'promoter_id');
    }
    public function latestShare()
    {
        return $this->hasOne(ShareHolding::class, 'promotor_id')->latest();
    }
    public function membershipCharge()
{
    return $this->hasOne(PromotorMembershipCharge::class);
}
}
