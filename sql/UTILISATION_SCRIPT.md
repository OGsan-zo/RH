# 🚀 Utilisation du Script d'Installation Automatique

## Rendre le script exécutable

```bash
cd sql
chmod +x setup-demo.sh
```

## Lancer le script

```bash
./setup-demo.sh
```

## Menu du script

Le script propose 6 options :

### 1️⃣ Installation complète (première fois)
- Crée la base de données
- Crée toutes les tables
- Charge les données de démonstration
- Vérifie que tout est OK

**Utiliser quand** : Première installation ou après un DROP complet

### 2️⃣ Reset et rechargement des données
- Vide toutes les données (TRUNCATE)
- Recharge les données de démonstration
- Vérifie que tout est OK

**Utiliser quand** : Avant chaque démonstration pour avoir des données fraîches

### 3️⃣ Vérification des données
- Affiche un rapport complet :
  - Nombre d'enregistrements par table
  - Liste des comptes utilisateurs
  - Répartition des candidatures
  - Annonces ouvertes
  - Entretiens à venir
  - Résultats des tests
  - Contrats actifs
  - Affiliations sociales
  - Notifications non lues
  - Statistiques globales

**Utiliser quand** : Pour vérifier que les données sont correctes

### 4️⃣ Supprimer toutes les données (TRUNCATE)
- Vide toutes les tables
- Garde la structure (tables)

**Utiliser quand** : Pour repartir de zéro en gardant les tables

### 5️⃣ Supprimer la base complète (DROP)
- Supprime TOUTE la base de données
- Supprime les tables ET les données

**Utiliser quand** : Pour une réinstallation complète

### 6️⃣ Quitter
- Ferme le script

---

## Exemple d'utilisation

### Première installation
```bash
cd sql
chmod +x setup-demo.sh
./setup-demo.sh
# Choisir : 1
```

### Avant une démo
```bash
cd sql
./setup-demo.sh
# Choisir : 2
```

### Vérifier les données
```bash
cd sql
./setup-demo.sh
# Choisir : 3
```

---

## Si le script ne fonctionne pas

Utiliser les commandes manuelles :

```bash
# Installation complète
psql -U postgres -f sql/1-TABLE.sql
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# Reset
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql

# Vérification
psql -U postgres -d rh -f sql/data/VERIFICATION.sql
```
