<?php
require_once './app/controllers/EvenementController.php';

$controller = new EvenementController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->handleParticipation($_POST);
    echo json_encode($result);
    exit;
}

$controller->index();