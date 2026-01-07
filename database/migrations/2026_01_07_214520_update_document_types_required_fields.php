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
        // Article scientifique - Ajouter DOI, volume, issue, pages, publication_date
        DB::table('document_types')
            ->where('code', 'article')
            ->update([
                'required_fields' => json_encode(['journal', 'issn', 'doi', 'volume', 'issue', 'pages', 'publication_date', 'publication_status'])
            ]);

        // Rapport de stage - Ajouter stage_supervisor
        DB::table('document_types')
            ->where('code', 'rapport_stage')
            ->update([
                'required_fields' => json_encode(['host_institution', 'stage_period', 'supervisor', 'stage_supervisor'])
            ]);

        // Projet de fin d'étude - Ajouter partners
        DB::table('document_types')
            ->where('code', 'projet_fin_etude')
            ->update([
                'required_fields' => json_encode(['supervisor', 'project_type', 'partners'])
            ]);

        // Cours et supports pédagogiques - Ajouter credits
        DB::table('document_types')
            ->where('code', 'cours')
            ->update([
                'required_fields' => json_encode(['course_level', 'semester', 'course_type', 'credits'])
            ]);

        // Communication scientifique - Ajouter presentation_type
        DB::table('document_types')
            ->where('code', 'communication')
            ->update([
                'required_fields' => json_encode(['event_name', 'event_date', 'event_location', 'presentation_type'])
            ]);

        // Rapport institutionnel - Ajouter report_type
        DB::table('document_types')
            ->where('code', 'rapport_institutionnel')
            ->update([
                'required_fields' => json_encode(['issuing_body', 'report_period', 'report_type'])
            ]);

        // Document administratif - Ajouter reference_number
        DB::table('document_types')
            ->where('code', 'document_admin')
            ->update([
                'required_fields' => json_encode(['document_type', 'issuing_authority', 'reference_number'])
            ]);

        // Données de recherche - Ajouter sample_size, collection_period
        DB::table('document_types')
            ->where('code', 'dataset')
            ->update([
                'required_fields' => json_encode(['data_type', 'collection_method', 'data_format', 'sample_size', 'collection_period'])
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir aux anciennes définitions
        DB::table('document_types')
            ->where('code', 'article')
            ->update([
                'required_fields' => json_encode(['journal', 'issn', 'publication_status'])
            ]);

        DB::table('document_types')
            ->where('code', 'rapport_stage')
            ->update([
                'required_fields' => json_encode(['host_institution', 'stage_period', 'supervisor'])
            ]);

        DB::table('document_types')
            ->where('code', 'projet_fin_etude')
            ->update([
                'required_fields' => json_encode(['supervisor', 'project_type'])
            ]);

        DB::table('document_types')
            ->where('code', 'cours')
            ->update([
                'required_fields' => json_encode(['course_level', 'semester', 'course_type'])
            ]);

        DB::table('document_types')
            ->where('code', 'communication')
            ->update([
                'required_fields' => json_encode(['event_name', 'event_date', 'event_location'])
            ]);

        DB::table('document_types')
            ->where('code', 'rapport_institutionnel')
            ->update([
                'required_fields' => json_encode(['issuing_body', 'report_period'])
            ]);

        DB::table('document_types')
            ->where('code', 'document_admin')
            ->update([
                'required_fields' => json_encode(['document_type', 'issuing_authority'])
            ]);

        DB::table('document_types')
            ->where('code', 'dataset')
            ->update([
                'required_fields' => json_encode(['data_type', 'collection_method', 'data_format'])
            ]);
    }
};
