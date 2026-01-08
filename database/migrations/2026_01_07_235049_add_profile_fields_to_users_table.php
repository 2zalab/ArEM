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
            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'institution')) {
                $table->string('institution')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->enum('user_type', ['etudiant', 'chercheur', 'enseignant', 'autre'])->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'grade')) {
                $table->enum('grade', [
                    'Etudiant Licence',
                    'Etudiant Master',
                    'Doctorant',
                    'Assistant',
                    'Maître de Conférences',
                    'Professeur',
                    'Prof Lycées et Collèges',
                    'Chercheur',
                    'Autre'
                ])->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'education_level')) {
                $table->string('education_level')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'research_interests')) {
                $table->text('research_interests')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'phone',
                'institution',
                'user_type',
                'grade',
                'education_level',
                'bio',
                'research_interests'
            ]);
        });
    }
};
