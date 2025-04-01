<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/evenement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="/assets/js/evenement.js" defer></script>
</head>
<body>
<header>
        <nav class="main-nav">
            <div class="nav-brand">
                <a href="/">
                    <img src="/assets/images/logo.png" alt="Logo BDE" class="logo">
                    <span>BDE Info</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="/">Accueil</a>
                <a href="/evenement.php" class="active">Événements</a>
                <a href="/boutique.php">Boutique</a>
                <a href="/contact.php">Contact</a>
                <a href="#compte">Compte</a>
            </div>
            <div class="nav-actions">
                <button id="loginBtn" class="btn-login">
                    <i class="fas fa-user"></i>
                    <a href="/connexion.php">Se connecter</a>
                </button>
            </div>
        </nav>
</header>
    <main id="app">

    <div class="container">
        <div id="evenement-app" class="evenement-container">
            <h2>Les événements du BDE</h2>
            <!-- Le contenu sera chargé dynamiquement ici -->
        </div>
	</div>

<footer>
	<div class="footer-bottom">
		<p>&copy;
			<?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés
		</p>
	</div>
</footer>

</body>

</html>