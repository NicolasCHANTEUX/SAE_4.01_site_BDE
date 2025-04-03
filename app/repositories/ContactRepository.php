<?php

require_once './app/core/Repository.php';

class ContactRepository {
    private $repository;

    public function __construct() {
        $this->repository = Repository::getInstance();
    }

    public function creerContact($data) {
        try {
            $sql = "INSERT INTO contacts (nom, prenom, email, message, date_envoi) 
                    VALUES (:nom, :prenom, :email, :message, NOW())";
            
            $stmt = $this->repository->getPDO()->prepare($sql);
            return $stmt->execute([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'message' => $data['demande']  // changé ici
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
