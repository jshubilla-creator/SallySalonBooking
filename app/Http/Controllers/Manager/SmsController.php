<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SmsController extends Controller
{
public function index()
{
    // Example stats placeholders
    $smsSentToday = 0;
    $pendingReminders = 0;
    $successRate = 95;

    // ✅ Fetch users who have approved bookings
    $confirmedBookings = \App\Models\Appointment::with(['user', 'specialist', 'service'])
        ->where('status', 'confirmed') // ← use “approved” (not “confirm”)
        ->get();

    return view('manager.sms.index', compact(
        'smsSentToday',
        'pendingReminders',
        'successRate',
        'confirmedBookings'
    ));
}

    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:500',
        ]);

        $smsService = new SmsService();
        $success = $smsService->sendSms($request->phone, $request->message);

        if ($success) {
            return back()->with('success', 'SMS sent successfully!');
        } else {
            return back()->with('error', 'Failed to send SMS. Please try again.');
        }
    }

    public function sendReminders()
    {
        $tomorrow = Carbon::tomorrow();

        $appointments = Appointment::with(['user', 'service', 'specialist'])
            ->whereDate('appointment_date', $tomorrow)
            ->whereIn('status', ['confirmed', 'pending'])
            ->get();

        $smsService = new SmsService();
        $sentCount = 0;

        foreach ($appointments as $appointment) {
            if ($appointment->user->phone) {
                $success = $smsService->sendAppointmentReminder($appointment);
                if ($success) {
                    $sentCount++;
                }
            }
        }

        return back()->with('success', "Sent {$sentCount} reminder SMS messages.");
    }
}
