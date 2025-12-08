<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for appointments scheduled for tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending appointment reminders...');

        $tomorrow = Carbon::tomorrow();

        // Get appointments for tomorrow
        $appointments = Appointment::with(['user', 'service', 'specialist'])
            ->whereDate('appointment_date', $tomorrow)
            ->whereIn('status', ['confirmed', 'pending'])
            ->get();

        $sentCount = 0;

        foreach ($appointments as $appointment) {
            if ($appointment->user->email) {
                try {
                    Mail::to($appointment->user->email)->send(new AppointmentReminderMail($appointment));
                    $sentCount++;
                    $this->line("Reminder sent to {$appointment->user->name} ({$appointment->user->email})");
                } catch (\Exception $e) {
                    $this->error("Failed to send reminder to {$appointment->user->name}: {$e->getMessage()}");
                }
            } else {
                $this->warn("No email for {$appointment->user->name}");
            }
        }

        $this->info("Sent {$sentCount} reminders out of {$appointments->count()} appointments.");

        return Command::SUCCESS;
    }
}
