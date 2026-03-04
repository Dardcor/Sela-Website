<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    public function index(SubTaskService $service, int $taskId): JsonResponse
    {
        return response()->json($service->getByTask($taskId));
    }

    public function store(Request $request, SubTaskService $service, int $taskId): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'required_ability_id' => 'nullable|exists:abilities,id',
            'generation_id' => 'nullable|exists:task_generations,id',
            'status' => 'nullable|string',
        ]);

        $validated['task_id'] = $taskId;

        return response()->json($service->create($validated), 201);
    }

    public function show(SubTaskService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function update(Request $request, SubTaskService $service, int $id): JsonResponse
    {
        $subTask = $service->getById($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'description' => 'nullable|string',
            'required_ability_id' => 'nullable|exists:abilities,id',
            'generation_id' => 'nullable|exists:task_generations,id',
            'status' => 'nullable|string',
        ]);

        return response()->json($service->update($subTask, $validated));
    }

    public function destroy(SubTaskService $service, int $id): JsonResponse
    {
        $subTask = $service->getById($id);
        $service->delete($subTask);

        return response()->json(null, 204);
    }
}
