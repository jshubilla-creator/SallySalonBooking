<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialist;
use App\Models\Service;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@salon.com',
                'phone' => '+1234567891',
                'bio' => 'Experienced hair stylist with 8 years of expertise in cutting, coloring, and styling.',
                'specialization' => 'Hair Stylist',
                'experience_years' => 8,
                'working_hours' => [
                    'monday' => ['start' => '09:00', 'end' => '18:00'],
                    'tuesday' => ['start' => '09:00', 'end' => '18:00'],
                    'wednesday' => ['start' => '09:00', 'end' => '18:00'],
                    'thursday' => ['start' => '09:00', 'end' => '18:00'],
                    'friday' => ['start' => '09:00', 'end' => '18:00'],
                    'saturday' => ['start' => '10:00', 'end' => '16:00'],
                    'sunday' => ['start' => 'closed', 'end' => 'closed'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Maria Rodriguez',
                'email' => 'maria@salon.com',
                'phone' => '+1234567892',
                'bio' => 'Professional nail artist specializing in manicures, pedicures, and nail art.',
                'specialization' => 'Nail Artist',
                'experience_years' => 5,
                'working_hours' => [
                    'monday' => ['start' => '10:00', 'end' => '19:00'],
                    'tuesday' => ['start' => '10:00', 'end' => '19:00'],
                    'wednesday' => ['start' => '10:00', 'end' => '19:00'],
                    'thursday' => ['start' => '10:00', 'end' => '19:00'],
                    'friday' => ['start' => '10:00', 'end' => '19:00'],
                    'saturday' => ['start' => '09:00', 'end' => '17:00'],
                    'sunday' => ['start' => 'closed', 'end' => 'closed'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Emma Thompson',
                'email' => 'emma@salon.com',
                'phone' => '+1234567893',
                'bio' => 'Beauty specialist with expertise in facials, makeup, and skincare treatments.',
                'specialization' => 'Beauty Specialist',
                'experience_years' => 6,
                'working_hours' => [
                    'monday' => ['start' => '09:00', 'end' => '17:00'],
                    'tuesday' => ['start' => '09:00', 'end' => '17:00'],
                    'wednesday' => ['start' => '09:00', 'end' => '17:00'],
                    'thursday' => ['start' => '09:00', 'end' => '17:00'],
                    'friday' => ['start' => '09:00', 'end' => '17:00'],
                    'saturday' => ['start' => '10:00', 'end' => '16:00'],
                    'sunday' => ['start' => 'closed', 'end' => 'closed'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Lisa Chen',
                'email' => 'lisa@salon.com',
                'phone' => '+1234567894',
                'bio' => 'Master stylist specializing in hair treatments, rebonding, and advanced coloring techniques.',
                'specialization' => 'Master Hair Stylist',
                'experience_years' => 12,
                'working_hours' => [
                    'monday' => ['start' => '08:00', 'end' => '18:00'],
                    'tuesday' => ['start' => '08:00', 'end' => '18:00'],
                    'wednesday' => ['start' => '08:00', 'end' => '18:00'],
                    'thursday' => ['start' => '08:00', 'end' => '18:00'],
                    'friday' => ['start' => '08:00', 'end' => '18:00'],
                    'saturday' => ['start' => '09:00', 'end' => '17:00'],
                    'sunday' => ['start' => 'closed', 'end' => 'closed'],
                ],
                'is_available' => true,
            ],
        ];

        foreach ($specialists as $specialist) {
            $createdSpecialist = Specialist::create($specialist);

            // Assign services based on specialization
            if ($specialist['specialization'] === 'Hair Stylist' || $specialist['specialization'] === 'Master Hair Stylist') {
                $hairServices = Service::where('category', 'Hair')->get();
                $createdSpecialist->services()->attach($hairServices);
            } elseif ($specialist['specialization'] === 'Nail Artist') {
                $nailServices = Service::where('category', 'Nail')->get();
                $createdSpecialist->services()->attach($nailServices);
            } elseif ($specialist['specialization'] === 'Beauty Specialist') {
                $beautyServices = Service::where('category', 'Beauty')->get();
                $createdSpecialist->services()->attach($beautyServices);
            }
        }
    }
}
