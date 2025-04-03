<?php

require_once './app/core/Repository.php';

class ArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $query = 'SELECT * FROM articles ORDER BY date_creation ASC';
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array {
        $query = 'SELECT * FROM articles WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool {
        $query = 'INSERT INTO articles (titre, description, date_creation)
                 VALUES (:titre, :description, :date_creation)';
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function update(array $data): bool {
        $query = 'UPDATE articles 
                 SET titre = :titre, 
                     description = :description, 
                     date_creation = :date_creation
                 WHERE id = :id';
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $query = 'DELETE FROM articles WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

}