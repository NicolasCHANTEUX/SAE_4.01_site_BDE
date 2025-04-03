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
            'data' => $contact
        ];
    }
}