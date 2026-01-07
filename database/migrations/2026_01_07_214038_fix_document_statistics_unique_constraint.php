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
        // SQLite doesn't support dropping constraints easily, so we'll recreate the table
        Schema::dropIfExists('document_statistics');

        Schema::create('document_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->date('stat_date');
            $table->timestamps();

            // Unique constraint on the combination of document_id and stat_date
            $table->unique(['document_id', 'stat_date']);
            $table->index(['document_id', 'stat_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_statistics');

        // Recreate with old structure (for rollback purposes)
        Schema::create('document_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->date('stat_date')->unique();
            $table->timestamps();

            $table->index(['document_id', 'stat_date']);
        });
    }
};
