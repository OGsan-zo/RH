# 🔧 Guide de Dépannage

Ce guide vous aide à résoudre les problèmes courants rencontrés lors de l'installation et de l'utilisation du système RH.

## 🗄️ Problèmes de Base de Données

### Erreur : "SQLSTATE[08006] could not connect to server"

**Cause** : PostgreSQL n'est pas démarré ou n'écoute pas sur le bon port.

**Solutions** :

```bash
# Vérifier le statut de PostgreSQL
sudo systemctl status postgresql

# Démarrer PostgreSQL
sudo systemctl start postgresql

# Activer au démarrage
sudo systemctl enable postgresql

# Vérifier le port d'écoute
sudo netstat -plunt | grep postgres
```

### Erreur : "SQLSTATE[42P01] relation does not exist"

**Cause** : Les tables n'ont pas été créées.

**Solution** :
```bash
# Exécuter les scripts SQL dans l'ordre
psql -U postgres -d rh -f sql/1-TABLE.sql
psql -U postgres -d rh -f sql/2-VIEW.sql
psql -U postgres -d rh -f sql/data/3-INSERT.sql
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql
```

### Erreur : "FATAL: password authentication failed"

**Cause** : Mauvais mot de passe ou utilisateur incorrect.

**Solution** :
```bash
# Réinitialiser le mot de passe PostgreSQL
sudo -u postgres psql
ALTER USER postgres PASSWORD 'nouveau_mot_de_passe';
\q

# Mettre à jour le .env
DB_PASSWORD=nouveau_mot_de_passe
```

### Erreur : "SQLSTATE[42703] column 'note_cv' does not exist"

**Cause** : La colonne `note_cv` n'a pas été ajoutée.

**Solution** :
```bash
psql -U postgres -d rh -f sql/data/4-ADD-NOTE-CV.sql
```

## 📁 Problèmes de Fichiers et Permissions

### Erreur : "The stream or file could not be opened"

**Cause** : Permissions insuffisantes sur les dossiers storage/ ou bootstrap/cache/.

**Solution** :
```bash
# Donner les permissions d'écriture
chmod -R 775 storage bootstrap/cache

# Si vous utilisez Apache/Nginx
sudo chown -R www-data:www-data storage bootstrap/cache

# Vérifier les permissions
ls -la storage/
```

### Erreur : "No such file or directory" pour le CV

**Cause** : Le lien symbolique storage n'existe pas.

**Solution** :
```bash
# Créer le lien symbolique
php artisan storage:link

# Vérifier que le lien existe
ls -la public/storage

# Si le lien existe déjà, le supprimer et recréer
rm public/storage
php artisan storage:link
```

### CV non accessible (404)

**Cause** : Mauvais chemin vers le fichier CV.

**Solution** :
```bash
# Vérifier que le fichier existe
ls -la storage/app/public/cv/

# Vérifier le lien symbolique
ls -la public/storage

# Si nécessaire, recréer le lien
php artisan storage:link
```

## 🔑 Problèmes d'Authentification

### Erreur : "No application encryption key has been specified"

**Cause** : La clé APP_KEY n'est pas générée.

**Solution** :
```bash
php artisan key:generate
```

### Impossible de se connecter avec les comptes de test

**Cause** : Les données de test n'ont pas été insérées.

**Solution** :
```bash
psql -U postgres -d rh -f sql/data/3-INSERT.sql
```

### Session expirée trop rapidement

**Cause** : Configuration de session incorrecte.

**Solution** :
```env
# Dans .env
SESSION_LIFETIME=120
SESSION_DRIVER=database
```

## 🤖 Problèmes avec l'IA (Gemini)

### Erreur : "Malformed UTF-8 characters"

**Cause** : Le CV contient des caractères binaires non-UTF8.

**Solution** :
```bash
# Nettoyer les données corrompues
psql -U postgres -d rh -f sql/data/5-FIX-COMPETENCES.sql
```

Le code a été mis à jour pour nettoyer automatiquement les caractères non-UTF8.

### Erreur : "API key not valid"

**Cause** : Clé API Gemini invalide ou manquante.

**Solution** :
```bash
# Vérifier que la clé est dans .env
grep GEMINI_API_KEY .env

# Obtenir une nouvelle clé sur
# https://makersuite.google.com/app/apikey
```

### Note CV toujours NULL

**Causes possibles** :
1. La colonne `note_cv` n'est pas dans le `$fillable` du modèle
2. Le CV n'a pas pu être lu
3. L'extraction du texte a échoué

**Solutions** :
```bash
# 1. Vérifier le modèle Candidature
grep "note_cv" app/Models/Candidature.php

# 2. Vérifier les logs
tail -f storage/logs/laravel.log
tail -f storage/logs/gemini_cv_evaluation.log

# 3. Tester manuellement l'extraction
php artisan tinker
>>> $service = app(\App\Services\CvParserService::class);
>>> $text = $service->extraireTexteDepuisFichier('storage/app/public/cv/test.pdf');
>>> echo $text;
```

### Erreur : "Rate limit exceeded"

**Cause** : Trop de requêtes à l'API Gemini.

**Solution** :
- Attendre quelques minutes
- Utiliser une autre clé API
- Implémenter un système de cache pour les résultats

## 📦 Problèmes de Dépendances

### Erreur : "Class 'GuzzleHttp\Client' not found"

**Cause** : La bibliothèque GuzzleHTTP n'est pas installée.

**Solution** :
```bash
composer require guzzlehttp/guzzle
```

### Erreur : "Your requirements could not be resolved"

**Cause** : Conflit de versions de dépendances.

**Solution** :
```bash
# Supprimer le cache Composer
rm -rf vendor/
rm composer.lock

# Réinstaller
composer install
```

### Erreur : "PHP Fatal error: Allowed memory size exhausted"

**Cause** : Mémoire PHP insuffisante.

**Solution** :
```bash
# Augmenter la limite temporairement
php -d memory_limit=512M artisan serve

# Ou dans php.ini
memory_limit = 512M
```

## 🌐 Problèmes de Serveur Web

### Page blanche sans erreur

**Cause** : Erreur PHP non affichée.

**Solution** :
```bash
# Activer le mode debug temporairement
# Dans .env
APP_DEBUG=true

# Vérifier les logs
tail -f storage/logs/laravel.log

# Vérifier les logs Apache/Nginx
sudo tail -f /var/log/apache2/error.log
sudo tail -f /var/log/nginx/error.log
```

### Erreur 500 Internal Server Error

**Causes possibles** :
1. Permissions incorrectes
2. .htaccess manquant
3. mod_rewrite non activé

**Solutions** :
```bash
# 1. Vérifier les permissions
chmod -R 775 storage bootstrap/cache

# 2. Vérifier .htaccess dans public/
ls -la public/.htaccess

# 3. Activer mod_rewrite (Apache)
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### CSS/JS ne se chargent pas

**Cause** : Assets non compilés ou mauvais chemin.

**Solution** :
```bash
# Vérifier que les assets existent
ls -la public/css/
ls -la public/js/

# Si vous utilisez Vite/Mix
npm install
npm run build
```

## 🔍 Problèmes de Performance

### Application lente

**Solutions** :
```bash
# Activer les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimiser l'autoloader
composer dump-autoload --optimize

# Vérifier les requêtes N+1
# Installer Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev
```

### Upload de CV lent

**Cause** : Limite de taille de fichier trop basse.

**Solution** :
```ini
# Dans php.ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

## 📧 Problèmes de Notifications

### Notifications non envoyées

**Cause** : Configuration mail incorrecte.

**Solution** :
```env
# Pour le développement, utiliser le log
MAIL_MAILER=log

# Vérifier les logs
tail -f storage/logs/laravel.log
```

## 🧪 Outils de Diagnostic

### Commandes Utiles

```bash
# Informations système
php artisan about

# Vérifier la configuration
php artisan config:show database

# Lister les routes
php artisan route:list

# Vider tous les caches
php artisan optimize:clear

# Tester la connexion DB
php artisan tinker
>>> DB::connection()->getPdo();

# Vérifier les migrations
php artisan migrate:status
```

### Logs à Consulter

```bash
# Logs Laravel
tail -f storage/logs/laravel.log

# Logs Gemini
tail -f storage/logs/gemini_cv_evaluation.log
tail -f storage/logs/gemini_competences.log

# Logs PostgreSQL
sudo tail -f /var/log/postgresql/postgresql-15-main.log

# Logs Apache
sudo tail -f /var/log/apache2/error.log

# Logs Nginx
sudo tail -f /var/log/nginx/error.log
```

## 🆘 Obtenir de l'Aide

Si votre problème n'est pas listé ici :

1. **Vérifier les logs** : `storage/logs/laravel.log`
2. **Consulter la documentation Laravel** : [laravel.com/docs](https://laravel.com/docs)
3. **Créer une issue** : [GitHub Issues](https://github.com/votre-username/RH/issues)
4. **Contacter l'équipe** : contact@rh-itu.mg

### Informations à Fournir

Lors d'une demande d'aide, incluez :
- Version de PHP : `php -v`
- Version de PostgreSQL : `psql --version`
- Message d'erreur complet
- Logs pertinents
- Étapes pour reproduire le problème

---

**Dernière mise à jour** : Octobre 2025
