<?php
require_once './app/controllers/ModifierArticleController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifier l'authentification
AuthMiddleware::requireAuth();

$controller = new ModifierArticleController();
$controller->index();