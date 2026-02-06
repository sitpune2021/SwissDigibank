<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionCenter extends Model
{
   protected $fillable = [
        'branch_id',
        'center_no',
        'center_name',

        'center_head_member_id',
        'center_head_employee_id',

        'center_cashier_member_id',
        'center_cashier_employee_id',

        'collection_day',
        'collection_time',
        'is_active',
        'latitude',
        'longitude',
        'group_id',
         'address', 
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Center Head
    public function centerHeadMember()
    {
        return $this->belongsTo(Member::class, 'center_head_member_id');
    }

    public function centerHeadEmployee()
    {
        return $this->belongsTo(Employee::class, 'center_head_employee_id');
    }

    // Center Cashier
    public function centerCashierMember()
    {
        return $this->belongsTo(Member::class, 'center_cashier_member_id');
    }

    public function centerCashierEmployee()
    {
        return $this->belongsTo(Employee::class, 'center_cashier_employee_id');
    }
      public function groups()
{
    return $this->hasMany(Group::class, 'collection_center_id');
}

    
}
