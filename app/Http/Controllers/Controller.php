<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\UserActivity;   // 👈 yaha import karo

class Controller extends BaseController
{

   
    protected function saveActivity($name, $action, $description = null)
    {
        if (!auth()->check()) {
            return;
        }

        UserActivity::create([
            'user_id' => auth()->id(),
            'activity_name' => $name,
            'activity_action' => $action,
            'ip_address' => request()->ip(),
            'description' => $description,
        ]);
    }

    
}