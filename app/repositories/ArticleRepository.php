<?php

require_once './app/core/Repository.php';
require_once './app/entities/Article.php';

class ArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM article');
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $this->createArticleFromRow($row);
        }
        return $articles;
    }

    public function findById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare('SELECT * FROM article WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if($article)
            return $this->createArticleFromRow($article);
        return null;
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

    private function createArticleFromRow(array $row): Article
    {
        return new Article($row['id'], 'titre', $row['description'], '10');
    }

}