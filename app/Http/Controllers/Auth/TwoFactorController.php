<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = auth()->user();

        if (!$user->isTwoFactorCodeValid($request->code)) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        $user->resetTwoFactorCode();
        session(['2fa_verified' => true]);

        // Redirect based on user role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isManager()) {
            return redirect()->route('manager.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }

    public function resend()
    {
        $user = auth()->user();
        
        $user->generateTwoFactorCode();
        // Code is sent via email through User model's sendTwoFactorEmail() method
        return back()->with('status', 'Verification code sent to your email.');
    }
}