<?php

require_once './app/core/Controller.php';

class PanierController extends Controller
{
	public function index()
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		$this->view('/boutique/panier.php', [
			'title' => 'Panier - BDE',
		]);
	}
}