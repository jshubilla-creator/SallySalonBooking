<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SpecialistController extends Controller
{
    public function index()
    {
        $specialists = Specialist::available()->with('services')->get();
        return view('customer.specialists.index', compact('specialists'));
    }

    public function show(Specialist $specialist)
    {
        $specialist->load('services');
        // Include next upcoming appointment (pending or confirmed) for this specialist
        $nextAppointment = $specialist->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->first();

        $next = null;
        if ($nextAppointment) {
            $next = [
                'id' => $nextAppointment->id,
                'date' => $nextAppointment->appointment_date->format('Y-m-d'),
                'start_time' => optional($nextAppointment->start_time)->format('H:i'),
                'end_time' => optional($nextAppointment->end_time)->format('H:i'),
                'service' => $nextAppointment->service?->name,
                'status' => $nextAppointment->status,
            ];
        }

        // Determine if the specialist is currently busy: any pending/confirmed appointment
        // for today where now is between start_time and end_time.
        $isBusyNow = false;
        $now = Carbon::now();
        $todayAppointments = $specialist->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('appointment_date', $now->toDateString())
            ->get();

        $currentAppointment = null;
        foreach ($todayAppointments as $appt) {
            // Build start and end datetimes using appointment_date + times
            if (! $appt->start_time || ! $appt->end_time) {
                continue;
            }
            try {
                $start = Carbon::parse($appt->appointment_date->format('Y-m-d') . ' ' . $appt->start_time->format('H:i'));
                $end = Carbon::parse($appt->appointment_date->format('Y-m-d') . ' ' . $appt->end_time->format('H:i'));
            } catch (\Exception $e) {
                continue;
            }

            if ($now->between($start, $end)) {
                $isBusyNow = true;
                $currentAppointment = $appt;
                break;
            }
        }

        // Build busy reason details for the current appointment, if any
        $busyReason = null;
        if ($currentAppointment) {
            $currentAppointment->loadMissing('service', 'user');
            $busyReason = [
                'appointment_id' => $currentAppointment->id,
                'service' => $currentAppointment->service?->name,
                'customer' => $currentAppointment->user?->name,
                'start_time' => optional($currentAppointment->start_time)->format('H:i'),
                'end_time' => optional($currentAppointment->end_time)->format('H:i'),
                'status' => $currentAppointment->status,
            ];
        }

        $feedback = \App\Models\Feedback::whereHas('appointment', function($q) use ($specialist) {
            $q->where('specialist_id', $specialist->id);
        })->where('is_public', true)->with('user')->latest()->take(3)->get();

        return response()->json([
            'id' => $specialist->id,
            'name' => $specialist->name,
            'email' => $specialist->email,
            'phone' => $specialist->phone,
            'bio' => $specialist->bio,
            'specialization' => $specialist->specialization,
            'experience_years' => $specialist->experience_years,
            'working_hours' => $specialist->working_hours ?? [],
            'services' => $specialist->services->map(function($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => $service->price,
                ];
            }),
            'next_appointment' => $next,
            'is_busy_now' => $isBusyNow,
            'busy_reason' => $busyReason,
            'feedback' => $feedback->map(function($f) {
                return [
                    'rating' => $f->rating,
                    'comment' => $f->comment,
                    'user_name' => $f->user->name,
                    'created_at' => $f->created_at->format('M d, Y')
                ];
            })
        ]);
    }
}
