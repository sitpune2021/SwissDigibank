<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdsAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'member_name',
        'member_address',
        'member_mobile',
        'minor_id',
        'branch_id',
        'advisor_id',
        'collection_advisor_id',
        'scheme_id',
        'dd_amount',
        'open_date',
        'tds_deduction',
        'account_type',
        'nominee',
    ];
    protected $casts = [
        'open_date' => 'date',
        'maturity_date' => 'date',
    ];


    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }

    public function minor()
    {
        return $this->belongsTo(Member::class, 'minor_id'); // minors सुद्धा members table मध्ये आहेत
    }

    // ✅ One Account has many Transactions
    public function transactions()
    {
        return $this->hasMany(DdTransaction::class, 'dds_account_id'); // <--- fix here
    }
}
