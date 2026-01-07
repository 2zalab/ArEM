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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('arem_doc_id')->unique(); // AREM-DOC-ENS-2026-00456
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('document_type_id')->constrained()->onDelete('cascade');

            // Métadonnées communes
            $table->string('title');
            $table->text('abstract');
            $table->json('keywords')->nullable();
            $table->string('language')->default('fr');
            $table->integer('year');
            $table->string('academic_year')->nullable(); // 2025-2026

            // Fichiers
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->default('pdf');
            $table->bigInteger('file_size')->nullable();

            // Droits et diffusion
            $table->enum('access_rights', ['public', 'restricted', 'embargo'])->default('public');
            $table->date('embargo_date')->nullable();

            // Statut du workflow
            $table->enum('status', ['draft', 'pending', 'validated', 'rejected', 'published'])->default('draft');
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('published_at')->nullable();

            // URL et identifiants
            $table->string('permanent_url')->nullable();
            $table->string('doi')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
