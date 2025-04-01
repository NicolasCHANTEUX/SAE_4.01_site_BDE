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
}