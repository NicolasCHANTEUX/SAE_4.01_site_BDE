<?php
require_once 'app/views/template/header.php';
?>

<link rel="stylesheet" href="/assets/css/accueilAdmin.css">
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
            <th scope="col">Date_Creation</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article['id'] ?></td>
            <td><?= $article['titre'] ?></td>
            <td><?= $article['description'] ?></td>
            <td><?= $article['date_creation'] ?></td>
            <td>
                <a href="article_update.php?id=<?= $article->getId() ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                <a href="article_delete.php?id=<?= $article->getId() ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="d-flex flex-row-reverse">
    <a href="article_create.php" class="btn btn-success">
        <i class="fa fa-plus"></i> Ajouter un article
    </a>
</div>
<?php require_once 'app/views/template/footer.php'; ?>

