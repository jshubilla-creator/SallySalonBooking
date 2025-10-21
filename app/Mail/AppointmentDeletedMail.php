<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $reason)
    {
        $this->appointment = $appointment;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('💔 Appointment Cancelled - Sally Salon')
                    ->from('build3vs@gmail.com', 'Sally Salon')
                    ->markdown('emails.appointments.cancelled')
                    ->with([
                        'appointment' => $this->appointment,
                        'reason' => $this->reason,
                    ]);
    }
}
