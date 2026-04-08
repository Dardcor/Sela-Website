<?php

namespace App\Support;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SupabaseJwtVerifier
{
    public function verify(string $token): array
    {
        $decoded = $this->decodeToken($token);
        $claims = json_decode(json_encode($decoded, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        $this->assertRequiredClaims($claims);

        return $claims;
    }

    private function decodeToken(string $token): object
    {
        $jwtSecret = config('services.supabase.jwt_secret');

        if (is_string($jwtSecret) && $jwtSecret !== '') {
            return JWT::decode($token, new Key($jwtSecret, 'HS256'));
        }

        $keySet = JWK::parseKeySet($this->getJwks());

        return JWT::decode($token, $keySet);
    }

    private function getJwks(): array
    {
        return Cache::remember('supabase:jwks', now()->addMinutes(10), function (): array {
            $supabaseUrl = rtrim((string) config('services.supabase.url'), '/');

            if ($supabaseUrl === '') {
                throw new RuntimeException('SUPABASE_URL must be configured when SUPABASE_JWT_SECRET is not set.');
            }

            $response = Http::acceptJson()
                ->timeout(10)
                ->get("{$supabaseUrl}/auth/v1/.well-known/jwks.json")
                ->throw()
                ->json();

            if (! is_array($response) || ! Arr::has($response, 'keys')) {
                throw new RuntimeException('Supabase JWKS response is invalid.');
            }

            return $response;
        });
    }

    private function assertRequiredClaims(array $claims): void
    {
        $subject = Arr::get($claims, 'sub');
        $role = Arr::get($claims, 'role');
        $audience = Arr::get($claims, 'aud');

        if (! is_string($subject) || $subject === '') {
            throw new RuntimeException('Supabase token does not contain a valid subject.');
        }

        if ($role !== null && $role !== 'authenticated') {
            throw new RuntimeException('Supabase token role is not allowed.');
        }

        if (is_string($audience) && $audience !== 'authenticated') {
            throw new RuntimeException('Supabase token audience is not allowed.');
        }

        if (is_array($audience) && ! in_array('authenticated', $audience, true)) {
            throw new RuntimeException('Supabase token audience is not allowed.');
        }
    }
}
