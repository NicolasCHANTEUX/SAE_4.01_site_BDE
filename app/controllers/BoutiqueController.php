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
}