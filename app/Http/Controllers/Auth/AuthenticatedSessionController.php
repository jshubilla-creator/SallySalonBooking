<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();
        
        // Check if user is banned
        if ($user->is_banned) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account has been banned. Reason: ' . $user->ban_reason,
            ]);
        }

        $request->session()->regenerate();

        // Check if 2FA is enabled
        if ($user->two_factor_enabled) {
            $user->generateTwoFactorCode();
            // Code is sent via email through User model's sendTwoFactorEmail() method
            return redirect()->route('two-factor.show');
        }

        session(['2fa_verified' => true]);
        $welcomeMessage = "Welcome back, {$user->name}! You have successfully logged in to Sally Salon.";

        // Redirect based on user role
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard', absolute: false))
                ->with('success', $welcomeMessage);
        } elseif ($user->hasRole('manager')) {
            return redirect()->intended(route('manager.dashboard', absolute: false))
                ->with('success', $welcomeMessage);
        } else {
            return redirect()->intended(route('customer.dashboard', absolute: false))
                ->with('success', $welcomeMessage);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
