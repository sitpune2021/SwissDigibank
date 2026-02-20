<?php

use App\Models\RolePermission;

function hasPermission($routeName)
{
    $user = auth()->user();

    if (!$user) return false;

    // Super Admin bypass
    if ($user->role_id == 1) {
        return true;
    }

    $rolePermission = RolePermission::where('role_id', $user->role_id)
        ->where('active', 'Yes')
        ->first();

    if (!$rolePermission) return false;

    $permissions = $rolePermission->permissions; // already array

    if (!is_array($permissions)) {
        return false;
    }

    return in_array($routeName, $permissions);
    
}