# Diagramme de la Base de Données - Snackin Laravel

## Description des Tables

### 1. USERS (Utilisateurs)
Stocke les utilisateurs du site (clients et administrateurs).
- **id** : Identifiant unique
- **name** : Nom de l'utilisateur
- **email** : Email (unique)
- **password** : Mot de passe haché
- **is_admin** : Booléen (admin ou non)
- **role** : Rôle (USER ou ADMIN)

### 2. SAVEURS (Saveurs)
Liste des saveurs disponibles pour les biscuits.
- **id** : Identifiant unique
- **nom_saveur** : Nom (ex: Chocolat, Vanille, Caramel)
- **description** : Description de la saveur
- **emoji** : Emoji associé

### 3. BISCUITS (Produits)
Catalogue des biscuits vendus.
- **id** : Identifiant unique
- **nom_biscuit** : Nom du biscuit
- **prix** : Prix en euros
- **description** : Description
- **image** : Chemin vers l'image
- **saveur_id** : Relation vers SAVEURS (FK)

### 4. COMMANDES (Commandes)
Commandes passées par les clients.
- **id** : Identifiant unique
- **utilisateur_id** : Relation vers USERS (FK)
- **client_nom** : Nom du client
- **client_email** : Email du client
- **status** : Statut (en_attente, en_preparation, prete, livree, annulee)
- **total_prix** : Prix total
- **details_json** : Détails au format JSON

### 5. COMMENTAIRES
Commentaires laissés par les clients.
- **id** : Identifiant unique
- **utilisateur_id** : Relation vers USERS (FK)
- **message** : Texte du commentaire
- **note** : Note sur 5
- **approuve** : Approuvé par admin (booléen)

### 6. LIGNE_COMMANDES
Détails des articles dans chaque commande.
- **id** : Identifiant unique
- **commande_id** : Relation vers COMMANDES (FK)
- **biscuit_id** : Relation vers BISCUITS (FK)
- **quantite** : Quantité commandée
- **prix_unitaire** : Prix unitaire à la commande

## Relations

```
USERS (1) ───< (N) COMMANDES
USERS (1) ───< (N) COMMENTAIRES
SAVEURS (1) ───< (N) BISCUITS
COMMANDES (1) ───< (N) LIGNE_COMMANDES
BISCUITS (1) ───< (N) LIGNE_COMMANDES
```

## Contraintes Clés

- Un biscuit appartient à **une seule** saveur
- Une commande appartient à **un seul** utilisateur
- Une commande contient **plusieurs** lignes de commande
- Chaque ligne de commande référence **un biscuit**
