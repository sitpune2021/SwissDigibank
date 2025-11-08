<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LockerList extends Model
{
    protected $table = 'locker_lists';

    protected $fillable = [
        'branch_id',
        'locker_no',
        'locker_name',
        'monthly_charges',
        'member_id',
        'assigned',
        'status',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

