<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/controllers/PanierController.php';

$controller = new PanierController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->ajouterProduit();
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

$controller->index();