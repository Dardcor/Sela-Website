<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserService $service): JsonResponse
    {
        return response()->json($service->getAll());
    }

    public function show(UserService $service, int $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function update(Request $request, UserService $service, int $id): JsonResponse
    {
        $user = $service->getById($id);

        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:100|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'class' => 'nullable|string|max:100',
            'role' => 'nullable|string|max:50',
        ]);

        return response()->json($service->update($user, $validated));
    }

    public function destroy(UserService $service, int $id): JsonResponse
    {
        $user = $service->getById($id);
        $service->delete($user);

        return response()->json(null, 204);
    }
}
