<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserAbilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAbilityController extends Controller
{
    public function index(UserAbilityService $service, int $userId): JsonResponse
    {
        return response()->json($service->getUserAbilities($userId));
    }

    public function store(Request $request, UserAbilityService $service, int $userId): JsonResponse
    {
        $validated = $request->validate([
            'ability_id' => 'required|exists:abilities,id',
            'level' => 'nullable|integer|min:0',
        ]);

        $validated['user_id'] = $userId;

        return response()->json($service->create($validated), 201);
    }

    public function update(Request $request, UserAbilityService $service, int $id): JsonResponse
    {
        $userAbility = $service->getById($id);

        $validated = $request->validate([
            'level' => 'required|integer|min:0',
        ]);

        return response()->json($service->update($userAbility, $validated));
    }

    public function destroy(UserAbilityService $service, int $id): JsonResponse
    {
        $userAbility = $service->getById($id);
        $service->delete($userAbility);

        return response()->json(null, 204);
    }
}
