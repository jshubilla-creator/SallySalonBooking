<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Feedback;
use App\Models\User;
use Carbon\Carbon;

class BasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic services
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
            [
                'name' => 'Manicure',
                'description' => 'Classic manicure with nail polish',
                'price' => 35.00,
                'duration_minutes' => 45,
                'category' => 'Nails',
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Create basic specialists
        $specialists = [
            [
                'name' => 'Jennifer Smith',
                'email' => 'jennifer@salon.com',
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
                'name' => 'Amanda Lee',
                'email' => 'amanda@salon.com',
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

        foreach ($specialists as $specialistData) {
            Specialist::create($specialistData);
        }

        // Associate specialists with services
        $hairServices = Service::where('category', 'Hair')->get();
        $skincareServices = Service::where('category', 'Skincare')->get();
        $nailServices = Service::where('category', 'Nails')->get();

        $specialists = Specialist::all();
        if ($specialists->count() >= 2) {
            $specialists[0]->services()->sync($hairServices->pluck('id')); // Jennifer - Hair Styling
            $specialists[1]->services()->sync($skincareServices->pluck('id')); // Amanda - Skincare
        }

        // Create basic inventory
        $inventoryItems = [
            [
                'name' => 'Shampoo - Professional Grade',
                'description' => 'High-quality professional shampoo for all hair types',
                'category' => 'Hair Care',
                'quantity' => 25,
                'unit_price' => 15.50,
                'supplier' => 'Beauty Supply Co.',
                'is_active' => true,
            ],
            [
                'name' => 'Facial Cleanser',
                'description' => 'Gentle facial cleanser for all skin types',
                'category' => 'Skincare',
                'quantity' => 18,
                'unit_price' => 22.75,
                'supplier' => 'Skin Care Solutions',
                'is_active' => true,
            ],
        ];

        foreach ($inventoryItems as $itemData) {
            Inventory::create($itemData);
        }

        // Create sample appointments if customers exist
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->get();

        if ($customers->count() > 0 && Service::count() > 0 && Specialist::count() > 0) {
            $appointments = [
                [
                    'customer_id' => $customers[0]->id,
                    'service_id' => Service::first()->id,
                    'specialist_id' => Specialist::first()->id,
                    'appointment_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'start_time' => '10:00:00',
                    'end_time' => '11:00:00',
                    'status' => 'confirmed',
                    'total_price' => 45.00,
                    'notes' => 'Regular appointment',
                ],
                [
                    'customer_id' => $customers->count() > 1 ? $customers[1]->id : $customers[0]->id,
                    'service_id' => Service::skip(1)->first() ? Service::skip(1)->first()->id : Service::first()->id,
                    'specialist_id' => Specialist::count() > 1 ? Specialist::skip(1)->first()->id : Specialist::first()->id,
                    'appointment_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                    'start_time' => '14:00:00',
                    'end_time' => '15:30:00',
                    'status' => 'completed',
                    'total_price' => 75.00,
                    'notes' => 'Completed appointment',
                ],
            ];

            foreach ($appointments as $appointmentData) {
                Appointment::create($appointmentData);
            }

            // Create sample feedback
            $feedbackData = [
                [
                    'customer_id' => $customers[0]->id,
                    'appointment_id' => Appointment::first()->id,
                    'rating' => 5,
                    'comment' => 'Excellent service! Very professional and friendly staff.',
                    'type' => 'appointment',
                ],
                [
                    'customer_id' => $customers->count() > 1 ? $customers[1]->id : $customers[0]->id,
                    'appointment_id' => null,
                    'rating' => 4,
                    'comment' => 'Great salon overall! Would definitely recommend.',
                    'type' => 'general',
                ],
            ];

            foreach ($feedbackData as $feedback) {
                Feedback::create($feedback);
            }
        }

        $this->command->info('Basic sample data created successfully!');
    }
}
