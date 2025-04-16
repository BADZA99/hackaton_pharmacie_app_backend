
-- Table roles
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

INSERT INTO roles (nom) VALUES 
('admin'), 
('client'), 
('livreur'), 
('pharmacien');


-- Table users
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NULL,
    google_id VARCHAR(255) NULL,
    avatar VARCHAR(255) NULL,
    role_id INT NOT NULL DEFAULT 2,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);


-- Table verifications_pharmaciens
CREATE TABLE verifications_pharmaciens (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    numero_licence VARCHAR(100) NOT NULL,
    nom_pharmacie VARCHAR(150),
    adresse_pharmacie TEXT,
    document_justificatif VARCHAR(255),
    statut ENUM('en_attente', 'valide', 'refuse') DEFAULT 'en_attente',
    commentaire_admin TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Table pharmacies
CREATE TABLE pharmacies (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    adresse TEXT NOT NULL,
    telephone VARCHAR(20),
    statut ENUM('active', 'inactive') DEFAULT 'inactive',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Table categories
CREATE TABLE categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Table medicaments
CREATE TABLE medicaments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    pharmacie_id BIGINT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    ordonnance_requise BOOLEAN DEFAULT FALSE,
    date_peremption DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pharmacie_id) REFERENCES pharmacies(id) ON DELETE CASCADE
);


-- Table categorie_medicament (pivot many-to-many)
CREATE TABLE categorie_medicament (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    medicament_id BIGINT NOT NULL,
    categorie_id BIGINT NOT NULL,
    FOREIGN KEY (medicament_id) REFERENCES medicaments(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
);


-- Table commandes
CREATE TABLE commandes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    client_id BIGINT NOT NULL,
    statut ENUM('en_attente', 'en_livraison', 'livree', 'annulee') DEFAULT 'en_attente',
    total DECIMAL(10,2) DEFAULT 0,
    adresse_livraison TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Table commande_medicament (pivot)
CREATE TABLE commande_medicament (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    commande_id BIGINT,
    medicament_id BIGINT,
    quantite INT,
    prix_unitaire DECIMAL(10,2),
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (medicament_id) REFERENCES medicaments(id) ON DELETE CASCADE
);


-- Table livraisons
CREATE TABLE livraisons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    commande_id BIGINT,
    livreur_id BIGINT,
    statut ENUM('en_cours', 'livree', 'echouee') DEFAULT 'en_cours',
    date_livraison DATE NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (livreur_id) REFERENCES users(id) ON DELETE CASCADE
);
