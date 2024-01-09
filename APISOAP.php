<?php
class UserAPI
{
  private $pdo;

  public function __construct()
  {
    // Connexion à la base de données
    $host = 'localhost:3307';
    $db   = 'testituser';
    $user = 'root';
    $pass = '';
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

  public function getUser($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function createUser($nom, $email)
  {
    $stmt = $this->pdo->prepare('INSERT INTO users (nom, email) VALUES (?, ?)');
    $stmt->execute([$nom, $email]);
    return 'Utilisateur créé';
  }

  public function updateUser($id, $nom, $email)
  {
    $stmt = $this->pdo->prepare('UPDATE users SET nom = ?, email = ? WHERE id = ?');
    $stmt->execute([$nom, $email, $id]);
    return 'Utilisateur mis à jour';
  }

  public function deleteUser($id)
  {
    $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);
    return 'Utilisateur supprimé';
  }
}
ini_set("soap.wsdl_cache_enabled", "0");
$server = new SoapServer("http://10.21.6.24/API-SOAP/APISOAP.wsdl");

$server->setClass('UserAPI');
$server->handle();