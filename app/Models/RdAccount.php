<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RdAccount extends Model
{
    protected $table = 'rd_accounts';
    protected $fillable = [
        'member_id',
        'minor_id',
        'branch_id',
        'advisor_staff',
        'collection_advisor_staff',
        'scheme',
        'rd_amount',
        'open_date',
        'tds',
        'account_type',
        'payment_mode',

        'maturity_date',
        'maturity_amount',   // changed from maturity_value
        'principal',         // changed from total_deposit
        'total_interest'
    ];

    public function rdTransactions()
    {
        return $this->hasMany(RdTransactions::class);
    }

    public function nominees()
    {
        return $this->hasMany(AccountNominee::class, 'rd_account_id');
    }


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scheme()
    {
        return $this->belongsTo(Rdscheme::class,'scheme', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function minor()
    {
        return $this->belongsTo(Minor::class);
    }
}
