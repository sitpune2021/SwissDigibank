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
        'member_id',
        'address_id',
        'branch_id',
        'advisor_id',
        'open_date',
        'amount_deposit',
        'account_holder_type',
        'member_id_one',
        'member_id_two',
        'mode_of_operation',
        'payment_mode',
        'transaction_date',
        'joint_member1',
        'joint_member2',
        'firm_name',
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
    public function minor()
    {
        return $this->belongsTo(Minor::class, 'member_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'member_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function nominee()
    {
        return $this->hasmany(AccountNominee::class, 'account_id');
    }
     public function transaction()
    {
        return $this->hasmany(Transaction::class);
    }
}
