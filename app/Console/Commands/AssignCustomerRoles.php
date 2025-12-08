<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignCustomerRoles extends Command
{
    protected $signature = 'users:assign-customer-role';
    protected $description = 'Assign customer role to users without roles';

    public function handle()
    {
        $users = User::whereDoesntHave('roles')->get();
        foreach ($users as $user) {
            $user->assignRole('customer');
        }
        $this->info("Assigned customer role to {$users->count()} users");
    }
}