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
        <!-- Titre de la page actuelle -->
        <div class="page-title">
            <h1 id="current-page-title">Accueil</h1>
        </div>

        <!-- Bouton pour ouvrir le menu mobile -->
        <button id="menu-toggle" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Menu déroulant mobile -->
        <nav id="mobile-menu" class="mobile-menu">
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/evenement.php">Événements</a></li>
                <li><a href="/boutique.php">Boutique</a></li>
                <li><a href="/contact.php">Contact</a></li>
                <li><a href="/connexion.php">Se connecter</a></li>
            </ul>
        </nav>

        <!-- Menu PC -->
        <nav class="main-nav">
            <div class="nav-brand">
                <a href="/">
                    <img src="/assets/images/logo.png" alt="Logo BDE" class="logo">
                    <span>BDE Info</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="/" class="active">Accueil</a>
                <a href="/evenement.php">Événements</a>
                <a href="/boutique.php">Boutique</a>
                <a href="/contact.php">Contact</a>
            </div>
            <div class="nav-actions">
                <button id="loginBtn" class="btn-login">
                    <i class="fas fa-user"></i>
                    <a href="/connexion.php">Se connecter</a>
                </button>
            </div>
        </nav>
    </header>