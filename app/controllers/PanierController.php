<?php
require_once './app/core/Controller.php';

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
}