<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\AppointmentDeletedMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApprovedMail; 


class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'service', 'specialist']);

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('service', function($serviceQuery) use ($search) {
                    $serviceQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('specialist', function($specialistQuery) use ($search) {
                    $specialistQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date !== '') {
            $query->whereDate('appointment_date', $request->date);
        }

        // Filter by specialist
        if ($request->has('specialist_id') && $request->specialist_id !== '') {
            $query->where('specialist_id', $request->specialist_id);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        $specialists = Specialist::available()->get();
        $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled'];

        return view('manager.appointments.index', compact('appointments', 'specialists', 'statuses'));
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
    $specialists = \App\Models\Specialist::available()->get();
    $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled'];

    return view('manager.appointments.edit', compact('appointment', 'services', 'specialists', 'statuses'));
}


    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,rescheduled',
            'notes' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

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

                if ($customerEmail) {
                    Mail::to($customerEmail)->send(new AppointmentDeletedMail($appointment, $reason));
                }

                $appointment->delete();

                return redirect('/manager/appointments')
                    ->with('success', 'Appointment deleted successfully and email notification sent.');
            }



        public function approve(Appointment $appointment)
        {
            $appointment->update(['status' => 'confirmed']);

            // Load relationships for email
            $appointment->load(['user', 'service', 'specialist']);
            $customerEmail = $appointment->user->email;

            if ($customerEmail) {
                Mail::to($customerEmail)->send(new AppointmentApprovedMail($appointment));
            }

            $smsService = new SmsService();
            $smsService->sendAppointmentConfirmation($appointment);

            return back()->with('success', 'Appointment approved successfully. Email and SMS notification sent.');
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

        // Send email notification
        if ($customerEmail) {
            Mail::to($customerEmail)->send(new AppointmentDeletedMail($appointment, $reason));
        }

        // Optionally send SMS
        $smsService = new \App\Services\SmsService();
        $smsService->sendAppointmentCancellation($appointment);

        return back()->with('success', 'Appointment cancelled successfully and email notification sent.');
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);
        return back()->with('success', 'Appointment marked as completed.');
    }
}
