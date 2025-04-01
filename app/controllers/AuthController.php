<?php
require_once './app/core/Controller.php';
require_once './app/repositories/UserRepository.php';

class AuthController extends Controller {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
            }

            $user = $this->userRepository->findByEmail($email);
            if (!$user || !password_verify($password, $user['mot_de_passe'])) {
                return json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
            }

            // Démarrer la session et stocker les infos utilisateur
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            return json_encode(['success' => true, 'redirect' => '/compte.php']);
        }

        $this->view('connexion/connexion.php');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';

            // Validation
            if (empty($email) || empty($password) || empty($nom) || empty($prenom)) {
                return json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
            }

            // Vérifier si l'email existe déjà
            if ($this->userRepository->findByEmail($email)) {
                return json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
            }

            // Créer l'utilisateur
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $success = $this->userRepository->create([
                'email' => $email,
                'mot_de_passe' => $hashedPassword,
                'nom' => $nom,
                'prenom' => $prenom,
                'role' => 'membre'
            ]);

            if ($success) {
                return json_encode(['success' => true, 'redirect' => '/connexion.php']);
            }

            return json_encode(['success' => false, 'message' => 'Erreur lors de la création du compte']);
        }

        $this->view('creerCompte/creerCompte.php');
    }
}