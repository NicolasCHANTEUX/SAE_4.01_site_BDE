<?php
require_once './app/controllers/AccueilAdminController.php';
require_once './app/middlewares/AuthMiddleware.php';

// Vérifie si un ID a été transmis via l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // Récupère et sécurise l'ID
    $articleService = new ArticleService();

    // Appelle la méthode pour supprimer l'article
    if ($articleService->supprimerArticle($id)) {
        exit;
    } else {
        echo "Erreur : impossible de supprimer l'article.";
    }
} else {
    echo "Erreur : aucun ID valide fourni.";
}
?>