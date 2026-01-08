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
            $table->string('profile_photo')->nullable()->after('email');
            $table->string('phone')->nullable()->after('profile_photo');
            $table->string('institution')->nullable()->after('phone');
            $table->enum('user_type', ['etudiant', 'chercheur', 'enseignant', 'autre'])->nullable()->after('institution');
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
            ])->nullable()->after('user_type');
            $table->string('education_level')->nullable()->after('grade');
            $table->text('bio')->nullable()->after('education_level');
            $table->text('research_interests')->nullable()->after('bio');
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
