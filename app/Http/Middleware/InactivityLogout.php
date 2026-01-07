<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;

class InactivityLogout
{
    // timeout in seconds (e.g. 30 for production, 3 for testing)
    protected int $timeout = 300;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity'); // may be Carbon or int

            $lastActivityTs = null;
            if ($lastActivity instanceof DateTimeInterface) {
                $lastActivityTs = $lastActivity->getTimestamp();
            } elseif (is_numeric($lastActivity)) {
                $lastActivityTs = (int) $lastActivity;
            }

            if ($lastActivityTs !== null && (time() - $lastActivityTs) > $this->timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['login' => 'You have been logged out due to inactivity.']);
            }

            // update timestamp for active user
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
