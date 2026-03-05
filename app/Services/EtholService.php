<?php

namespace App\Services;

use App\Models\UserEtholSession;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class EtholService
{
    private string $baseUrl;

    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36';

    private const MAX_REDIRECTS = 15;

    public function __construct()
    {
        $this->baseUrl = config('services.ethol.base_url');
    }

    /**
     * Perform CAS login and persist the session to the database.
     *
     * @throws \Exception
     */
    public function login(string $email, string $password, int $userId): void
    {
        $cookieJar = new CookieJar();

        // Step 1: GET the CAS login page to capture the initial cookies and form tokens.
        $casResult = $this->fetchWithRedirects("{$this->baseUrl}/cas", $cookieJar);
        $casHtml = $casResult['body'];
        $casUrl = $casResult['finalUrl'];
        $cookieJar = $casResult['cookieJar'];

        // Step 2: Extract hidden form fields required by CAS.
        if (! preg_match('/name="lt"\s+value="([^"]+)"/', $casHtml, $ltMatches)) {
            throw new \Exception('CAS login page did not return expected "lt" field. The CAS endpoint may have changed.');
        }

        if (! preg_match('/name="execution"\s+value="([^"]+)"/', $casHtml, $executionMatches)) {
            throw new \Exception('CAS login page did not return expected "execution" field. The CAS endpoint may have changed.');
        }

        $lt = $ltMatches[1];
        $execution = $executionMatches[1];

        // Step 3: POST credentials to the CAS login URL.
        $postResult = $this->fetchWithRedirects($casUrl, $cookieJar, 'POST', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'username'   => $email,
                'password'   => $password,
                'lt'         => $lt,
                'execution'  => $execution,
                '_eventId'   => 'submit',
            ],
        ]);

        $postHtml = $postResult['body'];
        $postUrl = $postResult['finalUrl'];
        $cookieJar = $postResult['cookieJar'];

        // Step 4: Detect failed login before attempting token extraction.
        if (str_contains($postUrl, 'login.pens.ac.id') || str_contains($postHtml, 'class="errors"')) {
            throw new \Exception('Invalid credentials. Please check your username and password.');
        }

        // Step 4 (continued): Extract the JWT token from the page JavaScript.
        if (! preg_match("/localStorage\.setItem\(['\"]token['\"]\s*,\s*['\"]([A-Za-z0-9._-]+)['\"]\)/", $postHtml, $tokenMatches)) {
            throw new \Exception('Could not extract authentication token from the ETHOL response. The login flow may have changed.');
        }

        $token = $tokenMatches[1];

        // Step 5: Verify API access with the extracted token.
        $apiClient = new Client([
            'headers' => [
                'User-Agent' => self::USER_AGENT,
                'token'      => $token,
            ],
            'http_errors' => false,
        ]);

        $apiResponse = $apiClient->get("{$this->baseUrl}/api/kuliah?tahun=2025&semester=2");
        $apiBody = (string) $apiResponse->getBody();
        $apiData = json_decode($apiBody, true);

        if (! is_array($apiData)) {
            throw new \Exception('ETHOL API verification failed: expected a JSON array response but received unexpected data.');
        }

        // Step 6: Persist the session to the database.
        UserEtholSession::updateOrCreate(
            ['user_id' => $userId],
            [
                'ethol_token'   => $token,
                'ethol_cookies' => json_encode($cookieJar->toArray()),
            ]
        );
    }

    /**
     * Remove the stored ETHOL session for the given user.
     */
    public function logout(int $userId): void
    {
        UserEtholSession::where('user_id', $userId)->delete();
    }

    /**
     * Check whether a stored ETHOL session exists for the given user.
     */
    public function isLoggedIn(int $userId): bool
    {
        return UserEtholSession::where('user_id', $userId)->exists();
    }

    /**
     * Retrieve the ETHOL session for the given user, or throw if not found.
     *
     * @throws \Exception
     */
    public function getSession(int $userId): UserEtholSession
    {
        $session = UserEtholSession::where('user_id', $userId)->first();

        if (! $session) {
            throw new \Exception("No ETHOL session found for user {$userId}. Please log in first.");
        }

        return $session;
    }

    /**
     * Return the raw JWT token from the stored session, or null if none exists.
     */
    public function getAuthToken(int $userId): ?string
    {
        $session = UserEtholSession::where('user_id', $userId)->first();

        return $session?->ethol_token;
    }

    /**
     * Perform an HTTP request manually following redirects, maintaining the provided cookie jar.
     *
     * Using raw Guzzle with `allow_redirects => false` is intentional here:
     * Laravel's Http facade auto-follows redirects and does not expose per-hop cookie
     * merging or method switching (POST → GET on 302/303), which CAS requires.
     *
     * @param  array<string, mixed>  $options  Additional Guzzle request options.
     * @return array{body: string, finalUrl: string, cookieJar: CookieJar}
     *
     * @throws \Exception
     */
    public function fetchWithRedirects(string $url, CookieJar $cookieJar, string $method = 'GET', array $options = []): array
    {
        $client = new Client([
            'cookies'         => $cookieJar,
            'allow_redirects' => false,
            'http_errors'     => false,
        ]);

        // Always attach the User-Agent to every request in the loop.
        $options['headers'] = array_merge(
            ['User-Agent' => self::USER_AGENT],
            $options['headers'] ?? []
        );

        $body = '';
        $redirectCount = 0;

        while ($redirectCount < self::MAX_REDIRECTS) {
            $response = $client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();

            // Not a redirect — we have the final response.
            if ($statusCode < 300 || $statusCode >= 400) {
                break;
            }

            $location = $response->getHeaderLine('Location');

            if (empty($location)) {
                // Redirect with no Location header; treat as final response.
                break;
            }

            // Resolve relative redirects against the current URL.
            if (! str_starts_with($location, 'http')) {
                $parsed = parse_url($url);
                $scheme = $parsed['scheme'] ?? 'https';
                $host = $parsed['host'] ?? '';
                $port = isset($parsed['port']) ? ":{$parsed['port']}" : '';
                $location = str_starts_with($location, '/')
                    ? "{$scheme}://{$host}{$port}{$location}"
                    : "{$scheme}://{$host}{$port}/" . ltrim($location, '/');
            }

            $url = $location;

            // 302/303 converts POST to GET and drops the body options.
            if (in_array($statusCode, [302, 303], true) && $method === 'POST') {
                $method = 'GET';
                unset($options['form_params'], $options['body'], $options['json']);
                // Keep only User-Agent in headers (drop Content-Type for GET).
                $options['headers'] = ['User-Agent' => self::USER_AGENT];
            }

            $redirectCount++;
        }

        if ($redirectCount >= self::MAX_REDIRECTS) {
            throw new \Exception("Exceeded maximum redirect limit (" . self::MAX_REDIRECTS . ") while following {$url}");
        }

        return [
            'body'      => $body,
            'finalUrl'  => $url,
            'cookieJar' => $cookieJar,
        ];
    }
}
