<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            [
                'name' => 'Mémoire de Licence',
                'code' => 'memoire_licence',
                'description' => 'Mémoire de fin d\'études de niveau Licence',
                'required_fields' => json_encode(['supervisor', 'specialty', 'defense_date'])
            ],
            [
                'name' => 'Mémoire de Master',
                'code' => 'memoire_master',
                'description' => 'Mémoire de fin d\'études de niveau Master',
                'required_fields' => json_encode(['supervisor', 'co_supervisor', 'specialty', 'defense_date', 'jury'])
            ],
            [
                'name' => 'Thèse de Doctorat',
                'code' => 'these_doctorat',
                'description' => 'Thèse de doctorat',
                'required_fields' => json_encode(['director', 'doctoral_school', 'defense_date', 'jury'])
            ],
            [
                'name' => 'Article scientifique',
                'code' => 'article',
                'description' => 'Publication dans une revue scientifique',
                'required_fields' => json_encode(['journal', 'issn', 'doi', 'volume', 'issue', 'pages', 'publication_date', 'publication_status'])
            ],
            [
                'name' => 'Rapport de stage',
                'code' => 'rapport_stage',
                'description' => 'Rapport de stage académique ou professionnel',
                'required_fields' => json_encode(['host_institution', 'stage_period', 'supervisor', 'stage_supervisor'])
            ],
            [
                'name' => 'Projet de fin d\'étude',
                'code' => 'projet_fin_etude',
                'description' => 'Projet de fin d\'études',
                'required_fields' => json_encode(['supervisor', 'project_type', 'partners'])
            ],
            [
                'name' => 'Cours et supports pédagogiques',
                'code' => 'cours',
                'description' => 'Polycopiés, diaporamas, exercices',
                'required_fields' => json_encode(['course_level', 'semester', 'course_type', 'credits'])
            ],
            [
                'name' => 'Communication scientifique',
                'code' => 'communication',
                'description' => 'Présentations à des colloques et conférences',
                'required_fields' => json_encode(['event_name', 'event_date', 'event_location', 'presentation_type'])
            ],
            [
                'name' => 'Rapport institutionnel',
                'code' => 'rapport_institutionnel',
                'description' => 'Rapports et documents administratifs',
                'required_fields' => json_encode(['issuing_body', 'report_period', 'report_type'])
            ],
            [
                'name' => 'Document administratif',
                'code' => 'document_admin',
                'description' => 'Documents administratifs académiques',
                'required_fields' => json_encode(['document_type', 'issuing_authority', 'reference_number'])
            ],
            [
                'name' => 'Données de recherche',
                'code' => 'dataset',
                'description' => 'Jeux de données scientifiques',
                'required_fields' => json_encode(['data_type', 'collection_method', 'data_format', 'sample_size', 'collection_period'])
            ],
            [
                'name' => 'Mémoire de DIPES II',
                'code' => 'memoire_dipes_ii',
                'description' => 'Mémoire de fin d\'études du DIPES II (Diplôme de Professeur de l\'Enseignement Secondaire)',
                'required_fields' => json_encode(['supervisor', 'specialty', 'defense_date', 'jury'])
            ],
            [
                'name' => 'Article de blog',
                'code' => 'blog_article',
                'description' => 'Article de vulgarisation ou de blog scientifique',
                'required_fields' => null
            ],
        ];

        foreach ($documentTypes as $type) {
            \App\Models\DocumentType::updateOrCreate(
                ['code' => $type['code']], // Clé unique
                $type // Données à créer ou mettre à jour
            );
        }
    }
}
