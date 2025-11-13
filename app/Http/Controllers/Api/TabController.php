<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TabController extends Controller
{
    public function getTabs(): JsonResponse
    {
        $tabs = config('tabs_form.main_tabs');

        return response()->json([
            'status' => true,
            'message' => 'All grouped tabs fetched successfully.',
            'data' => $tabs,
        ]);
    }
}
