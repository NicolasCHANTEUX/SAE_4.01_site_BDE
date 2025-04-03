<?php
require_once './app/controllers/CompteController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifier l'authentification
AuthMiddleware::requireAuth();

$controller = new CompteController();
$controller->index();