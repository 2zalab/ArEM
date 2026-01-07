<?php

use Illuminate\Support\Facades\Route;
use App\Models\DocumentType;

// Route temporaire pour vérifier les types de documents
// À supprimer en production
Route::get('/debug/document-types', function () {
    $types = DocumentType::all();

    $output = "<!DOCTYPE html>
<html>
<head>
    <title>Debug: Types de documents</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #003366; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-warning { background-color: #fff3cd; border-left: 4px solid #ffc107; }
        .alert-info { background-color: #d1ecf1; border-left: 4px solid #0dcaf0; }
        pre { background-color: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔍 Debug: Types de documents</h1>";

    if ($types->isEmpty()) {
        $output .= "<div class='alert alert-warning'>
            <strong>⚠️ Aucun type de document trouvé!</strong><br><br>
            Veuillez exécuter les commandes suivantes :<br>
            <pre>php artisan migrate:fresh
php artisan db:seed --class=DocumentTypeSeeder</pre>
        </div>";
    } else {
        $output .= "<div class='alert alert-info'>
            <strong>✓ {$types->count()} type(s) de document trouvé(s)</strong>
        </div>";

        $output .= "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Actif</th>
                    <th>Champs requis</th>
                    <th>Nombre de champs</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($types as $type) {
            $fieldsCount = is_array($type->required_fields) ? count($type->required_fields) : 0;
            $fieldsJson = json_encode($type->required_fields, JSON_PRETTY_PRINT);
            $isActive = $type->is_active ? '✓ Oui' : '✗ Non';

            $output .= "<tr>
                <td>{$type->id}</td>
                <td>{$type->name}</td>
                <td><code>{$type->code}</code></td>
                <td>{$isActive}</td>
                <td><pre>{$fieldsJson}</pre></td>
                <td><strong>{$fieldsCount}</strong></td>
            </tr>";
        }

        $output .= "</tbody></table>";
    }

    $output .= "
    <div style='margin-top: 30px; padding: 15px; background-color: #e7f3ff; border-left: 4px solid #2196F3;'>
        <h3>📝 Instructions</h3>
        <ol>
            <li>Si aucun type n'est affiché, exécutez les migrations et seeders</li>
            <li>Si les champs requis sont vides (null ou []), exécutez la migration de mise à jour</li>
            <li>Une fois vérifié, supprimez ce fichier : <code>routes/debug.php</code></li>
        </ol>
        <pre>php artisan migrate
php artisan db:seed --class=DocumentTypeSeeder</pre>
    </div>

    <div style='margin-top: 20px; text-align: center; color: #666;'>
        <small>Cette route de debug ne devrait pas être accessible en production</small>
    </div>
</body>
</html>";

    return response($output, 200)->header('Content-Type', 'text/html');
});
