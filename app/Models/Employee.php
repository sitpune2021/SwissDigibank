<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Promotor;

class Employee extends Model
{

    protected $fillable = [
        'name',
        'designation',
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
        return $this->belongsTo(Promotor::class, 'member_id');
    }
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function payableLedgers()
    {
        return $this->belongsTo(PayableLedger::class, 'payable_ledger_id');
    }
    public function payableExpenses()
    {
        return $this->belongsTo(PayableExpense::class, 'expense_ledger_id');
    }
    public function bloodgroups()
    {
        return $this->belongsTo(PayableExpense::class, 'blood_group');
    }
    public function bankname()
    {
        return $this->belongsTo(Bank::class, 'bank_name');
    }
     public function nominee_relations()
    {
        return $this->belongsTo(Relation::class, 'nominee_relation');
    }


}
