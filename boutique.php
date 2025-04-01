<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/controllers/BoutiqueController.php';

$controller = new BoutiqueController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$result = $controller->handleBoutique($_POST);
	echo json_encode($result);
	exit;
}

$controller->index();