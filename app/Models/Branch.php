<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Member;

class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'branch_code',
        'open_date',
        'ifsc_code',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
        'contact_email',
        'mobile_no',
        'landline_no',
        'gst_no',
        'disable_recharge',
        'disable_neft',
    ];

    protected $casts = [
        'open_date' => 'date',
    ];

    public function State()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function Member()
    {
        return $this->hasMany(Member::class, 'general_branch');
    }
  public function Shareholder()
    {
        return $this->hasMany(Shareholder::class,'general_branch');

    }

    
}
