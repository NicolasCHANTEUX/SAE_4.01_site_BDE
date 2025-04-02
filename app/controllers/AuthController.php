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
            $error = '';

            if (empty($email) || empty($password)) {
                $error = 'Tous les champs sont requis';
            }
            else {
                $user = $this->userRepository->findByEmail($email);
                
                if ($user === null || !password_verify($password, $user['mot_de_passe'])) {
                    $error = 'Email ou mot de passe incorrect';
                }
                else {
                    if(session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_prenom'] = $user['prenom'];  // Ajout du prénom
                    $_SESSION['user_nom'] = $user['nom'];        // Ajout du nom aussi
                    $_SESSION['user_role'] = $user['role'];      // Ajout du rôle
                    $_SESSION['user_email'] = $user['email'];    // Ajout de l'email

                    return $this->redirectTo('index.php');
                }
            }
        }
        $_SESSION['user_id'] = $user['id'];
		
		return $this->redirectTo('index.php');
				}
			}
        }
	

        $this->view('connexion/connexion.php', ['error' => $error]);
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