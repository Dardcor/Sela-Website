<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GroupMemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function index(GroupMemberService $service, int $groupId): JsonResponse
    {
        return response()->json($service->getGroupMembers($groupId));
    }

    public function store(Request $request, GroupMemberService $service, int $groupId): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string',
        ]);

        $validated['group_id'] = $groupId;

        return response()->json($service->addMember($validated), 201);
    }

    public function update(Request $request, GroupMemberService $service, int $id): JsonResponse
    {
        $member = $service->getById($id);

        $validated = $request->validate([
            'role' => 'required|string',
        ]);

        return response()->json($service->update($member, $validated));
    }

    public function destroy(GroupMemberService $service, int $groupId, int $userId): JsonResponse
    {
        $service->removeMember($groupId, $userId);

        return response()->json(null, 204);
    }
}
