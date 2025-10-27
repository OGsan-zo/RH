<?php

namespace App\Exports;

use App\Models\Candidat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class CandidatsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    /**
     * Récupérer tous les candidats avec leurs relations
     */
    public function collection()
    {
        return Candidat::with(['candidatures.annonce', 'user'])
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * En-têtes des colonnes
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénom',
            'Email',
            'Date de naissance',
            'Âge',
            'Compétences',
            'Statut candidat',
            'CV Disponible',
            'Chemin CV',
            'Nombre de candidatures',
            'Dernier poste postulé',
            'Date dernière candidature',
            'Note CV (dernière)',
            'Statut candidature (dernière)',
        ];
    }

    /**
     * Mapper les données pour chaque ligne
     */
    public function map($candidat): array
    {
        // Vérifier si le CV existe
        $cvPath = $candidat->cv_path;
        $cvDisponible = 'Non';
        
        if ($cvPath) {
            $cvFullPath = storage_path('app/public/' . $cvPath);
            $cvDisponible = file_exists($cvFullPath) ? 'Oui' : 'Non';
        }

        // Calculer l'âge
        $age = '';
        if ($candidat->date_naissance) {
            try {
                $age = Carbon::parse($candidat->date_naissance)->age . ' ans';
            } catch (\Exception $e) {
                $age = 'N/A';
            }
        }

        // Récupérer la dernière candidature
        $derniereCandidature = $candidat->candidatures()
            ->with('annonce')
            ->orderBy('date_candidature', 'desc')
            ->first();

        $dernierPoste = $derniereCandidature ? $derniereCandidature->annonce->titre : 'Aucune candidature';
        $dateDerniereCandidature = $derniereCandidature 
            ? Carbon::parse($derniereCandidature->date_candidature)->format('d/m/Y') 
            : '-';
        $noteCv = $derniereCandidature && $derniereCandidature->note_cv 
            ? number_format($derniereCandidature->note_cv, 2) . '%' 
            : '-';
        $statutCandidature = $derniereCandidature 
            ? ucfirst(str_replace('_', ' ', $derniereCandidature->statut)) 
            : '-';

        // Nombre total de candidatures
        $nombreCandidatures = $candidat->candidatures()->count();

        return [
            $candidat->id,
            $candidat->nom,
            $candidat->prenom,
            $candidat->email,
            $candidat->date_naissance ? Carbon::parse($candidat->date_naissance)->format('d/m/Y') : '-',
            $age,
            $candidat->competences ?: 'Non renseignées',
            ucfirst(str_replace('_', ' ', $candidat->statut)),
            $cvDisponible,
            $cvPath ?: 'Aucun CV',
            $nombreCandidatures,
            $dernierPoste,
            $dateDerniereCandidature,
            $noteCv,
            $statutCandidature,
        ];
    }

    /**
     * Styles pour le fichier Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour l'en-tête
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Largeur des colonnes
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 15,  // Nom
            'C' => 15,  // Prénom
            'D' => 25,  // Email
            'E' => 18,  // Date naissance
            'F' => 10,  // Âge
            'G' => 40,  // Compétences
            'H' => 18,  // Statut candidat
            'I' => 15,  // CV Disponible
            'J' => 30,  // Chemin CV
            'K' => 20,  // Nombre candidatures
            'L' => 35,  // Dernier poste
            'M' => 20,  // Date dernière candidature
            'N' => 18,  // Note CV
            'O' => 25,  // Statut candidature
        ];
    }
}
