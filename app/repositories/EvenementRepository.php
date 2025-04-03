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

    public function create(array $data): bool {
        try {
            // Gestion de l'upload de l'image
            $cheminImage = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $nomFichier = uniqid() . '.' . $extension;
                $cheminImage = 'assets/images/events/' . $nomFichier;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage)) {
                    throw new Exception('Erreur lors du téléchargement de l\'image');
                }
            }

            $query = 'INSERT INTO evenement (
                titre, 
                description, 
                date_evenement, 
                prix, 
                max_participants,
                nb_inscrits,
                chemin_image
            ) VALUES (
                :titre, 
                :description, 
                :date_evenement, 
                :prix, 
                :max_participants,
                0,
                :chemin_image
            )';
            
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([
                'titre' => $data['titre'],
                'description' => $data['description'],
                'date_evenement' => $data['date_evenement'],
                'prix' => $data['prix'],
                'max_participants' => empty($data['max_participants']) ? null : $data['max_participants'],
                'chemin_image' => $cheminImage
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    public function addParticipant(int $evenementId, int $userId): bool {
        try {
            $this->pdo->beginTransaction();
    
            // Vérifier si l'utilisateur est déjà inscrit
            $checkQuery = 'SELECT COUNT(*) FROM inscription_evenement 
                          WHERE evenement_id = :evenement_id 
                          AND utilisateur_id = :utilisateur_id';
            $checkStmt = $this->pdo->prepare($checkQuery);
            $checkStmt->execute([
                'evenement_id' => $evenementId,
                'utilisateur_id' => $userId
            ]);
            
            if ($checkStmt->fetchColumn() > 0) {
                throw new Exception('Vous êtes déjà inscrit à cet événement');
            }
    
            $query = 'INSERT INTO inscription_evenement (evenement_id, utilisateur_id, nb_participants) 
                     VALUES (:evenement_id, :utilisateur_id, 1)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'evenement_id' => $evenementId,
                'utilisateur_id' => $userId
            ]);

            $updateQuery = 'UPDATE evenement 
                           SET nb_inscrits = nb_inscrits + 1 
                           WHERE id = :id';
            $updateStmt = $this->pdo->prepare($updateQuery);
            $updateStmt->execute(['id' => $evenementId]);
    
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function create(array $data): bool {
        $query = 'INSERT INTO evenement (titre, description, date_evenement, createur_id, prix, max_participants, chemin_image)
                 VALUES (:titre, :description, :date_evenement, :createur_id, :prix, :max_participants, :chemin_image)';
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
	}

    public function update(array $data): bool {
        try {
            // Gestion de l'upload de la nouvelle image
            $cheminImage = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $nomFichier = uniqid() . '.' . $extension;
                $cheminImage = 'assets/images/events/' . $nomFichier;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage)) {
                    throw new Exception('Erreur lors du téléchargement de l\'image');
                }
            }

            // Construction de la requête en fonction de la présence ou non d'une nouvelle image
            $query = 'UPDATE evenement SET 
                titre = :titre,
                description = :description,
                date_evenement = :date_evenement,
                prix = :prix,
                max_participants = :max_participants' .
                ($cheminImage ? ', chemin_image = :chemin_image' : '') .
                ' WHERE id = :id';

            $params = [
                'id' => $data['event_id'],
                'titre' => $data['titre'],
                'description' => $data['description'],
                'date_evenement' => $data['date_evenement'],
                'prix' => $data['prix'],
                'max_participants' => empty($data['max_participants']) ? null : $data['max_participants']
            ];

            if ($cheminImage) {
                $params['chemin_image'] = $cheminImage;
            }

            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            // Supprimer d'abord l'image associée si elle existe
            $query = 'SELECT chemin_image FROM evenement WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result['chemin_image'] && file_exists($result['chemin_image'])) {
                unlink($result['chemin_image']);
            }

            // Supprimer les inscriptions associées
            $query = 'DELETE FROM inscription_evenement WHERE evenement_id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);

            // Supprimer l'événement
            $query = 'DELETE FROM evenement WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}