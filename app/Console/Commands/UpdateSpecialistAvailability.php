<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Specialist;

class UpdateSpecialistAvailability extends Command
{
    protected $signature = 'specialists:update-availability';
    protected $description = 'Update specialist availability based on bookings and working hours';

    public function handle()
    {
        $specialists = Specialist::all();
        $updated = 0;

        foreach ($specialists as $specialist) {
            $wasAvailable = $specialist->is_available;
            $specialist->checkAndUpdateAvailability();
            
            if ($wasAvailable !== $specialist->fresh()->is_available) {
                $updated++;
            }
        }

        $this->info("Updated availability for {$updated} specialists.");
        return 0;
    }
}