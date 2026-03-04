<?php

namespace App\Services;

use App\Models\SubTaskAssignment;
use Illuminate\Database\Eloquent\Collection;

class SubTaskAssignmentService
{
    public function getBySubTask(int $subTaskId): Collection
    {
        return SubTaskAssignment::with('user')->where('sub_task_id', $subTaskId)->get();
    }

    public function getById(int $id): SubTaskAssignment
    {
        return SubTaskAssignment::findOrFail($id);
    }

    public function create(array $data): SubTaskAssignment
    {
        return SubTaskAssignment::create($data);
    }

    public function update(SubTaskAssignment $assignment, array $data): SubTaskAssignment
    {
        $assignment->update($data);
        return $assignment->fresh();
    }

    public function delete(SubTaskAssignment $assignment): bool
    {
        return $assignment->delete();
    }
}
