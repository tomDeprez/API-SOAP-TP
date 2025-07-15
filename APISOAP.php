<?php
class UserAPI
{
  private $pdo;

  public function __construct()
  {
    // Connexion à la base de données
    $host = 'localhost:3306';
    $db   = 'livraison';
    $user = 'root';
    $pass = 'password';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
      $this->pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }

  // === ENDPOINTS UTILISATEURS ===
  public function getUser($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllUsers()
  {
    $stmt = $this->pdo->prepare('SELECT * FROM users ORDER BY created_at DESC');
    $stmt->execute();
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }

  public function createUser($nom, $email)
  {
    $stmt = $this->pdo->prepare('INSERT INTO users (nom, email) VALUES (?, ?)');
    $stmt->execute([$nom, $email]);
    return 'Utilisateur créé avec succès';
  }

  public function updateUser($id, $nom, $email)
  {
    $stmt = $this->pdo->prepare('UPDATE users SET nom = ?, email = ? WHERE id = ?');
    $stmt->execute([$nom, $email, $id]);
    return 'Utilisateur mis à jour avec succès';
  }

  public function deleteUser($id)
  {
    $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return 'Utilisateur supprimé avec succès';
  }

  // === ENDPOINTS COMMANDES ===
  public function getCommande($id)
  {
    $stmt = $this->pdo->prepare('
      SELECT c.*, u.nom as nom_utilisateur, u.email 
      FROM commandes c 
      JOIN users u ON c.user_id = u.id 
      WHERE c.id = ?
    ');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllCommandes()
  {
    $stmt = $this->pdo->prepare('
      SELECT c.*, u.nom as nom_utilisateur, u.email 
      FROM commandes c 
      JOIN users u ON c.user_id = u.id 
      ORDER BY c.created_at DESC
    ');
    $stmt->execute();
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }

  public function getCommandesByUser($user_id)
  {
    $stmt = $this->pdo->prepare('
      SELECT c.*, u.nom as nom_utilisateur, u.email 
      FROM commandes c 
      JOIN users u ON c.user_id = u.id 
      WHERE c.user_id = ? 
      ORDER BY c.created_at DESC
    ');
    $stmt->execute([$user_id]);
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }

  public function createCommande($user_id, $numero_commande, $montant, $adresse_livraison)
  {
    $stmt = $this->pdo->prepare('
      INSERT INTO commandes (user_id, numero_commande, montant, adresse_livraison) 
      VALUES (?, ?, ?, ?)
    ');
    $stmt->execute([$user_id, $numero_commande, $montant, $adresse_livraison]);
    return 'Commande créée avec succès';
  }

  public function updateCommandeStatut($id, $statut)
  {
    $stmt = $this->pdo->prepare('UPDATE commandes SET statut = ? WHERE id = ?');
    $stmt->execute([$statut, $id]);
    return 'Statut de la commande mis à jour avec succès';
  }

  public function deleteCommande($id)
  {
    $stmt = $this->pdo->prepare('DELETE FROM commandes WHERE id = ?');
    $stmt->execute([$id]);
    return 'Commande supprimée avec succès';
  }

  // === ENDPOINTS PRODUITS ===
  public function getProduit($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM produits WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllProduits()
  {
    $stmt = $this->pdo->prepare('SELECT * FROM produits ORDER BY nom');
    $stmt->execute();
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }

  public function getProduitsByCategorie($categorie)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM produits WHERE categorie = ? ORDER BY nom');
    $stmt->execute([$categorie]);
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }

  public function createProduit($nom, $description, $prix, $stock, $categorie)
  {
    $stmt = $this->pdo->prepare('
      INSERT INTO produits (nom, description, prix, stock, categorie) 
      VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([$nom, $description, $prix, $stock, $categorie]);
    return 'Produit créé avec succès';
  }

  public function updateProduit($id, $nom, $description, $prix, $stock, $categorie)
  {
    $stmt = $this->pdo->prepare('
      UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ?, categorie = ? 
      WHERE id = ?
    ');
    $stmt->execute([$nom, $description, $prix, $stock, $categorie, $id]);
    return 'Produit mis à jour avec succès';
  }

  public function deleteProduit($id)
  {
    $stmt = $this->pdo->prepare('DELETE FROM produits WHERE id = ?');
    $stmt->execute([$id]);
    return 'Produit supprimé avec succès';
  }

  // === ENDPOINTS STATISTIQUES ===
  public function getStatistiques()
  {
    $stats = [];
    
    // Nombre total d'utilisateurs
    $stmt = $this->pdo->prepare('SELECT COUNT(*) as total FROM users');
    $stmt->execute();
    $stats['total_utilisateurs'] = (int)$stmt->fetch()['total'];
    
    // Nombre total de commandes
    $stmt = $this->pdo->prepare('SELECT COUNT(*) as total FROM commandes');
    $stmt->execute();
    $stats['total_commandes'] = (int)$stmt->fetch()['total'];
    
    // Montant total des commandes
    $stmt = $this->pdo->prepare('SELECT SUM(montant) as total FROM commandes');
    $stmt->execute();
    $result = $stmt->fetch();
    $stats['montant_total'] = $result['total'] ? (float)$result['total'] : 0.0;
    
    // Nombre total de produits
    $stmt = $this->pdo->prepare('SELECT COUNT(*) as total FROM produits');
    $stmt->execute();
    $stats['total_produits'] = (int)$stmt->fetch()['total'];
    
    // Commandes par statut
    $stmt = $this->pdo->prepare('
      SELECT statut, COUNT(*) as nombre 
      FROM commandes 
      GROUP BY statut
    ');
    $stmt->execute();
    $stats['commandes_par_statut'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return json_encode($stats);
  }

  public function rechercherProduits($terme)
  {
    $stmt = $this->pdo->prepare('
      SELECT * FROM produits 
      WHERE nom LIKE ? OR description LIKE ? OR categorie LIKE ?
      ORDER BY nom
    ');
    $terme_recherche = "%$terme%";
    $stmt->execute([$terme_recherche, $terme_recherche, $terme_recherche]);
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }
}

ini_set("soap.wsdl_cache_enabled", "0");
$server = new SoapServer(__DIR__ . "/APISOAP.wsdl");

$server->setClass('UserAPI');
$server->handle();