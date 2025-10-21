<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventoryItems = [
            // Hair Products
            [
                'name' => 'Professional Shampoo',
                'description' => 'High-quality salon shampoo for all hair types',
                'category' => 'Product',
                'quantity' => 15,
                'min_quantity' => 5,
                'unit_price' => 12.50,
                'supplier' => 'Beauty Supply Co.',
                'expiry_date' => now()->addMonths(24),
                'is_active' => true,
            ],
            [
                'name' => 'Hair Conditioner',
                'description' => 'Deep conditioning treatment for damaged hair',
                'category' => 'Product',
                'quantity' => 8,
                'min_quantity' => 3,
                'unit_price' => 15.00,
                'supplier' => 'Beauty Supply Co.',
                'expiry_date' => now()->addMonths(18),
                'is_active' => true,
            ],
            [
                'name' => 'Hair Color Kit',
                'description' => 'Professional hair coloring kit',
                'category' => 'Product',
                'quantity' => 2,
                'min_quantity' => 5,
                'unit_price' => 25.00,
                'supplier' => 'Color Pro',
                'expiry_date' => now()->addMonths(12),
                'is_active' => true,
            ],

            // Nail Supplies
            [
                'name' => 'Nail Polish Remover',
                'description' => 'Acetone-free nail polish remover',
                'category' => 'Supply',
                'quantity' => 20,
                'min_quantity' => 10,
                'unit_price' => 8.00,
                'supplier' => 'Nail Essentials',
                'expiry_date' => now()->addMonths(36),
                'is_active' => true,
            ],
            [
                'name' => 'Nail Files',
                'description' => 'Professional nail files (pack of 50)',
                'category' => 'Supply',
                'quantity' => 3,
                'min_quantity' => 10,
                'unit_price' => 15.00,
                'supplier' => 'Nail Essentials',
                'is_active' => true,
            ],
            [
                'name' => 'Nail Polish Set',
                'description' => 'Professional nail polish collection (20 colors)',
                'category' => 'Product',
                'quantity' => 1,
                'min_quantity' => 2,
                'unit_price' => 45.00,
                'supplier' => 'Nail Essentials',
                'expiry_date' => now()->addMonths(30),
                'is_active' => true,
            ],

            // Equipment
            [
                'name' => 'Hair Dryer',
                'description' => 'Professional hair dryer with multiple heat settings',
                'category' => 'Equipment',
                'quantity' => 4,
                'min_quantity' => 2,
                'unit_price' => 120.00,
                'supplier' => 'Salon Equipment Inc.',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Straightener',
                'description' => 'Ceramic flat iron for hair straightening',
                'category' => 'Equipment',
                'quantity' => 3,
                'min_quantity' => 2,
                'unit_price' => 85.00,
                'supplier' => 'Salon Equipment Inc.',
                'is_active' => true,
            ],
            [
                'name' => 'Manicure Table',
                'description' => 'Professional manicure table with storage',
                'category' => 'Equipment',
                'quantity' => 2,
                'min_quantity' => 1,
                'unit_price' => 300.00,
                'supplier' => 'Salon Equipment Inc.',
                'is_active' => true,
            ],

            // Tools
            [
                'name' => 'Hair Cutting Scissors',
                'description' => 'Professional hair cutting scissors set',
                'category' => 'Tool',
                'quantity' => 6,
                'min_quantity' => 3,
                'unit_price' => 45.00,
                'supplier' => 'Professional Tools',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Brushes',
                'description' => 'Professional hair brushes (various sizes)',
                'category' => 'Tool',
                'quantity' => 12,
                'min_quantity' => 5,
                'unit_price' => 8.00,
                'supplier' => 'Professional Tools',
                'is_active' => true,
            ],
            [
                'name' => 'Nail Clippers',
                'description' => 'Professional nail clippers set',
                'category' => 'Tool',
                'quantity' => 4,
                'min_quantity' => 2,
                'unit_price' => 12.00,
                'supplier' => 'Professional Tools',
                'is_active' => true,
            ],
        ];

        foreach ($inventoryItems as $item) {
            Inventory::create($item);
        }
    }
}
