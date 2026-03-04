<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class GroupService
{
    public function getAll(): Collection
    {
        return Group::all();
    }

    public function getById(int $id): Group
    {
        return Group::findOrFail($id);
    }

    public function create(array $data): Group
    {
        if (empty($data['invitation_code'])) {
            $data['invitation_code'] = Str::upper(Str::random(8));
        }
        return Group::create($data);
    }

    public function update(Group $group, array $data): Group
    {
        $group->update($data);
        return $group->fresh();
    }

    public function delete(Group $group): bool
    {
        return $group->delete();
    }
}
