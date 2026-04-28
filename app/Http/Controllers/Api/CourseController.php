<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            ['id' => 1, 'name' => 'Mathematics'],
            ['id' => 2, 'name' => 'Physics'],
            ['id' => 3, 'name' => 'Computer Science']
        ]);
    }
}
