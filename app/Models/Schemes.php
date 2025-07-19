<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schemes extends Model
{
  protected $fillable = [
        'scheme_name',
        'scheme_code',
        'min_opening_balance',
        'min_monthly_avg_balance',
        'annual_interest_rate',
        'sr_citizen_add_on_interest_rate',
        'interest_payout_cycle',
        'lock_in_amount',
        'min_monthly_avg_balance_charge',
             // 'charge_frequency',
    'service_charges',
    'sms_charges',
    'free_ifsc_collection_per_month',
    'free_imps_neft_transactions',
    'free_transfers_per_month',
    'single_transaction_limit',
    'daily_max_limit',
    'weekly_max_limit',
    'monthly_max_limit',
    // IMPS Charges
    'imps_upto_1000',
    'imps_upto_2500',
    'imps_upto_5000',
    'imps_upto_7500',
    'imps_upto_10000',
    'imps_upto_17500',
    'imps_upto_25000',
    'imps_upto_37500',
    'imps_upto_50000',
    'imps_upto_75000',
    'imps_upto_100000',
    'imps_upto_150000',
    'imps_upto_200000',
    'imps_upto_300000',
    'imps_upto_400000',
    'imps_upto_500000',
    'imps_upto_1000000',

    // NEFT Charges
    'neft_upto_1000',
    'neft_upto_2500',
    'neft_upto_5000',
    'neft_upto_7500',
    'neft_upto_10000',
    'neft_upto_17500',
    'neft_upto_25000',
    'neft_upto_37500',
    'neft_upto_50000',
    'neft_upto_75000',
    'neft_upto_100000',
    'neft_upto_150000',
    'neft_upto_200000',
    'neft_upto_300000',
    'neft_upto_400000',
    'neft_upto_500000',
    'neft_upto_1000000',

    // UPI Charges
    'upi_upto_1000',
    'upi_upto_2500',
    'upi_upto_5000',
    'upi_upto_7500',
    'upi_upto_10000',
    'upi_upto_17500',
    'upi_upto_25000',
    'upi_upto_37500',
    'upi_upto_50000',
    'upi_upto_75000',
    'upi_upto_100000',
    'upi_upto_150000',
    'upi_upto_200000',
    'upi_upto_300000',
    'upi_upto_400000',
    'upi_upto_500000',
    'upi_upto_1000000',

    ];
}
