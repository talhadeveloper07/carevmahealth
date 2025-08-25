<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // if logged in and has employee relation
        if ($user && $user->employee && !$user->employee->profile_completed) {
            // allow ONLY profile routes
            if (!$request->routeIs('employee.profile.*')) {
                return redirect()->route('employee.profile.edit')
                    ->with('warning', 'Please complete your profile before accessing other sections.');
            }
        }

        return $next($request);
    }
}
