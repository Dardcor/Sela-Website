<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AbilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbilityController extends Controller
{
    public function index(AbilityService $service): JsonResponse
    {
        return response()->json($service->getAll());
    }

    public function store(Request $request, AbilityService $service): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        return response()->json($service->create($validated), 201);
    }

    public function show(AbilityService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function update(Request $request, AbilityService $service, int $id): JsonResponse
    {
        $ability = $service->getById($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        return response()->json($service->update($ability, $validated));
    }

    public function destroy(AbilityService $service, int $id): JsonResponse
    {
        $ability = $service->getById($id);
        $service->delete($ability);

        return response()->json(null, 204);
    }
}
