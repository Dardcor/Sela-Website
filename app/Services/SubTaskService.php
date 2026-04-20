<?php

namespace App\Services;

use App\Models\Subtask;
use App\Models\SubtaskProgress;

class SubTaskService
{
    public function createSubtask($task_id, $request)
    {
        $subtask = Subtask::create([
            'title' => $request->title,
            'description' => $request->description,
            'task_id' => $task_id,
        ]);

        if ($request->user_id) {
            SubtaskProgress::create([
                'subtask_id' => $subtask->id,
                'user_id' => $request->user_id,
                'progress' => 0,
            ]);
        }

        return $subtask->load('progressEntries');
    }

    public function updateProgress($subtask_id, $user_id, $progress)
    {
        $entry = SubtaskProgress::where('subtask_id', $subtask_id)
            ->where('user_id', $user_id)
            ->first();

        if ($entry) {
            $entry->update(['progress' => $progress]);
        } else {
            $entry = SubtaskProgress::create([
                'subtask_id' => $subtask_id,
                'user_id' => $user_id,
                'progress' => $progress,
            ]);
        }

        return $entry;
    }

    public function delete($subtask_id)
    {
        $subtask = Subtask::findOrFail($subtask_id);
        $subtask->delete();

        return true;
    }
}
