<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckExpiry
{
    /**
     * Handle an incoming request.
     *
     * If current time (Asia/Manila) is on/after the expiry,
     * block access (show a view or abort).
     */
    public function handle(Request $request, Closure $next)
    {
        // Read expiry from env or default to 24 Oct 2025 00:00 Manila
        $expiryString = config('app.feature_expire_at', env('FEATURE_EXPIRE_AT', '2025-10-24 00:00:00'));

        // Parse expiry with timezone Asia/Manila
        $expiry = Carbon::parse($expiryString, 'Asia/Manila');

        // Current time in Manila
        $now = Carbon::now('Asia/Manila');

        if ($now->greaterThanOrEqualTo($expiry)) {
            // Option A: return a friendly view (recommended)
            if (view()->exists('errors.expired')) {
                return response()->view('errors.expired', ['expiry' => $expiry], 503);
            }

            // Option B: abort with message
            abort(503, 'This feature is no longer available. Expired on ' . $expiry->toDateTimeString() . ' (Asia/Manila).');
        }

        return $next($request);
    }
}
