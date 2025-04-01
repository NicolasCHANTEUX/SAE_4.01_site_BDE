<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <nav class="main-nav">
            <div class="nav-brand">
                <a href="#accueil">
                    <img src="/assets/images/logo.png" alt="Logo BDE" class="logo">
                    <span>BDE Info</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="#accueil">Accueil</a>
                <a href="#evenements">Événements</a>
                <a href="#boutique">Boutique</a>
                <a href="/contact.php">Contact</a>
            </div>
            <div class="nav-actions">
                <?php if (AuthMiddleware::isAuthenticated()): ?>
                    <div class="user-menu">
                        <span>Bonjour, <?= htmlspecialchars($_SESSION['user_prenom']) ?></span>
                        <a href="/compte.php" class="btn-account">Mon compte</a>
                        <a href="/deconnexion.php" class="btn-logout">Déconnexion</a>
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
    <main id="app">