<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Support\SupabaseJwtVerifier;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthenticateSupabase
{
    public function __construct(private readonly SupabaseJwtVerifier $verifier) {}

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! is_string($token) || $token === '') {
            return $this->unauthorized('Missing bearer token.');
        }

        try {
            $claims = $this->verifier->verify($token);
            $profile = $this->resolveProfile($claims);
        } catch (Throwable $exception) {
            return $this->unauthorized($exception->getMessage());
        }

        Auth::guard()->setUser($profile);
        $request->setUserResolver(static fn () => $profile);
        $request->attributes->set('supabase_claims', $claims);

        return $next($request);
    }

    private function resolveProfile(array $claims): User
    {
        $profileId = (string) $claims['sub'];
        $profile = User::query()->find($profileId);

        if ($profile) {
            return $profile;
        }

        $metadata = $claims['user_metadata'] ?? [];
        $usernameSeed = $metadata['username']
            ?? $metadata['user_name']
            ?? $claims['email']
            ?? Str::lower($profileId);

        $username = Str::of((string) $usernameSeed)
            ->before('@')
            ->lower()
            ->replaceMatches('/[^a-z0-9_]/', '_')
            ->trim('_')
            ->value();

        if ($username === '') {
            $username = 'user_'.Str::lower(Str::substr($profileId, 0, 8));
        }

        if (User::query()->where('username', $username)->whereKeyNot($profileId)->exists()) {
            $username .= '_'.Str::lower(Str::substr($profileId, 0, 8));
        }

        return User::query()->create([
            'id' => $profileId,
            'username' => $username,
            'full_name' => $metadata['full_name'] ?? $metadata['name'] ?? $username,
            'class_name' => $metadata['class_name'] ?? null,
            'avatar_url' => $metadata['avatar_url'] ?? null,
            'last_login_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function unauthorized(string $message): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated.',
            'error' => $message,
        ], 401);
    }
}
