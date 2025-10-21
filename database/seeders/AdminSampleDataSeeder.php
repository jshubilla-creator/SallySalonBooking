<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Feedback;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@salon.com',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, City, State 12345',
            'date_of_birth' => '1985-01-15',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Manager Users
        $manager1 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@salon.com',
            'phone' => '+1234567891',
            'address' => '456 Manager Ave, City, State 12345',
            'date_of_birth' => '1990-03-22',
            'gender' => 'female',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $manager1->assignRole('manager');

        $manager2 = User::create([
            'name' => 'Michael Chen',
            'email' => 'michael@salon.com',
            'phone' => '+1234567892',
            'address' => '789 Manager Blvd, City, State 12345',
            'date_of_birth' => '1988-07-10',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $manager2->assignRole('manager');

        // Create Customer Users
        $customers = [
            [
                'name' => 'Emily Davis',
                'email' => 'emily@email.com',
                'phone' => '+1234567893',
                'address' => '321 Customer St, City, State 12345',
                'date_of_birth' => '1995-05-18',
                'gender' => 'female',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@email.com',
                'phone' => '+1234567894',
                'address' => '654 Customer Ave, City, State 12345',
                'date_of_birth' => '1992-11-30',
                'gender' => 'male',
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'lisa@email.com',
                'phone' => '+1234567895',
                'address' => '987 Customer Rd, City, State 12345',
                'date_of_birth' => '1987-09-14',
                'gender' => 'female',
            ],
            [
                'name' => 'James Taylor',
                'email' => 'james@email.com',
                'phone' => '+1234567896',
                'address' => '147 Customer Ln, City, State 12345',
                'date_of_birth' => '1993-12-05',
                'gender' => 'male',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@email.com',
                'phone' => '+1234567897',
                'address' => '258 Customer Dr, City, State 12345',
                'date_of_birth' => '1991-04-25',
                'gender' => 'female',
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = User::create([
                ...$customerData,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $customer->assignRole('customer');
        }

        $this->command->info('Sample users created successfully!');
    }
}
