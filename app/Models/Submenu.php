<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submenu extends Model
{
    protected $fillable = ['menu_id', 'title', 'route'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
