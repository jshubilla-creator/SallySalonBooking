<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            // Hair Services
            [
                'name' => 'Haircut',
                'description' => 'Professional haircut and styling',
                'price' => 25.00,
                'duration_minutes' => 45,
                'category' => 'Hair',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Color',
                'description' => 'Full hair coloring service',
                'price' => 80.00,
                'duration_minutes' => 120,
                'category' => 'Hair',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Rebond',
                'description' => 'Hair straightening treatment',
                'price' => 150.00,
                'duration_minutes' => 180,
                'category' => 'Hair',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Treatment',
                'description' => 'Deep conditioning and treatment',
                'price' => 45.00,
                'duration_minutes' => 60,
                'category' => 'Hair',
                'is_active' => true,
            ],

            // Nail Services
            [
                'name' => 'Manicure',
                'description' => 'Professional nail care and polish',
                'price' => 30.00,
                'duration_minutes' => 60,
                'category' => 'Nail',
                'is_active' => true,
            ],
            [
                'name' => 'Pedicure',
                'description' => 'Foot care and nail polish',
                'price' => 40.00,
                'duration_minutes' => 75,
                'category' => 'Nail',
                'is_active' => true,
            ],
            [
                'name' => 'Foot Spa',
                'description' => 'Relaxing foot spa treatment',
                'price' => 50.00,
                'duration_minutes' => 90,
                'category' => 'Nail',
                'is_active' => true,
            ],

            // Additional Services
            [
                'name' => 'Eyebrow Shaping',
                'description' => 'Professional eyebrow shaping and styling',
                'price' => 20.00,
                'duration_minutes' => 30,
                'category' => 'Beauty',
                'is_active' => true,
            ],
            [
                'name' => 'Facial Treatment',
                'description' => 'Deep cleansing facial treatment',
                'price' => 60.00,
                'duration_minutes' => 90,
                'category' => 'Beauty',
                'is_active' => true,
            ],
            [
                'name' => 'Makeup Application',
                'description' => 'Professional makeup application',
                'price' => 70.00,
                'duration_minutes' => 90,
                'category' => 'Beauty',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
