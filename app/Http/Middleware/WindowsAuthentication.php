<?php

namespace App\Http\Middleware;

use App\Models\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WindowsAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $_SERVER['AUTH_USER'] ?? null;

        if ($username) {
            // Authenticate the user and log them in
            $user = Users::where('Name', $username)->first();

            if ($user) {
                Auth::login($user);
            }
        }

        return $next($request);
    }
}
