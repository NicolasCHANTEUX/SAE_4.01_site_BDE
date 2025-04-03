<?php
require_once './app/controllers/AccueilController.php';
require_once './app/controllers/PanierController.php';
require_once './app/controllers/ContactController.php';

$url = $_SERVER['REQUEST_URI'];

if (strpos($url, '/panier/modifierQuantite') === 0) {
    (new PanierController())->modifierQuantite();
} elseif (strpos($url, '/panier/supprimer') === 0) {
    (new PanierController())->supprimerProduit();
} elseif (strpos($url, '/panier/envoyerCommande') === 0) {
    (new PanierController())->envoyerCommande();
} elseif (strpos($url, '/contact/envoyer') === 0) {
    (new ContactController())->envoyerMessage();
} else {
    (new AccueilController())->index();
}