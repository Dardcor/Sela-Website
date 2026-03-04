<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubTaskAssignmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubTaskAssignmentController extends Controller
{
    public function index(SubTaskAssignmentService $service, int $subTaskId): JsonResponse
    {
        return response()->json($service->getBySubTask($subTaskId));
    }

    public function store(Request $request, SubTaskAssignmentService $service, int $subTaskId): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $validated['sub_task_id'] = $subTaskId;

        return response()->json($service->create($validated), 201);
    }

    public function update(Request $request, SubTaskAssignmentService $service, int $id): JsonResponse
    {
        $assignment = $service->getById($id);

        $validated = $request->validate([
            'role' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        return response()->json($service->update($assignment, $validated));
    }

    public function destroy(SubTaskAssignmentService $service, int $id): JsonResponse
    {
        $assignment = $service->getById($id);
        $service->delete($assignment);

        return response()->json(null, 204);
    }
}
