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
            'name' => 'Administrateur Principal',
            'email' => 'admin@ens-maroua.cm',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => $departments->random()->id,
            'email_verified_at' => now(),
        ]);

        // Moderators
        $moderators = [
            ['name' => 'Dr. Marie Kouam', 'email' => 'marie.kouam@ens-maroua.cm', 'dept' => 'Sciences de l\'Éducation'],
            ['name' => 'Prof. Jean Ngando', 'email' => 'jean.ngando@ens-maroua.cm', 'dept' => 'Mathématiques'],
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

        // Depositors (enseignants et chercheurs)
        $depositors = [
            ['name' => 'Dr. Pascal Mohamadou', 'dept' => 'Informatique'],
            ['name' => 'Dr. Aïcha Bello', 'dept' => 'Physique-Chimie'],
            ['name' => 'Dr. Emmanuel Nana', 'dept' => 'Sciences de la Vie et de la Terre'],
            ['name' => 'Dr. Fatima Alhadji', 'dept' => 'Lettres et Sciences Humaines'],
            ['name' => 'M. Ibrahim Sali', 'dept' => 'Mathématiques'],
        ];

        foreach ($depositors as $dep) {
            $dept = $departments->where('name', $dep['dept'])->first();
            User::create([
                'name' => $dep['name'],
                'email' => strtolower(str_replace([' ', '.', 'Dr. ', 'M. '], ['', '', '', ''], $dep['name'])) . '@ens-maroua.cm',
                'password' => Hash::make('password'),
                'role' => 'depositor',
                'department_id' => $dept ? $dept->id : $departments->random()->id,
                'email_verified_at' => now(),
            ]);
        }

        // Readers (étudiants)
        $readers = [
            'Aminatou Abdoulaye',
            'Bouba Hamadou',
            'Claire Tchakounte',
            'Daniel Ndjana',
            'Esther Manga',
        ];

        foreach ($readers as $reader) {
            User::create([
                'name' => $reader,
                'email' => strtolower(str_replace(' ', '', $reader)) . '@ens-maroua.cm',
                'password' => Hash::make('password'),
                'role' => 'reader',
                'department_id' => $departments->random()->id,
                'email_verified_at' => now(),
            ]);
        }
    }
}
