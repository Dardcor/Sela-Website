<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskGenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskGenerationController extends Controller
{
    public function index(TaskGenerationService $service, int $taskId): JsonResponse
    {
        return response()->json($service->getByTask($taskId));
    }

    public function store(Request $request, TaskGenerationService $service, int $taskId): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => 'required|string',
            'ai_response' => 'nullable|string',
            'model' => 'nullable|string|max:50',
            'version' => 'nullable|integer|min:1',
        ]);

        $validated['task_id'] = $taskId;
        $validated['generated_by'] = auth()->id();

        return response()->json($service->create($validated), 201);
    }

    public function show(TaskGenerationService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function destroy(TaskGenerationService $service, int $id): JsonResponse
    {
        $generation = $service->getById($id);
        $service->delete($generation);

        return response()->json(null, 204);
    }
}
