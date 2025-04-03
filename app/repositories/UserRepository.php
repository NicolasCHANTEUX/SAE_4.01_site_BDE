<?php

require_once './app/core/Repository.php';
require_once './app/entities/User.php';

class UserRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM "utilisateur"');
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->createUserFromRow($row);
        }
        return $users;
    }

    private function createUserFromRow(array $row): User
    {
        return new User($row['id'], $row['email'], $row['mot_de_passe'], $row['nom'], $row['prenom'], $row['role'], $row['date_creation']);
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->pdo->prepare('SELECT * FROM "utilisateur" WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user)
            return $this->createUserFromRow($user);
        return null;
    }

    public function create(array $data): bool {
        try {
            $sql = "INSERT INTO utilisateur (email, mot_de_passe, nom, prenom, role) 
                    VALUES (:email, :mot_de_passe, :nom, :prenom, :role)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'email' => $data['email'],
                'mot_de_passe' => $data['mot_de_passe'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'role' => $data['role']
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
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