<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
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

        'company_category',
        'company_class',
        'incorporation_date',
        'incorporation_state',
        'incorporation_country',

        'authorized_capital',
        'paid_up_capital',
    ];
    public function stateData()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
    public function incorporationState()
    {
        return $this->belongsTo(State::class, 'incorporation_state', 'id');
    }
}
