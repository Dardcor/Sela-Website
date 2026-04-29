<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            ['id' => 1, 'name' => 'D4 IT A'],
            ['id' => 2, 'name' => 'D4 IT B'],
            ['id' => 3, 'name' => 'D3 IT A']
        ]);
    }
}
