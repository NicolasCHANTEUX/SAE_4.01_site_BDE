<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="presentation">
            <h2>Bienvenue sur le site du BDE</h2>
            <p>Découvrez nos événements, nos produits et bien plus encore !</p>
        </section>

        <section id="evenements">
            <h2>Événements à venir</h2>
            <!-- Exemple de contenu statique ou dynamique -->
            <ul>
                <li>Soirée cinéma - 15 avril 2025</li>
                <li>Tournoi de football - 20 avril 2025</li>
                <li>Conférence sur l'innovation - 25 avril 2025</li>
            </ul>
        </section>

        <section id="boutique">
            <h2>Boutique</h2>
            <!-- Exemple de contenu statique ou dynamique -->
            <div class="product">
                <h3>T-shirt BDE</h3>
                <p>Prix : 15 €</p>
            </div>
            <div class="product">
                <h3>Mug BDE</h3>
                <p>Prix : 10 €</p>
            </div>
        </section>

        <section id="faq">
            <h2>FAQ</h2>
            <!-- Exemple de contenu statique ou dynamique -->
            <div class="faq-item">
                <h3>Comment rejoindre le BDE ?</h3>
                <p>Pour rejoindre le BDE, contactez-nous via la page "Contact".</p>
            </div>
            <div class="faq-item">
                <h3>Quels sont les prochains événements ?</h3>
                <p>Consultez la section "Événements" pour découvrir ce qui est prévu.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Le site du BDE. Tous droits réservés.</p>
    </footer>

</body>
</html>
