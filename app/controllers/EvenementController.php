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

   public function handleParticipation()
   {
       if(session_status() == PHP_SESSION_NONE)
           session_start();

       $userId = $_SESSION['user_id'] ?? null;

       if ($userId) {
           // Logique pour gérer la participation à l'événement
           // Par exemple, enregistrer la participation dans la base de données
           return [
               'status' => 'success',
               'message' => 'Participation enregistrée avec succès.',
           ];
       } else {
           return [
               'status' => 'error',
               'message' => 'Vous devez être connecté pour participer.',
           ];
       }
   }
}
