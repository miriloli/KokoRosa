<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service; 

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('Password')
        ]);

        Service::factory()->create([
            'name' => 'Manicura tradicional',
            'price' => (15)
        ]);
        Service::factory()->create([
            'name' => 'Manicura semipermanente',
            'price' => (25)
        ]);
        Service::factory()->create([
            'name' => 'Manicura acrílica',
            'price' => (40)
        ]);
        Service::factory()->create([
            'name' => 'Pedicura tradicional',
            'price' => (12)
        ]);
        Service::factory()->create([
            'name' => 'Pedicura semipermanente',
            'price' => (20)
        ]);
        Service::factory()->create([
            'name' => 'Pedicura constructiva',
            'price' => (50)
        ]);
        
    }
}
