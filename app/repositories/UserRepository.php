<?php

require_once './app/core/Repository.php';

class UserRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->pdo->prepare('
            INSERT INTO utilisateur (email, mot_de_passe, nom, prenom, role)
            VALUES (:email, :mot_de_passe, :nom, :prenom, :role)
        ');
        return $stmt->execute($data);
    }

    public function verifyPassword(int $userId, string $password): bool {
        try {
            $stmt = $this->pdo->prepare('SELECT mot_de_passe FROM utilisateur WHERE id = :id');
            $stmt->execute(['id' => $userId]);
            $result = $stmt->fetch();

            if (!$result) {
                return false;
            }

            return password_verify($password, $result['mot_de_passe']);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteAccount(int $userId): bool {
        try {
            $this->pdo->beginTransaction();

            // Supprimer les commandes liées
            $stmt = $this->pdo->prepare('DELETE FROM ligne_commande WHERE commande_id IN (SELECT id FROM commande WHERE utilisateur_id = :id)');
            $stmt->execute(['id' => $userId]);

            // Supprimer les commandes
            $stmt = $this->pdo->prepare('DELETE FROM commande WHERE utilisateur_id = :id');
            $stmt->execute(['id' => $userId]);

            // Supprimer les inscriptions aux événements
            $stmt = $this->pdo->prepare('DELETE FROM inscription_evenement WHERE utilisateur_id = :id');
            $stmt->execute(['id' => $userId]);

            // Supprimer l'utilisateur
            $stmt = $this->pdo->prepare('DELETE FROM utilisateur WHERE id = :id');
            $success = $stmt->execute(['id' => $userId]);

            if ($success) {
                $this->pdo->commit();
                return true;
            } else {
                $this->pdo->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function updatePassword(int $userId, string $hashedPassword): bool {
        try {
            $stmt = $this->pdo->prepare('UPDATE utilisateur SET mot_de_passe = :password WHERE id = :id');
            return $stmt->execute([
                'id' => $userId,
                'password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}