<?php

class User {
    public function __construct(
        private ?int $id,
        private string $email,
        private string $password,
        private string $nom,
        private string $prenom,
        private string $role = 'membre',
        private ?string $date_creation = null
    ) {}

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getRole(): string { return $this->role; }
    public function getDateCreation(): ?string { return $this->date_creation; }

    // Setters avec validation
    public function setEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email invalide');
        }
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Le mot de passe doit faire au moins 8 caractères');
        }
        $this->password = $password;
    }

    public function setRole(string $role): void {
        $validRoles = ['membre', 'adherent', 'admin'];
        if (!in_array($role, $validRoles)) {
            throw new InvalidArgumentException('Rôle invalide');
        }
        $this->role = $role;
    }
}