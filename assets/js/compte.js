document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des modals
    const compteModalEl = document.getElementById('compteModal');
    const passwordModalEl = document.getElementById('passwordModal');
    const deleteModalEl = document.getElementById('deleteAccountModal');

    if (typeof bootstrap !== 'undefined') {
        const compteModal = new bootstrap.Modal(compteModalEl);
        const passwordModal = new bootstrap.Modal(passwordModalEl);
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        // Gestionnaire pour le bouton "Mon compte"
        document.querySelector('[data-bs-target="#compteModal"]')?.addEventListener('click', function() {
            compteModal.show();
        });

        // Gestionnaires pour les transitions entre modals
        document.querySelector('[data-bs-target="#passwordModal"]')?.addEventListener('click', function() {
            compteModal.hide();
            setTimeout(() => passwordModal.show(), 150);
        });

        document.querySelector('[data-bs-target="#deleteAccountModal"]')?.addEventListener('click', function() {
            compteModal.hide();
            setTimeout(() => deleteModal.show(), 150);
        });
    }

    // Gestion du formulaire de modification de mot de passe
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', async function (e) {
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
    }

    // Gestion du formulaire de suppression de compte
    const deleteForm = document.getElementById('deleteAccountForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', async function (e) {
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
    }
});