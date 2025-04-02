<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';

class AccueilAdminController extends Controller {
   private $articleRepository;

   public function __construct() {
      $this->articleRepository = new ArticleRepository();
   }

   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

        if(isset($_GET['action']) && $_GET['action'] === 'list') {
            header('Content-Type: application/json');
            echo json_encode($this->articleRepository->findAll());
            exit;
        }

        $articles = $this->articleRepository->findAll();
        $this->view('accueil/accueilAdmin.php', [
            'title' => 'Le site du BDE',
            'articles' => $articles,
        ]);

   }
}
