<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $currentRole = session('user_role');

        if ($currentRole !== $role) {
            return response()->view('errors.unauthorized', ['role' => $role], 403);
        }

        return $next($request);
    }
}
