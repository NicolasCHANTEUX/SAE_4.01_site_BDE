<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/panier.css">
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
                <a href="/">Accueil</a>
                <a href="/evenement.php">Événements</a>
                <a href="/boutique.php" class="active">Boutique</a>
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

    <main>
        <div class="container">
            <h1>Mon Panier</h1>
			<div class="cart-items">
				<div class="cart-item">
					<div class="item-image">
						<img src="/assets/images/product-default.jpg" alt="T-Shirt BDE">
					</div>
					<div class="item-details">
						<h3>T-Shirt BDE Info</h3>
						<div class="item-info">
							<span class="item-price">15.99 €</span>
							<div class="item-options">
								<span class="item-size">Taille: M</span>
								<span class="item-color">Couleur: Noir</span>
							</div>
						</div>
					</div>
					<div class="quantity-controls">
						<button class="quantity-btn minus">
							<i class="fas fa-minus"></i>
						</button>
						<span class="quantity">1</span>
						<button class="quantity-btn plus">
							<i class="fas fa-plus"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="order-section">
				<button class="order-btn">
					<i class="fas fa-shopping-cart"></i>
					Commander
				</button>
			</div>
        </div>
    </main>

    <footer>
		<div class="footer-bottom">
			<p>&copy; <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés</p>
		</div>
	</footer>
	<script src="/assets/js/panier.js"></script>
</body>
</html>
