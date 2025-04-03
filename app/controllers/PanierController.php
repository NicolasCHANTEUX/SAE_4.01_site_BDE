<?php
require_once './app/core/Controller.php';
require_once './app/repositories/PanierRepository.php';

class PanierController extends Controller {
	public function index() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['panier'])) {
			$_SESSION['panier'] = [];
		}

		$this->view('/boutique/panier.php', [
			'title' => 'Panier - BDE'
		]);
	}

	public function ajouterProduit() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['panier'])) {
			$_SESSION['panier'] = [];
		}

		$data = json_decode(file_get_contents('php://input'), true);
		
		// Vérifier si le produit existe déjà dans le panier avec les mêmes options
		$existingIndex = $this->findExistingProduct($data);
		
		if ($existingIndex !== false) {
			// Incrémenter la quantité si le produit existe déjà
			$_SESSION['panier'][$existingIndex]['quantite']++;
		} else {
			// Ajouter le nouveau produit
			$_SESSION['panier'][] = [
				'id' => $data['produitId'],
				'nom' => $data['nom'],
				'prix' => $data['prix'],
				'image' => $data['image'],
				'quantite' => $data['quantite'],
				'taille' => $data['taille'],
				'couleur' => $data['couleur']
			];
		}

		return ['success' => true, 'message' => 'Produit ajouté au panier'];
	}

	private function findExistingProduct($newProduct) {
		foreach ($_SESSION['panier'] as $index => $item) {
			if ($item['id'] === $newProduct['produitId'] && 
				$item['taille'] === $newProduct['taille'] && 
				$item['couleur'] === $newProduct['couleur']) {
				return $index;
			}
		}
		return false;
	}

	public function supprimerProduit() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		header('Content-Type: application/json');
		
		$data = json_decode(file_get_contents('php://input'), true);
		$index = $data['index'];
	
		if (isset($_SESSION['panier'][$index])) {
			unset($_SESSION['panier'][$index]);
			$_SESSION['panier'] = array_values($_SESSION['panier']); // Reindex array
			echo json_encode(['success' => true, 'message' => 'Produit supprimé du panier']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Produit non trouvé']);
		}
		exit();
	}

	public function modifierQuantite() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		header('Content-Type: application/json');
		
		try {
			$data = json_decode(file_get_contents('php://input'), true);
			
			if (!isset($data['index']) || !isset($data['quantite'])) {
				throw new Exception('Données manquantes');
			}
			
			$index = $data['index'];
			$quantite = max(1, intval($data['quantite']));
			
			if (!isset($_SESSION['panier'][$index])) {
				throw new Exception('Produit non trouvé');
			}
			
			$_SESSION['panier'][$index]['quantite'] = $quantite;
			
			echo json_encode([
				'success' => true,
				'quantite' => $quantite,
				'total' => $_SESSION['panier'][$index]['prix'] * $quantite
			]);
			
		} catch (Exception $e) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => $e->getMessage()
			]);
		}
		exit();
	}

	public function envoyerCommande() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		header('Content-Type: application/json');

		if (!isset($_SESSION['user_id'])) {
			echo json_encode([
				'success' => false,
				'message' => 'Vous devez être connecté pour commander'
			]);
			exit;
		}

		if (empty($_SESSION['panier'])) {
			echo json_encode([
				'success' => false,
				'message' => 'Votre panier est vide'
			]);
			exit;
		}

		$panierRepo = new PanierRepository();
		if ($panierRepo->envoyerCommande($_SESSION['user_id'])) {
			$_SESSION['panier'] = [];
			echo json_encode([
				'success' => true,
				'message' => 'Commande envoyée avec succès'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Erreur lors de l\'envoi de la commande'
			]);
		}
		exit;
	}
}