<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SupportFileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupportFileController extends Controller
{
    public function index(SupportFileService $service, int $taskId): JsonResponse
    {
        return response()->json($service->getByTask($taskId));
    }

    public function store(Request $request, SupportFileService $service, int $taskId): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $supportFile = $service->upload(
            $request->file('file'),
            $taskId,
            auth()->id()
        );

        return response()->json($supportFile, 201);
    }

    public function show(SupportFileService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function destroy(SupportFileService $service, int $id): JsonResponse
    {
        $file = $service->getById($id);
        $service->delete($file);

        return response()->json(null, 204);
    }
}
