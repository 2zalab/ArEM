<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Department;
use App\Models\User;

class TestDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $depositors = User::where('role', 'depositor')->get();
        $documentTypes = DocumentType::all();
        $departments = Department::all();

        $documents = [
            [
                'type' => 'memoire_master',
                'title' => 'L\'intégration des TIC dans l\'enseignement des mathématiques au secondaire',
                'abstract' => 'Ce mémoire examine comment les technologies de l\'information et de la communication peuvent améliorer l\'enseignement et l\'apprentissage des mathématiques dans les établissements secondaires du Cameroun.',
                'keywords' => ['TIC', 'mathématiques', 'enseignement secondaire', 'innovation pédagogique'],
                'year' => 2023,
                'metadata' => [
                    'supervisor' => 'Prof. Jean Ngando',
                    'specialty' => 'Didactique des mathématiques',
                    'defense_date' => '2023-07-15',
                    'jury' => 'Prof. Jean Ngando (Président), Dr. Marie Kouam (Membre), Dr. Pascal Mohamadou (Membre)'
                ]
            ],
            [
                'type' => 'memoire_licence',
                'title' => 'Les défis de l\'alphabétisation en milieu rural au Nord Cameroun',
                'abstract' => 'Cette recherche explore les obstacles à l\'alphabétisation dans les zones rurales de la région du Nord Cameroun et propose des solutions adaptées au contexte local.',
                'keywords' => ['alphabétisation', 'milieu rural', 'éducation', 'Nord Cameroun'],
                'year' => 2024,
                'metadata' => [
                    'supervisor' => 'Dr. Marie Kouam',
                    'specialty' => 'Sciences de l\'éducation',
                    'defense_date' => '2024-06-20'
                ]
            ],
            [
                'type' => 'article',
                'title' => 'Impact du changement climatique sur la biodiversité du parc national de la Bénoué',
                'abstract' => 'Cet article scientifique analyse les effets du changement climatique sur la faune et la flore du parc national de la Bénoué, avec des recommandations pour la conservation.',
                'keywords' => ['changement climatique', 'biodiversité', 'conservation', 'Bénoué'],
                'year' => 2023,
                'metadata' => [
                    'journal' => 'Revue Camerounaise d\'Écologie',
                    'issn' => '2415-1234',
                    'publication_status' => 'Publié'
                ]
            ],
            [
                'type' => 'rapport_stage',
                'title' => 'Stage pédagogique au Lycée de Maroua',
                'abstract' => 'Rapport détaillé d\'un stage d\'enseignement de physique-chimie au Lycée de Maroua, incluant les observations, les méthodes pédagogiques appliquées et les résultats obtenus.',
                'keywords' => ['stage', 'enseignement', 'physique-chimie', 'lycée'],
                'year' => 2024,
                'metadata' => [
                    'host_institution' => 'Lycée de Maroua',
                    'stage_period' => 'Janvier - Mars 2024',
                    'supervisor' => 'Dr. Aïcha Bello'
                ]
            ],
            [
                'type' => 'these_doctorat',
                'title' => 'Modélisation mathématique des dynamiques de population en écologie tropicale',
                'abstract' => 'Cette thèse développe de nouveaux modèles mathématiques pour comprendre et prédire les dynamiques de populations animales dans les écosystèmes tropicaux, avec application au contexte camerounais.',
                'keywords' => ['modélisation mathématique', 'écologie', 'dynamiques de population', 'tropical'],
                'year' => 2023,
                'metadata' => [
                    'director' => 'Prof. Jean Ngando',
                    'doctoral_school' => 'École Doctorale de Mathématiques et Applications',
                    'defense_date' => '2023-12-10',
                    'jury' => 'Prof. Jean Ngando (Directeur), Prof. Emmanuel Nana (Rapporteur), Dr. Pascal Mohamadou (Examinateur)'
                ]
            ],
            [
                'type' => 'projet_fin_etude',
                'title' => 'Développement d\'une application mobile pour l\'apprentissage du français',
                'abstract' => 'Ce projet présente le développement d\'une application mobile Android destinée à faciliter l\'apprentissage du français pour les élèves du primaire au Cameroun.',
                'keywords' => ['application mobile', 'e-learning', 'français', 'Android'],
                'year' => 2024,
                'metadata' => [
                    'supervisor' => 'Dr. Pascal Mohamadou',
                    'project_type' => 'Développement logiciel'
                ]
            ],
            [
                'type' => 'cours',
                'title' => 'Introduction à la programmation Python - Niveau L1',
                'abstract' => 'Support de cours complet pour l\'introduction à la programmation avec Python, destiné aux étudiants de première année de licence en informatique.',
                'keywords' => ['Python', 'programmation', 'cours', 'débutant'],
                'year' => 2024,
                'metadata' => [
                    'course_level' => 'Licence 1',
                    'semester' => 'Semestre 1',
                    'course_type' => 'Cours magistral'
                ]
            ],
            [
                'type' => 'communication',
                'title' => 'L\'enseignement bilingue au Cameroun : défis et perspectives',
                'abstract' => 'Communication présentée au colloque international sur l\'éducation en Afrique, abordant les enjeux du bilinguisme dans le système éducatif camerounais.',
                'keywords' => ['bilinguisme', 'éducation', 'Cameroun', 'colloque'],
                'year' => 2023,
                'metadata' => [
                    'event_name' => 'Colloque International sur l\'Éducation en Afrique',
                    'event_date' => '2023-11-15',
                    'event_location' => 'Yaoundé, Cameroun'
                ]
            ],
        ];

        foreach ($documents as $docData) {
            $user = $depositors->random();
            $type = $documentTypes->where('code', $docData['type'])->first();

            $document = Document::create([
                'user_id' => $user->id,
                'department_id' => $user->department_id,
                'document_type_id' => $type->id,
                'title' => $docData['title'],
                'abstract' => $docData['abstract'],
                'keywords' => $docData['keywords'],
                'language' => 'fr',
                'year' => $docData['year'],
                'academic_year' => ($docData['year'] - 1) . '-' . $docData['year'],
                'file_path' => 'documents/sample_' . uniqid() . '.pdf',
                'file_name' => 'document.pdf',
                'file_type' => 'pdf',
                'file_size' => rand(500000, 5000000),
                'access_rights' => 'public',
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 90)),
            ]);

            // Add metadata
            foreach ($docData['metadata'] as $key => $value) {
                $document->setMetaValue($key, $value);
            }

            // Add some statistics
            for ($i = 0; $i < rand(5, 30); $i++) {
                $document->incrementViews();
            }

            for ($i = 0; $i < rand(1, 10); $i++) {
                $document->incrementDownloads();
            }
        }

        // Create some pending documents
        $pendingDocs = [
            [
                'type' => 'memoire_licence',
                'title' => 'Les stratégies d\'enseignement de la lecture au cycle primaire',
                'abstract' => 'Ce mémoire étudie différentes méthodes d\'enseignement de la lecture et leur efficacité auprès des élèves du cycle primaire.',
                'keywords' => ['lecture', 'primaire', 'pédagogie'],
                'year' => 2024,
            ],
            [
                'type' => 'article',
                'title' => 'Utilisation des plantes médicinales locales dans le traitement du paludisme',
                'abstract' => 'Étude ethnobotanique sur l\'utilisation traditionnelle des plantes médicinales dans le traitement du paludisme au Nord Cameroun.',
                'keywords' => ['plantes médicinales', 'paludisme', 'ethnobotanique'],
                'year' => 2024,
            ],
        ];

        foreach ($pendingDocs as $docData) {
            $user = $depositors->random();
            $type = $documentTypes->where('code', $docData['type'])->first();

            Document::create([
                'user_id' => $user->id,
                'department_id' => $user->department_id,
                'document_type_id' => $type->id,
                'title' => $docData['title'],
                'abstract' => $docData['abstract'],
                'keywords' => $docData['keywords'],
                'language' => 'fr',
                'year' => $docData['year'],
                'academic_year' => ($docData['year'] - 1) . '-' . $docData['year'],
                'file_path' => 'documents/sample_' . uniqid() . '.pdf',
                'file_name' => 'document.pdf',
                'file_type' => 'pdf',
                'file_size' => rand(500000, 5000000),
                'access_rights' => 'public',
                'status' => 'pending',
            ]);
        }
    }
}
