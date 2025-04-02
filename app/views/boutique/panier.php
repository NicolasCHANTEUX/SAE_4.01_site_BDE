<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/panier.css">
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
                            <div class="quantity-controls">
                                <button class="quantity-btn minus" data-index="<?= $index ?>">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity"><?= $item['quantite'] ?></span>
                                <button class="quantity-btn plus" data-index="<?= $index ?>">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
			<div class="order-section">
                <a href="/boutique.php" class="order-btn">
                    <i class="fas fa-shopping-cart"></i>
                    Continuer mes achats
                </a>
            </div>
            </div>
        </div>
    </main>
    <script src="/assets/js/panier.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>
