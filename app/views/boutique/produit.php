<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom'] ?? 'Produit non disponible') ?> - BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/produit.css">
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
                <a href="#evenements">Événements</a>
                <a href="/boutique.php" class="active">Boutique</a>
                <a href="/contact.php">Contact</a>
                <a href="#compte">Compte</a>
            </div>
            <div class="nav-actions">
                <button id="loginBtn" class="btn-login">
                    <i class="fas fa-user"></i>
                    <a href="/connexion.php">Se connecter</a>
                </button>
            </div>
        </nav>
    </header>

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
                        <button class="btn-primary btn-order">Commander</button>
                        <button class="btn-secondary btn-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés</p>
        </div>
    </footer>
    <script src="/assets/js/produit.js"></script>
</body>
</html>
