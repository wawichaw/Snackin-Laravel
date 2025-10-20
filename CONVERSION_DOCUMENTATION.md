# 📋 DOCUMENTATION - CONVERSION PHP VERS LARAVEL

## 🎯 Vue d'ensemble du projet

Ce projet est une conversion d'une application PHP classique vers le framework Laravel pour l'application **Snackin** (vente de biscuits).

## 📁 Structure des fichiers modifiés

### 🛣️ Routes (`routes/web.php`)
- **Routes de commandes** : `/commandes` (GET/POST)
- **Routes de biscuits** : `/biscuits` et `/biscuit` (GET)
- **Routes d'administration** : `/admin-biscuits` avec actions
- **Routes de test** : `/biscuits-test`, `/biscuits-simple`

### 🎮 Contrôleurs
- **`CommandeController.php`** : Gestion des commandes de boîtes
- **`BiscuitController.php`** : Gestion du menu et administration

### 🗄️ Modèles
- **`Biscuit.php`** : Modèle principal avec SoftDeletes et relation saveur
- **`Saveur.php`** : Modèle pour les saveurs des biscuits
- **`User.php`** : Modifié pour ajouter le champ `is_admin`

### 📄 Vues (`resources/views/`)
- **`commande.blade.php`** : Formulaire de commande avec validation JS
- **`biscuit.blade.php`** : Menu des biscuits avec actions admin

## 🔄 Principales conversions effectuées

### Syntaxe PHP → Blade
```php
// AVANT (PHP)
<?php echo htmlspecialchars($variable) ?>
<?php if (!empty($var)): ?>
<?php foreach ($array as $item): ?>

// APRÈS (Blade)
{{ $variable }}
@if (!empty($var))
@foreach ($array as $item)
```

### Accès aux propriétés
```php
// AVANT
$biscuit->getNomBiscuit()
$biscuit->getPrix()
$biscuit->getId()

// APRÈS
$biscuit->nom_biscuit
$biscuit->prix
$biscuit->id
```

### Gestion des utilisateurs
```php
// AVANT
current_user_id()
is_admin()

// APRÈS
auth()->check()
auth()->user()->is_admin
```

### Relations de base de données
```php
// AVANT
Saveur::getNomById($biscuit->getIdSaveur())

// APRÈS
$biscuit->saveur->nom_saveur
```

## 🗃️ Base de données

### Tables créées
- **`biscuits`** : ID, nom_biscuit, prix, description, image, saveur_id, timestamps, deleted_at
- **`saveurs`** : ID, nom_saveur, description, timestamps
- **`users`** : Modifié pour ajouter `is_admin` (boolean)

### Seeders
- **`BiscuitSeeder`** : 6 biscuits de test avec saveurs
- **`SaveurSeeder`** : 6 saveurs (Chocolat, Vanille, Fruit, etc.)
- **`AdminUserSeeder`** : Utilisateurs admin et test

## 🔐 Système d'authentification

### Utilisateurs de test créés
- **Admin** : `admin@snackin.com` / `password` (is_admin = true)
- **Utilisateur** : `user@snackin.com` / `password` (is_admin = false)

### Permissions
- **Non connecté** : Peut voir les biscuits et ajouter des commentaires
- **Connecté** : Même accès mais pas de bouton "ajouter commentaire"
- **Admin** : Accès complet + actions admin + corbeille

## 🎨 Fonctionnalités implémentées

### Page de commande (`/commandes`)
- ✅ Sélection taille de boîte (4, 6, 12 biscuits)
- ✅ Choix des saveurs et quantités
- ✅ Validation JavaScript temps réel
- ✅ Validation côté serveur Laravel
- ✅ Protection CSRF
- ✅ Messages d'erreur et succès

### Page des biscuits (`/biscuits`)
- ✅ Affichage liste complète avec prix et saveurs
- ✅ Boutons commentaires
- ✅ Actions admin (modifier, supprimer)
- ✅ Section corbeille pour restaurer
- ✅ Design responsive

## 🚀 URLs de test

- **Accueil** : `http://127.0.0.1:8000/`
- **Commandes** : `http://127.0.0.1:8000/commandes`
- **Menu biscuits** : `http://127.0.0.1:8000/biscuits` ou `/biscuit`
- **Test routes** : `http://127.0.0.1:8000/biscuits-test`

## 📝 Prochaines étapes possibles

1. **Système d'authentification complet** (login/register)
2. **Gestion des commentaires** (modèles, contrôleurs, vues)
3. **Interface d'administration** pour CRUD biscuits
4. **Système de panier** avancé
5. **Emails de confirmation** de commande
6. **Gestion des images** pour les biscuits

## 🛠️ Commandes utiles

```bash
# Démarrer le serveur
php artisan serve

# Voir les routes
php artisan route:list

# Exécuter les migrations
php artisan migrate

# Exécuter les seeders
php artisan db:seed --class=BiscuitSeeder
php artisan db:seed --class=SaveurSeeder
php artisan db:seed --class=AdminUserSeeder

# Vider le cache
php artisan route:clear
php artisan config:clear
```

---
*Documentation créée lors de la conversion PHP → Laravel pour l'équipe Snackin* 🍪
