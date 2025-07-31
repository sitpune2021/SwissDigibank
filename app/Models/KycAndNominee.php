<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycAndNominee extends Model
{
        protected $fillable = [
        'member_id', 'member_kyc_aadhaar_no', 'member_kyc_voter_id_no', 'member_kyc_pan_no',
        'member_kyc_ration_card_no', 'member_kyc_meter_no', 'member_kyc_ci_no',
        'member_kyc_ci_relation', 'member_kyc_dl_no', 'member_kyc_passport_no',
        'member_kyc_photo', 'member_kyc_signature', 'member_kyc_id_proof', 'member_kyc_id_proof_back',
        'member_kyc_address_proof', 'member_kyc_address_proof_back', 'member_kyc_pan_number',
        'nominee_name', 'nominee_relation', 'nominee_mobile_no', 'nominee_gender',
        'nominee_dob', 'nominee_aadhaar_no', 'nominee_voter_id_no', 'nominee_pan_no',
        'nominee_ration_card_no', 'nominee_address', 'extra_sms', 'charges_transaction_date',
        'charges_membership_fee', 'charges_net_fee', 'charges_remarks', 'charges_pay_mode'
    ];

    protected $casts = [
        'charges_transaction_date' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

}
