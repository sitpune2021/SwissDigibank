<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    protected $fillable = [
        'employee_id',
        'rank',
        'supervisor_id',
        'enrollment_date',
        'first_name',
        'last_name',
        'username',
        'email',
        'mobile',
        'dob',
        'father_name',
        'husband_wife_name',
        'pan',
        'aadhaar',
        'address',
        'back_date_days',
        'role',
        'branch_id',
        'access_type',
        'login_holiday',
        'searchable_accounts',
        'active',
        'nominee_name',
        'nominee_relation',
        'nominee_address',
    ];

    public function supervisor()
    {
        return $this->belongsTo(Associate::class, 'supervisor_id');
    }

}
