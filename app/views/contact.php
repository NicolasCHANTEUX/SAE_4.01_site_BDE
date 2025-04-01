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
                <a href="/">Accueil</a>
                <a href="/evenement.php">Événements</a>
                <a href="/boutique.php">Boutique</a>
                <a href="/contact.php" class="active">Contact</a>
                <a href="/connexion.php">Se Connecter</a>
            </div>
			<div></div>
        </nav>
    </header>
    <main id="app">

        <div class="container">
            <h1>Contactez-nous</h1>
            
            <form id="contactForm" method="POST" action="/contact" class="contact-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="demande">Votre message</label>
                    <textarea class="form-control" id="demande" name="demande" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>

            <section class="social-section">
                <h2>Rejoignez-nous</h2>
                <div class="social-grid">
                    <div class="social-card">
                        <i class="fas fa-envelope social-icon"></i>
                        <h3>Email</h3>
                        <a href="mailto:<?= htmlspecialchars($socialLinks['email']) ?>" class="social-link">
                            <?= htmlspecialchars($socialLinks['email']) ?>
                        </a>
                    </div>
                    
                    <div class="social-card">
                        <i class="fab fa-discord social-icon"></i>
                        <h3>Discord</h3>
                        <a href="<?= htmlspecialchars($socialLinks['discord']) ?>" target="_blank" class="social-link btn-discord">
                            Rejoindre le serveur
                        </a>
                    </div>
                    
                    <div class="social-card">
                        <i class="fab fa-instagram social-icon"></i>
                        <h3>Instagram</h3>
                        <a href="<?= htmlspecialchars($socialLinks['instagram']) ?>" target="_blank" class="social-link btn-instagram">
                            Nous suivre
                        </a>
                    </div>
                </div>
            </section>
        </div>

    </main>
    <footer>
        <div class="footer-bottom">
            <p>&copy;
                <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés
            </p>
        </div>
    </footer>
    <script src="/assets/js/contact.js"></script>
</body>

</html>