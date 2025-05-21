<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            switch (Auth::user()->role_id) {
                case 1:
                    return redirect('/admin-dashboard');
                case 2:
                    return redirect('/agent-dashboard');
                case 3:
                    return redirect('/responsable-dashboard');
                case 4:
                    return redirect('/client-dashboard');
                default:
                    return redirect('/login');
            }
        }

        return $next($request);
    }
}
