<?php

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
        if ($_SESSION['user_role'] !== $role) {
            header('Location: /acces-refuse.php');
            exit();
        }
    }
}
