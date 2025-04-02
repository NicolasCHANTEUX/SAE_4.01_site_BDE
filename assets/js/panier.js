document.addEventListener('DOMContentLoaded', function() {
    const quantityButtons = document.querySelectorAll('.quantity-btn');

    quantityButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const index = this.dataset.index;
            const isPlus = this.classList.contains('plus');
            const quantityElement = this.parentElement.querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (isPlus) {
                quantity++;
            } else {
                quantity = Math.max(1, quantity - 1);
            }

            try {
                const response = await fetch('/panier/modifierQuantite', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        index: index,
                        quantite: quantity
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success) {
                    quantityElement.textContent = data.quantite;
                    const priceElement = button.closest('.cart-item').querySelector('.price');
                    priceElement.textContent = `${data.total.toFixed(2)} €`;
                    
                    // Update total if it exists
                    updateCartTotal();
                } else {
                    throw new Error(data.message || 'Erreur de modification de la quantité');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de la modification de la quantité');
            }
        });
    });

    // Helper function to update cart total
    function updateCartTotal() {
        const totalElement = document.querySelector('.cart-total');
        if (totalElement) {
            const prices = Array.from(document.querySelectorAll('.price'))
                .map(el => parseFloat(el.textContent))
                .reduce((a, b) => a + b, 0);
            totalElement.textContent = `Total: ${prices.toFixed(2)} €`;
        }
    }

	document.querySelectorAll('.delete-btn').forEach(button => {
		button.addEventListener('click', async function() {
			const index = this.dataset.index;
			try {
				const response = await fetch('/panier/supprimer', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ index: index })
				});
				
				const result = await response.json();
				if (result.success) {
					// Remove the item from the DOM
					const cartItem = this.closest('.cart-item');
					cartItem.remove();
					
					// If cart is empty, show empty message
					if (document.querySelectorAll('.cart-item').length === 0) {
						const cartItems = document.querySelector('.cart-items');
						cartItems.innerHTML = '<p class="empty-cart">Votre panier est vide</p>';
					}
				}
			} catch (error) {
				console.error('Erreur lors de la suppression:', error);
			}
		});
	});
});