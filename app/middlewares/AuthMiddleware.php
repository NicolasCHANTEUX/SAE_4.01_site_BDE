<?php

require_once './app/entities/User.php';

class AuthMiddleware {
    public static function isAuthenticated() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header('Location: /connexion.php');
            exit();
        }
    }

    public static function requireRole($role) {
        self::requireAuth();
        
        // Récupérer l'utilisateur depuis la session
        $user = unserialize($_SESSION['user']);
        
        if ($user->getRole() !== $role) {
            header('Location: /acces-refuse.php');
            exit();
        }
    }
}
