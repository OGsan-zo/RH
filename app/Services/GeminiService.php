<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class GeminiService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->client = new Client([
            'base_uri' => 'https://generativelanguage.googleapis.com/v1beta/',
            'timeout'  => 60.0,
        ]);
    }

    /**
     * Génère un test QCM complet à partir d'une annonce.
     */
    public function genererTestComplet(string $annonceTitre, string $annonceDescription, int $nbQuestions = 10, int $nbReponses = 4): array
    {
        try {
            $prompt = "
                Crée un test QCM complet pour le poste suivant :
                Titre : {$annonceTitre}
                Description : {$annonceDescription}

                Le test doit inclure :
                - Un titre clair pour le test
                - Une courte description
                - {$nbQuestions} questions à choix multiple avec {$nbReponses} propositions, dont une correcte.

                Réponds uniquement en JSON strict :
                {
                  'titre': 'Titre du test',
                  'description': 'Description du test',
                  'questions': [
                    {
                      'question': 'Texte de la question',
                      'reponses': [
                        {'texte': 'Réponse 1', 'est_correcte': false},
                        {'texte': 'Réponse 2', 'est_correcte': true}
                      ]
                    }
                  ]
                }
            ";

            $response = $this->client->post("models/gemini-2.5-flash:generateContent?key={$this->apiKey}", [
                'json' => [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // 🔹 Journalisation du texte brut pour le débogage
            file_put_contents(storage_path('logs/gemini_raw.log'), $text);

            // 🔹 Nettoyage du format Markdown (```json ... ```)
            $text = preg_replace('/```json|```/i', '', trim($text));

            // 🔹 Extraction du premier bloc JSON si du texte parasite existe
            if (!str_starts_with(trim($text), '{') && !str_starts_with(trim($text), '[')) {
                preg_match('/(\{.*\}|\[.*\])/s', $text, $matches);
                if (isset($matches[1])) {
                    $text = $matches[1];
                }
            }

            // 🔹 Décodage
            $data = json_decode($text, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Réponse Gemini invalide ou non conforme JSON.');
            }

            return $data;
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

        /**
     * Analyse le contenu textuel d’un CV et renvoie une liste de compétences.
     *
     * @param string $contenuCV
     * @return string
     */
    public function extraireCompetencesDepuisCV(string $contenuCV): string
    {
        try {
            // Nettoyer le contenu avant envoi (enlever caractères non-UTF8)
            $contenuCV = $this->nettoyerTexte($contenuCV);
            
            // Limiter la taille du contenu (max 5000 caractères)
            if (strlen($contenuCV) > 5000) {
                $contenuCV = substr($contenuCV, 0, 5000);
            }
            
            $prompt = "
                Analyse ce texte de CV et renvoie uniquement les compétences clés du candidat,
                séparées par des virgules. 
                Réponds uniquement en texte brut sans phrase, sans format JSON.
                
                Contenu du CV :
                {$contenuCV}
            ";

            $response = $this->client->post("models/gemini-2.5-flash:generateContent?key={$this->apiKey}", [
                'json' => [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Nettoyage simple
            $competences = trim(preg_replace('/[^a-zA-ZÀ-ÿ0-9, ]/', '', $text));

            // Journalisation pour suivi
            file_put_contents(storage_path('logs/gemini_competences.log'), $competences . "\n", FILE_APPEND);

            return $competences ?: 'Non détecté';
        } catch (Exception $e) {
            // Ne pas retourner le message d'erreur, juste logger
            \Log::error('Erreur extraction compétences Gemini: ' . $e->getMessage());
            return 'Non détecté';
        }
    }

    /**
     * Évalue l'adéquation d'un CV par rapport aux exigences d'un poste.
     * 
     * @param string $contenuCV Contenu textuel du CV
     * @param string $competencesRequises Compétences requises pour le poste
     * @param string $niveauRequis Niveau d'études/expérience requis
     * @param string $descriptionPoste Description complète du poste
     * @return float Note sur 100 représentant l'adéquation CV/poste
     */
    public function evaluerCVPourPoste(
        string $contenuCV, 
        string $competencesRequises, 
        string $niveauRequis, 
        string $descriptionPoste
    ): float
    {
        try {
            // Nettoyer le contenu avant envoi
            $contenuCV = $this->nettoyerTexte($contenuCV);
            $descriptionPoste = $this->nettoyerTexte($descriptionPoste);
            $competencesRequises = $this->nettoyerTexte($competencesRequises);
            $niveauRequis = $this->nettoyerTexte($niveauRequis);
            
            // Limiter la taille du contenu
            if (strlen($contenuCV) > 5000) {
                $contenuCV = substr($contenuCV, 0, 5000);
            }
            
            $prompt = "
                Tu es un expert en recrutement. Analyse ce CV et évalue son adéquation avec le poste.
                
                POSTE :
                - Description : {$descriptionPoste}
                - Compétences requises : {$competencesRequises}
                - Niveau requis : {$niveauRequis}
                
                CV DU CANDIDAT :
                {$contenuCV}
                
                CONSIGNES :
                - Évalue l'adéquation entre le CV et les exigences du poste
                - Considère : compétences techniques, expérience, formation, pertinence
                - Donne une note sur 100 (0 = pas du tout adapté, 100 = parfaitement adapté)
                - Réponds UNIQUEMENT avec un nombre entre 0 et 100, sans texte ni explication
                
                Note :
            ";

            $response = $this->client->post("models/gemini-2.5-flash:generateContent?key={$this->apiKey}", [
                'json' => [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Nettoyage et extraction du nombre
            $text = trim($text);
            preg_match('/(\d+(?:\.\d+)?)/', $text, $matches);
            
            if (isset($matches[1])) {
                $note = floatval($matches[1]);
                // S'assurer que la note est entre 0 et 100
                $note = max(0, min(100, $note));
                
                // Journalisation pour suivi
                file_put_contents(
                    storage_path('logs/gemini_cv_evaluation.log'), 
                    date('Y-m-d H:i:s') . " - Note: {$note}\n",
                    FILE_APPEND
                );
                
                return round($note, 2);
            }

            // Si pas de nombre trouvé, retourner une note par défaut
            return 50.0;

        } catch (Exception $e) {
            // En cas d'erreur, retourner une note neutre
            file_put_contents(
                storage_path('logs/gemini_cv_evaluation.log'), 
                date('Y-m-d H:i:s') . " - Erreur: " . $e->getMessage() . "\n",
                FILE_APPEND
            );
            return 50.0;
        }
    }

    /**
     * Nettoie le texte en enlevant les caractères non-UTF8
     * 
     * @param string $texte
     * @return string
     */
    private function nettoyerTexte(string $texte): string
    {
        // Convertir en UTF-8 valide
        $texte = mb_convert_encoding($texte, 'UTF-8', 'UTF-8');
        
        // Enlever les caractères de contrôle et non-imprimables
        $texte = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $texte);
        
        // Nettoyer les espaces multiples
        $texte = preg_replace('/\s+/', ' ', $texte);
        
        return trim($texte);
    }

}
