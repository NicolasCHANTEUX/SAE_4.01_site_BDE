<?php

require_once './app/core/Controller.php';
require_once './app/repositories/BoutiqueRepository.php';

class BoutiqueController extends Controller
{

	private $BoutiqueRepository;
	public function __construct()
	{
		$this->BoutiqueRepository = new BoutiqueRepository();
	}
	public function index()
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		$produits = $this->BoutiqueRepository->getAllProduits();

		$this->view('boutique/boutique.php', [
			'title' => 'Boutique - BDE',
			'produits' => $produits,
		]);
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