<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FdAccount extends Model
{
    protected $table = 'fd_accounts';
     use SoftDeletes;

    protected $fillable = [
        'member_id',
        'minor_id',
        'branch_id',
        'scheme_id',
        'staff_id',
        'open_date',
        'tenure_year',
        'tenure_month',
        'tenure_days',
        'fd_amount',
        'interest_payout_type',
        'tds_deduction',
        'senior_citizen',
        'account_type',

        // 'nominees',
        'final_amount',
        'transaction_date',
        'pay1_amount',
        'payment_mode',
        'pay1_bank',
        'pay1_cheque_no',
        'pay1_cheque_date',
        'pay1_transfer_date',
        'pay1_transaction_no',
        'pay1_transfer_mode',
        'pay1_credited',
        'pay1_saving_account',

        'monthly_interest',
        'final_amount',
        'maturity_amount',
        'maturity_date',
        'saving_account_id',
        'link_status',

        'foreclose_request_date',
        'foreclose_interest_left',
        'foreclose_tds',
        'foreclose_reverse_interest',

        'foreclose_penal_charges',
        'foreclose_cancellation_charges',

        'foreclose_total_amount',
        'foreclose_rounding',
        'foreclose_final_amount',

        'foreclose_status',


    ];

    protected $dates = ['close_date'];
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function fdscheme()
    {
        return $this->belongsTo(FDScheme::class, 'scheme_id');
    }
    public function nominee()
    {
        return $this->hasMany(AccountNominee::class, 'fd_account_id');
    }
    public function getFinalStatusAttribute()
    {
        if ($this->status == 2) {
            return 'Disapproved';
        }

        if ($this->status == 0) {
            return 'Pending';
        }

        if ($this->status == 1 && $this->active == 0) {
            return 'Closed';
        }

        if ($this->status == 1 && $this->active == 1) {
            return 'Active';
        }

        return '--';
    }
    public function transactions()
    {
        return $this->hasMany(FdTransaction::class, 'fd_account_id');
    }
    public function minor()
    {
        return $this->belongsTo(Minor::class, 'minor_id');
    }
    public function savingAccount()
    {
        return $this->belongsTo(Account::class, 'saving_account_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class, 'fd_account_id');
    }
}
