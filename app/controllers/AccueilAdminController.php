<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/ArticleService.php';
require_once './app/services/AuthService.php';

class AccueilAdminController extends Controller {
   use FormTrait;

   public function index()
   {
      $this->checkAuth();
      $service = new ArticleService();
      $articles = $service->allArticles();

        $this->view('accueil/accueilAdmin.php', [
            'title'    => 'Gestion Articles',
            'articles' => $articles
        ]);

   }

   public function create() {
      //$this->checkAuth();
      $categoryService = new CategoryService();
      $categories = $categoryService->allCategory();

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

      $this->view('/accueil/form', 'Création d\'un article', [
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
