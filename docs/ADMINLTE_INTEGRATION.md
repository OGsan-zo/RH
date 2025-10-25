# 🎨 Intégration AdminLTE 3

Ce document explique l'intégration d'AdminLTE 3 dans le projet RH.

## ✅ Ce qui a été fait

### 1. Layout Principal
- **Fichier** : `resources/views/layouts/adminlte.blade.php`
- **Fonctionnalités** :
  - Navbar avec notifications
  - Sidebar collapsible
  - Footer
  - Intégration Chart.js
  - Font Awesome icons
  - Responsive design

### 2. Sidebar RH
- **Fichier** : `resources/views/layouts/partials/sidebar-rh.blade.php`
- **Menus** :
  - Dashboard
  - Annonces (liste, créer)
  - Candidatures (toutes, tri)
  - Tests QCM (liste, créer, résultats)
  - Entretiens (liste, planifier)
  - Décisions
  - Employés (liste, contrats, affiliations)
  - Départements
  - Profil & Déconnexion

### 3. Dashboard RH Moderne
- **Vue** : `resources/views/rh/dashboard-adminlte.blade.php`
- **Contrôleur** : `app/Http/Controllers/DashboardRhController.php`
- **Composants** :
  - 4 Info boxes (Candidatures, Tests, Entretiens, Décisions)
  - Graphique d'évolution des candidatures (Chart.js)
  - Graphique de répartition par statut (Doughnut)
  - Tableau des dernières candidatures
  - Tableau des prochains entretiens
  - Boutons d'actions rapides

## 🚀 Utilisation

### Pour utiliser AdminLTE dans une nouvelle page

```blade
@extends('layouts.adminlte')

@section('title', 'Titre de la page')
@section('page-title', 'Titre affiché')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
    <li class="breadcrumb-item active">Ma Page</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <!-- Votre contenu ici -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mon Titre</h3>
        </div>
        <div class="card-body">
            <!-- Contenu -->
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Vos scripts JS ici
</script>
@endpush
```

## 🎨 Composants AdminLTE Disponibles

### Info Boxes
```blade
<div class="info-box">
    <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
    <div class="info-box-content">
        <span class="info-box-text">Texte</span>
        <span class="info-box-number">42</span>
    </div>
</div>
```

### Cards
```blade
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Titre</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        Contenu
    </div>
</div>
```

### Badges
```blade
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-danger">Danger</span>
```

### Boutons
```blade
<button class="btn btn-primary">Primary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-info">Info</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-danger">Danger</button>
```

## 📊 Chart.js

### Graphique en ligne
```javascript
const ctx = document.getElementById('myChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fév', 'Mar'],
        datasets: [{
            label: 'Données',
            data: [12, 19, 15],
            borderColor: 'rgb(52, 152, 219)',
            backgroundColor: 'rgba(52, 152, 219, 0.1)'
        }]
    }
});
```

### Graphique en donut
```javascript
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Label 1', 'Label 2'],
        datasets: [{
            data: [30, 70],
            backgroundColor: ['rgb(52, 152, 219)', 'rgb(46, 204, 113)']
        }]
    }
});
```

## 🎨 Personnalisation des Couleurs

Les couleurs principales sont définies dans le layout :
- **Primary** : #3498db (Bleu)
- **Success** : #2ecc71 (Vert)
- **Info** : #17a2b8 (Cyan)
- **Warning** : #ffc107 (Jaune)
- **Danger** : #dc3545 (Rouge)

Pour modifier, éditer `resources/views/layouts/adminlte.blade.php` section `<style>`.

## 📱 Responsive

AdminLTE est entièrement responsive :
- **Desktop** : Sidebar visible
- **Tablet** : Sidebar collapsible
- **Mobile** : Sidebar en overlay

## 🔧 Prochaines Étapes

### Pages à migrer vers AdminLTE
1. ✅ Dashboard RH
2. ⏳ Tri des Candidats
3. ⏳ Liste des Annonces
4. ⏳ Profil Candidat
5. ⏳ Tests QCM
6. ⏳ Entretiens
7. ⏳ Décisions

### Améliorations Futures
- [ ] Dark mode
- [ ] Notifications en temps réel
- [ ] Recherche globale
- [ ] Raccourcis clavier
- [ ] Export PDF/Excel
- [ ] Drag & drop pour upload CV

## 📚 Ressources

- **AdminLTE 3 Docs** : https://adminlte.io/docs/3.2/
- **Chart.js Docs** : https://www.chartjs.org/docs/latest/
- **Font Awesome Icons** : https://fontawesome.com/icons

## 🐛 Dépannage

### Les styles ne se chargent pas
Vérifier que les CDN sont accessibles :
```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
```

### Les graphiques ne s'affichent pas
Vérifier que Chart.js est chargé :
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
```

### La sidebar ne se collapse pas
Vérifier que jQuery et Bootstrap sont chargés avant AdminLTE.

---

**Dernière mise à jour** : Octobre 2025
