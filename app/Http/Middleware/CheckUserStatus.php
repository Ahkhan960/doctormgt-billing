<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Force-logout check: compare session's version with user's version
            $sessionVersion = (int) session('session_version', 0);
            $forceVersion   = (int) session('force_logout_version', 0);

            // 1) Admin forced logout: force_logout_version changed
            if ($forceVersion !== (int) $user->force_logout_version) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['login' => 'You have been logged out by an administrator.']);
            }

            // 2) Single-device logout: session_version changed (logged in somewhere else)
            if ($sessionVersion !== (int) $user->session_version) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors([
                        'login' => 'Your account is logged in from another device. You can only be logged in from one device at a time.',
                    ]);
            }

            // Existing active/inactive check
            if ($user->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['login' => 'Your account is inactive. Please contact an admin or manager.']);
            }
        }

        return $next($request);
    }
}
