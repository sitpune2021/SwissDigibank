<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\CompanyCertificate;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'company_website',
        'company_name',
        'short_name',
        'about_company',

        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',

        'mobile_no',
        'landline_no',
        'contact_email',

        'cin_no',
        'pan_no',
        'tan_no',
        'gst_no',
        
        'iso_certification',
        'bis_certification',
        'pf_number',
        'esic_number',

        'company_category',
        'company_class',
        'incorporation_date',
        'incorporation_state',
        'incorporation_country',

        'authorized_capital',
        'paid_up_capital',
    ];

    // protected $casts = [
    //     'incorporation_date' => 'date',
    // ];

    public function State()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function incorporationState()
    {
        return $this->belongsTo(State::class, 'incorporation_state');
    }

     public function certificate()
    {
        return $this->hasOne(CompanyCertificate::class, 'company_id');
    }
}
