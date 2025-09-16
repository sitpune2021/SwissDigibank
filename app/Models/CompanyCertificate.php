<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;

class CompanyCertificate extends Model
{
    protected $table = 'company_certificates';

    protected $fillable = [
        'company_id',
        'cin_certificate_path',
        'pan_certificate_path',
        'tan_certificate_path',
        'gst_certificate_path',
        'iso_certificate_path',
        'bis_certificate_path',
        'pf_certificate_path',
        'esic_certificate_path',
    ];

    public $timestamps = false; // Add this if the table doesn't have created_at/updated_at

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
