<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/connexion.css">
    <main id="app">
        
    <div class="signup-container">
        <h1>Créer un compte</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <form action="creerCompte.php" method="post">
            
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
            
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
            
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
</main>
<script src="/assets/js/connexion.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>