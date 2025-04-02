### pour récupérer toutes les informations dune commande grace à son id
SELECT 
    c.id AS commande_id,
    c.date_commande,
    c.statut,
    c.adresse,
    c.ville,
    c.code_postal,
    u.nom AS nom_client,
    u.prenom AS prenom_client,
    u.email,
    lc.quantite,
    lc.taille,
    lc.couleur,
    lc.prix_unitaire,
    p.nom AS nom_produit,
    p.description AS description_produit,
    (lc.quantite * lc.prix_unitaire) AS sous_total
FROM commande c
JOIN utilisateur u ON c.utilisateur_id = u.id
JOIN ligne_commande lc ON c.id = lc.commande_id
JOIN produits p ON lc.produit_id = p.id
WHERE c.id = [ID_COMMANDE]
ORDER BY lc.id;

### pour récupérer la somme totale dune commande grace à son id
SELECT SUM(quantite * prix_unitaire) AS total_commande
FROM ligne_commande
WHERE commande_id = [ID_COMMANDE];