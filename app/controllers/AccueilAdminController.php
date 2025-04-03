<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/services/ArticleService.php';
require_once './app/services/AuthService.php';

class AccueilAdminController extends Controller {
    use FormTrait;

    private $articleRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
    }

    public function index() {
        $this->checkAuth();
        // Récupérer tous les articles pour le formulaire
        $articles = $this->articleRepository->findAll();

        $this->view('accueil/form.php', [
            'title' => 'Administration - Accueil',
            'articles' => $articles
        ]);
    }

    public function create() {
        $this->checkAuth();

        $data = $this->getAllPostParams();
        $errors = [];

        if (!empty($data)) {
            try {
                $articleService = new ArticleService();
                $articleService->create($data);
                $this->redirectTo('accueilAdmin.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/accueil/form.php', [
            'title' => 'Création Article',
            'data' => $data,
            'errors' => $errors
        ]);
    }

    public function update() {
        $this->checkAuth();

        $data = $this->getAllPostParams();
        $errors = [];

        if (!empty($data)) {
            try {
                $articleService = new ArticleService();
                $articleService->update($data);
                $this->redirectTo('accueilAdmin.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/accueil/form.php', [
            'title' => 'Modification Article',
            'data' => $data,
            'errors' => $errors
        ]);
    }

    public function delete() {
        $this->checkAuth();

        $data = $this->getAllPostParams();
        $errors = [];

        if (!empty($data)) {
            try {
                $articleService = new ArticleService();
                $articleService->delete($data);
                $this->redirectTo('accueilAdmin.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/accueil/form.php', [
            'title' => 'Suppression Article',
            'data' => $data,
            'errors' => $errors
        ]);
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('connexion.php');
        }
        if ($auth->getUser()->getRole() !== 'admin') {
            $this->redirectTo('index.php');
        }
    }
}
