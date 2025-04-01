<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Boutique - BDE IUT Informatique</title>
	<link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/boutique.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <a href="/" class="active">Accueil</a>
                <a href="/evenement.php">Événements</a>
                <a href="/boutique.php">Boutique</a>
                <a href="/contact.php">Contact</a>
            </div>
            <div class="nav-actions">
                <button id="loginBtn" class="btn-login">
                    <i class="fas fa-user"></i>
					<a href="/connexion.php">Se connecter</a>
				</button>
			</div>
		</nav>
	</header>

	<main id="app">
			<div class="container">
				<div id="boutique-app" class="boutique-container">
					<h2>Notre boutique</h2>
					<!-- Le contenu sera chargé dynamiquement ici -->
				</div>

				<!-- Formulaire de commande (initialement caché) -->
				<div id="forms" style="display: none;">
					<form id="orderForm" class="order-form">
						<h3>Commander un produit</h3>
						<div class="form-group">
							<input type="hidden" name="produit" value="">
							<label for="quantite">Quantité</label>
							<input type="number" id="quantite" name="quantite" min="1" required>
						</div>
						<div class="form-group">
							<label for="taille">Taille (si applicable)</label>
							<select id="taille" name="taille">
								<option value="">Choisir une taille</option>
								<option value="S">S</option>
								<option value="M">M</option>
								<option value="L">L</option>
								<option value="XL">XL</option>
							</select>
						</div>
						<button type="submit" class="btn-primary">Commander</button>
						<button type="button" class="btn-secondary" onclick="closeOrderForm()">Annuler</button>
					</form>
				</div>
			</div>
	</main>

	<footer>
		<div class="footer-bottom">
			<p>&copy; <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés</p>
		</div>
	</footer>
	<script src="/assets/js/boutique.js"></script>
</body>
</html>