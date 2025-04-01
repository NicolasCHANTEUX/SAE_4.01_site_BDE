<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/controllers/ContactController.php';


$controller = new ContactController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->handleContact($_POST);
    echo json_encode($result);
    exit;
}

$controller->index();