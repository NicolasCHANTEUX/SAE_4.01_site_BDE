<?php

require_once './config/config.php';

class Repository {
    private static $instance = null;  // Instance unique de la classe
    private $pdo;

    // Le constructeur est maintenant privé pour empêcher une instanciation directe
    private function __construct() {
        try {
            $this->pdo = new PDO(
                "pgsql:host=" . DB_HOST . 
                ";port=" . DB_PORT . 
                ";dbname=" . DB_NAME . 
                ";user=" . DB_USER . 
                ";password=" . DB_PASS,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            error_log("Erreur de connexion : " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données");
        }
    }

    // Méthode pour obtenir l'instance unique de la classe (Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Repository();
        }
        return self::$instance;
    }

    // Méthode pour obtenir la connexion PDO
    public function getPDO() {
        return $this->pdo;
    }

    // Empêche le clonage de l'objet
    private function __clone() {}

}
