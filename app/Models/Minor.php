<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minor extends Model
{
    protected $fillable = [
    'member_id',
    'enrollment_date',
    'title',
    'gender',
    'first_name',
    'last_name',
    'dob',
    'father_name',
    'aadhaar_no',
    'address',
];

public function member()
{
    return $this->belongsTo(Member::class);
}



}
