<?php

require_once './app/core/Controller.php';

class EvenementController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('evenement/evenement.php',  [
            'title' => 'Le site du BDE',
        ]);
   }
}
