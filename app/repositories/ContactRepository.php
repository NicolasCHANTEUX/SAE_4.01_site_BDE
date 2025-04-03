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
                'message' => $data['demande']
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function findAll(): array {
        try {
            $sql = "SELECT * FROM contacts ORDER BY date_envoi DESC";
            $stmt = $this->repository->getPDO()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updateStatut($contactId, $statut): bool {
        try {
            $sql = "UPDATE contacts SET statut = :statut WHERE id = :id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            return $stmt->execute([
                'id' => $contactId,
                'statut' => $statut
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function findById($id) {
        try {
            $sql = "SELECT * FROM contacts WHERE id = :id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}
