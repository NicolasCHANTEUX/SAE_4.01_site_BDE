<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/accueil.css"> <!-- Ajout du CSS spécifique à l'accueil -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="/assets/js/main.js" defer></script>
</head>
<body>
    <header>
        <nav class="new-nav">
            <a href="#accueil" class="active">Accueil</a>
            <a href="#evenements">Événements</a>
            <a href="#boutique">Boutique</a>
            <a href="#contact">Contact</a>
            <a href="#compte">Compte</a>
        </nav>
    </header>

    <main id="app">
        <!-- Autres sections -->
        <section id="presentation">
            <h2>Bienvenue sur le site du BDE</h2>
            <p>Découvrez nos événements, nos produits et bien plus encore !</p>
        </section>


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

    <!-- Boutons de navigation -->
    <div class="carousel-controls">
        <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
        <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
    </div>
</section>

        
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Le site du BDE. Tous droits réservés.</p>
    </footer>

    <!-- Script JS -->
    <script src="/assets/js/accueil.js"></script> <!-- Ajout du fichier JS pour le carousel -->
</body>
</html>
