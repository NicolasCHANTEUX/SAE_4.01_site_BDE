<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/produit.css">

    <div class="navigation-buttons">
        <a href="/boutique.php" class="nav-btn back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
        <a href="/panier.php" class="nav-btn cart-btn">
            <span>Panier</span>
            <i class="fas fa-shopping-cart"></i>
        </a>
    </div>

    <main id="app">
        <div class="container">
            <div class="product-details">
                <div class="product-image">
                    <img src="/<?= htmlspecialchars($produit['image'] ?? 'assets/images/product-default.jpg') ?>" 
                        alt="<?= htmlspecialchars($produit['nom'] ?? 'Produit') ?>"
                        onerror="this.src='/assets/images/product-default.jpg'">
                </div>
                
                <div class="product-info">
                    <h1><?= htmlspecialchars($produit['nom'] ?? 'Produit non disponible') ?></h1>
                    <p class="product-description"><?= htmlspecialchars($produit['description'] ?? 'Description non disponible') ?></p>
                    <div class="product-price"><?= number_format($produit['prix'] ?? 0, 2, ',', ' ') ?> €</div>
                    
                    <div class="product-options">
                        <div class="size-selection">
                            <h3>Taille</h3>
                            <div class="size-buttons">
                                <button class="size-btn" data-size="XS">XS</button>
                                <button class="size-btn" data-size="S">S</button>
                                <button class="size-btn" data-size="M">M</button>
                                <button class="size-btn" data-size="L">L</button>
                                <button class="size-btn" data-size="XL">XL</button>
                            </div>
                        </div>

                        <div class="color-selection">
                            <h3>Couleur</h3>
                            <div class="color-circles">
                                <button class="color-btn" style="background-color: #000000;" data-color="noir"></button>
                                <button class="color-btn" style="background-color: #FFFFFF;" data-color="blanc"></button>
                                <button class="color-btn" style="background-color: #FF0000;" data-color="rouge"></button>
                                <button class="color-btn" style="background-color: #0000FF;" data-color="bleu"></button>
                            </div>
                        </div>
                    </div>

                    <div class="product-actions">
                        <form method="POST" action="/app/controllers/commander.php">
                            <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                            <input type="hidden" name="taille" id="taille_selected">
                            <input type="hidden" name="couleur" id="couleur_selected">
                            <button type="submit" class="btn-primary btn-order" name="commander">Commander</button>
                        </form>
                        <button class="btn-secondary btn-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/assets/js/produit.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>
