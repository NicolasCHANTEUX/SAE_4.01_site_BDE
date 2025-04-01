<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/accueil.css">
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
				<a href="/">Accueil</a>
				<a href="#evenements">Événements</a>
				<a href="/boutique.php" class="active">Boutique</a>
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
            <section id="presentation" class="hero-section">
                <h1>Bienvenue sur le site du BDE</h1>
                <p>Découvrez nos événements, nos produits et bien plus encore !</p>
            </section>

            <!-- Section des articles -->
            <section id="carousel" class="carousel-container">
                <div class="carousel">
                    <div class="carousel-item active">
                        <h3>Article 1</h3>
                        <p>Description de l'article central.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>Article 2</h3>
                        <p>Description de l'article à gauche.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>Article 3</h3>
                        <p>Description de l'article à droite.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>Article 4</h3>
                        <p>
                            Cet article contient plus de texte pour illustrer une présentation détaillée. 
                            Découvrez nos événements, nos produits, et bien plus encore ! Nous organisons 
                            régulièrement des activités pour les étudiants, comme des soirées cinéma, des 
                            conférences sur l'innovation, et des tournois sportifs. Rejoignez-nous pour 
                            vivre une expérience unique !
                        </p>
                    </div>
                    <div class="carousel-item">
                        <h3>Article 5</h3>
                        <p>Description d'un autre article.</p>
                    </div>
                </div>
                <div class="carousel-controls">
                    <button class="prev-btn" aria-label="Article précédent">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="next-btn" aria-label="Article suivant">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>

            <!-- Section Événements -->
            <section id="evenements" class="evenements-container">
            <h2>Événements à venir</h2>

            <!-- Grille des événements -->
            <div class="evenements-grid">
                <!-- Événement 1 -->
                <div class="evenement-item">
                    <img src="/assets/images/bowling.jpg" alt="Événement Bowling" />
                    <h3>Soirée Bowling</h3>
                    <p>Le 2 avril 2025 - 10 places disponibles</p>
                </div>

                <!-- Événement 2 -->
                <div class="evenement-item">
                    <img src="/assets/images/poker.jpg" alt="Événement Poker" />
                    <h3>Tournoi de Poker</h3>
                    <p>Le 5 avril 2025 - 6 places disponibles</p>
                </div>

                <!-- Voir plus d'événements -->
                <div class="voir-plus-item">
                    <span>+</span>
                    <p>Voir plus d'événements</p>
                </div>
            </div>
        </section>

        </div>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés</p>
        </div>
    </footer>
    <script src="/assets/js/accueil.js"></script>
</body>
</html>