<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form15G15H extends Model
{
    
    protected $fillable = [
        'member_id',
        'financial_year',
        'form_15_upload',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

}
