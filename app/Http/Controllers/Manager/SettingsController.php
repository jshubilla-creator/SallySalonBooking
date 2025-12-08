<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\SettingsService;

class SettingsController extends Controller
{
    public function index()
    {
        $service = new SettingsService();
        $defaults = [
            'salon_name' => 'Sally Salon',
            'salon_email' => 'info@beautysalon.com',
            'salon_phone' => '(555) 123-4567',
            'salon_address' => '123 Beauty Street, Downtown, City 12345',
            'working_hours' => [
                'monday' => ['start' => '09:00', 'end' => '17:00'],
                'tuesday' => ['start' => '09:00', 'end' => '17:00'],
                'wednesday' => ['start' => '09:00', 'end' => '17:00'],
                'thursday' => ['start' => '09:00', 'end' => '17:00'],
                'friday' => ['start' => '09:00', 'end' => '17:00'],
                'saturday' => ['start' => '09:00', 'end' => '17:00'],
                'sunday' => ['start' => '09:00', 'end' => '17:00'],
            ],
            'booking_advance_days' => 30,
            'cancellation_hours' => 24,
            'notification_settings' => [
                'email_notifications' => false,
                'sms_notifications' => false,
                'appointment_reminders' => false,
                'sms_confirmations' => false,
            ],
        ];

    $settings = array_replace_recursive($defaults, $service->all());

    return view('manager.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_email' => 'required|email',
            'salon_phone' => 'required|string|max:50',
            'salon_address' => 'required|string|max:255',
            'booking_advance_days' => 'required|integer|min:1|max:365',
            'cancellation_hours' => 'required|integer|min:1|max:168',
            'working_hours' => 'array',
            'facebook_url' => 'nullable|url',
            'messenger_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
        ]);

        // Handle notification settings
        $notificationSettings = [
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications' => $request->has('sms_notifications'),
            'appointment_reminders' => $request->has('appointment_reminders'),
            'sms_confirmations' => $request->has('sms_confirmations'),
        ];
        $validated['notification_settings'] = $notificationSettings;

    // Save all to shared settings via service
    $service = new SettingsService();
    $service->setMany($validated);

        return redirect()->route('manager.settings')->with('success', 'Settings updated successfully!');
    }
}
