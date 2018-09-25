<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $unauthorized = ['status' => 'Unauthorized'];

        $token = $request->headers->get('Authorization');

        if ($token) {

            if (User::where('auth-token', '=', $token)->exists()) {
                return $next($request);
            }

            return $unauthorized;
        }

        return $unauthorized;
    }
}
