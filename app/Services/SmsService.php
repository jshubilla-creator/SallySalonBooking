<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send SMS notification
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendSms(string $phone, string $message): bool
    {
        try {
            // In a real application, you would integrate with SMS providers like:
            // - Twilio
            // - Nexmo/Vonage
            // - AWS SNS
            // - MessageBird
            // - etc.

            // For demo purposes, we'll just log the SMS
            Log::info('SMS Sent', [
                'phone' => $phone,
                'message' => $message,
                'timestamp' => now()
            ]);

            // Simulate SMS sending delay
            sleep(1);

            return true;
        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'phone' => $phone,
                'message' => $message,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send appointment confirmation SMS
     */
    public function sendAppointmentConfirmation($appointment): bool
    {
        $message = "Hi {$appointment->user->name}! Your appointment for {$appointment->service->name} with {$appointment->specialist->name} on {$appointment->appointment_date->format('M d, Y')} at {$appointment->start_time} has been confirmed. Thank you!";

        return $this->sendSms($appointment->user->phone, $message);
    }

    /**
     * Send appointment reminder SMS
     */
    public function sendAppointmentReminder($appointment): bool
    {
        $message = "Reminder: You have an appointment for {$appointment->service->name} with {$appointment->specialist->name} tomorrow at {$appointment->start_time}. See you soon!";

        return $this->sendSms($appointment->user->phone, $message);
    }

    /**
     * Send appointment cancellation SMS
     */
    public function sendAppointmentCancellation($appointment): bool
    {
        $message = "Hi {$appointment->user->name}, your appointment for {$appointment->service->name} on {$appointment->appointment_date->format('M d, Y')} has been cancelled. Please contact us to reschedule.";

        return $this->sendSms($appointment->user->phone, $message);
    }

    /**
     * Send appointment reschedule SMS
     */
    public function sendAppointmentReschedule($appointment): bool
    {
        $message = "Hi {$appointment->user->name}, your appointment has been rescheduled to {$appointment->appointment_date->format('M d, Y')} at {$appointment->start_time}. Please confirm if this works for you.";

        return $this->sendSms($appointment->user->phone, $message);
    }
}
