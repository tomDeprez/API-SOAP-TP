#!/bin/bash

echo "=== TEST DE L'API SOAP ===\n"

# Attendre un peu que le serveur soit prêt
echo "Attente du démarrage du serveur..."
sleep 3

# Test 1: Vérifier l'accès au WSDL
echo "1. Test d'accès au WSDL..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/APISOAP.wsdl | grep -q "200"; then
    echo "✓ WSDL accessible"
else
    echo "✗ WSDL non accessible"
    echo "Assurez-vous que le serveur PHP est démarré avec: ./start_server.sh"
    exit 1
fi

# Test 2: Exécuter le test simple
echo "2. Exécution du test simple..."
php test_simple.php

# Test 3: Exécuter le test complet
echo "3. Exécution du test complet..."
php client_test.php

echo "\n=== FIN DES TESTS ===\n"
echo "Pour arrêter le serveur, utilisez Ctrl+C dans le terminal du serveur" 