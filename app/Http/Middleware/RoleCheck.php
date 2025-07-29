<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user has any of the required roles
        if (! $request->user() || ! $request->user()->hasAnyRole($roles)) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        return $next($request);
    }
}
