<?php

require_once './app/core/Repository.php';
require_once './app/entities/Article.php';

class ArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM articles');
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $this->createArticleFromRow($row);
        }
        return $articles;
    }

    public function findById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if($article)
            return $this->createArticleFromRow($article);
        return null;
    }

    public function create(Article $article): bool {
        $query = 'INSERT INTO articles (titre, description, date_creation)
                 VALUES (:titre, :description, :date_creation)';
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'titre' => $article->getTitre(),
            'description' => $article->getDescription(),
            'date_creation' => $article->getDateCreation()
        ]);
    }

    public function update(array $data): bool {
        $article = new Article(null, $data['titre'], $data['description'], $data['date_creation']);

        $this->delete($data['id']);
        $this->create($article);
    }

    public function delete(int $id): bool {
        try {
            $query = 'DELETE FROM articles WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    private function createArticleFromRow(array $row): Article
    {
        return new Article($row['id'], $row['titre'], $row['description'], $row['date_creation']);
    }

}