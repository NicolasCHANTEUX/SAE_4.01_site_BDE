<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/repositories/BoutiqueRepository.php';
require_once './app/services/AuthService.php';

class BoutiqueAdminController extends Controller {
    use FormTrait;

    private $boutiqueRepository;

    public function __construct() {
        $this->boutiqueRepository = new BoutiqueRepository();
    }

    public function index() {
        //$this->checkAuth();
        $produits = $this->boutiqueRepository->getAllProduits();
        
        $this->view('boutique/form.php', [
            'title' => 'Gestion des produits',
            'produits' => $produits
        ]);
    }

    public function create() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$produitData = [
				'nom' => $_POST['nom'] ?? '',
				'description' => $_POST['description'] ?? '',
				'prix' => $_POST['prix'] ?? 0,
				'stock' => $_POST['stock'] ?? 0,
				'tailles' => $_POST['tailles'] ?? [],
				'couleurs' => $_POST['couleurs'] ?? [],
				'image' => $_FILES['image'] ?? null
			];
			
			if ($this->boutiqueRepository->create($produitData)) {
				header('Location: /boutiqueAdmin.php?success=create');
			} else {
				header('Location: /boutiqueAdmin.php?error=create');
			}
			exit;
		}
	}
	
	public function update() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$produitData = [
				'id' => $_POST['product_id'] ?? null,
				'nom' => $_POST['nom'] ?? '',
				'description' => $_POST['description'] ?? '',
				'prix' => $_POST['prix'] ?? 0,
				'stock' => $_POST['stock'] ?? 0,
				'tailles' => $_POST['tailles'] ?? [],
				'couleurs' => $_POST['couleurs'] ?? [],
				'image' => $_FILES['image'] ?? null
			];
			
			if ($this->boutiqueRepository->update($produitData)) {
				header('Location: /boutiqueAdmin.php?success=update');
			} else {
				header('Location: /boutiqueAdmin.php?error=update');
			}
			exit;
		}
	}
	
	public function delete() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
			$id = (int)$_POST['product_id'];
			
			if ($this->boutiqueRepository->delete($id)) {
				header('Location: /boutiqueAdmin.php?success=delete');
			} else {
				header('Location: /boutiqueAdmin.php?error=delete');
			}
			exit;
		}
	}

    //methode
    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('connexion.php');
        }
    }
}