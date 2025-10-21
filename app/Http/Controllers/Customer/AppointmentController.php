<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create(Request $request)
    {
        $selectedService = null;
        $selectedSpecialist = null;

        // If specialist is pre-selected, get it and filter services
        if ($request->has('specialist')) {
            $selectedSpecialist = Specialist::find($request->specialist);
            if ($selectedSpecialist) {
                $services = $selectedSpecialist->services()->where('is_active', true)->get();
            } else {
                $services = Service::active()->get();
            }
        } else {
            $services = Service::active()->get();
        }

        // If service is pre-selected, get it
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
    // ✅ Store the validated data in a variable
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

        $startTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        if ($startTime->isToday() && $startTime->isPast()) {
            return back()->withErrors(['start_time' => 'You cannot book an appointment in the past. Please select a future time.']);
        }

        $conflict = Appointment::where('specialist_id', $specialist->id)
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')])
                    ->orWhereBetween('end_time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime->format('H:i:s'))
                          ->where('end_time', '>=', $endTime->format('H:i:s'));
                    });
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'This time slot is already taken. Please select another time.']);
        }

        $tip = $request->custom_tip && $request->custom_tip > 0
            ? $request->custom_tip
            : ($request->selected_tip ?? 0);

        $total = $service->price;
        $grandTotal = $total + $tip;

        // ✅ Use the validated array now
        Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'specialist_id' => $specialist->id,
            'appointment_date' => $startTime->format('Y-m-d H:i:s'),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => 'pending',
            'notes' => $request->notes,
            'is_home_service' => $request->has('is_home_service'),
            'home_address' => $request->home_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tip_amount' => $tip,
            'payment_method' => $validated['payment_method'], // ✅ works now
            'total_price' => $total,
            'grand_total' => $grandTotal,
            'contact_phone' => auth()->user()->phone ?? '',
            'contact_email' => auth()->user()->email,
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Appointment booked successfully! You will receive a confirmation email shortly.');
    } catch (\Exception $e) {
        return back()->withErrors(['appointment' => 'Failed to create appointment. Error: ' . $e->getMessage()]);
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
    public function getSpecialistsForService(Request $request)
    {
        $serviceId = $request->get('service_id');

        if (!$serviceId) {
            return response()->json(['error' => 'Service ID is required'], 400);
        }

        $service = Service::findOrFail($serviceId);
        $specialists = $service->specialists()
            ->where('is_available', true)
            ->get()
            ->map(function ($specialist) {
                return [
                    'id' => $specialist->id,
                    'name' => $specialist->name,
                    'specialization' => $specialist->specialization,
                    'experience_years' => $specialist->experience_years,
                    'bio' => $specialist->bio,
                ];
            });

        return response()->json($specialists);
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

        $bookedSlots = Appointment::where('service_id', $serviceId)
            ->where('specialist_id', $specialistId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(function ($appointment) {
                return [
                    'start_time' => $appointment->start_time,
                    'end_time' => $appointment->end_time,
                ];
            });

        return response()->json($bookedSlots);
    }
}
