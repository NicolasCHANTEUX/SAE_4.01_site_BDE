<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/panier.css">
<link rel="stylesheet" href="/assets/css/notifications.css">
<main>
	<div class="container">
		<h1>Mon Panier</h1>
		<div class="cart-items">
			<?php if (empty($_SESSION['panier'])): ?>
				<p class="empty-cart">Votre panier est vide</p>
			<?php else: ?>
				<?php foreach ($_SESSION['panier'] as $index => $item): ?>
					<div class="cart-item" data-index="<?= $index ?>">
						<div class="item-image">
							<img src="/<?= htmlspecialchars($item['image'] ?? 'assets/images/product-default.jpg') ?>" 
								alt="<?= htmlspecialchars($item['nom']) ?>"
								onerror="this.src='/assets/images/product-default.jpg'">
						</div>
						<div class="item-details">
							<h3><?= htmlspecialchars($item['nom']) ?></h3>
							<div class="item-info">
								<span class="item-price"><?= number_format($item['prix'], 2, ',', ' ') ?> €</span>
								<div class="item-options">
									<span class="item-size">Taille: <?= htmlspecialchars($item['taille']) ?></span>
									<span class="item-color">Couleur: <?= htmlspecialchars($item['couleur']) ?></span>
								</div>
							</div>
						</div>
						<div class="item-actions">
							<div class="quantity-control">
								<button class="quantity-btn minus" data-index="<?= $index ?>">-</button>
								<span class="quantity"><?= $item['quantite'] ?></span>
								<button class="quantity-btn plus" data-index="<?= $index ?>">+</button>
							</div>
							<div class="price" data-unit-price="<?= $item['prix'] ?>">
								<?= number_format($item['prix'] * $item['quantite'], 2) ?> €
							</div>
							<button class="delete-btn" data-index="<?= $index ?>">
								<i class="fas fa-trash"></i>
							</button>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php if (!empty($_SESSION['panier'])): ?>
			<div class="cart-footer">
				<div class="cart-total">
					Total: <?= number_format(array_sum(array_map(function($item) {
						return $item['prix'] * $item['quantite'];
					}, $_SESSION['panier'])), 2) ?> €
				</div>
				<div class="cart-actions">
				<a href="/boutique.php" class="btn-secondary">
					<i class="fas fa-arrow-left"></i>
					Continuer mes achats
				</a>
				<?php if (AuthMiddleware::isAuthenticated()): ?>
					<button class="btn-primary">
						<i class="fas fa-shopping-cart"></i>
						Commander
					</button>
				<?php else: ?>
					<a href="/connexion.php" class="btn-primary">
						<i class="fas fa-sign-in-alt"></i>
						Se connecter pour commander
					</a>
				<?php endif; ?>
			</div>
			</div>
		<?php endif; ?>
	</div>
</main>

<!-- Modal de confirmation -->
<div id="confirmationModal" class="modal">
	<div class="modal-content">
		<h2>Confirmation de commande</h2>
		<p>Êtes-vous sûr de vouloir passer cette commande ?</p>
		<div class="modal-actions">
			<button id="confirmOrder" class="btn-primary">Confirmer</button>
			<button id="cancelOrder" class="btn-secondary">Annuler</button>
		</div>
	</div>
</div>

<script src="/assets/js/panier.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>
