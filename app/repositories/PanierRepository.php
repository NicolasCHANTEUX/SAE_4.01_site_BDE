<?php

require_once './app/core/Repository.php';

class PanierRepository {
    private $repository;

    public function __construct() {
        $this->repository = Repository::getInstance();
    }

    public function creerCommande($utilisateur_id) {
        try {
            $sql = "INSERT INTO commande (utilisateur_id) VALUES (:utilisateur_id) RETURNING id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute(['utilisateur_id' => $utilisateur_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function ajouterLigneCommande($commande_id, $produit_id, $quantite, $taille, $couleur, $prix_unitaire) {
        try {
            $sql = "INSERT INTO ligne_commande (commande_id, produit_id, quantite, taille, couleur, prix_unitaire) 
                    VALUES (:commande_id, :produit_id, :quantite, :taille, :couleur, :prix_unitaire)";
            $stmt = $this->repository->getPDO()->prepare($sql);
            return $stmt->execute([
                'commande_id' => $commande_id,
                'produit_id' => $produit_id,
                'quantite' => $quantite,
                'taille' => $taille,
                'couleur' => $couleur,
                'prix_unitaire' => $prix_unitaire
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getCommandeDetails($commande_id) {
        try {
            $sql = "SELECT 
                        c.id AS commande_id,
                        c.date_commande,
                        c.statut,
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
                    WHERE c.id = :commande_id
                    ORDER BY lc.id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute(['commande_id' => $commande_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function envoyerCommande($utilisateur_id) {
        try {
            $pdo = $this->repository->getPDO();
            $pdo->beginTransaction();

            // Créer une nouvelle commande
            $sql = "INSERT INTO commande (utilisateur_id, statut) VALUES (:utilisateur_id, 'envoyee') RETURNING id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['utilisateur_id' => $utilisateur_id]);
            $commande_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

            // Ajouter les lignes de la commande
            $sql = "INSERT INTO ligne_commande (commande_id, produit_id, quantite, taille, couleur, prix_unitaire) 
                    VALUES (:commande_id, :produit_id, :quantite, :taille, :couleur, :prix_unitaire)";
            $stmt = $pdo->prepare($sql);

            foreach ($_SESSION['panier'] as $item) {
                $stmt->execute([
                    'commande_id' => $commande_id,
                    'produit_id' => $item['id'],
                    'quantite' => $item['quantite'],
                    'taille' => $item['taille'],
                    'couleur' => $item['couleur'],
                    'prix_unitaire' => $item['prix']
                ]);
            }

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}