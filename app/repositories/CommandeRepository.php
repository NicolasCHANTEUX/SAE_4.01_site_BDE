<?php

require_once './app/core/Repository.php';

class CommandeRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findByUserId($userId): array {
        try {
            $sql = "SELECT c.id, c.date_commande, c.statut,
                           p.nom as produit_nom, 
                           lc.quantite, lc.prix_unitaire, lc.taille, lc.couleur,
                           (lc.quantite * lc.prix_unitaire) as prix_total
                    FROM commande c
                    JOIN ligne_commande lc ON c.id = lc.commande_id
                    JOIN produits p ON lc.produit_id = p.id
                    WHERE c.utilisateur_id = :user_id
                    ORDER BY c.date_commande DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function findById(int $id): ?array {
        try {
            $sql = "SELECT c.*, u.nom as user_nom, u.prenom as user_prenom
                    FROM commande c
                    JOIN utilisateur u ON c.utilisateur_id = u.id
                    WHERE c.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function findAll(): array {
        try {
            $sql = "SELECT c.*, u.nom as user_nom, u.prenom as user_prenom
                    FROM commande c
                    JOIN utilisateur u ON c.utilisateur_id = u.id
                    ORDER BY c.date_commande DESC";
            
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updateStatus(int $id, string $status): bool {
        try {
            $sql = "UPDATE commande SET statut = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'status' => $status
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}