<?php

namespace App\Services;

use App\Models\SupportFile;
use Illuminate\Support\Facades\DB;
use App\Models\Task;

class TaskService
{

    public function getTasksByUser($user_id)
    {

        $tasks = DB::table('group_members')
            ->join('groups', 'groups.id', '=', 'group_members.group_id')
            ->join('tasks', 'tasks.group_id', '=', 'groups.id')
            ->where('group_members.user_id', $user_id)
            ->select(
                'tasks.id',
                'tasks.title',
                'tasks.deadline',
                'groups.name as group_name',
                'groups.id as group_id'
            )
            ->get();

        foreach ($tasks as $task) {

            $total = DB::table('sub_tasks')
                ->where('task_id', $task->id)
                ->count();

            $done = DB::table('sub_tasks')
                ->where('task_id', $task->id)
                ->where('status', 'done')
                ->count();

            $task->progress = $total > 0 ? round(($done / $total) * 100) : 0;
        }

        return $tasks;
    }


    public function getTaskDetail($task_id, $user_id)
    {

        $task = DB::table('tasks')
            ->join('groups', 'groups.id', '=', 'tasks.group_id')
            ->where('tasks.id', $task_id)
            ->select(
                'tasks.id',
                'tasks.title',
                'tasks.description',
                'tasks.deadline',
                'tasks.group_id',
                'groups.name as group_name'
            )
            ->first();

        $total = DB::table('sub_tasks')
            ->where('task_id', $task_id)
            ->count();

        $done = DB::table('sub_tasks')
            ->where('task_id', $task_id)
            ->where('status', 'done')
            ->count();

        $progress = $total > 0 ? round(($done / $total) * 100) : 0;

        $yourProgress = DB::table('sub_task_assignments')
            ->join('sub_tasks', 'sub_tasks.id', '=', 'sub_task_assignments.sub_task_id')
            ->where('sub_tasks.task_id', $task_id)
            ->where('sub_task_assignments.user_id', $user_id)
            ->select(
                'sub_tasks.id',
                'sub_tasks.name',
                'sub_tasks.status'
            )
            ->get();

        $members = DB::table('group_members')
            ->join('users', 'users.id', '=', 'group_members.user_id')
            ->where('group_members.group_id', $task->group_id)
            ->select(
                'users.id',
                'users.username'
            )
            ->get();

        foreach ($members as $member) {

            $member->subtasks = DB::table('sub_task_assignments')
                ->join('sub_tasks', 'sub_tasks.id', '=', 'sub_task_assignments.sub_task_id')
                ->where('sub_tasks.task_id', $task_id)
                ->where('sub_task_assignments.user_id', $member->id)
                ->select(
                    'sub_tasks.name',
                    'sub_tasks.status'
                )
                ->get();
        }

        return [

            "task" => [
                "id" => $task->id,
                "title" => $task->title,
                "description" => $task->description,
                "deadline" => $task->deadline,
                "group_name" => $task->group_name,
                "progress" => $progress
            ],

            "your_progress" => $yourProgress,

            "members_progress" => $members
        ];
    }


    public function createTask($request)
    {

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'group_id' => $request->group_id
        ]);

        /*
    SAVE LINK
    */

        if ($request->link) {

            SupportFile::create([
                'file_name' => 'link',
                'file_path' => $request->link,
                'task_id' => $task->id,
                'uploaded_by' => auth()->id()
            ]);
        }

        /*
    SAVE FILE
    */

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $path = $file->store('support_files', 'public');

            SupportFile::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'task_id' => $task->id,
                'uploaded_by' => auth()->id()
            ]);
        }

        return $task;
    }
}
