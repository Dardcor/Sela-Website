<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(TaskService $service): JsonResponse
    {
        return response()->json($service->getAll());
    }

    public function store(Request $request, TaskService $service): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'group_id' => 'required|exists:groups,id',
        ]);

        return response()->json($service->create($validated), 201);
    }

    public function show(TaskService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function update(Request $request, TaskService $service, int $id): JsonResponse
    {
        $task = $service->getById($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:150',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'group_id' => 'sometimes|required|exists:groups,id',
        ]);

        return response()->json($service->update($task, $validated));
    }

    public function destroy(TaskService $service, int $id): JsonResponse
    {
        $task = $service->getById($id);
        $service->delete($task);

        return response()->json(null, 204);
    }
}
