<?php
require_once './app/controllers/AccueilAdminController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifier l'authentification
AuthMiddleware::requireAuth();

$controller = new AccueilAdminController();
$controller->create();