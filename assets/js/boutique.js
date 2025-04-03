const API_URL = 'http://localhost:8000';
const DEFAULT_IMAGE = './assets/images/product-default.jpg';

// Fonction pour charger les produits
async function loadProducts() {
    try {
        // Simuler un délai de chargement
        await new Promise(resolve => setTimeout(resolve, 500));
        
        // Utiliser les données provenant de PHP
        if (typeof BOUTIQUE_DATA !== 'undefined') {
            displayProducts(BOUTIQUE_DATA);
        } else {
            throw new Error('Aucune donnée de produits disponible');
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        displayError("Impossible de charger les produits pour le moment.");
    }
}

function displayProducts(products) {
    const boutiqueApp = document.getElementById('boutique-app');
    
    if (!products || products.length === 0) {
        displayEmptyShop(boutiqueApp);
        return;
    }

    try {
        boutiqueApp.innerHTML = `
            <div class="products-grid">
                ${products.map(product => createProductCard(product)).join('')}
            </div>
        `;
    } catch (error) {
        console.error('Erreur lors de l\'affichage des produits:', error);
        displayError("Une erreur est survenue lors de l'affichage des produits.");
    }
}

function createProductCard(product) {
    const name = product.nom || 'Produit sans nom';
    const price = parseFloat(product.prix) || 0;
    const image = product.image || DEFAULT_IMAGE;
    const id = product.id || null;
    const description = product.description || '';

    return `
        <div class="product-card">
            <a href="/produit.php?id=${id}" class="product-link">
                <div class="product-image">
                    <img src="${image}" alt="${name}" 
                         onerror="this.onerror=null; this.src='${DEFAULT_IMAGE}';">
                </div>
                <h3 class="product-title">${name}</h3>
                <p class="product-description">${description}</p>
                <div class="product-footer">
                    <span class="product-price">${price.toFixed(2)}€</span>
                    <div class="btn btn-secondary">
                        <i class="fas fa-shopping-cart"></i>
                        Voir produit
                    </div>
                </div>
            </a>
        </div>
    `;
}

function displayEmptyShop(container) {
    container.innerHTML = `
        <div class="boutique-empty">
            <img src="./assets/images/calendrier-empty.jpg" alt="Boutique vide"
                 onerror="this.onerror=null; this.src='${DEFAULT_IMAGE}';">
            <p>Notre boutique est temporairement vide</p>
            <p class="subtitle">Revenez bientôt pour découvrir nos nouveaux produits !</p>
        </div>
    `;
}

function displayError(message) {
    const boutiqueApp = document.getElementById('boutique-app');
    boutiqueApp.innerHTML = `
        <div class="error-container">
            <i class="fas fa-exclamation-triangle"></i>
            <p>${message}</p>
            <button onclick="loadProducts()" class="btn-retry">
                Réessayer
            </button>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', loadProducts);
