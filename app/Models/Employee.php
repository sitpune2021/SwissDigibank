<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'member', 
        'branch',
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

        'auto_generate',
        'payable_ledger',
        'expense_ledger'
    ];
}
