<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

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
    public function stateData()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
}
