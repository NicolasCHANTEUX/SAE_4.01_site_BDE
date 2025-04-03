<?php

class Article {
    public function __construct(
        private ?int    $id,
        private string $titre,
        private string $description,
        private ?string $date_creation,
    ) {}

    // Getters
    public function getId():           int    { return $this->id;            }
    public function getTitre():        string { return $this->titre;         }
    public function getDescription():  string { return $this->description;   }
    public function getDateCreation(): ?string { return $this->date_creation; }

    // Setters
    public function setTitre(string $titre):             void { $this->titre = $titre;             }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setDateCreation(string $date):       void { $this->date_creation = $date;      }
}