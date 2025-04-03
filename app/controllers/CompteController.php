<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../repositories/CommandeRepository.php';

class CompteController extends Controller
{
    private $commandeRepository;

    public function __construct() {
        try {
            parent::__construct();
            $this->commandeRepository = new CommandeRepository();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function index()
    {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            // Vérification que l'utilisateur est connecté
            if (!isset($_SESSION['user_id'])) {
                header('Location: /connexion.php');
                exit();
            }

            // Récupération de l'historique des commandes
            $historique = $this->commandeRepository->findByUserId($_SESSION['user_id']);

            $this->view('/compte.php', [
                'title' => 'Mon Compte - BDE',
                'historique' => $historique,
                'error' => ''
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->view('/compte.php', [
                'title' => 'Mon Compte - BDE',
                'historique' => [],
                'error' => "Une erreur est survenue lors de la récupération de vos données"
            ]);
        }
    }

    public function updateProfile($data) 
    {
        try {
            // Validation des données
            if (empty($data['email']) || empty($data['nom']) || empty($data['prenom'])) {
                return [
                    'success' => false,
                    'message' => 'Tous les champs sont obligatoires'
                ];
            }

            // Validation de l'email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Adresse email invalide'
                ];
            }

            // TODO: Ajouter la logique de mise à jour du profil

            return [
                'success' => true,
                'message' => 'Profil mis à jour avec succès'
            ];

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du profil'
            ];
        }
    }

    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return [
                'success' => false,
                'message' => 'Méthode non autorisée'
            ];
        }

        try {
            $currentPassword = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            // Validations
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                return [
                    'success' => false,
                    'message' => 'Tous les champs sont obligatoires'
                ];
            }

            if ($newPassword !== $confirmPassword) {
                return [
                    'success' => false,
                    'message' => 'Les nouveaux mots de passe ne correspondent pas'
                ];
            }

            // Vérifier l'ancien mot de passe
            if (!$this->userRepository->verifyPassword($_SESSION['user_id'], $currentPassword)) {
                return [
                    'success' => false,
                    'message' => 'Mot de passe actuel incorrect'
                ];
            }

            // Mettre à jour le mot de passe
            $success = $this->userRepository->updatePassword($_SESSION['user_id'], password_hash($newPassword, PASSWORD_DEFAULT));

            if ($success) {
                return [
                    'success' => true,
                    'message' => 'Mot de passe modifié avec succès'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erreur lors de la modification du mot de passe'
            ];

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue'
            ];
        }
    }

    public function deleteAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return [
                'success' => false,
                'message' => 'Méthode non autorisée'
            ];
        }

        try {
            $password = $_POST['confirmPassword'] ?? '';

            if (empty($password)) {
                return [
                    'success' => false,
                    'message' => 'Le mot de passe est requis'
                ];
            }

            // Vérifier le mot de passe
            if (!$this->userRepository->verifyPassword($_SESSION['user_id'], $password)) {
                return [
                    'success' => false,
                    'message' => 'Mot de passe incorrect'
                ];
            }

            // Supprimer le compte
            $success = $this->userRepository->deleteAccount($_SESSION['user_id']);

            if ($success) {
                // Déconnecter l'utilisateur
                session_destroy();
                return [
                    'success' => true,
                    'message' => 'Votre compte a été supprimé avec succès',
                    'redirect' => '/index.php'
                ];
            }

            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression du compte'
            ];

        } catch (Exception $e) {
            error_log($e->getMessage());
            return [
                'success' => false,
                'message' => 'Une erreur est survenue'
            ];
        }
    }
}