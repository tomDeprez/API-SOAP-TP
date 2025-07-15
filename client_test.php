<?php
// Client de test pour l'API SOAP
ini_set("soap.wsdl_cache_enabled", "0");

try {
    $client = new SoapClient("http://localhost:8000/APISOAP.wsdl", array(
        'trace' => 1,
        'exceptions' => true
    ));

    echo "=== TEST DE L'API SOAP ===\n\n";

    // === TEST DES UTILISATEURS ===
    echo "1. RÉCUPÉRATION DE TOUS LES UTILISATEURS\n";
    echo "----------------------------------------\n";
    try {
        $result = $client->getAllUsers();
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "2. RÉCUPÉRATION D'UN UTILISATEUR (ID: 1)\n";
    echo "----------------------------------------\n";
    try {
        $result = $client->getUser(1);
        echo "Utilisateur trouvé:\n";
        print_r($result);
        echo "\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "3. CRÉATION D'UN NOUVEAU UTILISATEUR\n";
    echo "-----------------------------------\n";
    try {
        $result = $client->createUser("Test User", "test.user@email.com");
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    // === TEST DES COMMANDES ===
    echo "4. RÉCUPÉRATION DE TOUTES LES COMMANDES\n";
    echo "---------------------------------------\n";
    try {
        $result = $client->getAllCommandes();
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "5. RÉCUPÉRATION D'UNE COMMANDE (ID: 1)\n";
    echo "--------------------------------------\n";
    try {
        $result = $client->getCommande(1);
        echo "Commande trouvée:\n";
        print_r($result);
        echo "\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "6. RÉCUPÉRATION DES COMMANDES D'UN UTILISATEUR (ID: 1)\n";
    echo "----------------------------------------------------\n";
    try {
        $result = $client->getCommandesByUser(1);
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "7. CRÉATION D'UNE NOUVELLE COMMANDE\n";
    echo "----------------------------------\n";
    try {
        $result = $client->createCommande(1, "CMD-2024-TEST", 299.99, "123 Test Street, 75001 Paris");
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "8. MISE À JOUR DU STATUT D'UNE COMMANDE\n";
    echo "--------------------------------------\n";
    try {
        $result = $client->updateCommandeStatut(1, "expediee");
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    // === TEST DES PRODUITS ===
    echo "9. RÉCUPÉRATION DE TOUS LES PRODUITS\n";
    echo "------------------------------------\n";
    try {
        $result = $client->getAllProduits();
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "10. RÉCUPÉRATION D'UN PRODUIT (ID: 1)\n";
    echo "-------------------------------------\n";
    try {
        $result = $client->getProduit(1);
        echo "Produit trouvé:\n";
        print_r($result);
        echo "\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "11. RÉCUPÉRATION DES PRODUITS PAR CATÉGORIE\n";
    echo "-------------------------------------------\n";
    try {
        $result = $client->getProduitsByCategorie("Informatique");
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "12. CRÉATION D'UN NOUVEAU PRODUIT\n";
    echo "--------------------------------\n";
    try {
        $result = $client->createProduit("Test Produit", "Description du produit de test", 99.99, 10, "Test");
        echo "Résultat: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    // === TEST DES STATISTIQUES ===
    echo "13. RÉCUPÉRATION DES STATISTIQUES\n";
    echo "--------------------------------\n";
    try {
        $result = $client->getStatistiques();
        echo "Statistiques:\n";
        print_r($result);
        echo "\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    // === TEST DE LA RECHERCHE ===
    echo "14. RECHERCHE DE PRODUITS\n";
    echo "-------------------------\n";
    try {
        $result = $client->rechercherProduits("Gaming");
        echo "Résultat de la recherche: " . $result . "\n\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n\n";
    }

    echo "=== FIN DES TESTS ===\n";

} catch (Exception $e) {
    echo "Erreur de connexion: " . $e->getMessage() . "\n";
}
?> 