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
            return redirect('/JADBudget', 302, [
                "error" => "test"
            ]);
        }
        
        return $next($r);
    }
}
