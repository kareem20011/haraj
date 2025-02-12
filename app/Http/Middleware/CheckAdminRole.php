<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // التحقق من إذا كان المستخدم لديه دور "admin"
            if (Auth::user()->role === 'admin') {
                return $next($request); // إذا كان "admin"، السماح بالمرور
            }
        }

        abort(401);
    }
}
