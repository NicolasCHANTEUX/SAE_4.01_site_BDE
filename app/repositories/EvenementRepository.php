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

	public function findAll(): array
	{
		$query = $this->pdo->query('SELECT * FROM evenement');
		$query->setFetchMode(PDO::FETCH_CLASS, Evenement::class);
		return $query->fetchAll();
	}

	public function create(Evenement $evenement): bool {
		$stmt = $this->pdo->prepare('
		INSERT INTO evenement (name, description, date, image, place, price)
		VALUES (:name, :description, :date, :image, :place, :price)
	');

		return $stmt->execute([
			'name'        => $evenement->getName(),
			'description' => $evenement->getDescription(),
			'date'        => $evenement->getDate(),
			'image'       => $evenement->getImage(),
			'place'       => $evenement->getPlace(),
			'price'       => $evenement->getPrice()
		]);
	}

	public function delete(int $id): bool {
		$stmt = $this->pdo->prepare('DELETE FROM evenement WHERE id = :id');
		return $stmt->execute(['id' => $id]);
	}
	
	public function update(Evenement $evenement): bool {
		$stmt = $this->pdo->prepare('
			UPDATE evenement
			SET name = :name, description = :description, date = :date, image = :image, place = :place, price = :price
			WHERE id = :id
		');

		return $stmt->execute([
			'id' => $evenement->getId(),
			'name' => $evenement->getName(),
			'description' => $evenement->getDescription(),
			'date' => $evenement->getDate(),
			'image' => $evenement->getImage(),
			'place' => $evenement->getPlace(),
			'price' => $evenement->getPrice()
		]);
	}

	private function createEvenementFromRow(array $row): Evenement
	{
		return new Evenement($row['id'], $row['name'], $row['description'], $row['date'], $row['image'], $row['place'], $row['price']);
	}

}

    public function delete(int $id): bool {
        $query = 'DELETE FROM evenement WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}