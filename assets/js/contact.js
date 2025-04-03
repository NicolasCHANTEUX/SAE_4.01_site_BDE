document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const messageResult = document.getElementById('messageResult');
    
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            const data = {
                nom: formData.get('nom')?.trim(),
                prenom: formData.get('prenom')?.trim(),
                email: formData.get('email')?.trim(),
                demande: formData.get('demande')?.trim()
            };
            
            // Validation côté client
            for (const [key, value] of Object.entries(data)) {
                if (!value) {
                    messageResult.innerHTML = `
                        <div class="alert alert-danger">
                            Tous les champs sont obligatoires
                        </div>
                    `;
                    return;
                }
            }

            try {
                const response = await fetch('/contact/envoyer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                
                messageResult.innerHTML = `
                    <div class="alert alert-${result.success ? 'success' : 'danger'}">
                        ${result.message}
                    </div>
                `;

                if (result.success) {
                    contactForm.reset();
                }
            } catch (error) {
                console.error('Erreur:', error);
                messageResult.innerHTML = `
                    <div class="alert alert-danger">
                        Une erreur est survenue lors de l'envoi du message
                    </div>
                `;
            }
        });
    }
});
