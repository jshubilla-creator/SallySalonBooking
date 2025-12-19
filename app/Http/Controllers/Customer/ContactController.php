<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactMessageMail;
use App\Services\SettingsService;

class ContactController extends Controller
{
    /**
     * Show the contact form with salon info.
     */
    public function index()
    {
        // Fetch salon info from shared settings service (file-backed)
        $service = new SettingsService();

        $settings = [
            'salon_name' => $service->get('salon_name', 'Salon Booking System'),
            'salon_email' => $service->get('salon_email', config('mail.from.address', 'admin@salon.com')),
            'salon_phone' => $service->get('salon_phone', '+1 (555) 123-4567'),
            'salon_address' => $service->get('salon_address', '123 Beauty Street, City, State 12345'),
            'facebook_url' => $service->get('facebook_url'),
            'messenger_url' => $service->get('messenger_url'),
            'instagram_url' => $service->get('instagram_url'),
            'tiktok_url' => $service->get('tiktok_url'),
        ];

        // Pass settings to the view
        return view('customer.contact', compact('settings'));
    }

    /**
     * Store a contact message submitted by a customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Use the saved salon email from shared settings
        $service = new SettingsService();
        $recipient = $service->get('salon_email', config('mail.from.address', 'ptc.johnalexishubilla@gmail.com'));

        // Mail::to($recipient)->send(new ContactMessageMail($validated));

        return back()->with('success', 'Your message has been sent successfully!');
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
