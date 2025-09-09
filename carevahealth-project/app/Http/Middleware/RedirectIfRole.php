<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'superadmin' => redirect('/superadmin/dashboard'),
                'admin'      => redirect('/admin/dashboard'),
                'doctor'     => redirect('/doctor/dashboard'),
                'va'         => redirect('/employee/dashboard'),
                default      => redirect('/home'),
            };
        }

        return $next($request);
    }
}
