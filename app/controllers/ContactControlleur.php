<?php

namespace app\controllers;

use app\service\Database;

class ContactController {
	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function index() {
		// Afficher la page de contact
		$socialLinks = $this->getSocialLinks();
		require_once 'Views/contact.view.php';
	}

	public function handleContact($data) {
		// Validation des données
		if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['demande'])) {
			return [
				'success' => false,
				'message' => 'Tous les champs sont obligatoires'
			];
		}

		// Validation de l'email
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return [
				'success' => false,
				'message' => 'Adresse email invalide'
			];
		}

		try {
			// Insertion dans la base de données
			$sql = "INSERT INTO contacts (nom, prenom, email, demande, date_creation) 
					VALUES (:nom, :prenom, :email, :demande, NOW())";
			
			$stmt = $this->db->getPDO()->prepare($sql);
			$stmt->execute([
				'nom' => htmlspecialchars($data['nom']),
				'prenom' => htmlspecialchars($data['prenom']),
				'email' => $data['email'],
				'demande' => htmlspecialchars($data['demande'])
			]);

			return [
				'success' => true,
				'message' => 'Votre message a bien été envoyé'
			];

		} catch (\PDOException $e) {
			return [
				'success' => false,
				'message' => 'Une erreur est survenue lors de l\'envoi du message'
			];
		}
	}

	private function getSocialLinks() {
		return [
			'email' => 'contact@bde-iut.fr',
			'discord' => 'https://discord.gg',
			'instagram' => 'https://instagram.com'
		];
	}
}