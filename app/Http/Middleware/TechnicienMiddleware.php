<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechnicienMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        error_log('TEST');
        if (auth()->check() && auth()->user()->role_id === 2) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }
}
