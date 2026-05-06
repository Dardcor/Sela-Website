<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FcmService;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request, FcmService $service)
    {
        $request->validate([
            'token' => 'required|string',
            'platform' => 'nullable|string'
        ]);

        $service->registerToken($request->user()->id, $request->token, $request->platform ?? 'android');
        
        return response()->json(['message' => 'Token registered successfully']);
    }

    public function destroy(Request $request, FcmService $service)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $service->removeToken($request->token);
        
        return response()->json(['message' => 'Token removed successfully']);
    }
}
