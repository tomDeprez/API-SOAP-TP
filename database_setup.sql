-- Création de la base de données
CREATE DATABASE IF NOT EXISTS livraison;
USE livraison;

-- Création de la table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Création de la table commandes
CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    numero_commande VARCHAR(50) NOT NULL UNIQUE,
    statut ENUM('en_preparation', 'expediee', 'livree', 'annulee') DEFAULT 'en_preparation',
    montant DECIMAL(10,2) NOT NULL,
    adresse_livraison TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Création de la table produits
CREATE TABLE IF NOT EXISTS produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    categorie VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion de données de test pour les utilisateurs
INSERT INTO users (nom, email) VALUES
('Jean Dupont', 'jean.dupont@email.com'),
('Marie Martin', 'marie.martin@email.com'),
('Pierre Durand', 'pierre.durand@email.com'),
('Sophie Bernard', 'sophie.bernard@email.com'),
('Lucas Petit', 'lucas.petit@email.com'),
('Emma Roux', 'emma.roux@email.com'),
('Thomas Moreau', 'thomas.moreau@email.com'),
('Julie Simon', 'julie.simon@email.com');

-- Insertion de données de test pour les produits
INSERT INTO produits (nom, description, prix, stock, categorie) VALUES
('Laptop Gaming', 'Ordinateur portable pour jeux vidéo', 1299.99, 15, 'Informatique'),
('Smartphone Pro', 'Téléphone intelligent haut de gamme', 899.99, 25, 'Mobile'),
('Tablette 10"', 'Tablette tactile 10 pouces', 399.99, 30, 'Mobile'),
('Écouteurs Sans Fil', 'Écouteurs bluetooth avec réduction de bruit', 199.99, 50, 'Audio'),
('Souris Gaming', 'Souris optique pour jeux vidéo', 79.99, 40, 'Informatique'),
('Clavier Mécanique', 'Clavier avec switches mécaniques', 149.99, 20, 'Informatique'),
('Webcam HD', 'Caméra web haute définition', 89.99, 35, 'Informatique'),
('Disque Dur Externe', 'Disque dur externe 2TB', 129.99, 25, 'Stockage');

-- Insertion de données de test pour les commandes
INSERT INTO commandes (user_id, numero_commande, statut, montant, adresse_livraison) VALUES
(1, 'CMD-2024-001', 'livree', 1299.99, '123 Rue de la Paix, 75001 Paris'),
(2, 'CMD-2024-002', 'expediee', 899.99, '456 Avenue des Champs, 75008 Paris'),
(3, 'CMD-2024-003', 'en_preparation', 399.99, '789 Boulevard Saint-Germain, 75006 Paris'),
(4, 'CMD-2024-004', 'livree', 199.99, '321 Rue du Commerce, 75015 Paris'),
(5, 'CMD-2024-005', 'annulee', 79.99, '654 Rue de Rivoli, 75001 Paris'),
(1, 'CMD-2024-006', 'en_preparation', 149.99, '123 Rue de la Paix, 75001 Paris'),
(6, 'CMD-2024-007', 'expediee', 89.99, '987 Rue de la Pompe, 75016 Paris'),
(7, 'CMD-2024-008', 'livree', 129.99, '147 Avenue Victor Hugo, 75016 Paris'); 