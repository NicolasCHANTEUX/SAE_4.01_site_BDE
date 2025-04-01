<?php
require_once './app/controllers/AuthController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Rediriger si déjà connecté
if (AuthMiddleware::isAuthenticated()) {
    header('Location: /compte.php');
    exit();
}

$controller = new AuthController();
echo $controller->login();