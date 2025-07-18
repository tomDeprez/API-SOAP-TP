# API SOAP - Système de Livraison

Une API SOAP complète pour la gestion d'un système de livraison avec utilisateurs, commandes et produits.

## 🚀 Fonctionnalités

### Utilisateurs
- ✅ Récupérer un utilisateur par ID
- ✅ Récupérer tous les utilisateurs
- ✅ Créer un nouvel utilisateur
- ✅ Mettre à jour un utilisateur
- ✅ Supprimer un utilisateur

### Commandes
- ✅ Récupérer une commande par ID
- ✅ Récupérer toutes les commandes
- ✅ Récupérer les commandes d'un utilisateur
- ✅ Créer une nouvelle commande
- ✅ Mettre à jour le statut d'une commande
- ✅ Supprimer une commande

### Produits
- ✅ Récupérer un produit par ID
- ✅ Récupérer tous les produits
- ✅ Récupérer les produits par catégorie
- ✅ Créer un nouveau produit
- ✅ Mettre à jour un produit
- ✅ Supprimer un produit

### Statistiques et Recherche
- ✅ Obtenir des statistiques globales
- ✅ Rechercher des produits par terme

## 📋 Prérequis

- PHP 7.4 ou supérieur
- Extension PHP SOAP
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)

## 🛠️ Installation

### 1. Installation automatique

```bash
# Rendre le script d'installation exécutable
chmod +x install.sh

# Exécuter l'installation
./install.sh
```

Le script d'installation va :
- Vérifier les prérequis
- Créer la base de données
- Configurer les URLs
- Insérer les données de test

### 2. Installation manuelle

#### Étape 1 : Installation des dépendances

```bash
# Installation de l'extension PHP SOAP
sudo apt-get install php-soap

# Redémarrage du serveur web
sudo systemctl restart apache2
```

#### Étape 2 : Création de la base de données

```bash
# Connexion à MySQL
mysql -u root -p

# Exécution du script SQL
source database_setup.sql
```

#### Étape 3 : Configuration

Modifiez les paramètres de connexion dans `APISOAP.php` :

```php
$host = 'localhost:3306';
$db   = 'livraison';
$user = 'root';
$pass = 'votre_mot_de_passe';
```

#### Étape 4 : Configuration des URLs

Mettez à jour les URLs dans :
- `APISOAP.php`
- `APISOAP.wsdl`
- `client_test.php`

## 🗄️ Structure de la base de données

### Table `users`
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `nom` (VARCHAR(100), NOT NULL)
- `email` (VARCHAR(255), NOT NULL, UNIQUE)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

### Table `commandes`
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `user_id` (INT, FOREIGN KEY)
- `numero_commande` (VARCHAR(50), UNIQUE)
- `statut` (ENUM: 'en_preparation', 'expediee', 'livree', 'annulee')
- `montant` (DECIMAL(10,2))
- `adresse_livraison` (TEXT)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

### Table `produits`
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `nom` (VARCHAR(200))
- `description` (TEXT)
- `prix` (DECIMAL(10,2))
- `stock` (INT)
- `categorie` (VARCHAR(100))
- `created_at` (TIMESTAMP)

## 🔧 Utilisation

### Démarrage du serveur PHP

```bash
# Démarrer le serveur PHP intégré
./start_server.sh
```

Le serveur sera accessible sur :
- **Serveur :** http://localhost:8000
- **WSDL :** http://localhost:8000/APISOAP.wsdl
- **Service SOAP :** http://localhost:8000/APISOAP.php

### Test de l'API

```bash
# Dans un autre terminal, tester l'API
./test_api.sh

# Ou exécuter le client de test directement
php client_test.php
```

### Exemple d'utilisation avec PHP

```php
<?php
// Création du client SOAP
$client = new SoapClient("http://localhost:8000/APISOAP.wsdl");

// Récupérer tous les utilisateurs
$users = $client->getAllUsers();

// Créer un nouvel utilisateur
$result = $client->createUser("Jean Dupont", "jean@example.com");

// Récupérer une commande
$commande = $client->getCommande(1);

// Créer un produit
$result = $client->createProduit("Laptop", "Ordinateur portable", 999.99, 10, "Informatique");
?>
```

## 📡 Endpoints disponibles

### Utilisateurs
- `getUser($id)` - Récupérer un utilisateur
- `getAllUsers()` - Récupérer tous les utilisateurs
- `createUser($nom, $email)` - Créer un utilisateur
- `updateUser($id, $nom, $email)` - Mettre à jour un utilisateur
- `deleteUser($id)` - Supprimer un utilisateur

### Commandes
- `getCommande($id)` - Récupérer une commande
- `getAllCommandes()` - Récupérer toutes les commandes
- `getCommandesByUser($user_id)` - Récupérer les commandes d'un utilisateur
- `createCommande($user_id, $numero_commande, $montant, $adresse_livraison)` - Créer une commande
- `updateCommandeStatut($id, $statut)` - Mettre à jour le statut
- `deleteCommande($id)` - Supprimer une commande

### Produits
- `getProduit($id)` - Récupérer un produit
- `getAllProduits()` - Récupérer tous les produits
- `getProduitsByCategorie($categorie)` - Récupérer par catégorie
- `createProduit($nom, $description, $prix, $stock, $categorie)` - Créer un produit
- `updateProduit($id, $nom, $description, $prix, $stock, $categorie)` - Mettre à jour un produit
- `deleteProduit($id)` - Supprimer un produit

### Statistiques et Recherche
- `getStatistiques()` - Obtenir les statistiques
- `rechercherProduits($terme)` - Rechercher des produits

## 📊 Données de test

L'installation inclut automatiquement :

### Utilisateurs (8 utilisateurs)
- Jean Dupont, Marie Martin, Pierre Durand, etc.

### Produits (8 produits)
- Laptop Gaming, Smartphone Pro, Tablette 10", etc.

### Commandes (8 commandes)
- Différents statuts et montants pour tester

## 🔍 Dépannage

### Erreur de connexion SOAP
- Vérifiez que l'extension PHP SOAP est installée
- Vérifiez les URLs dans les fichiers de configuration

### Erreur de base de données
- Vérifiez les paramètres de connexion dans `APISOAP.php`
- Assurez-vous que la base de données existe

### Erreur WSDL
- Vérifiez que le fichier WSDL est accessible via HTTP
- Vérifiez les permissions des fichiers

## 📝 Fichiers du projet

- `APISOAP.php` - Serveur SOAP principal
- `APISOAP.wsdl` - Définition WSDL
- `database_setup.sql` - Script de création de la base de données
- `client_test.php` - Client de test
- `install.sh` - Script d'installation automatique
- `README.md` - Documentation

## 🤝 Contribution

Pour contribuer au projet :
1. Fork le repository
2. Créez une branche pour votre fonctionnalité
3. Committez vos changements
4. Poussez vers la branche
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT.
