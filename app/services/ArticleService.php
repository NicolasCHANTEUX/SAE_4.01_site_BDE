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

        

        $repository = new ArticleRepository();
        if (!$repository->create($article)) {
            throw new Exception('Erreur lors de la création de l\'article.');
        }

        return $article;
    }


    public function update() {

        if (empty($data['id'])) {
            $errors[] = 'Le id est requis.';
        }
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

        $repository = new ArticleRepository();
        if (!$repository->update($article)) {
            throw new Exception('Erreur lors de la modification de l\'article.');
        }
    }


    public function delete(array $data): bool {
        $errors = [];

        // Validation des données
        if (empty($data['id'])) {
            $errors[] = 'L\'id est invalide.';
            return false;
        }

        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
            return false;
        }

        $repository = new ArticleRepository();
        if (!$repository->delete($data['id'])) {
            throw new Exception('Erreur lors de la création de l\'article.');
        }

        return true;
    }

    public function find(int $id): ?Article
    {
        $articleRepo = new ArticleRepository();
        return $articleRepo->findById($id);
    }

}