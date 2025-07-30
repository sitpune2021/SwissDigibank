<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_type',
        'account_no',
        'member_id ',
        'advisor_id',
        'member_info_first_name',
        'member_info_middle_name',
        'member_info_last_name',
        'member_address_line_1',
        'branch_id',
        'scheme_id'
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'member_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function schemes()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}
