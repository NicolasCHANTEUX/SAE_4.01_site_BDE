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

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['demande'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Tous les champs sont obligatoires'
            ]);
            exit;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Adresse email invalide'
            ]);
            exit;
        }

        if ($this->contactRepository->creerContact($data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi du message'
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