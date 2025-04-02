<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/panier.css">
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
	<script src="/assets/js/panier.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>
