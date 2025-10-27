# 📁 Scripts SQL - Système RH

Ce dossier contient tous les scripts SQL nécessaires pour la gestion de la base de données.

---

## 📂 Structure des Fichiers

```
sql/
├── 1-TABLE.sql                    # Création des tables (PostgreSQL)
├── data/
│   ├── 2-ROLE.sql                 # Comptes Admin et RH
│   ├── 3-TEST.sql                 # Données de test basiques
│   ├── DEMO_COMPLETE.sql          # ⭐ Données complètes pour démo
│   └── VERIFICATION.sql           # Script de vérification
├── drop & truncate/
│   ├── DROP.sql                   # Suppression des tables
│   └── TRUNCATE.sql               # Vidage des données
└── README.md                      # Ce fichier
```

---

## 🚀 UTILISATION RAPIDE

### 1. Première Installation

```bash
# 1. Créer la base et les tables
psql -U postgres -f sql/1-TABLE.sql

# 2. Charger les données de démonstration
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# 3. Vérifier que tout est OK
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

### 2. Reset Complet

```bash
# Vider toutes les données
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql

# Recharger les données
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql
```

---

## 📋 Description des Scripts

### 🔧 Scripts de Structure

#### `1-TABLE.sql`
**Objectif** : Créer la base de données et toutes les tables

**Contenu** :
- Création de la base `rh`
- Extension `pgcrypto` pour les UUID
- 15 tables :
  - users
  - departements
  - annonces
  - tests, questions, reponses
  - candidats, candidatures
  - resultats_tests, candidat_reponses
  - entretiens, evaluations_entretiens
  - contrats, affiliations_sociales
  - employes, notifications

**Utilisation** :
```bash
psql -U postgres -f sql/1-TABLE.sql
```

---

### 📊 Scripts de Données

#### `data/2-ROLE.sql`
**Objectif** : Créer les comptes Admin et RH

**Comptes créés** :
- Admin : `admin@rh.local` / `admin123`
- RH : `rh@rh.local` / `rh123`

**Utilisation** :
```bash
psql -U postgres -d rh -f sql/data/2-ROLE.sql
```

---

#### `data/3-TEST.sql`
**Objectif** : Données de test basiques

**Contenu** :
- 3 départements
- 3 annonces ouvertes

**Utilisation** :
```bash
psql -U postgres -d rh -f sql/data/3-TEST.sql
```

---

#### `data/DEMO_COMPLETE.sql` ⭐
**Objectif** : Données complètes pour démonstration

**Contenu** :
- **10 utilisateurs** (1 Admin, 1 RH, 8 Candidats)
- **5 départements**
- **5 annonces** (différents statuts)
- **8 candidatures** (tous les cas de figure)
- **3 tests QCM** avec questions/réponses
- **4 résultats de tests**
- **5 entretiens** (passés, à venir)
- **3 évaluations**
- **2 contrats actifs**
- **3 affiliations sociales**
- **2 employés**
- **7 notifications**

**Cas de figure illustrés** :
- ✅ Candidat employé (parcours complet)
- ✅ Candidat retenu
- ✅ Candidat en entretien
- ✅ Candidat en test
- ✅ Candidat en attente
- ✅ Candidat refusé (test)
- ✅ Candidat refusé (entretien)
- ✅ Annonce sans candidat
- ✅ Annonce fermée
- ✅ Contrat d'essai
- ✅ Contrat CDI

**Utilisation** :
```bash
# Première fois
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# Pour reset et recharger
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql
```

**Comptes de test** :
| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@rh.local | admin123 |
| RH | rh@rh.local | rh123 |
| Candidat | jean.rasolofo@email.com | rh123 |
| Candidat | sophie.andria@email.com | rh123 |
| Candidat | paul.razafy@email.com | rh123 |
| Candidat | marie.rabe@email.com | rh123 |

---

#### `data/VERIFICATION.sql`
**Objectif** : Vérifier que les données sont bien chargées

**Affiche** :
1. Comptage de tous les enregistrements
2. Liste des comptes utilisateurs
3. Répartition des candidatures par statut
4. Annonces ouvertes avec urgence
5. Entretiens à venir
6. Résultats des tests QCM
7. Contrats actifs
8. Affiliations sociales
9. Notifications non lues
10. Statistiques globales

**Utilisation** :
```bash
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

**Exemple de sortie** :
```
=========================================
VÉRIFICATION DES DONNÉES
=========================================
 table_name       | count 
------------------+-------
 Affiliations     |     3
 Annonces         |     5
 Candidats        |     8
 Candidatures     |     8
 Contrats         |     2
 ...

=========================================
COMPTES UTILISATEURS
=========================================
 id |        name         |           email            | role     
----+---------------------+----------------------------+----------
  1 | Administrateur...   | admin@rh.local             | admin
  2 | Marie RAKOTO        | rh@rh.local                | rh
  3 | Jean RASOLOFO       | jean.rasolofo@email.com    | candidat
...
```

---

### 🗑️ Scripts de Nettoyage

#### `drop & truncate/TRUNCATE.sql`
**Objectif** : Vider toutes les données (garder les tables)

**Action** :
- TRUNCATE de toutes les tables
- RESTART IDENTITY (remet les ID à 1)
- CASCADE (supprime les dépendances)

**Utilisation** :
```bash
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql
```

⚠️ **ATTENTION** : Cette commande supprime TOUTES les données !

---

#### `drop & truncate/DROP.sql`
**Objectif** : Supprimer toutes les tables

**Action** :
- DROP TABLE de toutes les tables
- CASCADE (supprime les dépendances)

**Utilisation** :
```bash
psql -U postgres -d rh -f sql/drop\ \&\ truncate/DROP.sql
```

⚠️ **ATTENTION** : Cette commande supprime les tables ET les données !

---

## 🎯 Scénarios d'Utilisation

### Scénario 1 : Installation Initiale
```bash
# 1. Créer la structure
psql -U postgres -f sql/1-TABLE.sql

# 2. Charger les données de démo
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# 3. Vérifier
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

---

### Scénario 2 : Préparation de Démo
```bash
# 1. Reset complet
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql

# 2. Charger les données
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# 3. Vérifier que tout est OK
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

---

### Scénario 3 : Développement
```bash
# Utiliser les données de test basiques
psql -U postgres -d rh -f sql/data/2-ROLE.sql
psql -U postgres -d rh -f sql/data/3-TEST.sql
```

---

### Scénario 4 : Reset Rapide
```bash
# Vider et recharger en une commande
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql && \
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql
```

---

## 🔍 Vérifications Manuelles

### Compter les enregistrements
```sql
SELECT 
    (SELECT COUNT(*) FROM users) as users,
    (SELECT COUNT(*) FROM candidatures) as candidatures,
    (SELECT COUNT(*) FROM tests) as tests,
    (SELECT COUNT(*) FROM contrats) as contrats;
```

### Voir les candidatures
```sql
SELECT 
    c.id,
    cand.nom || ' ' || cand.prenom as candidat,
    a.titre as poste,
    c.statut,
    c.score_global
FROM candidatures c
JOIN candidats cand ON c.candidat_id = cand.id
JOIN annonces a ON c.annonce_id = a.id
ORDER BY c.date_candidature DESC;
```

### Voir les tests et résultats
```sql
SELECT 
    t.titre as test,
    COUNT(q.id) as nb_questions,
    COUNT(DISTINCT rt.id) as nb_passages,
    ROUND(AVG(rt.score), 2) as score_moyen
FROM tests t
LEFT JOIN questions q ON t.id = q.test_id
LEFT JOIN resultats_tests rt ON t.id = rt.test_id
GROUP BY t.id, t.titre;
```

---

## 📝 Notes Importantes

### Mots de passe
Tous les mots de passe sont hashés avec bcrypt :
- Hash : `$2y$12$7dLqqlzxnOa5N8/UUddQaukIRh3zpEdh3TRuit0da8kGOidkZdl.C`
- Correspond à : `rh123`

### Dates
Les dates sont relatives à `CURRENT_DATE` :
- Permet d'avoir des données toujours à jour
- Les entretiens "à venir" sont toujours dans le futur
- Les dates limites sont cohérentes

### Scores
Les scores sont réalistes :
- Score CV : 45% à 95%
- Score tests : 37.5% à 100%
- Notes entretiens : 11.5/20 à 19.5/20

---

## 🐛 Dépannage

### Erreur : "database does not exist"
```bash
# Créer la base manuellement
psql -U postgres -c "CREATE DATABASE rh;"
```

### Erreur : "relation already exists"
```bash
# Supprimer les tables existantes
psql -U postgres -d rh -f sql/drop\ \&\ truncate/DROP.sql
# Puis recréer
psql -U postgres -f sql/1-TABLE.sql
```

### Erreur : "permission denied"
```bash
# Vérifier les droits
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE rh TO postgres;"
```

### Les données ne s'affichent pas
```bash
# Vérifier la connexion à la bonne base
psql -U postgres -d rh -c "SELECT current_database();"

# Vérifier les données
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```

---

## 📚 Ressources

- [Documentation PostgreSQL](https://www.postgresql.org/docs/)
- [Guide Laravel Database](https://laravel.com/docs/database)
- [Guide de Démonstration](../docs/GUIDE_DEMONSTRATION.md)

---

**Dernière mise à jour** : Octobre 2025
