<?php

require_once './app/core/Controller.php';
require_once './app/repositories/BoutiqueRepository.php';
require_once './app/repositories/CommandeRepository.php';

class BoutiqueController extends Controller
{

	private $BoutiqueRepository;
	private $CommandeRepository;
	public function __construct()
	{
		$this->BoutiqueRepository = new BoutiqueRepository();
		$this->CommandeRepository = new CommandeRepository();
	}
	public function index() {
		$produits = $this->BoutiqueRepository->getAllProduits();
		$commandes = $this->CommandeRepository->findAll();
		
		$this->view('boutique/form.php', [
			'title' => 'Gestion des produits',
			'produits' => $produits,
			'commandes' => $commandes
		]);
	}
	
	public function getCommande() {
		header('Content-Type: application/json');
		if (isset($_GET['id'])) {
			$details = $this->CommandeRepository->getCommandeDetails($_GET['id']);
			echo json_encode($details);
		}
		exit;
	}
	
	public function validateCommande() {
		header('Content-Type: application/json');
		$data = json_decode(file_get_contents('php://input'), true);
		
		if ($this->CommandeRepository->updateStatus($data['id'], 'validee')) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Erreur lors de la validation']);
		}
		exit;
	}

	public function ajouterAuPanier() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['user_id'])) {
			http_response_code(401);
			echo json_encode(['error' => 'Utilisateur non connecté']);
			return;
		}

		$produit_id = $_POST['produit_id'] ?? null;
		$quantite = $_POST['quantite'] ?? null;
		$taille = $_POST['taille'] ?? null;
		$couleur = $_POST['couleur'] ?? null;

		if (!$produit_id || !$quantite) {
			http_response_code(400);
			echo json_encode(['error' => 'Données manquantes']);
			return;
		}

		// Vérifier le stock
		if (!$this->BoutiqueRepository->verifierStock($produit_id, $quantite)) {
			http_response_code(400);
			echo json_encode(['error' => 'Stock insuffisant']);
			return;
		}

		// Créer ou récupérer la commande en cours
		if (!isset($_SESSION['panier_id'])) {
			$panier_id = $this->PanierRepository->creerCommande($_SESSION['user_id']);
			$_SESSION['panier_id'] = $panier_id;
		}

		// Ajouter le produit au panier
		$produit = $this->BoutiqueRepository->getProduitById($produit_id);
		$success = $this->PanierRepository->ajouterLigneCommande(
			$_SESSION['panier_id'],
			$produit_id,
			$quantite,
			$taille,
			$couleur,
			$produit['prix']
		);

		if ($success) {
			echo json_encode(['success' => true]);
		} else {
			http_response_code(500);
			echo json_encode(['error' => 'Erreur lors de l\'ajout au panier']);
		}
	}
}