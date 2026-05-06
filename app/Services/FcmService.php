<?php

namespace App\Services;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FcmService
{
    private ?string $projectId = null;
    private ?string $credentialsPath = null;

    public function sendToUser($userId, $title, $message, $data = [])
    {
        $tokens = DeviceToken::where('user_id', $userId)->pluck('token')->all();

        if (empty($tokens)) {
            return;
        }

        // Resolve credentials + access token once for all device tokens
        $this->credentialsPath = storage_path('app/firebase-credentials.json');

        if (!file_exists($this->credentialsPath)) {
            Log::warning('FCM: firebase-credentials.json not found, skipping push');
            return;
        }

        $credentials = json_decode(file_get_contents($this->credentialsPath), true);
        $this->projectId = $credentials['project_id'] ?? null;

        if (!$this->projectId) {
            Log::warning('FCM: project_id not found in credentials');
            return;
        }

        $accessToken = $this->getCachedAccessToken();

        if (!$accessToken) {
            Log::error('FCM: Failed to obtain OAuth access token — push skipped');
            return;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        foreach ($tokens as $deviceToken) {
            $this->sendToToken($deviceToken, $title, $message, $data, $accessToken, $url);
        }
    }

    private function sendToToken($token, $title, $body, $data, $accessToken, $url)
    {
        try {
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => array_map('strval', $data),
                    'android' => [
                        'priority' => 'high',
                        'ttl' => '0s', // 0 seconds = deliver immediately or drop, prevents FCM queuing
                        'notification' => [
                            'channel_id' => 'sela_high_importance_channel',
                        ],
                    ],
                    'apns' => [
                        'headers' => [
                            'apns-priority' => '10', // iOS instant delivery
                        ],
                    ],
                ],
            ];

            $response = Http::withToken($accessToken)
                ->timeout(5)
                ->post($url, $payload);

            if ($response->failed()) {
                Log::error('FCM send failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'token_prefix' => substr($token, 0, 20),
                ]);

                if ($response->status() === 404 || $response->status() === 400) {
                    DeviceToken::where('token', $token)->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error('FCM exception: ' . $e->getMessage());
        }
    }

    /**
     * Get OAuth access token from cache (valid 55 min) or fetch fresh.
     * This is the biggest perf win — eliminates ~800ms OAuth roundtrip per push.
     */
    private function getCachedAccessToken(): ?string
    {
        return Cache::remember('fcm_access_token', 55 * 60, function () {
            return $this->fetchAccessToken();
        });
    }

    private function fetchAccessToken(): ?string
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        if (class_exists(ServiceAccountCredentials::class)) {
            $cred = new ServiceAccountCredentials($scopes, $this->credentialsPath);
            $token = $cred->fetchAuthToken();
            return $token['access_token'] ?? null;
        }

        $credentials = json_decode(file_get_contents($this->credentialsPath), true);

        $now = time();
        $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $claim = $this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => implode(' ', $scopes),
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        $signature = '';
        openssl_sign("$header.$claim", $signature, $credentials['private_key'], 'SHA256');
        $jwt = "$header.$claim." . $this->base64UrlEncode($signature);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (!$response->successful()) {
            Log::error('FCM OAuth token request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        return $response->json('access_token');
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public function registerToken($userId, $token, $platform = 'android')
    {
        return DeviceToken::updateOrCreate(
            ['token' => $token],
            ['user_id' => $userId, 'platform' => $platform]
        );
    }
    
    public function removeToken($token)
    {
        return DeviceToken::where('token', $token)->delete();
    }
    
    public function removeUserTokens($userId)
    {
        return DeviceToken::where('user_id', $userId)->delete();
    }
}