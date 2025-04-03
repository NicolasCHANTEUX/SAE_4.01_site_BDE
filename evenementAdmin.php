<?php
require_once './app/controllers/EvenementAdminController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifier l'authentification


$controller = new EvenementAdminController();

// Router les actions
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}