<?php
require_once './app/repositories/ArticleRepository.php';

class ArticleService {
    public function allArticles() {
        $articleRepo = new ArticleRepository();

        $articles = $articleRepo->findAll();

        return $articles;
    }

    public function create(array $data): Article {
        $errors = [];

        // Validation des données
        if (empty($data['titre'])) {
            $errors[] = 'Le titre est requis.';
        }
        if (empty($data['description'])) {
            $errors[] = 'La description est requise.';
        }
        if (empty($data['date_creation'])) {
            $errors[] = 'La date est incorrecte.';
        }


        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }

        $article = new Article(
            null,
            $data['titre'],
            $data['description'] ?? '',
            $data['date']
        );

        $repository = new ArticleRepository();
        if (!$repository->create($article)) {
            throw new Exception('Erreur lors de la création de l\'article.');
        }

        return $article;
    }


    public function update() {
        //$this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleData = [
                'article_id' => $_POST['article_id'] ?? null,
                'titre' => $_POST['titre'] ?? '',
                'description' => $_POST['description'] ?? '',
                'date_creation' => $_POST['date_creation'] ?? ''
            ];
            
            $this->evenementRepository->update($articleData);
            $this->redirectTo('accueilAdmin.php');
        }
    }


    public function supprimerArticle(int $id): bool {
        $repository = new ArticleRepository();
    }

    public function find(int $id): ?Article
    {
        $articleRepo = new ArticleRepository();
        return $articleRepo->findById($id);
    }

}