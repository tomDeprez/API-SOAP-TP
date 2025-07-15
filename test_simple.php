<?php
// Test simple de l'API SOAP
echo "=== TEST SIMPLE DE L'API SOAP ===\n";

// Test 1: Vérifier si le WSDL est accessible
echo "1. Test d'accès au WSDL...\n";
$wsdl_url = "http://localhost:8000/APISOAP.wsdl";
$headers = get_headers($wsdl_url);
if ($headers && strpos($headers[0], '200') !== false) {
    echo "✓ WSDL accessible\n";
} else {
    echo "✗ WSDL non accessible\n";
    exit(1);
}

// Test 2: Créer un client SOAP
echo "2. Création du client SOAP...\n";
try {
    $client = new SoapClient($wsdl_url, array(
        'trace' => 1,
        'exceptions' => true
    ));
    echo "✓ Client SOAP créé\n";
} catch (Exception $e) {
    echo "✗ Erreur création client: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 3: Test simple - récupérer les statistiques
echo "3. Test de récupération des statistiques...\n";
try {
    $stats = $client->getStatistiques();
    echo "✓ Statistiques récupérées:\n";
    print_r($stats);
} catch (Exception $e) {
    echo "✗ Erreur statistiques: " . $e->getMessage() . "\n";
}

// Test 4: Test de récupération d'un utilisateur
echo "4. Test de récupération d'un utilisateur...\n";
try {
    $user = $client->getUser(1);
    echo "✓ Utilisateur récupéré:\n";
    print_r($user);
} catch (Exception $e) {
    echo "✗ Erreur utilisateur: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DU TEST ===\n";
?> 