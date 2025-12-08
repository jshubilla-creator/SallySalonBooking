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

            $conflict = Appointment::where('specialist_id', $specialist->id)
                ->whereDate('appointment_date', $startTime->format('Y-m-d'))
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $endTime->format('H:i:s'))
                        ->where('end_time', '>', $startTime->format('H:i:s'));
                    });
                })
                ->exists();


        if ($conflict) {
            return back()->withErrors(['start_time' => 'This time slot is already taken. Please select another.']);
        }

        // Check daily booking limit
        $dailyLimit = config('salon.daily_booking_limit', 10);
        $dailyBookings = Appointment::whereDate('appointment_date', $startTime->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($dailyBookings >= $dailyLimit) {
            return back()->withErrors(['appointment_date' => 'Daily booking limit reached. Please select another date.']);
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
            'specialist_id' => $specialist->id,
            'appointment_date' => $startTime->format('Y-m-d H:i:s'),
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
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
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Fetch specialists for a service (AJAX).
     */
    public function getSpecialists(Request $request)
    {
        $serviceId = $request->query('service_id');

        if (!$serviceId) {
            return response()->json(['error' => 'Missing service_id'], 400);
        }

        try {
            $specialists = Specialist::whereHas('services', function ($q) use ($serviceId) {
                $q->where('service_id', $serviceId);
            })
            ->select('id', 'name', 'specialization', 'experience_years', 'bio')
            ->get();

            return response()->json($specialists);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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