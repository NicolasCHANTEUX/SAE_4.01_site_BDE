<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom'] ?? 'Produit non disponible') ?> - BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/questionsFrequentes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

    <div class="navigation-buttons">
        <a href="/contact.php" class="nav-btn back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>


	<main id="app">
    <div class="faq-container"></div>
        <script>
            // Conversion des données PHP en JSON pour JavaScript
            const FAQ_DATA = <?php echo json_encode($questionsFrequentes); ?>;
        </script>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés</p>
        </div>
    </footer>
    <script src="/assets/js/questionsfrequentes.js"></script>
</body>
</html>
