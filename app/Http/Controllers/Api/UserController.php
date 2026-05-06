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

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        $users = \App\Models\User::where('username', 'ILIKE', "%{$query}%")
            ->orWhere('email', 'ILIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }

    public function show(UserService $service, string $id): JsonResponse
    {
        return response()->json($service->getById($id));
    }

    public function update(Request $request, UserService $service, string $id): JsonResponse
    {
        $profile = $service->getById($id);

        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:50',
            'full_name' => 'sometimes|required|string|max:100',
            'avatar_url' => 'nullable|string',
            'class_name' => 'nullable|string|max:100',
        ]);

        return response()->json($service->update($profile, $validated));
    }

    public function destroy(UserService $service, string $id): JsonResponse
    {
        $profile = $service->getById($id);
        $service->delete($profile);

        return response()->json(null, 204);
    }

    public function getProfileAbilities(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $abilities = \App\Models\ProfileAbility::where('user_id', $userId)->get();

        return response()->json(['abilities' => $abilities]);
    }

    public function updateProfileAbilities(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $validated = $request->validate([
            'abilities' => 'required|array',
            'abilities.*' => 'string|max:100',
        ]);

        \App\Models\ProfileAbility::where('user_id', $userId)->delete();

        foreach ($validated['abilities'] as $ability) {
            \App\Models\ProfileAbility::create([
                'user_id' => $userId,
                'ability' => $ability,
            ]);
        }

        return response()->json(['message' => 'Abilities updated successfully']);
    }

    public function abilities(UserService $service, string $userId): JsonResponse
    {
        return response()->json($service->getAbilities($userId));
    }

    public function storeAbility(Request $request, UserService $service, string $userId): JsonResponse
    {
        $validated = $request->validate([
            'ability' => 'required|string|max:100',
        ]);

        return response()->json($service->createAbility($userId, $validated['ability']), 201);
    }

    public function destroyAbility(UserService $service, string $id): JsonResponse
    {
        $service->deleteAbility($id);

        return response()->json(null, 204);
    }

    public function requestLecturerAccess(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $adminEmail = env('GOOGLE_SMTP_USER', 'admin@sela.com');
        if (!$adminEmail || $adminEmail === 'null') {
            $adminEmail = 'admin@sela.com';
        }

        try {
            $approveUrl = \Illuminate\Support\Facades\URL::signedRoute(
                'users.approve-lecturer',
                ['user' => $user->id]
            );

            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(
                new \App\Mail\LecturerAccessRequestMail($user, $approveUrl)
            );
            return response()->json(['message' => 'Lecturer access request sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send request.', 'error' => $e->getMessage()], 500);
        }
    }

    public function approveLecturerAccess(Request $request, \App\Models\User $user)
    {
        if ($user->role === 'lecturer') {
            return response()->view('emails.lecturer_approved', [
                'name' => $user->profile->full_name ?? $user->username,
                'alreadyApproved' => true,
            ]);
        }

        $user->update(['role' => 'lecturer']);
        $user->tokens()->delete();

        return response()->view('emails.lecturer_approved', [
            'name' => $user->profile->full_name ?? $user->username,
            'alreadyApproved' => false,
        ]);
    }
}
