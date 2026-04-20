<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubTaskService;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    public function store(Request $request, $task_id, SubTaskService $service)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'user_id' => 'nullable|uuid|exists:profiles,id',
        ]);

        $data = $service->createSubtask($task_id, $request);

        return response()->json([
            "message" => "Subtask created",
            "data" => $data,
        ], 201);
    }

    public function updateProgress(Request $request, $subtask_id, SubTaskService $service)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'user_id' => 'required|uuid|exists:profiles,id',
        ]);

        $data = $service->updateProgress($subtask_id, $request->user_id, $request->progress);

        return response()->json([
            "message" => "Progress updated",
            "data" => $data,
        ]);
    }

    public function destroy($subtask_id, SubTaskService $service)
    {
        $service->delete($subtask_id);

        return response()->json([
            "message" => "Subtask deleted",
        ]);
    }
}
