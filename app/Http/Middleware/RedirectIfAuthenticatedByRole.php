<?php

namespace App\Http\Middleware;

use Closure;
#if u need me, im here

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedByRole
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            switch ($role) {
                case 'SuperAdmin':
                    return redirect()->route('superadmin.dashboard');
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                case 'User':
                    return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
