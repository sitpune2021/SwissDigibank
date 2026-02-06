<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MufinController extends Controller
{
    public function callBack(Request $request)
    {

        // 1️⃣ Log raw payload (important for debugging)
        Log::info('Payment Callback Received', $request->all());

        // 2️⃣ Validate required fields (example)
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
            'amount' => 'required|numeric',

        ]);

        // 3️⃣ Process data (example)
        // Payment::where('order_id', $request->order_id)
        //        ->update(['status' => $request->status]);

        // 4️⃣ Always return success fast
        return response()->json([
            'message' => 'Callback received'
        ], 200);
    }
}
