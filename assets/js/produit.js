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

    // Gestion du bouton panier
    cartButton?.addEventListener('click', () => {
        const selectedSize = document.querySelector('.size-btn.selected')?.dataset.size;
        const selectedColor = document.querySelector('.color-btn.selected')?.dataset.color;

        if (!selectedSize || !selectedColor) {
            alert('Veuillez sélectionner une taille et une couleur');
            return;
        }

        // Ajouter ici la logique d'ajout au panier
    });
});
