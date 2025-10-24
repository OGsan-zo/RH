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
git clone https://github.com/votre-username/RH.git
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

### Administrateur
- **Email** : `admin@rh.mg`
- **Mot de passe** : `admin123`

### RH
- **Email** : `rh@rh.mg`
- **Mot de passe** : `rh123`

### Candidat
- **Inscription** : `/RH/register`