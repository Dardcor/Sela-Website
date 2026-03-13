<?php

namespace App\Services;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupService
{
    public function getGroupsByUser($user_id, $search = null)
    {

        $groups = DB::table('group_members')
            ->join('groups', 'groups.id', '=', 'group_members.group_id')
            ->where('group_members.user_id', $user_id)

            ->when($search, function ($query) use ($search) {
                $query->where('groups.name', 'like', "%$search%");
            })

            ->select(
                'groups.id',
                'groups.name',
                'groups.course'
            )

            ->get();

        foreach ($groups as $group) {

            $group->total_member = DB::table('group_members')
                ->where('group_id', $group->id)
                ->count();

            $group->members = DB::table('group_members')
                ->join('users', 'users.id', '=', 'group_members.user_id')
                ->where('group_members.group_id', $group->id)
                ->select(
                    'users.id',
                    'users.username'
                )
                ->limit(5)
                ->get();
        }

        return $groups;
    }

    public function getGroupDetail($group_id)
    {

        $group = DB::table('groups')
            ->where('id', $group_id)
            ->select(
                'id',
                'name',
                'course',
                'max_member',
                'invitation_code'
            )
            ->first();

        $members = DB::table('group_members')
            ->join('users', 'users.id', '=', 'group_members.user_id')
            ->where('group_members.group_id', $group_id)

            ->select(
                'users.id',
                'users.username',
                'group_members.role'
            )

            ->get();

        return [

            "group" => [
                "id" => $group->id,
                "name" => $group->name,
                "course" => $group->course,
                "max_member" => $group->max_member,
                "invitation_code" => $group->invitation_code
            ],

            "members" => $members
        ];
    }

    public function createGroup($request)
    {
        $user = User::find(auth()->id());

        $code = strtoupper(Str::random(6));

        $groupName = $user->class
            . "-" .
            $request->course
            . "-Kelompok "
            . $request->number_group;

        $group = Group::create([
            'name' => $groupName,
            'course' => $request->course,
            'max_member' => $request->max_member,
            'invitation_code' => $code
        ]);

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'role' => 'leader',
            'joined_at' => now()
        ]);

        return $group;
    }


    public function joinGroup($code, $user_id)
    {

        $group = Group::where('invitation_code', $code)->firstOrFail();

        $count = GroupMember::where('group_id', $group->id)->count();

        if ($count >= $group->max_member) {
            throw new \Exception("Group is full");
        }

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $user_id,
            'role' => 'member',
            'joined_at' => now()
        ]);

        return $group;
    }
}
