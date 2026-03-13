<?php

namespace App\Services;

use App\Models\SubTask;
use App\Models\SubTaskAssignment;

class SubTaskService
{
    public function createSubtask($task_id, $request)
    {

        $subtask = SubTask::create([
            'name' => $request->name,
            'description' => $request->description,
            'task_id' => $task_id,
            'status' => 'pending'
        ]);

        SubTaskAssignment::create([
            'sub_task_id' => $subtask->id,
            'user_id' => $request->user_id,
            'role' => 'assignee',
            'status' => 'assigned'
        ]);

        return $subtask;
    }


    public function updateSubtaskStatus($subtask_id, $status)
    {
        $subtask = SubTask::findOrFail($subtask_id);

        $subtask->update([
            'status' => $status
        ]);

        return $subtask;
    }


    public function delete($subtask_id)
    {
        $subtask = SubTask::findOrFail($subtask_id);

        $subtask->delete();

        return true;
    }
}
