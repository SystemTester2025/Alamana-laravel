<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the AdminSeeder to create the admin user if needed
        $this->call(AdminSeeder::class);
        
        // Call the ProductSeeder, SectionSeeder, and SectionPartSeeder
        $this->call([
            ProductSeeder::class,
            SectionSeeder::class,
            SectionPartSeeder::class,
            SettingSeeder::class,
            ImageSeeder::class,
        ]);
    }
}
