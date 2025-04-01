<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="/assets/js/main.js" defer></script>
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
    </header>
    <main id="app">




    <div class="events-container">
        <!-- Bowling -->
        <div class="event-card">
            <img src="bowling.jpg" alt="Bowling">
            <h3>Bowling</h3>
            <p>2 avril</p>
        </div>

        <!-- Poker -->
        <div class="event-card">
            <img src="poker.jpg" alt="Poker">
            <h3>Poker</h3>
            <p>5 avril</p>
        </div>

        <!-- Minigolf -->
        <div class="event-card">
            <img src="minigolf.jpg" alt="Minigolf">
            <h3>Minigolf</h3>
            <p>22 avril</p>
        </div>

        <!-- Karting -->
        <div class="event-card">
            <img src="karting.jpg" alt="Karting">
            <h3>Karting</h3>
            <p>24 avril</p>
        </div>

        <!-- Laser Game -->
        <div class="event-card">
            <img src="laser-game.jpg" alt="Laser Game">
            <h3>Laser Game</h3>
            <p>1 mai</p>
        </div>

    </div>

    <!-- Détails de l'événement sélectionné -->
    <article>
        <img src="bowling.jpg" alt="Bowling">
        <h2>Bowling</h2>
        <p><strong>Partie de 10 personnes</strong></p>
        <p><strong>Durée :</strong> 1H30</p>
        <p><strong>Date :</strong> 2 avril 2025</p>
        <p><strong>Adresse :</strong> 51 Rue Pierre Semard, 76600 Le Havre</p>
        <button>Je participe</button>
    </article>
</body>

<footer>
    <div class="footer-bottom">
        <p>&copy;
            <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés
        </p>
    </div>
</footer>

<script src="/assets/js/main.js"></script>
</body>

</html>