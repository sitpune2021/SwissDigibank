<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
        protected $fillable = [
        'member_id', 'member_address_line_1', 'member_address_line_2', 'member_address_para',
        'member_address_ward', 'member_address_panchayat', 'member_address_area',
        'member_address_landmark', 'member_address_city_district', 'member_address_state',
        'member_address_pincode', 'member_address_country', 'member_address_address',
        'member_perm_address_city', 'member_perm_address_state', 'member_perm_address_pincode',
        'member_gps_location_latitude', 'member_gps_location_longitude'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
