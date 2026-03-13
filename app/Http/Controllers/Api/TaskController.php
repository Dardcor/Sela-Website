<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function getByUser($user_id, TaskService $service)
    {
        $tasks = $service->getTasksByUser($user_id);

        return response()->json([
            "tasks" => $tasks
        ]);
    }

    public function detail($task_id, $user_id, TaskService $service)
    {
        $data = $service->getTaskDetail($task_id, $user_id);

        return response()->json($data);
    }
    public function store(Request $request, TaskService $service)
    {

        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'group_id' => 'required|exists:groups,id',
            'link' => 'nullable|url',
            'file' => 'nullable|file|max:5120'
        ]);

        $task = $service->createTask($request);

        return response()->json([
            "message" => "Task created successfully",
            "data" => $task
        ], 201);
    }
}
