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

    public function getProduitById($id) {
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

    public function verifierStock($produit_id, $quantite) {
        try {
            $sql = "SELECT stock FROM produits WHERE id = :id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute(['id' => $produit_id]);
            $stock = $stmt->fetch(PDO::FETCH_ASSOC)['stock'];
            return $stock >= $quantite;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}