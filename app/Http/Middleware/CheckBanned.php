<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_banned) {
                $banReason = $user->ban_reason;
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account has been banned. Reason: ' . $banReason]);
            }
        }

        return $next($request);
    }
}