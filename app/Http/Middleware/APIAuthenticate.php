<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class APIAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('name', $request->login)->first();
        
        if (!$user || ($user && !Hash::check($request->password, $user->password)))
            return response()->json([
                "logged" => "0",
                "message" => "Bad credentials"
            ], 401);

        $request->attributes->add(['user' => $user]);

        return $next($request);
    }
}
