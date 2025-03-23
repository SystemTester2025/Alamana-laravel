<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the admin user seeder.
     * This creates an admin user only if no users exist in the database.
     */
    public function run(): void
    {
        // Check if any users already exist
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]);
            
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists. Skipping creation.');
        }
    }
} 