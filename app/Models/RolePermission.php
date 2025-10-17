<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'role_permissions';
    protected $fillable = ['role_id', 'role_position', 'permission_type', 'active', 'permissions'];

    protected $casts = [
        'permissions' => 'array', // automatically cast JSON to array
    ];
}
