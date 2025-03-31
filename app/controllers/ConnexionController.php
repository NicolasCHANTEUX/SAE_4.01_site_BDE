<?php

require_once './app/core/Controller.php';

class ConnexionController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('connexion/connexion.php',  [
            'title' => 'Le site du BDE',
        ]);
   }
}