<?php

require_once './app/core/Controller.php';
require_once './app/repositories/EvenementRepository.php';

class EvenementController extends Controller {
    private $evenementRepository;

    public function __construct() {
        $this->evenementRepository = new EvenementRepository();
    }

    public function index() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si c'est une requête AJAX pour la liste des événements
        if(isset($_GET['action']) && $_GET['action'] === 'list') {
            header('Content-Type: application/json');
            echo json_encode($this->evenementRepository->findAll());
            exit;
        }

        // Sinon, afficher la page normale
        $evenements = $this->evenementRepository->findAll();
        
        $this->view('evenement/evenement.php', [
            'title' => 'Événements - BDE',
            'evenements' => $evenements
        ]);
    }

    public function handleParticipation() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
    
        $userId = $_SESSION['user_id'] ?? null;
        $evenementId = $data['evenement_id'] ?? null;
    
        if (!$userId || !$evenementId) {
            return [
                'status' => 'error',
                'message' => 'Données invalides ou utilisateur non connecté'
            ];
        }
    
        try {
            $success = $this->evenementRepository->addParticipant($evenementId, $userId);
            if ($success) {
                return [
                    'status' => 'success',
                    'message' => 'Inscription réussie'
                ];
            }
            return [
                'status' => 'error',
                'message' => 'Erreur lors de l\'inscription'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}