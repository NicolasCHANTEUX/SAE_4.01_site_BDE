<?php

require_once './app/core/Repository.php';

class ProduitRepository {
    private $repository;

    public function __construct() {
        $this->repository = Repository::getInstance();
    }

    public function findById($id) {
        try {
            $sql = "SELECT * FROM produits WHERE id = :id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}