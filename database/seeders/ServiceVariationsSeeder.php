<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceVariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $haircutVariations = [
            ['name' => 'Classic Cut', 'description' => 'Traditional haircut with scissors', 'price' => 300, 'duration' => 45],
            ['name' => 'Fade Cut', 'description' => 'Modern fade haircut', 'price' => 400, 'duration' => 60],
            ['name' => 'Mohawk', 'description' => 'Edgy mohawk style', 'price' => 500, 'duration' => 75],
            ['name' => 'Buzz Cut', 'description' => 'Short all-over cut', 'price' => 200, 'duration' => 30],
            ['name' => 'Layered Cut', 'description' => 'Layered styling for volume', 'price' => 450, 'duration' => 60]
        ];

        $colorVariations = [
            ['name' => 'Full Color', 'description' => 'Complete hair color change', 'price' => 1500, 'duration' => 180],
            ['name' => 'Highlights', 'description' => 'Partial highlights', 'price' => 1200, 'duration' => 150],
            ['name' => 'Root Touch-up', 'description' => 'Root color maintenance', 'price' => 800, 'duration' => 90],
            ['name' => 'Balayage', 'description' => 'Hand-painted highlights', 'price' => 2000, 'duration' => 240]
        ];

        // Update haircut services
        \App\Models\Service::where('name', 'LIKE', '%haircut%')
            ->orWhere('name', 'LIKE', '%cut%')
            ->update(['variations' => json_encode($haircutVariations)]);

        // Update hair color services
        \App\Models\Service::where('name', 'LIKE', '%color%')
            ->orWhere('name', 'LIKE', '%dye%')
            ->update(['variations' => json_encode($colorVariations)]);
    }
}
