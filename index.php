<?php
require_once './app/controllers/AccueilController.php';
require_once './app/controllers/PanierController.php';

$url = $_SERVER['REQUEST_URI'];

if (strpos($url, '/panier/modifierQuantite') === 0) {
    (new PanierController())->modifierQuantite();
} elseif (strpos($url, '/panier/supprimer') === 0) {
    (new PanierController())->supprimerProduit();
} elseif (strpos($url, '/panier/envoyerCommande') === 0) {
    (new PanierController())->envoyerCommande();
} else {
    (new AccueilController())->index();
}