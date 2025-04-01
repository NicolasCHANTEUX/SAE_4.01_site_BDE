<?php

require_once './app/core/Controller.php';

class BoutiqueController extends Controller
{
	public function index()
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		$this->view('/boutique/boutique.php', [
			'title' => 'Boutique - BDE',
		]);
	}
}