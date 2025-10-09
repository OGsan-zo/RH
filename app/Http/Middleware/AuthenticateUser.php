<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect('/RH/login')->withErrors(['message' => 'Vous devez être connecté.']);
        }
        return $next($request);
    }
}
