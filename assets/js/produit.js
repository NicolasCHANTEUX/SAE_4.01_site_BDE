document.addEventListener('DOMContentLoaded', function() {
    // Gestion des boutons de taille
    const sizeButtons = document.querySelectorAll('.size-btn');
    sizeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active des autres boutons
            sizeButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            // Mettre à jour l'input hidden
            document.querySelector('#taille_selected').value = this.dataset.size;
        });
    });

    // Gestion des boutons de couleur
    const colorButtons = document.querySelectorAll('.color-btn');
    colorButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active des autres boutons
            colorButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            // Mettre à jour l'input hidden
            document.querySelector('#couleur_selected').value = this.dataset.color;
        });
    });

    const btnCart = document.querySelector('.btn-cart');
    if (btnCart) {
        btnCart.addEventListener('click', async function() {
            const produitId = document.querySelector('input[name="produit_id"]').value;
            const taille = document.querySelector('#taille_selected').value;
            const couleur = document.querySelector('#couleur_selected').value;
            
            if (!taille || !couleur) {
                showNotification('Attention', 'Veuillez sélectionner une taille et une couleur', 'warning');
                return;
            }

            try {
                const productData = {
                    produitId: produitId,
                    quantite: 1,
                    taille: taille,
                    couleur: couleur,
                    nom: document.querySelector('.product-info h1').textContent.trim(),
                    prix: parseFloat(document.querySelector('.product-price').textContent.replace('€', '').replace(',', '.').trim()),
                    image: document.querySelector('.product-image img').getAttribute('src')
                };

                const response = await fetch('/panier.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(productData)
                });

                const result = await response.json();
                if (result.success) {
                    showNotification(
                        'Parfait !',
                        'Le produit a été ajouté à votre panier',
                        'success'
                    );
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                showNotification(
                    'Erreur',
                    error.message || 'Une erreur est survenue',
                    'error'
                );
            }
        });
    }
});

function showNotification(title, message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} notification-icon"></i>
        <div class="notification-content">
            <p class="notification-title">${title}</p>
            <p class="notification-message">${message}</p>
        </div>
        <button class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;

    document.body.appendChild(notification);
    
    // Force un reflow pour déclencher l'animation
    notification.offsetHeight;
    
    // Afficher la notification
    setTimeout(() => notification.classList.add('show'), 10);

    // Gestionnaire pour le bouton de fermeture
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    });

    // Auto-fermeture après 3 secondes
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}