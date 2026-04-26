<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('document_types')->updateOrInsert(
            ['code' => 'autres'],
            [
                'name' => 'Autres',
                'code' => 'autres',
                'description' => 'Tout document ne correspondant à aucun des types listés ci-dessus',
                'required_fields' => json_encode(['custom_type', 'document_description', 'origin', 'reference_number', 'additional_notes']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('document_types')->where('code', 'autres')->delete();
    }
};
