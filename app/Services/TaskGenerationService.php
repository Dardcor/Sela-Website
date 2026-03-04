<?php

namespace App\Services;

use App\Models\TaskGeneration;
use Illuminate\Database\Eloquent\Collection;

class TaskGenerationService
{
    public function getByTask(int $taskId): Collection
    {
        return TaskGeneration::where('task_id', $taskId)->get();
    }

    public function getById(int $id): TaskGeneration
    {
        return TaskGeneration::findOrFail($id);
    }

    public function create(array $data): TaskGeneration
    {
        return TaskGeneration::create($data);
    }

    public function delete(TaskGeneration $generation): bool
    {
        return $generation->delete();
    }
}
