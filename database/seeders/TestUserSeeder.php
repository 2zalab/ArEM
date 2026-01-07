<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();

        // Admin user
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@ens-maroua.cm',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => $departments->random()->id,
            'email_verified_at' => now(),
        ]);

        // Moderators
        $moderators = [
            ['name' => 'Isaac', 'email' => 'isaac@ens-maroua.cm', 'dept' => 'Sciences de l\'Éducation'],
            ['name' => 'Touza', 'email' => 'touzaisaac@gmail.com', 'dept' => 'Informatique'],
        ];

        foreach ($moderators as $mod) {
            $dept = $departments->where('name', $mod['dept'])->first();
            User::create([
                'name' => $mod['name'],
                'email' => $mod['email'],
                'password' => Hash::make('password'),
                'role' => 'moderator',
                'department_id' => $dept ? $dept->id : $departments->random()->id,
                'email_verified_at' => now(),
            ]);
        }
    }
}
