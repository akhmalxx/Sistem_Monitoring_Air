<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EnsureRoleMatches
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role; // 'Admin', 'User', 'Super Admin'
        $userRoleSlug = Str::slug($userRole, '-'); // jadi 'admin', 'user', 'super-admin'
        $requestPrefix = $request->segment(1); // ambil prefix URL (misal 'admin')

        if (Str::lower($userRoleSlug) !== Str::lower($requestPrefix)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
