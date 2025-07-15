#!/bin/bash

echo "=== INSTALLATION DE L'API SOAP ===\n"

# Vérification de MySQL
echo "1. Vérification de MySQL..."
if ! command -v mysql &> /dev/null; then
    echo "MySQL n'est pas installé. Veuillez l'installer d'abord."
    exit 1
fi
echo "✓ MySQL est installé\n"

# Création de la base de données
echo "2. Création de la base de données..."
read -p "Nom d'utilisateur MySQL (défaut: root): " mysql_user
mysql_user=${mysql_user:-root}

read -s -p "Mot de passe MySQL: " mysql_pass
echo ""

# Exécution du script SQL
echo "Création des tables et insertion des données de test..."
mysql -u "$mysql_user" -p"$mysql_pass" < database_setup.sql

if [ $? -eq 0 ]; then
    echo "✓ Base de données créée avec succès\n"
else
    echo "✗ Erreur lors de la création de la base de données"
    exit 1
fi

# Vérification de PHP SOAP
echo "3. Vérification de l'extension PHP SOAP..."
if ! php -m | grep -q soap; then
    echo "L'extension PHP SOAP n'est pas installée."
    echo "Installez-la avec: sudo apt-get install php-soap"
    echo "Puis redémarrez votre serveur web."
    exit 1
fi
echo "✓ Extension PHP SOAP est installée\n"

# Configuration de l'URL dans les fichiers
echo "4. Configuration de l'URL..."
read -p "URL de votre serveur (défaut: http://localhost/API-SOAP): " server_url
server_url=${server_url:-http://localhost/API-SOAP}

# Mise à jour de l'URL dans APISOAP.php
sed -i "s|http://localhost/API-SOAP/APISOAP.wsdl|$server_url/APISOAP.wsdl|g" APISOAP.php

# Mise à jour de l'URL dans APISOAP.wsdl
sed -i "s|http://localhost/API-SOAP/APISOAP.php|$server_url/APISOAP.php|g" APISOAP.wsdl

# Mise à jour de l'URL dans client_test.php
sed -i "s|http://localhost/API-SOAP/APISOAP.wsdl|$server_url/APISOAP.wsdl|g" client_test.php

echo "✓ URLs configurées\n"

# Mise à jour des paramètres de connexion à la base de données
echo "5. Configuration de la base de données..."
read -p "Hôte MySQL (défaut: localhost:3306): " db_host
db_host=${db_host:-localhost:3306}

read -p "Nom de la base de données (défaut: livraison): " db_name
db_name=${db_name:-livraison}

read -p "Nom d'utilisateur de la base de données (défaut: root): " db_user
db_user=${db_user:-root}

read -s -p "Mot de passe de la base de données: " db_pass
echo ""

# Mise à jour des paramètres dans APISOAP.php
sed -i "s|localhost:3306|$db_host|g" APISOAP.php
sed -i "s|livraison|$db_name|g" APISOAP.php
sed -i "s|root|$db_user|g" APISOAP.php
sed -i "s|password|$db_pass|g" APISOAP.php

echo "✓ Configuration de la base de données terminée\n"

echo "=== INSTALLATION TERMINÉE ===\n"
echo "Votre API SOAP est maintenant prête à être utilisée !\n"
echo "Pour tester l'API, exécutez: php client_test.php\n"
echo "URL du service SOAP: $server_url/APISOAP.php\n"
echo "URL du WSDL: $server_url/APISOAP.wsdl\n" 