<?php
require_once 'app/views/template/header.php';
?>
	<link rel="stylesheet" href="/assets/css/boutique.css">

	<div class="navigation-buttons">
		<a href="/" class="nav-btn back-btn">
			<i class="fas fa-arrow-left"></i>
			<span>Accueil</span>
		</a>
		<a href="/panier.php" class="nav-btn cart-btn">
			<span>Panier</span>
			<i class="fas fa-shopping-cart"></i>
		</a>
	</div>

	<main id="app">
			<div class="container">
				<div id="boutique-app" class="boutique-container">
					<h2>Notre boutique</h2>
					<script>
						const BOUTIQUE_DATA = <?php echo json_encode($produits); ?>;
					</script>
					<!-- Le contenu sera chargé dynamiquement ici -->
				</div>
			</div>
	</main>
	<script src="/assets/js/boutique.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>