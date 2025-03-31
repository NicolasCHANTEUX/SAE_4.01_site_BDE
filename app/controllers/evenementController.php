<?php

require_once './app/core/Controller.php';
require_once './app/repositories/evenementRepository.php';

class EvenementController extends Controller
{
   use FormTrait;
   public function index()
   {
       $evenementRepo = new EvenementRepository();


       $evenements = $evenementRepo->findAll();

       foreach ($evenements as $evenement) {
           $category = $categoryRepo->findByArticle($article);
           $article->setCategory($category);
       }

        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('evenement/index.html.twig',  [
            'title' => 'Le site du BDE',
            'articles' => $articles,
            'purchases'=> array_map(static fn(string $purchase) => unserialize($purchase),$_SESSION['purchases']??[])
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
