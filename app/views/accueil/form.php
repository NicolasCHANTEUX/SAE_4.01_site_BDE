<?php
require_once 'app/views/template/header.php';
?>

<form method="POST" action="article_create.php" class="container mt-5">
    <h1 class="mb-4">Création d'un article</h1>

    <!-- Erreurs -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?=$error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Titre -->
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" name="titre" id="titre" class="form-control"
               value="<?= $data['titre'] ?? ''; ?>" required>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?= $data['description'] ?? ''; ?></textarea>
    </div>

    <!-- Date Création -->
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="date_creation" id="date_creation" class="form-control"><?=$data['date_creation'] ?? ''; ?>
    </div>

    <!-- Bouton -->
    <button type="submit" class="btn btn-primary">Créer</button>
</form>


<?php require_once 'app/views/template/footer.php'; ?>
