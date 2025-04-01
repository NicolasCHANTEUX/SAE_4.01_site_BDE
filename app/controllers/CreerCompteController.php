<?php

require_once './app/core/Controller.php';

class CreerCompteController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('creerCompte/creerCompte.php',  [
            'title' => 'Le site du BDE',
        ]);
   }
}