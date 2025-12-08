<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\SettingsService;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settingsService = new SettingsService();

        // Add notification settings
        $settingsService->set('notification_settings', [
            'sms_notifications' => true,
            'sms_confirmations' => true,
            'appointment_reminders' => true,
            'email_notifications' => true,
        ]);

        $this->command->info('Settings seeded successfully!');
    }
}