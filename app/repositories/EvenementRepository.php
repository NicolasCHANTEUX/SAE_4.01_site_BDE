<?php

require_once './app/core/Repository.php';

class EvenementRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $query = 'SELECT * FROM evenement ORDER BY date_evenement ASC';
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array {
        $query = 'SELECT * FROM evenement WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool {
        $query = 'INSERT INTO evenement (titre, description, date_evenement, createur_id, prix, max_participants, chemin_image)
                 VALUES (:titre, :description, :date_evenement, :createur_id, :prix, :max_participants, :chemin_image)';
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
	}

    public function update(array $data): bool {
        $query = 'UPDATE evenement 
                 SET titre = :titre, 
                     description = :description, 
                     date_evenement = :date_evenement,
                     prix = :prix,
                     max_participants = :max_participants,
                     nb_inscrits = :nb_inscrits,
                     chemin_image = :chemin_image
                 WHERE id = :id';
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $query = 'DELETE FROM evenement WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}