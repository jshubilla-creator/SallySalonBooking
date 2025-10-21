<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        // Get current settings from config or database
        $settings = [
            'salon_name' => config('app.name', 'Salon Booking System'),
            'salon_address' => '123 Main Street, City, State 12345',
            'salon_phone' => '+1 (555) 123-4567',
            'salon_email' => 'info@salon.com',
            'business_hours' => [
                'monday' => ['open' => '09:00', 'close' => '18:00', 'closed' => false],
                'tuesday' => ['open' => '09:00', 'close' => '18:00', 'closed' => false],
                'wednesday' => ['open' => '09:00', 'close' => '18:00', 'closed' => false],
                'thursday' => ['open' => '09:00', 'close' => '18:00', 'closed' => false],
                'friday' => ['open' => '09:00', 'close' => '18:00', 'closed' => false],
                'saturday' => ['open' => '10:00', 'close' => '16:00', 'closed' => false],
                'sunday' => ['open' => '10:00', 'close' => '16:00', 'closed' => true],
            ],
            'booking_settings' => [
                'advance_booking_days' => 30,
                'cancellation_hours' => 24,
                'auto_confirm' => false,
                'send_reminders' => true,
            ],
            'notification_settings' => [
                'email_notifications' => true,
                'sms_notifications' => false,
                'appointment_reminders' => true,
                'new_booking_notifications' => true,
            ],
            'payment_settings' => [
                'currency' => 'USD',
                'tax_rate' => 8.5,
                'payment_methods' => ['cash', 'card', 'online'],
            ],
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_address' => 'required|string|max:500',
            'salon_phone' => 'required|string|max:20',
            'salon_email' => 'required|email|max:255',
            'business_hours' => 'required|array',
            'booking_settings' => 'required|array',
            'notification_settings' => 'required|array',
            'payment_settings' => 'required|array',
        ]);

        // In a real application, you would save these to a database
        // For now, we'll just return a success message

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'appointment_reminders' => 'boolean',
            'new_booking_notifications' => 'boolean',
        ]);

        // In a real application, you would save these to a database

        return redirect()->route('admin.settings')
            ->with('success', 'Notification settings updated successfully.');
    }
}
