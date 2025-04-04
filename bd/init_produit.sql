DROP TABLE IF EXISTS produits CASCADE;
DROP TABLE IF EXISTS ligne_commande CASCADE;

CREATE TABLE produits (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INTEGER NOT NULL DEFAULT 0,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    taille VARCHAR(5)[],
    couleurs VARCHAR(20)[],
    chemin_image VARCHAR(255)
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