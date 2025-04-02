<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/connexion.css">
    <main id="app">

    <div class="login-container">
        <h1>Connectez-vous</h1>

		<?php if($error !== '') echo $error; ?>
        <form action="connexion.php" method="post">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>
            
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
            
            <button type="submit">Valider</button>
        </form>
        <p>Vous n'avez pas de compte ? <a href="creerCompte.php">Créer mon compte</a></p>
    </div>
</body>
<!--<script src="/assets/js/connexion.js"></script>-->
<?php require_once 'app/views/template/footer.php'; ?>