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

            try {
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
                
                throw new Exception('Erreur lors de l\'envoi de l\'email');
            } catch (Exception $e) {
                error_log($e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Erreur lors de l\'envoi de la réponse: ' . $e->getMessage()
                ];
            }
        }
        
        return [
            'success' => false,
            'message' => 'Méthode non autorisée'
        ];
    }

    public function deleteMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['contactId'])) {
                return [
                    'success' => false,
                    'message' => 'ID du message manquant'
                ];
            }

            $success = $this->contactRepository->deleteContact($data['contactId']);
            return [
                'success' => $success,
                'message' => $success ? 'Message supprimé avec succès' : 'Erreur lors de la suppression'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Méthode non autorisée'
        ];
    }

    private function envoyerEmail($to, $message) {
        try {
            $subject = "Réponse demande Site BDE IUT le Havre";
            
            // Configuration plus détaillée des en-têtes
            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8',
                'From: BDE IUT Le Havre <no-reply@example.com>',
                'X-Mailer: PHP/' . phpversion(),
                'Return-Path: <no-reply@example.com>',
                'Reply-To: bde.iut.lehavre@gmail.com'
            ];

            // En-têtes additionnels pour la compatibilité
            ini_set('sendmail_from', 'no-reply@example.com');
            
            // Nettoyer le message pour l'encodage
            $messageHtml = "
            <html>
            <head>
                <meta charset='utf-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 0.9em; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <p>Bonjour,</p>
                    <p>Nous avons bien reçu votre demande et voici notre réponse :</p>
                    <p style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #4795c9;'>
                        {$message}
                    </p>
                    <div class='footer'>
                        <p>Cordialement,<br>L'équipe du BDE IUT Le Havre</p>
                        <p>
                            <small>Cet email est envoyé automatiquement, merci de ne pas y répondre directement.<br>
                            Pour toute autre demande, utilisez le formulaire de contact sur notre site.</small>
                        </p>
                    </div>
                </div>
            </body>
            </html>";

            $messageHtml = wordwrap($messageHtml, 70, "\r\n");

            // Ajouter plus de logs pour le débogage
            error_log("Destinataire: " . $to);
            error_log("Sujet: " . $subject);
            error_log("Headers: " . implode("\r\n", $headers));

            // Essayer d'envoyer l'email avec plus de paramètres
            $result = mail(
                $to,
                '=?UTF-8?B?'.base64_encode($subject).'?=',
                $messageHtml,
                implode("\r\n", $headers),
                '-f no-reply@example.com'
            );
            
            if (!$result) {
                $error = error_get_last();
                throw new Exception("Échec de l'envoi : " . 
                    ($error ? print_r($error, true) : 'Échec de la fonction mail()'));
            }

            return true;

        } catch (Exception $e) {
            error_log("Erreur détaillée d'envoi d'email : " . $e->getMessage());
            error_log("Trace : " . $e->getTraceAsString());
            throw $e;
        }
    }
}