<?php

require_once './app/core/Repository.php';
require_once './app/entities/Evenement.php';

class EvenementRepository {
	private $pdo;

	public function __construct() {
		$this->pdo = Repository::getInstance()->getPDO();
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
			'name' => $evenement->getName(),
			'description' => $evenement->getDescription(),
			'date' => $evenement->getDate(),
			'image' => $evenement->getImage(),
			'place' => $evenement->getPlace(),
			'price' => $evenement->getPrice()
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

