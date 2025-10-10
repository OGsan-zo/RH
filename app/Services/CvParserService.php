<?php

namespace App\Services;

class CvParserService
{
    /**
     * Analyse un CV texte pour extraire des compétences simples.
     */
    public function extraireCompetences(string $contenu): string
    {
        $motsCles = [
            'php', 'laravel', 'html', 'css', 'javascript', 'sql', 'python', 
            'excel', 'communication', 'gestion', 'comptabilité', 'marketing', 'java'
        ];

        $trouves = [];
        foreach ($motsCles as $mot) {
            if (stripos($contenu, $mot) !== false) {
                $trouves[] = ucfirst($mot);
            }
        }

        return implode(', ', array_unique($trouves));
    }
}
