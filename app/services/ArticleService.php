<?php
require_once './app/repositories/ArticleRepository.php';
require_once './app/entities/Article.php';

class ArticleService {
    private $articleRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
    }

    public function create(array $data): bool {
        $article = new Article(
            null,
            $data['titre'],
            $data['description'],
            $data['date_creation']
        );

        return $this->articleRepository->create($article);
    }

    public function update(array $data): bool {
        return $this->articleRepository->update($data);
    }

    public function delete(array $data): bool {
        return $this->articleRepository->delete($data['id']);
    }
}