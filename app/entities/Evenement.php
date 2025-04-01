<?php

class Evenement {
    public function __construct(
        private int $id,
        private string $titre,
        private string $description,
        private string $date_evenement,
        private ?int $createur_id,
        private string $date_creation,
        private float $prix,
        private ?int $max_participants,
        private int $nb_inscrits,
		private ?string $chemin_image
    ) {}

    // Getters
    public function getId(): int { return $this->id; }
    public function getTitre(): string { return $this->titre; }
    public function getDescription(): string { return $this->description; }
    public function getDateEvenement(): string { return $this->date_evenement; }
    public function getCreateurId(): ?int { return $this->createur_id; }
    public function getDateCreation(): string { return $this->date_creation; }
    public function getPrix(): float { return $this->prix; }
    public function getMaxParticipants(): ?int { return $this->max_participants; }
    public function getNbInscrits(): int { return $this->nb_inscrits; }
	public function getCheminImage(): ?string { return $this->chemin_image; }

    // Setters
    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setDateEvenement(string $date): void { $this->date_evenement = $date; }
    public function setPrix(float $prix): void { $this->prix = $prix; }
    public function setMaxParticipants(?int $max): void { $this->max_participants = $max; }
    public function setNbInscrits(int $nb): void { $this->nb_inscrits = $nb; }
	public function setCheminImage(?string $chemin): void { $this->chemin_image = $chemin; }
}