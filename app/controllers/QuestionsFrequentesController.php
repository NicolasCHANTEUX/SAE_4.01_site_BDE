<?php

require_once './app/core/Controller.php';
require_once './app/repositories/QuestionsFrequentesRepository.php';

class QuestionsFrequentesController extends Controller
{
	private $QuestionsFrequentesRepository;
	public function __construct()
	{
		$this->QuestionsFrequentesRepository = new QuestionsFrequentesRepository();
	}

	public function index()
	{
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		$questionsFrequentes = $this->QuestionsFrequentesRepository->getAllQuestions();

		$this->view('questionsFrequentes.php', [
			'title' => 'Questions Fréquentes - BDE',
			'questionsFrequentes' => $questionsFrequentes,
		]);
	}
}