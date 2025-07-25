<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;

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
    
}
