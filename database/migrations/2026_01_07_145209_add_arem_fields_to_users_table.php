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
            $table->string('arem_id')->unique()->nullable();
            $table->enum('role', ['admin', 'moderator', 'depositor', 'reader'])->default('reader');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('status')->nullable(); // Étudiant, Enseignant, Chercheur
            $table->string('filiere')->nullable();
            $table->string('institutional_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'arem_id',
                'role',
                'department_id',
                'status',
                'filiere',
                'institutional_email',
                'phone',
                'profile_photo',
                'bio',
                'is_active'
            ]);
        });
    }
};
