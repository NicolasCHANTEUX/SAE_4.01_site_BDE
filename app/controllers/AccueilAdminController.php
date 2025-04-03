<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/ArticleService.php';
require_once './app/services/AuthService.php';

class AccueilAdminController extends Controller {
    use FormTrait;

    private $service;

    public function __construct() {
        $this->service = new ArticleService();
    }

    public function index()
    {
      //$this->checkAuth();
      $articles = $service->allArticles();

        $this->view('accueil/form.php', [
            'title'    => 'Gestion Articles',
            'articles' => $articles
        ]);

    }

    public function create() {
        $service->create();
    }

    public function update() {
        $service->update();
    }

    public function delete() {
        $service->delete();
    }

   private function checkAuth() {
      $auth = new AuthService();
      if (!$auth->isLoggedIn()) {
          $this->redirectTo('connexion.php');
      }
   }
}
