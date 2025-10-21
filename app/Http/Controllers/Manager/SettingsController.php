<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('manager.settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_email' => 'required|email|max:255',
            'salon_phone' => 'required|string|max:20',
            'salon_address' => 'required|string|max:500',
            'working_hours' => 'required|array',
            'booking_advance_days' => 'required|integer|min:1|max:365',
            'cancellation_hours' => 'required|integer|min:1|max:168',
        ]);

        // In a real application, you would save these to a settings table or config file
        // For now, we'll just show a success message

        return back()->with('success', 'Settings updated successfully.');
    }
}
