CREATE TABLE contacts (
	id INT PRIMARY KEY AUTO_INCREMENT,
	nom VARCHAR(100) NOT NULL,
	prenom VARCHAR(100) NOT NULL,
	email VARCHAR(255) NOT NULL,
	demande TEXT NOT NULL,
	date_creation DATETIME NOT NULL,
	statut ENUM('nouveau', 'en_cours', 'traite') DEFAULT 'nouveau',
	INDEX idx_email (email),
	INDEX idx_date (date_creation)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;