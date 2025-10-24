# 🏢 Système de Gestion des Ressources Humaines (SGRH) - ITU Madagascar

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-336791.svg)](https://postgresql.org)
[![GitHub Issues](https://img.shields.io/github/issues/your-username/RH)](https://github.com/your-username/RH/issues)
[![GitHub Stars](https://img.shields.io/github/stars/your-username/RH)](https://github.com/your-username/RH/stargazers)
[![GitHub Forks](https://img.shields.io/github/forks/your-username/RH)](https://github.com/your-username/RH/network/members)

> **SGRH** - Application web complète de gestion des ressources humaines avec analyse IA des CV. Développé avec Laravel, PostgreSQL et Gemini AI dans le cadre du projet académique ITU S5.

## 🎯 Aperçu du Projet

Le **Système de Gestion des Ressources Humaines (SGRH)** est une solution complète qui modernise les processus RH grâce à l'intelligence artificielle. Notre système automatise l'analyse des CV, optimise le recrutement et fournit des insights data-driven pour une prise de décision éclairée.

### 🚀 Démo Live
- **Application principale**: [Lien vers la démo]()
- **Admin Demo**: `admin@rh.mg` / `admin123`
- **RH Demo**: `rh@rh.mg` / `rh123`

## ✨ Fonctionnalités Clés

### 🤖 Intelligence Artificielle Intégrée
- **Analyse automatique des CV** avec Gemini AI
- **Extraction intelligente** des compétences et expériences
- **Score d'adéquation** calculé automatiquement (0-100)
- **Recommandation de candidats** basée sur l'IA

### 📊 Tableaux de Bord Avancés
- **Statistiques en temps réel** avec Chart.js
- **Métriques RH** personnalisables
- **Rapports exportables** (PDF, Excel)
- **Visualisation des données** de recrutement

### 🔍 Recrutement Intelligent
- **Filtres multi-critères** avancés
- **Tests QCM** personnalisables
- **Planification d'entretiens** automatisée
- **Workflow de recrutement** complet

[Voir toutes les fonctionnalités →](#-fonctionnalités-principales)

## 🛠️ Installation & Démarrage

### Prérequis
- PHP 8.2+ | PostgreSQL 15+ | Composer 2.0+

### 🚀 Installation Express (5 minutes)

```bash
# 1. Cloner le projet
git clone https://github.com/votre-username/RH.git
cd RH

# 2. Installer les dépendances
composer install

# 3. Configuration rapide
cp .env.example .env
php artisan key:generate

# 4. Base de données (assurez-vous que PostgreSQL tourne)
./scripts/setup-database.sh

# 5. Lancer l'application
php artisan serve