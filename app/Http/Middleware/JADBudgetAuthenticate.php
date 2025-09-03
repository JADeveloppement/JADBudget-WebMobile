<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class JADBudgetAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $r, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($r->ajax() || $r->wantsJson()) {
                return response()->json([
                    'message' => 'Non authentifié. Identifiants invalides.'
                ], 401);
            }

            return redirect('/JADBudget')->with('error', 'Identifiants invalides.');
        }
        
        return $next($r);
    }
}
