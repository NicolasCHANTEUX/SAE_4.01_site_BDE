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
                <a href="#accueil">
                    <img src="/assets/images/logo.png" alt="Logo BDE" class="logo">
                    <span>BDE Info</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="#accueil">Accueil</a>
                <a href="#evenements">Événements</a>
                <a href="#boutique">Boutique</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="nav-actions">
                <button id="loginBtn" class="btn-login">
                    <i class="fas fa-user"></i>
                    Se connecter
                </button>
            </div>
        </nav>
    </header>
    <main id="app">

    <div class="login-container">
        <h1>Connectez-vous</h1>
        <form action="authentification.php" method="post">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>
            
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
            
            <button type="submit">Valider</button>
        </form>
        <a href="creerCompte.php">Créer mon compte</a>
    </div>
</body>

<footer>
    <div class="footer-bottom">
        <p>&copy;
            <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés
        </p>
    </div>
</footer>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/connexion.js"></script>
</body>

</html>