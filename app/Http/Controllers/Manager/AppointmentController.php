<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;

use Illuminate\Http\Request;
use Carbon\Carbon;
// use App\Mail\AppointmentDeletedMail;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\AppointmentApprovedMail;


class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Debug log all request data
        \Log::info('All Request Data:', $request->all());
        
        // Start with base query including relationships
        $query = Appointment::with(['user', 'service', 'specialist']);

        // Basic filters
        if ($request->filled('specialist_id')) {
            \Log::info('Filtering by specialist_id: ' . $request->specialist_id);
            $query->where('specialist_id', $request->specialist_id);
        }

        // Filter by user (accept both user_id and legacy user param)
        if ($request->filled('user_id') || $request->filled('user')) {
            $userId = $request->user_id ?? $request->user;
            \Log::info('Filtering by user_id: ' . $userId);
            $query->where('user_id', $userId);
        }

        if ($request->filled('status')) {
            \Log::info('Filtering by status: ' . $request->status);
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            \Log::info('Filtering by date: ' . $request->date);
            $query->whereDate('appointment_date', $request->date);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            \Log::info('Searching for: ' . $search);

            // Note: removed specialist name from the free-text search per request.
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQ) use ($search) {
                    $userQ->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('service', function($serviceQ) use ($search) {
                    $serviceQ->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // Log the query before execution
        \Log::info('Query SQL: ' . $query->toSql());
        \Log::info('Query Bindings:', $query->getBindings());

        // Execute query - order by creation date to show newest appointments first
        $appointments = $query->latest('created_at')->paginate(10);
        
        // Log result count
        \Log::info('Results count: ' . $appointments->count());

        // Get statuses and specialists for dropdowns
        $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled'];
        $specialists = \App\Models\Specialist::orderBy('name')->get();

        \Log::info('Available Specialists: ', $specialists->pluck('name', 'id')->toArray());

        return view('manager.appointments.index', compact('appointments', 'statuses', 'specialists'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'service', 'specialist', 'feedback']);
        return view('manager.appointments.show', compact('appointment'));
    }

    
    public function edit(Appointment $appointment)
{
    $appointment->load(['user', 'service', 'specialist']);

    // Optional: kung gusto mong may dropdowns sa edit form
    $services = \App\Models\Service::all();
    $specialists = \App\Models\Specialist::available();
    $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled'];

    return view('manager.appointments.edit', compact('appointment', 'services', 'specialists', 'statuses'));
}


    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,rescheduled',
            'notes' => 'nullable|string|max:500',
            'is_home_service' => 'boolean',
            'home_address' => 'required_if:is_home_service,true|nullable|string|max:500',
        ]);

        if ($request->is_home_service && $request->home_address) {
            $validator = new \App\Services\HomeServiceValidator();
            $result = $validator->validateAndCalculateFee($request->home_address);
            
            if (!$result['valid']) {
                return back()->withErrors(['home_address' => $result['message']]);
            }
            
            $appointment->update([
                'status' => $request->status,
                'notes' => $request->notes,
                'home_address' => $request->home_address,
                'city' => $result['city'],
                'distance_km' => $result['distance_km'],
                'distance_fee' => $result['fee'],
                'latitude' => $result['coordinates']['latitude'] ?? null,
                'longitude' => $result['coordinates']['longitude'] ?? null,
                'grand_total' => $appointment->total_price + $result['fee'] + ($appointment->tip_amount ?? 0),
            ]);
        } else {
            $appointment->update([
                'status' => $request->status,
                'notes' => $request->notes,
            ]);
        }

        return back()->with('success', 'Appointment updated successfully.');
    }

            public function destroy(Request $request, Appointment $appointment)
            {
                $request->validate([
                    'deletion_reason' => 'required|string|max:500',
                ]);

                $appointment->load(['user', 'service', 'specialist']);
                $reason = $request->deletion_reason;
                $customerEmail = $appointment->user->email;

                // if ($customerEmail) {
                //     Mail::to($customerEmail)->send(new AppointmentDeletedMail($appointment, $reason));
                // }

                $appointment->delete();

                return redirect()->route('manager.appointments.index')
                    ->with('success', 'Appointment deleted successfully and email notification sent.');
            }



        public function approve(Appointment $appointment)
        {
            $appointment->update(['status' => 'confirmed']);

            // Load relationships for email
            $appointment->load(['user', 'service', 'specialist']);
            $customerEmail = $appointment->user->email;

            // Check notification settings
            $settingsService = new \App\Services\SettingsService();
            $notificationSettings = $settingsService->get('notification_settings', []);

            $notifications = [];

            // Send email if enabled
            // if ($customerEmail && ($notificationSettings['email_notifications'] ?? false) && ($notificationSettings['sms_confirmations'] ?? false)) {
            //     Mail::to($customerEmail)->send(new AppointmentApprovedMail($appointment));
            //     $notifications[] = 'email';
            // }



            $message = 'Appointment approved successfully.';
            // if (!empty($notifications)) {
            //     $message .= ' ' . implode(' and ', $notifications) . ' notification sent.';
            // }

            return back()->with('success', $message);
        }

    public function cancel(Request $request, Appointment $appointment)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ]);

        $appointment->load(['user', 'service', 'specialist']);
        $reason = $request->cancel_reason;
        $customerEmail = $appointment->user->email;

        // Update status
        $appointment->update(['status' => 'cancelled']);

        // Check notification settings
        $settingsService = new \App\Services\SettingsService();
        $notificationSettings = $settingsService->get('notification_settings', []);

        $notifications = [];

        // Send email if enabled
        // if ($customerEmail && ($notificationSettings['email_notifications'] ?? false)) {
        //     Mail::to($customerEmail)->send(new AppointmentDeletedMail($appointment, $reason));
        //     $notifications[] = 'email';
        // }



        $message = 'Appointment cancelled successfully.';
        // if (!empty($notifications)) {
        //     $message .= ' ' . implode(' and ', $notifications) . ' notification sent.';
        // }

        return back()->with('success', $message);
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);
        return back()->with('success', 'Appointment marked as completed.');
    }
}
