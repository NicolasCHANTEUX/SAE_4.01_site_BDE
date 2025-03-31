<?php

require_once 'autoload.php';

use app\controllers\ContactController;

$controller = new ContactController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$result = $controller->handleContact($_POST);
	echo json_encode($result);
	exit;
}

$controller->index();