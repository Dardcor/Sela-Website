<?php

namespace App\Services;

use App\Models\GroupMember;
use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

class GroupMemberService
{
    public function getGroupMembers(int $groupId): Collection
    {
        return GroupMember::with('user')->where('group_id', $groupId)->get();
    }

    public function addMember(array $data): GroupMember
    {
        $data['joined_at'] = now();
        return GroupMember::create($data);
    }

    public function getById(int $id): GroupMember
    {
        return GroupMember::findOrFail($id);
    }

    public function update(GroupMember $member, array $data): GroupMember
    {
        $member->update($data);
        return $member->fresh();
    }

    public function removeMember(int $groupId, int $userId): bool
    {
        $member = GroupMember::where('group_id', $groupId)
            ->where('user_id', $userId)
            ->firstOrFail();
        return $member->delete();
    }
}
