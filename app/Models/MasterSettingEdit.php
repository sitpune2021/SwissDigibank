<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSettingEdit extends Model
{  protected $table = 'master_settings_edit'; 
    protected $fillable = [
        'member_playstore_url',
        'member_ios_url',
        'tax_deduction_limit',
        'tax_deduction_limit_senior',
        'membership_fee_enabled',
        'membership_fee',
        'associate_fee_enabled',
        'associate_fee',
        'share_transfer_mode',
        'disable_share_selection',
        'default_shares'
    ];
}
