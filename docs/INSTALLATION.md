# 📦 Guide d'Installation Complet

Ce guide détaille l'installation du système RH étape par étape.

## 📋 Prérequis

### Logiciels Requis
- **PHP** >= 8.2
- **PostgreSQL** >= 15
- **Composer** >= 2.0
- **Git** (pour cloner le projet)
- **Node.js** >= 18 (optionnel, pour compiler les assets)

### Extensions PHP Requises
```bash
# Vérifier les extensions installées
php -m | grep -E 'pdo_pgsql|mbstring|openssl|fileinfo|curl'
```

Extensions nécessaires :
- `pdo_pgsql` - Connexion PostgreSQL
- `mbstring` - Manipulation de chaînes
- `openssl` - Sécurité
- `fileinfo` - Détection type de fichiers
- `curl` - Requêtes HTTP
- `gd` ou `imagick` - Manipulation d'images (optionnel)

### Installation des Extensions (Ubuntu/Debian)
```bash
sudo apt-get update
sudo apt-get install php8.2-pgsql php8.2-mbstring php8.2-curl php8.2-xml php8.2-zip
```

## 🚀 Installation Étape par Étape

### Étape 1 : Cloner le Projet
```bash
# Via HTTPS
git clone https://github.com/votre-username/RH.git
cd RH

# Ou via SSH
git clone git@github.com:votre-username/RH.git
cd RH
```

### Étape 2 : Installer les Dépendances PHP
```bash
# Installer Composer si nécessaire
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Installer les dépendances du projet
composer install --no-dev --optimize-autoloader
```

### Étape 3 : Configuration de l'Environnement

#### 3.1 Copier le fichier .env
```bash
cp .env.example .env
```

#### 3.2 Générer la clé d'application
```bash
php artisan key:generate
```

#### 3.3 Éditer le fichier .env
```bash
nano .env
# ou
vim .env
```

Configuration minimale :
```env
APP_NAME="RH System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rh
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe_securise

GEMINI_API_KEY=votre_cle_api_gemini
```

### Étape 4 : Configuration PostgreSQL

#### 4.1 Installer PostgreSQL
```bash
# Ubuntu/Debian
sudo apt-get install postgresql postgresql-contrib

# Démarrer le service
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

#### 4.2 Créer la base de données
```bash
# Se connecter à PostgreSQL
sudo -u postgres psql

# Dans le shell PostgreSQL
CREATE DATABASE rh;
CREATE USER rh_user WITH ENCRYPTED PASSWORD 'votre_mot_de_passe';
GRANT ALL PRIVILEGES ON DATABASE rh TO rh_user;
\q
```

#### 4.3 Exécuter les scripts SQL
```bash
# Créer les tables
psql -U postgres -d rh -f sql/1-TABLE.sql

# Créer les vues
psql -U postgres -d rh -f sql/2-VIEW.sql

# Insérer les données de test
psql -U postgres -d rh -f sql/data/3-INSERT.sql

# Ajouter la colonne note_cv
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql
```

### Étape 5 : Configuration du Storage

#### 5.1 Créer le lien symbolique
```bash
php artisan storage:link
```

#### 5.2 Configurer les permissions
```bash
# Donner les permissions d'écriture
chmod -R 775 storage bootstrap/cache

# Si vous utilisez Apache/Nginx
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Étape 6 : Obtenir une Clé API Gemini

1. Aller sur [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Se connecter avec un compte Google
3. Créer une nouvelle clé API
4. Copier la clé dans `.env` :
   ```env
   GEMINI_API_KEY=votre_cle_api_ici
   ```

### Étape 7 : Tester l'Installation

#### 7.1 Lancer le serveur de développement
```bash
php artisan serve
```

#### 7.2 Accéder à l'application
Ouvrir le navigateur : `http://localhost:8000`

#### 7.3 Tester la connexion
- **Admin** : `admin@rh.mg` / `admin123`
- **RH** : `rh@rh.mg` / `rh123`

## 🌐 Déploiement en Production

### Configuration Apache

#### 1. Créer un VirtualHost
```apache
<VirtualHost *:80>
    ServerName votre-domaine.com
    DocumentRoot /var/www/rh/public

    <Directory /var/www/rh/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/rh-error.log
    CustomLog ${APACHE_LOG_DIR}/rh-access.log combined
</VirtualHost>
```

#### 2. Activer les modules nécessaires
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Configuration Nginx

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/rh/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Optimisations Production

```bash
# Cache de configuration
php artisan config:cache

# Cache des routes
php artisan route:cache

# Cache des vues
php artisan view:cache

# Optimiser l'autoloader
composer install --optimize-autoloader --no-dev
```

## 🔒 Sécurité

### 1. Permissions Strictes
```bash
# Fichiers en lecture seule
find . -type f -exec chmod 644 {} \;

# Répertoires exécutables
find . -type d -exec chmod 755 {} \;

# Storage et cache en écriture
chmod -R 775 storage bootstrap/cache
```

### 2. Protéger le fichier .env
```bash
chmod 600 .env
```

### 3. Désactiver le mode debug en production
```env
APP_DEBUG=false
APP_ENV=production
```

## 🔍 Vérification de l'Installation

### Checklist
- [ ] PHP >= 8.2 installé
- [ ] PostgreSQL >= 15 installé et démarré
- [ ] Base de données `rh` créée
- [ ] Tables créées (sql/1-TABLE.sql)
- [ ] Données de test insérées
- [ ] `.env` configuré correctement
- [ ] Clé API Gemini configurée
- [ ] `php artisan storage:link` exécuté
- [ ] Permissions correctes sur storage/
- [ ] Serveur accessible sur le navigateur
- [ ] Connexion admin/rh fonctionne

### Commandes de Diagnostic
```bash
# Vérifier la version PHP
php -v

# Vérifier les extensions
php -m

# Vérifier la connexion PostgreSQL
psql -U postgres -d rh -c "SELECT version();"

# Tester la configuration Laravel
php artisan about

# Vérifier les routes
php artisan route:list
```

## 🆘 Besoin d'Aide ?

Consultez le [Guide de Dépannage](TROUBLESHOOTING.md) pour résoudre les problèmes courants.

---

**Dernière mise à jour** : Octobre 2025
