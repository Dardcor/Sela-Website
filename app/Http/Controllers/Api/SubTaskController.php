<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubTaskService;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    protected $taskService;

   public function store(Request $request,$task_id,SubTaskService $service)
    {
        $request->validate([
            'name'=>'required|string|max:150',
            'description'=>'nullable|string',
            'user_id'=>'required|exists:users,id'
        ]);

        $data = $service->createSubtask($task_id,$request);

        return response()->json([
            "message"=>"Subtask created",
            "data"=>$data
        ],201);
    }


    public function updateStatus(Request $request,$subtask_id,SubTaskService $service)
    {
        $request->validate([
            'status'=>'required|in:pending,in_progress,done,upcoming'
        ]);

        $data = $service->updateSubtaskStatus($subtask_id,$request->status);

        return response()->json([
            "message"=>"Status updated",
            "data"=>$data
        ]);
    }


    public function destroy($subtask_id,SubTaskService $service)
    {
        $service->delete($subtask_id);

        return response()->json([
            "message"=>"Subtask deleted"
        ]);
    }

}
