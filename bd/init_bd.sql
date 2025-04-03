DROP TABLE IF EXISTS articles CASCADE;
DROP TABLE IF EXISTS produits CASCADE;
DROP TABLE IF EXISTS commande CASCADE;
DROP TABLE IF EXISTS ligne_commande CASCADE;
DROP TABLE IF EXISTS inscription_evenement CASCADE;
DROP TABLE IF EXISTS contacts CASCADE;
DROP TABLE IF EXISTS evenement CASCADE;
DROP TABLE IF EXISTS utilisateur CASCADE;
DROP TABLE IF EXISTS questionsFrequentes CASCADE;

CREATE TABLE articles (
	id SERIAL PRIMARY KEY, 
	titre VARCHAR(255) NOT NULL,
	description TEXT NOT NULL, 
	date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE utilisateur (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'membre',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE evenement (
    id SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_evenement TIMESTAMP NOT NULL,
    createur_id INTEGER REFERENCES utilisateur(id),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    prix DECIMAL(10,2) DEFAULT 0,
    max_participants INTEGER,
    nb_inscrits INTEGER DEFAULT 0,
	chemin_image VARCHAR(255)
);

CREATE TABLE produits (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INTEGER NOT NULL DEFAULT 0,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    taille VARCHAR(5)[],
    couleurs VARCHAR(20)[]
);

CREATE TABLE commande (
    id SERIAL PRIMARY KEY,
    utilisateur_id INTEGER REFERENCES utilisateur(id),
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) DEFAULT 'en_attente'
);

CREATE TABLE ligne_commande (
    id SERIAL PRIMARY KEY,
    commande_id INTEGER REFERENCES commande(id),
    produit_id INTEGER REFERENCES produits(id),
    quantite INTEGER NOT NULL,
    taille VARCHAR(5),
    couleur VARCHAR(20),
    prix_unitaire DECIMAL(10,2) NOT NULL
);

CREATE TABLE inscription_evenement (
    id SERIAL PRIMARY KEY,
    evenement_id INTEGER REFERENCES evenement(id),
    utilisateur_id INTEGER REFERENCES utilisateur(id),
    nb_participants INTEGER NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut_paiement VARCHAR(20) DEFAULT 'en_attente'
);

CREATE TABLE contacts (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
	prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) DEFAULT 'non_lu'
);

CREATE TABLE questionsFrequentes (
   id SERIAL PRIMARY KEY,
   question   VARCHAR(100) NOT NULL,
   reponse    VARCHAR(800) NOT NULL
);