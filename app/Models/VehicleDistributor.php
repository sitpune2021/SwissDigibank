<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDistributor extends Model
{
    use HasFactory;

    protected $fillable = [
    'distributor_name',
    'distributor_code',
    'distributor_type',
    'contact_no',
    'email',
    'address',
    'city',
    'state',
    'country',
    'pincode',
    'gst_no',
    'license_no',
    'active',
];

}
