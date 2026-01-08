<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Informations personnelles additionnelles
            $table->date('birth_date')->nullable()->after('profile_photo');
            $table->string('birth_place')->nullable()->after('birth_date');
            $table->string('nationality')->nullable()->after('birth_place');
            $table->text('address')->nullable()->after('nationality');
            $table->string('linkedin')->nullable()->after('address');
            $table->string('orcid')->nullable()->after('linkedin');
            $table->string('google_scholar')->nullable()->after('orcid');

            // Formation académique (JSON)
            $table->json('education')->nullable()->after('google_scholar');

            // Expérience professionnelle (JSON)
            $table->json('experience')->nullable()->after('education');

            // Compétences (JSON)
            $table->json('skills')->nullable()->after('experience');

            // Langues (JSON)
            $table->json('languages')->nullable()->after('skills');

            // Publications (JSON)
            $table->json('publications')->nullable()->after('languages');

            // Certifications (JSON)
            $table->json('certifications')->nullable()->after('publications');

            // Références (JSON)
            $table->json('references')->nullable()->after('certifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'birth_place',
                'nationality',
                'address',
                'linkedin',
                'orcid',
                'google_scholar',
                'education',
                'experience',
                'skills',
                'languages',
                'publications',
                'certifications',
                'references',
            ]);
        });
    }
};
