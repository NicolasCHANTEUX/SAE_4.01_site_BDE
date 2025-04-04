<?php
require_once './app/controllers/ContactAdminController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifier que l'utilisateur est admin
AuthMiddleware::requireRole('admin');

$controller = new ContactAdminController();

// Gérer les différentes actions
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'get':
            $contactId = $_GET['id'] ?? null;
            if ($contactId) {
                header('Content-Type: application/json');
                echo json_encode($controller->getContact($contactId));
                exit;
            }
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    header('Content-Type: application/json');
    switch ($_GET['action']) {
        case 'repondre':
            echo json_encode($controller->envoyerReponse());
            exit;
        case 'delete':
            echo json_encode($controller->deleteMessage());
            exit;
    }
}

// Par défaut, afficher la page principale
$controller->index();