<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/controllers/ContactController.php';

$controller = new ContactController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/contact/envoyer') !== false) {
    $controller->envoyerMessage();
} else {
    $controller->index();
}