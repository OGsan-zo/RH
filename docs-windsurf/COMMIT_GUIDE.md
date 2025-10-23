# Guide de Commit pour la Fonctionnalité Tri CV

## 📦 Structure des Commits

Pour pousser cette fonctionnalité sur GitHub, voici la structure recommandée des commits :

### Commit 1 : Base de données
```bash
git add sql/data/4-ADD-NOTE-CV.sql sql/data/5-FIX-COMPETENCES.sql
git commit -m "feat(database): ajout colonne note_cv et nettoyage données

- Ajout colonne note_cv (DECIMAL 5,2) dans table candidatures
- Script de nettoyage des compétences corrompues
- Support pour stockage note IA du CV"
```

### Commit 2 : Services IA
```bash
git add app/Services/GeminiService.php app/Services/CvParserService.php
git commit -m "feat(ai): analyse IA du CV et extraction texte PDF

- Ajout méthode evaluerCVPourPoste() dans GeminiService
- Évaluation adéquation CV/Poste sur 100 points
- Extraction texte PDF avec CvParserService
- Nettoyage UTF-8 pour éviter erreurs JSON
- Gestion erreurs avec fallback valeurs par défaut"
```

### Commit 3 : Modèles et Contrôleurs
```bash
git add app/Models/Candidature.php app/Http/Controllers/CandidatureController.php app/Http/Controllers/EvaluationEntretienController.php
git commit -m "feat(models): intégration note_cv dans le processus de recrutement

- Ajout note_cv dans fillable du modèle Candidature
- Analyse automatique CV lors de la postulation
- Recalcul score_global avec 3 notes (CV + Test + Entretien)
- Correction chemin CV (storage au lieu de public)"
```

### Commit 4 : Tri et Filtrage
```bash
git add app/Http/Controllers/TriCandidatController.php
git commit -m "feat(tri): contrôleur tri candidats avec filtres avancés

- Création TriCandidatController avec filtres
- Recherche par nom/prénom (insensible casse)
- Filtre par âge (min/max)
- Filtre par compétences
- Filtre par statut candidature
- Optimisation requêtes (eager loading, batch queries)
- Documentation PHPDoc complète"
```

### Commit 5 : Vues
```bash
git add resources/views/rh/tri-candidats/ resources/views/rh/resultats/details.blade.php resources/views/rh/decisions/show.blade.php
git commit -m "feat(views): interface tri candidats et affichage notes

- Vue tri-candidats avec formulaire filtres
- Affichage 3 notes (CV, Test, Entretien) avec badges
- Colonnes Âge et Compétences dans tableau
- Tri par score global décroissant
- Bouton réinitialisation filtres
- Correction lien CV (asset storage)"
```

### Commit 6 : Routes et Navigation
```bash
git add routes/web.php resources/views/layouts/sidebar.blade.php
git commit -m "feat(routes): ajout routes tri-candidats et menu

- Routes GET /RH/tri-candidats (index et show)
- Middleware auth.custom et role:rh
- Ajout lien 'Tri des Candidats' dans sidebar RH
- Correction double prefix RH"
```

### Commit 7 : Documentation
```bash
git add FEATURE_TRI_CV.md COMMIT_GUIDE.md
git commit -m "docs: documentation complète fonctionnalité tri CV

- Guide d'installation et utilisation
- Structure fichiers créés/modifiés
- Liste des optimisations appliquées
- Problèmes résolus
- Guide de commit pour GitHub"
```

## 🔍 Convention de Nommage des Commits

### Format
```
<type>(<scope>): <description courte>

[corps optionnel]

[footer optionnel]
```

### Types
- **feat**: Nouvelle fonctionnalité
- **fix**: Correction de bug
- **docs**: Documentation
- **style**: Formatage, point-virgules manquants, etc.
- **refactor**: Refactoring du code
- **perf**: Amélioration des performances
- **test**: Ajout de tests
- **chore**: Maintenance, configuration

### Scopes
- **database**: Base de données
- **ai**: Intelligence artificielle
- **models**: Modèles Eloquent
- **controllers**: Contrôleurs
- **views**: Vues Blade
- **routes**: Routes
- **services**: Services

## 📋 Checklist Avant Push

- [ ] Tous les fichiers SQL sont testés
- [ ] Les migrations fonctionnent sans erreur
- [ ] Le code respecte PSR-12
- [ ] Pas de `dd()`, `var_dump()` ou `console.log()`
- [ ] Pas de clés API en dur
- [ ] Documentation à jour
- [ ] Commentaires en français
- [ ] Pas de fichiers sensibles (.env, logs)

## 🚀 Commandes Git

### Vérifier les fichiers modifiés
```bash
git status
```

### Voir les différences
```bash
git diff
```

### Ajouter tous les fichiers de la fonctionnalité
```bash
git add sql/data/4-ADD-NOTE-CV.sql sql/data/5-FIX-COMPETENCES.sql
git add app/Services/GeminiService.php app/Services/CvParserService.php
git add app/Models/Candidature.php
git add app/Http/Controllers/CandidatureController.php
git add app/Http/Controllers/EvaluationEntretienController.php
git add app/Http/Controllers/TriCandidatController.php
git add resources/views/rh/tri-candidats/
git add resources/views/rh/resultats/details.blade.php
git add resources/views/rh/decisions/show.blade.php
git add routes/web.php
git add resources/views/layouts/sidebar.blade.php
git add FEATURE_TRI_CV.md COMMIT_GUIDE.md
```

### Commit global (alternative)
```bash
git commit -m "feat: système complet de tri candidats avec analyse IA CV

Fonctionnalités:
- Analyse automatique CV par IA (Gemini)
- Score global sur 3 critères (CV + Test + Entretien)
- Filtres avancés (nom, âge, compétences, statut)
- Interface optimisée avec badges et tri
- Documentation complète

Optimisations:
- Eager loading pour éviter N+1
- Batch queries pour performances
- Nettoyage UTF-8 pour stabilité
- PHPDoc complet

Closes #XX"
```

### Push vers GitHub
```bash
git push origin main
# ou
git push origin develop
```

## 📝 Notes

- Utiliser des commits atomiques (une fonctionnalité = un commit)
- Écrire des messages clairs et descriptifs
- Référencer les issues si applicable (#XX)
- Tester avant de push
