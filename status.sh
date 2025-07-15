#!/bin/bash

echo "=== STATUT DU SERVEUR PHP SOAP ===\n"

# Vérifier si le serveur PHP est en cours d'exécution
echo "1. Statut du serveur PHP..."
if pgrep -f "php -S localhost:8000" > /dev/null; then
    echo "✓ Serveur PHP en cours d'exécution"
    echo "   PID: $(pgrep -f 'php -S localhost:8000')"
else
    echo "✗ Serveur PHP non démarré"
    echo "   Pour démarrer: ./start_server.sh"
fi

# Vérifier l'accès au WSDL
echo "2. Test d'accès au WSDL..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/APISOAP.wsdl | grep -q "200"; then
    echo "✓ WSDL accessible sur http://localhost:8000/APISOAP.wsdl"
else
    echo "✗ WSDL non accessible"
fi

# Vérifier l'accès au service SOAP
echo "3. Test d'accès au service SOAP..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/APISOAP.php | grep -q "200"; then
    echo "✓ Service SOAP accessible sur http://localhost:8000/APISOAP.php"
else
    echo "✗ Service SOAP non accessible"
fi

# Afficher les URLs importantes
echo "4. URLs importantes:"
echo "   - Serveur: http://localhost:8000"
echo "   - WSDL: http://localhost:8000/APISOAP.wsdl"
echo "   - Service: http://localhost:8000/APISOAP.php"
echo "   - Test: ./test_api.sh"

echo "\n=== FIN DU STATUT ===\n" 