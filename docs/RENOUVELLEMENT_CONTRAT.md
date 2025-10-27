# 🔒 RÈGLE MÉTIER : RENOUVELLEMENT DE CONTRAT (1 SEULE FOIS)

## ✅ Implémentation complète

### 🎯 Règle métier appliquée

**Un contrat ne peut être modifié qu'UNE SEULE FOIS, peu importe le type de contrat.**

---

## 📊 EXEMPLES DE SCÉNARIOS

### ✅ Scénario 1 : Modification autorisée
```
1. Contrat initial : CDD (renouvellement = 0)
2. Modification vers CDI → ✅ AUTORISÉ (renouvellement = 1)
3. Tentative de modification vers CDD → ❌ BLOQUÉ
```

### ✅ Scénario 2 : Prolongation autorisée
```
1. Contrat initial : CDD 1 an (renouvellement = 0)
2. Prolongation CDD 1 an → ✅ AUTORISÉ (renouvellement = 1)
3. Tentative de prolongation → ❌ BLOQUÉ
```

### ✅ Scénario 3 : Changement multiple bloqué
```
1. Contrat initial : Essai (renouvellement = 0)
2. Changement vers CDD → ✅ AUTORISÉ (renouvellement = 1)
3. Changement vers CDI → ❌ BLOQUÉ
4. Retour vers Essai → ❌ BLOQUÉ
```

### ❌ Scénario 4 : Tentative de contournement
```
1. Contrat initial : CDD (renouvellement = 0)
2. Modification vers CDI → ✅ AUTORISÉ (renouvellement = 1)
3. Modification vers CDD → ❌ BLOQUÉ (message d'erreur)
4. Modification vers Essai → ❌ BLOQUÉ (message d'erreur)
```

---

## 🔧 MODIFICATIONS EFFECTUÉES

### 1. **Modèle `Contrat.php`**

#### Méthodes ajoutées :
```php
/**
 * Vérifier si le contrat peut être renouvelé/modifié
 */
public function peutEtreRenouvele()
{
    return $this->renouvellement < 1;
}

/**
 * Vérifier si le contrat a déjà été renouvelé
 */
public function estDejaRenouvele()
{
    return $this->renouvellement >= 1;
}
```

**Utilisation** :
```php
if ($contrat->peutEtreRenouvele()) {
    // Autoriser la modification
} else {
    // Bloquer la modification
}
```

---

### 2. **Contrôleur `ContratController.php`**

#### Validation stricte (ligne 100-103) :
```php
// ⚠️ RÈGLE MÉTIER GLOBALE : Un contrat ne peut être modifié qu'UNE SEULE FOIS
if (!$contrat->peutEtreRenouvele()) {
    return back()->with('error', 'Ce contrat a déjà été modifié une fois. Aucune modification supplémentaire n\'est autorisée.');
}
```

#### Logique de renouvellement (ligne 122) :
```php
// AVANT (ancienne logique avec reset)
$renouvellement = ($contrat->type_contrat === $request->type_contrat)
    ? min($contrat->renouvellement + 1, 1)
    : 0;  // ← Reset à 0 si changement de type

// APRÈS (nouvelle logique globale)
$renouvellement = min($contrat->renouvellement + 1, 1);  // ← Toujours incrémenter
```

**Différence clé** :
- **Avant** : Le compteur se réinitialisait à 0 si on changeait de type
- **Après** : Le compteur s'incrémente toujours, peu importe le type

---

### 3. **Vue `index.blade.php`**

#### Nouvelle colonne "Renouvellements" :
```blade
<th class="text-center">Renouvellements</th>
```

#### Badge indicateur :
```blade
<span class="badge badge-{{ $c->renouvellement >= 1 ? 'danger' : 'success' }}">
    {{ $c->renouvellement }}/1
</span>
```

**Affichage** :
- `0/1` → Badge vert (peut être modifié)
- `1/1` → Badge rouge (ne peut plus être modifié)

#### Bouton conditionnel :
```blade
@if($c->peutEtreRenouvele())
    <a href="{{ route('contrats.edit',$c->id) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-sync-alt"></i> Modifier
    </a>
@else
    <button class="btn btn-secondary btn-sm" disabled title="Déjà modifié une fois">
        <i class="fas fa-ban"></i> Bloqué
    </button>
@endif
```

**Comportement** :
- Si `renouvellement < 1` → Bouton "Modifier" actif
- Si `renouvellement >= 1` → Bouton "Bloqué" désactivé

---

## 🔒 SÉCURITÉ

### Niveaux de protection :

1. **Base de données** ✅
   ```sql
   CHECK (renouvellement <= 1)
   ```
   → Empêche l'insertion de valeurs > 1

2. **Modèle** ✅
   ```php
   public function peutEtreRenouvele()
   ```
   → Logique métier centralisée

3. **Contrôleur** ✅
   ```php
   if (!$contrat->peutEtreRenouvele())
   ```
   → Validation avant toute modification

4. **Vue** ✅
   ```blade
   @if($c->peutEtreRenouvele())
   ```
   → Masquage du bouton si déjà renouvelé

---

## 📊 TABLEAU RÉCAPITULATIF

| Renouvellement | Badge | Bouton | Action possible |
|----------------|-------|--------|-----------------|
| 0 | 🟢 `0/1` | ✅ Modifier | Oui |
| 1 | 🔴 `1/1` | ❌ Bloqué | Non |

---

## 🧪 TESTS À EFFECTUER

### Test 1 : Modification initiale
1. Créer un contrat CDD
2. Vérifier : Badge `0/1` vert
3. Modifier vers CDI
4. Vérifier : Badge `1/1` rouge
5. Vérifier : Bouton "Bloqué" désactivé

### Test 2 : Tentative de 2ème modification
1. Contrat avec `renouvellement = 1`
2. Cliquer sur "Modifier" (ne devrait pas être visible)
3. Tenter d'accéder directement à l'URL `/contrats/{id}/edit`
4. Vérifier : Message d'erreur affiché
5. Vérifier : Redirection vers la liste

### Test 3 : Prolongation
1. Créer un contrat CDD 1 an
2. Prolonger le CDD de 1 an
3. Vérifier : `renouvellement = 1`
4. Tenter une nouvelle prolongation
5. Vérifier : Bloqué

### Test 4 : Changement de type multiple
1. Créer un contrat Essai
2. Changer vers CDD → OK
3. Tenter de changer vers CDI → Bloqué
4. Tenter de changer vers Essai → Bloqué

---

## 🎨 INTERFACE UTILISATEUR

### Avant modification
```
┌─────────────────────────────────────────────────┐
│ Candidat  │ Type │ Renouvellements │ Actions   │
├─────────────────────────────────────────────────┤
│ Jean      │ CDD  │ 0/1 🟢          │ [Modifier]│
└─────────────────────────────────────────────────┘
```

### Après 1 modification
```
┌─────────────────────────────────────────────────┐
│ Candidat  │ Type │ Renouvellements │ Actions   │
├─────────────────────────────────────────────────┤
│ Jean      │ CDI  │ 1/1 🔴          │ [Bloqué]  │
└─────────────────────────────────────────────────┘
```

---

## 💡 MESSAGES D'ERREUR

### Message affiché si tentative de modification
```
Ce contrat a déjà été modifié une fois. 
Aucune modification supplémentaire n'est autorisée.
```

### Tooltip sur le bouton bloqué
```
Déjà modifié une fois
```

---

## 📝 NOTES IMPORTANTES

1. **Compteur persistant** : Le compteur `renouvellement` ne se réinitialise JAMAIS, même en changeant de type

2. **Validation stricte** : La vérification se fait AVANT toute autre validation

3. **Interface claire** : Badge coloré + bouton désactivé = feedback visuel immédiat

4. **Sécurité multicouche** : Protection au niveau BDD, modèle, contrôleur ET vue

5. **Règle métier** : 1 seule modification autorisée, peu importe :
   - Le type de contrat (Essai, CDD, CDI)
   - Le type de modification (prolongation, changement de type)
   - La durée entre les modifications

---

## 🔄 ÉVOLUTIONS FUTURES POSSIBLES

### Option 1 : Renouvellement par type
Si besoin de revenir à l'ancienne logique :
```php
$renouvellement = ($contrat->type_contrat === $request->type_contrat)
    ? min($contrat->renouvellement + 1, 1)
    : 0;
```

### Option 2 : Limite configurable
Permettre de configurer le nombre max de renouvellements :
```php
const MAX_RENOUVELLEMENTS = 1;

public function peutEtreRenouvele()
{
    return $this->renouvellement < self::MAX_RENOUVELLEMENTS;
}
```

### Option 3 : Historique des modifications
Créer une table `historique_contrats` pour tracer toutes les modifications

---

## ✅ CHECKLIST DE VÉRIFICATION

- [x] Méthodes ajoutées au modèle `Contrat`
- [x] Validation stricte dans le contrôleur
- [x] Logique de renouvellement modifiée (pas de reset)
- [x] Colonne "Renouvellements" ajoutée dans la vue
- [x] Badge indicateur affiché
- [x] Bouton conditionnel (actif/bloqué)
- [x] Message d'erreur clair
- [x] Contrainte CHECK en base de données
- [x] Documentation complète

---

**La règle métier est maintenant strictement appliquée ! 🔒**
