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
    if ($auth->getUser()->getRole() !== 'admin') {
            $this->redirectTo('index.php');
    }
   }
}
