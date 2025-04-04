<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/services/AuthService.php';

class EvenementAdminController extends Controller {
    use FormTrait;

    private $evenementRepository;

    public function __construct() {
        $this->evenementRepository = new EvenementRepository();
    }

    public function index() {
        $this->checkAuth();
        $evenements = $this->evenementRepository->findAll();
        
        $this->view('evenement/form.php', [
            'title' => 'Gestion des événements',
            'evenements' => $evenements
        ]);
    }

    public function create() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'titre' => $_POST['titre'] ?? '',
                'description' => $_POST['description'] ?? '',
                'date_evenement' => $_POST['date_evenement'] ?? '',
                'prix' => $_POST['prix'] ?? 0,
                'max_participants' => $_POST['max_participants'] ?? null,
                'image' => $_FILES['image'] ?? null
            ];
            
            $this->evenementRepository->create($eventData);
            $this->redirectTo('evenementAdmin.php');
        }
    }

    public function update() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'event_id' => $_POST['event_id'] ?? null,
                'titre' => $_POST['titre'] ?? '',
                'description' => $_POST['description'] ?? '',
                'date_evenement' => $_POST['date_evenement'] ?? '',
                'prix' => $_POST['prix'] ?? 0,
                'max_participants' => $_POST['max_participants'] ?? null,
                'image' => $_FILES['image'] ?? null
            ];
            
            $this->evenementRepository->update($eventData);
            $this->redirectTo('evenementAdmin.php');
        }
    }

    public function delete() {
        $this->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
            $eventId = (int)$_POST['event_id'];
            $this->evenementRepository->delete($eventId);
            $this->redirectTo('evenementAdmin.php');
        }
    }

    
    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('connexion.php');
        }
        if ($auth->getUser()->getRole() !== 'admin') {
            $this->redirectTo('index.php');
        }
    }
}