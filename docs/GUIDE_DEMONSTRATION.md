# 🎯 GUIDE DE DÉMONSTRATION - Système RH
## Présentation Professeur

---

## 📋 PRÉPARATION AVANT LA DÉMO

### 1. Charger les données de démonstration
```bash
# Se connecter à PostgreSQL
psql -U postgres

# Exécuter le script de données
\i /chemin/vers/sql/data/DEMO_COMPLETE.sql
```

### 2. Comptes de test disponibles
| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Admin** | admin@rh.local | admin123 |
| **RH** | rh@rh.local | rh123 |
| **Candidat** | jean.rasolofo@email.com | rh123 |
| **Candidat** | sophie.andria@email.com | rh123 |

---

## 🎬 SCÉNARIO DE DÉMONSTRATION (30 minutes)

### ⏱️ PARTIE 1 : INTERFACE RH (15 minutes)

#### **1.1 Connexion et Dashboard RH** (2 min)
**Objectif** : Montrer l'interface moderne AdminLTE

**Actions** :
1. Se connecter avec `rh@rh.local` / `rh123`
2. **Montrer le Dashboard** :
   - ✅ 4 Info-boxes avec statistiques en temps réel
   - ✅ Graphique d'évolution des candidatures (Chart.js)
   - ✅ Graphique de répartition par statut (Doughnut)
   - ✅ Tableau des dernières candidatures
   - ✅ Tableau des prochains entretiens
   - ✅ Boutons d'actions rapides

**Points à souligner** :
- Interface responsive et moderne
- Données dynamiques
- Navigation intuitive

---

#### **1.2 Gestion des Annonces** (3 min)
**Objectif** : Montrer le cycle de vie d'une annonce

**Actions** :
1. **Aller dans "Annonces" → "Liste des annonces"**
   - Montrer les 5 annonces avec différents statuts
   - Filtrer par statut (ouverte/fermée)
   - Badges colorés pour les dates limites

2. **Créer une nouvelle annonce** :
   - Cliquer sur "Créer une annonce"
   - Remplir le formulaire :
     ```
     Département: Informatique
     Titre: Développeur Mobile Flutter
     Description: Développement d'applications mobiles cross-platform
     Compétences: Flutter, Dart, Firebase, Git
     Niveau: BAC+3 + 2 ans d'expérience
     Date limite: [Date dans 30 jours]
     ```
   - Valider et montrer le message de succès

**Points à souligner** :
- Validation des formulaires
- Interface claire et guidée
- Gestion des dates

---

#### **1.3 Tri et Notation des Candidats** (4 min)
**Objectif** : Démontrer le système de tri automatique

**Actions** :
1. **Aller dans "Tri des Candidats"**
   - Sélectionner l'annonce "Développeur Full Stack Senior"
   - Montrer la liste des 5 candidats avec leurs scores CV

2. **Examiner un profil** :
   - Cliquer sur "Voir Profil" de Sophie ANDRIA
   - Montrer les compétences matchées
   - Score CV: 88.75%
   - Statut: Retenu

3. **Montrer les différents statuts** :
   - ✅ En attente (Emma - 78%)
   - ✅ Test en cours (Marie - 82.5%)
   - ✅ En entretien (Paul - 85%)
   - ✅ Retenu (Sophie - 88.75%)
   - ❌ Refusé (Alice - 45%)

**Points à souligner** :
- Tri automatique par score
- Visualisation claire des compétences
- Aide à la décision

---

#### **1.4 Gestion des Tests QCM** (3 min)
**Objectif** : Montrer la création et les résultats des tests

**Actions** :
1. **Voir les tests existants** :
   - Aller dans "Tests QCM" → "Voir les tests QCM"
   - Montrer le test "Développeur Full Stack" avec 5 questions

2. **Consulter les résultats** :
   - Aller dans "Tests QCM" → "Résultats QCM candidats"
   - Sélectionner l'annonce "Développeur Full Stack Senior"
   - Montrer les 4 résultats :
     - Jean: 100% ✅
     - Sophie: 87.5% ✅
     - Paul: 87.5% ✅
     - Alice: 37.5% ❌

**Points à souligner** :
- Correction automatique
- Seuil de réussite (70%)
- Statistiques détaillées

---

#### **1.5 Gestion des Entretiens** (3 min)
**Objectif** : Montrer la planification et l'évaluation

**Actions** :
1. **Voir le calendrier** :
   - Aller dans "Entretiens" → "Calendrier des entretiens"
   - Montrer les 2 entretiens à venir :
     - Paul RAZAFY - Dans 3 jours (Confirmé)
     - Michel RANDRIA - Dans 7 jours (Planifié)

2. **Évaluer un entretien** :
   - Aller dans "Entretiens" → "Évaluer les entretiens"
   - Sélectionner l'entretien de Sophie ANDRIA
   - Montrer l'évaluation : 17/20
   - Commentaire positif

3. **Voir les résultats globaux** :
   - Aller dans "Entretiens" → "Résultats globaux"
   - Montrer le classement des candidats

**Points à souligner** :
- Gestion complète du processus
- Évaluation structurée
- Aide à la décision finale

---

### ⏱️ PARTIE 2 : INTERFACE CANDIDAT (10 minutes)

#### **2.1 Connexion Candidat** (1 min)
**Actions** :
1. Se déconnecter du compte RH
2. Se connecter avec `sophie.andria@email.com` / `rh123`

---

#### **2.2 Dashboard Candidat** (2 min)
**Objectif** : Montrer l'espace personnel du candidat

**Actions** :
1. **Montrer le Dashboard** :
   - Message de bienvenue personnalisé
   - 3 Small-boxes avec statistiques :
     - Annonces disponibles
     - Mes candidatures
     - Entretiens planifiés
   - Actions rapides (6 boutons)

**Points à souligner** :
- Interface adaptée au candidat
- Informations pertinentes
- Navigation simplifiée

---

#### **2.3 Consulter les Annonces** (2 min)
**Objectif** : Montrer la recherche d'emploi

**Actions** :
1. **Voir les annonces** :
   - Cliquer sur "Annonces Disponibles"
   - Montrer les 4 annonces ouvertes
   - Badges pour jours restants (vert/jaune/rouge)

2. **Voir les détails** :
   - Cliquer sur "Développeur Full Stack Senior"
   - Montrer :
     - Description complète
     - Compétences requises
     - Date limite avec badge
     - Conseils dans la sidebar
   - Bouton "Postuler"

**Points à souligner** :
- Interface claire
- Informations complètes
- Aide à la décision

---

#### **2.4 Suivi de Candidature** (2 min)
**Objectif** : Montrer le tracking de candidature

**Actions** :
1. **Voir le suivi** :
   - Cliquer sur "Mes Candidatures"
   - Montrer la candidature de Sophie :
     - Card verte (Retenu)
     - Badge "Retenu" avec icône
     - Barre de progression à 80%
     - Callout de félicitations
     - Détails (département, date)

**Points à souligner** :
- Transparence du processus
- Visualisation de la progression
- Communication claire

---

#### **2.5 Passer un Test QCM** (3 min)
**Objectif** : Montrer l'expérience de test

**Actions** :
1. Se déconnecter et se connecter avec `marie.rabe@email.com` / `rh123`

2. **Sélectionner un test** :
   - Cliquer sur "Passer un Test"
   - Sélectionner "Développeur Full Stack Senior"
   - Montrer le callout d'informations
   - Cliquer sur "Passer le test"

3. **Répondre aux questions** :
   - Montrer l'interface :
     - Cards pour chaque question
     - Radio buttons stylisés
     - Sidebar de progression (sticky)
     - Compteur de questions répondues
     - Barre de progression dynamique
   - Répondre à 2-3 questions
   - Montrer la mise à jour automatique de la progression

4. **Valider** :
   - Cliquer sur "Valider mes réponses"
   - Confirmer
   - Montrer la page de résultat :
     - Info-box géante avec score
     - Barre de progression visuelle
     - Callout de réussite/échec
     - Statistiques (total questions, seuil)

**Points à souligner** :
- Interface intuitive
- Feedback en temps réel
- Résultats immédiats

---

### ⏱️ PARTIE 3 : FONCTIONNALITÉS AVANCÉES (5 minutes)

#### **3.1 Gestion des Contrats** (2 min)
**Objectif** : Montrer le cycle complet jusqu'à l'embauche

**Actions** :
1. Se reconnecter en RH
2. **Aller dans "Contrats"** :
   - Montrer les 2 contrats actifs :
     - Jean RASOLOFO - CDI (actif)
     - Sophie ANDRIA - Essai (actif)
   - Cliquer sur le contrat de Jean
   - Montrer les détails complets

3. **Affiliations sociales** :
   - Aller dans "Affiliations sociales"
   - Montrer les affiliations de Jean :
     - CNAPS
     - OSTIE
   - Statut actif

4. **Employés** :
   - Aller dans "Employés"
   - Montrer la liste des 2 employés
   - Matricules, dates d'embauche, statuts

**Points à souligner** :
- Gestion complète du cycle
- Conformité légale (affiliations)
- Suivi des employés

---

#### **3.2 Système de Notifications** (1 min)
**Objectif** : Montrer la communication automatisée

**Actions** :
1. **Voir les notifications RH** :
   - Cliquer sur l'icône cloche (navbar)
   - Montrer les 3 notifications :
     - Nouvelle candidature (Emma)
     - Entretien à venir (Paul)
     - Test complété (Sophie)

2. **Voir les notifications candidat** :
   - Se connecter en candidat (Sophie)
   - Montrer la notification de félicitations

**Points à souligner** :
- Communication automatique
- Alertes en temps réel
- Traçabilité

---

#### **3.3 Décision de Recrutement** (2 min)
**Objectif** : Montrer la prise de décision finale

**Actions** :
1. Se reconnecter en RH
2. **Aller dans "Décision de recrutement"** :
   - Montrer le tableau récapitulatif :
     - Scores CV
     - Résultats tests
     - Notes entretiens
     - Score global
   - Montrer les candidats retenus vs refusés
   - Expliquer le processus de décision

**Points à souligner** :
- Vue d'ensemble complète
- Aide à la décision objective
- Traçabilité des choix

---

## 🎯 POINTS FORTS À METTRE EN AVANT

### ✅ Technique
1. **Architecture moderne** :
   - Laravel (backend)
   - PostgreSQL (base de données)
   - AdminLTE 3 (interface)
   - Chart.js (graphiques)

2. **Responsive Design** :
   - Fonctionne sur desktop, tablette, mobile
   - Interface adaptative

3. **Sécurité** :
   - Authentification sécurisée
   - Gestion des rôles (Admin/RH/Candidat)
   - Protection CSRF

### ✅ Fonctionnel
1. **Processus complet de recrutement** :
   - Publication d'annonces
   - Réception et tri des candidatures
   - Tests QCM automatisés
   - Planification d'entretiens
   - Évaluation et décision
   - Génération de contrats
   - Affiliations sociales

2. **Automatisation** :
   - Tri automatique des CV
   - Correction automatique des tests
   - Calcul automatique des scores
   - Notifications automatiques

3. **Traçabilité** :
   - Historique complet de chaque candidature
   - Suivi des décisions
   - Statistiques et reporting

### ✅ UX/UI
1. **Interface intuitive** :
   - Navigation claire
   - Feedback visuel
   - Messages explicites

2. **Design moderne** :
   - AdminLTE 3
   - Icônes Font Awesome
   - Couleurs cohérentes
   - Animations fluides

---

## 📊 DONNÉES DE DÉMONSTRATION

### Résumé des données chargées :
- **10 utilisateurs** (1 Admin, 1 RH, 8 Candidats)
- **5 départements**
- **5 annonces** (4 ouvertes, 1 fermée)
- **8 candidatures** (tous les statuts)
- **3 tests QCM** avec questions/réponses
- **5 entretiens** (passés, à venir, confirmés)
- **2 contrats actifs** (CDI + Essai)
- **3 affiliations sociales**
- **2 employés**
- **7 notifications**

### Cas de figure illustrés :
✅ Candidat employé (parcours complet)
✅ Candidat retenu (en attente de contrat)
✅ Candidat en entretien
✅ Candidat en test
✅ Candidat en attente (nouvelle candidature)
✅ Candidat refusé (test échoué)
✅ Candidat refusé (après entretien)
✅ Annonce sans candidat
✅ Annonce fermée
✅ Contrat d'essai
✅ Contrat CDI
✅ Affiliations multiples

---

## 🔄 RESET DES DONNÉES

### Pour recommencer la démo :
```bash
# Méthode 1: Utiliser le script TRUNCATE
psql -U postgres -d rh -f sql/drop\ \&\ truncate/TRUNCATE.sql

# Méthode 2: Recharger les données
psql -U postgres -d rh -f sql/data/DEMO_COMPLETE.sql
```

### Vérifier le reset :
```sql
-- Compter les enregistrements
SELECT 
    (SELECT COUNT(*) FROM users) as users,
    (SELECT COUNT(*) FROM candidatures) as candidatures,
    (SELECT COUNT(*) FROM tests) as tests;
```

---

## 💡 CONSEILS POUR LA PRÉSENTATION

### Avant la démo :
1. ✅ Tester la connexion à la base de données
2. ✅ Vérifier que toutes les données sont chargées
3. ✅ Ouvrir plusieurs onglets (RH + Candidat)
4. ✅ Préparer les comptes de connexion
5. ✅ Tester le parcours complet une fois

### Pendant la démo :
1. 🎯 Commencer par le Dashboard (impact visuel)
2. 🎯 Suivre un fil conducteur (parcours candidat)
3. 🎯 Montrer les automatisations
4. 🎯 Mettre en avant l'UX
5. 🎯 Terminer par les statistiques

### En cas de problème :
1. 🔧 Avoir le script TRUNCATE prêt
2. 🔧 Avoir une sauvegarde des données
3. 🔧 Connaître les routes principales
4. 🔧 Avoir le guide sous les yeux

---

## ⏱️ TIMING RECOMMANDÉ

| Partie | Durée | Contenu |
|--------|-------|---------|
| Introduction | 2 min | Contexte et objectifs |
| Interface RH | 15 min | Dashboard, Annonces, Tri, Tests, Entretiens |
| Interface Candidat | 10 min | Dashboard, Annonces, Suivi, Tests |
| Fonctionnalités avancées | 5 min | Contrats, Notifications, Décisions |
| Questions/Réponses | 8 min | Discussion |
| **TOTAL** | **40 min** | |

---

## 🎓 CONCLUSION

### Points à rappeler :
1. ✅ **Système complet** de gestion RH
2. ✅ **Automatisation** du processus de recrutement
3. ✅ **Interface moderne** et intuitive
4. ✅ **Traçabilité** et conformité
5. ✅ **Évolutivité** et maintenabilité

### Améliorations futures possibles :
- 📧 Envoi d'emails automatiques
- 📄 Génération de PDF (contrats, CV)
- 📊 Tableaux de bord avancés
- 🔔 Notifications push en temps réel
- 📱 Application mobile
- 🤖 IA pour le tri des CV

---

**Bonne présentation ! 🎉**
