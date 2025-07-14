<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotor extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch',
        'enrollment_date',
        'title',
        'gender',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'occupation',
        'father_name',
        'mother_name',
        'marital_status',
        'member_religion',
        'husband_wife_name',
        'email',
        'mobile',
        'aadhaar_no',
        'voter_id_no',
        'pan_no',
        'ration_card_no',
        'meter_no',
        'ci_no',
        'ci_relation',
        'dl_no',
        'nominee_name',
        'nominee_relation',
        'nominee_mobile_no',
        'nominee_aadhaar_no',
        'nominee_voter_id_no',
        'nominee_pan_no',
        'nominee_address',
        'sms',
    ];
    public function MaritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status', 'id');
    }
    public function Religion()
    {
        return $this->belongsTo(Religion::class, 'member_religion', 'id');
    }
}
