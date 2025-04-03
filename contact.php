<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/controllers/ContactController.php';

$controller = new ContactController();

// Vérifie si la requête est pour envoyer un message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/contact/envoyer') !== false) {
    $controller->envoyerMessage();
} else {
    // Affichage normal de la page de contact
    $controller->index();
}