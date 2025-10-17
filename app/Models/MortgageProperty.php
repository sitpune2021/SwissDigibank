<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortgageProperty extends Model
{
    use HasFactory;

    protected $table = 'mortgage_properties';

    protected $fillable = [
    'loan_application_id',
    'property_type',
    'doc_number',
    'registrar_name',
    'owner_name',
    'parent_name',
    'plot_no',
    'tehsil',
    'district',
    'area_sqft',
    'expected_value',
    'registered',
    'boundary_sale_east',
    'boundary_sale_west',
    'boundary_sale_north',
    'boundary_sale_south',
    'boundary_tech_east',
    'boundary_tech_west',
    'boundary_tech_north',
    'boundary_tech_south',
];


    public function loanApplication()
    {
        return $this->belongsTo(MortgageLoanApplication::class, 'loan_application_id');
    }
}
