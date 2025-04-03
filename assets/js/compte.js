document.getElementById('passwordForm').addEventListener('submit', async function (e) {
	e.preventDefault();

	try {
		const formData = new FormData(this);
		const response = await fetch('/compte/updatePassword', {
			method: 'POST',
			body: formData
		});

		const result = await response.json();

		if (result.success) {
			// Fermer le modal
			bootstrap.Modal.getInstance(document.getElementById('passwordModal')).hide();
			// Afficher un message de succès
			alert(result.message);
		} else {
			alert(result.message);
		}
	} catch (error) {
		alert('Une erreur est survenue');
	}
});

document.getElementById('deleteAccountForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
        return;
    }

    try {
        const formData = new FormData(this);
        const response = await fetch('/compte/deleteAccount', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            if (result.redirect) {
                window.location.href = result.redirect;
            }
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Une erreur est survenue');
    }
});

// Gestion de l'accordéon pour l'historique des commandes
document.querySelectorAll('#historique .commande-header').forEach(header => {
    header.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const isActive = content.classList.contains('active');
        
        // Fermer tous les autres contenus actifs
        document.querySelectorAll('#historique .commande-content.active').forEach(item => {
            if (item !== content) {
                item.classList.remove('active');
            }
        });
        
        // Basculer l'état du contenu cliqué
        content.classList.toggle('active');
    });
});