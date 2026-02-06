<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    // Create new API key
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }        // 1. Generate raw key
        $rawKey = 'sk_' . Str::random(40);

        // 2. Store hashed key
        ApiKey::create([
            'name' => $request->name,
            'key' => hash('sha256', $rawKey),
        ]);


        // 3. Return raw key ONCE
        return response()->json([
            'message' => 'API key created. Save it now.',
            'api_key' => $rawKey,
        ], 201);
    }

    // Revoke API key
    public function revoke($id)
    {
        ApiKey::where('id', $id)->update(['active' => false]);

        return response()->json(['message' => 'API key revoked']);
    }
}
