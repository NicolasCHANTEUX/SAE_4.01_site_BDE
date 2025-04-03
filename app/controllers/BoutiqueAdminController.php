<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/repositories/BoutiqueRepository.php';
require_once './app/repositories/CommandeRepository.php';
require_once './app/services/AuthService.php';

class BoutiqueAdminController extends Controller {
    use FormTrait;

    private $boutiqueRepository;
    private $commandeRepository;

    public function __construct() {
        $this->boutiqueRepository = new BoutiqueRepository();
        $this->commandeRepository = new CommandeRepository();
    }

    public function index() {
        //$this->checkAuth();
        $produits = $this->boutiqueRepository->getAllProduits();
        $commandes = $this->commandeRepository->findAll();
        
        $this->view('boutique/form.php', [
            'title' => 'Gestion des produits',
            'produits' => $produits,
            'commandes' => $commandes
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

    public function reglerCommande() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if ($this->commandeRepository->updateStatus($data['id'], 'reglee')) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
            }
        }
        exit;
    }

    public function supprimerCommande() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if ($this->commandeRepository->deleteCommande($data['id'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
            }
        }
        exit;
    }

    public function getCommande() {
        if (isset($_GET['id'])) {
            $commande = $this->commandeRepository->findById($_GET['id']);
            if ($commande) {
                header('Content-Type: application/json');
                echo json_encode($commande);
                exit;
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Commande non trouvée']);
        exit;
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('connexion.php');
        }
    }
}