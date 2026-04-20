<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskFile;
use App\Models\TaskLink;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getByUser($user_id, TaskService $service)
    {
        $tasks = $service->getTasksByUser($user_id);

        return response()->json([
            "tasks" => $tasks,
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
            'category' => 'nullable|string',
            'subject' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'is_group' => 'nullable|boolean',
            'group_id' => 'nullable|uuid|exists:groups,id',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'link' => 'nullable|url',
            'link_label' => 'nullable|string',
        ]);

        $task = $service->createTask($request);

        return response()->json([
            "message" => "Task created successfully",
            "data" => $task,
        ], 201);
    }

    public function links($taskId)
    {
        return response()->json(TaskLink::where('task_id', $taskId)->get());
    }

    public function storeLink(Request $request, $taskId)
    {
        $request->validate([
            'url' => 'required|url',
            'label' => 'nullable|string',
        ]);

        $link = TaskLink::create([
            'task_id' => $taskId,
            'url' => $request->url,
            'label' => $request->label,
        ]);

        return response()->json($link, 201);
    }

    public function destroyLink($id)
    {
        $link = TaskLink::findOrFail($id);
        $link->delete();

        return response()->json(null, 204);
    }

    public function files($taskId)
    {
        return response()->json(TaskFile::where('task_id', $taskId)->get());
    }

    public function storeFile(Request $request, $taskId)
    {
        $request->validate([
            'file_name' => 'required|string',
            'file_path' => 'required|string',
            'file_type' => 'nullable|string',
            'file_size' => 'nullable|integer',
        ]);

        $file = TaskFile::create([
            'task_id' => $taskId,
            'file_name' => $request->file_name,
            'file_path' => $request->file_path,
            'file_type' => $request->file_type,
            'file_size' => $request->file_size ?? 0,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json($file, 201);
    }

    public function destroyFile($id)
    {
        $file = TaskFile::findOrFail($id);
        $file->delete();

        return response()->json(null, 204);
    }
}
