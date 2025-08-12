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
    'promotor_id',
    'dob',
    'father_name',
    'aadhaar_no',
    'address',
];

public function member()
{
    return $this->belongsTo(Member::class, 'member_id', 'id');
}
public function promotor()
    {
        return $this->belongsTo(Promotor::class, 'promotor_id');
    }



}
