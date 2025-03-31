<?php

require_once './app/core/Controller.php';

class AccueilController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('index.php',  [
            'title' => 'Le site du BDE',
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
