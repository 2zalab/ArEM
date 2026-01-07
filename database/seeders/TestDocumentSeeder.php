<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\User;

class TestDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $depositors = User::where('role', 'depositor')->get();
        $documentTypes = DocumentType::all();

        if ($depositors->isEmpty() || $documentTypes->isEmpty()) {
            $this->command->warn('Aucun déposant ou type de document trouvé.');
            return;
        }

        $documents = [
            [
                'type' => 'memoire_master',
                'title' => "L'intégration des TIC dans l'enseignement des mathématiques au secondaire",
                'abstract' => "Ce mémoire examine comment les technologies de l'information et de la communication peuvent améliorer l'enseignement et l'apprentissage des mathématiques dans les établissements secondaires du Cameroun.",
                'keywords' => ['TIC', 'mathématiques', 'enseignement secondaire', 'innovation pédagogique'],
                'year' => 2023,
                'metadata' => [
                    'supervisor' => 'Prof. Jean Ngando',
                    'specialty' => 'Didactique des mathématiques',
                    'defense_date' => '2023-07-15',
                    'jury' => 'Prof. Jean Ngando (Président), Dr. Marie Kouam (Membre), Dr. Pascal Mohamadou (Membre)',
                ],
            ],
            [
                'type' => 'memoire_licence',
                'title' => "Les défis de l'alphabétisation en milieu rural au Nord Cameroun",
                'abstract' => "Cette recherche explore les obstacles à l'alphabétisation dans les zones rurales du Nord Cameroun.",
                'keywords' => ['alphabétisation', 'milieu rural', 'éducation', 'Nord Cameroun'],
                'year' => 2024,
                'metadata' => [
                    'supervisor' => 'Dr. Marie Kouam',
                    'specialty' => "Sciences de l'éducation",
                    'defense_date' => '2024-06-20',
                ],
            ],
            [
                'type' => 'article',
                'title' => "Impact du changement climatique sur la biodiversité du parc national de la Bénoué",
                'abstract' => "Analyse des effets du changement climatique sur la faune et la flore du parc national de la Bénoué.",
                'keywords' => ['changement climatique', 'biodiversité', 'conservation', 'Bénoué'],
                'year' => 2023,
                'metadata' => [
                    'journal' => "Revue Camerounaise d'Écologie",
                    'issn' => '2415-1234',
                    'publication_status' => 'Publié',
                ],
            ],
        ];

        foreach ($documents as $docData) {

            $type = $documentTypes->firstWhere('code', $docData['type']);
            if (!$type) {
                $this->command->warn("Type de document introuvable : {$docData['type']}");
                continue;
            }

            $user = $depositors->random();

            $document = Document::create([
                'arem_doc_id' => 'AREM-DOC-ENS-' . now()->year . '-' . Str::upper(Str::random(6)),
                'user_id' => $user->id,
                'department_id' => $user->department_id,
                'document_type_id' => $type->id,
                'title' => $docData['title'],
                'abstract' => $docData['abstract'],
                'keywords' => json_encode($docData['keywords'], JSON_UNESCAPED_UNICODE),
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

            // Métadonnées spécifiques
            foreach ($docData['metadata'] as $key => $value) {
                $document->setMetaValue($key, $value);
            }

            // Statistiques simulées
            for ($i = 0; $i < rand(5, 30); $i++) {
                $document->incrementViews();
            }

            for ($i = 0; $i < rand(1, 10); $i++) {
                $document->incrementDownloads();
            }
        }

        // Documents en attente de validation
        $pendingDocs = [
            [
                'type' => 'memoire_licence',
                'title' => "Les stratégies d'enseignement de la lecture au cycle primaire",
                'abstract' => "Étude des méthodes d'enseignement de la lecture au primaire.",
                'keywords' => ['lecture', 'primaire', 'pédagogie'],
                'year' => 2024,
            ],
        ];

        foreach ($pendingDocs as $docData) {

            $type = $documentTypes->firstWhere('code', $docData['type']);
            if (!$type) {
                continue;
            }

            $user = $depositors->random();

            Document::create([
                'arem_doc_id' => 'AREM-DOC-ENS-' . now()->year . '-' . Str::upper(Str::random(6)),
                'user_id' => $user->id,
                'department_id' => $user->department_id,
                'document_type_id' => $type->id,
                'title' => $docData['title'],
                'abstract' => $docData['abstract'],
                'keywords' => json_encode($docData['keywords'], JSON_UNESCAPED_UNICODE),
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
