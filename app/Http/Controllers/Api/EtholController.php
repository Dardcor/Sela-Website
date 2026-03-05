<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EtholService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EtholController extends Controller
{
    /**
     * Log in to ETHOL and persist the session.
     */
    public function login(Request $request, EtholService $service): JsonResponse
    {
        $validated = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $service->login($validated['email'], $validated['password'], $request->user()->id);

            return response()->json([
                'success' => true,
                'message' => 'Logged in to ETHOL successfully.',
            ]);
        } catch (\Throwable $e) {
            $status = str_contains($e->getMessage(), 'Invalid credentials') ? 401 : 500;

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Remove the stored ETHOL session.
     */
    public function logout(Request $request, EtholService $service): JsonResponse
    {
        try {
            $service->logout($request->user()->id);

            return response()->json([
                'success' => true,
                'message' => 'Logged out from ETHOL successfully.',
            ]);
        } catch (\Throwable $e) {
            $status = (str_contains($e->getMessage(), 'expired') || str_contains($e->getMessage(), 'not logged in')) ? 401 : 500;

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Get the current semester schedule.
     */
    public function schedule(Request $request, EtholService $service): JsonResponse
    {
        try {
            $data = $service->getSchedule($request->user()->id);

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Throwable $e) {
            $status = (str_contains($e->getMessage(), 'expired') || str_contains($e->getMessage(), 'not logged in')) ? 401 : 500;

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Get homework assignments across semesters.
     */
    public function homework(Request $request, EtholService $service): JsonResponse
    {
        try {
            $data = $service->getHomework($request->user()->id);

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Throwable $e) {
            $status = (str_contains($e->getMessage(), 'expired') || str_contains($e->getMessage(), 'not logged in')) ? 401 : 500;

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Get attendance history across semesters.
     */
    public function attendance(Request $request, EtholService $service): JsonResponse
    {
        try {
            $data = $service->getAttendance($request->user()->id);

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Throwable $e) {
            $status = (str_contains($e->getMessage(), 'expired') || str_contains($e->getMessage(), 'not logged in')) ? 401 : 500;

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Get the stored ETHOL JWT token.
     */
    public function token(Request $request, EtholService $service): JsonResponse
    {
        try {
            $token = $service->getAuthToken($request->user()->id);

            if (! $token) {
                return response()->json([
                    'success' => false,
                    'error'   => 'not logged in',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data'    => $token,
            ]);
        } catch (\Throwable $e) {
            $status = (str_contains($e->getMessage(), 'expired') || str_contains($e->getMessage(), 'not logged in')) ? 401 : 500;

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], $status);
        }
    }
}
