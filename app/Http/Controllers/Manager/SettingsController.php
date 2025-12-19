<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'salon_name' => Setting::get('salon_name', 'Sally Salon'),
            'salon_email' => Setting::get('salon_email', 'info@sallysalon.com'),
            'salon_phone' => Setting::get('salon_phone', '(555) 123-4567'),
            'salon_address' => Setting::get('salon_address', '123 Beauty Street'),
            'booking_advance_days' => Setting::get('booking_advance_days', 30),
            'cancellation_hours' => Setting::get('cancellation_hours', 24),
            'daily_booking_limit' => Setting::get('daily_booking_limit', 20),
            'customer_daily_limit' => Setting::get('customer_daily_limit', 3),
            'specialist_daily_quota' => Setting::get('specialist_daily_quota', 8),
            'working_hours' => Setting::get('working_hours', [
                'monday' => ['start' => '09:00', 'end' => '17:00'],
                'tuesday' => ['start' => '09:00', 'end' => '17:00'],
                'wednesday' => ['start' => '09:00', 'end' => '17:00'],
                'thursday' => ['start' => '09:00', 'end' => '17:00'],
                'friday' => ['start' => '09:00', 'end' => '17:00'],
                'saturday' => ['start' => '09:00', 'end' => '17:00'],
                'sunday' => ['start' => '09:00', 'end' => '17:00']
            ]),
            'notification_settings' => Setting::get('notification_settings', []),
            'facebook_url' => Setting::get('facebook_url', ''),
            'messenger_url' => Setting::get('messenger_url', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
            'tiktok_url' => Setting::get('tiktok_url', '')
        ];
        
        return view('manager.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_email' => 'required|email|max:255',
            'salon_phone' => 'required|string|max:20',
            'salon_address' => 'required|string|max:500',
            'booking_advance_days' => 'required|integer|min:1|max:365',
            'cancellation_hours' => 'required|integer|min:1|max:168',
            'daily_booking_limit' => 'required|integer|min:1|max:100',
            'customer_daily_limit' => 'required|integer|min:1|max:10',
            'specialist_daily_quota' => 'required|integer|min:1|max:20'
        ]);

        Setting::set('salon_name', $request->salon_name);
        Setting::set('salon_email', $request->salon_email);
        Setting::set('salon_phone', $request->salon_phone);
        Setting::set('salon_address', $request->salon_address);
        Setting::set('booking_advance_days', $request->booking_advance_days);
        Setting::set('cancellation_hours', $request->cancellation_hours);
        Setting::set('daily_booking_limit', $request->daily_booking_limit);
        Setting::set('customer_daily_limit', $request->customer_daily_limit);
        Setting::set('specialist_daily_quota', $request->specialist_daily_quota);
        
        if ($request->has('working_hours')) {
            Setting::set('working_hours', $request->working_hours);
        }
        
        Setting::set('facebook_url', $request->facebook_url);
        Setting::set('messenger_url', $request->messenger_url);
        Setting::set('instagram_url', $request->instagram_url);
        Setting::set('tiktok_url', $request->tiktok_url);
        
        // Handle notification settings
        $notificationSettings = [
            'email_notifications' => $request->has('email_notifications'),
            'appointment_reminders' => $request->has('appointment_reminders')
        ];
        Setting::set('notification_settings', $notificationSettings);

        return back()->with('success', 'Settings updated successfully!');
    }

    public function clearCache()
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');
            \Artisan::call('optimize:clear');
            
            return back()->with('success', '✅ All application caches cleared successfully.');
        } catch (\Exception $e) {
            return back()->with('error', '⚠️ Failed to clear cache: ' . $e->getMessage());
        }
    }
}