<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    protected $fillable = [
        'membership_type',
        'general_advisor_staff',
        'general_group',
        'general_branch',
        'general_enrollment_date',
        'member_info_title',
        'folio_no',
        'member_info_gender',
        'member_info_first_name',
        'member_info_middle_name',
        'member_info_last_name',
        'member_info_dob',
        'member_info_qualification',
        'member_info_occupation',
        'member_info_monthly_income',
        'member_info_old_member_no',
        'member_info_father_name',
        'member_info_mother_name',
        'member_info_spouse_name',
        'member_info_spouse_dob',
        'member_info_mobile_no',
        'member_info_collection_time',
        'member_info_marital_status',
        'member_info_religion',
        'member_info_email'
    ];
    //   protected $casts = [
    //     'general_enrollment_date' => 'date',
    // ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
    public function kyc(): HasOne
    {
        return $this->hasOne(KycAndNominee::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'general_branch');
    }
    public function minors()
    {
        return $this->hasMany(Minor::class, 'member_id', 'id');
    }
    public function Shareholder()
    {
        return $this->hasMany(Shareholders::class, 'member_id');
    }
    public function accounts()
    {
        return $this->hasMany(Account::class, 'member_id');
    }
    public function schemes()
    {
        return $this->belongsToMany(Scheme::class, 'account_scheme', 'member_id', 'scheme_id');
    }
    public function ShareCertificate()
    {
        return $this->hasMany(ShareCertificate::class, 'member_id');
    }
    public function form15G15H()
    {
        return $this->hasMany(Form15G15H::class, 'member_id');
    }
}
