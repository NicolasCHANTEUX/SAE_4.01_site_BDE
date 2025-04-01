<?php

class Evenement {

	public function __construct(
		private int    $id,
		private string $name,
		private string $description,
		private string $date,
		private string $image,
		private string $place,
		private int    $price,)
	{}

	public function getId(): int
	{
		return $this->id;
	}
	public function getName(): string
	{
		return $this->name;
	}
	public function getDescription(): string
	{
		return $this->description;
	}
	public function getDate(): string
	{
		return $this->date;
	}
	public function getImage(): string
	{
		return $this->image;
	}
	public function getPlace(): string
	{
		return $this->place;
	}
	public function getPrice(): int
	{
		return $this->price;
	}
	
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function setName(string $name): void
	{
		$this->name = $name;
	}
	public function setDescription(string $description): void
	{
		$this->description = $description;
	}
	public function setDate(string $date): void
	{
		$this->date = $date;
	}
	public function setImage(string $image): void
	{
		$this->image = $image;
	}
	public function setPlace(string $place): void
	{
		$this->place = $place;
	}
	public function setPrice(int $price): void
	{
		$this->price = $price;
	}

}