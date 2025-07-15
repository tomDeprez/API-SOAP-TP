#!/bin/bash

echo "=== DÉMARRAGE DU SERVEUR PHP SOAP ===\n"

# Arrêter le serveur existant s'il y en a un
echo "1. Arrêt du serveur existant..."
pkill -f "php -S localhost:8000" 2>/dev/null
sleep 2

# Vérifier si le port 8000 est libre
echo "2. Vérification du port 8000..."
if lsof -Pi :8000 -sTCP:LISTEN -t >/dev/null ; then
    echo "✗ Le port 8000 est déjà utilisé"
    echo "Arrêt du processus utilisant le port 8000..."
    sudo lsof -ti:8000 | xargs kill -9
    sleep 2
fi

# Démarrer le serveur PHP
echo "3. Démarrage du serveur PHP..."
echo "Serveur accessible sur: http://localhost:8000"
echo "WSDL accessible sur: http://localhost:8000/APISOAP.wsdl"
echo "Service SOAP accessible sur: http://localhost:8000/APISOAP.php"
echo ""
echo "Pour arrêter le serveur: Ctrl+C"
echo ""

# Démarrer le serveur en mode interactif
php -S localhost:8000 