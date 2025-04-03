<?php
// filepath: /home/etudiant/vm231606/TP/s4/s4.01_dev_application/SAE_4.01_site_BDE/boutiqueAdmin.php
require_once './app/controllers/BoutiqueAdminController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifier l'authentification


$controller = new BoutiqueAdminController();

// Router les actions
$action = $_GET['action'] ?? 'index';

switch ($action) {
	case 'create':
		$controller->create();
		break;
	case 'update':
		$controller->update();
		break;
	case 'delete':
		error_log("Delete action requested");
		error_log("POST data: " . print_r($_POST, true));
		$controller->delete();
		break;
	case 'get':
		if (isset($_GET['id'])) {
			header('Content-Type: application/json');
			echo json_encode($controller->get((int)$_GET['id']));
			exit;
		}
		break;
	default:
		$controller->index();
		break;
}