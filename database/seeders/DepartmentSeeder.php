<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Sciences de l\'Éducation', 'code' => 'SE', 'description' => 'Formation des enseignants en sciences de l\'éducation'],
            ['name' => 'Mathématiques', 'code' => 'MATH', 'description' => 'Département de mathématiques et statistiques'],
            ['name' => 'Physique-Chimie', 'code' => 'PC', 'description' => 'Sciences physiques et chimiques'],
            ['name' => 'Sciences de la Vie et de la Terre', 'code' => 'SVT', 'description' => 'Biologie, géologie et environnement'],
            ['name' => 'Lettres et Sciences Humaines', 'code' => 'LSH', 'description' => 'Langues, littérature et sciences humaines'],
            ['name' => 'Informatique', 'code' => 'INFO', 'description' => 'Informatique et nouvelles technologies'],
        ];

        foreach ($departments as $dept) {
            \App\Models\Department::create($dept);
        }
    }
}
