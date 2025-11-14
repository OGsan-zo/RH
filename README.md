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
- Extension PHP : pdo_pgsql, mbstring, openssl, fileinfo

## 🚀 Installation Rapide

```bash
# 1. Cloner le projet
git clone https://github.com/OGSan-zo/RH.git
cd RH

# 2. Installer les dépendances
composer install

# 3. Configuration
cp .env.example .env
php artisan key:generate

# 4. Créer la base de données
psql -U postgres -c "CREATE DATABASE rh;"
psql -U postgres -d rh -f sql/1-TABLE.sql
psql -U postgres -d rh -f sql/2-VIEW.sql
psql -U postgres -d rh -f sql/data/3-INSERT.sql
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql

# 5. Configuration finale
php artisan storage:link
chmod -R 775 storage bootstrap/cache

# 6. Lancer le serveur
php artisan serve
```

📖 **[Guide d'Installation Complet](docs/INSTALLATION.md)** - Instructions détaillées, déploiement production, optimisations

## 👤 Comptes de Test

### RH
- **Email** : `rh@example.com`
- **Mot de passe** : `rh1234`

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
├── docs/                      # Documentation complète
└── public/                     # Assets publics
```

## 🎯 Utilisation

### Démarrage Rapide

**Pour le RH** :
1. Publier une annonce avec critères détaillés
2. Consulter les candidatures avec filtres avancés
3. Organiser tests QCM et entretiens
4. Prendre des décisions basées sur 3 notes (CV + Test + Entretien)

**Pour le Candidat** :
1. S'inscrire et uploader son CV
2. Postuler aux annonces (analyse IA automatique)
3. Passer les tests assignés
4. Suivre sa candidature en temps réel

📖 **[Guide d'Utilisation Complet](docs/USAGE.md)** - Tutoriels détaillés par rôle, conseils et bonnes pratiques

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
- **Usage** : Analyse des CV et extraction de compétences
- **Documentation** : [Gemini API Docs](https://ai.google.dev/docs)

## 🐛 Dépannage

### Problèmes Courants

- **PostgreSQL ne démarre pas** → `sudo systemctl start postgresql`
- **Erreur GuzzleHTTP** → `composer require guzzlehttp/guzzle`
- **CV non accessible** → `php artisan storage:link`
- **Erreur UTF-8** → `psql -U postgres -d rh -f sql/data/5-FIX-COMPETENCES.sql`

🔧 **[Guide de Dépannage Complet](docs/TROUBLESHOOTING.md)** - Solutions détaillées pour tous les problèmes

## 📚 Documentation

### Guides Utilisateurs
- 📖 **[Guide d'Utilisation](docs/USAGE.md)** - Tutoriels par rôle (RH, Candidat)
- 📦 **[Guide d'Installation](docs/INSTALLATION.md)** - Installation complète et déploiement
- 🔧 **[Guide de Dépannage](docs/TROUBLESHOOTING.md)** - Solutions aux problèmes courants

### Documentation Développeurs
- ✨ **[Fonctionnalité Tri CV](docs/FEATURE_TRI_CV.md)** - Architecture et implémentation
- 📝 **[Convention de Commits](docs/COMMIT_GUIDE.md)** - Standards Git

## 🤝 Contribution

Ce projet est académique. Les contributions sont les bienvenues pour :
- Améliorer les fonctionnalités existantes
- Corriger des bugs
- Ajouter de nouvelles fonctionnalités
- Améliorer la documentation

### Convention de commits
Suivre le guide dans [docs/COMMIT_GUIDE.md](docs/COMMIT_GUIDE.md)

## 📝 Licence

Projet académique - ITU Madagascar S5

## 🙏 Remerciements

- **Mr Tovo** - Encadrant du projet
- **Google Gemini AI** - API d'analyse de CV
- **Laravel Community** - Framework et documentation
- **ITU Madagascar** - Formation et ressources

## 📞 Contact

Pour toute question ou suggestion :
- **Email** : zoheriniaina@gmail.com
- **GitHub Issues** : [Créer une issue](https://github.com/OGSan-zo/RH/issues)
