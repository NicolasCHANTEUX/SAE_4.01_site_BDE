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
            $sql = "SELECT c.*, u.nom, u.prenom,
                           p.nom as produit_nom, 
                           lc.quantite, lc.prix_unitaire, lc.taille, lc.couleur,
                           (lc.quantite * lc.prix_unitaire) as ligne_total
                    FROM commande c
                    JOIN utilisateur u ON c.utilisateur_id = u.id
                    JOIN ligne_commande lc ON c.id = lc.commande_id
                    JOIN produits p ON lc.produit_id = p.id
                    ORDER BY c.date_commande DESC";
            
            $stmt = $this->pdo->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Regrouper les résultats par commande
            $commandes = [];
            foreach ($results as $row) {
                if (!isset($commandes[$row['id']])) {
                    $commandes[$row['id']] = [
                        'id' => $row['id'],
                        'date_commande' => $row['date_commande'],
                        'statut' => $row['statut'],
                        'nom' => $row['nom'],
                        'prenom' => $row['prenom'],
                        'produits' => [],
                        'total_commande' => 0
                    ];
                }
                $commandes[$row['id']]['produits'][] = [
                    'nom' => $row['produit_nom'],
                    'quantite' => $row['quantite'],
                    'prix_unitaire' => $row['prix_unitaire'],
                    'taille' => $row['taille'],
                    'couleur' => $row['couleur'],
                    'ligne_total' => $row['ligne_total']
                ];
                // Ajouter le total de la ligne au total de la commande
                $commandes[$row['id']]['total_commande'] += $row['ligne_total'];
            }
            return array_values($commandes);
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

    public function deleteCommande(int $id): bool {
        try {
            $this->pdo->beginTransaction();
            
            // Supprimer d'abord les lignes de commande
            $stmt = $this->pdo->prepare('DELETE FROM ligne_commande WHERE commande_id = :id');
            $stmt->execute(['id' => $id]);
            
            // Puis supprimer la commande
            $stmt = $this->pdo->prepare('DELETE FROM commande WHERE id = :id');
            $success = $stmt->execute(['id' => $id]);
            
            if ($success) {
                $this->pdo->commit();
                return true;
            }
            
            $this->pdo->rollBack();
            return false;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log($e->getMessage());
            return false;
        }
    }
}