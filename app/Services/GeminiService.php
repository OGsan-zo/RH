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
            file_put_contents(storage_path('logs/gemini_competences.log'), $competences);

            return $competences ?: 'Non détecté';
        } catch (Exception $e) {
            return 'Erreur extraction Gemini : '.$e->getMessage();
        }
    }

}
