<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboard($user_id, $search = null)
    {
        $tasks = DB::table('sub_task_assignments')
            ->join('sub_tasks', 'sub_tasks.id', '=', 'sub_task_assignments.sub_task_id')
            ->join('tasks', 'tasks.id', '=', 'sub_tasks.task_id')
            ->join('groups', 'groups.id', '=', 'tasks.group_id')
            ->join('users', 'users.id', '=', 'sub_task_assignments.user_id')
            ->where('sub_task_assignments.user_id', $user_id)
            ->when($search, function ($query) use ($search) {
                $query->where('sub_tasks.name', 'like', "%$search%");
            })
            ->select(
                'sub_tasks.id',
                'sub_tasks.name',
                'sub_tasks.status',
                'tasks.title as task_title',
                'groups.name as group_name',
                'tasks.deadline'
            )
            ->get();

        $now = Carbon::now();

        $done = $tasks->where('status', 'done')->count();

        $in_progress = $tasks->where('status', 'in_progress')->count();

        $upcoming = $tasks->filter(function ($task) use ($now) {
            return $task->deadline && $task->deadline > $now;
        })->count();

        $all = $tasks->count();

        $groupTasks = DB::table('group_members')
            ->join('groups', 'groups.id', '=', 'group_members.group_id')
            ->join('tasks', 'tasks.group_id', '=', 'groups.id')
            ->where('group_members.user_id', $user_id)
            ->select(
                'groups.id',
                'groups.name',
                'tasks.title',
                'tasks.deadline'
            )
            ->get()
            ->groupBy('name');

        $user = DB::table('users')
            ->where('id', $user_id)
            ->select('username', 'role')
            ->first();

        return [
            "user" => $user,
            "overview" => [
                "all_tasks" => $all,
                "done" => $done,
                "in_progress" => $in_progress,
                "upcoming" => $upcoming
            ],
            "group_tasks" => $groupTasks,
            // "tasks" => $tasks
        ];
    }
}