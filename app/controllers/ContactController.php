<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../repositories/ContactRepository.php';

class ContactController extends Controller {
    private $contactRepository;

    public function __construct() {
        $this->contactRepository = new ContactRepository();
    }

    public function index() {
        $socialLinks = $this->getSocialLinks();
        $this->view('contact.php', [
            'title' => 'Contact - BDE',
            'socialLinks' => $socialLinks
        ]);
    }

    public function envoyerMessage() {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            error_log('Données reçues: ' . print_r($data, true)); // Debug log
            
            if (!$data) {
                throw new Exception('Données invalides');
            }

            // Validation des données
            $requiredFields = ['nom', 'prenom', 'email', 'demande'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Le champ '$field' est requis");
                }
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Adresse email invalide');
            }

            if ($this->contactRepository->creerContact($data)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Votre message a été envoyé avec succès'
                ]);
            } else {
                throw new Exception('Erreur lors de l\'enregistrement du message');
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    private function getSocialLinks() {
        return [
            'email' => 'contact@bde-iut.fr',
            'discord' => 'https://discord.gg',
            'instagram' => 'https://instagram.com'
        ];
    }
}