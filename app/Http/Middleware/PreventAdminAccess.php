<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventAdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            auth()->logout();
            return redirect()->route('admin.loginForm')
                ->with('error', 'Please use the admin login page for administrator accounts.');
        }

        return $next($request);
    }
} 