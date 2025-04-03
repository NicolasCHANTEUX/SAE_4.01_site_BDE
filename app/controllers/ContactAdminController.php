<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ContactRepository.php';
require_once './app/services/AuthService.php';

class ContactAdminController extends Controller {
    private $contactRepository;

    public function __construct() {
        $this->contactRepository = new ContactRepository();
    }

    public function index() {
        $contacts = $this->contactRepository->findAll();
        $this->view('contact/contactAdmin.php', [
            'title' => 'Gestion des contacts',
            'contacts' => $contacts
        ]);
    }

    public function updateStatut() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactId = $_POST['contact_id'] ?? null;
            $nouveauStatut = $_POST['statut'] ?? null;
            
            if ($contactId && $nouveauStatut) {
                $success = $this->contactRepository->updateStatut($contactId, $nouveauStatut);
                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        http_response_code(400);
        exit;
    }

    public function getContact($id) {
        $contact = $this->contactRepository->findById($id);
        if (!$contact) {
            return [
                'success' => false,
                'message' => 'Contact non trouvé'
            ];
        }

        // Si on trouve le contact, on le marque comme lu
        if ($contact['statut'] === 'non_lu') {
            $this->contactRepository->updateStatut($id, 'lu');
        }

        return [
            'success' => true,
            'data' => [
                'id' => $contact['id'],
                'nom' => $contact['nom'],
                'prenom' => $contact['prenom'],
                'email' => $contact['email'],
                'message' => $contact['message'],
                'date_envoi' => $contact['date_envoi'],
                'statut' => $contact['statut']
            ]
        ];
    }

    public function envoyerReponse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['contactId'], $data['reponse'])) {
                return [
                    'success' => false,
                    'message' => 'Données manquantes'
                ];
            }

            $contact = $this->contactRepository->findById($data['contactId']);
            if (!$contact) {
                return [
                    'success' => false,
                    'message' => 'Contact non trouvé'
                ];
            }

            // Envoyer l'email de réponse
            $success = $this->envoyerEmail($contact['email'], $data['reponse']);
            
            if ($success) {
                // Mettre à jour le statut du contact
                $this->contactRepository->updateStatut($data['contactId'], 'repondu');
                return [
                    'success' => true,
                    'message' => 'Réponse envoyée avec succès'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'envoi de la réponse'
            ];
        }
    }

    private function envoyerEmail($to, $message) {
        $headers = [
            'From' => 'bde@example.com',
            'Reply-To' => 'bde@example.com',
            'X-Mailer' => 'PHP/' . phpversion(),
            'Content-Type' => 'text/html; charset=UTF-8'
        ];

        $subject = 'Réponse à votre message - BDE IUT Informatique';
        
        return mail($to, $subject, $message, $headers);
    }
}