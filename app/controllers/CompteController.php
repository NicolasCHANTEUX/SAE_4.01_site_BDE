<?php

require_once './app/core/Controller.php';

class CompteController extends Controller
{
	public function index()
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		$this->view('/compte.php', [
			'title' => 'Compte - BDE',
		]);
	}
}