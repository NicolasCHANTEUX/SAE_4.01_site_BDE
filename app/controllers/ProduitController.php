<?php

require_once './app/core/Controller.php';

class ProduitController extends Controller
{
	public function index($id = null)
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();
			
		 // Données d'exemple avec chemin d'image absolu
		$produit = [
			'nom' => 'Exemple de Produit',
			'description' => 'Description du produit...',
			'prix' => 19.99,
			'image' => 'assets/images/product-default.jpg' // Chemin relatif sans slash initial
		];

		$this->view('/boutique/produit.php', [
			'title' => 'Produit - BDE',
			'produit' => $produit
		]);
	}
}