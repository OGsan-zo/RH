<?php

namespace App\Services;

use Exception;

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

    /**
     * Extrait le texte d'un fichier PDF ou DOC
     * 
     * @param string $filePath Chemin complet vers le fichier
     * @return string Texte extrait du fichier
     */
    public function extraireTexteDepuisFichier(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return '';
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        try {
            if ($extension === 'pdf') {
                return $this->extraireTextePDF($filePath);
            } elseif (in_array($extension, ['doc', 'docx'])) {
                return $this->extraireTexteWord($filePath);
            } elseif ($extension === 'txt') {
                return file_get_contents($filePath);
            }
        } catch (Exception $e) {
            \Log::error("Erreur extraction texte CV: " . $e->getMessage());
            return '';
        }

        return '';
    }

    /**
     * Extrait le texte d'un PDF en utilisant pdftotext (si disponible)
     * Sinon, retourne un texte générique pour permettre l'analyse
     */
    private function extraireTextePDF(string $filePath): string
    {
        // Méthode 1 : Utiliser pdftotext (si installé sur le serveur)
        if (function_exists('shell_exec')) {
            $output = shell_exec("pdftotext " . escapeshellarg($filePath) . " -");
            if ($output && trim($output) !== '') {
                return $output;
            }
        }

        // Méthode 2 : Extraction basique avec regex (limité mais fonctionne)
        $content = file_get_contents($filePath);
        
        // Nettoyer les caractères non-UTF8
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        
        // Extraire uniquement les caractères imprimables
        $text = preg_replace('/[^\x20-\x7E\xA0-\xFF]/u', ' ', $content);
        
        // Nettoyer les espaces multiples
        $text = preg_replace('/\s+/', ' ', $text);
        
        return trim($text);
    }

    /**
     * Extrait le texte d'un fichier Word
     */
    private function extraireTexteWord(string $filePath): string
    {
        // Pour les fichiers Word, une solution simple est d'utiliser antiword ou catdoc
        if (function_exists('shell_exec')) {
            $output = shell_exec("antiword " . escapeshellarg($filePath));
            if ($output && trim($output) !== '') {
                return $output;
            }
        }

        // Fallback : retourner un texte vide
        return '';
    }
}
