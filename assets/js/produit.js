document.addEventListener('DOMContentLoaded', () => {
    // Gestion des erreurs d'image
    const productImage = document.querySelector('.product-image img');
    if (productImage) {
        productImage.onerror = function() {
            this.src = '/assets/images/product-default.jpg';
        };
    }

    const sizeButtons = document.querySelectorAll('.size-btn');
    const colorButtons = document.querySelectorAll('.color-btn');
    const orderButton = document.querySelector('.btn-order');
    const cartButton = document.querySelector('.btn-cart');

    // Gestion de la sélection des tailles
    sizeButtons.forEach(button => {
        button.addEventListener('click', () => {
            sizeButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });

    // Gestion de la sélection des couleurs
    colorButtons.forEach(button => {
        button.addEventListener('click', () => {
            colorButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });

    // Gestion du bouton commander
    orderButton?.addEventListener('click', () => {
        const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
        const selectedColor = document.querySelector('.color-btn.selected')?.dataset.color;

        if (!selectedSize || !selectedColor) {
            alert('Veuillez sélectionner une taille et une couleur');
            return;
        }

        // Ajouter ici la logique de commande
    });

    cartButton?.addEventListener('click', async () => {
        const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
        const selectedColor = document.querySelector('.color-btn.selected')?.dataset.color;

        if (!selectedSize || !selectedColor) {
            alert('Veuillez sélectionner une taille et une couleur');
            return;
        }

        // Get product data from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');

        // Get product details from the page
        const productName = document.querySelector('.product-info h1').textContent;
        const productPrice = parseFloat(document.querySelector('.product-price').textContent.replace('€', '').trim());
        const productImage = document.querySelector('.product-image img').getAttribute('src');

        try {
            const response = await fetch('/panier.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    produitId: productId,
                    nom: productName,
                    prix: productPrice,
                    image: productImage.replace(/^\//, ''),
                    quantite: 1,
                    taille: selectedSize,
                    couleur: selectedColor
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            if (result.success) {
                alert('Produit ajouté au panier');
            } else {
                alert(result.message || 'Erreur lors de l\'ajout au panier');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors de l\'ajout au panier');
        }
    });
});