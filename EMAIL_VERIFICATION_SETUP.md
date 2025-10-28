# Configuration de la Vérification Email avec Mailtrap

## 🚀 Étapes de Configuration

### 1. Configuration Mailtrap

1. **Créez un compte sur [Mailtrap.io](https://mailtrap.io)**
2. **Créez une nouvelle inbox** dans votre tableau de bord Mailtrap
3. **Récupérez vos identifiants SMTP** depuis la section "SMTP Settings"

### 2. Configuration du fichier .env

Ajoutez ces variables dans votre fichier `.env` :

```env
# Configuration Email - Mailtrap
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@snackin.com"
MAIL_FROM_NAME="Snackin'"

# Configuration App (important pour les liens de vérification)
APP_URL=http://localhost:8000
```

**⚠️ Important :** Remplacez `your_mailtrap_username` et `your_mailtrap_password` par vos vrais identifiants Mailtrap.

### 3. Vidage du cache de configuration

Après modification du fichier `.env`, exécutez :

```bash
php artisan config:cache
php artisan route:cache
```

## 🎯 Fonctionnalités Implémentées

### ✅ Vérification Email Obligatoire
- Les nouveaux utilisateurs doivent vérifier leur email
- Accès restreint aux fonctionnalités protégées jusqu'à vérification

### ✅ Routes Protégées
Les routes suivantes nécessitent une vérification email :
- 🍪 **Passer des commandes** (`/commandes`)
- 📦 **Voir mes commandes** (`/mes-commandes`)
- ⚙️ **Administration** (toutes les routes admin)
- 🏠 **Dashboard** (`/home`)

### ✅ Email Personnalisé
- Message de bienvenue en français avec emojis 🍪
- Instructions claires pour l'utilisateur
- Lien d'expiration (60 minutes)
- Design cohérent avec l'identité Snackin'

### ✅ Interface de Vérification
- Page élégante `/email/verify`
- Possibilité de renvoyer l'email
- Instructions d'aide pour l'utilisateur

## 🧪 Comment Tester

### 1. Inscription d'un Nouvel Utilisateur
1. Allez sur `/register`
2. Créez un nouveau compte
3. ➡️ Vous serez redirigé vers `/email/verify`

### 2. Vérification dans Mailtrap
1. Connectez-vous à votre inbox Mailtrap
2. Vous devriez voir l'email de vérification
3. Cliquez sur le lien de vérification
4. ➡️ Votre compte sera vérifié (`email_verified_at` sera rempli)

### 3. Test des Restrictions
1. Essayez d'accéder à `/commandes` sans vérification
2. ➡️ Vous serez redirigé vers `/email/verify`
3. Après vérification, l'accès sera autorisé

## 📋 Colonne email_verified_at

La colonne `email_verified_at` dans la table `users` :
- **`NULL`** = Email non vérifié
- **`datetime`** = Date de vérification de l'email

Cette colonne est automatiquement mise à jour lors de la vérification.

## 🔧 Dépannage

### Email non reçu dans Mailtrap
1. Vérifiez les identifiants SMTP dans `.env`
2. Vérifiez que `MAIL_MAILER=smtp`
3. Videz le cache : `php artisan config:cache`

### Lien de vérification ne fonctionne pas
1. Vérifiez que `APP_URL` est correct dans `.env`
2. Assurez-vous que les routes sont en cache : `php artisan route:cache`

### Page de vérification ne s'affiche pas
1. Vérifiez que `Auth::routes(['verify' => true])` est dans `routes/web.php`
2. La vue `resources/views/auth/verify.blade.php` doit exister

## 🎉 Résultat Final

Une fois configuré :
- ✅ Nouveaux utilisateurs reçoivent un email de vérification élégant
- ✅ Accès restreint jusqu'à vérification
- ✅ Interface utilisateur intuitive
- ✅ Emails testables dans Mailtrap
- ✅ Conformité avec les bonnes pratiques Laravel
