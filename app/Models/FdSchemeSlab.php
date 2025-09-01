<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FdSchemeSlab extends Model
{
    protected $table = 'fd_scheme_slabs';

    protected $fillable = [
        'fd_scheme_id',
        'day_from',
        'day_to',
        'interest_rate',
        'sr_citizen_rate',
        'payout_type',
    ];

    /**
     * Relationship: Slab belongs to a Scheme
     */
    public function fdscheme()
    {
        return $this->belongsTo(FdScheme::class, 'fd_scheme_id');
    }
}
