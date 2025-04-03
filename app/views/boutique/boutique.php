<?php
require_once 'app/views/template/header.php';
?>
	<link rel="stylesheet" href="/assets/css/boutique.css">
	<main id="app">
			<div class="container">
				<div id="boutique-app" class="boutique-container">
					<h2>Notre boutique</h2>
					<script>
						const BOUTIQUE_DATA = <?php echo json_encode($produits); ?>;
					</script>
					<!-- Le contenu sera chargé dynamiquement ici -->
				</div>

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
	<script src="/assets/js/boutique.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>