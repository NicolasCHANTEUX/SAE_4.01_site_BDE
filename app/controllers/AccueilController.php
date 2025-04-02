<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';

class AccueilController extends Controller {
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
        $this->view('index.php', [
            'title' => 'Le site du BDE',
            'articles' => $articles
        ]);

   }

   public function purchase()
   {
       $articleRepo = new ArticleRepository();
       $article = $articleRepo->findById($this->getQueryParam('article_id'));

       $authService = new AuthService();
       $purchase = new Purchase(null,$article,$authService->getUser(),$this->getPostParam('quantity'));

       if(session_status() == PHP_SESSION_NONE)
           session_start();

       if(!isset($_SESSION['purchases']))
       {
           $_SESSION['purchases']=[];
       }

       $_SESSION['purchases'][] = serialize($purchase);

       $this->redirectTo('index.php');
   }
}
