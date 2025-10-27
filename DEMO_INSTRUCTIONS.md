# 🎯 INSTRUCTIONS RAPIDES - PRÉPARATION DÉMO

## ⚡ DÉMARRAGE RAPIDE (5 minutes)

### 1️⃣ Charger les données de démonstration

**Option A : Avec le script automatique** (Recommandé)
```bash
cd sql
chmod +x setup-demo.sh
./setup-demo.sh
# Choisir l'option 1 (Installation complète)
```

**Option B : Manuellement**
```bash
# Créer la structure
psql -U postgres -f sql/1-TABLE.sql

# Charger les données
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# Vérifier
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

---

### 2️⃣ Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Admin** | admin@rh.local | admin123 |
| **RH** | rh@rh.local | rh123 |
| **Candidat (Retenu)** | sophie.andria@email.com | rh123 |
| **Candidat (Test)** | marie.rabe@email.com | rh123 |
| **Candidat (Entretien)** | paul.razafy@email.com | rh123 |

---

### 3️⃣ Démarrer l'application

```bash
# Démarrer le serveur Laravel
php artisan serve

# Ouvrir dans le navigateur
http://localhost:8000
```

---

## 📊 DONNÉES DISPONIBLES

### ✅ Ce qui est déjà créé :

- **10 utilisateurs** (Admin, RH, 8 Candidats)
- **5 départements** (Informatique, Marketing, RH, Finance, Commercial)
- **5 annonces** (4 ouvertes, 1 fermée)
- **8 candidatures** avec tous les statuts possibles :
  - ✅ Employé (Jean RASOLOFO)
  - ✅ Retenu (Sophie ANDRIA)
  - ✅ En entretien (Paul RAZAFY)
  - ✅ Test en cours (Marie RABE)
  - ✅ En attente (David RANDRIANA, Emma RAKOTOMALALA)
  - ❌ Refusé test (Alice RAHARISON)
  - ❌ Refusé entretien (Michel RANDRIA)
- **3 tests QCM** avec questions/réponses
- **4 résultats de tests** (scores de 37.5% à 100%)
- **5 entretiens** (passés et à venir)
- **3 évaluations** d'entretiens
- **2 contrats actifs** (CDI + Essai)
- **3 affiliations sociales** (CNAPS, OSTIE)
- **2 employés** actifs
- **7 notifications**

---

## 🎬 PARCOURS DE DÉMONSTRATION

### 🔵 PARTIE 1 : Interface RH (15 min)

1. **Connexion RH** : `rh@rh.local` / `rh123`
2. **Dashboard** : Voir les statistiques et graphiques
3. **Annonces** : Créer une nouvelle annonce
4. **Tri Candidats** : Voir le classement automatique
5. **Tests QCM** : Consulter les résultats
6. **Entretiens** : Voir le calendrier et les évaluations
7. **Décisions** : Vue d'ensemble des candidats
8. **Contrats** : Voir les contrats actifs
9. **Affiliations** : Voir les affiliations sociales
10. **Employés** : Liste des employés

### 🟢 PARTIE 2 : Interface Candidat (10 min)

1. **Connexion Candidat** : `sophie.andria@email.com` / `rh123`
2. **Dashboard** : Voir les statistiques personnelles
3. **Annonces** : Consulter les offres disponibles
4. **Suivi** : Voir sa candidature (Retenu)
5. **Changer de compte** : `marie.rabe@email.com` / `rh123`
6. **Passer un test** : Faire le test QCM
7. **Voir le résultat** : Score et feedback

---

## 🔄 RESET DES DONNÉES

### Avant chaque démonstration :

**Option A : Script automatique**
```bash
cd sql
./setup-demo.sh
# Choisir l'option 2 (Reset et rechargement)
```

**Option B : Manuel**
```bash
# Vider les données
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql

# Recharger
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql
```

---

## 🐛 DÉPANNAGE RAPIDE

### Problème : "Database does not exist"
```bash
psql -U postgres -f sql/1-TABLE.sql
```

### Problème : "Connection refused"
```bash
# Démarrer PostgreSQL
sudo systemctl start postgresql
# ou
sudo service postgresql start
```

### Problème : "Permission denied"
```bash
# Donner les droits
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE rh TO postgres;"
```

### Problème : "Pas de données"
```bash
# Recharger les données
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql
```

### Vérifier que tout fonctionne :
```bash
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

---

## 📚 DOCUMENTATION COMPLÈTE

- **Guide de démonstration détaillé** : `docs/GUIDE_DEMONSTRATION.md`
- **Documentation SQL** : `sql/README.md`
- **Structure de la base** : `sql/1-TABLE.sql`

---

## ✅ CHECKLIST AVANT DÉMO

- [ ] PostgreSQL est démarré
- [ ] Base de données créée et données chargées
- [ ] Vérification passée avec succès
- [ ] Serveur Laravel démarré
- [ ] Comptes de test notés
- [ ] Guide de démo imprimé/ouvert
- [ ] Navigateur prêt (onglets RH + Candidat)

---

## 🎯 POINTS CLÉS À MONTRER

### Fonctionnalités principales :
1. ✅ **Gestion complète du recrutement** (de l'annonce au contrat)
2. ✅ **Tri automatique des candidats** (scoring CV)
3. ✅ **Tests QCM automatisés** (correction instantanée)
4. ✅ **Planification d'entretiens** (calendrier)
5. ✅ **Évaluations structurées** (notes et commentaires)
6. ✅ **Génération de contrats** (essai, CDD, CDI)
7. ✅ **Affiliations sociales** (CNAPS, OSTIE, AMIT)
8. ✅ **Suivi employés** (matricules, statuts)
9. ✅ **Notifications** (alertes automatiques)
10. ✅ **Statistiques et reporting** (graphiques)

### Aspects techniques :
1. ✅ **Interface moderne** (AdminLTE 3)
2. ✅ **Responsive design** (mobile, tablette, desktop)
3. ✅ **Architecture MVC** (Laravel)
4. ✅ **Base de données relationnelle** (PostgreSQL)
5. ✅ **Sécurité** (authentification, rôles, CSRF)

---

## 📞 SUPPORT

En cas de problème pendant la démo :
1. Garder son calme 😊
2. Utiliser le script de reset rapide
3. Avoir une sauvegarde de la base
4. Connaître les routes principales

---

**Bonne démonstration ! 🚀**
