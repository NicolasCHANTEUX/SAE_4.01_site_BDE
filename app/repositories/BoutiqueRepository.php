<?php

require_once './app/core/Repository.php';

class BoutiqueRepository {
    private $repository;

    public function __construct() {
        $this->repository = Repository::getInstance();
    }

    public function getAllProduits() {
        try {
            $sql = "SELECT * FROM produits ORDER BY id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}