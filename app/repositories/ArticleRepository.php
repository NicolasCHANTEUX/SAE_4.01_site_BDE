<?php

require_once './app/core/Repository.php';
require_once './app/entities/Article.php';

class ArticleRepository {
    private $repository;

    public function __construct() {
        $this->repository = Repository::getInstance();
    }

    public function findAll(): array {
        try {
            $sql = "SELECT * FROM articles ORDER BY date_creation DESC";
            $stmt = $this->repository->getPDO()->query($sql);
            $articles = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $articles[] = new Article(
                    $row['id'],
                    $row['titre'],
                    $row['description'],
                    $row['date_creation']
                );
            }
            
            return $articles;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function findById(int $id): ?Article
    {
        $stmt = $this->repository->getPDO()->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if($article)
            return $this->createArticleFromRow($article);
        return null;
    }

    public function create(Article $article): bool {
        $query = 'INSERT INTO articles (titre, description, date_creation)
                 VALUES (:titre, :description, :date_creation)';
        
        $stmt = $this->repository->getPDO()->prepare($query);
        return $stmt->execute([
            'titre' => $article->getTitre(),
            'description' => $article->getDescription(),
            'date_creation' => $article->getDateCreation()
        ]);
    }

    public function update(array $data): bool {
        try {
            $query = 'UPDATE articles SET titre = :titre, description = :description, date_creation = :date_creation WHERE id = :id';
            
            $stmt = $this->repository->getPDO()->prepare($query);
            return $stmt->execute([
                'id' => $data['id'],
                'titre' => $data['titre'],
                'description' => $data['description'],
                'date_creation' => $data['date_creation']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            $query = 'DELETE FROM articles WHERE id = :id';
            $stmt = $this->repository->getPDO()->prepare($query);
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