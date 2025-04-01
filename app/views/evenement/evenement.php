<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/evenement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="/assets/js/evenement.js" defer></script>
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
                <a href="/evenement.php" class="active">Événements</a>
                <a href="/boutique.php">Boutique</a>
                <a href="/contact.php">Contact</a>
                <a href="/connexion.php">Se Connecter</a>
            </div>
            <div></div>
        </nav>
</header>
    <main id="app">

    <div class="container">
        <div id="evenement-app" class="evenement-container">
            <h2>Les événements du BDE</h2>
            <?php foreach ($evenements as $evenement): ?>
                <div class="evenement-card">
                    <?php if ($evenement['chemin_image']): ?>
                        <div class="evenement-image">
                            <img src="/<?= $evenement['chemin_image'] ?>" 
                                 alt="<?= htmlspecialchars($evenement['titre']) ?>"
                                 loading="lazy"
                                 onerror="this.src='/assets/images/product-default.jpg'">
                        </div>
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($evenement['titre']) ?></h3>
                    <p><?= htmlspecialchars($evenement['description']) ?></p>
                    <div class="evenement-details">
                        <span class="date">Date: <?= date('d/m/Y H:i', strtotime($evenement['date_evenement'])) ?></span>
                        <span class="prix">Prix: <?= number_format($evenement['prix'], 2) ?> €</span>
                        <span class="places">Places: <?= $evenement['nb_inscrits'] ?>/<?= $evenement['max_participants'] ?: '∞' ?></span>
                    </div>
                    <button class="btn-participer" data-id="<?= $evenement['id'] ?>">Participer</button>
                </div>
            <?php endforeach; ?>
        </div>
	</div>

<footer>
	<div class="footer-bottom">
		<p>&copy;
			<?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés
		</p>
	</div>
</footer>

</body>

</html>