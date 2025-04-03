<?php
require_once './app/repositories/ArticleRepository.php';

class ArticleService {
    public function allArticles() {
        $articleRepo = new ArticleRepository();

        $articles = $articleRepo->findAll();

        return $articles;
    }

    public function create() {
        //$this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'titre' => $_POST['titre'] ?? '',
                'description' => $_POST['description'] ?? '',
                'date_creation' => $_POST['date_creation'] ?? ''
            ];
            
            $this->articleRepository->create($eventData);
            $this->redirectTo('accueilAdmin.php');
        }
    }

    public function update() {
        //$this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'event_id' => $_POST['event_id'] ?? null,
                'titre' => $_POST['titre'] ?? '',
                'description' => $_POST['description'] ?? '',
                'date_creation' => $_POST['date_creation'] ?? ''
            ];
            
            $this->evenementRepository->update($eventData);
            $this->redirectTo('evenementAdmin.php');
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