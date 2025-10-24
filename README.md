# 🏢 Système de Gestion des Ressources Humaines (SGRH)

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-336791.svg)](https://postgresql.org)
[![License](https://img.shields.io/badge/License-Academic-blue.svg)](LICENSE)
[![GitHub Issues](https://img.shields.io/github/issues/your-username/RH)](https://github.com/your-username/RH/issues)
[![GitHub Stars](https://img.shields.io/github/stars/your-username/RH)](https://github.com/your-username/RH/stargazers)

> Application web complète de gestion des ressources humaines avec analyse IA des CV, développée dans le cadre du projet académique ITU S5.

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

## 🛠️ Stack Technologique

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

### Outils & Développement
- **Composer** - Gestionnaire de dépendances PHP
- **Git** - Contrôle de version
- **Artisan** - CLI Laravel

## 🚀 Démarrage Rapide

```bash
# Cloner le projet
git clone https://github.com/votre-username/RH.git
cd RH

# Installer les dépendances
composer install

# Configuration
cp .env.example .env
php artisan key:generate

# Configurer la base de données PostgreSQL
# Modifier le fichier .env avec vos credentials DB

# Créer et peupler la base de données
psql -U postgres -c "CREATE DATABASE rh;"
psql -U postgres -d rh -f sql/1-TABLE.sql
psql -U postgres -d rh -f sql/2-VIEW.sql
psql -U postgres -d rh -f sql/data/3-INSERT.sql
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql

# Finaliser la configuration
php artisan storage:link
chmod -R 775 storage bootstrap/cache

# Lancer le serveur de développement
php artisan serve