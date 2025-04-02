document.addEventListener('DOMContentLoaded', function() {
    const quantityButtons = document.querySelectorAll('.quantity-btn');

    quantityButtons.forEach(button => {
        button.addEventListener('click', function() {
            const index = this.dataset.index;
            const isPlus = this.classList.contains('plus');
            const quantityElement = this.parentElement.querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (isPlus) {
                quantity++;
            } else {
                quantity = Math.max(0, quantity - 1);
            }

            fetch('/panier/modifierQuantite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    index: index,
                    quantite: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (quantity === 0) {
                        const cartItem = button.closest('.cart-item');
                        cartItem.remove();
                    } else {
                        quantityElement.textContent = quantity;
                    }
                }
            });
        });
    });
});