<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(GroupService $service): JsonResponse
    {
        return response()->json($service->getAll());
    }

    public function store(Request $request, GroupService $service): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'course' => 'nullable|string|max:100',
            'max_member' => 'nullable|integer|min:1',
            'invitation_code' => 'nullable|string|max:20|unique:groups,invitation_code',
        ]);

        return response()->json($service->create($validated), 201);
    }

    public function show(GroupService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function update(Request $request, GroupService $service, int $id): JsonResponse
    {
        $group = $service->getById($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'course' => 'nullable|string|max:100',
            'max_member' => 'nullable|integer|min:1',
        ]);

        return response()->json($service->update($group, $validated));
    }

    public function destroy(GroupService $service, int $id): JsonResponse
    {
        $group = $service->getById($id);
        $service->delete($group);

        return response()->json(null, 204);
    }
}
