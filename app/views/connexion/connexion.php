<?php
require_once 'app/views/template/header.php';
?>
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
        <p>Vous n'avez pas de compte ? <a href="creerCompte.php">Créer mon compte</a></p>
    </div>
</body>

<footer>
    <div class="footer-bottom">
        <p>&copy;
            <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés
        </p>
    </div>
</footer>

<script src="/assets/js/connexion.js"></script>
</body>

</html>