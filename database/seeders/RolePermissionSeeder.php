<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Create permissions
        $permissions = [
            // Appointment permissions
            'view-appointments',
            'create-appointments',
            'edit-appointments',
            'delete-appointments',
            'approve-appointments',
            'cancel-appointments',

            // Service permissions
            'view-services',
            'create-services',
            'edit-services',
            'delete-services',

            // Specialist permissions
            'view-specialists',
            'create-specialists',
            'edit-specialists',
            'delete-specialists',

            // User management permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Inventory permissions
            'view-inventory',
            'create-inventory',
            'edit-inventory',
            'delete-inventory',

            // Feedback permissions
            'view-feedback',
            'create-feedback',
            'edit-feedback',
            'delete-feedback',

            // Analytics permissions
            'view-analytics',
            'view-reports',

            // Settings permissions
            'manage-settings',
            'manage-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());

        $managerRole->givePermissionTo([
            'view-appointments', 'create-appointments', 'edit-appointments', 'approve-appointments', 'cancel-appointments',
            'view-services', 'create-services', 'edit-services', 'delete-services',
            'view-specialists', 'create-specialists', 'edit-specialists',
            'view-users', 'create-users', 'edit-users',
            'view-inventory', 'create-inventory', 'edit-inventory', 'delete-inventory',
            'view-feedback', 'create-feedback', 'edit-feedback',
            'view-analytics', 'view-reports',
            'manage-settings',
        ]);

        $customerRole->givePermissionTo([
            'view-appointments', 'create-appointments', 'edit-appointments', 'cancel-appointments',
            'view-services',
            'view-specialists',
            'create-feedback',
        ]);

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@salon.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create default manager user
        $manager = User::firstOrCreate(
            ['email' => 'manager@salon.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password'),
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
            ]
        );
        if (!$manager->hasRole('manager')) {
            $manager->assignRole('manager');
        }

        // Create sample customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'phone' => '+1234567890',
                'address' => '123 Main St, City, State',
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
            ]
        );
        if (!$customer->hasRole('customer')) {
            $customer->assignRole('customer');
        }
    }
}
