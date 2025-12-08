<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('customer.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (including profile picture).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle 2FA toggle separately
        if ($request->has('two_factor_enabled') && !$request->has('name')) {
            $enabled = $request->boolean('two_factor_enabled');
            
            if ($enabled && !$user->phone) {
                return back()->withErrors(['phone' => 'Phone number is required to enable 2FA.']);
            }
            
            $user->update(['two_factor_enabled' => $enabled]);
            
            $message = $enabled ? '2FA has been enabled for your account.' : '2FA has been disabled for your account.';
            return back()->with('success', $message);
        }

        // Handle regular profile update
        $user->fill($request->validated());

        if ($request->hasFile('profile_picture')) {
            // Delete old photo if it exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new photo
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('customer.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function password(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
            'two_factor_code' => $request->user()->two_factor_enabled ? ['required', 'digits:6'] : [],
        ]);

        $user = $request->user();
        
        // Verify 2FA if enabled
        if ($user->two_factor_enabled && $user->phone) {
            if (!$user->isTwoFactorCodeValid($validated['two_factor_code'])) {
                return back()->withErrors(['two_factor_code' => 'Invalid or expired verification code.']);
            }
            $user->resetTwoFactorCode();
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
            'two_factor_code' => $request->user()->two_factor_enabled ? ['required', 'digits:6'] : [],
        ]);

        $user = $request->user();
        
        // Verify 2FA if enabled
        if ($user->two_factor_enabled && $user->phone) {
            if (!$user->isTwoFactorCodeValid($request->two_factor_code)) {
                return back()->withErrors(['two_factor_code' => 'Invalid or expired verification code.']);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function toggle2FA(Request $request): RedirectResponse
    {
        $user = $request->user();
        $enabled = $request->boolean('two_factor_enabled');
        
        $user->update(['two_factor_enabled' => $enabled]);
        
        if (!$enabled) {
            $user->resetTwoFactorCode();
        }
        
        $message = $enabled ? '2FA has been enabled for your account.' : '2FA has been disabled for your account.';
        return back()->with('success', $message);
    }

    public function send2FACode(Request $request)
    {
        $user = $request->user();
        
        if (!$user->two_factor_enabled) {
            return response()->json(['success' => false, 'message' => '2FA not enabled']);
        }
        
        $user->generateTwoFactorCode();
        
        return response()->json(['success' => true, 'message' => 'Verification code sent to your email']);
    }
}
