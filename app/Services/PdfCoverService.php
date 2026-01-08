<?php

namespace App\Services;

use App\Models\Document;
use setasign\Fpdi\Tcpdf\Fpdi;

class PdfCoverService
{
    public function addCoverPage(Document $document, string $originalPdfPath): string
    {
        // Créer un PDF avec la page de garde
        $pdf = new Fpdi();

        // Désactiver l'en-tête et le pied de page par défaut
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Ajouter la page de garde
        $pdf->AddPage();
        $this->generateCoverPage($pdf, $document);

        // Ajouter les pages du PDF original
        $pageCount = $pdf->setSourceFile($originalPdfPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            // Ajouter une nouvelle page avec les mêmes dimensions
            if ($pageNo == 1) {
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            } else {
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            }

            $pdf->useTemplate($templateId);
        }

        // Sauvegarder le PDF combiné dans un fichier temporaire
        $tempPath = storage_path('app/temp/cover_' . $document->arem_doc_id . '_' . time() . '.pdf');

        // Créer le dossier temp s'il n'existe pas
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $pdf->Output($tempPath, 'F');

        return $tempPath;
    }

    protected function generateCoverPage($pdf, Document $document)
    {
        $pdf->SetMargins(25, 25, 25);
        $pdf->SetAutoPageBreak(false);

        // Couleurs ArEM
        $primaryColor = [0, 51, 102]; // #003366
        $secondaryColor = [0, 153, 204]; // #0099cc

        // Espace pour le logo
        $logoPath = public_path('images/ens.png');
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 85, 20, 40, 0, '', '', '', false, 300, '', false, false, 0);
        }

        // Nom de la plateforme
        $pdf->SetY(70);
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
        $pdf->MultiCell(0, 10, "ArEM", 0, 'C', false, 1);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->MultiCell(0, 5, "Plateforme d'Archives de l'École Normale Supérieure de Maroua", 0, 'C', false, 1);

        // Ligne de séparation
        $pdf->SetY($pdf->GetY() + 5);
        $pdf->SetLineStyle(['width' => 0.5, 'color' => $secondaryColor]);
        $pdf->Line(40, $pdf->GetY(), 170, $pdf->GetY());

        // Titre du document
        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
        $pdf->MultiCell(0, 8, $document->title, 0, 'C', false, 1);

        // Auteurs
        if ($document->authors && count($document->authors) > 0) {
            $pdf->SetY($pdf->GetY() + 8);
            $pdf->SetFont('helvetica', 'I', 12);
            $pdf->SetTextColor(80, 80, 80);

            $authorsText = '';
            foreach ($document->authors as $index => $author) {
                if ($index > 0) {
                    $authorsText .= ', ';
                }
                $authorsText .= $author['name'];
                if (isset($author['institution']) && $author['institution']) {
                    $authorsText .= ' (' . $author['institution'] . ')';
                }
            }

            $pdf->MultiCell(0, 6, $authorsText, 0, 'C', false, 1);
        }

        // Informations du document (cadre central)
        $pdf->SetY($pdf->GetY() + 15);
        $startY = $pdf->GetY();

        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetTextColor(60, 60, 60);

        $info = [
            ['label' => 'Type de document', 'value' => $document->documentType->name ?? 'N/A'],
            ['label' => 'Département', 'value' => $document->department->name ?? 'N/A'],
            ['label' => 'Année académique', 'value' => $document->academic_year ?? $document->year],
            ['label' => 'Identifiant ArEM', 'value' => $document->arem_doc_id],
        ];

        foreach ($info as $item) {
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(60, 7, $item['label'] . ' :', 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 11);
            $pdf->Cell(0, 7, $item['value'], 0, 1, 'L');
        }

        // URL permanente
        $pdf->SetY($pdf->GetY() + 5);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(60, 7, 'URL permanente :', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'U', 10);
        $pdf->SetTextColor($secondaryColor[0], $secondaryColor[1], $secondaryColor[2]);
        $pdf->Cell(0, 7, $document->permanent_url, 0, 1, 'L', false, $document->permanent_url);

        // Droits de diffusion
        $pdf->SetY($pdf->GetY() + 10);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->SetTextColor(60, 60, 60);
        $pdf->Cell(0, 7, 'Droits de diffusion :', 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 10);
        $accessText = match($document->access_rights) {
            'public' => 'Accès libre - Ce document est librement accessible et téléchargeable.',
            'restricted' => 'Accès restreint - L\'accès à ce document nécessite une autorisation.',
            'embargo' => 'Embargo - Ce document sera accessible après le ' . ($document->embargo_date ? $document->embargo_date->format('d/m/Y') : 'N/A'),
            default => 'Non spécifié'
        };

        $pdf->MultiCell(0, 5, $accessText, 0, 'L', false, 1);

        // Date de mise en ligne
        $pdf->SetY($pdf->GetY() + 8);
        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->SetTextColor(120, 120, 120);

        $uploadDate = $document->published_at ? $document->published_at->format('d/m/Y') : ($document->created_at ? $document->created_at->format('d/m/Y') : 'N/A');
        $pdf->Cell(0, 5, 'Document mis en ligne le : ' . $uploadDate, 0, 1, 'C');

        // Citation (en bas de page)
        if ($document->citation) {
            $pdf->SetY(250);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
            $pdf->Cell(0, 5, 'Citation recommandée :', 0, 1, 'L');

            $pdf->SetFont('helvetica', '', 9);
            $pdf->SetTextColor(80, 80, 80);

            // Enlever les balises HTML de la citation
            $citationText = strip_tags($document->citation);
            $pdf->MultiCell(0, 4, $citationText, 0, 'L', false, 1);
        }

        // Footer avec logo et copyright
        $pdf->SetY(280);
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->Cell(0, 4, '© ' . date('Y') . ' ArEM - École Normale Supérieure de Maroua', 0, 1, 'C');
        $pdf->Cell(0, 4, 'Cette page de garde a été générée automatiquement par la plateforme ArEM', 0, 1, 'C');
    }
}
