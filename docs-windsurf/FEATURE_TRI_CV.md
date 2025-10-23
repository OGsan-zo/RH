# Fonctionnalité : Tri et Filtrage des Candidats avec Analyse IA du CV

## 📋 Description

Cette fonctionnalité permet au service RH de trier et filtrer les candidats pour un poste donné en fonction de plusieurs critères, avec une analyse automatique du CV par intelligence artificielle.

## ✨ Fonctionnalités

### 1. **Analyse IA du CV**
- Extraction automatique du texte des CV (PDF/DOC)
- Évaluation de l'adéquation CV/Poste par Gemini AI
- Génération d'une note sur 100 lors de la postulation
- Extraction automatique des compétences

### 2. **Score Global Multi-Critères**
Le score global est calculé comme la moyenne de 3 notes :
- **Note CV (IA)** : Adéquation du CV avec le poste (0-100)
- **Score Test** : Résultat du test QCM (0-100)
- **Note Entretien** : Évaluation de l'entretien (0-100)

**Formule** : `Score Global = (Note CV + Score Test + Note Entretien) / 3`

### 3. **Filtres de Recherche**
- 🔍 **Nom/Prénom** : Recherche insensible à la casse
- 📅 **Âge** : Filtre par âge minimum et maximum
- 💼 **Compétences** : Recherche dans les compétences extraites
- 📊 **Statut** : Filtrage par statut de candidature

### 4. **Affichage Optimisé**
- Tableau trié par score global décroissant
- Affichage des 3 notes avec badges colorés
- Colonne âge calculée automatiquement
- Aperçu des compétences (limité à 30 caractères)

## 🗂️ Structure des Fichiers

### Fichiers Créés
```
sql/data/
├── 4-ADD-NOTE-CV.sql          # Ajout colonne note_cv
└── 5-FIX-COMPETENCES.sql      # Nettoyage données corrompues

app/Http/Controllers/
└── TriCandidatController.php  # Contrôleur tri et filtrage

resources/views/rh/
└── tri-candidats/
    └── index.blade.php         # Vue principale
```

### Fichiers Modifiés
```
app/Services/
├── GeminiService.php          # + evaluerCVPourPoste()
└── CvParserService.php        # + extraireTexteDepuisFichier()

app/Http/Controllers/
├── CandidatureController.php  # Analyse CV lors postulation
└── EvaluationEntretienController.php  # Calcul score avec 3 notes

app/Models/
└── Candidature.php            # + note_cv dans $fillable

resources/views/rh/
├── resultats/details.blade.php    # Affichage note CV
└── decisions/show.blade.php       # Affichage note CV

routes/
└── web.php                    # Routes tri-candidats

resources/views/layouts/
└── sidebar.blade.php          # Lien menu
```

## 🔧 Installation

### 1. Base de Données
```bash
# Ajouter la colonne note_cv
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql

# Nettoyer les données corrompues (si nécessaire)
psql -U postgres -d rh -f sql/data/5-FIX-COMPETENCES.sql
```

### 2. Lien Symbolique Storage
```bash
php artisan storage:link
```

### 3. Configuration Gemini API
Assurer que `GEMINI_API_KEY` est défini dans `.env`

## 📊 Routes

| Méthode | URL | Nom | Description |
|---------|-----|-----|-------------|
| GET | `/RH/tri-candidats` | `tri.index` | Formulaire sélection poste |
| GET | `/RH/tri-candidats/{id}` | `tri.show` | Liste candidats avec filtres |

## 🎯 Utilisation

### Pour le RH

1. **Accéder au tri des candidats**
   - Menu : "📊 Tri des Candidats"

2. **Sélectionner un poste**
   - Choisir dans le dropdown
   - Cliquer sur "Voir les candidats"

3. **Appliquer des filtres**
   - Nom/Prénom
   - Âge (min/max)
   - Compétences
   - Statut

4. **Consulter les résultats**
   - Candidats triés par score global
   - 3 notes visibles
   - Accès au profil complet

### Pour le Candidat

1. **Lors de l'inscription**
   - Upload du CV (PDF/DOC)

2. **Lors de la postulation**
   - Le CV est automatiquement analysé
   - Une note_cv est générée
   - Les compétences sont extraites

## 🔍 Optimisations Appliquées

### Performance
- ✅ **Eager Loading** : Évite les requêtes N+1
- ✅ **Batch Queries** : Récupération groupée des scores
- ✅ **Indexation** : Utilisation des clés étrangères

### Code Quality
- ✅ **Séparation des responsabilités** : Méthodes privées dédiées
- ✅ **Documentation PHPDoc** : Tous les paramètres documentés
- ✅ **Nettoyage UTF-8** : Protection contre caractères corrompus
- ✅ **Gestion d'erreurs** : Fallback sur valeurs par défaut

### Sécurité
- ✅ **Mass Assignment Protection** : $fillable défini
- ✅ **SQL Injection** : Utilisation de Query Builder
- ✅ **XSS Protection** : Blade escaping automatique

## 🐛 Problèmes Résolus

### 1. Erreur UTF-8
**Problème** : Caractères binaires du PDF causaient des erreurs JSON
**Solution** : Extraction du texte avec `CvParserService` + nettoyage UTF-8

### 2. Note CV non enregistrée
**Problème** : `note_cv` non dans `$fillable`
**Solution** : Ajout dans le modèle `Candidature`

### 3. Erreur 404 sur routes
**Problème** : Double prefix `/RH/RH/`
**Solution** : Retrait du prefix interne

### 4. CV non accessible
**Problème** : Mauvais chemin `public/` au lieu de `storage/`
**Solution** : Utilisation de `asset('storage/' . $path)`

## 📈 Améliorations Futures

- [ ] Export Excel des candidats filtrés
- [ ] Graphiques de distribution des scores
- [ ] Comparaison de plusieurs candidats
- [ ] Historique des filtres utilisés
- [ ] Sauvegarde des filtres favoris

## 👥 Auteurs

Développé dans le cadre du projet RH - ITU S5

## 📝 Licence

Projet académique - ITU Madagascar
