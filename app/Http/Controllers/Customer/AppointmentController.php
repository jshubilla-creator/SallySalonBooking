<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create(Request $request)
    {
        $selectedService = null;
        $selectedSpecialist = null;

        // If specialist is pre-selected, filter services
        if ($request->has('specialist')) {
            $selectedSpecialist = Specialist::find($request->specialist);
            $services = $selectedSpecialist
                ? $selectedSpecialist->services()->where('is_active', true)->get()
                : Service::active()->get();
        } else {
            $services = Service::active()->get();
        }

        // If service is pre-selected
        if ($request->has('service')) {
            $selectedService = Service::find($request->service);
        }

        return view('customer.appointments.create', compact('services', 'selectedService', 'selectedSpecialist'));
    }

    /**
     * Store new appointment.
     */
  public function store(Request $request)
{
    $validated = $request->validate([
        'service_id' => 'required|exists:services,id',
        'specialist_id' => 'required|exists:specialists,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'start_time' => 'required',
        'notes' => 'nullable|string|max:500',
        'is_home_service' => 'nullable|in:on,off,1,0,true,false',
        'home_address' => 'required_if:is_home_service,on|nullable|string|max:500',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'selected_tip' => 'nullable|numeric|min:0',
        'custom_tip' => 'nullable|numeric|min:0',
        'payment_method' => 'required|string|max:100',
    ]);

    try {
        $service = Service::findOrFail($validated['service_id']);
        $specialist = Specialist::findOrFail($validated['specialist_id']);

        // Build accurate Carbon timestamps
        $startTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Prevent booking in the past
        if ($startTime->isToday() && $startTime->isPast()) {
            return back()->withErrors(['start_time' => 'You cannot book an appointment in the past.']);
        }

        // Prevent night bookings (6 PM - 8 AM)
        $appointmentHour = $startTime->hour;
        if ($appointmentHour >= 18 || $appointmentHour < 8) {
            return back()->withErrors(['start_time' => 'Salon is closed at night. Please select a time between 8 AM - 6 PM.']);
        }

            $conflict = Appointment::where('specialist_id', $specialist->id)
                ->whereDate('appointment_date', $startTime->format('Y-m-d'))
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                    });
                })
                ->exists();


        if ($conflict) {
            return back()->withErrors(['start_time' => 'This time slot is already taken. Please select another.']);
        }

        // Check daily booking limit
        $dailyLimit = \App\Models\Setting::get('daily_booking_limit', config('salon.daily_booking_limit', 20));
        $dailyBookings = Appointment::whereDate('appointment_date', $startTime->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($dailyBookings >= $dailyLimit) {
            return back()->withErrors(['appointment_date' => 'Daily booking limit reached. Please select another date.']);
        }

        // Check customer daily booking limit
        $customerDailyLimit = \App\Models\Setting::get('customer_daily_limit', config('salon.customer_daily_limit', 3));
        $customerDailyBookings = Appointment::where('user_id', auth()->id())
            ->whereDate('appointment_date', $startTime->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($customerDailyBookings >= $customerDailyLimit) {
            return back()->withErrors(['appointment_date' => 'You have reached your daily booking limit of ' . $customerDailyLimit . ' appointments.']);
        }

        // Check specialist daily quota
        $specialistQuota = \App\Models\Setting::get('specialist_daily_quota', 8);
        $specialistDailyBookings = Appointment::where('specialist_id', $specialist->id)
            ->whereDate('appointment_date', $startTime->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($specialistDailyBookings >= $specialistQuota) {
            return back()->withErrors(['specialist_id' => 'This specialist is fully booked for the selected date (max ' . $specialistQuota . ' appointments per day).']);
        }

        // Calculate tip and totals
        $tip = $request->custom_tip && $request->custom_tip > 0
            ? $request->custom_tip
            : ($request->selected_tip ?? 0);

        $total = $service->price;
        $grandTotal = $total + $tip;

        // ✅ Create new appointment
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'service_variation' => $request->service_variation,
            'specialist_id' => $specialist->id,
            'appointment_date' => $startTime,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'notes' => $request->notes,
            'is_home_service' => $request->has('is_home_service'),
            'home_address' => $request->home_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tip_amount' => $tip,
            'payment_method' => $validated['payment_method'],
            'total_price' => $total,
            'grand_total' => $grandTotal,
            'contact_phone' => auth()->user()->phone ?? '',
            'contact_email' => auth()->user()->email,
        ]);

        // Send booking confirmation email
        $appointment->load(['user', 'service', 'specialist']);
        \Mail::to($appointment->user->email)->send(new \App\Mail\AppointmentBookedMail($appointment));

        return redirect()->route('customer.dashboard')
            ->with('success', 'Appointment booked successfully!');
    } catch (\Exception $e) {
        \Log::error('Appointment creation failed: ' . $e->getMessage());
        return back()->withErrors(['appointment' => 'Failed to create appointment.']);

    }
}

    /**
     * Cancel appointment.
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        \Log::info('Cancel method called', ['appointment_id' => $appointment->id, 'user_id' => auth()->id()]);
        
        if ($appointment->user_id !== auth()->id()) {
            \Log::error('Unauthorized cancel attempt');
            abort(403);
        }

        $result = $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason ?? 'Cancelled by customer',
        ]);
        
        \Log::info('Update result', ['result' => $result]);

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Fetch specialists for a service (AJAX).
     */
    public function getSpecialists(Request $request)
    {
        $serviceId = $request->query('service_id');
        $date = $request->query('date');

        if (!$serviceId) {
            return response()->json(['error' => 'Missing service_id'], 400);
        }

        try {
            $specialists = Specialist::whereHas('services', function ($q) use ($serviceId) {
                $q->where('service_id', $serviceId);
            })
            ->select('id', 'name', 'specialization', 'experience_years', 'bio')
            ->get();

            // If date is provided, check availability
            if ($date) {
                $specialists = $specialists->map(function ($specialist) use ($serviceId, $date) {
                    $availability = $this->isSpecialistFullyBooked($specialist->id, $serviceId, $date);
                    $specialist->is_fully_booked = $availability['is_fully_booked'];
                    $specialist->available_slots = $availability['available_slots'];
                    $specialist->morning_slots = $availability['morning_slots'];
                    $specialist->evening_slots = $availability['evening_slots'];
                    return $specialist;
                });
            }

            return response()->json($specialists);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function isSpecialistFullyBooked($specialistId, $serviceId, $date)
    {
        $service = Service::find($serviceId);
        if (!$service) return ['is_fully_booked' => false, 'available_slots' => 0];

        $parsedDate = Carbon::parse($date)->format('Y-m-d');
        
        $bookedSlots = Appointment::where('specialist_id', $specialistId)
            ->whereDate('appointment_date', $parsedDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['start_time', 'end_time']);

        // Check if it's night time (6 PM - 8 AM) or if checking for midnight
        $currentHour = now()->hour;
        $selectedDate = Carbon::parse($date);
        
        // Make unavailable at midnight or night hours
        if ($currentHour >= 18 || $currentHour < 8 || $selectedDate->hour == 0) {
            return ['is_fully_booked' => true, 'available_slots' => 0, 'morning_slots' => 0, 'evening_slots' => 0];
        }

        // Get working hours from settings
        $workingHours = \App\Models\Setting::get('working_hours', [
            'monday' => ['start' => '09:00', 'end' => '18:00']
        ]);
        $dayOfWeek = strtolower(Carbon::parse($date)->format('l'));
        $dayHours = $workingHours[$dayOfWeek] ?? ['start' => '09:00', 'end' => '18:00'];
        
        $startHour = (int) explode(':', $dayHours['start'])[0];
        $endHour = (int) explode(':', $dayHours['end'])[0];
        
        $allSlots = [];
        for ($hour = $startHour; $hour < $endHour; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $allSlots[] = sprintf('%02d:%02d', $hour, $minute);
            }
        }

        $availableSlots = 0;
        $morningSlots = 0;
        $eveningSlots = 0;
        
        foreach ($allSlots as $slot) {
            $slotTime = Carbon::parse($parsedDate . ' ' . $slot);
            $slotEndTime = $slotTime->copy()->addMinutes($service->duration_minutes);
            
            $isBooked = $bookedSlots->some(function ($booking) use ($slotTime, $slotEndTime) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);
                return $slotTime->lt($bookingEnd) && $slotEndTime->gt($bookingStart);
            });
            
            if (!$isBooked) {
                $availableSlots++;
                $hour = (int) explode(':', $slot)[0];
                if ($hour < 14) { // Before 2 PM = Morning
                    $morningSlots++;
                } else { // 2 PM - 6 PM = Afternoon
                    $eveningSlots++;
                }
            }
        }

        return [
            'is_fully_booked' => $availableSlots === 0, 
            'available_slots' => $availableSlots,
            'morning_slots' => $morningSlots,
            'evening_slots' => $eveningSlots
        ];
    }

    /**
     * Get daily booking counts for calendar display
     */
    public function getDailyBookingCounts(Request $request)
    {
        $startDate = $request->get('start_date', now()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(30)->format('Y-m-d'));
        
        $dailyCounts = Appointment::selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->whereDate('appointment_date', '>=', $startDate)
            ->whereDate('appointment_date', '<=', $endDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();
            
        return response()->json($dailyCounts);
    }

    /**
     * Fetch booked time slots for a given date (AJAX).
     */
    public function getBookedTimeSlots(Request $request)
    {
        $serviceId = $request->get('service_id');
        $specialistId = $request->get('specialist_id');
        $date = $request->get('date');

        if (!$serviceId || !$specialistId || !$date) {
            return response()->json(['error' => 'Service ID, Specialist ID, and Date are required'], 400);
        }

        try {
            $parsedDate = Carbon::parse($date)->format('Y-m-d');

            \Log::info('🔍 Fetching booked slots', [
                'service_id' => $serviceId,
                'specialist_id' => $specialistId,
                'date' => $parsedDate,
            ]);

            $bookedSlots = Appointment::where('service_id', $serviceId)
                ->where('specialist_id', $specialistId)
                ->whereDate('appointment_date', $parsedDate)
                ->whereIn('status', ['pending', 'confirmed'])
                ->select('start_time', 'end_time')
                ->get();

            if ($bookedSlots->isEmpty()) {
                \Log::info('⚠️ No booked slots found for this date.');
            }

            return response()->json($bookedSlots);
        } catch (\Exception $e) {
            \Log::error('❌ Error fetching booked slots: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch booked time slots.'], 500);
        }
    }
/**
 * Display a list of all appointments for the logged-in customer.
 */
public function index()
{
    $appointments = Appointment::where('user_id', auth()->id())
        ->with(['service', 'specialist'])
        ->orderBy('appointment_date', 'desc')
        ->paginate(10);

    return view('customer.appointments.index', compact('appointments'));
}
public function show(Appointment $appointment)
{
    // Make sure the user owns this appointment
    if ($appointment->user_id !== auth()->id()) {
        abort(403);
    }

    return view('customer.appointments.show', compact('appointment'));
}

}