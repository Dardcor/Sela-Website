<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = SchoolClass::select('id', 'name')
            ->orderBy('name')
            ->get();
        return response()->json($classes);
    }
}
