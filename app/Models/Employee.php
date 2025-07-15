<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'member_id',
        'branch_id',
        'joining_date',
        'gender',
        'dob',
        'email',
        'mobile_no',
        'address',
        'father_name',
        'pan_no',
        'aadhar_no',
        'blood_group',
        'monthly_salary',
        'location',

        'account_holder',
        'bank_name',
        'account_no',
        'ifsc',

        'nominee_name',
        'nominee_relation',
        'nominee_address',
        'blood_group',
        'nominee_relation',
        'payable_ledger_id',
        'expense_ledger_id',

        'auto_generate',
    ];
    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
