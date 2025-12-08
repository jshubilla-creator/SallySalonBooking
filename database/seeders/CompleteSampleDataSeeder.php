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

class CompleteSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User (if not exists)
        $admin = User::firstOrCreate(
            ['email' => 'admin@salon.com'],
            [
                'name' => 'Admin User',
                'phone' => '+1234567890',
                'address' => '123 Admin Street, City, State 12345',
                'date_of_birth' => '1985-01-15',
                'gender' => 'male',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create Manager Users (if not exist)
        $manager1 = User::firstOrCreate(
            ['email' => 'sarah@salon.com'],
            [
                'name' => 'Sarah Johnson',
                'phone' => '+1234567891',
                'address' => '456 Manager Ave, City, State 12345',
                'date_of_birth' => '1990-03-22',
                'gender' => 'female',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$manager1->hasRole('manager')) {
            $manager1->assignRole('manager');
        }

        // Create Customer Users (if not exist)
        $customers = [
            [
                'email' => 'emily@email.com',
                'name' => 'Emily Davis',
                'phone' => '+1234567893',
                'address' => '321 Customer St, City, State 12345',
                'date_of_birth' => '1995-05-18',
                'gender' => 'female',
            ],
            [
                'email' => 'david@email.com',
                'name' => 'David Wilson',
                'phone' => '+1234567894',
                'address' => '654 Customer Ave, City, State 12345',
                'date_of_birth' => '1992-11-30',
                'gender' => 'male',
            ],
        ];

        $customerUsers = [];
        foreach ($customers as $customerData) {
            $customer = User::firstOrCreate(
                ['email' => $customerData['email']],
                [
                    ...$customerData,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            if (!$customer->hasRole('customer')) {
                $customer->assignRole('customer');
            }
            $customerUsers[] = $customer;
        }

        // Create Services (if not exist)
        $services = [
            [
                'name' => 'Haircut & Styling',
                'description' => 'Professional haircut with styling and blow-dry',
                'price' => 45.00,
                'duration_minutes' => 60,
                'category' => 'Hair',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Coloring',
                'description' => 'Full hair coloring service with premium products',
                'price' => 120.00,
                'duration_minutes' => 120,
                'category' => 'Hair',
                'is_active' => true,
            ],
            [
                'name' => 'Facial Treatment',
                'description' => 'Deep cleansing facial with moisturizing',
                'price' => 75.00,
                'duration_minutes' => 75,
                'category' => 'Skincare',
                'is_active' => true,
            ],
        ];

        $serviceModels = [];
        foreach ($services as $serviceData) {
            $service = Service::firstOrCreate(
                ['name' => $serviceData['name']],
                $serviceData
            );
            $serviceModels[] = $service;
        }

        // Create Specialists (if not exist)
        $specialists = [
            [
                'email' => 'jennifer@salon.com',
                'name' => 'Jennifer Smith',
                'phone' => '+1234567898',
                'bio' => 'Experienced hairstylist with 8 years in the industry.',
                'specialization' => 'Hair Styling',
                'experience_years' => 8,
                'working_hours' => [
                    ['day' => 'monday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'tuesday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'wednesday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'thursday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'friday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'saturday', 'start_time' => '10:00', 'end_time' => '16:00', 'is_available' => true],
                    ['day' => 'sunday', 'start_time' => '10:00', 'end_time' => '16:00', 'is_available' => false],
                ],
                'is_available' => true,
            ],
            [
                'email' => 'amanda@salon.com',
                'name' => 'Amanda Lee',
                'phone' => '+1234567900',
                'bio' => 'Skincare specialist with advanced training in facial treatments.',
                'specialization' => 'Skincare',
                'experience_years' => 5,
                'working_hours' => [
                    ['day' => 'monday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'tuesday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'wednesday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'thursday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'friday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'saturday', 'start_time' => '10:00', 'end_time' => '16:00', 'is_available' => true],
                    ['day' => 'sunday', 'start_time' => '10:00', 'end_time' => '16:00', 'is_available' => false],
                ],
                'is_available' => true,
            ],
        ];

        $specialistModels = [];
        foreach ($specialists as $specialistData) {
            $specialist = Specialist::firstOrCreate(
                ['email' => $specialistData['email']],
                $specialistData
            );
            $specialistModels[] = $specialist;
        }

        // Assign services to specialists based on their specialization
        if (count($specialistModels) > 0 && count($serviceModels) > 0) {
            // Jennifer Smith (Hair Styling) - assign hair services
            $hairSpecialist = $specialistModels[0]; // Jennifer Smith
            $hairServices = array_filter($serviceModels, function($service) {
                return $service->category === 'Hair';
            });
            foreach ($hairServices as $service) {
                $hairSpecialist->services()->syncWithoutDetaching([$service->id]);
            }

            // Amanda Lee (Skincare) - assign skincare services
            $skincareSpecialist = $specialistModels[1]; // Amanda Lee
            $skincareServices = array_filter($serviceModels, function($service) {
                return $service->category === 'Skincare';
            });
            foreach ($skincareServices as $service) {
                $skincareSpecialist->services()->syncWithoutDetaching([$service->id]);
            }
        }

        // Create sample appointments
        if (count($customerUsers) > 0 && count($serviceModels) > 0 && count($specialistModels) > 0) {
            $appointments = [
                [
                    'user_id' => $customerUsers[0]->id,
                    'service_id' => $serviceModels[0]->id,
                    'specialist_id' => $specialistModels[0]->id,
                    'appointment_date' => Carbon::tomorrow(),
                    'start_time' => Carbon::tomorrow()->setTimeFromTimeString('10:00:00'),
                    'end_time' => Carbon::tomorrow()->setTimeFromTimeString('11:00:00'),
                    'status' => 'confirmed',
                    'total_price' => 45.00,
                    'notes' => 'Regular appointment',
                ],
                [
                    'user_id' => $customerUsers[1]->id,
                    'service_id' => $serviceModels[2]->id,
                    'specialist_id' => $specialistModels[1]->id,
                    'appointment_date' => Carbon::now()->addDays(2),
                    'start_time' => Carbon::now()->addDays(2)->setTimeFromTimeString('14:00:00'),
                    'end_time' => Carbon::now()->addDays(2)->setTimeFromTimeString('15:15:00'),
                    'status' => 'completed',
                    'total_price' => 75.00,
                    'notes' => 'Completed appointment',
                ],
            ];

            foreach ($appointments as $appointmentData) {
                Appointment::firstOrCreate(
                    [
                        'user_id' => $appointmentData['user_id'],
                        'service_id' => $appointmentData['service_id'],
                        'specialist_id' => $appointmentData['specialist_id'],
                        'appointment_date' => $appointmentData['appointment_date'],
                        'start_time' => $appointmentData['start_time'],
                    ],
                    $appointmentData
                );
            }

            // Create sample feedback
            $feedbackData = [
                [
                    'user_id' => $customerUsers[1]->id,
                    'appointment_id' => Appointment::where('status', 'completed')->first()?->id,
                    'rating' => 5,
                    'comment' => 'Excellent service! Very professional and friendly staff.',
                    'type' => 'service',
                    'is_public' => true,
                ],
                [
                    'user_id' => $customerUsers[0]->id,
                    'appointment_id' => null,
                    'rating' => 4,
                    'comment' => 'Great salon overall! Would definitely recommend.',
                    'type' => 'general',
                    'is_public' => true,
                ],
                [
                    'user_id' => $customerUsers[0]->id,
                    'appointment_id' => Appointment::where('status', 'confirmed')->first()?->id,
                    'rating' => 5,
                    'comment' => 'Amazing haircut and styling! The specialist was very attentive.',
                    'type' => 'service',
                    'is_public' => true,
                ],
                [
                    'user_id' => $customerUsers[1]->id,
                    'appointment_id' => null,
                    'rating' => 3,
                    'comment' => 'Good service but could improve on appointment scheduling.',
                    'type' => 'general',
                    'is_public' => false,
                ],
            ];

            foreach ($feedbackData as $feedback) {
                Feedback::firstOrCreate(
                    [
                        'user_id' => $feedback['user_id'],
                        'comment' => $feedback['comment'],
                    ],
                    $feedback
                );
            }
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('Admin Login: admin@salon.com / password');
        $this->command->info('Manager Login: sarah@salon.com / password');
        $this->command->info('Customer Login: emily@email.com / password');
    }
}
