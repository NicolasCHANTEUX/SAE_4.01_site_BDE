<?php

require_once './app/core/Controller.php';

class QuestionsFrequentesController extends Controller
{
	public function index()
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		$this->view('/questionsFrequentes.php', [
			'title' => 'Questions Fréquentes - BDE',
		]);
	}
}