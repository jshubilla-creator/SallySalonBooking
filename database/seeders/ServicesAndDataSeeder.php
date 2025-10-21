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

class ServicesAndDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Services
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
                'name' => 'Hair Highlights',
                'description' => 'Professional hair highlighting service',
                'price' => 85.00,
                'duration_minutes' => 90,
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
            [
                'name' => 'Pedicure',
                'description' => 'Relaxing pedicure with foot massage',
                'price' => 50.00,
                'duration_minutes' => 60,
                'category' => 'Nails',
                'is_active' => true,
            ],
            [
                'name' => 'Eyebrow Shaping',
                'description' => 'Professional eyebrow shaping and tinting',
                'price' => 25.00,
                'duration_minutes' => 30,
                'category' => 'Beauty',
                'is_active' => true,
            ],
            [
                'name' => 'Makeup Application',
                'description' => 'Professional makeup for special occasions',
                'price' => 65.00,
                'duration_minutes' => 90,
                'category' => 'Beauty',
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Create Specialists
        $specialists = [
            [
                'name' => 'Jennifer Smith',
                'email' => 'jennifer@salon.com',
                'phone' => '+1234567898',
                'bio' => 'Experienced hairstylist with 8 years in the industry. Specializes in cutting and coloring.',
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
                'name' => 'Robert Martinez',
                'email' => 'robert@salon.com',
                'phone' => '+1234567899',
                'bio' => 'Professional colorist with expertise in highlights and balayage techniques.',
                'specialization' => 'Hair Coloring',
                'experience_years' => 6,
                'working_hours' => [
                    ['day' => 'monday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'tuesday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'wednesday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'thursday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'friday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'saturday', 'start_time' => '09:00', 'end_time' => '15:00', 'is_available' => true],
                    ['day' => 'sunday', 'start_time' => '09:00', 'end_time' => '15:00', 'is_available' => false],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Amanda Lee',
                'email' => 'amanda@salon.com',
                'phone' => '+1234567900',
                'bio' => 'Skincare specialist with advanced training in facial treatments and skin analysis.',
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
            [
                'name' => 'Jessica Wong',
                'email' => 'jessica@salon.com',
                'phone' => '+1234567901',
                'bio' => 'Nail technician specializing in manicures, pedicures, and nail art.',
                'specialization' => 'Nail Care',
                'experience_years' => 4,
                'working_hours' => [
                    ['day' => 'monday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'tuesday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'wednesday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'thursday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'friday', 'start_time' => '10:00', 'end_time' => '18:00', 'is_available' => true],
                    ['day' => 'saturday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => true],
                    ['day' => 'sunday', 'start_time' => '09:00', 'end_time' => '17:00', 'is_available' => false],
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
        $beautyServices = Service::where('category', 'Beauty')->get();

        $specialists = Specialist::all();
        $specialists[0]->services()->sync($hairServices->pluck('id')); // Jennifer - Hair Styling
        $specialists[1]->services()->sync($hairServices->pluck('id')); // Robert - Hair Coloring
        $specialists[2]->services()->sync($skincareServices->pluck('id')); // Amanda - Skincare
        $specialists[3]->services()->sync($nailServices->pluck('id')); // Jessica - Nail Care

        // Create Inventory Items
        $inventoryItems = [
            [
                'item_name' => 'Shampoo - Professional Grade',
                'description' => 'High-quality professional shampoo for all hair types',
                'category' => 'Hair Care',
                'quantity' => 25,
                'unit_price' => 15.50,
                'supplier' => 'Beauty Supply Co.',
                'is_active' => true,
            ],
            [
                'item_name' => 'Hair Color - Blonde',
                'description' => 'Professional hair coloring product for blonde shades',
                'category' => 'Hair Care',
                'quantity' => 12,
                'unit_price' => 25.00,
                'supplier' => 'Color Pro Inc.',
                'is_active' => true,
            ],
            [
                'item_name' => 'Facial Cleanser',
                'description' => 'Gentle facial cleanser for all skin types',
                'category' => 'Skincare',
                'quantity' => 18,
                'unit_price' => 22.75,
                'supplier' => 'Skin Care Solutions',
                'is_active' => true,
            ],
            [
                'item_name' => 'Nail Polish - Red',
                'description' => 'Long-lasting nail polish in classic red',
                'category' => 'Nail Care',
                'quantity' => 30,
                'unit_price' => 8.99,
                'supplier' => 'Nail Art Supplies',
                'is_active' => true,
            ],
            [
                'item_name' => 'Cotton Pads',
                'description' => 'Disposable cotton pads for various treatments',
                'category' => 'Supplies',
                'quantity' => 5,
                'unit_price' => 5.25,
                'supplier' => 'Beauty Supply Co.',
                'is_active' => true,
            ],
            [
                'item_name' => 'Towels - White',
                'description' => 'Professional salon towels',
                'category' => 'Supplies',
                'quantity' => 2,
                'unit_price' => 12.00,
                'supplier' => 'Salon Equipment Ltd.',
                'is_active' => true,
            ],
        ];

        foreach ($inventoryItems as $itemData) {
            Inventory::create($itemData);
        }

        // Create Appointments
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->get();

        $appointments = [
            [
                'customer_id' => $customers[0]->id,
                'service_id' => 1, // Haircut & Styling
                'specialist_id' => 1, // Jennifer Smith
                'appointment_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'status' => 'confirmed',
                'total_price' => 45.00,
                'notes' => 'Regular haircut and styling',
            ],
            [
                'customer_id' => $customers[1]->id,
                'service_id' => 2, // Hair Coloring
                'specialist_id' => 2, // Robert Martinez
                'appointment_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'status' => 'pending',
                'total_price' => 120.00,
                'notes' => 'Full hair coloring service',
            ],
            [
                'customer_id' => $customers[2]->id,
                'service_id' => 4, // Facial Treatment
                'specialist_id' => 3, // Amanda Lee
                'appointment_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'start_time' => '11:00:00',
                'end_time' => '12:15:00',
                'status' => 'completed',
                'total_price' => 75.00,
                'notes' => 'Deep cleansing facial',
            ],
            [
                'customer_id' => $customers[3]->id,
                'service_id' => 5, // Manicure
                'specialist_id' => 4, // Jessica Wong
                'appointment_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'start_time' => '15:00:00',
                'end_time' => '15:45:00',
                'status' => 'confirmed',
                'total_price' => 35.00,
                'notes' => 'Classic manicure with nail polish',
            ],
            [
                'customer_id' => $customers[4]->id,
                'service_id' => 6, // Pedicure
                'specialist_id' => 4, // Jessica Wong
                'appointment_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
                'status' => 'pending',
                'total_price' => 50.00,
                'notes' => 'Relaxing pedicure with foot massage',
            ],
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }

        // Create Feedback
        $feedbackData = [
            [
                'customer_id' => $customers[2]->id,
                'appointment_id' => 3,
                'rating' => 5,
                'comment' => 'Amazing facial treatment! My skin feels so refreshed and clean. Amanda was very professional and knowledgeable.',
                'type' => 'appointment',
            ],
            [
                'customer_id' => $customers[0]->id,
                'appointment_id' => null,
                'rating' => 4,
                'comment' => 'Great salon overall! The staff is friendly and the atmosphere is relaxing. Would definitely recommend.',
                'type' => 'general',
            ],
            [
                'customer_id' => $customers[1]->id,
                'appointment_id' => null,
                'rating' => 5,
                'comment' => 'Excellent service! The booking process was easy and the staff was very accommodating.',
                'type' => 'service',
            ],
        ];

        foreach ($feedbackData as $feedback) {
            Feedback::create($feedback);
        }

        $this->command->info('Sample services, specialists, appointments, and feedback created successfully!');
    }
}
