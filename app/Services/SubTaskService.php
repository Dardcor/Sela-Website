<?php

namespace App\Services;

use App\Models\SubTask;
use Illuminate\Database\Eloquent\Collection;

class SubTaskService
{
    public function getByTask(int $taskId): Collection
    {
        return SubTask::with(['requiredAbility', 'generation'])->where('task_id', $taskId)->get();
    }

    public function getById(int $id): SubTask
    {
        return SubTask::findOrFail($id);
    }

    public function create(array $data): SubTask
    {
        return SubTask::create($data);
    }

    public function update(SubTask $subTask, array $data): SubTask
    {
        $subTask->update($data);
        return $subTask->fresh();
    }

    public function delete(SubTask $subTask): bool
    {
        return $subTask->delete();
    }
}
