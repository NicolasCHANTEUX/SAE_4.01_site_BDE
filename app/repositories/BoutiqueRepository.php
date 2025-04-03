<?php
require_once './app/core/Repository.php';

class BoutiqueRepository {
    private $pdo;
    // Change this line to match events pattern
    private $uploadDir = 'assets/images/products/';

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    private function handleImageUpload(): ?string {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Create directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $nomFichier = uniqid() . '.' . $extension;
        $cheminImage = $this->uploadDir . $nomFichier;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage)) {
            throw new Exception('Erreur lors du téléchargement de l\'image');
        }

        return $cheminImage;
    }

    private function deleteImage(?string $path): void {
        if ($path && file_exists($path)) {
            unlink($path);
        }
    }

    public function create(array $data): bool {
        try {
            $this->pdo->beginTransaction();

            $cheminImage = $this->handleImageUpload();

            $query = 'INSERT INTO produits (nom, description, prix, stock, taille, couleurs, chemin_image) 
                     VALUES (:nom, :description, :prix, :stock, :taille, :couleurs, :chemin_image)';
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([
                'nom' => $data['nom'],
                'description' => $data['description'],
                'prix' => $data['prix'],
                'stock' => $data['stock'],
                'taille' => $this->formatArrayForPostgres($data['tailles']),
                'couleurs' => $this->formatArrayForPostgres($data['couleurs']),
                'chemin_image' => $cheminImage
            ]);

            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            if (isset($cheminImage)) {
                $this->deleteImage($cheminImage);
            }
            error_log($e->getMessage());
            return false;
        }
    }

    public function update(array $data): bool {
        try {
            $this->pdo->beginTransaction();

            $cheminImage = $this->handleImageUpload();

            if ($cheminImage) {
                // Delete old image
                $query = 'SELECT chemin_image FROM produits WHERE id = :id';
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['id' => $data['id']]);
                $oldImage = $stmt->fetch(PDO::FETCH_ASSOC)['chemin_image'];
                $this->deleteImage($oldImage);
            }

            $query = 'UPDATE produits SET 
                nom = :nom,
                description = :description,
                prix = :prix,
                stock = :stock,
                taille = :taille,
                couleurs = :couleurs' .
                ($cheminImage ? ', chemin_image = :chemin_image' : '') .
                ' WHERE id = :id';

            $params = [
                'id' => $data['id'],
                'nom' => $data['nom'],
                'description' => $data['description'],
                'prix' => $data['prix'],
                'stock' => $data['stock'],
                'taille' => $this->formatArrayForPostgres($data['tailles']),
                'couleurs' => $this->formatArrayForPostgres($data['couleurs'])
            ];

            if ($cheminImage) {
                $params['chemin_image'] = $cheminImage;
            }

            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute($params);

            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            if (isset($cheminImage)) {
                $this->deleteImage($cheminImage);
            }
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            $this->pdo->beginTransaction();

            $query = 'SELECT chemin_image FROM produits WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result && $result['chemin_image']) {
                $this->deleteImage($result['chemin_image']);
            }

            $query = 'DELETE FROM ligne_commande WHERE produit_id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);

            $query = 'DELETE FROM produits WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            $this->pdo->commit();
            return $result;

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log($e->getMessage());
            return false;
        }
    }

    public function findById(int $id): ?array {
        try {
            $query = 'SELECT * FROM produits WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $result['tailles'] = array_map('trim', explode(',', trim($result['taille'], '{}')));
                $result['couleurs'] = array_map('trim', explode(',', trim($result['couleurs'], '{}')));
            }
            return $result ?: null;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    private function formatArrayForPostgres(array $arr): string {
        // Remove any empty values and trim whitespace
        $arr = array_filter(array_map('trim', $arr));
        // Format as PostgreSQL array string
        return '{' . implode(',', $arr) . '}';
    }

    public function getAllProduits(): array {
        try {
            $query = "SELECT * FROM produits ORDER BY id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Convert PostgreSQL arrays to PHP arrays for each product
            foreach ($produits as &$produit) {
                $produit['tailles'] = array_map('trim', explode(',', trim($produit['taille'], '{}')));
                $produit['couleurs'] = array_map('trim', explode(',', trim($produit['couleurs'], '{}')));
            }
            
            return $produits;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}