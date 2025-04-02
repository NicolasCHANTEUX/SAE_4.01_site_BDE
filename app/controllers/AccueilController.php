<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/repositories/EvenementRepository.php';

class AccueilController extends Controller {
   private $articleRepository;
   private $evenementRepository;

   public function __construct() {
      $this->articleRepository = new ArticleRepository();
      $this->evenementRepository = new EvenementRepository();
   }

   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

        if(isset($_GET['action']) && $_GET['action'] === 'list') {
            header('Content-Type: application/json');
            echo json_encode($this->articleRepository->findAll());
            echo json_encode($this->evenementRepository->findAll());
            exit;
        }

        $articles = $this->articleRepository->findAll();
        $evenements = $this->evenementRepository->findAll();
        $this->view('index.php', [
            'title' => 'Le site du BDE',
            'articles' => $articles,
            'evenements' => $evenements
        ]);

   }
}
