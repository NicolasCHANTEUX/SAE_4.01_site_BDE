<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'app/middlewares/AuthMiddleware.php';
require_once 'app/entities/User.php';
?>

<?php

$isAdmin = false;
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user instanceof User) {
        $isAdmin = $user->getRole() === 'admin';
    }
}

 // Détermine la page actuelle
 $currentPage = basename($_SERVER['REQUEST_URI']);

 // Associe chaque page à son équivalent admin
$adminPages = [
    '' => 'accueilAdmin.php',
    'index.php' => 'accueilAdmin.php',
    'evenement.php' => 'evenementAdmin.php',
    'boutique.php' => 'boutiqueAdmin.php',
    'contact.php' => 'contactAdmin.php',
    'connexion.php' => 'adminConnexion.php'
];

// Définit le lien de redirection pour le bouton Mode Édition
$adminPageLink = $adminPages[$currentPage] ?? 'index.php'; // Par défaut, redirige vers admin.php
?>

<?php

$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

 // Détermine la page actuelle
 $currentPage = basename($_SERVER['REQUEST_URI']);

 // Associe chaque page à son équivalent admin
$adminPages = [
    'index.php' => 'accueilAdmin.php',
    'evenement.php' => 'evenementAdmin.php',
    'boutique.php' => 'boutiqueAdmin.php',
    'contact.php' => 'contactAdmin.php',
    'connexion.php' => 'adminConnexion.php'
];

// Définit le lien de redirection pour le bouton Mode Édition
$adminPageLink = $adminPages[$currentPage] ?? 'accueilAdmin.php'; // Par défaut, redirige vers admin.php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <!-- Ajouter Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php
    // Détermine la page actuelle
    $currentPage = basename($_SERVER['REQUEST_URI']);
    ?>

    <header>
        <!-- Titre de la page actuelle -->
        <div class="page-title">
            <h1 id="current-page-title">
                <?= $currentPage === '' || $currentPage === 'index.php' ? 'Accueil' : ucfirst(pathinfo($currentPage, PATHINFO_FILENAME)) ?>
            </h1>
        </div>

        <!-- Bouton pour ouvrir le menu mobile -->
        <button id="menu-toggle" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Menu déroulant mobile -->
        <nav id="mobile-menu" class="mobile-menu">
            <ul>
                <li><a href="/" class="<?= $currentPage === '' || $currentPage === 'index.php' ? 'active' : '' ?>">Accueil</a></li>
                <li><a href="/evenement.php" class="<?= $currentPage === 'evenement.php' ? 'active' : '' ?>">Événements</a></li>
                <li><a href="/boutique.php" class="<?= $currentPage === 'boutique.php' ? 'active' : '' ?>">Boutique</a></li>
                <li><a href="/contact.php" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact</a></li>
                <li><a href="/connexion.php" class="<?= $currentPage === 'connexion.php' ? 'active' : '' ?>">Se connecter</a></li>
            </ul>
        </nav>

        <!-- Menu PC -->
        <nav class="main-nav">
            <div class="nav-brand">
                
                <?php if ($isAdmin): ?>
                    <button onclick="window.location.href='<?= htmlspecialchars($adminPageLink) ?>'" class="mode-edition-btn">Mode Édition</button>
                <?php endif; ?>

                <a href="/">
                    <img src="/assets/images/logo.png" alt="Logo BDE" class="logo">
                    <span>BDE Info</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="/" class="<?= $currentPage === '' || $currentPage === 'index.php' ? 'active' : '' ?>">Accueil</a>
                <a href="/evenement.php" class="<?= $currentPage === 'evenement.php' ? 'active' : '' ?>">Événements</a>
                <a href="/boutique.php" class="<?= $currentPage === 'boutique.php' ? 'active' : '' ?>">Boutique</a>
                <a href="/contact.php" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact</a>
            </div>
            <div class="nav-actions">
                <?php if (AuthMiddleware::isAuthenticated()): ?>
                    <div class="user-menu">
                        <span>Bonjour, <?= htmlspecialchars($_SESSION['user_prenom']) ?></span>
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#compteModal">
                            Mon compte
                        </button>
                        <a href="/deconnexion.php" class="btn btn-danger">Déconnexion</a>
                    </div>
                <?php else: ?>
                    <button id="loginBtn" class="btn-login">
                        <i class="fas fa-user"></i>
                        <a href="/connexion.php">Se connecter</a>
                    </button>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Inclure la modal de compte si l'utilisateur est connecté -->
    <?php if (AuthMiddleware::isAuthenticated()): ?>
        <?php require_once 'app/views/components/modal-compte.php'; ?>
    <?php endif; ?>

    <!-- Ajouter Bootstrap JS et Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
