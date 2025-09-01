<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FDAccount extends Model
{
    protected $table = 'fd_accounts';

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

        'nominees',
        'final_amount',
        'transaction_date',
        'pay1_amount',
        'pay1_mode',
        'pay1_bank',
        'pay1_cheque_no',
        'pay1_cheque_date',
        'pay1_transfer_date',
        'pay1_transaction_no',
        'pay1_transfer_mode',
        'pay1_credited',
        'pay1_saving_account',

    ];

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
   
}
