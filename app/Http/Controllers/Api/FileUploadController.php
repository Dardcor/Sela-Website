<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|image|max:5120',
        ]);

        $path = $request->file('file')->store('avatars', 'public');

        return response()->json([
            'message' => 'Avatar uploaded successfully',
            'url' => asset('storage/' . $path),
        ]);
    }

    public function uploadTaskFile(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:20480',
        ]);

        $path = $request->file('file')->store('task-files', 'public');

        return response()->json([
            'message' => 'Task file uploaded successfully',
            'url' => asset('storage/' . $path),
        ]);
    }
}
