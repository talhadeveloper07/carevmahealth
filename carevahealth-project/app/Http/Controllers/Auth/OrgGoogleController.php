<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrgGoogleController extends Controller
{
    // Redirect logged-in user to Google to connect account
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

// Redirect from login page
public function redirectToGoogleLogin()
{
    return Socialite::driver('google')->redirect();
}

// Handle Google callback (both login & connect)
public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    // If user is logged in, this is “connect”
    if (Auth::check()) {
        $user = Auth::user();

        // Make sure the Google email matches the employee email
        if ($googleUser->email !== $user->email) {
            return redirect()->route('employee.setting')
                ->withErrors('Google email must match your registered email.');
        }

        // Save Google ID to the employee account
        $user->google_id = $googleUser->id;
        $user->save();

        return redirect()->route('employee.setting')
            ->with('success', 'Google account connected successfully!');
    }

    // Otherwise, this is a login via Google
    $user = \App\Models\User::where('google_id', $googleUser->id)
        ->orWhere('email', $googleUser->email)
        ->first();

    // Check if the user exists and is connected to Google
    if (!$user || !$user->google_id) {
        return redirect()->route('login')
            ->withErrors('Your account is not connected to Google.');
    }

    // Login the user
    Auth::login($user);

    return redirect()->route('employee.dashboard');
}

public function disconnectGoogle(Request $request)
{
    $user = Auth::user();

    // Remove the google_id
    $user->google_id = null;
    $user->save();

    return redirect()->route('employee.dashboard')
        ->with('success', 'Google account disconnected successfully.');
}

}
