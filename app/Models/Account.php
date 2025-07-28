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
        'member_address_line_1'
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
}
