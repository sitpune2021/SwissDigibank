<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Director extends Model
{
        protected $fillable = [
        'designation',
        'member_id',
        'director_name',
        'din_no',
        'appointment_date',
        'resignation_date',
        'signature',
        'authorized_signatory',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'resignation_date' => 'date',
    ];

    // Relationship to Member
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
