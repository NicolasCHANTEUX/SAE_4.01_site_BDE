<?php
require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';


class AuthController extends Controller {
    use FormTrait;

    public function login() {
        $authService = new AuthService();

        // Récupérer les données POST nettoyées
        $postData = $this->getAllPostParams();

        // Si aucune donnée n'est envoyée en POST ou si la connexion échoue, afficher le formulaire
        if (empty($postData) || !$authService->login($this->getPostParam('email'), $this->getPostParam('password'))) {

            $data= empty($postData) ? []:['error'=>'Email ou mot de passe invalide'];// si des données existent, elles ne sont pas valide

            $this->view('connexion/connexion.php',['Authentification',$data]); // Affiche la vue login.php
        } else {
            // Rediriger vers la page d'accueil après connexion réussie
            $this->redirectTo('index.php');
        }
    }

   
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';

            // Validation
            if (empty($email) || empty($password) || empty($nom) || empty($prenom)) {
                $_SESSION['error'] = 'Tous les champs sont requis';
                return $this->view('creerCompte/creerCompte.php', ['error' => 'Tous les champs sont requis']);
            }

            // Vérifier si l'email existe déjà
            if ($this->userRepository->findByEmail($email)) {
                $_SESSION['error'] = 'Cet email est déjà utilisé';
                return $this->view('creerCompte/creerCompte.php', ['error' => 'Cet email est déjà utilisé']);
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
                $_SESSION['success'] = 'Compte créé avec succès';
                header('Location: /connexion.php');
                exit();
            } else {
                $_SESSION['error'] = 'Erreur lors de la création du compte';
                return $this->view('creerCompte/creerCompte.php', ['error' => 'Erreur lors de la création du compte']);
            }
        }

        return $this->view('creerCompte/creerCompte.php');
    }
}