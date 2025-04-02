<?php
require_once './app/core/Controller.php';
require_once './app/repositories/ProduitRepository.php';

class ProduitController extends Controller {
    private $produitRepository;

    public function __construct() {
        $this->produitRepository = new ProduitRepository();
    }

    public function index($id = null) {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($id === null) {
            header('Location: /boutique.php');
            exit;
        }

        $produit = $this->produitRepository->findById($id);

        if (!$produit) {
            header('Location: /boutique.php');
            exit;
        }

        $this->view('/boutique/produit.php', [
            'title' => $produit['nom'] . ' - BDE',
            'produit' => $produit
        ]);
    }
}