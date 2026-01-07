<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('document_types')->insert([
            [
                'name' => 'Mémoire de DIPES II',
                'code' => 'memoire_dipes_ii',
                'description' => 'Mémoire de fin d\'études du DIPES II (Diplôme de Professeur de l\'Enseignement Secondaire)',
                'required_fields' => json_encode(['supervisor', 'specialty', 'defense_date', 'jury']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Article de blog',
                'code' => 'blog_article',
                'description' => 'Article de vulgarisation ou de blog scientifique',
                'required_fields' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('document_types')
            ->whereIn('code', ['memoire_dipes_ii', 'blog_article'])
            ->delete();
    }
};
