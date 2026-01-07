<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Departments and Document Types first
        $this->call([
            DepartmentSeeder::class,
            DocumentTypeSeeder::class,
        ]);

        // Create a test admin user
        User::factory()->create([
            'name' => 'Admin ArEM',
            'email' => 'admin@ens-maroua.cm',
            'role' => 'admin',
            'status' => 'Administrateur',
        ]);
    }
}
