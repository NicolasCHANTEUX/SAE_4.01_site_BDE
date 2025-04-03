<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/controllers/ProduitController.php';

$controller = new ProduitController();

// Récupérer l'ID du produit depuis l'URL si présent
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$result = $controller->handleProduit($_POST);
	echo json_encode($result);
	exit;
}

$controller->index($id);