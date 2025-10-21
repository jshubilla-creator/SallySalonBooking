<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Services\SmsService;
use Illuminate\Console\Command;
use Carbon\Carbon;

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
    protected $description = 'Send SMS reminders for appointments scheduled for tomorrow';

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

        $smsService = new SmsService();
        $sentCount = 0;

        foreach ($appointments as $appointment) {
            if ($appointment->user->phone) {
                $success = $smsService->sendAppointmentReminder($appointment);
                if ($success) {
                    $sentCount++;
                    $this->line("Reminder sent to {$appointment->user->name} ({$appointment->user->phone})");
                } else {
                    $this->error("Failed to send reminder to {$appointment->user->name}");
                }
            } else {
                $this->warn("No phone number for {$appointment->user->name}");
            }
        }

        $this->info("Sent {$sentCount} reminders out of {$appointments->count()} appointments.");

        return Command::SUCCESS;
    }
}
