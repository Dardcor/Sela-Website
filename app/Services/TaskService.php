<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskFile;
use App\Models\TaskLink;
use Illuminate\Support\Facades\DB;

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
                'tasks.due_date',
                'tasks.status',
                'tasks.priority',
                'tasks.is_group',
                'groups.name as group_name',
                'groups.id as group_id'
            )
            ->get();

        foreach ($tasks as $task) {
            $total = DB::table('subtasks')
                ->where('task_id', $task->id)
                ->count();

            $progressEntries = DB::table('subtask_progress')
                ->join('subtasks', 'subtasks.id', '=', 'subtask_progress.subtask_id')
                ->where('subtasks.task_id', $task->id)
                ->avg('subtask_progress.progress');

            $task->progress = $total > 0 ? round($progressEntries ?? 0) : 0;
        }

        $personalTasks = DB::table('tasks')
            ->where('created_by', $user_id)
            ->where(function ($q) {
                $q->where('is_group', false)->orWhereNull('group_id');
            })
            ->select(
                'tasks.id',
                'tasks.title',
                'tasks.due_date',
                'tasks.status',
                'tasks.priority',
                'tasks.is_group'
            )
            ->get();

        foreach ($personalTasks as $task) {
            $task->group_name = null;
            $task->group_id = null;
            $task->progress = 0;
        }

        return $tasks->merge($personalTasks)->unique('id')->values();
    }

    public function getTaskDetail($task_id, $user_id)
    {
        $task = DB::table('tasks')
            ->leftJoin('groups', 'groups.id', '=', 'tasks.group_id')
            ->where('tasks.id', $task_id)
            ->select(
                'tasks.id',
                'tasks.title',
                'tasks.description',
                'tasks.category',
                'tasks.subject',
                'tasks.start_date',
                'tasks.due_date',
                'tasks.is_group',
                'tasks.status',
                'tasks.priority',
                'tasks.group_id',
                'groups.name as group_name'
            )
            ->first();

        $subtasks = DB::table('subtasks')
            ->where('task_id', $task_id)
            ->select('id', 'title', 'description', 'created_at')
            ->get();

        foreach ($subtasks as $subtask) {
            $subtask->progress_entries = DB::table('subtask_progress')
                ->join('profiles', 'profiles.id', '=', 'subtask_progress.user_id')
                ->where('subtask_progress.subtask_id', $subtask->id)
                ->select(
                    'subtask_progress.id',
                    'subtask_progress.user_id',
                    'profiles.username',
                    'profiles.full_name',
                    'subtask_progress.progress',
                    'subtask_progress.updated_at'
                )
                ->get();
        }

        $yourProgress = DB::table('subtask_progress')
            ->join('subtasks', 'subtasks.id', '=', 'subtask_progress.subtask_id')
            ->where('subtasks.task_id', $task_id)
            ->where('subtask_progress.user_id', $user_id)
            ->select(
                'subtasks.id',
                'subtasks.title',
                'subtask_progress.progress'
            )
            ->get();

        $members = collect();
        if ($task && $task->group_id) {
            $members = DB::table('group_members')
                ->join('profiles', 'profiles.id', '=', 'group_members.user_id')
                ->where('group_members.group_id', $task->group_id)
                ->select(
                    'profiles.id',
                    'profiles.username',
                    'profiles.full_name'
                )
                ->get();

            foreach ($members as $member) {
                $member->subtasks = DB::table('subtask_progress')
                    ->join('subtasks', 'subtasks.id', '=', 'subtask_progress.subtask_id')
                    ->where('subtasks.task_id', $task_id)
                    ->where('subtask_progress.user_id', $member->id)
                    ->select(
                        'subtasks.title',
                        'subtask_progress.progress'
                    )
                    ->get();
            }
        }

        $links = TaskLink::where('task_id', $task_id)->get();
        $files = TaskFile::where('task_id', $task_id)->get();

        $total = $subtasks->count();
        $avgProgress = $total > 0
            ? round(DB::table('subtask_progress')
                ->join('subtasks', 'subtasks.id', '=', 'subtask_progress.subtask_id')
                ->where('subtasks.task_id', $task_id)
                ->avg('subtask_progress.progress') ?? 0)
            : 0;

        return [
            "task" => [
                "id" => $task->id,
                "title" => $task->title,
                "description" => $task->description,
                "category" => $task->category,
                "subject" => $task->subject,
                "start_date" => $task->start_date,
                "due_date" => $task->due_date,
                "is_group" => $task->is_group,
                "status" => $task->status,
                "priority" => $task->priority,
                "group_name" => $task->group_name,
                "progress" => $avgProgress,
            ],
            "subtasks" => $subtasks,
            "your_progress" => $yourProgress,
            "members_progress" => $members,
            "links" => $links,
            "files" => $files,
        ];
    }

    public function createTask($request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'subject' => $request->subject,
            'start_date' => $request->start_date ?? now(),
            'due_date' => $request->due_date,
            'is_group' => $request->is_group ?? false,
            'group_id' => $request->group_id,
            'created_by' => auth()->id(),
            'status' => $request->status ?? 'To Do',
            'priority' => $request->priority ?? 'Medium',
        ]);

        if ($request->link) {
            TaskLink::create([
                'task_id' => $task->id,
                'url' => $request->link,
                'label' => $request->link_label,
            ]);
        }

        return $task;
    }
}
