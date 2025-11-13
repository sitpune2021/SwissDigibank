<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TabController extends Controller
{
    public function getTabs()
    {
        // Fetch all tabs from config file
        $tabs = config('tabs.tabs');

        return response()->json([
            'status' => true,
            'message' => 'Tabs fetched successfully.',
            'data' => $tabs
        ], 200);
    }

    public function getSeeMoreTabs()
    {
        // Fetch only 'see_more' section dynamically
        $seeMore = config('tabs.tabs.see_more');

        return response()->json([
            'status' => true,
            'message' => 'See More tabs fetched successfully.',
            'data' => $seeMore
        ], 200);
    }
}
