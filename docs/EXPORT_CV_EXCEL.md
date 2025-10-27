# 📊 FONCTIONNALITÉ : EXPORT DES CV EN EXCEL

## ✅ Implémentation complète

### 🎯 Objectif
Permettre aux RH d'exporter toutes les données des candidats (avec ou sans CV) dans un fichier Excel pour analyse et archivage.

---

## 📁 Fichiers créés

### 1. **Classe d'export** : `app/Exports/CandidatsExport.php`
- Récupère tous les candidats avec leurs relations
- Vérifie l'existence des fichiers CV
- Formate les données pour Excel
- Applique des styles (en-tête bleu, colonnes ajustées)

**Colonnes exportées** :
1. ID
2. Nom
3. Prénom
4. Email
5. Date de naissance
6. Âge
7. Compétences
8. Statut candidat
9. CV Disponible (Oui/Non)
10. Chemin CV
11. Nombre de candidatures
12. Dernier poste postulé
13. Date dernière candidature
14. Note CV (dernière)
15. Statut candidature (dernière)

### 2. **Contrôleur** : `app/Http/Controllers/ExportCvController.php`
- **Méthode `index()`** : Affiche la page d'export avec statistiques
- **Méthode `export()`** : Génère et télécharge le fichier Excel
- **Méthode `countCvDisponibles()`** : Compte les CV réellement présents

### 3. **Vue** : `resources/views/rh/export-cv.blade.php`
- Page complète avec AdminLTE
- 4 info-boxes : Total candidats, CV disponibles, CV manquants, Candidatures
- Section d'explication du contenu
- Bouton de téléchargement
- Tableau de prévisualisation (10 derniers candidats)

### 4. **Routes** : `routes/web.php`
```php
Route::get('/export-cv', [ExportCvController::class, 'index'])->name('export.cv');
Route::get('/export-cv/download', [ExportCvController::class, 'export'])->name('export.cv.download');
```

### 5. **Sidebar** : `resources/views/layouts/partials/sidebar-rh.blade.php`
- Nouvelle section "EXPORTS & RAPPORTS"
- Lien "Exporter les CV" avec icône Excel verte

---

## 🚀 Utilisation

### Accès à la fonctionnalité
1. Se connecter en tant que RH
2. Cliquer sur "Exporter les CV" dans le sidebar
3. Consulter les statistiques
4. Cliquer sur "Télécharger l'Excel"

### Fichier généré
- **Nom** : `export_cv_candidats_YYYY-MM-DD_HHMMSS.xlsx`
- **Format** : Excel (.xlsx)
- **Contenu** : Tous les candidats avec leurs données

---

## 🔍 Logique de traitement

### Vérification des CV
```php
$cvPath = $candidat->cv_path;
$cvDisponible = 'Non';

if ($cvPath) {
    $cvFullPath = storage_path('app/public/' . $cvPath);
    $cvDisponible = file_exists($cvFullPath) ? 'Oui' : 'Non';
}
```

### Gestion des CV manquants
- Si le CV n'existe pas → Marqué "Non" dans la colonne "CV Disponible"
- Toutes les autres données sont quand même exportées
- Aucune erreur n'est levée
- Le processus continue normalement

### Calcul de l'âge
```php
$age = Carbon::parse($candidat->date_naissance)->age . ' ans';
```

### Dernière candidature
```php
$derniereCandidature = $candidat->candidatures()
    ->with('annonce')
    ->orderBy('date_candidature', 'desc')
    ->first();
```

---

## 📊 Exemple de données exportées

| ID | Nom | Prénom | Email | Date naissance | Âge | Compétences | Statut | CV Dispo | Chemin CV | Nb Cand | Dernier poste | Date | Note CV | Statut Cand |
|----|-----|--------|-------|----------------|-----|-------------|--------|----------|-----------|---------|---------------|------|---------|-------------|
| 1 | RASOLOFO | Jean | jean@... | 15/03/1990 | 34 ans | PHP, Laravel... | employe | Oui | cv/jean.pdf | 2 | Dev Full Stack | 01/09/2024 | 95.50% | Employe |
| 2 | ANDRIA | Sophie | sophie@... | 22/07/1992 | 32 ans | PHP, Vue.js... | retenu | Non | cv/sophie.pdf | 1 | Dev Full Stack | 22/09/2024 | 88.75% | Retenu |

---

## 🎨 Styles Excel

### En-tête
- **Fond** : Bleu (#4472C4)
- **Texte** : Blanc, gras, taille 12
- **Alignement** : Centré

### Colonnes
- Largeurs ajustées automatiquement
- Texte aligné à gauche
- Nombres alignés à droite

---

## 📦 Package utilisé

### maatwebsite/excel v3.1
```bash
composer require maatwebsite/excel
```

**Fonctionnalités** :
- Export vers Excel, CSV
- Import depuis Excel, CSV
- Styles personnalisés
- Formules Excel
- Graphiques (optionnel)

---

## 🔒 Sécurité

### Middleware
- `auth.custom` : Authentification requise
- `role:rh` : Accès réservé aux RH

### Vérification des fichiers
- Utilisation de `storage_path()` pour les chemins absolus
- Vérification avec `file_exists()`
- Pas d'exposition des chemins sensibles

---

## 🧪 Tests

### Test manuel
1. Se connecter en RH
2. Aller sur la page d'export
3. Vérifier les statistiques
4. Télécharger le fichier
5. Ouvrir avec Excel/LibreOffice
6. Vérifier les données

### Cas de test
- ✅ Candidat avec CV disponible
- ✅ Candidat sans CV (chemin null)
- ✅ Candidat avec CV manquant (fichier supprimé)
- ✅ Candidat sans candidature
- ✅ Candidat avec plusieurs candidatures
- ✅ Export avec 0 candidat
- ✅ Export avec beaucoup de candidats

---

## 🐛 Gestion des erreurs

### CV manquant
- **Comportement** : Continue l'export
- **Marquage** : "Non" dans la colonne "CV Disponible"
- **Données** : Toutes les autres données sont exportées

### Aucun candidat
- **Comportement** : Fichier Excel vide avec en-têtes
- **Message** : Affiché sur la page

### Erreur d'écriture
- **Comportement** : Exception Laravel
- **Solution** : Vérifier les permissions du dossier `storage/`

---

## 🔧 Personnalisation

### Ajouter une colonne
1. Modifier `headings()` dans `CandidatsExport.php`
2. Modifier `map()` pour ajouter la donnée
3. Ajuster `columnWidths()` si nécessaire

### Filtrer les candidats
```php
public function collection()
{
    return Candidat::with(['candidatures.annonce', 'user'])
        ->where('statut', 'employe') // Exemple de filtre
        ->orderBy('id', 'asc')
        ->get();
}
```

### Changer le format
```php
// CSV au lieu de XLSX
return Excel::download(new CandidatsExport, $filename, \Maatwebsite\Excel\Excel::CSV);
```

---

## 📈 Améliorations futures possibles

1. **Filtres avancés**
   - Par statut
   - Par date de candidature
   - Par département

2. **Export multiple**
   - Export par département
   - Export par période
   - Export personnalisé

3. **Graphiques**
   - Intégrer des graphiques dans Excel
   - Statistiques visuelles

4. **Planification**
   - Export automatique quotidien/hebdomadaire
   - Envoi par email

5. **Historique**
   - Sauvegarder les exports
   - Consulter les exports précédents

---

## ✅ Checklist de vérification

- [x] Package `maatwebsite/excel` installé
- [x] Classe `CandidatsExport` créée
- [x] Contrôleur `ExportCvController` créé
- [x] Vue `export-cv.blade.php` créée
- [x] Routes ajoutées
- [x] Lien dans le sidebar
- [x] Middleware de sécurité
- [x] Gestion des CV manquants
- [x] Styles Excel appliqués
- [x] Documentation complète

---

**La fonctionnalité est prête à être utilisée ! 🎉**
