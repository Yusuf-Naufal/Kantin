<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to login page if not authenticated
            return redirect()->route('login')->with('message', 'Anda Belum Login!');
        }

        // Get the authenticated user's role
        $userRole = Auth::user()->role; // Assuming 'role' is the field in your User model

        // Check if the user's role is in the list of allowed roles
        if (!in_array($userRole, $roles)) {
            // Redirect to a forbidden page or home if the role is not allowed
            return redirect()->route('error-page')->with('message', 'Anda Tidak Memiliki Izin Mengakses Halaman Ini!');
        }

        return $next($request);
    }
}
