document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const messageResult = document.getElementById('messageResult');
    
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Récupérer les données du formulaire
            const formData = new FormData(contactForm);
            const data = {
                nom: formData.get('nom'),
                prenom: formData.get('prenom'),
                email: formData.get('email'),
                demande: formData.get('demande')  // Maintenant ça correspond au name="demande" du HTML
            };
            
            try {
                const formData = new FormData(contactForm);
                const response = await fetch('/contact/envoyer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    messageResult.innerHTML = `
                        <div class="alert alert-success">
                            ${result.message}
                        </div>
                    `;
                    contactForm.reset();
                } else {
                    messageResult.innerHTML = `
                        <div class="alert alert-danger">
                            ${result.message}
                        </div>
                    `;
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
