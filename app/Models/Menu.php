<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SubMenus;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'icon',
        'route',
        'prefix',
        'position',
        'active',
    ];

    public function submenus(): HasMany
    {
        return $this->hasMany(SubMenus::class);
    }
}
