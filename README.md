# 🏢 Système de Gestion des Ressources Humaines

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-blue.svg)](https://postgresql.org)
[![License](https://img.shields.io/badge/License-Academic-green.svg)](LICENSE)

Application web complète de gestion des ressources humaines avec analyse IA des CV, développée dans le cadre du projet académique ITU S5.

## ✨ Fonctionnalités Principales

### 🎯 Gestion du Recrutement
- **Publication d'annonces** avec critères détaillés
- **Postulation en ligne** avec upload de CV
- **Analyse IA du CV** via Gemini AI (extraction compétences + note d'adéquation)
- **Tests QCM** personnalisés par poste
- **Planification d'entretiens** avec notifications
- **Évaluation multi-critères** (CV + Test + Entretien)
- **Tri et filtrage avancé** des candidats

### 👥 Gestion des Employés
- **Dossiers employés** complets
- **Gestion des contrats** (CDI, CDD, Stage)
- **Affiliations sociales** (CNAPS, OSTIE, Sanitaire)
- **Historique de carrière**

### 📊 Tableau de Bord
- **Statistiques en temps réel** (candidatures, tests, entretiens)
- **Graphiques interactifs** (Chart.js)
- **Notifications** push en temps réel
- **Rapports** exportables

### 🤖 Intelligence Artificielle
- **Extraction automatique** du texte des CV (PDF/DOC)
- **Analyse sémantique** des compétences
- **Évaluation de l'adéquation** CV/Poste (score sur 100)
- **Score global** calculé sur 3 critères

## 🛠️ Technologies Utilisées

### Backend
- **Laravel 11.x** - Framework PHP
- **PostgreSQL 15+** - Base de données
- **Gemini AI** - Analyse des CV
- **GuzzleHTTP** - Client HTTP pour API

### Frontend
- **Blade Templates** - Moteur de templates Laravel
- **Bootstrap 5** - Framework CSS
- **Chart.js** - Graphiques interactifs
- **JavaScript Vanilla** - Interactions dynamiques

### Outils
- **Composer** - Gestionnaire de dépendances PHP
- **Git** - Contrôle de version
- **Artisan** - CLI Laravel

## 📋 Prérequis

- PHP >= 8.2
- PostgreSQL >= 15
- Composer >= 2.0
- Node.js >= 18 (optionnel, pour assets)
- Extension PHP : pdo_pgsql, mbstring, openssl, fileinfo

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone https://github.com/votre-username/RH.git
cd RH
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configuration de l'environnement
```bash
# Copier le fichier .env
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configurer la base de données
Éditer le fichier `.env` :
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rh
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe

# API Gemini pour l'analyse IA
GEMINI_API_KEY=votre_cle_api_gemini
```

### 5. Créer la base de données
```bash
# Créer la base de données PostgreSQL
psql -U postgres -c "CREATE DATABASE rh;"

# Exécuter les scripts SQL
psql -U postgres -d rh -f sql/1-TABLE.sql
psql -U postgres -d rh -f sql/2-VIEW.sql
psql -U postgres -d rh -f sql/data/3-INSERT.sql
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql
```

### 6. Créer le lien symbolique pour le storage
```bash
php artisan storage:link
```

### 7. Configurer les permissions
```bash
chmod -R 775 storage bootstrap/cache
```

### 8. Lancer le serveur
```bash
php artisan serve
```

L'application sera accessible sur : `http://localhost:8000`

## 👤 Comptes de Test

### Administrateur
- **Email** : `admin@rh.mg`
- **Mot de passe** : `admin123`

### RH
- **Email** : `rh@rh.mg`
- **Mot de passe** : `rh123`

### Candidat
- **Inscription** : `/RH/register`

## 📁 Structure du Projet

```
RH/
├── app/
│   ├── Http/Controllers/      # Contrôleurs
│   ├── Models/                 # Modèles Eloquent
│   └── Services/               # Services (Gemini, Parser CV)
├── resources/
│   └── views/                  # Vues Blade
│       ├── admin/              # Interface Admin
│       ├── rh/                 # Interface RH
│       └── candidat/           # Interface Candidat
├── routes/
│   └── web.php                 # Routes de l'application
├── sql/
│   ├── 1-TABLE.sql            # Création des tables
│   ├── 2-VIEW.sql             # Vues PostgreSQL
│   └── data/                   # Scripts d'insertion
├── storage/
│   └── app/public/cv/         # CVs uploadés
├── docs-windsurf/             # Documentation développement
└── public/                     # Assets publics
```

## 🎯 Utilisation

### Pour le RH

1. **Publier une annonce**
   - Menu : Annonces → Créer une annonce
   - Remplir les critères (compétences, niveau, salaire)

2. **Consulter les candidatures**
   - Menu : Tri des Candidats
   - Sélectionner un poste
   - Appliquer des filtres (nom, âge, compétences)

3. **Organiser un test**
   - Menu : Tests → Créer un test
   - Ajouter des questions QCM
   - Assigner aux candidats

4. **Planifier un entretien**
   - Menu : Entretiens → Planifier
   - Choisir date, heure, lieu

5. **Prendre une décision**
   - Consulter le profil complet
   - Voir les 3 notes (CV, Test, Entretien)
   - Accepter ou refuser

### Pour le Candidat

1. **S'inscrire**
   - Remplir le formulaire
   - Uploader le CV (PDF/DOC)

2. **Postuler**
   - Consulter les annonces
   - Cliquer sur "Postuler"
   - Le CV est analysé automatiquement

3. **Passer le test**
   - Recevoir la notification
   - Répondre aux questions

4. **Suivre sa candidature**
   - Tableau de bord
   - Notifications en temps réel

## 🔍 Fonctionnalités Avancées

### Analyse IA du CV
- Extraction automatique du texte (PDF/DOC)
- Analyse sémantique des compétences
- Évaluation de l'adéquation avec le poste
- Score sur 100 généré automatiquement

### Score Global Multi-Critères
```
Score Global = (Note CV + Score Test + Note Entretien) / 3
```

### Filtres Avancés
- Recherche par nom/prénom
- Filtre par âge (min/max)
- Filtre par compétences
- Filtre par statut

## 📊 API Utilisées

### Gemini AI (Google)
- **Endpoint** : `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent`
- **Usage** : Analyse des CV et extraction de compétences
- **Documentation** : [Gemini API Docs](https://ai.google.dev/docs)

## 🐛 Dépannage

### Erreur "SQLSTATE[08006]"
```bash
# Vérifier que PostgreSQL est démarré
sudo systemctl status postgresql
sudo systemctl start postgresql
```

### Erreur "Class 'GuzzleHttp\Client' not found"
```bash
composer require guzzlehttp/guzzle
```

### CV non accessible
```bash
# Recréer le lien symbolique
php artisan storage:link
```

### Erreur UTF-8 avec les CV
Les CV sont automatiquement nettoyés. Si le problème persiste :
```bash
psql -U postgres -d rh -f sql/data/5-FIX-COMPETENCES.sql
```

## 📚 Documentation

- **[Guide de la fonctionnalité Tri CV](docs-windsurf/FEATURE_TRI_CV.md)** - Documentation complète
- **[Guide de commit](docs-windsurf/COMMIT_GUIDE.md)** - Convention de commits

## 🤝 Contribution

Ce projet est académique. Les contributions sont les bienvenues pour :
- Améliorer les fonctionnalités existantes
- Corriger des bugs
- Ajouter de nouvelles fonctionnalités
- Améliorer la documentation

### Convention de commits
Suivre le guide dans `docs-windsurf/COMMIT_GUIDE.md`

## 📝 Licence

Projet académique - ITU Madagascar S5

## 👥 Auteurs

- **Équipe RH** - Développement et conception
- **ITU S5** - Encadrement académique

## 🙏 Remerciements

- **Mr Tovo** - Encadrant du projet
- **Google Gemini AI** - API d'analyse de CV
- **Laravel Community** - Framework et documentation
- **ITU Madagascar** - Formation et ressources

## 📞 Contact

Pour toute question ou suggestion :
- **Email** : contact@rh-itu.mg
- **GitHub Issues** : [Créer une issue](https://github.com/votre-username/RH/issues)

---

**Développé avec ❤️ par l'équipe RH - ITU Madagascar**
