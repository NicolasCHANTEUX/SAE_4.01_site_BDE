<?php
require_once 'app/views/template/header.php';
?>
    <main id="app">
        
    <div class="signup-container">
        <h1>Créer un compte</h1>
        <form action="inscription.php" method="post">
            
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>
            
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
            
            <label for="confirm-password">Réécrire le mot de passe</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmez votre mot de passe" required>
            
            <button type="submit">Valider</button>
        </form>
        
        <p>Vous avez un compte ? <a href="connexion.php">Connectez-vous</a></p>
    </div>
</body>
<script src="/assets/js/connexion.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>