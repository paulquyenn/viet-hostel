<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log for debugging
        Log::info('AdminRoleMiddleware: checking if user has admin role');
        Log::info('Current user email: ' . ($request->user() ? $request->user()->email : 'Not authenticated'));

        if (! $request->user()) {
            Log::warning('AdminRoleMiddleware: No authenticated user');
            return response()->json([
                'error' => 'Unauthorized action: You must be logged in.',
                'status' => 403
            ], 403);
        }

        try {
            $hasRole = $request->user()->hasRole('admin');
            $allRoles = $request->user()->roles()->pluck('name')->toArray();
            Log::info('User has roles: ' . json_encode($allRoles));
            Log::info('User hasRole("admin"): ' . ($hasRole ? 'true' : 'false'));

            if (!$hasRole) {
                return response()->json([
                    'error' => 'Unauthorized action: You do not have the admin role.',
                    'user_roles' => $allRoles,
                    'status' => 403
                ], 403);
            }
        } catch (\Exception $e) {
            Log::error('Error checking roles: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'error' => 'Error checking roles: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }

        Log::info('AdminRoleMiddleware: User has admin role, proceeding with request');
        return $next($request);
    }
}
